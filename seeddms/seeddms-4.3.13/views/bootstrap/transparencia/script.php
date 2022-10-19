<?php
/**
 * Created by PhpStorm.
 * User: IIEG-NFlores
 * Date: 05/03/2018
 * Time: 02:33 PM
 * La función de este script es convertir los montos de string a decimal, y guardarlos en la columna 'monto'
 * Si la columna no existe, ejecutar la sentencia que se muestra aquí abajo.
 */
/**
 * SENTENCIA
 * ALTER TABLE `tblDocumentAttributes` ADD `monto` DECIMAL(15,2) NULL DEFAULT '0' COMMENT 'Monto en formato numérico' AFTER `value`;
 */
require_once 'config/connection.php';
$conexion = new Connection();

// Obtén todos los registros con signo de pesos
$sql = "SELECT * FROM `tblDocumentAttributes` WHERE value LIKE '%$%' AND monto = 0.00";
$result = $conexion->execute($sql);

var_dump(sizeof($result));


foreach ($result as $r) {
    var_dump($r['value']);
    // Extrae todos los números del string
    preg_match_all('!\d+!', $r['value'], $matches);
    print_r($matches[0]);

    if (isset($matches[0][0]) && isset($matches[0][1]) && isset($matches[0][2])) {
        // Construye la cantidad
        $cantString = $matches[0][0] . $matches[0][1] .'.' . $matches[0][2];

        var_dump($cantString);

        // Actualiza el registro
        $sql = "UPDATE tblDocumentAttributes SET monto = :monto WHERE id = :id";
        $conexion->execute($sql, [':monto' => $cantString, ':id' => $r['id']]);
    } elseif (isset($matches[0][0]) && isset($matches[0][1])) {
        // Construye la cantidad
        $cantString = $matches[0][0] . $matches[0][1];

        var_dump($cantString);

        // Actualiza el registro
        $sql = "UPDATE tblDocumentAttributes SET monto = :monto WHERE id = :id";
        $conexion->execute($sql, [':monto' => $cantString, ':id' => $r['id']]);
    }

}
