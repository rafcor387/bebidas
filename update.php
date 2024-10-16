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
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $price = $_POST['price'];

    $stmt = $pdo->prepare("UPDATE beverages SET name = :name, type = :type, price = :price WHERE id = :id");
    $stmt->execute(['name' => $name, 'type' => $type, 'price' => $price, 'id' => $id]);

    header('Location: index.php');
    exit;
}

// Obtener la bebida actual
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM beverages WHERE id = :id");
$stmt->execute(['id' => $id]);
$beverage = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Bebida</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Actualizar Bebida</h1>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($beverage['id']); ?>">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($beverage['name']); ?>" required><br>
            <label for="type">Tipo:</label>
            <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($beverage['type']); ?>" required><br>
            <label for="price">Precio:</label>
            <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($beverage['price']); ?>" required><br>
            <button type="submit">Actualizar</button>
        </form>
        <a href="index.php">Volver</a>
    </div>
</body>
</html>
