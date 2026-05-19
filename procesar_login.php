<?php

session_start();

require_once "conexion.php";

$correo = trim($_POST['correo'] ?? '');

$password = $_POST['password'] ?? '';

if ($correo === '' || $password === '') {

    header("Location: login.php?error=campos");

    exit();
}






/* =========================
   VALIDAR ADMINISTRADOR
========================= */

$stmtAdmin = $pdo->prepare(
    "SELECT correo, password
    FROM administradores
    WHERE correo = :correo
    LIMIT 1"
);

$stmtAdmin->execute([
    'correo' => $correo
]);

$admin = $stmtAdmin->fetch();

if ($administradores && password_verify($password, $administradores['password'])) {

    $_SESSION['admin'] = $admin['correo'];

    header("Location: admin.php");

    exit();
}






/* =========================
   VALIDAR USUARIO NORMAL
========================= */

$stmt = $pdo->prepare(
    "SELECT nombre, correo, password
    FROM usuarios
    WHERE correo = :correo
    LIMIT 1"
);

$stmt->execute([
    'correo' => $correo
]);

$usuario = $stmt->fetch();

if ($usuario && password_verify($password, $usuario['password'])) {

    $_SESSION['usuario'] = $usuario['nombre'];

    $_SESSION['correo'] = $usuario['correo'];

    header("Location: index.php");

    exit();
}

header("Location: login.php?error=credenciales");

exit();