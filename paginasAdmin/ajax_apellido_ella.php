<?php

/**
 * Despliega las ciudades del estado seleccionado
 * en el select se la pagina ingresar.php
 */
//Archivo que incluye parametros de conexion
include '../basededatos/conexion.php';
//Archivo que incluye funciones utiles
include '../basededatos/funciones.php';
//abre la conexion
$db = new BD();

// Trae la busqueda disparada de apellidos paternos
$autocomplete_value = getGet('term', $db);
$hint = array();

//Realiza la busqueda en la base de datos de apellidos basados en los datos introducidos
$query = "SELECT `ella_id`,`ella_paterno`,`ella_materno`,`ella_nombre` FROM `ella` WHERE `ella_paterno` LIKE '%$autocomplete_value%' LIMIT 20 ";
$result = $db->query($query);
if ($result) {
    while ($row = $db->fetchAssoc($result)) {
        $row["value"]= $row["ella_paterno"];
        $hint[]= $row;
    }
    $db->freeResult($result);
}
$db->closeConnexion();

echo json_encode($hint);
?>