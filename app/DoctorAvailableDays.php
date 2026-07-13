<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorAvailableDays extends Model
{
    protected $table = 'doctor_available_days';

    protected $fillable = [
        'doctor_id',
        'mon',
        'tue',
        'wed',
        'thu',
        'fri',
        'sat',
        'sun'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
