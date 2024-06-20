<?php
include("conexion.php");

// Recibir datos del cliente
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si se recibieron datos
if (isset($data['datosTraslado'])) {
    $datos = $data['datosTraslado'];
    $Traslado = $datos['Traslado'];

    $sql = "UPDATE `programacion` SET `Traslado`='" . $Traslado . "',`Cliente`='" . $datos['Cliente'] . "',`Pollos`='" . $datos['Pollos'] . "',
    `Granja`='" . $datos['Granja'] . "',`Lote`='" . $datos['Lote'] . "',`Destino`='" . $datos['Destino'] . "',`Unidad`='" . $datos['Unidad'] . "',
    `Remol`='" . $datos['Remol'] . "',`Operador`='" . $datos['Operador'] . "',`Rejas`='" . $datos['Rejas'] . "',`Permisionario`='" . $datos['Permisionario'] . "',
    `Folio`='" . $datos['Folio'] . "',`Estatus`='" . $datos['Estatus'] . "',`Placas_plana`= '" . $datos['Placas_plana'] . "'  WHERE Traslado = " . $Traslado;
    try {
        if ($conn->query($sql) === TRUE) {
            $response['status'] = 'Éxito';
        } else {
            $response['status'] = 'Error al actualizar en la base de datos';
            throw new Exception($conn->error);
        }
    } catch (Exception $e) {
        $response['status'] = $e->getMessage();
    }
} else if (isset($_POST['datosTablas'])) {
    $datosT = $_POST['datosTablas'];
    $tabla = $_POST['tabla'];
    $clave = $_POST['clave'];

    switch ($tabla) {
        case "unidades":
            $sql2 = "UPDATE `unidades` SET 
                `NUMERO_UNIDAD`='" . $datosT['NUMERO_UNIDAD'] . "',
                `RAZON_SOCIAL`='" . $datosT['RAZON_SOCIAL'] . "',
                `TIPO_UNIDAD`='" . $datosT['TIPO_UNIDAD'] . "',
                `MARCA`='" . $datosT['MARCA'] . "',
                `MODELO`='" . $datosT['MODELO'] . "',
                `AÑO`='" . $datosT['AÑO'] . "',
                `PLACAS_TR`='" . $datosT['PLACAS_TR'] . "',
                `PLACAS_PLANA`='" . $datosT['PLACAS_PLANA'] . "',
                `ÁREA`='" . $datosT['ÁREA'] . "',
                `RESPONSABLE`='" . $datosT['RESPONSABLE'] . "',
                `NUM_REJAS`='" . $datosT['NUM_REJAS'] . "',
                `REJAS_PROPIAS/AGRO`='" . $datosT['REJAS_PROPIAS/AGRO'] . "',
                `FECHA_PRESTAMO`='" . $datosT['FECHA_PRESTAMO'] . "',
                `OBSERVACION`='" . $datosT['OBSERVACION'] . "'
            WHERE `NUMERO_UNIDAD` = '".$clave."'";

            break;
        case "clientes":
            $sql2 = "UPDATE `clientes` SET 
            `CLIENTE`='" . $datosT['CLIENTE'] . "',
            `LOCALIDAD`='" . $datosT['LOCALIDAD'] . "',
            `MUNICIPIO`='" . $datosT['MUNICIPIO'] . "',
            `ESTADO`='" . $datosT['ESTADO'] . "' 
            WHERE `CLIENTE` = '".$clave."'"; 
            break;
        case "granjas":
            $sql2 = "UPDATE `granjas` SET 
            `GRANJA`='" . $datosT['GRANJA'] . "',
            `UPA`='" . $datosT['UPA'] . "',
            `LOCALIDAD`='" . $datosT['LOCALIDAD'] . "',
            `MUNICIPIO`='" . $datosT['MUNICIPIO'] . "',
            `ESTADO`='" . $datosT['ESTADO'] . "' WHERE `UPA` = '".$clave."'";
            break;
        default:
            echo "Opción no reconocida";
            exit();
    }
    try {
        if ($conn->query($sql2) === TRUE) {
            $response['status'] = 'Éxito';
        } else {
            $response['status'] = $conn->error;
            throw new Exception($conn->error);
        }
    } catch (Exception $e) {
        $response['status'] = $e->getMessage();
    }
}
// Enviar la respuesta al cliente (en formato JSON)
header('Content-Type: application/json');
echo json_encode($response);
// Close the connection
$conn->close();
