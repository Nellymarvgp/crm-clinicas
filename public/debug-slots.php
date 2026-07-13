<?php
// Script de depuración para doctor-available-slots

require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Configuración de cabeceras para permitir ver la salida
header('Content-Type: text/plain');

try {
    // Parámetros de prueba
    $doctorId = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : 1;
    $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
    
    echo "Depuración de doctor-available-slots\n";
    echo "===================================\n";
    echo "Doctor ID: $doctorId\n";
    echo "Fecha: $date\n\n";
    
    // Calcular día de la semana
    $dayOfWeek = date('w', strtotime($date)); 
    echo "Día de la semana (número): $dayOfWeek\n";
    
    // Mapeo de día de la semana
    $dayMapping = [
        0 => 'sun', 1 => 'mon', 2 => 'tue', 3 => 'wen', 4 => 'thu', 5 => 'fri', 6 => 'sat',
    ];
    $day = $dayMapping[$dayOfWeek];
    echo "Día de la semana (texto): $day\n\n";
    
    // Verificar si el doctor está disponible ese día
    $availableDay = DB::table('doctor_available_days')
        ->where('doctor_id', $doctorId)
        ->where($day, 1)
        ->first();
    
    echo "Doctor disponible en este día: " . ($availableDay ? 'SÍ' : 'NO') . "\n\n";
    
    if (!$availableDay) {
        echo "El doctor no atiende este día.";
        exit;
    }
    
    // Prueba de formatos para day_of_week
    echo "Pruebas de formato de día:\n";
    
    // Formato string numérico
    $formatString = (string)$dayOfWeek;
    echo "* Buscando con formato string numérico: '$formatString'\n";
    $timesString = DB::table('doctor_available_times')
        ->where('doctor_id', $doctorId)
        ->where('day_of_week', $formatString)
        ->where('is_deleted', 0)
        ->get();
    echo "  Resultados: " . $timesString->count() . "\n";
    if ($timesString->count() > 0) {
        echo "  Primer resultado: " . json_encode($timesString->first()) . "\n";
    }
    
    // Formato numérico
    echo "* Buscando con formato numérico: $dayOfWeek\n";
    $timesNum = DB::table('doctor_available_times')
        ->where('doctor_id', $doctorId)
        ->where('day_of_week', $dayOfWeek)
        ->where('is_deleted', 0)
        ->get();
    echo "  Resultados: " . $timesNum->count() . "\n";
    if ($timesNum->count() > 0) {
        echo "  Primer resultado: " . json_encode($timesNum->first()) . "\n";
    }
    
    // Formato texto
    echo "* Buscando con formato texto: '$day'\n";
    $timesText = DB::table('doctor_available_times')
        ->where('doctor_id', $doctorId)
        ->where('day_of_week', $day)
        ->where('is_deleted', 0)
        ->get();
    echo "  Resultados: " . $timesText->count() . "\n";
    if ($timesText->count() > 0) {
        echo "  Primer resultado: " . json_encode($timesText->first()) . "\n";
    }
    
    echo "\n";
    
    // Determinar cuál es el formato correcto
    $availableTimes = collect();
    if ($timesString->count() > 0) {
        echo "El formato correcto parece ser string numérico\n";
        $availableTimes = $timesString;
    } elseif ($timesNum->count() > 0) {
        echo "El formato correcto parece ser numérico\n";
        $availableTimes = $timesNum;
    } elseif ($timesText->count() > 0) {
        echo "El formato correcto parece ser texto\n";
        $availableTimes = $timesText;
    } else {
        echo "No se encontraron horarios disponibles con ningún formato\n";
        exit;
    }
    
    // Verificar estructura de doctor_available_slots si existe
    echo "\nComprobando si existe la tabla 'doctor_available_slots'...\n";
    $hasSlots = false;
    try {
        $slotTables = DB::select("SHOW TABLES LIKE 'doctor_available_slots'");
        $hasSlots = count($slotTables) > 0;
        echo "La tabla 'doctor_available_slots' " . ($hasSlots ? "existe" : "no existe") . "\n";
        
        if ($hasSlots) {
            $firstTime = $availableTimes->first();
            $slots = DB::table('doctor_available_slots')
                ->where('doctor_id', $doctorId)
                ->where(function($query) use ($firstTime) {
                    $query->where('doctor_available_time_id', $firstTime->id)
                          ->orWhere('doctor_available_id', $firstTime->id);
                })
                ->where('is_deleted', 0)
                ->get();
            
            echo "Slots para time_id=" . $firstTime->id . ": " . $slots->count() . "\n";
            
            if ($slots->count() > 0) {
                echo "Primer slot: " . json_encode($slots->first()) . "\n";
            }
        }
    } catch (\Exception $e) {
        echo "Error al verificar la tabla de slots: " . $e->getMessage() . "\n";
    }
    
    // Mostrar resumen
    echo "\nResumen:\n";
    echo "- Formato de día en BD: " . ($availableTimes->count() > 0 ? $availableTimes->first()->day_of_week : 'Desconocido') . "\n";
    echo "- Total de horarios disponibles: " . $availableTimes->count() . "\n";
    
    // Generar algunos slots de ejemplo
    echo "\nSlots generados:\n";
    $counter = 0;
    
    foreach ($availableTimes as $time) {
        $startTime = strtotime($time->from);
        $endTime = strtotime($time->to);
        
        $timeSlot = $startTime;
        while ($timeSlot < $endTime && $counter < 5) {
            $formattedTime = date('H:i', $timeSlot);
            $displayTime = date('h:i A', $timeSlot);
            
            echo "- ID: {$time->id}, Tiempo: {$formattedTime}, Mostrar como: {$displayTime}\n";
            
            $timeSlot = strtotime('+30 minutes', $timeSlot);
            $counter++;
        }
    }
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "TRACE: " . str_replace("#", "\n#", $e->getTraceAsString()) . "\n";
}
