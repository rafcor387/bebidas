<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra Completa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>¡Gracias por tu compra!</h1>
        <p>Tu compra se ha completado exitosamente.</p>
        <a href="index.php">Volver a la lista de bebidas</a>
    </div>
</body>
</html>
