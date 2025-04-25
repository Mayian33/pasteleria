<?php
session_start();
echo 'Hola, tu ID es: ' . ($_SESSION['usuario_id'] ?? 'No logueado');
