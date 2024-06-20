<?php
// Datos de conexión a la base de datos
$host = '192.168.0.162';
$dbname = 'movilizacion';
$username = 'INTE-004';
$password = '';

// Crear conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Tu código aquí...

?>