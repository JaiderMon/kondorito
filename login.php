<?php
session_start();

if(isset($_POST['usuario'])){
    $_SESSION['usuario'] = $_POST['usuario'];
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login - Kondorito Postres</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-pink-50 flex items-center justify-center min-h-screen">

<div class="bg-white shadow-xl rounded-2xl p-10 w-96">

<div class="text-center mb-6">
<h1 class="text-3xl font-bold text-pink-600">Kondorito</h1>
<p class="text-gray-500">Inicia sesión para continuar</p>
</div>

<form action="validar_login.php" method="POST" class="space-y-5">

<div>
<label class="block text-gray-600 mb-1">Correo electrónico</label>
<input 
type="email" 
name="correo"
placeholder="ejemplo@correo.com"
class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-400 focus:outline-none"
required>
</div>

<div>
<label class="block text-gray-600 mb-1">Contraseña</label>
<input 
type="password"
name="contrasena"
placeholder="********"
class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-400 focus:outline-none"
required>
</div>

<button 
type="submit"
class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 rounded-lg transition">
Iniciar sesión
</button>

</form>

<p class="text-center text-sm text-gray-500 mt-5">
¿No tienes cuenta?
<a href="#" class="text-pink-500 hover:underline">Regístrate</a>
</p>

</div>

</body>
</html>