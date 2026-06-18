<?php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) header('Location: login.php');

$user_id = $_SESSION['user_id'];
$task_id = $_GET['id'] ?? 0;
$filter = $_GET['filter'] ?? 'pending';

// Obtener tarea y verificar propiedad
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$task_id, $user_id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$task) {
    $_SESSION['message'] = 'Tarea no encontrada.';
    header("Location: dashboard.php?filter=$filter");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $due_date = $_POST['due_date'] ?: null;
    $priority = $_POST['priority'] ?? 'medium';

    if (empty($title)) {
        $error = 'El título es obligatorio.';
    } else {
        $update = $pdo->prepare("UPDATE tasks SET title=?, description=?, due_date=?, priority=? WHERE id=? AND user_id=?");
        if ($update->execute([$title, $description, $due_date, $priority, $task_id, $user_id])) {
            $_SESSION['message'] = 'Tarea actualizada.';
            header("Location: dashboard.php?filter=$filter");
            exit;
        } else {
            $error = 'Error al actualizar.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning">
                    <h4>✏️ Editar tarea</h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <form method="POST" id="editForm">
                        <div class="mb-3">
                            <label>Título *</label>
                            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($task['title']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Descripción</label>
                            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($task['description']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Fecha límite</label>
                            <input type="date" name="due_date" class="form-control" value="<?= $task['due_date'] ?>">
                        </div>
                        <div class="mb-3">
                            <label>Prioridad</label>
                            <select name="priority" class="form-select">
                                <option value="low" <?= $task['priority'] == 'low' ? 'selected' : '' ?>>Baja</option>
                                <option value="medium" <?= $task['priority'] == 'medium' ? 'selected' : '' ?>>Media</option>
                                <option value="high" <?= $task['priority'] == 'high' ? 'selected' : '' ?>>Alta</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        <a href="dashboard.php?filter=<?= $filter ?>" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('editForm').addEventListener('submit', function(e) {
        if (document.querySelector('[name="title"]').value.trim() === '') {
            alert('El título no puede estar vacío');
            e.preventDefault();
        }
    });
</script>
</body>
</html>