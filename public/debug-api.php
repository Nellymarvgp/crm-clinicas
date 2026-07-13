<?php
// Archivo para depurar problemas de API

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

header('Content-Type: application/json');

try {
    // Verificar la estructura de las tablas relevantes
    echo "Comprobando estructura de tablas...\n";
    
    // Comprobar doctor_available_days
    $columns_days = DB::getSchemaBuilder()->getColumnListing('doctor_available_days');
    echo "Columnas de doctor_available_days: " . json_encode($columns_days) . "\n";
    
    // Comprobar doctor_available_times
    $columns_times = DB::getSchemaBuilder()->getColumnListing('doctor_available_times');
    echo "Columnas de doctor_available_times: " . json_encode($columns_times) . "\n";
    
    // Comprobar doctor_available_slots
    $columns_slots = DB::getSchemaBuilder()->getColumnListing('doctor_available_slots');
    echo "Columnas de doctor_available_slots: " . json_encode($columns_slots) . "\n";
    
    // Probar una consulta similar a la que causa problemas
    echo "\nProbando consulta similar a la problemática:\n";
    
    $doctorId = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : 1;
    $dayOfWeek = isset($_GET['day']) ? $_GET['day'] : '1';
    
    echo "Consultando para doctor_id: $doctorId, day_of_week: $dayOfWeek\n";
    
    // Probar times
    $times = DB::table('doctor_available_times')
        ->where('doctor_id', $doctorId)
        ->where('day_of_week', $dayOfWeek)
        ->where('is_deleted', 0)
        ->get();
    
    echo "Times encontrados: " . $times->count() . "\n";
    echo json_encode($times) . "\n\n";
    
    // Si hay times, probar slots
    if ($times->count() > 0) {
        $timeId = $times->first()->id;
        echo "Buscando slots para time_id: $timeId\n";
        
        $slots = DB::table('doctor_available_slots')
            ->where('doctor_id', $doctorId)
            ->where('doctor_available_time_id', $timeId)
            ->where('is_deleted', 0)
            ->get();
        
        echo "Slots encontrados: " . $slots->count() . "\n";
        echo json_encode($slots) . "\n";
    }
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "TRACE: " . $e->getTraceAsString() . "\n";
}
