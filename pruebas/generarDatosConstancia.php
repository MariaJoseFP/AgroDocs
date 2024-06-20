<?php

///ESTE DOCUMENTO SOLO GENERA LOS DATOS DE LA UNIDAD PUES EL RESTO YA SE OBTUVIERON EN EL DOC GENERARDATOSAVISO.PHP
include("conexion.php");
if (isset($_GET['data'])) {

        // Decodificar el JSON a un array asociativo
        $datosProgra = json_decode($_GET['data'], true);
        $datosUnidad = info_vehiculo( $datosProgra['Unidad'],$conn);
        $response = array("status" => "success", "datosUnidad" => $datosUnidad );
        
    } else {
        // En caso de error en la consulta
        $response = array("status" => "error", "message" => "No se recibieron datos");
    }

// Enviar la respuesta al cliente (en formato JSON)
header('Content-Type: application/json');
echo json_encode($response);

function info_vehiculo($unidad,$conn)
{
    $sql = "SELECT numero_unidad,marca, modelo,año,placas_tr, placas_plana FROM unidades WHERE numero_unidad = '" . $unidad . "'";
    $result = mysqli_query($conn, $sql);

    // Verifica si hay resultados
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = mysqli_fetch_array($result)) {
            $data= array('marca' => $row['marca'], 'placas_tr' => $row['placas_tr'], 'modelo' => $row['año'], 'placas_plana' => $row['placas_plana']);
        }
        
        return json_encode($data);
    }
    $conn->close();
}