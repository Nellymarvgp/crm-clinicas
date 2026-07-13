<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TestAppointmentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Verificar si ya hay doctores en el sistema
        $doctors = DB::table('doctors')->get();
        
        if ($doctors->isEmpty()) {
            // Insertar usuarios para los doctores de prueba
            $doctorUsers = [
                [
                    'first_name' => 'Juan',
                    'last_name' => 'Pérez',
                    'email' => 'juan.perez@doctor.com',
                    'password' => bcrypt('password'),
                    'mobile' => '1234567890',
                    'is_deleted' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'first_name' => 'María',
                    'last_name' => 'González',
                    'email' => 'maria.gonzalez@doctor.com',
                    'password' => bcrypt('password'),
                    'mobile' => '0987654321',
                    'is_deleted' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'first_name' => 'Carlos',
                    'last_name' => 'Rodríguez',
                    'email' => 'carlos.rodriguez@doctor.com',
                    'password' => bcrypt('password'),
                    'mobile' => '5678901234',
                    'is_deleted' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            ];
            
            $doctorUserIds = [];
            foreach ($doctorUsers as $user) {
                $userId = DB::table('users')->insertGetId($user);
                $doctorUserIds[] = $userId;
                
                // Asignar rol de doctor (2)
                DB::table('role_users')->insert([
                    'user_id' => $userId,
                    'role_id' => 2,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            
            // Insertar departamentos si no existen
            $departmentId = DB::table('departments')->first();
            if (!$departmentId) {
                $departmentId = DB::table('departments')->insertGetId([
                    'name' => 'Medicina General',
                    'is_deleted' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                $departmentId = $departmentId->id;
            }
            
            // Insertar doctores
            $doctorIds = [];
            foreach ($doctorUserIds as $userId) {
                $doctorId = DB::table('doctors')->insertGetId([
                    'user_id' => $userId,
                    'department_id' => $departmentId,
                    'experience' => rand(2, 15) . ' años',
                    'is_deleted' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                $doctorIds[] = $doctorId;
            }
        } else {
            // Usar doctores existentes
            $doctorIds = $doctors->pluck('id')->toArray();
        }
        
        // Limpiar configuraciones de disponibilidad existentes para los doctores
        DB::table('doctor_available_days')->whereIn('doctor_id', $doctorIds)->delete();
        DB::table('doctor_available_times')->whereIn('doctor_id', $doctorIds)->delete();
        
        // Configurar días disponibles para cada doctor
        foreach ($doctorIds as $index => $doctorId) {
            // Diferentes patrones de días disponibles para cada doctor
            switch ($index % 3) {
                case 0:
                    // Lunes, Miércoles, Viernes
                    DB::table('doctor_available_days')->insert([
                        'doctor_id' => $doctorId,
                        'mon' => 1,
                        'tue' => 0,
                        'wed' => 1,
                        'thu' => 0,
                        'fri' => 1,
                        'sat' => 0,
                        'sun' => 0,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    break;
                case 1:
                    // Martes, Jueves, Sábado
                    DB::table('doctor_available_days')->insert([
                        'doctor_id' => $doctorId,
                        'mon' => 0,
                        'tue' => 1,
                        'wed' => 0,
                        'thu' => 1,
                        'fri' => 0,
                        'sat' => 1,
                        'sun' => 0,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    break;
                case 2:
                    // Lunes a Viernes
                    DB::table('doctor_available_days')->insert([
                        'doctor_id' => $doctorId,
                        'mon' => 1,
                        'tue' => 1,
                        'wed' => 1,
                        'thu' => 1,
                        'fri' => 1,
                        'sat' => 0,
                        'sun' => 0,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    break;
            }
            
            // Configurar horarios disponibles para los días correspondientes
            switch ($index % 3) {
                case 0:
                    // Para Lunes, Miércoles, Viernes
                    foreach ([1, 3, 5] as $dayOfWeek) {
                        DB::table('doctor_available_times')->insert([
                            'doctor_id' => $doctorId,
                            'day_of_week' => $dayOfWeek,
                            'from' => '09:00',
                            'to' => '13:00',
                            'is_deleted' => 0,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                        
                        DB::table('doctor_available_times')->insert([
                            'doctor_id' => $doctorId,
                            'day_of_week' => $dayOfWeek,
                            'from' => '14:00',
                            'to' => '18:00',
                            'is_deleted' => 0,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                    break;
                case 1:
                    // Para Martes, Jueves, Sábado
                    foreach ([2, 4, 6] as $dayOfWeek) {
                        DB::table('doctor_available_times')->insert([
                            'doctor_id' => $doctorId,
                            'day_of_week' => $dayOfWeek,
                            'from' => '08:00',
                            'to' => '12:00',
                            'is_deleted' => 0,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                        
                        if ($dayOfWeek != 6) { // No tardes los sábados
                            DB::table('doctor_available_times')->insert([
                                'doctor_id' => $doctorId,
                                'day_of_week' => $dayOfWeek,
                                'from' => '15:00',
                                'to' => '19:00',
                                'is_deleted' => 0,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                        }
                    }
                    break;
                case 2:
                    // Para Lunes a Viernes
                    foreach ([1, 2, 3, 4, 5] as $dayOfWeek) {
                        DB::table('doctor_available_times')->insert([
                            'doctor_id' => $doctorId,
                            'day_of_week' => $dayOfWeek,
                            'from' => '10:00',
                            'to' => '14:00',
                            'is_deleted' => 0,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                        
                        DB::table('doctor_available_times')->insert([
                            'doctor_id' => $doctorId,
                            'day_of_week' => $dayOfWeek,
                            'from' => '16:00',
                            'to' => '20:00',
                            'is_deleted' => 0,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                    break;
            }
            
            // Crear slots disponibles
            $availableTimes = DB::table('doctor_available_times')
                                ->where('doctor_id', $doctorId)
                                ->get();
            
            foreach ($availableTimes as $time) {
                DB::table('doctor_available_slots')->insert([
                    'doctor_id' => $doctorId,
                    'doctor_available_id' => $time->id,
                    'from' => $time->from,
                    'to' => $time->to,
                    'is_deleted' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
        
        $this->command->info('Datos de prueba para citas han sido insertados correctamente.');
    }
}
