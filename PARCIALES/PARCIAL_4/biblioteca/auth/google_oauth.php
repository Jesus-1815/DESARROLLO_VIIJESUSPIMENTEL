<?php
session_start();

// Datos de tu proyecto de Google
$client_id = '1058326611298-vcbcsikpdkbn84fe6lgqgrj2joo7pptp.apps.googleusercontent.com';
$redirect_uri = 'http://localhost/PARCIALES/PARCIAL_4/biblioteca/auth/callback.php';

//permiso necesario para optener tambien el nombre de usuario
$scope = 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile';


// Redirige a Google para autenticarse
$auth_url = "https://accounts.google.com/o/oauth2/auth?" . http_build_query([
    'response_type' => 'code',
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'scope' => $scope,
    'access_type' => 'offline'
]);

header('Location: ' . $auth_url);
exit();
