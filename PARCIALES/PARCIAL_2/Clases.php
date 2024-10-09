<?php

interface Detalle {
    public function obtenerDetallesEspecificos(): string;
}

abstract class Entrada implements Detalle {
    public $id;
    public $fecha_creacion;
    public $tipo;
    public $titulo;
    public $descripcion;

    public function __construct($datos = []) {
        foreach ($datos as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    abstract public function obtenerDetallesEspecificos(): string;
}

class EntradaUnaColumna extends Entrada {
    public function obtenerDetallesEspecificos(): string {
        return "Entrada de una columna: " . $this->titulo;
    }
}

class EntradaDosColumnas extends Entrada {
    public $titulo1;
    public $descripcion1;
    public $titulo2;
    public $descripcion2;

    public function obtenerDetallesEspecificos(): string {
        return "Entrada de dos columnas: " . $this->titulo1 . " | " . $this->titulo2;
    }
}

class EntradaTresColumnas extends Entrada {
    public $titulo1;
    public $descripcion1;
    public $titulo2;
    public $descripcion2;
    public $titulo3;
    public $descripcion3;

    public function obtenerDetallesEspecificos(): string {
        return "Entrada de tres columnas: " . $this->titulo1 . " | " . $this->titulo2 . " | " . $this->titulo3;
    }
}

class GestorBlog {
    private $entradas = [];

    public function cargarEntradas() {
        if (file_exists('blog.json')) {
            $json = file_get_contents('blog.json');
            $data = json_decode($json, true);

            foreach ($data as $entradaData) {
                switch ($entradaData['tipo']) {
                    case 1:
                        $this->entradas[] = new EntradaUnaColumna($entradaData);
                        break;
                    case 2:
                        $this->entradas[] = new EntradaDosColumnas($entradaData);
                        break;
                    case 3:
                        $this->entradas[] = new EntradaTresColumnas($entradaData);
                        break;
                }
            }
        }
    }

    public function agregarEntrada(Entrada $entrada) {
        $this->entradas[] = $entrada;
    }

    public function editarEntrada(Entrada $entrada) {
        foreach ($this->entradas as $key => $existente) {
            if ($existente->id === $entrada->id) {
                $this->entradas[$key] = $entrada; // Actualiza la entrada
                return true;
            }
        }
        return false; 
    }


    public function eliminarEntrada($id) {
        foreach ($this->entradas as $key => $entrada) {
            if ($entrada->id === $id) {
                unset($this->entradas[$key]); 
                $this->entradas = array_values($this->entradas); 
                return true;
            }
        }
        return false;
    }

    
    public function obtenerEntrada($id) {
        foreach ($this->entradas as $entrada) {
            if ($entrada->id === $id) {
                return $entrada; 
            }
        }
        return null; 
    }


    public function moverEntrada($id, $direccion) {
        foreach ($this->entradas as $key => $entrada) {
            if ($entrada->id === $id) {
                if ($direccion === 'arriba' && $key > 0) {
                    $temp = $this->entradas[$key - 1];
                    $this->entradas[$key - 1] = $entrada;
                    $this->entradas[$key] = $temp;
                    return true;
                } elseif ($direccion === 'abajo' && $key < count($this->entradas) - 1) {
            
                    $temp = $this->entradas[$key + 1];
                    $this->entradas[$key + 1] = $entrada;
                    $this->entradas[$key] = $temp;
                    return true;
                }
                return false;
            }
        }
        return false; // Si no se encuentra la entrada
    }

    // Método para guardar todas las entradas en el archivo JSON
    public function guardarEntradas() {
        $data = array_map(function($entrada) {
            return get_object_vars($entrada);
        }, $this->entradas);
        file_put_contents('blog.json', json_encode($data, JSON_PRETTY_PRINT));
    }

    // Método para obtener todas las entradas
    public function obtenerEntradas() {
        return $this->entradas;
    }
}

