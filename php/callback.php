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

// Verificamos si la información del usuario está disponible
if (isset($userinfo["error"])) {
    die("Error al obtener la información del usuario: " . $userinfo["error"]);
}

// Datos obtenidos de Google
$name = $userinfo['name'];
$email = $userinfo['email'];
$picture = $userinfo['picture'];

// Verificar si el usuario ya existe en la base de datos
$query = "SELECT * FROM usuarios WHERE email_usuario = '$email'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // El usuario ya existe, obtenemos los datos de sesión
    $user = $result->fetch_assoc();
    $_SESSION["usuario_id"] = $user["id_usuario"];  // Cambiar a "usuario_id"
    $_SESSION["nombre_usuario"] = $user["nombre_usuario"];
    $_SESSION["email_usuario"] = $user["email_usuario"];
    $_SESSION["foto_usuario"] = $user["foto_usuario"];
    $_SESSION["rol"] = $user["rol"];  // Obtener el rol del usuario
} else {
    // Si no existe, insertarlo en la base de datos
    $query = "INSERT INTO usuarios (nombre_usuario, email_usuario, foto_usuario, rol) 
              VALUES ('$name', '$email', '$picture', 2)"; // rol por defecto 2 (cliente)

    if ($conn->query($query) === TRUE) {
        // Nuevo usuario insertado
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
    header("Location: http://localhost/PROYECTO/pasteleria/pages/index.php");
    exit();
}
?>

<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
    // Inicializa Google Identity Services
    google.accounts.id.initialize({
        client_id: "610173823970-2ghtoc8eet06j6vdjggt4262gjfrdpol.apps.googleusercontent.com", // Asegúrate de cambiarlo por tu client_id real
        callback: handleCredentialResponse,
    });

    // Comentamos o eliminamos la línea que desactiva la selección automática de cuenta
    // google.accounts.id.disableAutoSelect(); // Eliminar o comentar esta línea

    // Esta línea fuerza a Google a mostrar el prompt (ventana de selección de cuenta)
    google.accounts.id.prompt(); // Siempre muestra la ventana de elección de cuenta

    // Función de callback que maneja la respuesta de la autenticación
    function handleCredentialResponse(response) {
        const responsePayload = jwt_decode(response.credential); // Decodificar JWT para obtener la info del usuario
        console.log("Id: " + responsePayload.sub);
        console.log("Nombre: " + responsePayload.name);
        console.log("Email: " + responsePayload.email);

        // Enviar el id_token a PHP para que se procese en el backend
        fetch('callback.php', {
            method: 'POST',
            body: JSON.stringify({
                id_token: response.credential
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(response => response.json()).then(data => {
            console.log(data);
            // Redirigir a la página correspondiente después de iniciar sesión
            window.location.href = data.redirect_url;
        }).catch(error => console.error('Error:', error));
    }
</script>