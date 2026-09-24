<?php
session_start();
require_once '../config/database.php';
require_once '../config/crypto.php';

// Verificar si el usuario esta logueado
if (!isset($_SESSION['user_id'])) {
header('Location: login.php');
exit;
}
// Cerrar sesion
if (isset($_GET['logout'])) {
session_destroy();
header('Location: login.php');
exit;
}
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
$telefono_descifrado = !empty($user['telefono_cifrado'])
? descifrarAES256($user['telefono_cifrado'])
: 'No registrado';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard </title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<div class="dashboard">
<div class="dashboard -header">
<h2>Panel de Usuario </h2>
<a href="?logout=1" class="btn btn-danger">Logout </a>
</div>

<div class="welcome">
<h3>Bienvenido , <?php echo htmlspecialchars($_SESSION['username'
]); ?></h3>
<p>Se ha registrado de manera correcta </p>
</div>
<div class="info-box">
<h4>Información de Sesión </h4>
<ul>
<li><strong>User ID:</strong> <?php echo $_SESSION['user_id'
]; ?></li>
<li><strong>Username:</strong> <?php echo htmlspecialchars(
$_SESSION['username']); ?></li>
<li><strong>Login time:</strong> <?php echo $_SESSION['
login_time'] ?? date('Y-m-d H:i:s'); ?></li>
</ul>
</div>
</div>
<div class="info-box" style="margin-top: 20px; background: #ebf8ff;">
<h4>Datos Cifrados (AES-256)</h4>
<ul>
<li><strong>Telefono en BD (cifrado):</strong>
<small><?php echo htmlspecialchars(substr($user['telefono_cifrado']
?? 'N/A', 0, 30)); ?>...</small>
</li>
<li><strong>Telefono descifrado:</strong>
    <?php echo htmlspecialchars($telefono_descifrado); ?>
</li>
<li><strong>Algoritmo:</strong> AES-256-CBC</li>    
</ul>
</div>
<div class="info-box" style="margin-top: 20px; background: #f0fff4;">
<h4>Datos Cifrados (RSA-2048)</h4>
<ul>
<li><strong>Token cifrado (Base64):</strong>
<small><?php echo htmlspecialchars(substr($_SESSION['token_rsa_cifrado'] ?? 'N/A', 0, 30)); ?>...</small>
</li>
<li><strong>Token descifrado:</strong>
<?php echo htmlspecialchars($_SESSION['token_rsa_descifrado'] ?? 'N/
A'); ?>
</li>
<li><strong>Algoritmo:</strong> RSA-2048</li>
</ul>
</div>
</div>

<!-- Enlace de demostración HMAC dentro del contenedor principal -->
<div style="margin-top: 20px; text-align: center;">
<a href="validar_integridad.php" target="_blank" class="btn btn-primary"
style="width: auto; padding: 10px 20px;">
4
4
5
6
Probar Validación HMAC
</a>
</div>

</body>
</html>