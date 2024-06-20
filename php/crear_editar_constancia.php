<?php
error_reporting(E_ALL); // Cambiado para mostrar todos los errores y advertencias
require '../vendor/autoload.php';
require 'guardarConstanciaBD.php';
include 'formatear_fecha_salida.php';

use PhpOffice\PhpWord\TemplateProcessor;

// Ruta del documento original
$rutaDocumentoOriginal = '../documentos\constancia_editable.docx';



// Verificar si se recibieron datos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    // Obtener los datos del formulario
    $datosFormulario = $_POST;

    // Datos dinámicos
    $folioConstancia = $datosFormulario['folio'];
    $traslado = $datosFormulario['traslado'];

    $fecha_exp = $datosFormulario['fecha_exp'];
    $fecha_exp = format_fecha1($fecha_exp);

    $fecha_vigencia = $datosFormulario['Fecha_vigencia'];
    $fecha_vigencia = format_fecha1($fecha_vigencia);

    $marca = $datosFormulario['marca'];
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
    $templateProcessor = new TemplateProcessor($rutaDocumentoOriginal);

    // Añadir mensaje de depuración
    error_log("TemplateProcessor creado exitosamente.");

    // Reemplazar marcadores de posición con nuevos datos
    $templateProcessor->setValue('FECHA_EX', $fecha_exp);
    $templateProcessor->setValue('FECHA_VI', $fecha_vigencia);
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

    // Añadir mensaje de depuración
    error_log("Valores reemplazados exitosamente.");

    $nombreArchivo = 'constanciaLavado_' . $folioConstancia . '.docx';
    $rutaDocumentoSalida = '../documentos/' . $nombreArchivo;

    // Guardar el documento editado
    $templateProcessor->saveAs($rutaDocumentoSalida);

    // Añadir mensaje de depuración
    error_log("Documento guardado exitosamente en: $rutaDocumentoSalida");

    // Guardar el registro en la base de datos
    $respuestaInsertar = guardarRegistroConstancia($datosFormulario);

    // Añadir mensaje de depuración
  //  error_log("Registro guardado en la base de datos con respuesta: " . json_encode($respuestaInsertar));

    $respuesta = array('status' => 'OK', 'archivo' => $nombreArchivo, 'insert' => $respuestaInsertar);
} else {
    // Si no se recibieron datos, devolver una respuesta de error
    $respuesta = array('status' => 'Error: No se recibieron datos del formulario');
}

// Añadir mensaje de depuración
error_log("Respuesta final: " . json_encode($respuesta));

header('Content-Type: application/json');
echo json_encode($respuesta);
?>
