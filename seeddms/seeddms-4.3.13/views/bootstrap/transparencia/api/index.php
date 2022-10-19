<?php
/**
 * Created by PhpStorm.
 * User: IIEG-NFlores
 * Date: 14/02/2018
 * Time: 11:35 AM
 */
require_once ('controller/DocumentosController.php');
// Token para realizar las peticiones
$token = 'F6GTUtqkF9NUMqE9q2PrCwm3QWTuuZqeGEW8mz9g';

/**
 * Parámetros de búsqueda
 */
$action = null;
$search = null; // Palabra de búsqueda;
$documentType = null; // Tipo de documento
$tipoContrato = null; // Tipo de documento
$orderBy = null;
$orderWay = null;
$limit = null;
$offset = null;
$fecha = null;
$tipoSesion = null;
$monto = null;
$t = null; // Token proveniente del frontend

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

if (isset($_GET['fecha']))
    $fecha = $_GET['fecha'];

if (isset($_GET['anio']))
    $fecha = $_GET['anio'];

if (isset($_GET['tipoSesion']))
    $tipoSesion = $_GET['tipoSesion'];

if (isset($_GET['monto']))
    $monto = $_GET['monto'];

if (isset($_GET['t']))
    $t = $_GET['t'];


$docsCtrl = new DocumentosController();

/**
 * Procesar petición
 */
switch ($action) {
    case 'getDocs':
        checkToken($token, $t);
        $docsCtrl->getAll($search, $tipoContrato, $fecha, $documentType, $monto, $orderBy, $orderWay, $limit, $offset);
        break;
    case 'getTiposDoc':
        checkToken($token, $t);
        $docsCtrl->getTiposDoc($documentType);
        break;
    case 'getDocsJuntaGobierno':
        checkToken($token, $t);
        $docsCtrl->getDocsJuntaGobierno($search, $tipoSesion, $fecha, $orderBy, $orderWay, $limit, $offset);
        break;
    case 'getTiposSesion':
        checkToken($token, $t);
        $docsCtrl->getTiposSesion();
        break;
    default:
        echo "DEFAULT";
        break;
}

/**
 * Verifica si se incluyó un token en la petición
 * @param $token
 * @param $t
 */
function checkToken($token, $t) {
    if ($token !== $t) {
        http_response_code(401);
        $errorMsg = new stdClass();
        $errorMsg->status = '401';
        $errorMsg->title = 'Unauthorized';
        $errorMsg->detail = 'Su petición no fue autorizada por el servidor';
        echo json_encode($errorMsg);
        exit;
    }
}