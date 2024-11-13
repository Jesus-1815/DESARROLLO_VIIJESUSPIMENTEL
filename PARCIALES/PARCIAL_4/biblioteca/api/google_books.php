<?php


function buscarLibros($query) {
 
    $api_url = "https://www.googleapis.com/books/v1/volumes?q=" . urlencode($query) . "&key=AIzaSyAF-jPkDof_FJ8gcp4ZFhD048Zr5q0OBBg";
 
    // Realizar la solicitud HTTP a la API
    $response = file_get_contents($api_url);

    // Verificar si la respuesta es válida
    if ($response !== false) {
        // Convertir la respuesta JSON en un array de PHP
        $data = json_decode($response, true);
        
        // Verificar si hay libros en los resultados
        if (isset($data['items'])) {
            return $data['items']; 
        } else {
            return null; 
        }
    } else {
        return null; 
    }
}
?>
