<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'config.php';

// Crear una nueva compra si no hay una en curso
if (!isset($_SESSION['id_purchase'])) {
    $stmt = $pdo->prepare("INSERT INTO purchase (total) VALUES (0)");
    $stmt->execute();
    $_SESSION['id_purchase'] = $pdo->lastInsertId();
}

$id_purchase = $_SESSION['id_purchase'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['beverage_id']) && isset($_POST['quantity'])) {
        $beverage_id = $_POST['beverage_id'];
        $quantity = $_POST['quantity'];

        // Obtener el precio de la bebida seleccionada
        $stmt = $pdo->prepare("SELECT price FROM beverages WHERE id = :beverage_id");
        $stmt->execute(['beverage_id' => $beverage_id]);
        $beverage = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($beverage) {
            $price = $beverage['price'];
            $total = $quantity * $price;

            // Insertar en la tabla de ítems de la compra
            $stmt = $pdo->prepare("INSERT INTO purchase_items (id_purchase, id_beverages, quantity, total) VALUES (:id_purchase, :id_beverages, :quantity, :total)");
            $stmt->execute(['id_purchase' => $id_purchase, 'id_beverages' => $beverage_id, 'quantity' => $quantity, 'total' => $total]);
        }
    } elseif (isset($_POST['finish'])) {
        // Terminar la compra
        $stmt = $pdo->prepare("SELECT SUM(total) AS total FROM purchase_items WHERE id_purchase = :id_purchase");
        $stmt->execute(['id_purchase' => $id_purchase]);
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Actualizar el total en la tabla purchase
        $stmt = $pdo->prepare("UPDATE purchase SET total = :total WHERE id = :id_purchase");
        $stmt->execute(['total' => $total, 'id_purchase' => $id_purchase]);

        // Limpiar la sesión
        unset($_SESSION['id_purchase']);
        header('Location: purchase_complete.php');
        exit;
    }
}

// Obtener los ítems de la compra en curso
$stmt = $pdo->prepare("SELECT pi.id_purchase, b.name, pi.quantity, pi.total 
                       FROM purchase_items pi 
                       JOIN beverages b ON pi.id_beverages = b.id 
                       WHERE pi.id_purchase = :id_purchase");
$stmt->execute(['id_purchase' => $id_purchase]);
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Realizar Compra</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Realizar Compra</h1>
        <a href="logout.php" class="button">Cerrar sesión</a>
        <form action="" method="post">
            <label for="beverage_id">Seleccionar Bebida:</label>
            <select id="beverage_id" name="beverage_id" required>
                <?php
                // Obtener todas las bebidas para el selector
                $stmt = $pdo->query("SELECT * FROM beverages");
                $beverages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($beverages as $beverage):
                ?>
                    <option value="<?php echo $beverage['id']; ?>">
                        <?php echo htmlspecialchars($beverage['name']); ?> (<?php echo htmlspecialchars($beverage['price']); ?>)
                    </option>
                <?php endforeach; ?>
            </select><br>
            <label for="quantity">Cantidad:</label>
            <input type="number" id="quantity" name="quantity" min="1" required><br>
            <button type="submit">Confirmar Compra</button>
        </form>

        <?php if (!empty($purchases)): ?>
            <h2>Detalles de la Compra</h2>
            <table>
                <tr>
                    <th>ID Compra</th>
                    <th>Bebida</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
                <?php foreach ($purchases as $purchase): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($purchase['id_purchase']); ?></td>
                        <td><?php echo htmlspecialchars($purchase['name']); ?></td>
                        <td><?php echo htmlspecialchars($purchase['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($purchase['total']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <form action="" method="post">
            <button type="submit" name="finish">Terminar Compra</button>
        </form>
        <a href="index.php">Volver a la lista de bebidas</a>
    </div>
</body>
</html>
