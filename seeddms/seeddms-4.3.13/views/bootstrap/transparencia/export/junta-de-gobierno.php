<?php
require '../vendor/autoload.php';
require_once '../api/model/Documento.php';
//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$documento = new Documento();
$phpExcel = new PHPExcel();

/**
 * Parámetros de búsqueda
 */
$action = null;
$search = null; // Palabra de búsqueda;
$documentType = null; // Tipo de documento
$tipoSesion = null; // Tipo de convenio
$fecha = null;
$orderBy = null;
$orderWay = null;
$limit = null;
$offset = null;
$fileName = 'iieg-junta-gobierno.xls';

/**
 * Guardar parámetros de búsqueda
 */
if (isset($_GET['search']))
    $search = $_GET['search'];

if (isset($_GET['action']))
    $action = $_GET['action'];

if (isset($_GET['documentType']))
    $documentType = $_GET['documentType'];

if (isset($_GET['orderBy']))
    $orderBy = $_GET['orderBy'];

if (isset($_GET['orderWay']))
    $orderWay = $_GET['orderWay'];

if (isset($_GET['limit']))
    $limit = $_GET['limit'];

if (isset($_GET['offset']))
    $offset = $_GET['offset'];

if (isset($_GET['tipoSesion']))
    $tipoSesion = $_GET['tipoSesion'];

if (isset($_GET['fecha']))
    $fecha = $_GET['fecha'];

// Obtener los convenios
$juntaGobierno = $documento->getDocsJuntaGobierno($search, $tipoSesion, $fecha, $orderBy, $orderWay, $limit, $offset);

/**
 * PHPEXCEL (DEPRECATED)
 * FUNCIONA EN VERSIONES PHP >= 5.4
 */
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Create a first sheet, representing sales data
$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();

$sheet->setCellValue('A1', 'Orden del día');
$sheet->setCellValue('B1', 'Fecha y hora de sesión');
$sheet->setCellValue('C1', 'Tipo de sesión');
$sheet->setCellValue('D1', 'Naturaleza de la sesión');
/*$sheet->setCellValue('E1', 'Documentos públicos para consulta pública');
$sheet->setCellValue('F1', 'Acta de sesión');
$sheet->setCellValue('G1', 'Documentos aprobados');*/

// Llenar el Excel
$count = 2;
foreach ($juntaGobierno['data'] as $c) {
    $sheet->setCellValue('A'.$count, "http://".$_SERVER."/seeddms/seeddms-4.3.13/data/1048576/".$c->id."/1.pdf");
    $sheet->setCellValue('B'.$count, $c->fecha);
    $sheet->setCellValue('C'.$count, html_entity_decode($c->tipoSesion));
    $sheet->setCellValue('D'.$count, $c->naturalezaSesion);

    // DOCUMENTOS PARA CONSULTA
    /*foreach ($c->documentosConsulta as $dc) {
        if ($dc['orgFileName'] !== null) {
            $url = '';
            if ($dc['name'] === 'Documentos aprobados') $url = "http://".$_SERVER."/seeddms/seeddms-4.3.13/data/1048576/$c->documento/f".$dc['id'].".".$dc['fileType'];
            else $url = "http://".$_SERVER."/seeddms/seeddms-4.3.13/data/1048576/$c->documento/f".$dc['id'].".".$dc['fileType'];

            $sheet->setCellValue('E'.$count, '=Hyperlink("https://www.someurl.com/","Mi web")');
            $sheet->getCell('E'.$count)->setHyperlink(new PHPExcel_Cell_Hyperlink($url, 'LINK'));
        }
    }*/

    /*$sheet->setCellValue('E'.$count, html_entity_decode($c->acciones));
    $sheet->setCellValue('F'.$count, html_entity_decode($c->proyecto));
    $sheet->setCellValue('G'.$count, $c->vigencia);*/
    $count++;
}

$sheet->getStyle('A1:G1')->getFont()->setBold(true)
    ->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

$sheet->getStyle('A1:G1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('721c24');

$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(true);

$writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

// We'll be outputting an excel file
header('Content-type: text/csv; charset=utf-8');

// It will be called file.xls
header('Content-Disposition: attachment; filename="'.$fileName.'"');
$writer->save('php://output', 'w');

/**
 * SPREADSHEET
 * FUNCIONA SÓLO EN VERSIONES PHP >= 5.6
 */
/*try {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'No. de Convenio');
    $sheet->setCellValue('B1', 'Tipo de Convenio');
    $sheet->setCellValue('C1', 'Nombre de la Persona física o jurídica');
    $sheet->setCellValue('D1', 'Monto');
    $sheet->setCellValue('E1', 'Acciones a realizar');
    $sheet->setCellValue('F1', 'Proyecto o partida');
    $sheet->setCellValue('G1', 'Vigencia');




// Llenar el Excel
    $count = 2;
    foreach ($convenios['data'] as $c) {
        $sheet->setCellValue('A'.$count, $c->numeroConvenio);
        $sheet->setCellValue('B'.$count, $c->tipoConvenio);
        $sheet->setCellValue('C'.$count, $c->nombrePersona);
        $sheet->setCellValue('D'.$count, $c->monto);
        $sheet->setCellValue('E'.$count, $c->acciones);
        $sheet->setCellValue('F'.$count, $c->proyecto);
        $sheet->setCellValue('G'.$count, $c->vigencia);
        $count++;
    }

    $sheet->getStyle('A1:G1')->getFont()->setBold(true)
        ->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

    $sheet->getStyle('A1:G1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('721c24');

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);
    $sheet->getColumnDimension('G')->setAutoSize(true);



    $writer = new Xlsx($spreadsheet);
//$writer->save($fileName);

// We'll be outputting an excel file
    header('Content-type: application/vnd.ms-excel');

// It will be called file.xls
    header('Content-Disposition: attachment; filename="'.$fileName.'"');

// Write file to the browser
    $writer->save('php://output');
} catch (Exception $ex) {
    echo $ex->getMessage();
}*/



