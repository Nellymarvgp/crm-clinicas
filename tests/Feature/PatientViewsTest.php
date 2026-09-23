<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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

    public function test_selected_day_time_is_used_for_overlap_validation(): void
    {
        $controller = new \App\Http\Controllers\PublicAppointmentController();
        $buildMethod = new \ReflectionMethod($controller, 'buildDateTimeFromTimeString');
        $buildMethod->setAccessible(true);

        $slotStart = $buildMethod->invoke($controller, '2026-10-15', '09:30');
        $slotEnd = $slotStart + (60 * 60);
        $bookedRange = ['from' => '2026-10-15 09:00:00', 'to' => '2026-10-15 10:00:00'];

        $method = new \ReflectionMethod($controller, 'slotRangeOverlapsBookedRange');
        $method->setAccessible(true);

        $this->assertTrue($method->invoke($controller, $slotStart, $slotEnd, $bookedRange));
    }

    public function test_completed_appointments_still_block_available_slots(): void
    {
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('doctor_available_slots');
        Schema::create('doctor_available_slots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id');
            $table->string('from');
            $table->string('to');
            $table->boolean('is_deleted')->default(false);
        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appointment_with');
            $table->date('appointment_date');
            $table->integer('status')->default(0);
            $table->boolean('is_deleted')->default(false);
            $table->integer('available_slot')->nullable();
            $table->text('available_slots')->nullable();
        });

        DB::table('doctor_available_slots')->insert([
            ['id' => 101, 'doctor_id' => 7, 'from' => '09:00', 'to' => '09:30', 'is_deleted' => false],
        ]);

        DB::table('appointments')->insert([
            [
                'appointment_with' => 7,
                'appointment_date' => '2026-10-15',
                'status' => 1,
                'is_deleted' => 0,
                'available_slot' => 101,
                'available_slots' => null,
            ],
        ]);

        $controller = new \App\Http\Controllers\PublicAppointmentController();
        $method = new \ReflectionMethod($controller, 'getBookedAppointmentRanges');
        $method->setAccessible(true);

        $result = $method->invoke($controller, [7], '2026-10-15');

        $this->assertNotEmpty($result);
        $this->assertSame('2026-10-15 09:00', $result[0]['from']);
        $this->assertSame('2026-10-15 09:30', $result[0]['to']);
    }

    public function test_internal_appointment_store_rejects_duplicate_slot_for_same_doctor_and_date(): void
    {
        Schema::dropIfExists('appointments');
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appointment_with');
            $table->date('appointment_date');
            $table->integer('status')->default(0);
            $table->boolean('is_deleted')->default(false);
            $table->integer('available_slot')->nullable();
            $table->text('available_slots')->nullable();
        });

        DB::table('appointments')->insert([
            [
                'appointment_with' => 12,
                'appointment_date' => '2026-10-15',
                'status' => 0,
                'is_deleted' => 0,
                'available_slot' => 44,
                'available_slots' => '[44]',
            ],
        ]);

        $controller = new \App\Http\Controllers\AppointmentController();
        $method = new \ReflectionMethod($controller, 'getBookedSlotIdsForDoctorAndDate');
        $method->setAccessible(true);

        $booked = $method->invoke($controller, 12, '2026-10-15');

        $this->assertTrue($booked->contains(44));

        $ensureMethod = new \ReflectionMethod($controller, 'ensureDoctorSlotIsAvailable');
        $ensureMethod->setAccessible(true);

        $this->expectException(\Exception::class);
        $ensureMethod->invoke($controller, 12, '2026-10-15', 44);
    }

    public function test_booking_keeps_existing_email_when_another_user_already_has_it(): void
    {
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cedula')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('mobile')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        $userWithEmail = User::create([
            'cedula' => '11111111',
            'first_name' => 'Ana',
            'last_name' => 'Pérez',
            'email' => 'otro@correo.com',
            'mobile' => '04140000000',
        ]);

        $existingUser = User::create([
            'cedula' => '22222222',
            'first_name' => 'Luis',
            'last_name' => 'Gómez',
            'email' => 'luis@correo.com',
            'mobile' => '04141111111',
        ]);

        $controller = new \App\Http\Controllers\PublicAppointmentController();
        $method = new \ReflectionMethod($controller, 'resolveBookingUserEmail');
        $method->setAccessible(true);

        $request = new Request([
            'email' => 'otro@correo.com',
            'cedula' => '22222222',
        ]);

        $resolvedEmail = $method->invoke($controller, $request, $existingUser);

        $this->assertSame('luis@correo.com', $resolvedEmail);
        $this->assertSame('luis@correo.com', $existingUser->fresh()->email);
        $this->assertNotSame('otro@correo.com', $existingUser->fresh()->email);
        $this->assertSame('otro@correo.com', $userWithEmail->fresh()->email);
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
