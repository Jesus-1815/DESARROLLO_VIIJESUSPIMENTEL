<?php 
require_once 'Prestable.php';

class Libro implements Prestable {
    private $titulo;
    private $autor;
    private $anioPublicacion;
    private $disponible = true;

    public function __construct($titulo, $autor, $anioPublicacion) {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->anioPublicacion = $anioPublicacion;
    }

    public function prestar() {
        if ($this->disponible) {
            $this->disponible = false;
            return true;
        }
        return false;
    }

    public function devolver() {
        $this->disponible = true;
    }

    public function estaDisponible() {
        return $this->disponible;
    }

    public function obtenerInformacion() {
        return "Título: " . $this->titulo . ", Autor: " . $this->autor . ", Año de Publicación: " . $this->anioPublicacion;
    }

    public function getTitulo() {
        return $this->titulo;
    }
}
