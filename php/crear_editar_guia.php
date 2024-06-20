<?php
error_reporting(0);
require '../vendor/autoload.php';
require 'guardarGuiaBD.php';
include 'formatear_fecha_salida.php';
use PhpOffice\PhpWord\TemplateProcessor;

// Ruta del documento original y del documento de salida
$originalDocumentPath = '../documentos/guia_editable.docx';

// Verificar si se recibieron datos
if (isset($_POST)) {
    // Obtener los datos del formulario
    $datosFormulario = $_POST;

    // Datos dinámicos
    $folio_guia = $datosFormulario['folio_guia'];

    $fechaOriginal = $datosFormulario['fecha_exp'];
    $fecha_exp = format_fecha1($fechaOriginal);

    $upp_psg_o = $datosFormulario['upp_o'];
    $nombre_o = $datosFormulario['nombre_o'];
    $estado_o = $datosFormulario['estado_o'];
    $municipio_o = $datosFormulario['municipio_o'];
    
    $upp_psg_d = $datosFormulario['upp_d'];
    $nombre_d = $datosFormulario['nombre_d'];
    $estado_d = $datosFormulario['estado_d'];
    $municipio_d = $datosFormulario['municipio_d'];

    $vehiculo = $datosFormulario['vehiculo'];
    $modelo = $datosFormulario['modelo'];
    $marca = $datosFormulario['marca2'];
    $año = $datosFormulario['año'];
    $color = $datosFormulario['color'];
    $placas = $datosFormulario['placas'];
    $conductor = $datosFormulario['conductor'];
    $ruta = $datosFormulario['ruta'];

    $especie = $datosFormulario['especie'];
    $cantidad = $datosFormulario['cantidad'];
    $mercancia = $datosFormulario['mercancia'];
    $unidad_medida = $datosFormulario['unidad_medida'];
    $motivo = $datosFormulario['motivo'];


    $n_constancia = $datosFormulario['n_constancia'];
    $UPA = $datosFormulario['UPA'];
    $lote = $datosFormulario['lote'];

    $antec = $datosFormulario['antec'];
    $cantidad2 = $datosFormulario['cantidad2'];
    $factura = $datosFormulario['factura'];
    $cert_zoo = $datosFormulario['cert_zoo'];
    $const_enf = $datosFormulario['const_enf'];

    $mvz = $datosFormulario['mvz'];

    // Crear un objeto TemplateProcessor
    $templateProcessor = new TemplateProcessor($originalDocumentPath);

    // Reemplazar marcadores de posición con nuevos datos
    $templateProcessor->setValue('FECHA_EX', $fecha_exp);
    $templateProcessor->setValue('UPP_PSG_O', $upp_psg_o);
    $templateProcessor->setValue('NOMBRE_O', $nombre_o);
    $templateProcessor->setValue('ESTADO_O', $estado_o);
    $templateProcessor->setValue('MUNICIPIO_O', $municipio_o);
    
    $templateProcessor->setValue('UPP_PSG_D', $upp_psg_d);
    $templateProcessor->setValue('NOMBRE_D', $nombre_d);
    $templateProcessor->setValue('ESTADO_D', $estado_d);
    $templateProcessor->setValue('MUNICIPIO_D', $municipio_d);
    $templateProcessor->setValue('UPA', $UPA);

    $templateProcessor->setValue('MARCA', $marca);
    $templateProcessor->setValue('AÑO', $año);
    $templateProcessor->setValue('COLOR', $color);
    $templateProcessor->setValue('PLACAS', $placas);
    $templateProcessor->setValue('CONDUCTOR', $conductor);
    $templateProcessor->setValue('RUTA', $ruta);
    $templateProcessor->setValue('ESPECIE', $especie);
    $templateProcessor->setValue('CANTIDAD', $cantidad);

    $templateProcessor->setValue('N_CONSTANCIA', $n_constancia);
    
    $templateProcessor->setValue('LOTE', $lote);

    $templateProcessor->setValue('ANTECEDENTES', $antec);
    $templateProcessor->setValue('CANTIDAD2', $cantidad2);
    $templateProcessor->setValue('FACTURA', $factura);
    $templateProcessor->setValue('CERT_ZOO', $cert_zoo);
    $templateProcessor->setValue('CONST_ENF', $const_enf);
    $templateProcessor->setValue('MVZ', $mvz);


    $nombreArchivo = 'guiaDeTraslado_' .$folio_guia.'.docx';
    $outputDocumentPath = '../documentos/'.$nombreArchivo;
    // Guardar el documento editado
    $templateProcessor->saveAs($outputDocumentPath);
    $respuesta_insertar = guardarRegistroGuia($datosFormulario);
    $respuesta = array('status' => 'OK', 'archivo' => $nombreArchivo, 'insert' => $respuesta_insertar);
} else {
    // Si no se recibieron datos, devolver una respuesta de error
    $respuesta = array('status' => 'Error: No se recibieron datos del formulario');
}

header('Content-Type: application/json');
echo json_encode($respuesta);
