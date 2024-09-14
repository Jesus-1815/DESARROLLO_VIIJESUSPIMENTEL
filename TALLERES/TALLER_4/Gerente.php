<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

class Gerente extends Empleado implements Evaluable {
    private $departamento;

    public function __construct($nombre, $id, $salarioBase, $departamento) {
        parent::__construct($nombre, $id, $salarioBase);
        $this->departamento = $departamento;
    }

    // Métodos getter y setter
    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    // Método específico para asignar bonos
    public function asignarBono($monto) {
        $nuevoSalario = $this->getSalarioBase() + $monto;
        $this->setSalarioBase($nuevoSalario);
    }

    // Implementación del método de la interfaz
    public function evaluarDesempenio() {
        return "Evaluación de desempeño del Gerente " . $this->getNombre() . ": Excelente";
    }
}
