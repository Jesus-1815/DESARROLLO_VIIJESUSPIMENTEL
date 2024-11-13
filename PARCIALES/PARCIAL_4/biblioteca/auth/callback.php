<?php

require_once '../modelo/Usuario.php';
require_once '../controladores/UsuarioControlador.php';

session_start();

// Datos de tu proyecto de Google
$client_id = '1058326611298-vcbcsikpdkbn84fe6lgqgrj2joo7pptp.apps.googleusercontent.com';
$client_secret = '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';
$redirect_uri = 'http://localhost/PARCIALES/PARCIAL_4/biblioteca/auth/callback.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Intercambiar el código por un token de acceso
    $token_url = 'https://oauth2.googleapis.com/token';
    $token_data = [
        'code' => $code,
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code',
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($token_data),
        ]
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($token_url, false, $context);

    $json_response = json_decode($response, true);
    if (isset($json_response['access_token'])) {
        $_SESSION['access_token'] = $json_response['access_token']; // Guardar el token en la sesión
        // Usar el token para obtener información del usuario
        $user_info_url = 'https://www.googleapis.com/oauth2/v2/userinfo?access_token=' . $json_response['access_token'];
        $user_info = file_get_contents($user_info_url);
        $user_data = json_decode($user_info, true);

        // Sanitizar las entradas de usuario
        $google_id = htmlspecialchars($user_data['id'], ENT_QUOTES, 'UTF-8');
        $nombre = htmlspecialchars($user_data['name'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($user_data['email'], ENT_QUOTES, 'UTF-8');

        // Guardar el user_id (ID de Google) en la sesión
        $_SESSION['user_id'] = $google_id; // Esto es el Google user ID

        // Crear un objeto Usuario con los datos de Google
        $usuario = Usuario::crearDesdeGoogle([ 
            'google_id' => $google_id,
            'nombre' => $nombre,
            'email' => $email
        ]);

         // Intentar registrar al usuario en la base de datos
         if (UsuarioControlador::registrarUsuario($usuario)) {
            // Usuario registrado con éxito, redirigir a la página de búsqueda de libros
            header('Location: /PARCIALES/PARCIAL_4/biblioteca/index.php');
        } else {
            // El usuario ya estaba registrado en la base de datos
            header('Location: /PARCIALES/PARCIAL_4/biblioteca/index.php');
        }
        exit();
    } else {
        echo "Error al obtener el token de acceso.";
    }
} else {
    echo "No se recibió el código de autorización.";
}
?>


