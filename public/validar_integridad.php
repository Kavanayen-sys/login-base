<?php
/**
* Módulo de Verificación de Integridad HMAC-SHA256
* Demostración de cómo asegurar que un mensaje no ha sido alterado
*
* HMAC = Hash-based Message Authentication Code
* Combina una clave secreta con SHA-256 para generar una firma
*/

/**
* ¿Cómo funciona el flujo HMAC?
* 1. Servidor y cliente comparten una clave secreta.
* 2. El servidor genera la firma: firma = HMAC(payload, clave_secreta).
* 3. El cliente transmite el payload junto con la firma.
* 4. El servidor recalcula el HMAC del payload recibido y compara usando
hash_equals().
* 5. Si coinciden , se garantiza que los datos son auténticos y no han sido
modificados.
*/


// Clave secreta para HMAC (¡CAMBIAR EN PRODUCCIÓN!)
$clave_secreta = "FirmaSuperSeguraServidor2026";
// Datos de ejemplo (simulando una transferencia bancaria)
$payload = "user_id=1&monto=5000&destino=CuentaA";
$payload_modificado = "user_id=1&monto=5000&destino=CuentaB";
/**
* PASO 1: Generar firma para el payload original
*/
$firma_original = hash_hmac('sha256', $payload, $clave_secreta);
/**
* PASO 2: Generar firma para el payload modificado
*/
$firma_modificada = hash_hmac('sha256', $payload_modificado , $clave_secreta);
// ============================================
// MOSTRAR RESULTADOS EN LA INTERFAZ
// ============================================
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación de Integridad HMAC</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .payload {
            background: #f7fafc;
            padding: 15px;
            border-radius: 4px;
            font-family: monospace;
            margin: 10px 0;
        }
        .firma {
            background: #edf2f7;
            padding: 10px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 12px;
            word-break: break-all;
        }
        .exito { color: #276749; background: #f0fff4; padding: 10px; border-
            radius: 4px; }
        .error { color: #c53030; background: #fff5f5; padding: 10px; border-
            radius: 4px; }
        .comparacion { margin: 20px 0; padding: 15px; border-left: 4px solid #
            4299e1; background: #ebf8ff; }
    </style>
</head>
<body>
    <div class="container" style="max-width: 800px;">
        <div class="card">
            <h2>Verificación de Integridad HMAC-SHA256 </h2>
            <h3>Payload Original </h3>
            <div class="payload"><?php echo htmlspecialchars($payload); ?></div>
            <p><strong>Firma HMAC:</strong ></p>
            <div class="firma"><?php echo $firma_original; ?></div>

            <hr style="margin: 20px 0;">

            <h3>Payload Modificado </h3>
            <div class="payload"><?php echo htmlspecialchars($payload_modificado
                ); ?></div>
            <p><strong>Firma HMAC:</strong ></p>
            <div class="firma"><?php echo $firma_modificada; ?></div>

            <hr style="margin: 20px 0;">

            <h3>Comparación de Firmas </h3>

            <div class="comparacion">
                <h4>Prueba 1: Verificación de Payload Legítimo </h4>
                <?php if (hash_equals($firma_original , $firma_original)): ?>
                    <div class="exito">FIRMA VÁLIDA: El payload no ha sido
                        alterado </div>
                <?php else: ?>
                    <div class="error">FIRMA INVÁLIDA: El payload ha sido
                        modificado </div>
                <?php endif; ?>
            </div>
             
            <div class="comparacion">
                <h4>Prueba 2: Verificación de Payload Modificado </h4>
                <?php if (hash_equals($firma_original , $firma_modificada)): ?>
                    <div class="exito">FIRMA VÁLIDA: El payload no ha sido
                        alterado </div>
                <?php else: ?>
                    <div class="error">FIRMA INVÁLIDA: ¡El payload ha sido
                        modificado!</div>
                <?php endif; ?>
            </div>

            <hr style="margin: 20px 0;">

            <div style="background: #ebf8ff; padding: 15px; border-radius: 4px;
                margin-top: 20px;">
                <h4>Explicación de HMAC</h4>
                <p><strong>HMAC</strong> (Hash-based Message Authentication Code
                    ) combina:</p>
                <ul>
                    <li>Una <strong>clave secreta </strong> conocida solo por el
                    servidor </li>
                    <li>El <strong>payload </strong> (datos a proteger)</li>
                    <li>La función hash <strong>SHA-256</strong ></li>
                </ul>
                <p>Si el payload cambia aunque sea 1 carácter, la firma cambia
                    completamente.</p>
                <p>La función <code>hash_equals()</code> previene ataques de
                    timing.</p>
                </div>
                <p class="link" style="margin-top: 20px;"><a href="dashboard.php">&
                    larr; Volver al Dashboard </a></p>
            </div>
        </div>
    </body>
</html> 