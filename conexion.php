<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "brollin"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT id_prod, nombre_prod, descripcion_prod, categoria, precio, imagen FROM productos";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    echo "<h1>Catálogo de Productos</h1>";
    echo "<div style='display: flex; flex-wrap: wrap;'>"; // Para mostrar en formato de cuadrícula

    // Recorrer los resultados y mostrarlos
    while ($row = $result->fetch_assoc()) {
        echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px; width: 200px;'>";
        echo "<h2>" . htmlspecialchars($row['nombre_prod']) . "</h2>";
        echo "<p>" . htmlspecialchars($row['descripcion_prod']) . "</p>";
        echo "<p><strong>Categoría:</strong> " . htmlspecialchars($row['categoria']) . "</p>";
        echo "<p><strong>Precio:</strong> $" . htmlspecialchars($row['precio']) . "</p>";
        
        // Mostrar la imagen
        echo "<img src='" . htmlspecialchars($row['imagen']) . "' style='width: 100%; height: auto;' />";
        
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "No hay productos disponibles.";
}

$conn->close();
?>