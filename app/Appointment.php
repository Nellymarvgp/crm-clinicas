<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $fillable = [
        'appointment_for',
        'appointment_with',
        'appointment_date',
        'appointment_time',
        'booked_by',
        'status',
        'available_slots',
        'final_consultation_price',
        'is_deleted',
    ];
    protected $appends = ['status_label'];

    public function getStatusLabelAttribute(): string
    {
        return match ((int) $this->status) {
            1 => 'Completada',
            2 => 'Cancelada',
            default => 'Pendiente',
        };
    }

    function patient()
    {
        return $this->hasOne(User::class, 'id', 'appointment_for');
    }
    function BookedBy()
    {
        return $this->hasOne(User::class, 'id', 'booked_by');
    }

    function doctor()
    {
        return $this->hasOne(Doctor::class, 'id', 'appointment_with');
    }

    function receptionlist_doctor()
    {
        return $this->hasMany(ReceptionListDoctor::class, 'doctor_id', 'appointment_with');
    }

    function timeSlot()
    {
        return $this->hasOne(DoctorAvailableSlot::class, 'id', 'available_slot');
    }

    public function getTimeRangeLabelAttribute(): string
    {
        $slotIds = json_decode($this->available_slots ?: '[]', true);
        $slotIds = is_array($slotIds) ? array_values(array_filter(array_map('intval', $slotIds))) : [];

        if (empty($slotIds) && $this->available_slot) {
            $slotIds = [(int) $this->available_slot];
        }

        $slots = DoctorAvailableSlot::whereIn('id', $slotIds)->get(['from', 'to']);
        $start = $slots->min('from');
        $end = $slots->max('to');

        if (!$start || !$end) {
            return 'Sin horario';
        }

        return \Carbon\Carbon::parse($start)->format('h:ia') . ' a ' .
            \Carbon\Carbon::parse($end)->format('h:ia');
    }

    function invoice(){
        return $this->hasOne(Invoice::class)->where('payment_status','Paid');
    }
    function prescription(){
        return $this->hasOne(Prescription::class)->where('is_deleted',0);
    }

    function dentalEvaluation()
    {
        return $this->hasOne(DentalEvaluation::class);
    }
}
