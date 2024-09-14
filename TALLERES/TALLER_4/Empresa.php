<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

class Empresa {
    private $empleados = [];

    public function agregarEmpleado(Empleado $empleado) {
        $this->empleados[] = $empleado;
    }

    public function listarEmpleados() {
        foreach ($this->empleados as $empleado) {
            echo "Nombre: " . $empleado->getNombre() . "\n";
            echo "ID: " . $empleado->getId() . "\n";
            echo "Salario Base: " . $empleado->getSalarioBase() . "\n";
            if ($empleado instanceof Evaluable) {
                echo $empleado->evaluarDesempenio() . "\n";
            }
            echo "\n";
        }
    }

    public function calcularNominaTotal() {
        $total = 0;
        foreach ($this->empleados as $empleado) {
            $total += $empleado->getSalarioBase();
        }
        return $total;
    }

    public function evaluarDesempenio() {
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Evaluable) {
                echo $empleado->evaluarDesempenio() . "\n";
            }
        }
    }
}
