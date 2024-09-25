<?php
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
    public function getDescripcion() {
        return $this->descripcion; 
    }
   
}
class TareaDesarrollo extends Tarea {
    private $lenguajeProgramacion;

    public function __construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion, $lenguajeProgramacion) {
        parent::__construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion);
        $this->lenguajeProgramacion = $lenguajeProgramacion;
    }

    public function obtenerDetallesEspecificos() {
        return "Lenguaje de Programación: $this->lenguajeProgramacion";
    }

    public function setLenguajeProgramacion($lenguaje) {
        $this->lenguajeProgramacion = $lenguaje;
    }
    public function getTitulo() {
        return $this->titulo; 
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
class GestorTareas {
    private $tareas = [];

    public function agregarTarea($tarea) {
        $this->tareas[] = $tarea;
    }
    public function cargarTareasDesdeJson($archivo) {
        if (file_exists($archivo)) {
            $contenido = file_get_contents($archivo);
            $datos = json_decode($contenido, true);

            foreach ($datos as $tareaData) {
                switch ($tareaData['tipo']) {
                    case 'desarrollo':
                        $tarea = new TareaDesarrollo();
                        $tarea->lenguajeProgramacion = $tareaData['lenguajeProgramacion'];
                        break;
                    case 'diseno':
                        $tarea = new TareaDiseno();
                        $tarea->herramientaDiseno = $tareaData['herramientaDiseno'];
                        break;
                    case 'testing':
                        $tarea = new TareaTesting();
                        $tarea->tipoTest = $tareaData['tipoTest'];
                        break;
                }
                
                $tarea->id = $tareaData['id'];
                $tarea->titulo = $tareaData['titulo'];
                $tarea->descripcion = $tareaData['descripcion'];
                $tarea->estado = $tareaData['estado'];
                $tarea->prioridad = $tareaData['prioridad'];
                $tarea->fechaCreacion = $tareaData['fechaCreacion'];

                $this->tareas[] = $tarea;
            }
        } else {
            throw new Exception("El archivo no existe.");
        }
    }

    public function listarTareas($filtroEstado = '') {
        if ($filtroEstado) {
            return array_filter($this->tareas, function($tarea) use ($filtroEstado) {
                return $tarea->estado === $filtroEstado;
            });
        }
        return $this->tareas;
    }

    
}
    
?>
