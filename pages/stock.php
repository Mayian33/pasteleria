<?php
include_once('../php/layout.php');


// Verifica si el usuario es administrador con rol 1
$isAdmin = isset($_SESSION['rol']) && $_SESSION['rol'] == 1;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" href="../css/estilos-comunes.css" as="style" />
    <link href="../css/estilos-comunes.css" rel="stylesheet" />
    <title>Stock e Ingredientes - Pastelería</title>
</head>

<body>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tabla de Stock de Ingredientes</title>
        <link rel="stylesheet" href="styles.css"> <!-- Asegúrate de enlazar tu archivo CSS -->
        <style>
            /* Estilos para la tabla */
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                font-family: text;
            }

            th,
            td {
                border: 1px solid var(--secondary);
                padding: 15px;
                text-align: left;
            }

            th {
                background-color: var(--secondary);
                color: var(--white);
                font-family: title;
            }
        </style>
    </head>

    <body>

        <!-- MENU NAVBAR -->
        <header>
            <?php echo $Menu ?>
        </header>

        <div class="main">
            <h1 class="title">Stock de Ingredientes</h1>
            <!-- tabla de masa -->
            <table>
                <thead>
                    <tr>
                        <th>Masa</th>
                        <th>Cantidad</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Hojaldre</td>
                        <td>10 kg</td>
                        <td>Masa para la base de los productos.</td>
                    </tr>
                </tbody>
            </table>

            <!-- tabla de ingredientes -->
            <table>
                <thead>
                    <tr>
                        <th>Ingredientes</th>
                        <th>Cantidad</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>huevo</td>
                        <td>5 kg</td>
                        <td>Masa para la base de los productos.</td>
                    </tr>
                </tbody>
            </table>

            <!-- tabla de decoracion -->
            <table>
                <thead>
                    <tr>
                        <th>Decoración</th>
                        <th>Cantidad</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>huevo</td>
                        <td>5 kg</td>
                        <td>Masa para la base de los productos.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>

    </html>