<?php
include("conexion.php");

if (isset($_GET['fechaIni'])) {
    $fechaIni = $_GET['fechaIni'];
    $fechaFin = $_GET['fechaFin'];

    $query = "SELECT * FROM constancias_de_lavado WHERE fecha_expedicion BETWEEN '". $fechaIni."' AND '".$fechaFin."'";
} else {
    date_default_timezone_set('UTC');
    $fecha = date("y/m/d");
    // Realizar la consulta a la base de datos
    $query = "SELECT * FROM constancias_de_lavado WHERE fecha_expedicion='" . $fecha . "'";
    
}

$resultado = $conn->query($query);

    // Crear la tabla HTML con los resultados de la consulta
    if ($resultado->num_rows > 0) {
        echo '<thead class="table-light">
        <tr>
            <th scope="col">FOLIO</th>
            <th scope="col">FECHA DE EXPEDICIÓN</th>
            <th scope="col">PROPIETARIO O RESPONSABLE</th>
            <th scope="col">MARCA</th>
            <th scope="col">PLACAS CABINA</th>
            <th scope="col">PLACAS REMOLQUE</th>';
        echo '
            <th scope="col">UPP O ESTABLECIMIENTO DE SALIDA</th>
            <th></th>';
        echo '                                   
        </tr>
    </thead>';
        echo '<tbody>';

        while ($row = $resultado->fetch_assoc()) {
            echo '<tr>';
            echo "<td>" . $row["folio"] . "</td>";
            echo "<td>" . $row["fecha_expedicion"] . "</td>";
            echo "<td>" . $row["propietario_responsable"] . "</td>";
            echo "<td>" . $row["marca"] . "</td>";
            echo "<td>" . $row["placas_cabina"] . "</td>";
            echo "<td>" . $row["placas_remolque"] . "</td>";
            echo "<td>" . $row["upp"] . "</td>";
            if ($row["status"] != 'CANCELADA') {
                echo "<td class='text-center align-middle'><button type='button' class='btn btn-outline-danger btn-cancelar-const text-center ' id='" . $row["folio"] . "' onclick='solicitarCancelarDoc(this, \"" . 'constancia' . "\");'>Cancelar</button></td>";
            }

            echo '</tr>';
        }
        echo '</tbody>';
    } else {
        echo 'S/R';
    }

    // Cerrar la conexión a la base de datos
    $conn->close();