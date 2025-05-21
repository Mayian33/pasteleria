<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// ✅ Ahora sí estás usando las claves reales del .env
$client_id = $_ENV['GOOGLE_CLIENT_ID'];
$client_secret = $_ENV['GOOGLE_CLIENT_SECRET'];
$redirect_uri = "http://localhost/PROYECTO/pasteleria/php/callback.php";


// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "brollin");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si no tenemos el código de Google, redirigir a Google para autenticarse
if (!isset($_GET["code"])) {
    $auth_url = "https://accounts.google.com/o/oauth2/v2/auth?client_id=$client_id&redirect_uri=$redirect_uri&response_type=code&scope=email%20profile";
    header("Location: $auth_url");
    exit();
}

// Intercambiar el código por el token
$code = $_GET["code"];
$token_url = "https://oauth2.googleapis.com/token";
$data = [
    "code" => $code,
    "client_id" => $client_id,
    "client_secret" => $client_secret,
    "redirect_uri" => $redirect_uri,
    "grant_type" => "authorization_code",
];

$options = [
    "http" => [
        "header" => "Content-Type: application/x-www-form-urlencoded",
        "method" => "POST",
        "content" => http_build_query($data),
    ],
];

$context = stream_context_create($options);
$response = file_get_contents($token_url, false, $context);

$response_data = json_decode($response, true);
if (isset($response_data["error"])) {
    die("Error al obtener el token: " . $response_data["error_description"]);
}

// Obtener la información del usuario desde Google
$access_token = $response_data["access_token"];
$userinfo_url = "https://www.googleapis.com/oauth2/v2/userinfo?access_token=" . $access_token;
$userinfo_response = file_get_contents($userinfo_url);
$userinfo = json_decode($userinfo_response, true);

if (isset($userinfo["error"])) {
    die("Error al obtener la información del usuario: " . $userinfo["error"]);
}

$name = $userinfo['name'];
$email = $userinfo['email'];
$picture = $userinfo['picture'];

$query = "SELECT * FROM usuarios WHERE email_usuario = '$email'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION["usuario_id"] = $user["id_usuario"];  
    $_SESSION["nombre_usuario"] = $user["nombre_usuario"];
    $_SESSION["email_usuario"] = $user["email_usuario"];
    $_SESSION["foto_usuario"] = $user["foto_usuario"];
    $_SESSION["rol"] = $user["rol"];
} else {
    $query = "INSERT INTO usuarios (nombre_usuario, email_usuario, foto_usuario, rol) 
              VALUES ('$name', '$email', '$picture', 2)";

    if ($conn->query($query) === TRUE) {
        $user_id = $conn->insert_id;
        $_SESSION["usuario_id"] = $user_id;
        $_SESSION["nombre_usuario"] = $name;
        $_SESSION["email_usuario"] = $email;
        $_SESSION["foto_usuario"] = $picture;
        $_SESSION["rol"] = 2; // rol por defecto 2 (cliente)
    } else {
        die("Error al registrar el usuario: " . $conn->error);
    }
}

// Redirigir según rol
if ($_SESSION["rol"] == 1) {
    // Si el rol es admin (1), redirigir a pedidos
    header("Location: http://localhost/PROYECTO/pasteleria/pages/orders.php");
    exit();
} else {
    // Si el rol es cliente (2), redirigir al home
    header("Location: http://localhost/PROYECTO/pasteleria/pages/principal.php");
    exit();
}
?>


