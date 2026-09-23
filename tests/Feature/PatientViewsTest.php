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

        \Illuminate\Support\Facades\DB::statement('CREATE TABLE IF NOT EXISTS app_setting (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, favicon TEXT, footer_left TEXT, footer_right TEXT);');
        \Illuminate\Support\Facades\DB::table('app_setting')->truncate();
        \Illuminate\Support\Facades\DB::table('app_setting')->insert([
            'title' => 'CORE',
            'favicon' => 'favicon.ico',
            'footer_left' => 'CORE Centro Odontológico',
            'footer_right' => 'info@corecentrove.com | centrocore.ve@gmail.com',
        ]);
    }

    public function test_overlap_check_blocks_already_booked_slot(): void
    {
        $controller = new \App\Http\Controllers\PublicAppointmentController();
        $method = new \ReflectionMethod($controller, 'slotRangeOverlapsBookedRange');
        $method->setAccessible(true);

        $slotStart = strtotime('2026-09-22 09:30:00');
        $slotEnd = strtotime('2026-09-22 10:30:00');
        $bookedRange = ['from' => '2026-09-22 09:00:00', 'to' => '2026-09-22 10:00:00'];

        $this->assertTrue($method->invoke($controller, $slotStart, $slotEnd, $bookedRange));
    }

    public function test_patient_list_view_contains_search_by_name_and_cedula(): void
    {
        $user = (object) ['id' => 1, 'first_name' => 'Ana', 'last_name' => 'García'];

        $html = View::make('patient.patients', [
            'user' => (object) [
                'id' => 1,
                'first_name' => 'Ana',
                'last_name' => 'García',
                'profile_photo' => null,
                'roles' => [(object) ['slug' => 'admin']],
            ],
            'role' => 'admin',
            'patients' => collect(),
            'Cnotification_count' => collect(),
        ])->render();

        $this->assertStringContainsString('Cédula', $html);
        $this->assertStringContainsString('Buscar por nombre, apellido o cédula', $html);
    }

    public function test_public_appointment_form_includes_half_hour_duration_option(): void
    {
        $html = View::make('public.appointments.create', [
            'doctors' => collect(),
            'selectedDoctor' => null,
            'selectedDoctorId' => null,
            'user' => (object) ['first_name' => 'Visitante', 'profile_photo' => null],
            'Cnotification_count' => collect(),
        ])->render();

        $this->assertStringContainsString('value="30"', $html);
        $this->assertStringContainsString('Media hora', $html);
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
            'user' => (object) [
                'id' => 1,
                'first_name' => 'Ana',
                'last_name' => 'García',
                'profile_photo' => null,
                'roles' => [(object) ['slug' => 'admin']],
            ],
            'role' => 'admin',
            'patient' => $patient,
            'patient_info' => $patientInfo,
            'medical_Info' => $medicalInfo,
            'data' => ['total_appointment' => 0, 'revenue' => 0, 'pending_bill' => 0],
            'appointments' => collect(),
            'prescriptions' => new LengthAwarePaginator([], 0, 10),
            'invoices' => new LengthAwarePaginator([], 0, 10),
            'Cnotification_count' => collect(),
        ])->render();

        $this->assertStringContainsString('Historia Dental', $html);
        $this->assertStringContainsString('Odontograma', $html);
    }
}
