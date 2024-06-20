<?php
// guardar_en_bd.php
include("conexion.php");

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
        $Remol = isset($fila['Remol']) ? $fila['Remol'] : null;
        $Operador = isset($fila['Operador']) ? $fila['Operador'] : null;
        $Rejas = isset($fila['Rejas']) ? $fila['Rejas'] : null;
        $Permisionario = isset($fila['Permisionario']) ? $fila['Permisionario'] : null;
        $Folio = isset($fila['Folio']) ? $fila['Folio'] : null;
        $Estatus = isset($fila['Estatus']) ? $fila['Estatus'] : null;
        
        //Obtener las placas del remolque
        $sql_remolq = "select NUMERO_UNIDAD,PLACAS_PLANA FROM UNIDADES WHERE NUMERO_UNIDAD ='" . $Remol . "'";
        $result = mysqli_query($conn, $sql_remolq);
        // Verifica si hay resultados
        if ($result->num_rows > 0) {
            $data = array();
            while ($row = mysqli_fetch_array($result)) {
                $Placas_plana=   $row['PLACAS_PLANA'];
            }
            
        }else{
            $Placas_plana= NULL;
        }

        // Preparar la consulta SQL
        $sql = "INSERT INTO `programacion`(`Fecha_expedicion`, `Traslado`, `Cliente`, `Pollos`, `Granja`, `Lote`, `Destino`, `Unidad`, `Remol`, `Operador`, `Rejas`, `Permisionario`, `Folio`, `Estatus`, `Placas_plana`)
        VALUES ('$Fecha_expedicion', '$Traslado', '$Cliente', '$Pollos', '$Granja', '$Lote', '$Destino', '$Unidad', '$Remol', '$Operador', '$Rejas', '$Permisionario', '$Folio', '$Estatus' ,'$Placas_plana')";

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
} else if (isset($data['datosForm'])) {
    $fila = $data['datosForm'];
    $Fecha_expedicion = isset($fila['Fecha_expedicion']) ? $fila['Fecha_expedicion'] : null;
    $Fecha_vigencia = isset($fila['Fecha_vigencia']) ? $fila['Fecha_vigencia'] : null;
    $Traslado = isset($fila['Traslado']) ? $fila['Traslado'] : null;
    $Cliente = isset($fila['Cliente']) ? $fila['Cliente'] : null;
    $Pollos = isset($fila['Pollos']) ? $fila['Pollos'] : null;
    $Granja = isset($fila['Granja']) ? $fila['Granja'] : null;
    $Lote = isset($fila['Lote']) ? $fila['Lote'] : null;
    $Destino = isset($fila['Destino']) ? $fila['Destino'] : null;
    $Unidad = isset($fila['Unidad']) ? $fila['Unidad'] : null;
    $Remol = isset($fila['Remol']) ? $fila['Remol'] : null;
    $Operador = isset($fila['Operador']) ? $fila['Operador'] : null;
    $Rejas = isset($fila['Rejas']) ? $fila['Rejas'] : null;
    $Permisionario = isset($fila['Permisionario']) ? $fila['Permisionario'] : null;
    $Folio = isset($fila['Folio']) ? $fila['Folio'] : null;
    $Estatus = isset($fila['Estatus']) ? $fila['Estatus'] : null;
    $Placas_plana = isset($fila['placas_plana']) ? $fila['placas_plana'] : null;
    // Verificar y asignar los valores solo si están presentes en el arreglo


    // Preparar la consulta SQL
    $sql = "INSERT INTO `programacion`(`Fecha_expedicion`, `Traslado`, `Cliente`, `Pollos`, `Granja`, `Lote`, `Destino`, `Unidad`, `Remol`, `Operador`, `Rejas`, `Permisionario`, `Folio`, `Estatus`, `Placas_plana`) 
        VALUES ('$Fecha_expedicion', '$Traslado', '$Cliente', '$Pollos', '$Granja', '$Lote', '$Destino', '$Unidad', '$Remol', '$Operador', '$Rejas', '$Permisionario', '$Folio', '$Estatus','$Placas_plana')";

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
} else {
    $response['status'] = 'No se recibieron datos';
}

// Enviar la respuesta al cliente (en formato JSON)
header('Content-Type: application/json');
echo json_encode($response);

// Cerrar la conexión a la base de datos
$conn->close();