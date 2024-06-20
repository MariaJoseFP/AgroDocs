<?php
    include("conexion.php");
    $Traslado = isset($_GET['traslado']) ? $_GET['traslado'] : null;
    $sql= "SELECT * FROM programacion WHERE Traslado=".$Traslado;
    $result = mysqli_query($conn, $sql);

    // Verifica si hay resultados
    if ($result->num_rows > 0) {
        $data = array();
        $row = mysqli_fetch_assoc($result);
        header('Content-Type: application/json');
        echo json_encode(array("status" => "success", "datos" => $row));
        
        
    }else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => "Error al insertar en la base de datos"+$conn->error));
    }
    $conn->close();
?>