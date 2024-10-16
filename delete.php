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

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM beverages WHERE id = :id");
$stmt->execute(['id' => $id]);

header('Location: index.php');
exit;
?>
