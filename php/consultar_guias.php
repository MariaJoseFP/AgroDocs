<?php
include("conexion.php");

if (isset($_GET['fechaIni'])) {
    $fechaIni = $_GET['fechaIni'];
    $fechaFin = $_GET['fechaFin'];

    $query = "SELECT * FROM guias_pollo WHERE fecha BETWEEN '" . $fechaIni . "' AND '" . $fechaFin . "'";
} else {
    date_default_timezone_set('UTC');
    $fecha = date("y/m/d");
    // Realizar la consulta a la base de datos
    $query = "SELECT * FROM guias_pollo WHERE fecha='" . $fecha . "'";
}

$resultado = $conn->query($query);

// Crear la tabla HTML con los resultados de la consulta
if ($resultado->num_rows > 0) {


    // Imprimir los datos de la tabla
    echo '<thead class="table-light">
        <tr>
            <th scope="col" rowspan="2" class="text-wrap">No. DE EXPEDIENTE</th>
            <th scope="col" rowspan="2" class="text-wrap text-center" style="min-width: 7em;">FECHA</th>
            <th colspan="2" style="color: #717171;">REMITENTE O VENDEDOR</th>
            <th style="color: #717171;">DESTINATARIO</th>
            
            <th scope="col" rowspan="2" style="min-width: 9em;">FOLIO DE GUIA DE TRANSITO</th>
            
            <th colspan="3" class="text-center" style="color: #717171;">ORIGEN</th>
            <th colspan="3" class="text-center" style="color: #717171;">DESTINO</th>
            <th scope="col" rowspan="2">ESPECIE</th>
            <th scope="col" rowspan="2">MERCANCIA</th>
            <th scope="col" rowspan="2">CANTIDAD</th>
            <th scope="col" rowspan="2"  style="min-width: 9em;">UNIDAD DE MEDIDA</th>
            <th scope="col" rowspan="2">MOTIVO DEL TRANSPORTE</th>
            <th scope="col" rowspan="2">NOMBRE DEL TRANSPORTISTA</th>
            <th colspan="5" class="text-center" style="color: #717171;">DATOS DEL VEHICULO</th>
            <th scope="col" rowspan="2" class="text-center">NOMBRE DEL RESPONSABLE</th>
            <th scope="col" rowspan="2" class="text-center">ESTATUS</th>
            <th rowspan="2"></th>
            </tr>
        <tr>
            
            
            <th scope="col">NOMBRE</th>
            <th scope="col">UPP/PSG</th>
            <th scope="col">NOMBRE</th>
            
            <th scope="col">LOCALIDAD</th>
            <th scope="col">MUNICIPIO</th>
            <th scope="col">ESTADO</th>
            <th scope="col">LOCALIDAD</th>
            <th scope="col">MUNICIPIO</th>
            <th scope="col">ESTADO</th>
            <th scope="col" >MARCA</th>
            <th scope="col">MODELO</th>
            <th scope="col">COLOR</th>
            <th scope="col">PLACAS</th>
            <th scope="col">REMOLQUE</th>
            
            ';
    echo '                                   
        </tr>

    </thead>';
    echo '<tbody class="table-group-divider">';
    while ($row = $resultado->fetch_assoc()) {
        echo '<tr>';
        // Imprimir cada valor en una celda
        foreach ($row as $valor) {
            echo "<td>$valor</td>";
        }
        if ($row["status"] != 'CANCELADA') {
            echo "<td class='text-center align-middle'><button type='button' class='btn btn-outline-danger btn-cancelar-guia text-center ' id='" . $row["No_expediente"] . "' onclick='solicitarCancelarDoc(this, \"" . 'guia' . "\");'>Cancelar</button></td>";
        }

        echo '</tr>';
    }

    echo '</tbody>';
} else {
    echo 'S/R';
}

// Cerrar la conexión a la base de datos
$conn->close();

