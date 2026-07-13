<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Doctor;
use App\DoctorAvailableDays;
use App\DoctorAvailableSlot;
use App\DoctorAvailableTimes;
use App\Patient;
use App\User;
use App\Services\CalendlyService;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PublicAppointmentController extends Controller
{
    /**
     * Display the public appointment form.
     *
     * @return \Illuminate\View\View
     */
    public function showAppointmentForm(Request $request)
    {
        // Get doctor_id from URL if present
        $selectedDoctorId = $request->query('doctor_id');
        
        // Get all doctors for the dropdown
        $doctors = Doctor::whereHas('user', function ($query) {
            $query->where('is_deleted', 0);
        })->with(['user' => function ($query) {
            $query->where('is_deleted', 0);
        }, 'department'])->get();

        // Get selected doctor info if doctor_id is provided
        $selectedDoctor = null;
        if ($selectedDoctorId) {
            $selectedDoctor = Doctor::with(['user', 'department'])
                ->find($selectedDoctorId);
        }

        return view('public.appointments.create', compact('doctors', 'selectedDoctor', 'selectedDoctorId'));
    }

    /**
     * Get available days for a doctor
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDoctorAvailableDays(Request $request)
    {
        try {
            $doctorId = $request->input('doctor_id');
            
            if (!$doctorId) {
                return response()->json(['error' => 'ID del doctor no proporcionado.', 'days' => []], 400);
            }
            
            // Obtener días disponibles directamente de la base de datos
            $availableDays = DB::table('doctor_available_days')
                ->where('doctor_id', $doctorId)
                ->first();
                
            if (!$availableDays) {
                return response()->json(['error' => 'No hay días disponibles para este doctor.', 'days' => []], 200);
            }

            // Convertir a array de números de días (0=domingo, 1=lunes, etc.)
            $days = [];
            if ($availableDays->sun) $days[] = 0; // Sunday
            if ($availableDays->mon) $days[] = 1; // Monday
            if ($availableDays->tue) $days[] = 2; // Tuesday
            if ($availableDays->wen) $days[] = 3; // Wednesday (corregido de "wed" a "wen")
            if ($availableDays->thu) $days[] = 4; // Thursday
            if ($availableDays->fri) $days[] = 5; // Friday
            if ($availableDays->sat) $days[] = 6; // Saturday

            return response()->json(['days' => $days]);
            
        } catch (\Exception $e) {
            // Registrar el error para depuración
            Log::error('Error al cargar días disponibles: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            
            return response()->json([
                'error' => 'Error interno al cargar días disponibles.',
                'message' => $e->getMessage(),
                'days' => []
            ], 500);
        }
    }

    /**
     * Get available time slots for a doctor on a specific date
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDoctorAvailableSlots(Request $request)
    {
        try {
            // Añadir log para seguir cada paso
            Log::info("-------- BEGIN getDoctorAvailableSlots --------");
            Log::info("Parámetros recibidos", $request->all());
            
            $doctorId = $request->input('doctor_id');
            $date = $request->input('date');
            
            Log::info("Parámetros extraídos", ['doctor_id' => $doctorId, 'date' => $date]);
            
            if (!$doctorId || !$date) {
                Log::info("Faltan parámetros requeridos");
                return response()->json(['error' => 'Faltan parámetros requeridos.', 'slots' => []], 400);
            }
            
            // Validar el formato de fecha
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                Log::info("Formato de fecha inválido: $date");
                return response()->json(['error' => 'Formato de fecha inválido.', 'slots' => []], 400);
            }
            
            // Obtener el día de la semana (0 = domingo, 1 = lunes, etc.)
            $dayOfWeek = date('w', strtotime($date));
            Log::info("Día de la semana calculado", ['date' => $date, 'dayOfWeek' => $dayOfWeek]);
            
            // Mapeo de día de la semana a nombre de columna en tabla doctor_available_days
            $dayMapping = [
                0 => 'sun',
                1 => 'mon',
                2 => 'tue',
                3 => 'wen', // Está como "wen" en la BD, no "wed"
                4 => 'thu',
                5 => 'fri',
                6 => 'sat',
            ];
            
            $day = $dayMapping[$dayOfWeek];
            Log::info("Nombre de la columna para el día", ['day' => $day]);
            
            // Verificar si el doctor está disponible en ese día
            Log::info("Verificando disponibilidad del doctor en ese día");
            try {
                $isAvailable = DB::table('doctor_available_days')
                    ->where('doctor_id', $doctorId)
                    ->where($day, 1)
                    ->exists();
                    
                Log::info("Resultado de la consulta de disponibilidad", ['isAvailable' => $isAvailable]);
                    
                if (!$isAvailable) {
                    Log::info("El doctor no atiende este día");
                    return response()->json(['error' => 'El doctor no atiende este día.', 'slots' => []], 200);
                }
            } catch (\Exception $e) {
                Log::error("Error al verificar disponibilidad: " . $e->getMessage());
                return response()->json([
                    'error' => 'Error al verificar disponibilidad del doctor.',
                    'slots' => []
                ], 500);
            }
            
            // Como el campo day_of_week es VARCHAR en la BD y almacena '1', '2', etc.
            $dayOfWeekString = (string)$dayOfWeek;
            Log::info("Formato de día para consulta", ['dayOfWeekString' => $dayOfWeekString]);
            
            // Obtener horarios disponibles para ese día
            Log::info("Consultando horarios disponibles");
            try {
                $availableTimes = DB::table('doctor_available_times')
                    ->where('doctor_id', $doctorId)
                    ->where('day_of_week', $dayOfWeekString)
                    ->where('is_deleted', 0)
                    ->get();
                
                Log::info("Resultado de la consulta de horarios", ['count' => $availableTimes->count()]);
                
                if ($availableTimes->isEmpty()) {
                    Log::info("No hay horarios configurados para este día");
                    return response()->json(['error' => 'No hay horarios configurados para este día.', 'slots' => []], 200);
                }
            } catch (\Exception $e) {
                Log::error("Error al consultar horarios: " . $e->getMessage());
                return response()->json([
                    'error' => 'Error al consultar horarios disponibles.',
                    'slots' => []
                ], 500);
            }
            
            // Comprobar qué citas ya están reservadas para este día
            Log::info("Consultando citas ya reservadas");
            try {
                // Revisar si la clase Appointment existe, de lo contrario usar consulta directa
                if (class_exists('App\Appointment')) {
                    $bookedAppointments = \App\Appointment::where('appointment_with', $doctorId)
                        ->where('appointment_date', $date)
                        ->get(['appointment_time']);
                } else if (class_exists('App\Models\Appointment')) {
                    $bookedAppointments = \App\Models\Appointment::where('appointment_with', $doctorId)
                        ->where('appointment_date', $date)
                        ->get(['appointment_time']);
                } else {
                    // Usar consulta directa si no se encuentra el modelo
                    $bookedAppointments = DB::table('appointments')
                        ->where('appointment_with', $doctorId)
                        ->where('appointment_date', $date)
                        ->get(['appointment_time']);
                }
                
                $bookedTimes = $bookedAppointments->pluck('appointment_time')->toArray();
                Log::info("Citas ya reservadas", ['count' => count($bookedTimes)]);
            } catch (\Exception $e) {
                Log::error("Error al consultar citas reservadas: " . $e->getMessage());
                // No interrumpir el flujo, asumir que no hay citas reservadas
                $bookedTimes = [];
            }
            
            // Generar slots disponibles
            Log::info("Generando slots disponibles");
            $availableSlots = [];
            
            foreach ($availableTimes as $time) {
                try {
                    $startTime = strtotime($time->from);
                    $endTime = strtotime($time->to);
                    
                    Log::info("Procesando horario", [
                        'id' => $time->id,
                        'from' => $time->from,
                        'to' => $time->to,
                        'startTime' => $startTime,
                        'endTime' => $endTime
                    ]);
                    
                    // Crear intervalos de 30 minutos
                    $timeSlot = $startTime;
                    while ($timeSlot < $endTime) {
                        $formattedTime = date('H:i', $timeSlot);
                        
                        // Comprobar si ya está reservada
                        if (!in_array($formattedTime, $bookedTimes)) {
                            $availableSlots[] = [
                                'id' => $time->id,
                                'time' => $formattedTime,
                                'display_time' => date('h:i A', $timeSlot)
                            ];
                        }
                        
                        // Incrementar 30 minutos
                        $timeSlot = strtotime('+30 minutes', $timeSlot);
                    }
                } catch (\Exception $e) {
                    Log::error("Error al procesar horario: " . $e->getMessage());
                    // Continuar con el siguiente horario
                }
            }
            
            Log::info("Total de slots generados: " . count($availableSlots));
            
            if (empty($availableSlots)) {
                Log::info("No hay slots disponibles para este doctor en la fecha seleccionada");
                return response()->json([
                    'error' => 'No hay slots disponibles para este doctor en la fecha seleccionada.',
                    'slots' => []
                ], 200);
            }
            
            Log::info("-------- END getDoctorAvailableSlots (SUCCESS) --------");
            return response()->json(['slots' => $availableSlots]);
            
        } catch (\Exception $e) {
            // Registrar el error para depuración
            Log::error("-------- ERROR getDoctorAvailableSlots --------");
            Log::error('Error completo: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            Log::error("-------- END ERROR getDoctorAvailableSlots --------");
            
            return response()->json([
                'error' => 'Error interno al cargar horarios disponibles.',
                'message' => $e->getMessage(),
                'slots' => []
            ], 500);
        }
    }

    /**
     * Store a new appointment
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'age' => 'required|integer|min:1|max:120',
            'gender' => 'required|string|in:Male,Female,Other',
            'address' => 'required|string|max:500',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        // Validación adicional dependiendo del modo de calendario
        if ($request->calendar_mode === 'standard') {
            $validator->addRules([
                'date' => 'required|date|date_format:Y-m-d|after_or_equal:today',
                'time' => 'required',
                'slot_id' => 'required|exists:doctor_available_slots,id',
            ]);
        } elseif ($request->calendar_mode === 'calendly') {
            $validator->addRules([
                'calendly_event_uri' => 'required|string',
                'calendly_invitee_uri' => 'required|string',
            ]);
        }
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Por favor corrige los errores en el formulario'
            ]);
        }

        try {
            // Iniciar una transacción de base de datos para asegurar consistencia
            DB::beginTransaction();
            
            // Dividir el nombre completo en nombre y apellido
            $nameParts = explode(' ', $request->name, 2);
            $firstName = $nameParts[0];
            $lastName = count($nameParts) > 1 ? $nameParts[1] : '';
            
            // Verificar si el usuario ya existe por email
            $existingUser = User::where('email', $request->email)->first();
            
            if ($existingUser) {
                // Actualizar usuario existente
                $user = $existingUser;
                $user->first_name = $firstName;
                $user->last_name = $lastName;
                $user->mobile = $request->phone;
                $user->save();
            } else {
                // Crear nuevo usuario con rol de paciente (ID 4)
                $user = new User();
                $user->first_name = $firstName;
                $user->last_name = $lastName;
                $user->email = $request->email;
                $user->mobile = $request->phone;
                $user->password = Hash::make(Str::random(10)); // Contraseña aleatoria
                $user->role_id = 4; // Rol de paciente
                $user->save();
            }
            
            // Verificar si el paciente ya existe
            $existingPatient = Patient::where('user_id', $user->id)->first();
            
            if ($existingPatient) {
                // Actualizar paciente existente
                $patient = $existingPatient;
                $patient->age = $request->age;
                $patient->gender = $request->gender;
                $patient->address = $request->address;
                $patient->save();
            } else {
                // Crear nuevo paciente
                $patient = new Patient();
                $patient->user_id = $user->id;
                $patient->age = $request->age;
                $patient->gender = $request->gender;
                $patient->address = $request->address;
                $patient->save();
            }
            
            // Crear cita
            $appointment = new Appointment();
            $appointment->appointment_for = $user->id; // ID del paciente
            $appointment->appointment_with = $request->doctor_id; // ID del doctor
            $appointment->booked_by = $user->id; // La cita es reservada por el mismo paciente
            
            if ($request->calendar_mode === 'standard') {
                // Modo de calendario estándar
                $appointment->appointment_date = $request->date;
                
                // available_time debe ser el ID del tiempo disponible, no la hora en formato texto
                // Obtener el ID del tiempo disponible según el slot seleccionado
                try {
                    // Obtener el tiempo disponible relacionado con el slot seleccionado
                    $slotInfo = DB::table('doctor_available_slots')
                        ->where('id', $request->slot_id)
                        ->first();
                        
                    if ($slotInfo) {
                        // El available_time debe ser el doctor_available_time_id asociado con el slot
                        $appointment->available_time = $slotInfo->doctor_available_time_id;
                    } else {
                        // Si no hay información, usar un valor por defecto para evitar errores
                        $appointment->available_time = $request->slot_id; // Como fallback
                        Log::warning("No se encontró información del slot {$request->slot_id}, usando ID como fallback");
                    }
                } catch (\Exception $e) {
                    Log::error("Error al obtener información del slot: " . $e->getMessage());
                    // Usar slot_id como fallback para evitar errores
                    $appointment->available_time = $request->slot_id;
                }
                
                $appointment->available_slot = $request->slot_id;
            } else {
                // Modo Calendly - Extraer fecha y hora del evento de Calendly
                // Aquí utilizamos la información del evento de Calendly
                $appointment->appointment_date = date('Y-m-d'); // Fecha actual como fallback
                $appointment->available_time = date('H:i:s'); // Hora actual como fallback
                $appointment->available_slot = 0; // No hay slot específico
                $appointment->calendly_event_uri = $request->calendly_event_uri;
                $appointment->calendly_invitee_uri = $request->calendly_invitee_uri;
            }
            
            $appointment->status = 0; // Pendiente
            $appointment->save();
            
            // Sincronizar con Calendly si está configurado
            if (env('USE_CALENDLY', false) && $request->calendar_mode === 'standard') {
                try {
                    $calendlyService = new CalendlyService();
                    $calendlyService->syncAppointmentToCalendly($appointment, $patient);
                } catch (\Exception $e) {
                    // Registrar error pero continuar con la creación de la cita
                    Log::error('Error al sincronizar con Calendly: ' . $e->getMessage());
                }
            }
            
            // Confirmar transacción
            DB::commit();
            
            // Enviar correo de confirmación (implementación futura)
            // Mail::to($user->email)->send(new AppointmentConfirmation($appointment));
            
            return response()->json([
                'success' => true,
                'message' => '¡Cita agendada correctamente!',
                'redirect' => route('public.appointment.success')
            ]);
            
        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            DB::rollBack();
            
            Log::error('Error al crear cita: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al agendar la cita: ' . $e->getMessage(),
                'error_details' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]
            ]);
        }
    }

    /**
     * Display success page after appointment booking
     *
     * @return \Illuminate\View\View
     */
    public function success()
    {
        return view('public.appointments.success');
    }

    /**
     * Insert test data for appointments and doctor availability
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function insertTestData()
    {
        try {
            DB::beginTransaction();

            // 1. Usar doctores existentes
            $doctors = Doctor::all();
            
            if ($doctors->isEmpty()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'No hay doctores en el sistema. Por favor, crea doctores primero.'
                ]);
            }
            
            // 2. Configurar disponibilidad para cada doctor
            foreach ($doctors as $index => $doctor) {
                // Eliminar configuraciones antiguas si existen
                DB::table('doctor_available_days')->where('doctor_id', $doctor->id)->delete();
                DB::table('doctor_available_times')->where('doctor_id', $doctor->id)->delete();
                DB::table('doctor_available_slots')->where('doctor_id', $doctor->id)->delete();
                
                // Crear configuración de días disponibles según el doctor
                // Nota: "wen" es la columna para miércoles (debería ser "wed" pero está así en la BD)
                if ($index % 3 == 0) {
                    // Lunes, Miércoles, Viernes
                    DB::table('doctor_available_days')->insert([
                        'doctor_id' => $doctor->id,
                        'sun' => 0,
                        'mon' => 1,
                        'tue' => 0,
                        'wen' => 1, // Nota: está mal escrito en la BD
                        'thu' => 0,
                        'fri' => 1,
                        'sat' => 0,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    
                    // Crear horarios para estos días
                    $this->createTimesForDoctor($doctor->id, [1, 3, 5], '09:00', '13:00', '14:00', '18:00');
                    
                } else if ($index % 3 == 1) {
                    // Martes, Jueves, Sábado
                    DB::table('doctor_available_days')->insert([
                        'doctor_id' => $doctor->id,
                        'sun' => 0,
                        'mon' => 0,
                        'tue' => 1,
                        'wen' => 0, // Nota: está mal escrito en la BD
                        'thu' => 1,
                        'fri' => 0,
                        'sat' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    
                    // Crear horarios para estos días
                    $this->createTimesForDoctor($doctor->id, [2, 4], '08:00', '12:00', '15:00', '19:00');
                    $this->createTimesForDoctor($doctor->id, [6], '08:00', '12:00'); // Solo mañanas los sábados
                    
                } else {
                    // Lunes a Viernes
                    DB::table('doctor_available_days')->insert([
                        'doctor_id' => $doctor->id,
                        'sun' => 0,
                        'mon' => 1,
                        'tue' => 1,
                        'wen' => 1, // Nota: está mal escrito en la BD
                        'thu' => 1,
                        'fri' => 1,
                        'sat' => 0,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    
                    // Crear horarios para estos días
                    $this->createTimesForDoctor($doctor->id, [1, 2, 3, 4, 5], '10:00', '14:00', '16:00', '20:00');
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true, 
                'message' => 'Datos de prueba creados correctamente. Se han configurado ' . $doctors->count() . ' doctores con sus horarios disponibles.'
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false, 
                'message' => 'Error al crear datos de prueba: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    
    /**
     * Helper method to create times and slots for doctors
     *
     * @param int $doctorId
     * @param array $days
     * @param string $morningStart
     * @param string $morningEnd
     * @param string|null $afternoonStart
     * @param string|null $afternoonEnd
     * @return void
     */
    private function createTimesForDoctor($doctorId, $days, $morningStart, $morningEnd, $afternoonStart = null, $afternoonEnd = null)
    {
        foreach ($days as $day) {
            // Crear horario de mañana
            $timeId = DB::table('doctor_available_times')->insertGetId([
                'doctor_id' => $doctorId,
                'day_of_week' => (string)$day, // day_of_week es varchar en la BD
                'from' => $morningStart,
                'to' => $morningEnd,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            // Crear slot para este horario (usar doctor_available_time_id, no doctor_available_id)
            DB::table('doctor_available_slots')->insert([
                'doctor_id' => $doctorId,
                'doctor_available_time_id' => $timeId, // Nombre correcto de la columna
                'from' => $morningStart,
                'to' => $morningEnd,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            // Si hay horario de tarde, crearlo también
            if ($afternoonStart && $afternoonEnd) {
                $timeId = DB::table('doctor_available_times')->insertGetId([
                    'doctor_id' => $doctorId,
                    'day_of_week' => (string)$day, // day_of_week es varchar en la BD
                    'from' => $afternoonStart,
                    'to' => $afternoonEnd,
                    'is_deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                // Crear slot para este horario
                DB::table('doctor_available_slots')->insert([
                    'doctor_id' => $doctorId,
                    'doctor_available_time_id' => $timeId, // Nombre correcto de la columna
                    'from' => $afternoonStart,
                    'to' => $afternoonEnd,
                    'is_deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
