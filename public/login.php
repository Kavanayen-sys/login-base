<?php
session_start();

require_once '../config/database.php';

$error = '';
$success = '';
$identifier = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$identifier = trim($_POST['identifier'] ?? '');
	$password = $_POST['password'] ?? '';

	if ($identifier === '' || $password === '') {
		$error = 'Todos los campos son requeridos.';
	} else {
		$stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE username = ? OR email = ? LIMIT 1');
		$stmt->execute([$identifier, $identifier]);
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($user && password_verify($password, $user['password'])) {
			session_regenerate_id(true);
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['username'] = $user['username'];
			$_SESSION['login_time'] = date('Y-m-d H:i:s');
			header('Location: dashboard.php');
			exit;
		} else {
			$error = 'Usuario, email o contraseña incorrectos.';
		}
	}
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Iniciar sesión</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<main class="container">
		<section class="card">
			<h2>Iniciar sesión</h2>

			<?php if ($error): ?>
				<div class="alert alert-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
			<?php endif; ?>

			<?php if ($success): ?>
				<div class="alert alert-success"><?php echo $success; ?></div>
			<?php endif; ?>

			<form method="POST" action="login.php">
				<div class="form-group">
					<label for="identifier">Usuario o email</label>
					<input type="text" id="identifier" name="identifier" value="<?php echo htmlspecialchars($identifier, ENT_QUOTES, 'UTF-8'); ?>" autocomplete="username" required>
				</div>

				<div class="form-group">
					<label for="password">Contraseña</label>
					<input type="password" id="password" name="password" autocomplete="current-password" required>
				</div>

				<button type="submit" class="btn btn-primary">Entrar</button>
			</form>

			<p class="link">¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
		</section>
	</main>
</body>
</html>/**
* Página de inicio de sesión
* Verifica credenciales usando password_verify() para comparación segura
*/
// password_verify() compara la contraseña ingresada con el hash almacenado
// Es seguro contra ataques de timing
