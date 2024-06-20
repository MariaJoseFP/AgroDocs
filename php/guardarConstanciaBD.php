<?php
function guardarRegistroConstancia($datos)
{
    include("conexion.php");

    try {
        // Validación de datos (puedes agregar más validaciones según sea necesario)

        //para prevenir SQL injection
        $folio = mysqli_real_escape_string($conn, $datos['folio']);
        $fechaExpedicion = $datos['fecha_exp'];
        $propietarioResponsable = mysqli_real_escape_string($conn, $datos['cliente']);
        $marca = mysqli_real_escape_string($conn, $datos['marca']);
        $placasCabina = mysqli_real_escape_string($conn, $datos['placas_tr']);
        $placasRemolque = mysqli_real_escape_string($conn, $datos['placas_plana']);
        $upp = isset($datos['granja']) ? mysqli_real_escape_string($conn, $datos['granja']) : "";

 
        // Construye la consulta SQL con los valores escapados
        $queryInsertar = "INSERT INTO `constancias_de_lavado`(`folio`, `fecha_Expedicion`, `propietario_responsable`, `marca`, `placas_cabina`, `placas_remolque`, `upp`) 
        VALUES ('$folio', '$fechaExpedicion', '$propietarioResponsable', '$marca', '$placasCabina', '$placasRemolque', '$upp')";

        // Ejecuta la consulta (asegúrate de tener una conexión a la base de datos)
        $resultado = mysqli_query($conn, $queryInsertar);

        if (!$resultado) {
           // throw new Exception("Error al insertar el registro: " . mysqli_error($conn));
           $result = mysqli_error($conn);
            return $result;
        }else{
            $result = "OK";
            return $result;
        }
    } catch (Exception $e) {
        //echo "Error: " . $e->getMessage();
        return $e->getMessage();
    } finally {
        // Cierra la conexión a la base de datos
        $conn->close();
    }
}
