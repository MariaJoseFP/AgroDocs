<?php
// guardar_en_bd.php
include("../php/conexion.php");

// Recibir datos del cliente
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si se recibieron datos
if (isset($data['datos'])) {
    $datos = $data['datos'];

    // Iterar sobre los datos y guardar en la base de datos (ajusta según tu estructura de BD)
    foreach ($datos as $fila) {
        $Fecha_expedicion = $fila['Fecha_expedicion'];
        $Traslado = $fila['Traslado'];
        $Cliente = $fila['Cliente'];
        $Pollos = $fila['Pollos'];
        $Granja = $fila['Granja'];
        //$Lote = $fila['Lote'];
        $Destino = $fila['Destino'];
        $Unidad = $fila['Unidad'];
        $Remol= $fila['Remol.'];
        $Operador = $fila['Operador'];
        $Rejas = $fila['Rejas'];
        $Permisionario = $fila['Permisionario'];
       // $Folio = $fila['Folio'];
       // $Estatus = $fila['Estatus'];
        // ... ajusta las columnas según tu estructura de BD

        // Preparar la consulta SQL
        $sql = "INSERT INTO `programacion`(`Fecha_expedicion`, `Traslado`, `Cliente`, `Pollos`, `Granja`, `Destino`, `Unidad`, `Remol.`, `Operador`, `Rejas`, `Permisionario`) 
        VALUES ('$Fecha_expedicion', '$Traslado', '$Cliente', '$Pollos', '$Granja', '$Destino', '$Unidad', '$Remol', '$Operador', '$Rejas', '$Permisionario')";
        
        // Ejecutar la consulta
        try {
            if ($conn->query($sql) === TRUE) {
                $response['status'] = 'Éxito';
            } else {
                $response['status'] = 'Error al insertar en la base de datos';
                throw new Exception($conn->error);
            }
        } catch (Exception $e) {
            $response['status'] = $e->getMessage();
        }
    }
} else {
    $response['status'] = 'No se recibieron datos';
}

// Enviar la respuesta al cliente (en formato JSON)
header('Content-Type: application/json');
echo json_encode($response);

// Cerrar la conexión a la base de datos
$conn->close();
?>
