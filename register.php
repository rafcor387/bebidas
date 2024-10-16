<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password1 = password_hash($_POST['password1'], PASSWORD_BCRYPT);
    $rol = $_POST['rol'];  // Recibimos el rol desde el formulario

    $stmt = $pdo->prepare("INSERT INTO users (email, password1, rol) VALUES (:email, :password1, :rol)");
    $stmt->execute(['email' => $email, 'password1' => $password1, 'rol' => $rol]);

    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Registro</h1>
        <form action="" method="post">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="password1">Contraseña:</label>
            <input type="password" id="password1" name="password1" required><br>
            <label for="rol">Rol:</label>
            <select id="rol" name="rol">
                <option value="0">Usuario</option>
                <option value="1">Administrador</option>
            </select><br>
            <button type="submit">Registrarse</button>
        </form>
        <a href="login.php">Volver al Login</a>
    </div>
</body>
</html>
