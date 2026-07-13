<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorAvailableTimes extends Model
{
    protected $table = 'doctor_available_times';

    protected $fillable = [
        'doctor_id',
        'day_of_week',
        'from',
        'to',
        'is_deleted'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
