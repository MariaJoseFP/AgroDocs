<?php
include("conexion.php");

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "";
//ASIGNAR EL QUERY DEPENDIENDO DE QUÉ SE DESEA VISUALIZAR 
if (isset($_GET['tabla'])) {
    // Obtener el valor del parámetro
    $valor = $_GET['tabla'];

    // Realizar acciones según el valor del parámetro
    switch ($valor) {
        case 'unidades':
            $sql = "SELECT * FROM `unidades`";
            break;

        case 'clientes':
            $sql = "SELECT * FROM `clientes`";
            break;

        case 'granjas':
            $sql = "SELECT * FROM `granjas`";
            break;

        default:
            echo 'no se recibieron datos';
    }
}

if (isset($_GET['clave'])) {
    // Obtener el valor del parámetro
    $valor = $_GET['tablaID'];
    $clave = $_GET['clave'];

    // Realizar acciones según el valor del parámetro
    switch ($valor) {
        case 'unidades':
            $sql = "SELECT * FROM `unidades` where `NUMERO_UNIDAD` = '".$clave."'";
            break;

        case 'clientes':
            $sql = "SELECT * FROM `clientes` WHERE `CLIENTE` = '".$clave."'";
            break;

        case 'granjas':
            $sql = "SELECT * FROM `granjas` WHERE `UPA` = '".$clave."'";
            break;

        default:
            echo 'no se recibieron datos';
    }
}


// Realizar la consulta a la base de datos
$result = $conn->query($sql);

// Retornar los resultados como JSON
$rows = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
     $rows[] = $row;
    }
    $status = "success";
}else{
    $status = "ERROR";
}
// Cerrar la conexión
$conn->close();

//echo json_encode($rows);
header('Content-Type: application/json');
echo json_encode(array("status" => $status, "data" => $rows));