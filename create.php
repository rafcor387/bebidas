<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'config.php';
?>

<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $price = $_POST['price'];

    $stmt = $pdo->prepare("INSERT INTO beverages (name, type, price) VALUES (:name, :type, :price)");
    $stmt->execute(['name' => $name, 'type' => $type, 'price' => $price]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Bebida</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Agregar Nueva Bebida</h1>
        <form action="" method="post">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="type">Tipo:</label>
            <input type="text" id="type" name="type" required><br>
            <label for="price">Precio:</label>
            <input type="text" id="price" name="price" required><br>
            <button type="submit">Guardar</button>
        </form>
        <a href="index.php">Volver</a>
    </div>
</body>
</html>
