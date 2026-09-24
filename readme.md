# Sistema de Login con Criptografía Aplicada
## Descripción
Sistema web desarrollado en PHP y MySQL que implementa los cuatro pilares
criptográficos fundamentales:
- **Hash Bcrypt**: Almacenamiento seguro de contraseñas.
- **Cifrado Simétrico AES-256-CBC**: Protección de datos sensibles en reposo.
- **Cifrado Asimétrico RSA-2048**: Generación e intercambio seguro de tokens.
- **HMAC-SHA256**: Verificación de integridad de mensajes.
## Características de Seguridad
- Contraseñas con salting automático mediante `password_hash()`.
- Números telefónicos cifrados con AES-256 en modo CBC.
- Intercambio de tokens de sesión mediante par de claves RSA (2048 bits).
- Comprobación de alteración de mensajes con HMAC y `hash_equals()`.
## Estructura del Proyecto
login-base/
config/
database.php
crypto.php
publica.key
public/
index.php
login.php
register.php
dashboard.php
validar_integridad.php
style.css
# Conexión PDO
# Módulos criptográficos AES y RSA
# Clave pública RSA
.gitignore
# Reglas de exclusión de seguridad
## Requisitos e Instalación
1. Clonar repositorio localmente.
2. Crear la base de datos `login_system ` en MySQL.
3. Ejecutar las tablas y alterations DDL provistas en las guías.
4. Generar el par de claves ejecutando `config/generar_rsa.php`.
5. Acceder a `http://localhost/login-base/public/register.php`.
## Tecnologías Utilizadas
- PHP 7.4+ / MySQL
- OpenSSL (Extensión criptográfica)
- HTML5 / CSS3
- Git / GitHub