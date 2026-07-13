<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

// Obtener información sobre la estructura de la tabla
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$columns = \Illuminate\Support\Facades\DB::select('SHOW COLUMNS FROM doctor_available_days');
print_r($columns);

$columns = \Illuminate\Support\Facades\DB::select('SHOW COLUMNS FROM doctor_available_times');
print_r($columns);

$columns = \Illuminate\Support\Facades\DB::select('SHOW COLUMNS FROM doctor_available_slots');
print_r($columns);
