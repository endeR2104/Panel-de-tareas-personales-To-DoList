<?php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) header('Location: login.php');

$task_id = $_GET['id'] ?? 0;
$filter = $_GET['filter'] ?? 'pending';
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
if ($stmt->execute([$task_id, $user_id])) {
    $_SESSION['message'] = 'Tarea eliminada.';
} else {
    $_SESSION['message'] = 'Error al eliminar.';
}
header("Location: dashboard.php?filter=$filter");
exit;
?>