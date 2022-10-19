<?php
/**
 * Created by PhpStorm.
 * User: IIEG-NFlores
 * Date: 14/02/2018
 * Time: 12:05 PM
 */
require_once (__DIR__.'/../model/Documento.php');

class DocumentosController
{
    private $documento = null;

    public function __construct() {
        $this->documento = new Documento();
    }

    /**
     * Obtiene una lista de documentos
     * @param $search
     * @param $documentType
     * @param $orderBy
     * @param $orderWay
     */
    public function getAll($search, $tipoContrato, $fecha, $documentType, $monto, $orderBy, $orderWay, $limit, $offset) {
        echo json_encode($this->documento->getAll($search, $tipoContrato, $fecha, $documentType, $monto, $orderBy, $orderWay, $limit, $offset), JSON_UNESCAPED_UNICODE);
    }

    public function getTiposDoc($documentType) {
        echo json_encode($this->documento->getTiposDoc($documentType), JSON_UNESCAPED_UNICODE);
    }

    public function getDocsJuntaGobierno($search, $tipoSesion, $fecha, $orderBy, $orderWay, $limit, $offset) {
        echo json_encode($this->documento->getDocsJuntaGobierno($search, $tipoSesion, $fecha, $orderBy, $orderWay, $limit, $offset), JSON_UNESCAPED_UNICODE);
    }

    public function getTiposSesion() {
        echo json_encode($this->documento->getTiposSesion(), JSON_UNESCAPED_UNICODE);
    }

}