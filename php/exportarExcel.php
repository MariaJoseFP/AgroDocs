<?php
require '../vendor/autoload.php'; // Carga la biblioteca PhpSpreadsheet
include 'formatear_fecha_salida.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_GET['doc'])) {
    $dsn = 'mysql:host=localhost;dbname=movilizacion';
    $usuario = 'root';
    $contraseña = '';

    $conn = new PDO($dsn, $usuario, $contraseña);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $doc = $_GET['doc'];
    $fecha_ini = $_GET['fechaIni'];
    $fecha_fin = $_GET['fechaFin'];

    if ($doc == 'constancias') {
        try {

            $query = "SELECT `folio`, `fecha_expedicion`, `propietario_responsable`, `marca`, `placas_cabina`, `placas_remolque`, `upp` FROM `constancias_de_lavado` WHERE `fecha_expedicion` BETWEEN '" . $fecha_ini . "' AND '" . $fecha_fin . "'";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            // Obtener los resultados de la consulta
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Crear una instancia de la hoja de cálculo
            $spreadsheet = new Spreadsheet();

            // Obtener la hoja activa
            $sheet = $spreadsheet->getActiveSheet();

            // Combinar celdas para el encabezado
            $sheet->mergeCells('A1:G1');
            $sheet->setCellValue('A1', 'CONTROL DE FOLIOS EMITIDOS DE CONSTANCIAS DE LAVADO Y DESINFECCIÓN.');
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            // Establecer el tamaño de las columnas
            $sheet->getColumnDimension('A')->setWidth(15);  // Columna A con ancho 15
            $sheet->getColumnDimension('B')->setWidth(20);  // Columna B con ancho 20
            $sheet->getColumnDimension('C')->setWidth(25);  // Columna C con ancho 25
            $sheet->getColumnDimension('D')->setWidth(15);  // Columna D con ancho 15
            $sheet->getColumnDimension('E')->setWidth(15);  // Columna E con ancho 15
            $sheet->getColumnDimension('F')->setWidth(18);  // Columna F con ancho 15
            $sheet->getColumnDimension('G')->setWidth(30);  // Columna G con ancho 25
            // Establecer el estilo del encabezado
            $styleHeader = [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DDDDDD']],
            ];
            $sheet->getStyle('A1:G2')->applyFromArray($styleHeader);

            // Escribir datos en la hoja de cálculo


            $sheet->setCellValue('A2', 'Folio');
            $sheet->setCellValue('B2', 'Fecha de expedición');
            $sheet->setCellValue('C2', 'Propietario o responsable');
            $sheet->setCellValue('D2', 'Marca');
            $sheet->setCellValue('E2', 'Placas cabina');
            $sheet->setCellValue('F2', 'Placas remolque');
            $sheet->setCellValue('G2', 'UPP o Establecimiento de salida');
            // Escribir los datos en la hoja de cálculo
            $row = 3;
            foreach ($datos as $fila) {
                $sheet->fromArray($fila, null, 'A' . $row);
                $row++;
            }
            // Crear un objeto Writer y guardar el archivo Excel
            $writer = new Xlsx($spreadsheet);
            $writer->save('../documentos/CONST_LAVADO_POLLO.xlsx');

            $response['status'] = 'OK';
            $response['archivo'] = 'CONST_LAVADO_POLLO.xlsx';
        } catch (PDOException $e) {
            $response['status'] = 'ERROR' . $e->getMessage();
            //echo 'Error de conexión: ' . $e->getMessage();
        } finally {
            // Cerrar la conexión a la base de datos
            $conn = null;
        }
    } else if ($doc == 'guias') {

        try {

            $query = "SELECT `No_expediente`, `fecha`, `nombre_remitente`, `upp_psg`, `nombre_destinatario`, `folio_guia`, `localidad_origen`, `municipio_origen`, `estado_origen`, `localidad_destino`, `municipio_destino`, `estado_destino`, `especie`, `mercancia`, `cantidad`, `unidad_medida`, `motivo_transporte`, `nombre_transportista`, `marca`, `modelo`, `color`, `placas`, `remolque`, `responsable_doc`FROM `guias_pollo` WHERE `fecha` BETWEEN '" . $fecha_ini . "' AND '" . $fecha_fin . "'";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            // Obtener los resultados de la consulta
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Crear una instancia de la hoja de cálculo
            $spreadsheet = new Spreadsheet();

            // Obtener la hoja activa
            $sheet = $spreadsheet->getActiveSheet();

            // Combinar celdas para el encabezado
            $sheet->mergeCells('A1:AD1');
            if($fecha_fin != $fecha_ini){
                
                $sheet->setCellValue('A1', 'LIBRO DE REGISTRO DIARIO  ELECTRONICO, CORRESPONDIENTE  DEL '.format_fecha1($fecha_ini).'   AL   '. format_fecha1($fecha_fin));
            }else{
                $sheet->setCellValue('A1', 'LIBRO DE REGISTRO DIARIO  ELECTRONICO, CORRESPONDIENTE  DEL '.format_fecha1($fecha_ini));
            }
           
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            
            // Establecer el estilo del encabezado
            $styleHeader = [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DDDDDD']],
            ];
            $sheet->getStyle('A1:X3')->applyFromArray($styleHeader);

            $style = $sheet->getStyle('A1:X3');
            $style->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Escribir datos en la hoja de cálculo


            $sheet->setCellValue('A2', 'No. DE EXPEDIENTE');
            $sheet->mergeCells('A2:A3');
            $sheet->setCellValue('B2', 'FECHA');
            $sheet->mergeCells('B2:B3');
            $sheet->setCellValue('C2', 'REMITENTE O VENDEDOR');
            $sheet->mergeCells('C2:D2');
            $sheet->setCellValue('C3', 'NOMBRE');
            $sheet->setCellValue('D3', 'UPP/PSG');
            $sheet->setCellValue('E2', 'DESTINATARIO O COMPRADOR');
            $sheet->setCellValue('E3', 'NOMBRE');
            $sheet->setCellValue('F2', 'FOLIO DE GUIA DE TRANSITO');
            $sheet->mergeCells('F2:F3');
            $sheet->setCellValue('G2', 'ORIGEN');
            $sheet->mergeCells('G2:I2');
            $sheet->setCellValue('G3', 'LOCALIDAD');
            $sheet->setCellValue('H3', 'MUNICIPIO');
            $sheet->setCellValue('I3', 'ESTADO');
            $sheet->setCellValue('J2', 'DESTINO');
            $sheet->mergeCells('J2:L2');
            $sheet->setCellValue('J3', 'LOCALIDAD');
            $sheet->setCellValue('K3', 'MUNICIPIO');
            $sheet->setCellValue('L3', 'ESTADO');
            $sheet->setCellValue('M2', 'ESPECIE');
            $sheet->setCellValue('N2', 'MERCANCIA');
            $sheet->setCellValue('O2', 'CANTIDAD');
            $sheet->mergeCells('M2:M3');
            $sheet->mergeCells('N2:N3');
            $sheet->mergeCells('O2:O3');
            $sheet->setCellValue('P2', 'UNIDAD DE MEDIDA');
            $sheet->setCellValue('Q2', 'MOTIVO DEL TRANSPORTE');
            $sheet->setCellValue('R2', 'NOMBRE DEL TRANSPORTISTA');
            $sheet->mergeCells('P2:P3');
            $sheet->mergeCells('Q2:Q3');
            $sheet->mergeCells('R2:R3');
            $sheet->setCellValue('S2', 'DATOS DEL VEHICULO');
            $sheet->mergeCells('S2:W2');
            $sheet->setCellValue('S3', 'MARCA');
            $sheet->setCellValue('T3', 'MODELO');
            $sheet->setCellValue('U3', 'COLOR');
            $sheet->setCellValue('V3', 'PLACAS');
            $sheet->setCellValue('W3', 'REMOLQUE');
            $sheet->setCellValue('X3', 'NOMBRE DEL RESPONSABLE DE LA DOCUMENTACION');
          //  $sheet->getStyle('A3:Y3')->getAlignment()->setWrapText(true);
            $sheet->getColumnDimension('A')->setWidth(15);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(40);
            $sheet->getColumnDimension('E')->setWidth(50);
            $sheet->getColumnDimension('F')->setWidth(25);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(15);
            $sheet->getColumnDimension('K')->setWidth(15);
            $sheet->getColumnDimension('L')->setWidth(15);
            $sheet->getColumnDimension('M')->setWidth(20);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(20);
            $sheet->getColumnDimension('P')->setWidth(20);
            $sheet->getColumnDimension('Q')->setWidth(24);
            $sheet->getColumnDimension('R')->setWidth(27);
            $sheet->getColumnDimension('S')->setWidth(15);
            $sheet->getColumnDimension('T')->setWidth(15);
            $sheet->getColumnDimension('U')->setWidth(15);
            $sheet->getColumnDimension('V')->setWidth(15);
            $sheet->getColumnDimension('Y')->setWidth(15);
            $sheet->getColumnDimension('X')->setWidth(14);
            $sheet->getColumnDimension('X')->setWidth(20);
            $sheet->getColumnDimension('W')->setWidth(15);
            $style = $sheet->getStyle('X3');
            $alignment = $style->getAlignment();
            $alignment->setWrapText(true);

            // Escribir los datos en la hoja de cálculo
            $row = 4;
            foreach ($datos as $fila) {
                $sheet->fromArray($fila, null, 'A' . $row);
                $row++;
            }


            // Crear un objeto Writer y guardar el archivo Excel
            $writer = new Xlsx($spreadsheet);
            $writer->save('../documentos/GUIAS_TRASLADO.xlsx');

            $response['status'] = 'OK';
            $response['archivo'] = 'GUIAS_TRASLADO.xlsx';
        } catch (PDOException $e) {
            $response['status'] = 'ERROR' . $e->getMessage();
            //echo 'Error de conexión: ' . $e->getMessage();
        } finally {
            // Cerrar la conexión a la base de datos
            $conn = null;
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
