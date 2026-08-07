<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalInfo extends Model
{
    protected $table = 'medical_infos';

    protected $fillable = [
        'user_id',
        'height',
        'weight',
        'b_group',
        'b_pressure',
        'pulse',
        'respiration',
        'allergy',
        'diet',
        'diabetes_status',
        'diabetes_controlled',
        'hypertension_status',
        'hypertension_controlled',
        'currently_pregnant',
        'heart_attack_history',
        'last_heart_attack',
        'takes_medications',
        'medications_list',
        'aspirin_last_72h',
        'has_disease',
        'disease_details',
        'is_deleted',
    ];
}
