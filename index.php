<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'config.php';

// Obtener todos los registros de bebidas
$stmt = $pdo->query("SELECT * FROM beverages");
$beverages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD - Bebidas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Bebidas</h1>
            <a href="create.php">Agregar Nueva Bebida</a>
            <a href="logout.php" class="button">Cerrar sesión</a>
        </header>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($beverages as $beverage): ?>
                <tr>
                    <td><?php echo htmlspecialchars($beverage['id']); ?></td>
                    <td><?php echo htmlspecialchars($beverage['name']); ?></td>
                    <td><?php echo htmlspecialchars($beverage['type']); ?></td>
                    <td><?php echo htmlspecialchars($beverage['price']); ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $beverage['id']; ?>">Editar</a> |
                        <a href="delete.php?id=<?php echo $beverage['id']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar esta bebida?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
