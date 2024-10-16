<?php
$host = 'localhost';
$db = 'licoreria';
$user = 'root';  // Usuario por defecto de XAMPP
$pass = '';      // Contraseña por defecto de XAMPP, generalmente está vacía

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
