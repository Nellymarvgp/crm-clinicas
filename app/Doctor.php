<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';

    protected $fillable = [
        'user_id',
        'department_id',
        'title',
        'fees',
        'doctor_payment_percentage',
        'degree',
        'experience',
        'slot_time',
        'is_deleted',
    ];

    function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
    function department() {
        return $this->hasOne(Departments::class, 'id', 'department_id');
    }

    public function departments()
    {
        return $this->belongsToMany(Departments::class, 'doctor_departments', 'doctor_id', 'department_id')->withTimestamps();
    }

    public function availableDays()
    {
        return $this->hasOne(DoctorAvailableDays::class, 'doctor_id');
    }

    public function availableTimes()
    {
        return $this->hasMany(DoctorAvailableTimes::class, 'doctor_id')->where('is_deleted', 0);
    }
}
