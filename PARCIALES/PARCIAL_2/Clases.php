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

    public function getId() {
        return $this->id; 
    }

    public function getTitulo() {
        return $this->titulo; 
    }

    public function getDescripcion() {
        return $this->descripcion; 
    }

    public function getEstado() {
        return $this->estado; 
    }

    public function getPrioridad() {
        return $this->prioridad; 
    }

    public function obtenerDetallesEspecificos() {
        return ''; // Método a ser sobreescrito por las subclases
    }
}

class TareaDesarrollo extends Tarea implements Detalle {
    private $lenguajeProgramacion;

    public function __construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion, $lenguajeProgramacion) {
        parent::__construct($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion);
        $this->lenguajeProgramacion = $lenguajeProgramacion;
    }

    public function obtenerDetallesEspecificos(): string {
        return "Lenguaje de Programación: $this->lenguajeProgramacion";
    }

    public function setLenguajeProgramacion($lenguaje) {
        $this->lenguajeProgramacion = $lenguaje;
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

    public function agregarTarea(Tarea $tarea) {
        $this->tareas[$tarea->getId()] = $tarea; // Usar el ID como clave para evitar duplicados
    }

    public function cargarTareasDesdeJson($archivo) {
        if (file_exists($archivo)) {
            $contenido = file_get_contents($archivo);
            $datos = json_decode($contenido, true);

            foreach ($datos as $tareaData) {
                switch ($tareaData['tipo']) {
                    case 'desarrollo':
                        $tarea = new TareaDesarrollo(
                            $tareaData['id'],
                            $tareaData['titulo'],
                            $tareaData['descripcion'],
                            $tareaData['estado'],
                            $tareaData['prioridad'],
                            $tareaData['fechaCreacion'],
                            $tareaData['lenguajeProgramacion']
                        );
                        break;
                    case 'diseno':
                        $tarea = new TareaDiseno(
                            $tareaData['id'],
                            $tareaData['titulo'],
                            $tareaData['descripcion'],
                            $tareaData['estado'],
                            $tareaData['prioridad'],
                            $tareaData['fechaCreacion'],
                            $tareaData['herramientaDiseno']
                        );
                        break;
                    case 'testing':
                        $tarea = new TareaTesting(
                            $tareaData['id'],
                            $tareaData['titulo'],
                            $tareaData['descripcion'],
                            $tareaData['estado'],
                            $tareaData['prioridad'],
                            $tareaData['fechaCreacion'],
                            $tareaData['tipoTest']
                        );
                        break;
                    default:
                        throw new Exception("Tipo de tarea desconocido: " . $tareaData['tipo']);
                }

                $this->agregarTarea($tarea);
            }
        } else {
            throw new Exception("El archivo no existe.");
        }
    }

    public function listarTareas($filtroEstado = '') {
        if ($filtroEstado) {
            return array_filter($this->tareas, function($tarea) use ($filtroEstado) {
                return $tarea->getEstado() === $filtroEstado;
            });
        }
        return $this->tareas;
    }
}

?>

