<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cargar variables de entorno si estás trabajando localmente con .env
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

// Obtener datos desde variables de entorno
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$db   = getenv('DB_NAME') ?: 'brollin';
$port = getenv('DB_PORT') ?: 3306;

// Conexión a la base de datos
$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
