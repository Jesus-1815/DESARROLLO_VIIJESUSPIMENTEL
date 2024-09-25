<?php
require_once 'Tarea.php';
require_once 'Detalle.php';

class TareaDesarrollo extends Tarea implements Detalle {
    private $lenguajeProgramacion;

    public function __construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion, $lenguajeProgramacion) {
        parent::__construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion);
        $this->lenguajeProgramacion = $lenguajeProgramacion;
    }

    public function obtenerDetallesEspecificos(): string {
        return "Lenguaje de programación: " . $this->lenguajeProgramacion;
    }
}
?>
