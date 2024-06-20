<?php

require '../vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

// Ruta del documento original y del documento de salida
$originalDocumentPath = '../documentos/contancia_editable.docx';
$outputDocumentPath = '../documentos/contanciaLavado_documento_editado.docx';


// Verificar si se recibieron datos
if (isset($_POST)) {
    // Obtener los datos del formulario
    $datosFormulario = $_POST;

    // Datos dinámicos
    $fecha_exp = $datosFormulario['fecha_exp'];
    $Fecha_vigencia = $datosFormulario['Fecha_vigencia'];
    $marca =  $datosFormulario['marca'];
    $placas_tr = $datosFormulario['placas_tr'];
    $modelo = $datosFormulario['modelo'];
    $placas_plana = $datosFormulario['placas_plana'];
    $granja = $datosFormulario['granja'];
    $cliente = $datosFormulario['cliente'];
    $localidad = $datosFormulario['localidad'];
    $municipio = $datosFormulario['municipio'];
    $estado = $datosFormulario['estado'];
    $tipo_carga = $datosFormulario['tipo_carga'];
    $desinf = $datosFormulario['desinf'];
    $activo = $datosFormulario['activo'];
    $concent = $datosFormulario['concent'];
    $tiempo = $datosFormulario['tiempo'];
    $mvz = $datosFormulario['mvz'];
    $clave_aut = $datosFormulario['clave_aut'];
    // Crear un objeto TemplateProcessor
    $templateProcessor = new TemplateProcessor($originalDocumentPath);

    // Reemplazar marcadores de posición con nuevos datos
    $templateProcessor->setValue('FECHA_EX', $fecha_exp);
    $templateProcessor->setValue('FECHA_VI', $Fecha_vigencia);
    $templateProcessor->setValue('MARCA', $marca);
    $templateProcessor->setValue('PLACA', $placas_tr);
    $templateProcessor->setValue('AÑO', $modelo);
    $templateProcessor->setValue('PLACA_P', $placas_plana);
    $templateProcessor->setValue('GRANJA', $granja);
    $templateProcessor->setValue('CLIENTE', $cliente);
    $templateProcessor->setValue('LOCALIDAD', $localidad);
    $templateProcessor->setValue('MUNICIPIO', $municipio);
    $templateProcessor->setValue('ESTADO', $estado);
    $templateProcessor->setValue('TIPO_CARGA', $tipo_carga);
    $templateProcessor->setValue('DESINF', $desinf);
    $templateProcessor->setValue('ACTIVO', $activo);
    $templateProcessor->setValue('CONCENT', $concent);
    $templateProcessor->setValue('TIEMPO', $tiempo);
    $templateProcessor->setValue('MVZ', $mvz);
    $templateProcessor->setValue('CLAVE_AUT', $clave_aut);
    

    // Guardar el documento editado
    $templateProcessor->saveAs($outputDocumentPath);


    // Aquí puedes realizar las operaciones necesarias con los datos y devolver una respuesta
    $respuesta = array('status' => 'OK');
} else {
    // Si no se recibieron datos, devolver una respuesta de error
    $respuesta = array('status' => 'Error: No se recibieron datos del formulario');
}
header('Content-Type: application/json');
echo json_encode($respuesta);
