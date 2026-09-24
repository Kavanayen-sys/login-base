<?php

session_start();

require_once '../config/database.php';
require_once '../config/database.php';
require_once '../config/crypto.php';

$error = '';

$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$username = trim($_POST['username']);

$email = trim($_POST['email']);

$telefono = trim($_POST['telefono'] ?? '');
$telefono_cifrado = !empty($telefono) ? cifrarAES256($telefono) : null;

$password = $_POST['password'];

$confirm_password = $_POST['confirm_password'];

if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {

$error = 'Todos los campos son requeridos';

} elseif ($password !== $confirm_password) {

$error = 'La contraseña registrada no coincide';

} elseif (strlen($password) < 6) {

$error = 'La contraseña debe tener un largo mínimo de 6 caracteres';

} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

$error = 'Formato de correo electronico invalido';

} else {$stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");

$stmt->execute([$username , $email]);

if ($stmt->rowCount() > 0) {

$error = 'Nombre de usuario o email existentes';

} else {

// Guardado temporal en texto plano (se corregira en el Paso 8)

// APLICAR HASH - Bcrypt con Salt automatica

$hashed_password = password_hash($password , PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username , email, password ,
telefono_cifrado) VALUES (?, ?, ?, ?)");
if ([$stmt->execute([$username , $email, $hashed_password , $telefono_cifrado])]) {

$success = '¡Registro exitoso!';

} else {

$error = 'Registro fallido. Por favor, intentelo nuevamente.';

// La funcion password_hash() genera un hash seguro con un salt aleatorio

// El hash es irreversible , protegiendo la contraseña incluso si la BD es robada

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

<title>Register </title>

<link rel="stylesheet" href="styles.css">

</head>

<body>

<div class="container">

<div class="card">

<h2>Register </h2>

<?php if ($error): ?>

<div class="alert alert-error"><?php echo $error; ?></div>

<?php endif; ?>

<?php if ($success): ?>

<div class="alert alert-success"><?php echo $success; ?></div>

<?php endif; ?>

<form method="POST">

<div class="form-group">

<label for="username">Nombre de usuario </label>

<input type="text" id="username" name="username" required>

</div>

<div class="form-group">

<label for="email">Email </label>

<input type="email" id="email" name="email" required>

</div>

<div class="form-group">
<label for="telefono">Telefono (opcional)</label>
<input type="text" id="telefono" name="telefono" placeholder="Ej: 555-1234">
</div>

<div class="form-group">

<label for="password">Password </label>

<input type="password" id="password" name="password" required>

</div>

<div class="form-group">

<label for="confirm_password">Confirme su Password </label>

<input type="password" id="confirm_password" name="confirm_password" required>

</div>

<button type="submit" class="btn btn-primary">Registrese </button>

</form>

<p class="link">¿Ya tienes cuenta? <a href="login.php">Ingresa </a></p>

</div>

</div>

</body>

</html>