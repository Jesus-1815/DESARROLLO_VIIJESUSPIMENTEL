<?php 
require_once 'Libro.php';

class LibroDigital extends Libro {
    private $formato;
    private $tamaño;

    public function __construct($titulo, $autor, $anioPublicacion, $formato, $tamaño) {
        parent::__construct($titulo, $autor, $anioPublicacion);
        $this->formato = $formato;
        $this->tamaño = $tamaño;
    }

    public function obtenerInformacion() {
        return parent::obtenerInformacion() . ", Formato: " . $this->formato . ", Tamaño: " . $this->tamaño . " MB";
    }
}
