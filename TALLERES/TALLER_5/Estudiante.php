<?php

class Estudiante {
    private $id;
    private $nombre;
    private $edad;
    private $carrera;
    private $materias;

    public function __construct($id, $nombre, $edad, $carrera) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->carrera = $carrera;
        $this->materias = [];
    }

    public function agregarMateria($materia, $calificacion) {
        $this->materias[$materia] = $calificacion;
    }

    public function obtenerPromedio() {
        if (count($this->materias) === 0) return 0;
        $total = array_sum($this->materias);
        return $total / count($this->materias);
    }

    public function obtenerDetalles() {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'edad' => $this->edad,
            'carrera' => $this->carrera,
            'materias' => $this->materias
        ];
    }

    public function __toString() {
        return sprintf(
            "ID: %d, Nombre: %s, Edad: %d, Carrera: %s, Promedio: %.2f",
            $this->id,
            $this->nombre,
            $this->edad,
            $this->carrera,
            $this->obtenerPromedio()
        );
    }
}
