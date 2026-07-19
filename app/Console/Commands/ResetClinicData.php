<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetClinicData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clinic:reset-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpia datos clinicos y deja solo especialidades y un doctor base';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $doctorUserIds = DB::table('doctors')->pluck('user_id')->toArray();
            $patientUserIds = DB::table('patients')->pluck('user_id')->toArray();
            $cleanupUserIds = array_values(array_unique(array_merge($doctorUserIds, $patientUserIds)));

            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            $tablesToTruncate = [
                'appointments',
                'prescriptions',
                'medicines',
                'test_reports',
                'invoice_details',
                'invoices',
                'transactions',
                'payment_apis',
                'notifications',
                'reception_list_doctors',
                'doctor_available_slots',
                'doctor_available_times',
                'doctor_available_days',
                'medical_infos',
                'patients',
                'doctors',
                'call_settings',
            ];

            foreach ($tablesToTruncate as $table) {
                if (DB::getSchemaBuilder()->hasTable($table)) {
                    DB::table($table)->truncate();
                }
            }

            if (!empty($cleanupUserIds)) {
                DB::table('role_users')->whereIn('user_id', $cleanupUserIds)->delete();
                DB::table('activations')->whereIn('user_id', $cleanupUserIds)->delete();
                DB::table('persistences')->whereIn('user_id', $cleanupUserIds)->delete();
                DB::table('reminders')->whereIn('user_id', $cleanupUserIds)->delete();
                DB::table('throttle')->whereIn('user_id', $cleanupUserIds)->delete();
                DB::table('users')->whereIn('id', $cleanupUserIds)->delete();
            }

            DB::table('departments')->truncate();

            $departments = [
                [
                    'name' => 'Rehabilitación Oral',
                    'description' => 'Especialidad enfocada en recuperar función, estética y salud integral de la sonrisa.',
                ],
                [
                    'name' => 'Diseño de Sonrisa',
                    'description' => 'Planificación estética personalizada para armonizar tu sonrisa con tu rostro.',
                ],
                [
                    'name' => 'Ortodoncia',
                    'description' => 'Corrección de la posición dental y mordida para lograr una sonrisa funcional y saludable.',
                ],
                [
                    'name' => 'Cirugía',
                    'description' => 'Procedimientos quirúrgicos odontológicos seguros para resolver casos complejos con precisión.',
                ],
            ];

            $departmentIds = [];
            foreach ($departments as $department) {
                $departmentIds[$department['name']] = DB::table('departments')->insertGetId([
                    'name' => $department['name'],
                    'description' => $department['description'],
                    'is_deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $doctorEmail = 'dr.jesus@corecentro.test';
            $doctorId = DB::table('users')->where('email', $doctorEmail)->value('id');

            if (!$doctorId) {
                $doctorId = DB::table('users')->insertGetId([
                    'first_name' => 'Jesus',
                    'last_name' => 'Rodriguez',
                    'mobile' => '04120000000',
                    'profile_photo' => null,
                    'email' => $doctorEmail,
                    'password' => Hash::make('12345678'),
                    'created_by' => 'system',
                    'updated_by' => 'system',
                    'permissions' => null,
                    'last_login' => null,
                    'is_deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $doctorRoleId = DB::table('roles')->where('slug', 'doctor')->value('id');
            if ($doctorRoleId) {
                DB::table('role_users')->updateOrInsert(
                    ['user_id' => $doctorId, 'role_id' => $doctorRoleId],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }

            DB::table('doctors')->insert([
                'user_id' => $doctorId,
                'department_id' => $departmentIds['Rehabilitación Oral'],
                'title' => 'Dr.',
                'fees' => '50',
                'degree' => 'Odontólogo especialista en Rehabilitación oral y estética (perfil de prueba)',
                'experience' => '8 años de experiencia clínica en rehabilitación oral, estética y planificación integral de tratamientos.',
                'slot_time' => 30,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            $this->info('Base de datos limpiada correctamente.');
            $this->line('Especialidades activas: 4');
            $this->line('Especialista de prueba: Dr. Jesus Rodriguez');
            $this->line('Usuario: dr.jesus@corecentro.test');
            $this->line('Clave temporal: 12345678');
        } catch (\Throwable $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            $this->error('Error durante limpieza: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
