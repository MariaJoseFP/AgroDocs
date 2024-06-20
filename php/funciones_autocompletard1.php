<?php
include "conexion.php";  // Archivo con la conexión a la base de datos


if (isset($_GET['granja'])) {
    $granja = $_GET['granja'];
    $sql = "SELECT granja FROM granjas";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conn));
    }

    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    mysqli_close($conn);

    header('Content-Type: application/json');
    echo json_encode($data);
}
if (isset($_GET['cliente'])) {
    $nombre = $_GET['cliente'];

    // Consulta SQL para obtener datos del usuario
    $sql = "SELECT cliente, municipio FROM clientes WHERE cliente = '" . $nombre . "'";

    $result = mysqli_query($conn, $sql);
    $cliente = " ";
    $municipio = " ";
    // Verifica si hay resultados
    if ($result->num_rows > 0) {
        // Obtiene la primera fila (asumiendo que el número económico es único)
        while ($row = mysqli_fetch_array($result)) {
            $cliente = $row['cliente'];
            $municipio = $row['municipio'];
        }
    }
    $conn->close();

    // Devolver los datos como JSON
    echo json_encode(array('cliente' => $cliente, 'municipio' => $municipio));
}
if (isset($_GET['unidad'])) {
    $unidad = $_GET['unidad'];
    info_vehiculo($conn,$unidad);
}
if (isset($_GET['remolq'])) {
    $remolq = $_GET['remolq'];
    info_remolque($conn,$remolq);
}

function info_vehiculo($conn,$unidad)
{
    include("conexion.php");
    $sql = "SELECT numero_unidad,razon_social,tipo_unidad,marca, modelo,año,placas_tr, placas_plana, área FROM unidades WHERE numero_unidad = '" . $unidad . "'";
    $result = mysqli_query($conn, $sql);

    // Verifica si hay resultados
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = mysqli_fetch_array($result)) {
            if( $row['área'] == 'PERMISIONARIO'){
                $razon_social = $row['razon_social'];
            }else{
                $razon_social = "";
            }
            $data= array('tipo_unidad' => $row['tipo_unidad'],'marca' => $row['marca'], 'placas_tr' => $row['placas_tr'], 'modelo' => $row['modelo'],'año' => $row['año'], 'placas_plana' => $row['placas_plana'], 'permisionario' => $razon_social);
        }
        
        echo json_encode($data);
    }
    $conn->close();
}

function info_remolque($conn,$remolq){

    $sql = "select NUMERO_UNIDAD,PLACAS_PLANA FROM UNIDADES WHERE NUMERO_UNIDAD ='" . $remolq . "'";
    $result = mysqli_query($conn, $sql);

    // Verifica si hay resultados
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = mysqli_fetch_array($result)) {
            $data= array('Remolq' => $row['NUMERO_UNIDAD'],'placas_plana' =>  $row['PLACAS_PLANA']);
        }
        
    }else{
        $data= array('Remolq' => '','placas_plana' =>  '');
    }
    
    echo json_encode($data);
    $conn->close();
}