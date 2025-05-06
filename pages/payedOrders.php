<?php
session_start();
include_once('../php/conexion.php');

if (!isset($_SESSION['usuario_id'])) { 
    echo "<script>alert('Por favor, inicia sesión para ver tu carrito.'); window.location.href='../pages/compra.php';</script>";
    exit();
}

$usuario_id = $_SESSION['usuario_id'];  

// Consulta para obtener los pedidos del usuario
$sql = "SELECT * FROM pedidos WHERE usuario_id = $usuario_id ORDER BY fecha_pedido DESC";
$result = $conn->query($sql);

// Verificar si hay un error en la consulta
if (!$result) {
    echo "Error en la consulta: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos Realizados - Pastelería</title>

    <link rel="preload" href="../css/estilos-comunes.css" as="style" />
    <link href="../css/estilos-comunes.css" rel="stylesheet" />

    <link rel="preload" href="../css/payedOrders.css" as="style" />
    <link href="../css/payedOrders.css" rel="stylesheet" />

</head>

<body>

    <!-- MENU NAVBAR -->
    <header>
        <?php echo $Menu ?>
    </header>

    <main class="main">
        <h1 class="title">Pedidos Realizados</h1>
        <h2 class="subtitle-text">Historial de Pedidos Pagados</h2>

        <div class="orders">
            <?php
            if ($result->num_rows > 0) { // Verifica si hay resultados
                while ($row = $result->fetch_assoc()) { // Usando la forma orientada a objetos
                    echo '<div class="order-card">';
                    echo '<h3 class="title-text">Pedido #' . $row['pedido_id'] . '</h3>';
                    echo '<p class="common-text">Fecha: ' . $row['fecha_pedido'] . '</p>';
                    echo '<p class="common-text">Total: $' . $row['total_pedido'] . '</p>';
                    echo '<p class="common-text">Estado: ' . $row['estado_pedido'] . '</p>';
                    echo '<p class="common-text">Dirección: ' . $row['direccion_pedido'] . '</p>';
                    echo '<p class="common-text">Método de pago: ' . $row['metodo_pago'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p class="common-text">No tienes pedidos pagados.</p>';
            }
            ?>
        </div>

        <div class="cta-catalogue">
            <a href="#" class="cta-btn">Realizar un Nuevo Pedido</a>
        </div>
    </main>

</body>

</html>
