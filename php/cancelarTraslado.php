<?php
include("conexion.php");

// Recibir datos del cliente
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si se recibieron datos
if (isset($_GET['traslado'])) {

    $Traslado = $_GET['traslado'];

    $sql = "UPDATE `programacion` SET `Estatus`= 'CANCELADO'  WHERE Traslado = ". $Traslado;
    try {
        if ($conn->query($sql) === TRUE) {
            $response['status'] = 'OK';
        } else {
            $response['status'] = 'Error al actualizar en la base de datos';
            throw new Exception($conn->error);
        }
    } catch (Exception $e) {
        $response['status'] = $e->getMessage();
    }
    // Enviar la respuesta al cliente (en formato JSON)
    header('Content-Type: application/json');
    echo json_encode($response);
    $conn->close();
}
