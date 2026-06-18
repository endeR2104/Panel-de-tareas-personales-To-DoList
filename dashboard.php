<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$filter = $_GET['filter'] ?? 'pending'; // pending o completed
$status = ($filter === 'completed') ? 'completed' : 'pending';

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? AND status = ? ORDER BY 
                       FIELD(priority, 'high', 'medium', 'low'), due_date ASC");
$stmt->execute([$user_id, $status]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tareas - <?= htmlspecialchars($_SESSION['username']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .priority-high { background-color: #f8d7da; border-left: 5px solid #dc3545; }
        .priority-medium { background-color: #fff3cd; border-left: 5px solid #ffc107; }
        .priority-low { background-color: #d1e7dd; border-left: 5px solid #198754; }
        .task-card { margin-bottom: 12px; transition: 0.2s; }
        .task-card:hover { transform: translateX(4px); }
        .filter-active { font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">📋 Panel de Tareas</a>
        <div class="ms-auto">
            <span class="navbar-text text-white me-3">Hola, <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Mis tareas</h2>
                <a href="create_task.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Nueva tarea</a>
            </div>

            <!-- Filtros -->
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link <?= $filter == 'pending' ? 'active fw-bold' : '' ?>" href="?filter=pending">📌 Pendientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $filter == 'completed' ? 'active fw-bold' : '' ?>" href="?filter=completed">✅ Completadas</a>
                </li>
            </ul>

            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success alert-dismissible fade show"><?= $_SESSION['message'] ?></div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <?php if (count($tasks) === 0): ?>
                <div class="alert alert-info text-center">No hay tareas <?= $filter == 'pending' ? 'pendientes' : 'completadas' ?>. ¡Crea una nueva!</div>
            <?php else: ?>
                <?php foreach ($tasks as $task): ?>
                    <?php
                        $priorityClass = '';
                        if ($task['priority'] == 'high') $priorityClass = 'priority-high';
                        elseif ($task['priority'] == 'medium') $priorityClass = 'priority-medium';
                        else $priorityClass = 'priority-low';
                    ?>
                    <div class="card task-card <?= $priorityClass ?>">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="card-title"><?= htmlspecialchars($task['title']) ?></h5>
                                    <p class="card-text text-muted small"><?= nl2br(htmlspecialchars($task['description'])) ?></p>
                                    <?php if ($task['due_date']): ?>
                                        <span class="badge bg-secondary">📅 Vence: <?= date('d/m/Y', strtotime($task['due_date'])) ?></span>
                                    <?php endif; ?>
                                    <span class="badge bg-info ms-1">Prioridad: 
                                        <?php if ($task['priority'] == 'high'): ?>Alta
                                        <?php elseif ($task['priority'] == 'medium'): ?>Media
                                        <?php else: ?>Baja<?php endif; ?>
                                    </span>
                                    <?php if ($task['status'] == 'completed'): ?>
                                        <span class="badge bg-success ms-1">✔ Completada</span>
                                    <?php endif; ?>
                                </div>
                                <div class="btn-group">
                                    <?php if ($task['status'] == 'pending'): ?>
                                        <a href="toggle_status.php?id=<?= $task['id'] ?>&filter=<?= $filter ?>" class="btn btn-sm btn-outline-success" title="Marcar completada">
                                            <i class="bi bi-check-lg"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="toggle_status.php?id=<?= $task['id'] ?>&filter=<?= $filter ?>" class="btn btn-sm btn-outline-secondary" title="Reabrir">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="edit_task.php?id=<?= $task['id'] ?>&filter=<?= $filter ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="confirmDelete(<?= $task['id'] ?>, '<?= $filter ?>')" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function confirmDelete(taskId, filter) {
    if (confirm('¿Eliminar esta tarea permanentemente?')) {
        window.location.href = 'delete_task.php?id=' + taskId + '&filter=' + filter;
    }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>