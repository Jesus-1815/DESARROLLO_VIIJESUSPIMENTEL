<?php
// Cargar las variables de entorno desde el archivo .env
function cargarEnv($archivo) {
    if (!file_exists($archivo)) {
        throw new Exception('El archivo .env no existe.');
    }

    // Leer todo el archivo
    $contenido = file_get_contents($archivo);

    // Dividir el archivo en líneas
    $lineas = explode("\n", $contenido);

    // Iterar sobre las líneas y cargar las variables
    foreach ($lineas as $linea) {
        // Eliminar espacios en blanco y saltos de línea
        $linea = trim($linea);

        // Ignorar líneas vacías o comentarios
        if (empty($linea) || $linea[0] === '#') {
            continue;
        }

        // Buscar el símbolo "=" para separar la clave y el valor
        list($clave, $valor) = explode('=', $linea, 2);

        // Limpiar las claves y valores
        $clave = trim($clave);
        $valor = trim($valor);

        // Establecer la variable de entorno
        putenv("$clave=$valor");
    }
}

// Cargar el archivo .env
cargarEnv(__DIR__ . '/.env');

// Verificar que el token de GitHub se cargue correctamente
$githubToken = getenv('GITHUB_TOKEN');
if (!$githubToken) {
    throw new Exception('El token de GitHub no se ha cargado desde las variables de entorno. Verifica tu archivo .env.');
}

// Definir el token de GitHub y otras constantes
define('GITHUB_TOKEN', $githubToken); // Carga el token desde las variables de entorno
define('GITHUB_API_URL', 'https://api.github.com');
define('USER_AGENT', 'PHP GitHub API Client');

// Verificar si el token de GitHub está configurado correctamente
if (!GITHUB_TOKEN) {
    throw new Exception('El token de GitHub no está configurado. Verifica las variables de entorno.');
}

// Clase para interactuar con la API de GitHub
class GitHubClient {
    private $token;
    private $baseUrl;
    private $userAgent;

    public function __construct($token, $baseUrl, $userAgent) {
        // Asegurarse de que el token esté presente
        if (!$token) {
            throw new Exception('El token de GitHub no está configurado. Verifica las variables de entorno.');
        }
        $this->token = $token;
        $this->baseUrl = $baseUrl;
        $this->userAgent = $userAgent;
    }

    // Método para obtener los encabezados necesarios para la API de GitHub
    private function getHeaders() {
        return [
            'Authorization: Bearer ' . $this->token,
            'User-Agent: ' . $this->userAgent,
            'Accept: application/vnd.github+json',
            'X-GitHub-Api-Version: 2022-11-28'
        ];
    }

    // Método GET para hacer solicitudes a la API de GitHub
    public function get($endpoint, $params = []) {
        $url = $this->baseUrl . $endpoint;
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            throw new Exception('Error en la petición cURL: ' . curl_error($ch));
        }

        curl_close($ch);

        if ($httpCode >= 400) {
            throw new Exception('Error en la API de GitHub: ' . $response);
        }

        return json_decode($response, true);
    }

    // Método POST para hacer solicitudes a la API de GitHub
    public function post($endpoint, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge(
            $this->getHeaders(),
            ['Content-Type: application/json']
        ));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            throw new Exception('Error en la petición cURL: ' . curl_error($ch));
        }

        curl_close($ch);

        if ($httpCode >= 400) {
            throw new Exception('Error en la API de GitHub: ' . $response);
        }

        return json_decode($response, true);
    }
}

// Crear instancia del cliente de GitHub
$github = new GitHubClient(GITHUB_TOKEN, GITHUB_API_URL, USER_AGENT);
