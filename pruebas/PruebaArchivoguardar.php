<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Incluye la biblioteca SheetJS (xlsx) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Leer y Guardar Datos</title>
</head>
<body>

<!-- Formulario para seleccionar un archivo Excel -->
<form id="formArchivo">
    <input type="file" id="inputArchivo" accept=".xlsx, .xls" />
    <button type="button" onclick="leerExcel()">Leer y Guardar en BD</button>
</form>

<!-- Resultados -->
<div id="resultados"></div>

<!-- Tu script JavaScript -->
<script>
    function leerExcel() {
        var inputFile = document.getElementById('inputArchivo');
        var resultadosContainer = document.getElementById('resultados');

        var archivo = inputFile.files[0];

        if (archivo) {
            var lector = new FileReader();

            lector.onload = function (e) {
                var data = new Uint8Array(e.target.result);
                var workbook = XLSX.read(data, { type: 'array',cellDates: true });

                // Supongamos que solo hay una hoja en el archivo Excel
                var primeraHoja = workbook.SheetNames[0];
                var dateNF = 'yyyy/m/d/;@';

                var datos = XLSX.utils.sheet_to_json(workbook.Sheets[primeraHoja], { Fecha_expedicion: dateNF });

              //  var datos = XLSX.utils.sheet_to_json(workbook.Sheets[primeraHoja]);

                // Crear una tabla HTML
                var tablaHTML = '<table border="1">';
                tablaHTML += '<thead>';
                tablaHTML += '<tr>';

                // Obtener los nombres de las columnas
                var columnas = Object.keys(datos[0]);

                // Agregar encabezados de columna a la tabla
                columnas.forEach(function (columna) {
                    tablaHTML += '<th>' + columna + '</th>';
                });

                tablaHTML += '</tr>';
                tablaHTML += '</thead>';
                tablaHTML += '<tbody>';

                // Agregar filas de datos a la tabla
                datos.forEach(function (fila) {
                    tablaHTML += '<tr>';

                    // Agregar celdas de datos a la fila
                    columnas.forEach(function (columna) {
                        tablaHTML += '<td>' + fila[columna] + '</td>';
                    });

                    tablaHTML += '</tr>';
                });

                tablaHTML += '</tbody>';
                tablaHTML += '</table>';

                // Mostrar la tabla en el contenedor
                resultadosContainer.innerHTML = tablaHTML;

                // Llamar a la función para guardar en la base de datos
                guardarEnBD(datos);
            };

            lector.readAsArrayBuffer(archivo);
        } else {
            alert('Por favor, selecciona un archivo Excel.');
        }
    }

    function guardarEnBD(datos) {
    // Ejemplo usando jQuery.ajax
    $.ajax({
        url: 'guardar_en_bd.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ datos: datos }),
        success: function(data) {
            
            if(data.status != "ÉXITO"){
                console.log(data);
                alert(data.status);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
        }
    });
}
</script>

</body>
</html>
