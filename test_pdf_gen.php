<?php

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Iniciando prueba de PDF...\n";

    $data = ['title' => 'Prueba PDF'];
    $pdf = Pdf::loadHTML('<h1>Hola Mundo</h1><p>Esta es una prueba de PDF.</p>');

    $outputPath = public_path('test_pdf.pdf');
    $pdf->save($outputPath);

    if (File::exists($outputPath)) {
        echo "PDF generado exitosamente en: " . $outputPath . "\n";
    } else {
        echo "Error: El archivo PDF no se creó.\n";
    }
} catch (\Exception $e) {
    echo "Excepción capturada: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
