<?php
include("conexion.php");
if (isset($_GET['traslado'])) {
    $traslado = $_GET['traslado'];

    //REALIZAR LA CONSULTA  A LA BD 
    // Consulta SQL parametrizada
    $sql = "SELECT Fecha_expedicion, Fecha_vigencia, Traslado, Cliente,Pollos, Granja, Unidad FROM programacion where Traslado =  " . $traslado;


    // Realizar la consulta
    $resultado = $conn->query($sql);
    // Verificar si la consulta fue exitosa
    if ($resultado) {
        // Crear un array para almacenar los resultados
        $data = array();
        // Recorrer los resultados y agregarlos al array
        while ($fila = $resultado->fetch_assoc()) {
            $data = $fila;
            $granja = $fila['Granja'];
            $cliente =trim($fila['Cliente']);
        }
        

        //CONSULTAR DATOS DE LAS GRANJAS
        $queryGranja = "SELECT granja, estado, municipio from granjas where granja LIKE CONCAT('%','$granja', '%')";
        $datos_granja = BuscaDatos($queryGranja,$conn);

        //CONSULTAR DATOS DEL CLIENTES
        $queryCliente= "SELECT * from Clientes where cliente LIKE CONCAT('%', '$cliente', '%'); ";
        $datos_cliente = BuscaDatos($queryCliente,$conn);

        // Cerrar el resultado
        $resultado->close();
        // Cerrar la conexión a la base de datos
        $conn->close();

        // Crear la respuesta JSON
        $response = array("status" => "success", "data" => $data, "datos_granja" => $datos_granja,"datos_cliente" => $datos_cliente);
    } else {
        // En caso de error en la consulta
        $response = array("status" => "error", "message" => "Error en la consulta: " . $conn->error);
    }
}
// Enviar la respuesta al cliente (en formato JSON)
header('Content-Type: application/json');
echo json_encode($response);


function BuscaDatos($sql,$conn){
    $result = mysqli_query($conn, $sql);

    // Verifica si hay resultados
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data= $row;
            return $data;
        }
        
    }
}