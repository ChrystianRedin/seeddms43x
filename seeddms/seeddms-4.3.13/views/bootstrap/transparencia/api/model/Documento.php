<?php
/**
 * Created by PhpStorm.
 * User: IIEG-NFlores
 * Date: 14/02/2018
 * Time: 11:36 AM
 */
require_once (__DIR__.'/../../config/connection.php');

class Documento
{
    private $connection = null;
    public $id = null;
    public $numeroContrato = null;
    public $tipoDocumento = null;
    public $tipoContrato = null;
    public $nombrePersona = null;
    public $monto = null;
    public $acciones = null;
    public $proyecto = null;
    public $vigencia = null;
    public $formato = null;

    public $fecha = null;
    public $tipoSesion = null;
    public $naturalezaSesion = null;
    public $documento = null;
    public $version = null;

    public $documentosConsulta = []; // Documentos públicos para consulta previa
    public $documentosAprobados = []; // Documentos aprobados
    public $actaSesion = []; // Acta de sesión

    /**
     * Obtiene todos los recursos
     */
    public function getAll($search, $tipoContrato, $fecha, $documentType, $monto, $orderBy, $orderWay, $limit, $offset) {
        $this->connection = new Connection();
        $params = [];

        $sql = "SELECT
                    x.id,
					x.name,
					x.`comment` AS comment,
					t.value AS t_value,
					k.value AS k_value,
					m.value AS m_value,
					n.value AS n_value,
					p.value AS p_value,
					q.value AS q_value,
                    g.value AS g_value,
					tblDocumentContent.orgFileName,
					tblDocumentContent.fileType,
                    substring_index(t.value, '/', -1) AS anio,
                    substring_index(t.value, substring_index(t.value, '/', -1), 1) AS folio
				FROM
				    tblDocuments AS x
					LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 1) AS t ON x.id = t.document
					LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 2) AS k ON x.id = k.document
					LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 3) AS m ON x.id = m.document
					LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 4) AS n ON x.id = n.document
					LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 5) AS p ON x.id = p.document
					LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 6) AS q ON x.id = q.document
                    LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 18) AS g ON x.id = g.document
                            
					INNER JOIN tblDocumentContent ON tblDocumentContent.document = x.id
				WHERE
                    x.`name`= :documentType 
                     ";

            if ($search != '') {
                $sql .= 'AND (m.value LIKE :search
                              OR t.value LIKE :search
                              OR k.value LIKE :search
                              OR n.value LIKE :search
                              OR p.value LIKE :search
                              OR g.value LIKE :search
                              OR q.value LIKE :search) ';

                $params[':search'] = "%$search%";
            }

            if ($tipoContrato != 'Todos' && $tipoContrato != null) {
                $sql .= "AND k.value = :tipoContrato ";
                $params[':tipoContrato'] = $tipoContrato;
            }

            if ($fecha != 'Todos' && $fecha != null) {
                $sql .= "AND t.value LIKE :fecha ";
                $params[':fecha'] = "%$fecha%";
            }

            if ($monto == 1) $sql .= "AND n.monto BETWEEN 0 AND 250000 ";
            elseif ($monto == 2) $sql .= "AND n.monto BETWEEN 250001 AND 500000 ";
            elseif ($monto == 3) $sql .= "AND n.monto BETWEEN 500001 AND 750000 ";
            elseif ($monto == 4) $sql .= "AND n.monto BETWEEN 750001 AND 1000000 ";
            elseif ($monto == 5) $sql .= "AND n.monto BETWEEN 1000001 AND 2000000 ";
            elseif ($monto == 6) $sql .= "AND n.monto BETWEEN 2000001 AND 3000000 ";
            elseif ($monto == 7) $sql .= "AND n.monto BETWEEN 3000001 AND 5000000 ";
            elseif ($monto == 8) $sql .= "AND n.monto > 5000000 ";

            if ($orderBy == 't_value' || $orderBy == 'k_value' ||
                $orderBy == 'm_value' || $orderBy == 'n_value' ||
                $orderBy == 'p_value' || $orderBy == 'q_value' ||
                $orderBy == 'g_value' || $orderBy == 'n.monto') {
                $sql .= "ORDER BY
					$orderBy $orderWay ";
            } else
                $sql .= "ORDER BY
                    anio DESC, folio ASC ";

            if ($limit > 0) {
                $sql .= 'LIMIT :limit OFFSET :offset';
                $params[':limit'] = intval($limit);
                $params[':offset'] = intval($offset);
            }

        $params[':documentType'] = $documentType;

        $result = $this->connection->execute($sql, $params);

        $docList = [];
        foreach ($result as $doc) {
            $document                 = new Documento();
            $document->id             = $doc['id'];
            $document->tipoDocumento  = $doc['name'];
            $document->numeroContrato = $doc['t_value'];
            $document->tipoContrato   = $doc['k_value'];
            $document->nombrePersona  = $doc['m_value'];
            $document->monto          = $doc['n_value'];
            $document->acciones       = utf8_encode(htmlentities($doc['p_value']));
            $document->accionesShort  = utf8_encode(htmlentities(substr($doc['p_value'], 0, 50))). '...'; // Versión corta de acciones
            $document->proyecto       = utf8_encode(htmlentities($doc['q_value']));
            $document->proyectoShort  = utf8_encode(htmlentities(substr($doc['q_value'], 0, 50))). '...'; // Versión corta de proyecto
            $document->vigencia       = $doc['g_value'];
            $document->formato        = $doc['fileType'];

            // Obtener la versión del documento
            $sql = "SELECT tblDocumentStatus.version FROM tblDocumentStatus WHERE tblDocumentStatus.documentID = :id";
            $result = $this->connection->execute($sql, [':id' => $document->id]);
            if (isset($result[0])) $document->version = $result[0]['version'];

            // Agregar el documento al arreglo
            $docList[] = $document;
        }

        $response = [
            'pagination' => [
                'offset' => $offset,
                'limit' => $limit,
                'total_rows' => $this->countRows($search, $tipoContrato, $fecha, $documentType, $monto, $orderBy, $orderWay)
            ],
            'data' => $docList,
            'docs' => $this->checkDocs($documentType, $docList)
        ];

        //var_dump($docList);

        // Retorna la lista de documentos
        return $response;
    }

    /**
     * Cuenta los archivos y suma el peso total de cada uno
     */
    private function checkDocs($documentType, $docList) {
        $zipSize = 0;
        $totalDocs = 0;

        try {
            foreach ($docList as $doc) {
                if ($documentType == 'Contratos') {
                    $file = __DIR__.'/../../../../../data/1048576/'.$doc->id.'/1.pdf';
                    if (file_exists($file)) {
                        $totalDocs++;
                        $zipSize += filesize($file);
                    }
                }
            }
        } catch (Exception $ex) {}


        return [
            'totalDocs' => $totalDocs,
            'zipSize' => $zipSize
        ];
    }

    /**
     * Cuenta el total de registros
     * @param $search
     * @param $documentType
     * @param $orderBy
     * @param $orderWay
     * @return mixed
     */
    private function countRows($search, $tipoContrato, $fecha, $documentType, $monto, $orderBy, $orderWay) {
        $sql = "SELECT
                    COUNT(*) AS 'total'
				FROM
				    tblDocuments AS x
					LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 1) AS t ON x.id = t.document
					LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 2) AS k ON x.id = k.document
					LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 3) AS m ON x.id = m.document
					LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 4) AS n ON x.id = n.document
					LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 5) AS p ON x.id = p.document
					LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 6) AS q ON x.id = q.document
                    LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 18) AS g ON x.id = g.document
                            
					INNER JOIN tblDocumentContent ON tblDocumentContent.document = x.id
				WHERE
				    x.`name`= :documentType ";

        if ($search != '') {
            $sql .= 'AND (m.value LIKE :search
                              OR t.value LIKE :search
                              OR k.value LIKE :search
                              OR n.value LIKE :search
                              OR p.value LIKE :search
                              OR g.value LIKE :search
                              OR q.value LIKE :search) ';

            $params[':search'] = "%$search%";
        }

        if ($tipoContrato != 'Todos' && $tipoContrato != null) {
            $sql .= "AND k.value = :tipoContrato ";
            $params[':tipoContrato'] = $tipoContrato;
        }

        if ($tipoContrato != 'Todos' && $tipoContrato != null) {
            $sql .= "AND k.value = :tipoContrato ";
            $params[':tipoContrato'] = $tipoContrato;
        }

        if ($fecha != 'Todos' && $fecha != null) {
            //var_dump($fecha);
            $sql .= "AND t.value LIKE :fecha ";
            $params[':fecha'] = "%$fecha%";
        }

        if ($monto == 1) $sql .= "AND n.monto BETWEEN 0 AND 250000 ";
        elseif ($monto == 2) $sql .= "AND n.monto BETWEEN 250001 AND 500000 ";
        elseif ($monto == 3) $sql .= "AND n.monto BETWEEN 500001 AND 750000 ";
        elseif ($monto == 4) $sql .= "AND n.monto BETWEEN 750001 AND 1000000 ";
        elseif ($monto == 5) $sql .= "AND n.monto BETWEEN 1000001 AND 2000000 ";
        elseif ($monto == 6) $sql .= "AND n.monto BETWEEN 2000001 AND 3000000 ";
        elseif ($monto == 7) $sql .= "AND n.monto BETWEEN 3000001 AND 5000000 ";
        elseif ($monto == 8) $sql .= "AND n.monto > 5000000 ";

        /*$sql .= "ORDER BY
					$orderBy :$orderWay";*/

        $params[':documentType'] = $documentType;
        /*$params[':orderBy'] = $orderBy;
        $params[':orderWay'] = $orderWay;*/

        $result = $this->connection->execute($sql, $params);

        //var_dump($result);
        $total = 0;
        if (isset($result[0]))
            $total = $result[0]['total'];
        return $total;
    }

    /**
     * Obtiene los tipos de un doc específico
     * @param $documentType
     * @return array
     */
    public function getTiposDoc($documentType) {
        $this->connection = new Connection();

        $sql = "SELECT DISTINCT
                    k.value
                FROM
                    tblDocuments AS x
                    LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 2) AS k ON x.id = k.document
                WHERE
                    x.name = :name
                ORDER BY k.value ASC";

        $params = [':name' => $documentType];

        $result = $this->connection->execute($sql, $params);

        $contratosList = [];

        foreach ($result as $tipo) {
            $contratosList[] = $tipo['value'];
        }

        $response = [
            'data' => $contratosList
        ];

        //var_dump($docList);

        // Retorna la lista de documentos
        return $response;
    }

    /**
     * Obtiene todos los recursos de tipo Junta de Gobierno
     */
    public function getDocsJuntaGobierno($search, $tipoSesion, $fecha, $orderBy, $orderWay, $limit, $offset) {
        $this->connection = new Connection();
        $params = [];

        //
        $sql = "
                                SELECT
								tblDocumentAttributes.value,
								tblDocumentAttributes.attrdef,
								tblDocumentAttributes.document,
								tblDocumentAttributes.id,
								t.value AS t_value,
								m.value AS m_value,
								k.value AS k_value,
								tblDocumentContent.orgFileName,
								tblDocumentContent.fileType
								FROM
								tblDocuments
									LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 7) AS t ON tblDocuments.id = t.document
									LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 9) AS m ON tblDocuments.id = m.document
									LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 10) AS k ON tblDocuments.id = k.document								
								INNER JOIN tblDocumentAttributes ON tblDocuments.id = tblDocumentAttributes.document
								INNER JOIN tblDocumentContent ON tblDocumentContent.document = tblDocuments.id
								LEFT JOIN tblDocumentFiles ON tblDocumentFiles.document = tblDocuments.id
								WHERE
								tblDocuments.name = 'Junta de Gobierno'
								AND tblDocumentAttributes.attrdef = 7 
							  
								";


        // Si se busca una palabra en específico
        if ($search != '') {
            $sql .= 'AND (m.value LIKE :search
                          OR t.value LIKE :search
                          OR k.value LIKE :search
                          OR tblDocumentAttributes.value LIKE :search
                          OR tblDocumentAttributes.attrdef LIKE :search
                          OR tblDocumentAttributes.document LIKE :search
                          OR tblDocumentAttributes.id LIKE :search
                          OR tblDocumentContent.orgFileName LIKE :search
                          OR tblDocumentContent.fileType LIKE :search
                         ) ';

            $params[':search'] = "%$search%";
        }

        if ($fecha != 'todos' && $fecha != null) {
            $sql .= "AND t.value LIKE :fecha ";
            $params[':fecha'] = "%$fecha%";
        }

        if ($tipoSesion != 'todas' && $tipoSesion != null) {
            $sql .= "AND m.value = :tipoSesion ";
            $params[':tipoSesion'] = $tipoSesion;
        }

        //$sql .= "GROUP BY tblDocumentAttributes.document DESC";

        $sql .= "GROUP BY tblDocumentAttributes.document DESC"; 

        //TEST
        /*
        if ($orderBy == 't_value' || $orderBy == 'k_value' ||
            $orderBy == 'm_value' || $orderBy == 'n_value' ||
            $orderBy == 'p_value' || $orderBy == 'q_value' || $orderBy == 'g_value') {
            $sql .= "ORDER BY
					$orderBy $orderWay ";
        } else
            $sql .= "ORDER BY
                    id ASC ";
                    */
        //TEST

        if ($limit > 0) {
            $sql .= 'LIMIT :limit OFFSET :offset';
            $params[':limit'] = intval($limit);
            $params[':offset'] = intval($offset);
        }

        $result = $this->connection->execute($sql, $params);


        $docList = [];
        foreach ($result as $doc) {
            $document                   = new Documento();
            $document->id               = $doc['id'];
            $document->fecha            = utf8_encode(htmlentities($doc['t_value']));
            $document->tipoSesion       = utf8_encode(htmlentities($doc['m_value']));
            $document->naturalezaSesion = utf8_encode(htmlentities($doc['k_value']));
            $document->documento        = $doc['document'];

            // Documentos para consulta previa
            $sql = "SELECT
									tblDocumentAttributes.`value`,
									tblDocumentAttributes.attrdef,
									tblDocumentAttributes.document,
									tblDocumentAttributes.id,
									t.value,
									m.value,
									k.value,
									tblDocumentContent.orgFileName,
									tblDocumentFiles.fileType,
									tblDocumentFiles.orgFileName,
									tblDocumentFiles.id,
									tblDocumentFiles.`name`
									FROM
									tblDocuments
									LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 7) AS t ON tblDocuments.id = t.document
									LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 9) AS m ON tblDocuments.id = m.document
									LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 10) AS k ON tblDocuments.id = k.document								
									INNER JOIN tblDocumentAttributes ON tblDocuments.id = tblDocumentAttributes.document
									INNER JOIN tblDocumentContent ON tblDocumentContent.document = tblDocuments.id
									LEFT JOIN tblDocumentFiles ON tblDocumentFiles.document = tblDocuments.id
									WHERE
									tblDocuments.name = 'Junta de Gobierno'
									AND tblDocumentAttributes.attrdef=7
									and tblDocumentFiles.`name` like '%consulta%'
									AND tblDocumentAttributes.document = :doc";
                                    //agregue and tblDocumentFiles.`name` like '%consulta%' JAGG

            $result = $this->connection->execute($sql, [':doc' => $document->documento]);
			
            foreach ($result as $key => $value) {
                $document->documentosConsulta[$key] = $value;
            }

            // Documentos aprobados
            $sql = "
									SELECT
									tblDocumentAttributes.`value`,
									tblDocumentAttributes.attrdef,
									tblDocumentAttributes.document,
									tblDocumentAttributes.id,
									t.value,
									m.value,
									k.value,
									tblDocumentContent.orgFileName,
									tblDocumentFiles.fileType,
									tblDocumentFiles.orgFileName,
									tblDocumentFiles.id,
									tblDocumentFiles.`name`
									FROM
									tblDocuments
									LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 7) AS t ON tblDocuments.id = t.document
									LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 9) AS m ON tblDocuments.id = m.document
									LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 10) AS k ON tblDocuments.id = k.document								
									INNER JOIN tblDocumentAttributes ON tblDocuments.id = tblDocumentAttributes.document
									INNER JOIN tblDocumentContent ON tblDocumentContent.document = tblDocuments.id
									LEFT JOIN tblDocumentFiles ON tblDocumentFiles.document = tblDocuments.id
									WHERE
									tblDocuments.name = 'Junta de Gobierno'
									AND tblDocumentAttributes.attrdef=7
									and tblDocumentFiles.`name` like '%aprobados%' 
									AND tblDocumentAttributes.document = :doc";
                                    //agregue and tblDocumentFiles.`name` like '%aprobados%' JAGG

            $result = $this->connection->execute($sql, [':doc' => $document->documento]);

            foreach ($result as $key => $value) {
                $document->documentosAprobados[$key] = $value;
            }

            // Acta de sesión
            $sql = "
									SELECT
									tblDocumentAttributes.`value`,
									tblDocumentAttributes.attrdef,
									tblDocumentAttributes.document,
									tblDocumentAttributes.id,
									t.value,
									m.value,
									k.value,
									tblDocumentContent.orgFileName,
									tblDocumentFiles.fileType,
									tblDocumentFiles.orgFileName,
									tblDocumentFiles.id,
									tblDocumentFiles.`name`
									FROM
									tblDocuments
									LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 7) AS t ON tblDocuments.id = t.document
									LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 9) AS m ON tblDocuments.id = m.document
									LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 10) AS k ON tblDocuments.id = k.document								
									INNER JOIN tblDocumentAttributes ON tblDocuments.id = tblDocumentAttributes.document
									INNER JOIN tblDocumentContent ON tblDocumentContent.document = tblDocuments.id
									LEFT JOIN tblDocumentFiles ON tblDocumentFiles.document = tblDocuments.id
									WHERE
									tblDocuments.name = 'Junta de Gobierno'
									and tblDocumentAttributes.attrdef=7	
									and tblDocumentFiles.`name` like '%acta%'";

            $result = $this->connection->execute($sql, [':doc' => $document->documento]);

            foreach ($result as $key => $value) {
                $document->actaSesion[$key] = $value;
            }

            // Agregar el documento al arreglo
            $docList[] = $document;
        }

        $response = [
            'pagination' => [
                'offset' => $offset,
                'limit' => $limit,
                'total_rows' => $this->countRowsJuntaGob($search, $tipoSesion, $fecha)
            ],
            'data' => $docList
        ];

        // Retorna la lista de documentos
        return $response;
    }

    /**
     * Cuenta el total de registros de Junta de Gobierno
     * @param $search
     * @param $documentType
     * @param $orderBy
     * @param $orderWay
     * @return mixed
     */
    private function countRowsJuntaGob($search, $tipoSesion, $fecha) {
        $this->connection = new Connection();
        $params = [];
        $sql = "
                                SELECT
								  COUNT(tblDocuments.id) AS total
								FROM
								tblDocuments
									LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 7) AS t ON tblDocuments.id = t.document
									LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 9) AS m ON tblDocuments.id = m.document
									LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 10) AS k ON tblDocuments.id = k.document								
								INNER JOIN tblDocumentAttributes ON tblDocuments.id = tblDocumentAttributes.document
								INNER JOIN tblDocumentContent ON tblDocumentContent.document = tblDocuments.id
								LEFT JOIN tblDocumentFiles ON tblDocumentFiles.document = tblDocuments.id
								WHERE
								tblDocuments.name = 'Junta de Gobierno'
								AND tblDocumentAttributes.attrdef = 7 ";

        if ($search != '') {
            $sql .= 'AND (m.value LIKE :search
                          OR t.value LIKE :search
                          OR k.value LIKE :search
                          OR tblDocumentAttributes.value LIKE :search
                          OR tblDocumentAttributes.attrdef LIKE :search
                          OR tblDocumentAttributes.document LIKE :search
                          OR tblDocumentAttributes.id LIKE :search
                          OR tblDocumentContent.orgFileName LIKE :search
                          OR tblDocumentContent.fileType LIKE :search)';

            $params[':search'] = "%$search%";
        }

        if ($fecha != 'todos' && $fecha != null) {
            $sql .= "AND t.value LIKE :fecha ";
            $params[':fecha'] = "%$fecha%";
        }

        if ($tipoSesion != 'todas' && $tipoSesion != null) {
            $sql .= "AND m.value = :tipoSesion ";
            $params[':tipoSesion'] = $tipoSesion;
        }

        $sql .= "GROUP BY tblDocumentAttributes.document ";

        $result = $this->connection->execute($sql, $params);

        $total = 0;
        if (isset($result[0]))
            $total = sizeof($result);
        return $total;
    }

    public function getTiposSesion() {
        $this->connection = new Connection();
        $sql = "          SELECT 
								DISTINCT m.value
								FROM
								tblDocuments
									LEFT JOIN ( SELECT * FROM tblDocumentAttributes WHERE attrdef = 9) AS m ON tblDocuments.id = m.document								
								INNER JOIN tblDocumentAttributes ON tblDocuments.id = tblDocumentAttributes.document
								INNER JOIN tblDocumentContent ON tblDocumentContent.document = tblDocuments.id
								LEFT JOIN tblDocumentFiles ON tblDocumentFiles.document = tblDocuments.id
								WHERE
								tblDocuments.name = 'Junta de Gobierno'
								and tblDocumentAttributes.attrdef=7
								GROUP BY tblDocumentAttributes.document
        ";

        $result = $this->connection->execute($sql);
        $sesionesList = [];

        foreach ($result as $tipo) {
            $sesionesList[] = $tipo['value'];
        }

        $response = [
            'data' => $sesionesList
        ];

        //var_dump($docList);

        // Retorna la lista de documentos
        return $response;
    }

}