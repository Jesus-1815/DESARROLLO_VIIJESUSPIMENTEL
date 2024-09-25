<?php
class GestorTareas {
    private $tareas;

    public function __construct($archivoJSON) {
        $this->tareas = json_decode(file_get_contents($archivoJSON), true);
    }

    public function agregarTarea($tarea) {
        $this->tareas[] = $tarea;
        $this->guardarTareas();
    }

    public function eliminarTarea($id) {
        foreach ($this->tareas as $key => $tarea) {
            if ($tarea['id'] == $id) {
                unset($this->tareas[$key]);
            }
        }
        $this->guardarTareas();
    }

    public function actualizarTarea($tareaActualizada) {
        foreach ($this->tareas as $key => $tarea) {
            if ($tarea['id'] == $tareaActualizada['id']) {
                $this->tareas[$key] = $tareaActualizada;
            }
        }
        $this->guardarTareas();
    }

    public function actualizarEstadoTarea($id, $nuevoEstado) {
        foreach ($this->tareas as $key => $tarea) {
            if ($tarea['id'] == $id) {
                $this->tareas[$key]['estado'] = $nuevoEstado;
            }
        }
        $this->guardarTareas();
    }

    public function buscarTareasPorEstado($estado) {
        $tareasFiltradas = [];
        foreach ($this->tareas as $tarea) {
            if ($tarea['estado'] == $estado) {
                $tareasFiltradas[] = $tarea;
            }
        }
        return $tareasFiltradas;
    }

    public function listarTareas($filtroEstado = '') {
        if ($filtroEstado == '') {
            return $this->tareas;
        } else {
            return $this->buscarTareasPorEstado($filtroEstado);
        }
    }

    private function guardarTareas() {
        file_put_contents('tareas.json', json_encode($this->tareas, JSON_PRETTY_PRINT));
    }
}
<?php
require_once 'TareaDesarrollo.php';
require_once 'TareaDiseno.php';
require_once 'TareaTesting.php';

class GestorTareas {
    private $tareas = [];

    public function __construct($jsonFile) {
        $this->cargarTareas($jsonFile);
    }

    private function cargarTareas($jsonFile) {
        $data = json_decode(file_get_contents($jsonFile), true);
        foreach ($data as $tarea) {
            switch ($tarea['tipo']) {
                case 'desarrollo':
                    $this->tareas[] = new TareaDesarrollo($tarea['id'], $tarea['titulo'], $tarea['descripcion'], $tarea['estado'], $tarea['prioridad'], $tarea['fechaCreacion'], $tarea['lenguajeProgramacion']);
                    break;
                case 'diseno':
                    $this->tareas[] = new TareaDiseno($tarea['id'], $tarea['titulo'], $tarea['descripcion'], $tarea['estado'], $tarea['prioridad'], $tarea['fechaCreacion'], $tarea['herramientaDiseno']);
                    break;
                case 'testing':
                    $this->tareas[] = new TareaTesting($tarea['id'], $tarea['titulo'], $tarea['descripcion'], $tarea['estado'], $tarea['prioridad'], $tarea['fechaCreacion'], $tarea['tipoTest']);
                    break;
            }
        }
    }

    public function agregarTarea($tarea) {
        $this->tareas[] = $tarea;
    }

    public function eliminarTarea($id) {
        // Implementación para eliminar la tarea por ID
    }

    public function actualizarTarea($tarea) {
        // Implementación para actualizar una tarea
    }

    public function actualizarEstadoTarea($id, $nuevoEstado) {
        // Implementación para actualizar el estado de una tarea
    }

    public function buscarTareasPorEstado($estado) {
        // Implementación para buscar tareas por estado
    }

    public function listarTareas($filtroEstado = '') {
        // Implementación para listar tareas
    }
}
?>

?>