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
$id = getPost('id', $db);
$value = getPost('value', $db);

//verifica q solo se agregen valores validos
if ($value == 'si' || $value == 'no') {
    //Actualiza el valor del campo termino de la tabla folio
    $query = "UPDATE folio SET termino = '$value' WHERE folio_id = $id ";
    $result = $db->query($query);
        
}
    $db->closeConnexion();
    
?>