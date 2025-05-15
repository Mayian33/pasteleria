<?php
require __DIR__ . '/../../vendor/autoload.php'; // ✅ sube dos niveles: stripe → pages → pasteleria

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../'); // ✅ también sube dos niveles hasta .env
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

