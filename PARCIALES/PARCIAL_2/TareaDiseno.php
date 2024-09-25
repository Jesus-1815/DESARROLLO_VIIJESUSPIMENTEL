<?php
require_once 'Tarea.php';
require_once 'Detalle.php';

class TareaDiseno extends Tarea implements Detalle {
    private $herramientaDiseno;

    public function __construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion, $herramientaDiseno) {
        parent::__construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion);
        $this->herramientaDiseno = $herramientaDiseno;
    }

    public function obtenerDetallesEspecificos(): string {
        return "Herramienta de diseño: " . $this->herramientaDiseno;
    }
}
?>
