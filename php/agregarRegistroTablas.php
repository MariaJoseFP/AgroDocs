<?php
include_once("conexion.php");

$datosT = $_POST['datosTablas'];
$tabla = $_POST['tabla'];

// Validar que datosT sea un array asociativo
if (is_array($datosT) && !empty($datosT)) {
    // Inicializar un array para almacenar los valores escapados
    $escapedValues = [];

    // Escapar y citar cada valor del array para prevenir SQL injection
    foreach ($datosT as $value) {
        $escapedValues[] = "'" . mysqli_real_escape_string($conn, $value) . "'";
    }

    // Crear la lista de campos y valores
    $fields = implode(', ', array_map(function ($key) use ($conn) {
        return "`" . mysqli_real_escape_string($conn, $key) . "`";
    }, array_keys($datosT)));
    $values = implode(', ', $escapedValues);
    
    // Construir y ejecutar la consulta SQL
    $sql = "INSERT INTO `$tabla` ($fields) VALUES ($values)";
    // Ejecutar la consulta
    if (mysqli_query($conn, $sql)) {
        $response = array('status' => 'OK', 'message' => 'Registro insertado correctamente.');
    } else {
        $response = array('status' => 'Error', 'message' => $conn->error);
    }
} else {
        $response = array('status' => 'Error', 'message' => 'Datos no válidos o vacíos.');
}

// Cerrar la conexión
$conn->close();
header('Content-Type: application/json');
echo json_encode($response);

?>