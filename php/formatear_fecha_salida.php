<?php

function format_fecha1($fechaOriginal){
    // Verificar si la fecha original no es nula
    if($fechaOriginal !== null) {
        $dt = new DateTime($fechaOriginal);
        
        // Obtener el nombre del mes en español
        $nombreMes = [
            'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO',
            'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'
        ];
        
        // Formatear la fecha manualmente
        $fecha_exp = $dt->format('d/') . $nombreMes[$dt->format('n') - 1] . $dt->format('/Y');
        
        return $fecha_exp;
    } else {
        return ''; // Devolver una cadena vacía si la fecha original es nula
    }
}

?>