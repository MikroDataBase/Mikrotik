<?php
// Configuración de la base de datos
$host = "https://mikrotik-qwkw.vercel.app/"; // Cambia esto por tu host de MySQL
$username = "root"; // Cambia esto por tu usuario de MySQL
$password = ""; // Cambia esto a "" si tu usuario root no tiene contraseña
$database = "mikrotik-qwkw"; // Cambia esto por el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($host, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Establecer charset a utf8
$conn->set_charset("utf8");
?>
