<?php
include("conexion.php");

// Recibir datos del cliente
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si se recibieron datos
if (isset($_GET['id']) && isset($_GET['doc'])) {
    
    $folio = $_GET['id'];
    $doc = $_GET['doc'];
    $motivo = $_GET['motivo'];

    if($doc == 'constancia'){
        $sql = "UPDATE `constancias_de_lavado` SET `propietario_responsable`='CANCELADA',`marca`='CANCELADA',`placas_cabina`='CANCELADA',
        `placas_remolque`='CANCELADA',`upp`='CANCELADA', `status`='CANCELADA',`motivo_cancelacion`= '".$motivo."' WHERE FOLIO = '".$folio."'";
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
    
    }else if($doc == 'guia'){
        $sql = "UPDATE `guias_pollo` SET `nombre_remitente`='CANCELADA',`upp_psg`='CANCELADA',`nombre_destinatario`='CANCELADA',
        `localidad_origen`='CANCELADA',`municipio_origen`='CANCELADA',`estado_origen`='CANCELADA',`localidad_destino`='CANCELADA',`municipio_destino`='CANCELADA',
        `estado_destino`='CANCELADA',`especie`='CANCELADA',`mercancia`='CANCELADA',`cantidad`='CANCELADA',`unidad_medida`='CANCELADA',`motivo_transporte`='CANCELADA',
        `nombre_transportista`='CANCELADA',`marca`='CANCELADA',`modelo`='CANCELADA',`color`='CANCELADA',`placas`='CANCELADA',`remolque`='CANCELADA',
        `responsable_doc`='CANCELADA', `status`='CANCELADA', `motivo_cancelacion`= '".$motivo."' WHERE No_expediente = '".$folio."'";
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
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    $conn->close();
}
