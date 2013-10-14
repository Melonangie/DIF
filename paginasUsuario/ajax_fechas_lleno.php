<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//Archivo que incluye parametros de conexion
include '../basededatos/conexion.php';

//abre la conexion
$db = new BD();
$dates = null;
$query = "SELECT disponible.disponible_id AS fecha, 
                 disponible.disponible_activo AS activo,
                 (100 * disponible.disponible_contador / platica.platica_capacidad) AS lleno
            FROM disponible, platica 
            WHERE disponible.platica_id = platica.platica_id AND disponible.disponible_id > CURDATE()
            ORDER BY disponible.disponible_id";
$result = $db->query($query);
if ($result) {
    echo '[';
    while ($row = mysql_fetch_object($result)) {
        //convierte a numero el valor del contador
        $contador = (int) $row->lleno;

        if ($contador >= 98 || $row->activo == "cerrado") {
            $converteddate = date('Y-n-j', strtotime($row->fecha));
            $dates .= '"' . $converteddate . '",';
        }

    }
    $dates = rtrim($dates, ",");
    echo $dates;
    echo ']';
}
$db->closeConnexion();
?>
   