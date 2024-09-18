<?php

require_once 'Estudiante.php';
require_once 'SistemaGestionEstudiantes.php';

// Crear una instancia del sistema
$sistema = new SistemaGestionEstudiantes();

// Crear estudiantes
$estudiantes = [
    new Estudiante(1, 'Juan Pérez', 20, 'Ingeniería'),
    new Estudiante(2, 'Ana Gómez', 22, 'Medicina'),
    new Estudiante(3, 'Luis Martínez', 19, 'Derecho'),
    new Estudiante(4, 'Marta Rodríguez', 21, 'Ingeniería'),
    new Estudiante(5, 'Carlos Fernández', 23, 'Medicina'),
    new Estudiante(6, 'Laura Sánchez', 20, 'Derecho'),
    new Estudiante(7, 'José Ramírez', 22, 'Ingeniería'),
    new Estudiante(8, 'Elena Morales', 24, 'Medicina'),
    new Estudiante(9, 'Pedro López', 21, 'Derecho'),
    new Estudiante(10, 'Julia Díaz', 23, 'Ingeniería')
];

// Agregar materias y calificaciones
$materias = [
    'Matemáticas' => [90, 85, 80, 70, 95, 88, 82, 90, 76, 88],
    'Biología' => [85, 88, 92, 75, 80, 70, 80, 95, 90, 88],
    'Historia' => [78, 80, 85, 72, 90, 87, 89, 76, 82, 90]
];

foreach ($estudiantes as $estudiante) {
    foreach ($materias as $materia => $calificaciones) {
        $estudiante->agregarMateria($materia, $calificaciones[array_rand($calificaciones)]);
    }
    $sistema->agregarEstudiante($estudiante);
}

// Demostrar funcionalidades
echo "Lista de Estudiantes:\n";
print_r($sistema->listarEstudiantes());

echo "\nPromedio General:\n";
echo $sistema->calcularPromedioGeneral() . "\n";

echo "\nEstudiantes de Medicina:\n";
print_r($sistema->obtenerEstudiantesPorCarrera('Medicina'));

echo "\nMejor Estudiante:\n";
echo $sistema->obtenerMejorEstudiante() . "\n";

echo "\nReporte de Rendimiento:\n";
print_r($sistema->generarReporteRendimiento());

echo "\nRanking de Estudiantes:\n";
print_r($sistema->generarRanking());

echo "\nBuscar Estudiantes por nombre (Ana):\n";
print_r($sistema->buscarEstudiantes('Ana'));

echo "\nEstadísticas por Carrera:\n";
print_r($sistema->generarEstadisticas
