<?php
/**
 * Created by PhpStorm.
 * User: IIEG-NFlores
 * Date: 08/03/2018
 * Time: 02:52 PM
 */
require_once '../api/model/Documento.php';
$documento = new Documento();
echo "<h4>Comprimiendo archivos...</h4>";
/**
 * Parámetros de búsqueda
 */
$action = null;
$search = null; // Palabra de búsqueda;
$documentType = null; // Tipo de documento
$tipoContrato = null; // Tipo de contrato
$anio = null;
$monto = null;
$orderBy = null;
$orderWay = null;
$limit = null;
$offset = null;
$fileName = '';
$export = null;

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

if (isset($_GET['tipoContrato']))
    $tipoContrato = $_GET['tipoContrato'];

if (isset($_GET['anio']))
    $anio = $_GET['anio'];

if (isset($_GET['monto']))
    $monto = $_GET['monto'];

if (isset($_GET['export']))
    $export = $_GET['export'];


switch ($export) {
    case 'contratos':
        // Obtener los contratos
        $contratos = $documento->getAll($search, $tipoContrato, $anio, $documentType, $monto, $orderBy, $orderWay, $limit, $offset);
        checkFiles($contratos, 'iieg-contratos.zip');
        break;
    case 'convenios':
        $convenios = $documento->getAll($search, $tipoConvenio, $anio, $documentType, $monto, $orderBy, $orderWay, $limit, $offset);
        checkFiles($convenios, 'iieg-convenios.zip');
        break;
}

/**
 * Comprueba que exite el archivo
 */
function checkFiles($docs, $fileN) {
    $path = __DIR__.'/../../../../data/1048576/';
    $files = [];
    $i = 0;
    foreach ($docs['data'] as $c) {
        $fileName = $path.$c->id.'/1.pdf';
        $files[$i] = ['filename' => $fileName, 'numContrato' => $c->numeroContrato, 'formato' => $c->formato];

        if (file_exists($fileName)) {
            $files[] = $fileName;
            $i++;
        }
    }

    zipFile($files, $fileN);
}

/**
 * Comprime una lista de archivos
 * @param array $files
 */
function zipFile($files = [], $filename) {
    set_time_limit(500);
    $zip = new ZipArchive();

    //var_dump($filename);
    if ($zip->open($filename, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) === true) {
        foreach ($files as $file) {
            if (isset($file['filename'])) {
                $zip->addFile($file['filename'], str_replace("/", "_", $file['numContrato']).$file['formato']);
                //echo "<strong>Agregado: </strong>" . $file['numContrato'].$file['formato'] ."<br />";
            }
        }
    }
    $zip->close();
    if (file_exists(__DIR__.'/'.$filename)) {
        streamDownload($filename);
    } else
        echo "<h4>No se pudo generar el archivo comprimido...</h4>";

}

function streamDownload($filename) {
    header('Content-disposition: attachment; filename='.$filename);
    header('Content-type: application/zip');
    //readfile($filename);
    $retbytes = TRUE;
    $buffer = '';
    $cnt    = 0;
    $handle = fopen($filename, 'rb');

    if ($handle === false) {
        return false;
    }

    while (!feof($handle)) {
        $buffer = fread($handle, CHUNK_SIZE);
        echo $buffer;
        ob_flush();
        flush();

        if ($retbytes) {
            $cnt += strlen($buffer);
        }
    }

    $status = fclose($handle);

    if ($retbytes && $status) {
        return $cnt; // return num. bytes delivered like readfile() does.
    }

    return $status;
}