<?php
/**
* Generador de Par de Claves RSA-2048
* Genera la clave privada (privada.key) y pública (publica.key)
*/
$config = [
"digest_alg" => "sha256",
"private_key_bits" => 2048,
"private_key_type" => OPENSSL_KEYTYPE_RSA ,
];
// Generación de recursos criptográficos
$res = openssl_pkey_new($config);
// Extracción de la clave privada
openssl_pkey_export($res, $clavePrivada);
// Extracción de la clave pública
$detalles = openssl_pkey_get_details($res);
$clavePublica = $detalles["key"];
// Persistencia en archivos locales
file_put_contents(__DIR__ . '/privada.key', $clavePrivada);
file_put_contents(__DIR__ . '/publica.key', $clavePublica);
echo "Claves RSA-2048 generadas exitosamente.";
?>