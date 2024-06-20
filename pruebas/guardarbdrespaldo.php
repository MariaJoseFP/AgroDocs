<?php


// Recibir datos del cliente
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si se recibieron datos
if (isset($data['datosTabla'])) {
    $datos = $data['datosTabla'];

    // Iterar sobre los datos y guardar en la base de datos (ajusta según tu estructura de BD)
    foreach ($datos as $fila) {
        $Fecha_expedicion = isset($fila['Fecha_expedicion']) ? $fila['Fecha_expedicion'] : null;
        $Traslado = isset($fila['Traslado']) ? $fila['Traslado'] : null;
        $Cliente = isset($fila['Cliente']) ? $fila['Cliente'] : null;
        $Pollos = isset($fila['Pollos']) ? $fila['Pollos'] : null;
        $Granja = isset($fila['Granja']) ? $fila['Granja'] : null;
        $Lote = isset($fila['Lote']) ? $fila['Lote'] : null;
        $Destino = isset($fila['Destino']) ? $fila['Destino'] : null;
        $Unidad = isset($fila['Unidad']) ? $fila['Unidad'] : null;
        $Remol = isset($fila['Remol.']) ? $fila['Remol.'] : null;
        $Operador = isset($fila['Operador']) ? $fila['Operador'] : null;
        $Rejas = isset($fila['Rejas']) ? $fila['Rejas'] : null;
        $Permisionario = isset($fila['Permisionario']) ? $fila['Permisionario'] : null;
        $Lote = isset($fila['Lote']) ? $fila['Lote'] : null;
        $Folio = isset($fila['Folio']) ? $fila['Folio'] : null;
        $Estatus = isset($fila['Estatus']) ? $fila['Estatus'] : null;


        // Preparar la consulta SQL
        $sql = "INSERT INTO `programacion`(`Fecha_expedicion`, `Traslado`, `Cliente`, `Pollos`, `Granja`, `Lote`, `Destino`, `Unidad`, `Remol.`, `Operador`, `Rejas`, `Permisionario`, `Folio`, `Estatus`) 
        VALUES ('$Fecha_expedicion', '$Traslado', '$Cliente', '$Pollos', '$Granja', '$Lote', '$Destino', '$Unidad', '$Remol', '$Operador', '$Rejas', '$Permisionario', '$Folio', '$Estatus')";
        insert($sql);
        
    }
    //si solo se envia un dato y no varios (omite el foeach)
} elseif (isset($data['datosForm'])) {
    $datos = $data['datosForm'];
        $Fecha_expedicion = isset($datos['Fecha_expedicion']) ? $datos['Fecha_expedicion'] : null;
        $Traslado = isset($datos['Traslado']) ? $datos['Traslado'] : null;
        $Cliente = isset($datos['Cliente']) ? $datos['Cliente'] : null;
        $Pollos = isset($datos['Pollos']) ? $datos['Pollos'] : null;
        $Granja = isset($datos['Granja']) ? $datos['Granja'] : null;
        $Lote = isset($datos['Lote']) ? $datos['Lote'] : null;
        $Destino = isset($datos['Destino']) ? $datos['Destino'] : null;
        $Unidad = isset($datos['Unidad']) ? $datos['Unidad'] : null;
        $Remol = isset($datos['Remol.']) ? $datos['Remol.'] : null;
        $Operador = isset($datos['Operador']) ? $datos['Operador'] : null;
        $Rejas = isset($datos['Rejas']) ? $datos['Rejas'] : null;
        $Permisionario = isset($datos['Permisionario']) ? $datos['Permisionario'] : null;
        $Lote = isset($datos['Lote']) ? $datos['Lote'] : null;
        $Folio = isset($datos['Folio']) ? $datos['Folio'] : null;
        $Estatus = isset($datos['Estatus']) ? $datos['Estatus'] : null;

    // Preparar la consulta SQL
    $sql = "INSERT INTO `programacion`(`Fecha_expedicion`, `Traslado`, `Cliente`, `Pollos`, `Granja`, `Lote`, `Destino`, `Unidad`, `Remol.`, `Operador`, `Rejas`, `Permisionario`, `Folio`, `Estatus`) 
    VALUES ('$Fecha_expedicion', '$Traslado', '$Cliente', '$Pollos', '$Granja', '$Lote', '$Destino', '$Unidad', '$Remol', '$Operador', '$Rejas', '$Permisionario', '$Folio', '$Estatus')";
    insert($sql);

} else {
    $response['status'] = 'No se recibieron datos';
}





function insert($sql)
{
    // guardar_en_bd.php
    include("conexion.php");
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
    // Cerrar la conexión a la base de datos
    $conn->close();
    // Enviar la respuesta al cliente (en formato JSON)
    header('Content-Type: application/json');
    echo json_encode($response);
}
