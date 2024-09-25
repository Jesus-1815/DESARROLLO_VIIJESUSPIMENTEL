<?php
require_once 'Tarea.php';
require_once 'Detalle.php';

class TareaTesting extends Tarea implements Detalle {
    private $tipoTest;

    public function __construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion, $tipoTest) {
        parent::__construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion);
        $this->tipoTest = $tipoTest;
    }

    public function obtenerDetallesEspecificos(): string {
        return "Tipo de prueba: " . $this->tipoTest;
    }
}
?>
