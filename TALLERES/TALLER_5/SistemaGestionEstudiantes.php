<?php

class SistemaGestionEstudiantes {
    private $estudiantes;
    private $graduados;

    public function __construct() {
        $this->estudiantes = [];
        $this->graduados = [];
    }

    public function agregarEstudiante(Estudiante $estudiante) {
        $this->estudiantes[$estudiante->obtenerDetalles()['id']] = $estudiante;
    }

    public function obtenerEstudiante($id) {
        return $this->estudiantes[$id] ?? null;
    }

    public function listarEstudiantes() {
        return $this->estudiantes;
    }

    public function calcularPromedioGeneral() {
        $total = array_reduce($this->estudiantes, function($carry, $estudiante) {
            return $carry + $estudiante->obtenerPromedio();
        }, 0);
        $cantidad = count($this->estudiantes);
        return $cantidad ? $total / $cantidad : 0;
    }

    public function obtenerEstudiantesPorCarrera($carrera) {
        return array_filter($this->estudiantes, function($estudiante) use ($carrera) {
            return strtolower($estudiante->obtenerDetalles()['carrera']) === strtolower($carrera);
        });
    }

    public function obtenerMejorEstudiante() {
        return array_reduce($this->estudiantes, function($mejor, $estudiante) {
            return $mejor === null || $estudiante->obtenerPromedio() > $mejor->obtenerPromedio() ? $estudiante : $mejor;
        }, null);
    }

    public function generarReporteRendimiento() {
        $materias = [];
        foreach ($this->estudiantes as $estudiante) {
            foreach ($estudiante->obtenerDetalles()['materias'] as $materia => $calificacion) {
                if (!isset($materias[$materia])) {
                    $materias[$materia] = [
                        'total_calificaciones' => 0,
                        'cantidad' => 0,
                        'max' => $calificacion,
                        'min' => $calificacion
                    ];
                }
                $materias[$materia]['total_calificaciones'] += $calificacion;
                $materias[$materia]['cantidad']++;
                $materias[$materia]['max'] = max($materias[$materia]['max'], $calificacion);
                $materias[$materia]['min'] = min($materias[$materia]['min'], $calificacion);
            }
        }
        foreach ($materias as &$materia) {
            $materia['promedio'] = $materia['total_calificaciones'] / $materia['cantidad'];
        }
        return $materias;
    }

    public function graduarEstudiante($id) {
        if (isset($this->estudiantes[$id])) {
            $this->graduados[$id] = $this->estudiantes[$id];
            unset($this->estudiantes[$id]);
        }
    }

    public function generarRanking() {
        usort($this->estudiantes, function($a, $b) {
            return $b->obtenerPromedio() <=> $a->obtenerPromedio();
        });
        return $this->estudiantes;
    }

    public function buscarEstudiantes($query) {
        return array_filter($this->estudiantes, function($estudiante) use ($query) {
            return stripos($estudiante->obtenerDetalles()['nombre'], $query) !== false ||
                   stripos($estudiante->obtenerDetalles()['carrera'], $query) !== false;
        });
    }

    public function generarEstadisticasPorCarrera() {
        $estadisticas = [];
        foreach ($this->estudiantes as $estudiante) {
            $carrera = $estudiante->obtenerDetalles()['carrera'];
            if (!isset($estadisticas[$carrera])) {
                $estadisticas[$carrera] = [
                    'cantidad' => 0,
                    'total_promedio' => 0,
                    'mejor_estudiante' => $estudiante
                ];
            }
            $estadisticas[$carrera]['cantidad']++;
            $estadisticas[$carrera]['total_promedio'] += $estudiante->obtenerPromedio();
            if ($estudiante->obtenerPromedio() > $estadisticas[$carrera]['mejor_estudiante']->obtenerPromedio()) {
                $estadisticas[$carrera]['mejor_estudiante'] = $estudiante;
            }
        }
        foreach ($estadisticas as &$info) {
            $info['promedio_general'] = $info['total_promedio'] / $info['cantidad'];
        }
        return $estadisticas;
    }
}
