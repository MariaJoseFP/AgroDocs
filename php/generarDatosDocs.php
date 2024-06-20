<?php
include("conexion.php");
if (isset($_GET['traslado'])) {
    $traslado = $_GET['traslado'];

    //REALIZAR LA CONSULTA  A LA BD DE LA PROGRAMACIÓN
    $sql = "SELECT * FROM programacion where Traslado =  " . $traslado;



    $resultado = $conn->query($sql);
    if ($resultado) {
        // Crear un array para almacenar los resultados
        $data = array();
        // Recorrer los resultados y agregarlos al array
        while ($fila = $resultado->fetch_assoc()) {
            $data = $fila;
            if (trim($fila['Granja']) != "") {
                $granja = trim($fila['Granja']);
            } else {
                $granja = NULL;
            }

            //DATOS OBTENIDOS DE LA PROGRAMACIÓN
            $traslado= trim($fila['Traslado']);
            $cliente = trim($fila['Cliente']);
            $unidad = trim($fila['Unidad']);
            $destino = trim($fila['Destino']);
            $remolque_progra = trim($fila['Remol']);
        }


        //DATOS DE LA BASE DE DATOS
        //CONSULTAR DATOS DE LAS GRANJAS

        if ($granja !== null) {
            // Realizar la consulta para obtener datos de la granja solo si $granja no es NULL
            $queryGranja = "SELECT granja, UPA,localidad, estado, municipio FROM granjas WHERE granja LIKE CONCAT('%', '$granja', '%')";
            $datos_granja = BuscaDatos($queryGranja, $conn);
            //EN CASO DE QUE NO EXISTA LA GRANJA EN LA BD ENTONCES MANDAMOS LOS DATOS INGRESADOS EN LA PROGRAMACIÓN
            if ($datos_granja === null) {
                $datos_granja = array("granja" => $granja,
                                    "estado" => '',
                                    "municipio" => '',
                                    "localidad" => '');
            }
        } else {
            // Manejar el caso cuando $granja es NULL
            $queryGranja = "SELECT granja, UPA, estado, municipio FROM granjas WHERE granja = '$granja'";
            $datos_granja = BuscaDatos($queryGranja, $conn);
        }


        //CONSULTAR DATOS DEL CLIENTES
        if ($granja !== null) {
            // Realizar la consulta para obtener datos de la granja solo si $granja no es NULL
            $queryCliente = "SELECT * from Clientes where cliente LIKE CONCAT('%', '$cliente', '%'); ";
            $datos_cliente = BuscaDatos($queryCliente, $conn);
            //EN CASO DE QUE NO EXISTA EL CLIENTE EN LA BD ENTONCES MANDAMOS LOS DATOS INGRESADOS EN LA PROGRAMACIÓN
            if ($datos_cliente === null) {
                $datos_cliente = array(
                    "CLIENTE" => $cliente,
                    "LOCALIDAD" => $destino,
                    "MUNICIPIO" => $destino,
                );
            }
        } else {
            // Manejar el caso cuando $cliente es NULL en la programación
            $queryCliente = "SELECT * from Clientes where cliente = '$cliente' ";
            $datos_cliente = BuscaDatos($queryCliente, $conn);
        }


        //CONSULTAR DATOS DEL VEHICULO
        $datos_unidad = info_vehiculo($unidad, $conn);
        if($datos_unidad === null){
            //Si la unidad no esta en la base de datos se le asigna a "tipo_unidad" el valor de remolque ingresado en la programación para más adelante
            //saber si se trata de un vehiculo que no requiera ingresar placas de remolque.
            $datos_unidad = array("unidad" => $unidad, "tipo_unidad" => $remolque_progra);
        }

        // Cerrar el resultado Y Cerrar la conexión a la base de datos
        $resultado->close();
        $conn->close();

        // Crear la respuesta JSON
        $response = array("status" => "success", "data" => $data, "datos_granja" => $datos_granja, "datos_cliente" => $datos_cliente, "datos_unidad" => $datos_unidad);
    } else {
        // En caso de error en la consulta
        $response = array("status" => "error", "message" => "Error en la consulta: " . $conn->error);
    }
}
// Enviar la respuesta al cliente (en formato JSON)
header('Content-Type: application/json');
echo json_encode($response);




//FUNCIONES

function BuscaDatos($sql, $conn)
{
    $result = mysqli_query($conn, $sql);

    // Verifica si hay resultados
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data = $row;
            return $data;
        }
    }
}
function info_vehiculo($unidad, $conn)
{
    $sql = "SELECT numero_unidad,tipo_unidad, marca, modelo,año,placas_tr, placas_plana FROM unidades WHERE numero_unidad = '" . $unidad . "'";
    $result = mysqli_query($conn, $sql);

    // Verifica si hay resultados
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data = array('tipo_unidad' => $row['tipo_unidad'],'marca' => $row['marca'], 'placas_tr' => $row['placas_tr'], 'modelo' => $row['año'], 'placas_plana' => $row['placas_plana']);
        }

        return $data;
    }
}
