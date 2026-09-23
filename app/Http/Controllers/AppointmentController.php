<?php

namespace App\Http\Controllers;
use App\Appointment;
use App\DentalEvaluation;
use App\Doctor;
use App\DoctorAvailableDay;
use App\DoctorAvailableSlot;
use App\DoctorAvailableTime;
use App\Notification;
use App\ReceptionListDoctor;
use App\User;
use Illuminate\Support\Facades\Mail;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class AppointmentController extends Controller
{
    protected $appointment;
    public $limit;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('sentinel.auth');
        $this->appointment = new Appointment();
        $this->middleware(function ($request, $next) {
            if (session()->has('page_limit')) {
                $this->limit = session()->get('page_limit');
            } else {
                $this->limit = Config::get('app.page_limit');
            }
            return $next($request);
        });
    }

    private function getBookedSlotIdsForDoctorAndDate($doctorId, string $date, ?int $excludeAppointmentId = null)
    {
        $bookedSlotIds = Appointment::whereDate('appointment_date', $date)
            ->where('appointment_with', $doctorId)
            ->where('is_deleted', 0)
            ->whereNotIn('status', [2])
            ->when($excludeAppointmentId, function ($query, $excludeAppointmentId) {
                return $query->where('id', '!=', $excludeAppointmentId);
            })
            ->get(['available_slot', 'available_slots'])
            ->flatMap(function ($appointment) {
                $storedSlots = json_decode($appointment->available_slots ?: '[]', true);
                return array_merge(
                    [$appointment->available_slot],
                    is_array($storedSlots) ? $storedSlots : []
                );
            })
            ->map(function ($slotId) {
                return (int) $slotId;
            })
            ->filter(fn ($slotId) => $slotId > 0)
            ->unique()
            ->values();

        return $bookedSlotIds;
    }

    private function ensureDoctorSlotIsAvailable($doctorId, string $date, int $slotId, ?int $excludeAppointmentId = null): void
    {
        $bookedSlotIds = $this->getBookedSlotIdsForDoctorAndDate($doctorId, $date, $excludeAppointmentId);

        if ($bookedSlotIds->contains($slotId)) {
            throw new Exception('El horario seleccionado ya está ocupado para este doctor en la fecha indicada.');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Sentinel::getUser();
        if ($user && $user->hasAccess('appointment.create')) {
            return redirect('appointment/create');
        } else {
            return view('error.403');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Sentinel::getUser();
        if ($user && $user->hasAccess('appointment.create')) {
            $userId = $user->id;
            $role = $user->roles[0]->slug;
            $patient_role = Sentinel::findRoleBySlug('patient');
            $patients = $patient_role->users()->with('roles')->get();
            $doctor_role = Sentinel::findRoleBySlug('doctor');
            $doctors = $doctor_role->users()->with('roles')->get();
            if ($role == 'doctor') {
                $appointments = Appointment::with('patient', 'timeSlot')->where('appointment_with', $userId)->where('appointment_date', Carbon::today())->get();
            } elseif ($role == 'patient') {
                $appointments = Appointment::with('doctor', 'timeSlot')->where('appointment_for', $userId)->where('appointment_date', Carbon::today())->get();
            } elseif ($role == 'admin') {
                $appointments = Appointment::with('doctor', 'doctor.user', 'patient', 'timeSlot')
                    ->where('appointment_date', Carbon::today())
                    ->get();
            } else {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $userId)->pluck('doctor_id');
                $appointments = Appointment::with('doctor', 'patient', 'timeSlot')
                    ->where(function ($re) use ($userId, $receptionists_doctor_id) {
                        $re->whereIN('appointment_with', $receptionists_doctor_id);
                        $re->orWhereIN('booked_by', $receptionists_doctor_id);
                        $re->orWhere('booked_by', $userId);
                    })->where('appointment_date', Carbon::today())
                    ->get();
            }
            return view('appointment.appointment', compact('user', 'role', 'patients', 'doctors', 'appointments'));
        } else {
            return view('error.403');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
    }
    /**
     * List of appointments based on specified date
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON response
     */
    public function appointment_list(Request $request)
    {
        $user = Sentinel::getUser();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }
        $role = $user->roles[0]->slug;
        $userId = $user->id;
        $selectedDate = $request->date;
        if ($role == 'doctor') {
            $doctor = Doctor::where('user_id', $user->id)->where('is_deleted', 0)->first();
            $res = Appointment::with('patient', 'timeSlot')->where('appointment_with', $doctor->id)->whereDate('appointment_date', $selectedDate)->get();
        } elseif ($role == 'patient') {
            $res = Appointment::with('doctor', 'doctor.user', 'timeSlot')->where('appointment_for', $userId)->whereDate('appointment_date', $selectedDate)->get();
        } elseif ($role == 'admin') {
            $res = Appointment::with('patient', 'doctor', 'doctor.user', 'timeSlot')
                ->whereDate('appointment_date', $selectedDate)
                ->get();
        } else {
            $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $userId)->pluck('doctor_id');
            $res = Appointment::with('patient', 'timeSlot', 'doctor', 'doctor.user')->whereDate('appointment_date', $selectedDate)
                ->where(function ($re) use ($userId, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $userId);
                })
                ->get();
        }
        if ($res->isEmpty()) {
            $response = [
                'status' => 'error',
                'message' => 'No Appointments Found On '
            ];
        } else {
            $response = [
                'role' => $role,
                'appointments' => $res
            ];
        }
        return response()->json($response);
    }
    public function AppointmentList(User $patient)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {
            $user_id = Sentinel::getUser()->id;
            $user = Sentinel::getUser();
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            if ($role == 'doctor') {
                $doctor_row_id = Doctor::where('user_id', $user_id)->value('id');
                $doctor_lookup_ids = collect([$doctor_row_id, $user_id])->filter()->unique()->values();
                $pending_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($doctor_lookup_ids) {
                    $re->whereIn('appointment_with', $doctor_lookup_ids);
                    $re->orWhereIn('booked_by', $doctor_lookup_ids);
                })->where('status', 0)->orderBy('id', 'DESC')->get();

                $Complete_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($doctor_lookup_ids) {
                    $re->whereIn('appointment_with', $doctor_lookup_ids);
                    $re->orWhereIn('booked_by', $doctor_lookup_ids);
                })->where('status', 1)->orderBy('id', 'DESC')->get();

                $Upcoming_appointment = Appointment::where(function ($re) use ($doctor_lookup_ids) {
                    $re->whereIn('appointment_with', $doctor_lookup_ids);
                    $re->orWhereIn('booked_by', $doctor_lookup_ids);
                })
                    ->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($re) use ($today, $time, $doctor_lookup_ids) {
                        $re->whereDate('appointment_date', '=', $today);
                        $re->whereTime('available_time', '>=', $time);
                        $re->where(function ($r) use ($doctor_lookup_ids) {
                            $r->whereIn('appointment_with', $doctor_lookup_ids);
                            $r->orWhereIn('booked_by', $doctor_lookup_ids);
                        });
                    })->where('status', 0)
                    ->orderBy('id', 'DESC')->get();
                $Cancel_appointment = Appointment::with('doctor', 'patient', 'timeSlot')
                    ->where(function ($re) use ($doctor_lookup_ids) {
                        $re->whereIn('appointment_with', $doctor_lookup_ids);
                        $re->orWhereIn('booked_by', $doctor_lookup_ids);
                    })->where('status', 2)
                    ->orderBy('id', 'DESC')->get();
            } elseif ($role == 'patient') {
                $pending_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['status' => 0, 'appointment_for' => $user_id])->orderBy('id', 'DESC')->get();
                $Complete_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['status' => 1, 'appointment_for' => $user_id])->orderBy('id', 'DESC')->get();
                $Upcoming_appointment = Appointment::with('doctor', 'patient', 'timeSlot')
                    ->where('appointment_for', $user_id)
                    ->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($re) use ($today, $time, $user_id) {
                        $re->whereDate('appointment_date', '=', $today);
                        $re->whereTime('available_time', '>=', $time);
                        $re->where(function ($r) use ($user_id) {
                            $r->where('appointment_for', $user_id);
                        });
                    })->where('status', 0)
                    ->get();
                $Cancel_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['status' => 2, 'appointment_for' => $user_id])->get();
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $pending_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                })->where('status', 0)->orderBy('id', 'DESC')->get();
                $Complete_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                })->where('status', 1)->orderBy('id', 'DESC')->get();
                $time = date('H:i:s');
                $Upcoming_appointment = Appointment::with('patient', 'doctor', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->orWhereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                })
                    ->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($re) use ($today, $time) {
                        $re->whereDate('appointment_date', '=', $today);
                        $re->whereTime('available_time', '>=', $time);
                        $re->Where('status', 0);
                    })->orderBy('id', 'DESC')->get();
                $Cancel_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                })
                    ->where('status', 2)->orderBy('id', 'DESC')->get();
            } else {
                $pending_appointment = Appointment::with('doctor', 'patient')->where(['status' => 0])->orderBy('id', 'DESC')->get();
                $Complete_appointment = Appointment::with('doctor', 'patient')->where(['status' => 1])->orderBy('id', 'DESC')->get();
                $Upcoming_appointment = Appointment::with('doctor', 'patient')->where('appointment_date', '>', $today)->where('status', 0)->orderBy('id', 'DESC')->get();
                $Cancel_appointment = Appointment::with('doctor', 'patient')->where('status', 2)->orderBy('id', 'DESC')->get();
            }
            return view('appointment.appointment-list', compact('user', 'role', 'pending_appointment', 'Upcoming_appointment', 'Complete_appointment', 'Cancel_appointment'));
        } else {
            return view('error.403');
        }
    }

    public function appointment_status(Request $request, $id)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.status')) {
            $role = $user->roles[0]->slug;
            $userId = $user->id;
            $appointment = Appointment::find($id);
            if ($appointment) {
                $appointment->status = $request->status;
                $appointment->save();
                // complete appointment notification send
                if ($request->status == 1) {
                    if ($role == 'doctor') {
                        $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $patient_id = $appointment->appointment_for;
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($patient_id);
                        $fromId->push($admin_id);
                        $fromId->push($receptionists_doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 2;
                            $notification->title = 'Appointment completed successfully';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                    } elseif ($role == 'receptionist') {
                        $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('doctor_id');
                        $doctor_id = $appointment->appointment_with;
                        $patient_id = $appointment->appointment_for;
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($patient_id);
                        $fromId->push($admin_id);
                        $fromId->push($doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 2;
                            $notification->title = 'Appointment completed successfully';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                    }
                    return response()->json([
                        'isSuccess' => true,
                        'Message' => "Appointment Confirm successfully",
                        'data' => $appointment
                    ],200);
                }
                // cancel appointment mail send and
                // cancel appointment mail send
                elseif ($request->status == 2) {
                    $verify_mail = $user->email;
                    $app_name =  AppSetting('title');
                    $MailAppointment = Appointment::with('doctor','patient','BookedBy','timeSlot')->where('id',$appointment->id)->first();
                    $CancelBy = User::find($userId);
                    if ($role == 'doctor') {
                        $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $patient_id = $appointment->appointment_for;
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($patient_id);
                        $fromId->push($admin_id);
                        $fromId->push($receptionists_doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 3;
                            $notification->title = 'Appointment Cancel';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                        $receptionists_doctor_mail = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $reception_email = User::whereIN('id', $receptionists_doctor_mail)->pluck('email');
                        $patient_email = User::where('id',$patient_id)->pluck('email');
                        $admin_email = $admin_role->users()->with('roles')->pluck('email');
                        $mailSend = collect();
                        $mailSend->push($reception_email);
                        $mailSend->push($patient_email);
                        $mailSend->push($admin_email);
                        $mailSend = $mailSend->flatten();
                        $mailArray = $mailSend->toarray();
                        Mail::send('emails.appointment_cancel', ['MailAppointment' => $MailAppointment, 'email' => $verify_mail,'CancelBy'=>$CancelBy], function ($message) use ($mailArray, $app_name) {
                            $message->to($mailArray)->subject($app_name . ' - Cita cancelada');
                        });

                    } elseif ($role == 'patient') {
                        $doctor_id = $appointment->appointment_with;
                        $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($doctor_id);
                        $fromId->push($admin_id);
                        $fromId->push($receptionists_doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 3;
                            $notification->title = 'Appointment Cancel';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                        $receptionists_doctor_mail = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $receptionists_email = User::whereIN('id', $receptionists_doctor_mail)->pluck('email');
                        $admin_email = $admin_role->users()->with('roles')->pluck('email');
                        $receptionists_doctor_email = User::where('id', $doctor_id)->pluck('email');
                        $mailSend = collect();
                        $mailSend->push($receptionists_email);
                        $mailSend->push($receptionists_doctor_email);
                        $mailSend->push($admin_email);
                        $mailSend = $mailSend->flatten();
                        $mailArray = $mailSend->toarray();
                        Mail::send('emails.appointment_cancel', ['MailAppointment' => $MailAppointment, 'email' => $verify_mail,'CancelBy'=>$CancelBy], function ($message) use ($mailArray, $app_name) {
                            $message->to($mailArray)->subject($app_name . ' - Cita cancelada');
                        });
                    } elseif ($role == 'admin') {
                        $patient_id = $appointment->appointment_for;
                        $doctor_id = $appointment->appointment_with;
                        $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $fromId = collect();
                        $fromId->push($doctor_id);
                        $fromId->push($patient_id);
                        $fromId->push($receptionists_doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 3;
                            $notification->title = 'Appointment Cancel';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                        $receptionists_doctor_mail = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $receptionists_email = User::whereIN('id', $receptionists_doctor_mail)->pluck('email');
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_email = $admin_role->users()->with('roles')->pluck('email');
                        $receptionists_doctor_email = User::where('id', $doctor_id)->pluck('email');
                        $receptionists_patient_email = User::where('id', $patient_id)->pluck('email');
                        $mailSend = collect();
                        $mailSend->push($receptionists_email);
                        $mailSend->push($receptionists_doctor_email);
                        $mailSend->push($admin_email);
                        $mailSend->push($receptionists_patient_email);
                        $mailSend = $mailSend->flatten();
                        $mailArray = $mailSend->toarray();
                        Mail::send('emails.appointment_cancel', ['MailAppointment' => $MailAppointment, 'email' => $verify_mail,'CancelBy'=>$CancelBy], function ($message) use ($mailArray, $app_name) {
                            $message->to($mailArray)->subject($app_name . ' - Cita cancelada');
                        });

                    } elseif ($role == 'receptionist') {
                        $doctor_id = $appointment->appointment_with;
                        $patient_id = $appointment->appointment_for;
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($patient_id);
                        $fromId->push($admin_id);
                        $fromId->push($doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 3;
                            $notification->title = 'Appointment Cancel';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                        $admin_email = $admin_role->users()->with('roles')->pluck('email');
                        $receptionists_doctor_email = User::where('id', $doctor_id)->pluck('email');
                        $receptionists_patient_email = User::where('id', $patient_id)->pluck('email');
                        $mailSend = collect();
                        $mailSend->push($receptionists_patient_email);
                        $mailSend->push($receptionists_doctor_email);
                        $mailSend->push($admin_email);
                        $mailSend = $mailSend->flatten();
                        $mailArray = $mailSend->toarray();
                        Mail::send('emails.appointment_cancel', ['MailAppointment' => $MailAppointment, 'email' => $verify_mail,'CancelBy'=>$CancelBy], function ($message) use ($mailArray, $app_name) {
                            $message->to($mailArray)->subject($app_name . ' - Cita cancelada');
                        });
                    }
                    return response()->json([
                        'isSuccess' => true,
                        'Message' => "Appointment cancel successfully",
                        'data' => $appointment
                    ],200);
                }
            } else {
                return response()->json([
                    'isSuccess' => false,
                    'Message' => "Appointment not found",
                    'data' => '',
                ],409);
            }
        } else {
            return response()->json([
                'isSuccess' => false,
                'Message' => "You have no permission to change appointment ",
                'data' => '',
            ],409);
        }
    }

    public function doctor_by_day_time(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.create')) {
            if ($request->ajax()) {
                $doctor_id = (int) $request->doctor_id;
                $doctor_user_id = Doctor::where('id', $doctor_id)->value('user_id');
                $doctor_lookup_ids = collect([$doctor_id, $doctor_user_id])->filter()->unique()->values();

                $doctor_available_day = null;
                if ($doctor_lookup_ids->isNotEmpty()) {
                    $doctor_available_day = DoctorAvailableDay::whereIn('doctor_id', $doctor_lookup_ids->all())
                        ->orderByRaw('CASE WHEN doctor_id = ? THEN 0 ELSE 1 END', [$doctor_id])
                        ->first();
                }

                $doctor_available_time = collect();
                if ($doctor_lookup_ids->isNotEmpty()) {
                    $doctor_available_time = DoctorAvailableTime::whereIn('doctor_id', $doctor_lookup_ids->all())
                        ->where('is_deleted', 0)
                        ->orderBy('from')
                        ->get();
                }
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Doctor availableTime successfully",
                    'data' => [$doctor_available_day, $doctor_available_time]
                ]);
            }
        } else {
            return response()->json([
                'isSuccess' => false,
                'Message' => 'You have no permission to access doctor availability.',
                'data' => []
            ], 403);
        }
    }

    public function appointment_create()
    {
        $user = Sentinel::getUser();

        if ($user->hasAccess('appointment.create')) {
            $userId = $user->id;
            $doctor_id = Doctor::where('user_id' ,$userId)->pluck('id')->first();
            $doctor_available_day = '';
            $doctor_available_time = '';
            $role = $user->roles[0]->slug;
            $patient_role = Sentinel::findRoleBySlug('patient');
            $patients = $patient_role->users()->with('roles')->get();
            $doctor_role = Sentinel::findRoleBySlug('doctor');
            $doctors = $doctor_role->users()->with('roles')->where('is_deleted', 0)->get();
            if ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $userId)->pluck('doctor_id');
                $doctors = $doctor_role->users()->with('roles')->whereIN('id', $receptionists_doctor_id)->where('is_deleted', 0)->get();
            }
            $dayArray = collect();
            if ($role == 'doctor') {
                $doctor_lookup_ids = collect([$doctor_id, $userId])->filter()->unique()->values();
                $doctor_available_day_model = null;
                if ($doctor_lookup_ids->isNotEmpty()) {
                    $doctor_available_day_model = DoctorAvailableDay::whereIn('doctor_id', $doctor_lookup_ids->all())
                        ->orderByRaw('CASE WHEN doctor_id = ? THEN 0 ELSE 1 END', [$doctor_id])
                        ->first();
                }
                if ($doctor_available_day_model) {
                    $doctor_available_day = $doctor_available_day_model->toArray();
                    if ($doctor_available_day['sun'] == 0) {
                        $dayArray->push(0);
                    }
                    if ($doctor_available_day['mon'] == 0) {
                        $dayArray->push(1);
                    }
                    if ($doctor_available_day['tue'] == 0) {
                        $dayArray->push(2);
                    }
                    if ($doctor_available_day['wen'] == 0) {
                        $dayArray->push(3);
                    }
                    if ($doctor_available_day['thu'] == 0) {
                        $dayArray->push(4);
                    }
                    if ($doctor_available_day['fri'] == 0) {
                        $dayArray->push(5);
                    }
                    if ($doctor_available_day['sat'] == 0) {
                        $dayArray->push(6);
                    }
                }
                $doctor_available_time = collect();
                if ($doctor_lookup_ids->isNotEmpty()) {
                    $doctor_available_time = DoctorAvailableTime::whereIn('doctor_id', $doctor_lookup_ids->all())
                        ->where('is_deleted', 0)
                        ->orderBy('from')
                        ->get();
                }
            }
            return view('appointment.appointment_create', compact('user', 'role', 'patients', 'doctors', 'doctor_available_day', 'doctor_available_time', 'dayArray'));
        } else {
            return view('error.403');
        }
    }

    public function appointment_store(Request $request)
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        $userId = $user->id;
        if ($user->hasAccess('appointment.create')) {
            $request->validate([
                'appointment_for' => 'required',
                'appointment_with' => 'required',
                'appointment_date' => 'required',
                'available_time' => 'required',
                'available_slot' => 'required|array|min:1',
                'available_slot.*' => 'required|exists:doctor_available_slots,id',
            ]);
            try {
                if ($request->available_time == null && empty($request->available_slot)) {
                    return redirect()->back()->with('error', 'The appointment time and appointment slot  field is required.');
                } else {
                    $verify_mail = $user->email;
                    $app_name =  AppSetting('title');
                    $date = $request->appointment_date;
                    $newDate = Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
                    $selectedSlots = array_values(array_unique(array_map('intval', $request->available_slot)));
                    $selectedSlotId = (int) ($selectedSlots[0] ?? 0);

                    if ($selectedSlotId <= 0) {
                        return redirect()->back()->with('error', 'El horario seleccionado no es válido.');
                    }

                    $this->ensureDoctorSlotIsAvailable((int) $request->appointment_with, $newDate, $selectedSlotId);

                    $appointment = new Appointment();
                    $appointment->appointment_for = $request->appointment_for;
                    $appointment->appointment_with = $request->appointment_with;
                    $appointment->appointment_date = $newDate;
                    $appointment->available_time = $request->available_time;
                    $appointment->available_slot = $selectedSlotId;
                    $appointment->available_slots = json_encode($selectedSlots);
                    $appointment->booked_by    = $user->id;
                    $appointment->save();
                    // appointment create notification send and mail send
                    // Find Mail
                    $MailAppointment = Appointment::with('doctor','patient','BookedBy','timeSlot')->where('id',$appointment->id)->first();
                    if ($role == 'patient') {
                        $doctor_id = $appointment->appointment_with;
                        $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($doctor_id);
                        $fromId->push($admin_id);
                        $fromId->push($receptionists_doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 1;
                            $notification->title = 'Appointment Added';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                        $receptionists_doctor_mail = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $receptionists_email = User::whereIN('id', $receptionists_doctor_mail)->pluck('email');
                        $admin_email = $admin_role->users()->with('roles')->pluck('email');
                        $receptionists_doctor_email = User::where('id', $doctor_id)->pluck('email');
                        $mailSend = collect();
                        $mailSend->push($receptionists_email);
                        $mailSend->push($receptionists_doctor_email);
                        $mailSend->push($admin_email);
                        $mailSend = $mailSend->flatten();
                        $mailArray = $mailSend->toarray();
                        Mail::send('emails.appointment_create', ['MailAppointment' => $MailAppointment, 'email' => $verify_mail], function ($message) use ($mailArray, $app_name) {
                            $message->to($mailArray)->subject($app_name . ' - Nueva cita generada');
                        });
                    } elseif ($role == 'receptionist') {
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $patient_id = $appointment->appointment_for;
                        $doctor_id = $appointment->appointment_with;
                        $fromId = collect();
                        $fromId->push($patient_id);
                        $fromId->push($admin_id);
                        $fromId->push($doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 1;
                            $notification->title = 'Appointment Added';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                        $admin_email = $admin_role->users()->with('roles')->pluck('email');
                        $receptionists_doctor_email = User::where('id', $doctor_id)->pluck('email');
                        $receptionists_patient_email = User::where('id', $patient_id)->pluck('email');
                        // return $receptionists_patient_email;
                        $mailSend = collect();
                        $mailSend->push($receptionists_patient_email);
                        $mailSend->push($receptionists_doctor_email);
                        $mailSend->push($admin_email);
                        $mailSend = $mailSend->flatten();
                        $mailArray = $mailSend->toarray();
                        Mail::send('emails.appointment_create', ['MailAppointment' => $MailAppointment, 'email' => $verify_mail], function ($message) use ($mailArray, $app_name) {
                            $message->to($mailArray)->subject($app_name . ' - Nueva cita generada');
                        });

                    } elseif ($role == 'doctor') {
                        $receptionists_doctor_id = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $patient_id = $appointment->appointment_for;
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($patient_id);
                        $fromId->push($admin_id);
                        $fromId->push($receptionists_doctor_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 1;
                            $notification->title = 'Appointment Added';
                            $notification->data = $appointment->id;
                            $notification->from_user = $userId;
                            $notification->save();
                        }
                        $receptionists_doctor_mail = ReceptionListDoctor::where('doctor_id', $appointment->appointment_with)->pluck('reception_id');
                        $reception_email = User::whereIN('id', $receptionists_doctor_mail)->pluck('email');
                        $patient_email = User::where('id',$patient_id)->pluck('email');
                        $admin_email = $admin_role->users()->with('roles')->pluck('email');
                        $this->mailSend = collect();
                        $this->mailSend->push($reception_email);
                        $this->mailSend->push($patient_email);
                        $this->mailSend->push($admin_email);
                        $this->mailSend = $this->mailSend->flatten();
                        $mailArray = $this->mailSend->toarray();
                        Mail::send('emails.appointment_create', ['MailAppointment' => $MailAppointment, 'email' => $verify_mail], function ($message) use ($mailArray, $app_name) {
                            $message->to($mailArray)->subject($app_name . ' - Nueva cita generada');
                        });
                    }
                }
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
            return redirect('appointment/create')->with('success', 'Appointment created successfully');
        } else {
            return view('error.403');
        }
    }

    public function time_by_slot(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.create')) {
            if ($request->ajax()) {
                $timeId = $request->timeId;
                $doctorId  = $request->doctorId;
                $date  = $request->dates;
                $dates = Carbon::parse($date)->format('Y-m-d');

                $appointment_slot = DoctorAvailableSlot::with(['appointment' => function ($re) use ($dates) {
                    $re->whereDate('appointment_date', $dates)
                        ->where('is_deleted', 0)
                        ->whereNotIn('status', [2]);
                }])
                    ->where('doctor_available_time_id', $timeId)
                    ->where('is_deleted', 0)
                    ->orderBy('from')
                    ->get();

                $bookedSlotIds = Appointment::whereDate('appointment_date', $dates)
                    ->where('is_deleted', 0)
                    ->whereNotIn('status', [2])
                    ->get(['available_slot', 'available_slots'])
                    ->flatMap(function ($appointment) {
                        $storedSlots = json_decode($appointment->available_slots ?: '[]', true);
                        return array_merge(
                            [$appointment->available_slot],
                            is_array($storedSlots) ? $storedSlots : []
                        );
                    })
                    ->map(function ($slotId) {
                        return (int) $slotId;
                    })
                    ->unique();

                $appointment_slot->each(function ($slot) use ($bookedSlotIds) {
                    if ($bookedSlotIds->contains((int) $slot->id)) {
                        $slot->setRelation('appointment', collect([(object) []]));
                    }
                });
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Appointment slot find successfully",
                    'data' => [$appointment_slot, $dates, $doctorId]
                ]);
            }
        } else {
            return view('error.403');
        }
    }

    public function cal_appointment_show(Request $request)
    {
        if ($request->ajax()) {
            $user = Sentinel::getUser();
            $userId = $user->id;
            $role = $user->roles[0]->slug;
            if ($role == 'doctor') {
                $doctor = Doctor::where('user_id', $user->id)->where('is_deleted', 0)->first();
                $appointment = Appointment::select(DB::raw('count(id) as `total_appointment`'), DB::raw('appointment_date'), DB::raw('status'))
                    ->whereDate('appointment_date', '>=', $request->start)
                    ->whereDate('appointment_date',   '<=', $request->end)
                    ->where('appointment_with', $doctor->id)
                    ->groupBy(DB::raw('appointment_date'), DB::raw('status'))
                    ->get();
            } elseif ($role == 'patient') {
                $appointment = Appointment::select(DB::raw('count(id) as `total_appointment`'), DB::raw('appointment_date'), DB::raw('status'))
                    ->whereDate('appointment_date', '>=', $request->start)
                    ->whereDate('appointment_date',   '<=', $request->end)
                    ->where('appointment_for', $user->id)
                    ->groupBy(DB::raw('appointment_date'), DB::raw('status'))
                    ->get();
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $userId)->pluck('doctor_id');
                $appointment = Appointment::select(DB::raw('count(id) as `total_appointment`'), DB::raw('appointment_date'), DB::raw('status'))
                    ->whereDate('appointment_date', '>=', $request->start)
                    ->whereDate('appointment_date',   '<=', $request->end)
                    ->where(function ($re) use ($userId, $receptionists_doctor_id) {
                        $re->whereIN('appointment_with', $receptionists_doctor_id);
                        $re->orWhereIN('booked_by', $receptionists_doctor_id);
                        $re->orWhere('booked_by', $userId);
                    })
                    ->groupBy(DB::raw('appointment_date'), DB::raw('status'))
                    ->get();
            } else {
                $appointment = Appointment::select(DB::raw('count(id) as `total_appointment`'), DB::raw('appointment_date'), DB::raw('status'))
                    ->whereDate('appointment_date', '>=', $request->start)
                    ->whereDate('appointment_date', '<=', $request->end)
                    ->groupBy(DB::raw('appointment_date'), DB::raw('status'))
                    ->get();
            }

            if ($appointment->isEmpty()) {
                $response = [
                    'status' => 'error',
                    'message' => 'No Appointments Found On '
                ];
            } else {
                $response = [
                    'role' => $role,
                    'appointments' => $appointment
                ];
            }
            return response()->json($response);
        }
    }

    public function pending_appointment(User $patient)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {
            $user_id = Sentinel::getUser()->id;
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            if ($role == 'doctor') {
                $doctor_id = Doctor::where('user_id', $user_id)->pluck('id');
                $pending_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($doctor_id) {
                    $re->where('appointment_with', $doctor_id);
                    $re->orWhere('booked_by', $doctor_id);
                })->where('status', 0)->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'patient') {
                $pending_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['status' => 0, 'appointment_for' => $user_id])->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $pending_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                })->where('status', 0)->orderBy('id', 'DESC')->paginate($this->limit);
            } else {
                $pending_appointment = Appointment::with('doctor', 'patient')->where(['status' => 0])->orderBy('id', 'DESC')->paginate($this->limit);
            }
            return view('appointment.pending-appointment', compact('user', 'role', 'pending_appointment'));
        } else {
            return view('error.403');
        }
    }

    public function upcoming_appointment(User $patient)
    {
        $user = Sentinel::getUser();
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {
            $user_id = Sentinel::getUser()->id;
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            if ($role == 'doctor') {
                $doctor_id = Doctor::where('user_id', $user_id)->pluck('id');
                $Upcoming_appointment = Appointment::where(function ($re) use ($doctor_id) {
                    $re->orWhere('appointment_with', $doctor_id);
                    $re->orWhere('booked_by', $doctor_id);
                })
                    ->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($re) use ($today, $time, $doctor_id) {
                        $re->whereDate('appointment_date', '=', $today);
                        $re->whereTime('available_time', '>=', $time);
                        $re->where(function ($r) use ($doctor_id) {
                            $r->orWhere('appointment_with', $doctor_id);
                            $r->orWhere('booked_by', $doctor_id);
                        });
                    })->where('status', 0)
                    ->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'patient') {
                $Upcoming_appointment = Appointment::with('doctor', 'patient', 'timeSlot')
                    ->where('appointment_for', $user_id)
                    ->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($re) use ($today, $time, $user_id) {
                        $re->whereDate('appointment_date', '=', $today);
                        $re->whereTime('available_time', '>=', $time);
                        $re->where(function ($r) use ($user_id) {
                            $r->where('appointment_for', $user_id);
                        });
                    })->where('status', 0)
                    ->paginate($this->limit);
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $Upcoming_appointment = Appointment::with('patient', 'doctor', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->orWhereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                })
                    ->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($re) use ($today, $time) {
                        $re->whereDate('appointment_date', '=', $today);
                        $re->whereTime('available_time', '>=', $time);
                        $re->Where('status', 0);
                    })->orderBy('id', 'DESC')->paginate($this->limit);
            } else {
                $Upcoming_appointment = Appointment::where('appointment_date', '>', $today)->orWhere(function ($re) use ($today, $time) {
                    $re->whereDate('appointment_date', $today);
                    $re->whereTime('available_time', '>=', $time);
                })
                    ->paginate($this->limit);
            }
            return view('appointment.upcoming-appointment', compact('user', 'role', 'Upcoming_appointment'));
        } else {
            return view('error.403');
        }
    }

    public function complete_appointment(User $patient)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {

            $user_id = Sentinel::getUser()->id;
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            if ($role == 'doctor') {
                $doctor_row_id = Doctor::where('user_id', $user_id)->value('id');
                $doctor_lookup_ids = collect([$doctor_row_id, $user_id])->filter()->unique()->values();
                $Complete_appointment = Appointment::with('doctor.user', 'patient', 'timeSlot')->where(function ($re) use ($doctor_lookup_ids) {
                    $re->whereIn('appointment_with', $doctor_lookup_ids);
                    $re->orWhereIn('booked_by', $doctor_lookup_ids);
                })->where('status', 1)->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'patient') {
                $Complete_appointment = Appointment::with('doctor.user', 'patient', 'timeSlot')->where(['status' => 1, 'appointment_for' => $user_id])->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $receptionists_doctor_user_id = Doctor::whereIn('id', $receptionists_doctor_id)->pluck('user_id');
                $receptionists_lookup_ids = $receptionists_doctor_id->merge($receptionists_doctor_user_id)->filter()->unique()->values();
                $Complete_appointment = Appointment::with('doctor.user', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_lookup_ids) {
                    $re->whereIN('appointment_with', $receptionists_lookup_ids);
                    $re->orWhereIN('booked_by', $receptionists_lookup_ids);
                    $re->orWhere('booked_by', $user_id);
                })->where('status', 1)->orderBy('id', 'DESC')->paginate($this->limit);
            } else {
                $Complete_appointment = Appointment::with('doctor.user', 'patient', 'timeSlot')->where(['status' => 1])->orderBy('id', 'DESC')->paginate($this->limit);
            }

            $appointmentIds = $Complete_appointment->pluck('id');
            $invoiceTotals = collect();
            if ($appointmentIds->isNotEmpty()) {
                try {
                    $invoiceTotals = DB::table('invoices')
                        ->join('invoice_details', 'invoices.id', '=', 'invoice_details.invoice_id')
                        ->whereIn('invoices.appointment_id', $appointmentIds)
                        ->where('invoices.is_deleted', 0)
                        ->where('invoice_details.is_deleted', 0)
                        ->selectRaw('invoices.appointment_id, SUM(invoice_details.amount) as total')
                        ->groupBy('invoices.appointment_id')
                        ->pluck('total', 'appointment_id');
                } catch (\Throwable $e) {
                    Log::error('No se pudieron calcular los totales de facturas para citas completadas', [
                        'message' => $e->getMessage(),
                        'role' => $role,
                        'user_id' => $user_id,
                    ]);
                    $invoiceTotals = collect();
                }
            }

            return view('appointment.complete-appointment', compact('user', 'role', 'Complete_appointment', 'invoiceTotals'));
        } else {
            return view('error.403');
        }
    }

    public function update_final_consultation_price(Request $request, $id)
    {
        $user = Sentinel::getUser();
        if (!$user || !$user->hasAccess('appointment.status')) {
            return response()->json([
                'isSuccess' => false,
                'message' => 'No tiene permisos para actualizar el precio final.'
            ], 403);
        }

        $validated = $request->validate([
            'final_consultation_price' => 'required|numeric|min:0',
        ]);

        $appointment = Appointment::where('id', $id)->where('status', 1)->first();
        if (!$appointment) {
            return response()->json([
                'isSuccess' => false,
                'message' => 'Cita completada no encontrada.'
            ], 404);
        }

        $appointment->final_consultation_price = $validated['final_consultation_price'];
        $appointment->save();

        return response()->json([
            'isSuccess' => true,
            'message' => 'Precio final actualizado correctamente.',
            'final_consultation_price' => (float) $appointment->final_consultation_price,
        ], 200);
    }

    public function cancel_appointment(User $patient)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {
            $user_id = Sentinel::getUser()->id;
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            $admin_role = Sentinel::findRoleBySlug('admin');
            $verify_mail = $user->email;
            $app_name =  AppSetting('title');
            if ($role == 'doctor') {
                $doctor_id = Doctor::where('user_id', $user_id)->pluck('id');
                $Cancel_appointment = Appointment::with('doctor', 'patient', 'timeSlot')
                    ->where(function ($re) use ($doctor_id) {
                        $re->where('appointment_with', $doctor_id);
                        $re->orWhere('booked_by', $doctor_id);
                    })->where('status', 2)
                    ->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'patient') {
                $Cancel_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['status' => 2, 'appointment_for' => $user_id])->paginate($this->limit);
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $Cancel_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                })->where('status', 2)->orderBy('id', 'DESC')->paginate($this->limit);

            } else {
                $Cancel_appointment = Appointment::with('doctor', 'patient')->where('status', 2)->orderBy('id', 'DESC')->paginate($this->limit);
            }
            return view('appointment.cancel-appointment', compact('user', 'role', 'Cancel_appointment'));
        } else {
            return view('error.403');
        }
    }

    public function today_appointment(User $patient)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {
            $user_id = Sentinel::getUser()->id;
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            if ($role == 'doctor') {
                $doctor_id = Doctor::where('user_id', $user_id)->pluck('id');
                $Today_appointment = Appointment::with('doctor', 'patient', 'timeSlot')
                    ->where(function ($re) use ($doctor_id) {
                        $re->where('appointment_with', $doctor_id);
                        $re->orWhere('booked_by', $doctor_id);
                    })
                    ->whereDate('appointment_date', Carbon::today())
                    ->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'patient') {
                $Today_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['appointment_for' => $user_id])->whereDate('appointment_date', Carbon::today())->paginate($this->limit);
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $Today_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    $re->whereIN('appointment_with', $receptionists_doctor_id);
                    $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    $re->orWhere('booked_by', $user_id);
                })->whereDate('appointment_date', Carbon::today())->orderBy('id', 'DESC')->paginate($this->limit);
            } else {
                $Today_appointment = Appointment::with('doctor', 'patient')->whereDate('appointment_date', Carbon::today())->orderBy('id', 'DESC')->paginate($this->limit);
            }
            return view('appointment.today-appointment', compact('user', 'role', 'Today_appointment'));
        } else {
            return view('error.403');
        }
    }

    public function patient_appointment()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('patient-appointment.list')) {
            $role = $user->roles[0]->slug;
            $user_id = Sentinel::getUser()->id;
            $appointment = Appointment::with('doctor', 'timeSlot')->where(['appointment_for' => $user_id])->orderBy('id', 'DESC')->paginate($this->limit);
            return view('patient.patient-appointment', compact('appointment', 'user', 'role'));
        } else {
            return view('error.403');
        }
    }

    public function appointment_view($id)
    {
        $user = Sentinel::getUser();
        if (!$user || !$user->hasAccess('appointment.list')) {
            return view('error.403');
        }

        $role = $user->roles[0]->slug;
        $userId = $user->id;

        $query = Appointment::with(['patient', 'doctor.user', 'BookedBy', 'timeSlot', 'dentalEvaluation.images']);

        if ($role == 'doctor') {
            $doctorId = Doctor::where('user_id', $userId)->value('id');
            $query->where(function ($q) use ($doctorId) {
                $q->where('appointment_with', $doctorId)
                    ->orWhere('booked_by', $doctorId);
            });
        } elseif ($role == 'patient') {
            $query->where('appointment_for', $userId);
        } elseif ($role == 'receptionist') {
            $receptionistsDoctorIds = ReceptionListDoctor::where('reception_id', $userId)->pluck('doctor_id');
            $query->where(function ($q) use ($userId, $receptionistsDoctorIds) {
                $q->whereIn('appointment_with', $receptionistsDoctorIds)
                    ->orWhereIn('booked_by', $receptionistsDoctorIds)
                    ->orWhere('booked_by', $userId);
            });
        }

        $appointment = $query->where('id', $id)->first();
        if (!$appointment) {
            return redirect()->back()->with('error', 'Cita no encontrada o sin permisos para verla.');
        }

        $previousEvaluation = DentalEvaluation::query()
            ->select('dental_evaluations.*')
            ->join('appointments as previous_appointments', 'previous_appointments.id', '=', 'dental_evaluations.appointment_id')
            ->where('dental_evaluations.patient_id', $appointment->appointment_for)
            ->where('dental_evaluations.appointment_id', '<>', $appointment->id)
            ->where('previous_appointments.status', 1)
            ->whereDate('previous_appointments.appointment_date', '<=', $appointment->appointment_date)
            ->orderByDesc('previous_appointments.appointment_date')
            ->orderByDesc('previous_appointments.id')
            ->first();

        return view('appointment.appointment-view', compact('user', 'role', 'appointment', 'previousEvaluation'));
    }

    public function saveDentalEvaluation(Request $request, $id)
    {
        $user = Sentinel::getUser();
        if (!$user || !$user->hasAccess('appointment.list')) {
            return view('error.403');
        }

        $appointment = Appointment::find($id);
        if (!$appointment) {
            return redirect()->back()->with('error', 'Cita no encontrada.');
        }

        $role = $user->roles[0]->slug;
        if ((int) $appointment->status === 1) {
            return redirect()->back()->with('error', 'La historia de una cita finalizada es de solo lectura.');
        }
        if ($role === 'doctor') {
            $doctorId = Doctor::where('user_id', $user->id)->value('id');
            if ((int) $appointment->appointment_with !== (int) $doctorId) {
                return view('error.403');
            }
        }

        $validated = $request->validate([
            'diagnosis' => 'nullable|string|max:5000',
            'diagnosis_items' => 'nullable|array',
            'diagnosis_items.*.diagnosis' => 'nullable|string|max:1000',
            'diagnosis_items.*.treatment' => 'nullable|string|max:1000',
            'diagnosis_items.*.quantity' => 'nullable|numeric|min:0',
            'diagnosis_items.*.value' => 'nullable|numeric|min:0',
            'treatment' => 'nullable|string|max:5000',
            'quantity' => 'nullable|numeric|min:0',
            'value' => 'nullable|numeric|min:0',
            'clinical_notes' => 'nullable|string|max:10000',
            'tooth_marks' => 'nullable|string',
            'photos' => 'nullable|array|max:10',
            'photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $toothMarks = [];
        if (!empty($validated['tooth_marks'])) {
            $toothMarks = json_decode($validated['tooth_marks'], true);
            if (!is_array($toothMarks)) {
                return redirect()->back()->withErrors(['tooth_marks' => 'El odontograma no tiene un formato válido.'])->withInput();
            }

            $validTeeth = [18, 17, 16, 15, 14, 13, 12, 11, 21, 22, 23, 24, 25, 26, 27, 28, 48, 47, 46, 45, 44, 43, 42, 41, 31, 32, 33, 34, 35, 36, 37, 38];
            $toothMarks = collect($toothMarks)->filter(function ($mark, $tooth) use ($validTeeth) {
                return in_array((int) $tooth, $validTeeth, true) && in_array($mark, ['affected', 'worked'], true);
            })->all();
        }

        $diagnosisItems = collect($validated['diagnosis_items'] ?? [])
            ->filter(function ($item) {
                return trim((string) ($item['diagnosis'] ?? '')) !== '';
            })
            ->map(function ($item) {
                $quantity = (float) ($item['quantity'] ?? 0);
                $value = (float) ($item['value'] ?? 0);
                return [
                    'diagnosis' => trim((string) ($item['diagnosis'] ?? '')),
                    'treatment' => trim((string) ($item['treatment'] ?? '')),
                    'quantity' => $quantity,
                    'value' => $value,
                    'subtotal' => round($quantity * $value, 2),
                ];
            })->values()->all();
        $total = collect($diagnosisItems)->sum('subtotal');

        if ($request->boolean('complete') && empty($diagnosisItems) && blank($validated['diagnosis'] ?? null)) {
            return redirect()->back()->withErrors(['diagnosis' => 'Registra al menos un diagnóstico antes de finalizar la cita.'])->withInput();
        }

        $evaluation = DentalEvaluation::updateOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'patient_id' => $appointment->appointment_for,
                'doctor_id' => $appointment->appointment_with,
                'diagnosis' => $validated['diagnosis'] ?? null,
                'diagnosis_items' => $diagnosisItems,
                'treatment' => $validated['treatment'] ?? null,
                'quantity' => $validated['quantity'] ?? null,
                'value' => $validated['value'] ?? null,
                'clinical_notes' => $validated['clinical_notes'] ?? null,
                'tooth_marks' => $toothMarks,
            ]
        );

        $appointment->final_consultation_price = $total > 0 ? $total : ($validated['value'] ?? null);
        if ($request->boolean('complete')) {
            $appointment->status = 1;
        }
        $appointment->save();

        if ($request->hasFile('photos')) {
            $directory = public_path('storage/images/dental-evaluations');
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            foreach ($request->file('photos') as $photo) {
                $filename = Str::uuid() . '.' . $photo->getClientOriginalExtension();
                $photo->move($directory, $filename);
                $evaluation->images()->create([
                    'path' => 'images/dental-evaluations/' . $filename,
                    'original_name' => $photo->getClientOriginalName(),
                ]);
            }
        }

        if ($request->boolean('complete')) {
            $this->sendAppointmentSummary($appointment->fresh(['patient', 'doctor.user', 'timeSlot', 'dentalEvaluation']));
        }

        return redirect()->back()->with('success', $request->boolean('complete')
            ? 'Historia guardada y cita completada correctamente.'
            : 'Historia Dental guardada correctamente.');
    }

    public function sendDentalEvaluationEmail($id)
    {
        $user = Sentinel::getUser();
        if (!$user || !$user->hasAccess('appointment.list')) {
            return view('error.403');
        }

        $appointment = Appointment::with(['patient', 'doctor.user', 'timeSlot', 'dentalEvaluation'])
            ->findOrFail($id);
        if (!$appointment->dentalEvaluation) {
            return redirect()->back()->with('error', 'La cita todavía no tiene diagnóstico registrado.');
        }

        try {
            $this->sendAppointmentSummary($appointment);
        } catch (\Throwable $mailError) {
            Log::error('No se pudo enviar el resumen de la cita por correo.', [
                'appointment_id' => $appointment->id,
                'error' => $mailError->getMessage(),
            ]);

            return redirect()->back()->with('error', 'No se pudo enviar el correo. Verifica la contraseña SMTP de Hostinger.');
        }

        return redirect()->back()->with('success', 'El diagnóstico y el detalle de la consulta fueron enviados por correo.');
    }

    public function appointmentBudgetView($id)
    {
        $user = Sentinel::getUser();
        if (!$user || !$user->hasAccess('appointment.list')) {
            return view('error.403');
        }

        $appointment = Appointment::with(['patient', 'doctor.user', 'timeSlot', 'dentalEvaluation'])
            ->findOrFail($id);

        $items = $appointment->dentalEvaluation && is_array($appointment->dentalEvaluation->diagnosis_items)
            ? $appointment->dentalEvaluation->diagnosis_items
            : [];

        $total = (float) ($appointment->final_consultation_price ?? collect($items)->sum('subtotal'));

        return view('appointment.appointment-budget', compact('appointment', 'items', 'total'));
    }

    public function appointmentBudgetWhatsApp($id)
    {
        $user = Sentinel::getUser();
        if (!$user || !$user->hasAccess('appointment.list')) {
            return view('error.403');
        }

        $appointment = Appointment::with(['patient', 'doctor.user', 'dentalEvaluation'])
            ->findOrFail($id);

        $mobile = $this->sanitizeWhatsappNumber(optional($appointment->patient)->mobile);
        if (!$mobile) {
            return redirect()->back()->with('error', 'El paciente no tiene un número de WhatsApp registrado.');
        }

        $message = $this->buildBudgetMessage($appointment);
        $encodedMessage = urlencode($message);

        return redirect()->away('https://wa.me/' . $mobile . '?text=' . $encodedMessage);
    }

    private function sanitizeWhatsappNumber(?string $number): ?string
    {
        if (blank($number)) {
            return null;
        }

        $clean = preg_replace('/[^0-9]/', '', $number);
        if (strlen($clean) >= 9) {
            return ltrim($clean, '0');
        }

        return null;
    }

    private function buildBudgetMessage(Appointment $appointment): string
    {
        $patientName = trim(optional($appointment->patient)->first_name . ' ' . optional($appointment->patient)->last_name);
        $doctorName = trim(optional(optional($appointment->doctor)->user)->first_name . ' ' . optional(optional($appointment->doctor)->user)->last_name);
        $items = $appointment->dentalEvaluation && is_array($appointment->dentalEvaluation->diagnosis_items)
            ? $appointment->dentalEvaluation->diagnosis_items
            : [];
        $total = (float) ($appointment->final_consultation_price ?? collect($items)->sum('subtotal'));

        $lines = [
            'Presupuesto final de consulta',
            'Paciente: ' . ($patientName ?: 'No especificado'),
            'Odontólogo: ' . ($doctorName ?: 'No especificado'),
            'Fecha: ' . ($appointment->appointment_date ?: 'Sin fecha'),
            '',
            'Detalle:',
        ];

        if (empty($items)) {
            $lines[] = 'Sin diagnósticos registrados.';
        } else {
            foreach ($items as $item) {
                $diagnosis = $item['diagnosis'] ?? 'Servicio';
                $treatment = $item['treatment'] ?? '';
                $quantity = (float) ($item['quantity'] ?? 1);
                $value = (float) ($item['value'] ?? 0);
                $subtotal = (float) ($item['subtotal'] ?? ($quantity * $value));
                $summary = $diagnosis . (($treatment !== '') ? ' - ' . $treatment : '');
                $lines[] = '- ' . $summary . ': ' . number_format($quantity, 2, '.', '') . ' x ' . number_format($value, 2, '.', '') . ' = $' . number_format($subtotal, 2, '.', ',');
            }
        }

        $lines[] = '';
        $lines[] = 'Total: $' . number_format($total, 2, '.', ',');

        return implode("\n", $lines);
    }

    private function sendAppointmentSummary(Appointment $appointment): void
    {
        $recipients = collect([optional($appointment->patient)->email, optional($appointment->doctor->user)->email])
            ->merge(User::whereHas('roles', function ($query) {
                $query->where('slug', 'admin');
            })->pluck('email'))
            ->filter(function ($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL) && !str_ends_with($email, '@no-email.local');
            })->unique()->values()->all();

        if (empty($recipients)) {
            return;
        }

        Mail::send('emails/appointment_summary', ['appointment' => $appointment], function ($message) use ($recipients) {
            $message->to($recipients)->subject(AppSetting('title') . ' - Diagnóstico y detalle de consulta');
        });
    }
}
