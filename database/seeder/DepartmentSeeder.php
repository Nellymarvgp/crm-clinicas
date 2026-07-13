<?php

// namespace Database\Seeders;

use App\Departments;
use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hospitalDepartments = [
            [
                'name' => 'Rehabilitación oral',
                'description' => 'Restauramos función, estética y comodidad en cada sonrisa.',
            ],
            [
                'name' => 'Odontología estética',
                'description' => 'Diseño de sonrisa, blanqueamiento y armonización dental.',
            ],
            [
                'name' => 'Implantología',
                'description' => 'Reposición de piezas dentales con soluciones fijas y seguras.',
            ],
            [
                'name' => 'Prótesis dental',
                'description' => 'Prótesis parciales, totales y restauraciones personalizadas.',
            ],
            [
                'name' => 'Ortodoncia',
                'description' => 'Alineación dental y corrección de la mordida en adolescentes y adultos.',
            ],
            [
                'name' => 'Endodoncia',
                'description' => 'Tratamientos de conducto para conservar dientes afectados.',
            ],
            [
                'name' => 'Periodoncia',
                'description' => 'Cuidado de encías, tejidos de soporte y prevención periodontal.',
            ],
            [
                'name' => 'Cirugía oral',
                'description' => 'Extracciones y procedimientos quirúrgicos con enfoque seguro.',
            ],
            [
                'name' => 'Odontopediatría',
                'description' => 'Atención dental preventiva y amable para niños y adolescentes.',
            ],
            [
                'name' => 'Prevención y diagnóstico',
                'description' => 'Limpiezas, controles y diagnóstico temprano para una boca sana.',
            ],
        ];

        $existingDepartments = Departments::orderBy('id')->get();

        foreach ($hospitalDepartments as $index => $value) {
            if (isset($existingDepartments[$index])) {
                $department = $existingDepartments[$index];
                $department->name = $value['name'];
                $department->description = $value['description'];
                $department->is_deleted = 0;
                $department->save();
            } else {
                Departments::create($value);
            }
        }
          
    }
}
