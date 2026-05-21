<?php
session_start();

/*
|--------------------------------------------------------------------------
| CONEXIÓN
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../conexion.php';

/*
|--------------------------------------------------------------------------
| DATOS DEL FORMULARIO
|--------------------------------------------------------------------------
*/

$correo = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';

if ($correo === '' || $password === '') {

    header("Location: login.php?error=campos");
    exit();

}

/*
|--------------------------------------------------------------------------
| BUSCAR ADMIN
|--------------------------------------------------------------------------
*/

$stmtAdmin = $pdo->prepare("
    SELECT * FROM administradores
    WHERE correo = :correo
    LIMIT 1
");

$stmtAdmin->execute([
    'correo' => $correo
]);

$admin = $stmtAdmin->fetch();

/*
|--------------------------------------------------------------------------
| VALIDAR ADMIN
|--------------------------------------------------------------------------
*/

if ($admin && password_verify($password, $admin['password'])) {

    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_correo'] = $admin['correo'];
    $_SESSION['rol'] = 'admin';

    header("Location: admin.php");
    exit();

}

/*
|--------------------------------------------------------------------------
| BUSCAR USUARIO NORMAL
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT * FROM usuarios
    WHERE correo = :correo
    LIMIT 1
");

$stmt->execute([
    'correo' => $correo
]);

$usuario = $stmt->fetch();

/*
|--------------------------------------------------------------------------
| VALIDAR USUARIO
|--------------------------------------------------------------------------
*/

if ($usuario && password_verify($password, $usuario['password'])) {

    $_SESSION['usuario'] = $usuario['nombre'];
    $_SESSION['correo'] = $usuario['correo'];
    $_SESSION['rol'] = 'usuario';

    header("Location: index.php");
    exit();

}

/*
|--------------------------------------------------------------------------
| SI FALLA TODO
|--------------------------------------------------------------------------
*/

header("Location: login.php?error=credenciales");
exit();