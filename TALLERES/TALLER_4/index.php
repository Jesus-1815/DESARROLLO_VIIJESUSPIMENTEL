<?php
require_once 'Gerente.php';
require_once 'Desarrollador.php';
require_once 'Empresa.php';

$empresa = new Empresa();

$gerente = new Gerente("Juan Pérez", "G001", 5000, "Ventas");
$desarrollador = new Desarrollador("Ana Gómez", "D001", 4000, "PHP", "Intermedio");

$empresa->agregarEmpleado($gerente);
$empresa->agregarEmpleado($desarrollador);

echo "Listado de empleados:\n";
$empresa->listarEmpleados();

echo "Nómina total: " . $empresa->calcularNominaTotal() . "\n";

echo "Evaluaciones de desempeño:\n";
$empresa->evaluarDesempenio();
