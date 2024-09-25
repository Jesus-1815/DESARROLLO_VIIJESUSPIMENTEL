<?php
// Definimos la interfaz Detalle
interface Detalle {
    public function obtenerDetallesEspecificos(): string;
}
class Tarea {
    protected $id;
    protected $titulo;
    protected $descripcion;
    protected $estado;
    protected $prioridad;
    protected $fechaCreacion;
    
    public function __construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
        $this->prioridad = $prioridad;
        $this->fechaCreacion = $fechaCreacion;
    }
    
    // Métodos getter y setter generales para Tarea
}
class TareaDesarrollo extends Tarea implements Detalle {
    private $lenguajeProgramacion;

    public function __construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion, $lenguajeProgramacion) {
        parent::__construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion);
        $this->lenguajeProgramacion = $lenguajeProgramacion;
    }

    public function obtenerDetallesEspecificos(): string {
        return "Lenguaje de Programación: " . $this->lenguajeProgramacion;
    }
}
class TareaDiseno extends Tarea implements Detalle {
    private $herramientaDiseno;

    public function __construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion, $herramientaDiseno) {
        parent::__construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion);
        $this->herramientaDiseno = $herramientaDiseno;
    }

    public function obtenerDetallesEspecificos(): string {
        return "Herramienta de Diseño: " . $this->herramientaDiseno;
    }
}
class TareaTesting extends Tarea implements Detalle {
    private $tipoTest;

    public function __construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion, $tipoTest) {
        parent::__construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion);
        $this->tipoTest = $tipoTest;
    }

    public function obtenerDetallesEspecificos(): string {
        return "Tipo de Test: " . $this->tipoTest;
    }
}

?>
