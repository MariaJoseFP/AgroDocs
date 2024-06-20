<?php
include("conexion.php");
date_default_timezone_set('UTC');
$fecha = date("Y-m-d");

// Realizar la consulta a la base de datos
$query = "SELECT * FROM programacion WHERE Fecha_expedicion='".$fecha."'";
$resultado = $conn->query($query);

// Crear la tabla HTML con los resultados de la consulta
if ($resultado->num_rows > 0) {
    echo '<thead class="table-secondary">
        <tr>
            <th scope="col">Fecha de expedición</th>
            <th scope="col">Traslado</th>
            <th scope="col">Cliente</th>
            <th scope="col">Pollos</th>
            <th scope="col">Granja</th>
            <th scope="col">Lote</th>';
           echo '
            <th scope="col">Destino</th>
            <th scope="col">Unidad</th>
            <th scope="col">Remol</th>
            <th scope="col">Operador</th>
            <th scope="col">Rejas</th>
            <th scope="col">Permisionario</th>
            
             <th scope="col">Folio</th>
            <th scope="col">Estatus</th>';
        
            echo'                                   
        </tr>
    </thead>';
    echo '<tbody>';

    while ($row = $resultado->fetch_assoc()) {
        echo '<tr>';
            echo "<td>" . $row["Fecha_expedicion"] . "</td>";
            echo "<td>" . $row["Traslado"] . "</td>";
            echo "<td>" . $row["Cliente"] . "</td>";
            echo "<td>" . $row["Pollos"] . "</td>";
            echo "<td>" . $row["Granja"] . "</td>";
            echo "<td>" . $row["Lote"] . "</td>";
            echo "<td>" . $row["Destino"] . "</td>";
            echo "<td>" . $row["Unidad"] . "</td>";
            echo "<td>" . $row["Remol"] . "</td>";
            echo "<td>" . $row["Operador"] . "</td>";
            echo "<td>" . $row["Rejas"] . "</td>";
            echo "<td>" . $row["Permisionario"] . "</td>";
            echo "<td>" . $row["Folio"] . "</td>";
            echo "<td style='color: red'>" . $row["Estatus"] . "</td>";
            echo "<td><div class='btn-group btn-group-sm' role='group ' aria-label='Small button group'>";
                echo "<button type='button' class='btn btn-outline-primary btn-editar' id='".$row["Traslado"] ."' data-bs-toggle='modal' data-bs-target='#ModalEditar' onclick='abrirFormulario(this)'>Editar</button>";
              if($row["Estatus"] != 'CANCELADO' && $row["Estatus"] != 'CANCELADA' ){
                echo "<button type='button' class='btn btn-outline-danger btn-cancelar' id='".$row["Traslado"] ."' onclick='cancelarTraslado(this)'>Cancelar</button>";
              } 
            echo "</div></td>";
            echo "<td><a type='button' class='btn btn-link btn-generar' id='".$row["Traslado"] ."'   onclick='generarAviso(this)'>Generar documentos</a></td>";
            echo '</tr>';
    }
    echo '</tbody>';
} else {
    echo 'S/R';
}

// Cerrar la conexión a la base de datos
$conn->close();

