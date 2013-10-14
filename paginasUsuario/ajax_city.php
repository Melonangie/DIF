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
$estadoid = $_POST['id'];
$query = "SELECT `ciudad_nombre` FROM `ciudad` WHERE `estado_nombre` ='" . $estadoid . "' GROUP BY `ciudad_nombre`";
$result = $db->query($query);
if ($result) {
    while ($row = $db->fetchAssoc($result)) {
        $data = $row['ciudad_nombre'];
        echo '<option value="' . $data . '">' . $data . '</option>';
    }
    $db->freeResult($result);
}
$db->closeConnexion();




//Archivo que incluye parametros de conexion
//include '../funciones/funciones.php';
//
//$db = conexion::instancia();
////$estado= $db->real_escape_string($_POST['id']);
//$query = "SELECT `ciudad_nombre` FROM `ciudad` WHERE `estado_nombre` ='".$_POST['id']."' GROUP BY `ciudad_nombre`";
//$result = $db->query($query);
//if ($result) {
//    while ($row = $result->fetch_array(MYSQLI_ASSOC)){
//        $data=$row['ciudad_nombre'];
//        echo '<option value="'.$data.'">'.$data.'</option>';
//    }
//}

?>