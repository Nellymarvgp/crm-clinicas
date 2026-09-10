<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Doctor;
use App\DoctorAvailableDays;
use App\DoctorAvailableSlot;
use App\DoctorAvailableTimes;
use App\Patient;
use App\User;
use App\Services\GoogleCalendarService;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PublicAppointmentController extends Controller
{
    /**
     * Resolve the identifiers used by availability tables.
     *
     * Availability records point to users.id, while the public form sends doctors.id.
     * This helper allows both forms so legacy data keeps working.
     *
     * @param  int|string  $doctorId
     * @return array<int>
     */
    private function resolveAvailabilityDoctorIds($doctorId): array
    {
        $doctorId = (int) $doctorId;

        $doctorUserId = Doctor::where('id', $doctorId)->value('user_id');
        $doctorRowId = Doctor::where('user_id', $doctorId)->value('id');

        return collect([$doctorId, $doctorUserId, $doctorRowId])
            ->filter()
            ->map(function ($value) {
                return (int) $value;
            })
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Resolve the column used for Wednesday availability.
     *
     * Some legacy records use `wen` while the schema created by migrations uses `wed`.
     *
     * @return string
     */
    private function resolveWednesdayColumn(): string
    {
        if (Schema::hasColumn('doctor_available_days', 'wed')) {
            return 'wed';
        }

        if (Schema::hasColumn('doctor_available_days', 'wen')) {
            return 'wen';
        }

        return 'wed';
    }

    /**
     * Get a human-friendly time label for public slots.
     *
     * @param  string  $timeValue
     * @return string
     */
    private function formatPublicTimeLabel($timeValue): string
    {
        try {
            $formatted = date('h:i A', strtotime($timeValue));

            return str_replace(['AM', 'PM'], ['a. m.', 'p. m.'], $formatted);
        } catch (\Throwable $e) {
            return (string) $timeValue;
        }
    }

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

            $doctorLookupIds = $this->resolveAvailabilityDoctorIds($doctorId);
            
            $wednesdayColumn = $this->resolveWednesdayColumn();

            // Obtener días disponibles directamente de la base de datos y combinarlos si existen varias filas
            $availableDaysRows = DB::table('doctor_available_days')
                ->whereIn('doctor_id', $doctorLookupIds)
                ->get();

            if ($availableDaysRows->isEmpty()) {
                return response()->json(['error' => 'No hay días disponibles para este doctor.', 'days' => []], 200);
            }

            // Convertir a array de números de días (0=domingo, 1=lunes, etc.)
            $days = [];

            foreach ($availableDaysRows as $availableDays) {
                if (!empty($availableDays->sun)) $days[] = 0; // Sunday
                if (!empty($availableDays->mon)) $days[] = 1; // Monday
                if (!empty($availableDays->tue)) $days[] = 2; // Tuesday
                if (!empty($availableDays->{$wednesdayColumn})) $days[] = 3; // Wednesday
                if (!empty($availableDays->thu)) $days[] = 4; // Thursday
                if (!empty($availableDays->fri)) $days[] = 5; // Friday
                if (!empty($availableDays->sat)) $days[] = 6; // Saturday
            }

            $days = array_values(array_unique($days));

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
            $doctorLookupIds = $this->resolveAvailabilityDoctorIds($doctorId);
            
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
            $wednesdayColumn = $this->resolveWednesdayColumn();
            $dayMapping = [
                0 => 'sun',
                1 => 'mon',
                2 => 'tue',
                3 => $wednesdayColumn,
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
                    ->whereIn('doctor_id', $doctorLookupIds)
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
                    ->whereIn('doctor_id', $doctorLookupIds)
                    ->where('day_of_week', $dayOfWeekString)
                    ->where('is_deleted', 0)
                    ->get();

                // Fallback for legacy data: if there are no day-specific rows,
                // use generic rows configured for the same doctor.
                if ($availableTimes->isEmpty()) {
                    $availableTimes = DB::table('doctor_available_times')
                        ->whereIn('doctor_id', $doctorLookupIds)
                        ->where('is_deleted', 0)
                        ->get();

                    if ($availableTimes->isNotEmpty()) {
                        Log::warning('Usando horario general por falta de horario específico del día', [
                            'doctor_lookup_ids' => $doctorLookupIds,
                            'day_of_week' => $dayOfWeekString,
                        ]);
                    }
                }
                
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
            
            // Usar los slots persistidos: cada opción conserva su propio rango e ID.
            $availableSlotsQuery = DB::table('doctor_available_slots as slots')
                ->join('doctor_available_times as times', 'times.id', '=', 'slots.doctor_available_time_id')
                ->whereIn('times.id', $availableTimes->pluck('id')->all())
                ->where('slots.is_deleted', 0)
                ->where('times.is_deleted', 0)
                ->select('slots.id', 'slots.from', 'slots.to')
                ->orderBy('slots.from');

            $bookedAppointments = DB::table('appointments as appointments')
                ->leftJoin('doctor_available_slots as booked_slots', 'booked_slots.id', '=', 'appointments.available_slot')
                ->whereIn('appointments.appointment_with', $doctorLookupIds)
                ->where('appointments.appointment_date', $date)
                ->where('appointments.is_deleted', 0)
                ->whereNotIn('appointments.status', [1, 2])
                ->select('booked_slots.from', 'booked_slots.to')
                ->get();

            $availableSlots = $availableSlotsQuery->get()->filter(function ($slot) use ($bookedAppointments) {
                $slotStart = strtotime($slot->from);
                $slotEnd = strtotime($slot->to);

                return !$bookedAppointments->contains(function ($bookedSlot) use ($slotStart, $slotEnd) {
                    if (!$bookedSlot->from || !$bookedSlot->to) {
                        return false;
                    }

                    return $slotStart < strtotime($bookedSlot->to)
                        && $slotEnd > strtotime($bookedSlot->from);
                });
            })->map(function ($slot) {
                return [
                    'id' => $slot->id,
                    'time' => date('H:i', strtotime($slot->from)),
                    'display_time' => $this->formatPublicTimeLabel($slot->from) . ' a ' . $this->formatPublicTimeLabel($slot->to),
                ];
            })->values()->all();
            
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
            'cedula' => 'required|string|max:30',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'nullable|string|in:Male,Female,Other',
            'address' => 'nullable|string|max:500',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'time' => 'required',
            'slot_id' => 'required|exists:doctor_available_slots,id',
        ]);
        
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

            $doctorLookupIds = $this->resolveAvailabilityDoctorIds($request->doctor_id);
            $requestedDay = (string) date('w', strtotime($request->date));
            $selectedSlot = DB::table('doctor_available_slots as slots')
                ->join('doctor_available_times as times', 'times.id', '=', 'slots.doctor_available_time_id')
                ->where('slots.id', $request->slot_id)
                ->whereIn('slots.doctor_id', $doctorLookupIds)
                ->where('times.day_of_week', $requestedDay)
                ->where('slots.is_deleted', 0)
                ->where('times.is_deleted', 0)
                ->select('slots.*', 'times.id as available_time_id')
                ->first();

            if (!$selectedSlot || date('H:i', strtotime($selectedSlot->from)) !== date('H:i', strtotime($request->time))) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'El horario seleccionado ya no está disponible. Actualiza la fecha y vuelve a intentarlo.',
                ], 422);
            }

            $slotIsBooked = DB::table('appointments as appointments')
                ->leftJoin('doctor_available_slots as booked_slots', 'booked_slots.id', '=', 'appointments.available_slot')
                ->whereIn('appointments.appointment_with', $doctorLookupIds)
                ->where('appointments.appointment_date', $request->date)
                ->where('appointments.is_deleted', 0)
                ->whereNotIn('appointments.status', [1, 2])
                ->where('booked_slots.from', '<', $selectedSlot->to)
                ->where('booked_slots.to', '>', $selectedSlot->from)
                ->exists();

            if ($slotIsBooked) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'El horario seleccionado ya está ocupado. Actualiza la fecha y vuelve a intentarlo.',
                ], 422);
            }
            
            $firstName = $request->first_name;
            $lastName = $request->last_name;
            
            // La cedula identifica al paciente aunque todavía no tenga correo.
            $existingUser = User::where('cedula', $request->cedula)->first();
            if (!$existingUser && $request->filled('email')) {
                $existingUser = User::where('email', $request->email)->first();
            }
            
            if ($existingUser) {
                // Actualizar usuario existente
                $user = $existingUser;
                $user->cedula = $request->cedula;
                $user->first_name = $firstName;
                $user->last_name = $lastName;
                $user->mobile = $request->phone ?: $user->mobile;
                $user->email = $request->email ?: $user->email;
                $user->save();
            } else {
                // Crear nuevo usuario usando Sentinel (sin role_id en tabla users)
                $userData = [
                    'cedula' => $request->cedula,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $request->email ?: 'paciente-' . $request->cedula . '@no-email.local',
                    'mobile' => $request->phone ?: '',
                    'password' => Str::random(10),
                ];
                $user = Sentinel::registerAndActivate($userData);
            }

            // Asegurar que el usuario tenga rol de paciente
            $patientRole = Sentinel::findRoleBySlug('patient');
            if ($patientRole) {
                $alreadyPatient = $patientRole->users()->where('users.id', $user->id)->exists();
                if (!$alreadyPatient) {
                    $patientRole->users()->attach($user);
                }
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
            
            // Modo de calendario estándar
            $appointment->appointment_date = $request->date;

            $appointment->available_time = $selectedSlot->available_time_id;
            $appointment->available_slot = $request->slot_id;
            
            $appointment->status = 0; // Pendiente
            $appointment->save();
            
            $googleCalendarSync = false;
            $googleCalendarEventLink = null;

            try {
                $doctor = Doctor::with('user')->findOrFail($request->doctor_id);
                $googleCalendarService = new GoogleCalendarService();
                $eventData = $googleCalendarService->createAppointmentEvent($appointment, $patient, $doctor, $request->time);
                $googleCalendarSync = true;
                $googleCalendarEventLink = $eventData['htmlLink'] ?? null;
            } catch (\Throwable $googleError) {
                Log::error('No se pudo sincronizar la cita con Google Calendar', [
                    'appointment_id' => $appointment->id,
                    'error' => $googleError->getMessage(),
                ]);
            }
            
            // Confirmar transacción
            DB::commit();

            $mailAppointment = Appointment::with('doctor.user', 'patient', 'BookedBy', 'timeSlot')->find($appointment->id);
            $recipients = collect([$user->email, optional($mailAppointment->doctor->user)->email])
                ->merge(User::whereHas('roles', function ($query) {
                    $query->where('slug', 'admin');
                })->pluck('email'))
                ->filter(function ($email) {
                    return filter_var($email, FILTER_VALIDATE_EMAIL) && !str_ends_with($email, '@no-email.local');
                })->unique()->values()->all();
            $mailSent = true;
            if ($recipients) {
                try {
                    Mail::send('emails.appointment_create', ['MailAppointment' => $mailAppointment, 'email' => $user->email], function ($message) use ($recipients) {
                        $message->to($recipients)->subject(AppSetting('title') . ' - Nueva cita generada');
                    });
                } catch (\Throwable $mailError) {
                    $mailSent = false;
                    Log::error('La cita fue creada, pero no se pudo enviar el correo de confirmación.', [
                        'appointment_id' => $appointment->id,
                        'error' => $mailError->getMessage(),
                    ]);
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => $mailSent
                    ? ($googleCalendarSync
                        ? '¡Cita agendada y confirmada por correo!'
                        : '¡Cita agendada correctamente! No se pudo sincronizar con Google Calendar.')
                    : '¡Cita agendada correctamente! No se pudo enviar el correo; revisa la configuración SMTP.',
                'google_calendar_synced' => $googleCalendarSync,
                'google_calendar_event_link' => $googleCalendarEventLink,
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
