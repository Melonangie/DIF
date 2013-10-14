<?php

/**
 * Despliega los estados del pais seleccionado
 * en el select se la pagina ingresar.php
 */
//Archivo que incluye parametros de conexion
include '../basededatos/conexion.php';
//Archivo que incluye funciones utiles
include '../basededatos/funciones.php';
//abre la conexion
$db = new BD();
$paisid = $_POST['id'];
$query = "SELECT  `estado_nombre` FROM `ciudad` WHERE `pais_id`='" . $paisid . "' group by `estado_nombre`";
$result = $db->query($query);
if ($result) {
    while ($row = $db->fetchAssoc($result)) {
        $data = $row['estado_nombre'];
        echo '<option value="' . $data . '">' . $data . '</option>';
    }
    $db->freeResult($result);
}
$db->closeConnexion();
?>