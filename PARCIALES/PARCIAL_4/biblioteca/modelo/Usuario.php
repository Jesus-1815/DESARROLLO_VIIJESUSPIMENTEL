<?php

require_once('../db/conexion.php');

class Usuario {
    public $id;
    public $nombre;
    public $email;
    public $google_id; 

    // Constructor
    public function __construct($id, $nombre, $email, $google_id) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->google_id = $google_id; 
    }

    // Método para crear un usuario desde los datos obtenidos de Google
    public static function crearDesdeGoogle($data) {
        return new Usuario(null, $data['nombre'], $data['email'], $data['google_id']);
    }


    // Método para verificar si el usuario ya existe en la base de datos
    public static function existeEnBaseDeDatos($google_id) {
        $conexion = new Conexion();
        $db = $conexion->getConnection();

        $query = $db->prepare("SELECT id FROM usuario WHERE google_id = ?");
        $query->execute([$google_id]);

        $resultado = $query->fetch(PDO::FETCH_ASSOC);
        return $resultado ? true : false; // Devuelve true si el usuario existe, false si no
    }
}
