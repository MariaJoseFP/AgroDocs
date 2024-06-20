<?php


// Verificar si se recibieron datos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['datos'])) {
    // Obtener los datos del formulario
    $datosFormulario = json_decode($_POST['datos'], true);

    // Hacer algo con los datos (por ejemplo, imprimirlos)
    print_r($datosFormulario);

    // Aquí puedes realizar las operaciones necesarias con los datos y devolver una respuesta
    $respuesta = array('status' => 'Éxito');
    echo json_encode($respuesta);
} else {
    // Si no se recibieron datos, devolver una respuesta de error
    $respuesta = array('status' => 'Error: No se recibieron datos del formulario');
    echo json_encode($respuesta);
}

/*
require '../vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

// Ruta del documento original y del documento de salida
$originalDocumentPath = '../contancia_editable.docx';
$outputDocumentPath = '../contanciaLavado_documento_editado.docx';

// Datos dinámicos
$nuevoNombre = "EL FRAILE";
$nuevaEdad = 30;

// Crear un objeto TemplateProcessor
$templateProcessor = new TemplateProcessor($originalDocumentPath);

// Reemplazar marcadores de posición con nuevos datos
$templateProcessor->setValue('GRANJA', $nuevoNombre);
$templateProcessor->setValue('EDAD', $nuevaEdad);

// Guardar el documento editado
$templateProcessor->saveAs($outputDocumentPath);

echo 'Documento editado con éxito.';*/
?>
