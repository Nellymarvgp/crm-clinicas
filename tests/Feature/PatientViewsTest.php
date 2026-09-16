<?php

namespace Tests\Feature;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class PatientViewsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        \Illuminate\Support\Facades\DB::statement('CREATE TABLE IF NOT EXISTS app_setting (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT);');
        \Illuminate\Support\Facades\DB::table('app_setting')->insert(['title' => 'CORE']);
    }

    public function test_patient_list_view_contains_cedula_column_and_filter(): void
    {
        $user = (object) ['id' => 1, 'first_name' => 'Ana', 'last_name' => 'García'];

        $html = View::make('patient.patients', [
            'user' => $user,
            'role' => 'admin',
            'patients' => collect(),
        ])->render();

        $this->assertStringContainsString('Cédula', $html);
        $this->assertStringContainsString('Buscar por cédula', $html);
    }

    public function test_patient_profile_view_contains_dental_history_and_odontogram_sections(): void
    {
        $patient = (object) [
            'id' => 2,
            'first_name' => 'Luis',
            'last_name' => 'Pérez',
            'profile_photo' => null,
            'cedula' => '12345678',
            'mobile' => '04121234567',
            'email' => 'luis@example.com',
            'last_login' => '2026-09-16',
        ];

        $patientInfo = (object) [
            'age' => 30,
            'gender' => 'male',
            'address' => 'Caracas',
        ];

        $medicalInfo = (object) [
            'height' => '170',
            'weight' => '70',
            'b_group' => 'O+',
            'b_pressure' => '120/80',
            'pulse' => '72',
            'respiration' => '18',
            'allergy' => 'Ninguna',
            'diet' => 'Vegetarian',
            'diabetes_status' => 'no',
            'diabetes_controlled' => 'no',
            'hypertension_status' => 'no',
            'hypertension_controlled' => 'no',
            'currently_pregnant' => 'no',
            'heart_attack_history' => 'no',
            'last_heart_attack' => '',
            'takes_medications' => 'no',
            'medications_list' => '',
            'aspirin_last_72h' => 'no',
            'has_disease' => 'no',
            'disease_details' => '',
        ];

        $html = View::make('patient.patient-profile', [
            'user' => (object) ['id' => 1, 'roles' => [(object) ['slug' => 'admin']]],
            'role' => 'admin',
            'patient' => $patient,
            'patient_info' => $patientInfo,
            'medical_Info' => $medicalInfo,
            'data' => ['total_appointment' => 0, 'revenue' => 0, 'pending_bill' => 0],
            'appointments' => collect(),
            'prescriptions' => new LengthAwarePaginator([], 0, 10),
            'invoices' => new LengthAwarePaginator([], 0, 10),
        ])->render();

        $this->assertStringContainsString('Historia Dental', $html);
        $this->assertStringContainsString('Odontograma', $html);
    }
}
