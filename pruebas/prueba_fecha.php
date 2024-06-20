<?php

$fechaOriginal = '22/02/2024';

$dt = new DateTime($fechaOriginal);

// Obtener el nombre del mes en español
$nombreMes = [
    'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO',
    'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'
];

// Formatear la fecha manualmente
$fecha_exp = $dt->format('d/') . $nombreMes[$dt->format('n') - 1] . $dt->format('/Y');

echo $fecha_exp.'<br>';

// Crea un objeto DateTime a partir de la fecha original
$fechaObjeto = DateTime::createFromFormat('d/m/Y', $fechaOriginal);

// Formatea la fecha en un nuevo formato
echo $fechaFormateada = $fechaObjeto->format('Y-m-d')

?>