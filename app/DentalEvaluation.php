<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DentalEvaluation extends Model
{
    protected $table = 'dental_evaluations';

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_id',
        'diagnosis',
        'treatment',
        'quantity',
        'value',
        'clinical_notes',
        'tooth_marks',
    ];

    protected $casts = [
        'tooth_marks' => 'array',
        'quantity' => 'decimal:2',
        'value' => 'decimal:2',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function images()
    {
        return $this->hasMany(DentalEvaluationImage::class, 'dental_evaluation_id');
    }
}
