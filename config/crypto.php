<?php
/**
* Módulo de Cifrado Simétrico AES-256-CBC
* Proporciona funciones para cifrar y descifrar datos sensibles
*/
// Clave de 32 bytes para AES-256 (¡CAMBIAR EN PRODUCCIÓN!)
define('CLAVE_AES_256', 'C1av3S3cr3t4P4r4A3S256_PHP2026!');
/**
* Cifra un texto plano usando AES-256-CBC
*
* @param string $textoPlano Texto a cifrar
* @return string Texto cifrado en Base64 (incluye IV)
*/
/**
* NOTA DE SEGURIDAD EN PRODUCCION:
* La clave AES-256 debe almacenarse en variables de entorno fuera de la raíz web,
* generarse mediante un RNG criptográficamente seguro y rotarse periódicamente.
*/
/**
* Cifra un mensaje con la clave pública RSA-2048
*/
function cifrarRSA($mensaje) {
$clavePublica = file_get_contents(__DIR__ . '/publica.key');
openssl_public_encrypt($mensaje , $cifrado , $clavePublica);
return base64_encode($cifrado);
}
/**
* Descifra un mensaje con la clave privada RSA-2048
*/
function descifrarRSA($mensajeCifrado) {
$clavePrivada = file_get_contents(__DIR__ . '/privada.key');
openssl_private_decrypt(base64_decode($mensajeCifrado), $descifrado ,
$clavePrivada);
return $descifrado;
}

function cifrarAES256($textoPlano) {
$metodo = 'aes-256-cbc';
$ivLength = openssl_cipher_iv_length($metodo);
$iv = openssl_random_pseudo_bytes($ivLength);
$textoCifrado = openssl_encrypt($textoPlano , $metodo, CLAVE_AES_256 , 0, $iv)
;
// Concatenar IV + texto cifrado y codificar en Base64
return base64_encode($iv . $textoCifrado);
}
/**
 * 
* Descifra un texto cifrado con AES-256-CBC
*
* @param string $cadenaBase64 Texto cifrado en Base64
* @return string Texto descifrado
*/
function descifrarAES256($cadenaBase64) {
$datosBinarios = base64_decode($cadenaBase64);
$metodo = 'aes-256-cbc';
$ivLength = openssl_cipher_iv_length($metodo);
// Extraer el IV de los primeros bytes
$iv = substr($datosBinarios , 0, $ivLength);
$textoCifrado = substr($datosBinarios , $ivLength);
return openssl_decrypt($textoCifrado , $metodo, CLAVE_AES_256 , 0, $iv);
}
?>