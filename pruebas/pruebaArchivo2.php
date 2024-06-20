<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Incluye la biblioteca SheetJS (xlsx) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <title>Leer Datos de Excel</title>
</head>
<body>

<!-- Formulario para seleccionar un archivo Excel -->
<form id="formArchivo">
    <input type="file" id="inputArchivo" accept=".xlsx, .xls" />
    <button type="button" onclick="leerExcel()">Leer Excel</button>
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
                var workbook = XLSX.read(data, { type: 'array', cellDates: true });

                // Supongamos que solo hay una hoja en el archivo Excel
                var primeraHoja = workbook.SheetNames[0];

                // Configuración para interpretar 45334 como fecha
                var dateNF = 'yyyy-mm-dd;@';

                // Obtener el HTML directamente con formato de fecha personalizado
                var html = XLSX.utils.sheet_to_html(workbook.Sheets[primeraHoja], { dateNF: dateNF, header: 1, display: true });

                // Mostrar el HTML en el contenedor
                resultadosContainer.innerHTML = html;
            };

            lector.readAsArrayBuffer(archivo);
        } else {
            alert('Por favor, selecciona un archivo Excel.');
        }
    }
</script>

</body>
</html>
