<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    $errors = [];
    if (empty($username)) $errors[] = 'El nombre de usuario es obligatorio.';
    if (strlen($password) < 4) $errors[] = 'La contraseña debe tener al menos 4 caracteres.';
    if ($password !== $confirm) $errors[] = 'Las contraseñas no coinciden.';

    if (empty($errors)) {
        // Verificar si el usuario ya existe
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $errors[] = 'El nombre de usuario ya está registrado.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt->execute([$username, $hashed])) {
                $_SESSION['message'] = 'Registro exitoso. Ahora inicia sesión.';
                header('Location: login.php');
                exit;
            } else {
                $errors[] = 'Error al registrar usuario.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Panel de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .register-card { max-width: 500px; margin-top: 80px; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 register-card">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Crear cuenta</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $err) echo "<div>$err</div>"; ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" id="registerForm">
                        <div class="mb-3">
                            <label>Nombre de usuario</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Confirmar contraseña</label>
                            <input type="password" name="confirm_password" id="confirm" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                    </form>
                    <div class="mt-3 text-center">
                        ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        let pass = document.getElementById('password').value;
        let confirm = document.getElementById('confirm').value;
        if (pass !== confirm) {
            alert('Las contraseñas no coinciden');
            e.preventDefault();
        }
    });
</script>
</body>
</html>