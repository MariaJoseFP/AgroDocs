<?php

// Verificar si se proporcionó el parámetro de archivo
if (isset($_GET['archivo'])) {
    // Obtener el nombre del archivo desde la URL
    $nombreArchivo = $_GET['archivo'];

    // Ruta al directorio donde se busca el archivo
    $directorio = '../documentos/';

    // Ruta completa al archivo
    $rutaArchivo = $directorio . $nombreArchivo;
    echo $rutaArchivo;

    // Verificar si el archivo existe
    if (file_exists($rutaArchivo)) {
        // Intentar eliminar el archivo
        if (unlink($rutaArchivo)) {
            echo 'OK';
        } else {
            echo 'Error al intentar eliminar el archivo.';
        }
    } else {
        echo 'El archivo no existe.';
    }
} else {
    echo 'Parámetro de archivo no proporcionado.';
}

?>
