<?php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) header('Location: login.php');

$task_id = $_GET['id'] ?? 0;
$filter = $_GET['filter'] ?? 'pending';
$user_id = $_SESSION['user_id'];

// Obtener estado actual
$stmt = $pdo->prepare("SELECT status FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$task_id, $user_id]);
$task = $stmt->fetch();
if ($task) {
    $newStatus = ($task['status'] == 'pending') ? 'completed' : 'pending';
    $update = $pdo->prepare("UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?");
    $update->execute([$newStatus, $task_id, $user_id]);
    $_SESSION['message'] = ($newStatus == 'completed') ? 'Tarea completada ✔' : 'Tarea reabierta.';
}
header("Location: dashboard.php?filter=$filter");
exit;
?>