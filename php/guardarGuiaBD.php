<?php

function guardarRegistroGuia($datos)
{
    include("conexion.php");

    try {
        // Validación de datos (puedes agregar más validaciones según sea necesario)

        //para prevenir SQL injection
        $noExpediente = isset($datos['no_expediente']) ? mysqli_real_escape_string($conn, $datos['no_expediente']) : '';
        $fecha = $datos['fecha_exp'];
        $nombreRemitente = mysqli_real_escape_string($conn, $datos['nombre_o']);
        $uppPsg = mysqli_real_escape_string($conn, $datos['upp_o']);
        $nombre_destinatario = isset($datos['nombre_d']) ? mysqli_real_escape_string($conn, $datos['nombre_d']) : '';
        $folio_guia = isset($datos['folio_guia']) ? mysqli_real_escape_string($conn, $datos['folio_guia']) : '';

        $localidad_origen = isset($datos['localidad_o']) ? mysqli_real_escape_string($conn, $datos['localidad_o']) : '';
        $municipio_origen = isset($datos['municipio_o']) ? mysqli_real_escape_string($conn, $datos['municipio_o']) : '';
        $estado_origen = isset($datos['estado_o']) ? mysqli_real_escape_string($conn, $datos['estado_o']) : '';
        $localidad_destino = isset($datos['localidad_d']) ? mysqli_real_escape_string($conn, $datos['localidad_d']) : '';
        $municipio_destino = isset($datos['municipio_d']) ? mysqli_real_escape_string($conn, $datos['municipio_d']) : '';
        $estado_destino = isset($datos['estado_d']) ? mysqli_real_escape_string($conn, $datos['estado_d']) : '';
        $especie = isset($datos['especie']) ? mysqli_real_escape_string($conn, $datos['especie']) : '';
        $mercancia = isset($datos['mercancia']) ? mysqli_real_escape_string($conn, $datos['mercancia']) : '';
        $cantidad = isset($datos['cantidad']) ? mysqli_real_escape_string($conn, $datos['cantidad']) : '';
        $unidad_medida = isset($datos['unidad_medida']) ? mysqli_real_escape_string($conn, $datos['unidad_medida']) : '';
        $motivo_transporte = isset($datos['motivo']) ? mysqli_real_escape_string($conn, $datos['motivo']) : '';
        $nombre_transportista = isset($datos['conductor']) ? mysqli_real_escape_string($conn, $datos['conductor']) : '';
        $marca = isset($datos['marca']) ? mysqli_real_escape_string($conn, $datos['marca']) : '';
        $modelo = isset($datos['modelo']) ? mysqli_real_escape_string($conn, $datos['modelo']) : '';
        $color = isset($datos['color']) ? mysqli_real_escape_string($conn, $datos['color']) : '';
        $placas_tr = isset($datos['placas_1']) ? mysqli_real_escape_string($conn, $datos['placas_1']) : '';
        $placas_re = isset($datos['placas_2']) ? mysqli_real_escape_string($conn, $datos['placas_2']) : 'S/R';
      //  $remolque = isset($datos['remolque']) ? mysqli_real_escape_string($conn, $datos['remolque']) : '';
        $responsable_doc = isset($datos['responsable_doc']) ? mysqli_real_escape_string($conn, $datos['responsable_doc']) : '';

        // Construye la consulta SQL con los valores escapados
        $sql_insertar = "INSERT INTO `guias_pollo`(`No_expediente`, `fecha`, `nombre_remitente`, `upp_psg`, `nombre_destinatario`, `folio_guia`, 
        `localidad_origen`, `municipio_origen`, `estado_origen`, `localidad_destino`, `municipio_destino`, `estado_destino`, `especie`, `mercancia`,
         `cantidad`, `unidad_medida`, `motivo_transporte`, `nombre_transportista`, `marca`, `modelo`, `color`, `placas`, `remolque`, `responsable_doc`) 
        VALUES ('$noExpediente','$fecha','$nombreRemitente','$uppPsg','$nombre_destinatario','$folio_guia','$localidad_origen','$municipio_origen',
        '$estado_origen','$localidad_destino','$municipio_destino','$estado_destino','$especie','$mercancia','$cantidad','$unidad_medida','$motivo_transporte',
        '$nombre_transportista','$marca','$modelo','$color','$placas_tr','$placas_re','$responsable_doc')";
        // Ejecuta la consulta (asegúrate de tener una conexión a la base de datos)
        $resultado = mysqli_query($conn, $sql_insertar);

        if (!$resultado) {
            // throw new Exception("Error al insertar el registro: " . mysqli_error($conn));
            $result = "Error al insertar el registro: " . mysqli_error($conn);
             return $result;
         }else{
             $result = "OK";
             return $result;
         }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Cierra la conexión a la base de datos
        $conn->close();
    }
}
