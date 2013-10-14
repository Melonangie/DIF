<?php

/**
 * PAgina que valida el ingreso de un usuario
 */
//Documento para conexion a la base de datos
include ('conexion.php');
//Documento para conexion a la base de datos
include ('funciones.php');

/**
 * Verifica si existe algun valor en alguna tabla 
 * @param type $table nombre de la tabla
 * @param type $campo numbre del campo a probar
 * @param type $curp valor del campo a verificar
 * @param type $link conexion a la base de datos abierta
 * @return type
 */
function existe($table, $campo, $valor, $link) {
    $query = sprintf("SELECT COUNT(*) 
                      FROM $table 
                      WHERE $campo='%s'", $valor);
    $result = $link->query($query);
    $array = $link->fetchArray($result);
    $link->freeResult($result);
    return $array[0];
}

/**
 * Verifica si existe un registro con el usuario y la contraseña
 * @param type $usuario Nombre de Usuario
 * @param type $hash    Hash de la clave 
 * @return type         Regresa 1 si el usuario existe, 0 si no existe  
 */
function existeUsuario($usuario, $hash, $link) {
    $query = sprintf("SELECT COUNT(*) 
        FROM usuarios 
        WHERE usuario_nombre='%s' AND usuario_clave='%s'", $usuario, $hash);
    $result = $link->query($query);
    $array = $link->fetchArray($result);
    $link->freeResult($result);
    return $array[0];
}

/**
 * Funcion generica q verifica si un valor existe en una tabla
 * @param type $table   Nombre de la tabla
 * @param type $campo1  primer campo    
 * @param type $campo2  segundo campo
 * @param type $nom     primer valor
 * @param type $ap      segundo valor
 * @param type $link
 * @return type
 */
function existeId($table, $campo1, $campo2, $nom, $ap, $link) {
    $query = sprintf("SELECT COUNT(*) 
        FROM $table 
        WHERE $campo1='%s' AND $campo2='%s'", $nom, $ap);
    $result = $link->query($query);
    $array = $link->fetchArray($result);
    $link->freeResult($result);
    return $array[0];
}

function existenId($valor1, $valor2, $link) {
    $query = sprintf("SELECT COUNT(*) 
        FROM folio 
        WHERE el_id=%d AND ella_id=%d", $valor1, $valor2);
    $result = $link->query($query);
    $array = $link->fetchArray($result);
    $link->freeResult($result);
    return $array[0];
}

/**
 * Trae un valor de una tupla
 * @param type $info nombre del valor q se busca
 * @param type $tabla nombre de la tabla
 * @param type $campo nombre del campo 
 * @param type $valor valor del campo
 * @param type $link
 * @return type
 */
function traeInfo($info, $tabla, $campo, $valor, $link) {
    $query = sprintf("SELECT $info 
                      FROM $tabla
                      WHERE $campo = '%s'", $valor);
    $result = $link->query($query);
    $row = $link->fetchArray($result);
    $link->freeResult($result);
    return $row[$info];
}

/**
 * Trae toda la informacion de una fila
 * @param type $tabla nombre de la tabla
 * @param type $campo nombre del campo 
 * @param type $valor valor del campo
 * @param type $link
 * @return type
 */
function traerTodo($tabla, $campo, $valor, $link) {
    $row = array();
    $query = sprintf("SELECT * 
                      FROM $tabla
                      WHERE $campo = '%s'", $valor);
    $result = $link->query($query);
    if ($result) {
        $row = $link->fetchAssoc($result);
    }
    $link->freeResult($result);
    return $row;
}

/**
 * Funcion generica que trae la informacion de una tabla basada en un valor
 * @param type $valor   valor q se busca
 * @param type $table   Nombre de la tabla
 * @param type $campo1  primer campo    
 * @param type $campo2  segundo campo
 * @param type $nom     primer valor
 * @param type $ap      segundo valor
 * @param type $link
 * @return type
 */
function infoId($valor, $tabla, $campo1, $campo2, $nom, $ap, $link) {
    $row = array();
    $query = sprintf("SELECT $valor 
                    FROM $tabla 
                    WHERE $campo1='%s' AND $campo2='%s'", $nom, $ap);
    $result = $link->query($query);
    $row = $link->fetchArray($result);
    $link->freeResult($result);
    return $row[$valor];
}

/**
 * Inserta un nuevo usuario
 * @param type $usuario Nombre de usuario
 * @param type $hash Hash de la contraseña
 * @param type $link link abierto mysql a la base de datos
 * @return type regresa true si se efectuo, false si hubo error
 */
function registraUsuario($usuario, $hash, $link) {
    $query = sprintf("INSERT INTO usuarios 
                      VALUES (NULL,'%s','%s','usuario')
                      ON DUPLICATE KEY UPDATE usuario_clave= '%s' ", $usuario, $hash, $hash);
    return $link->query($query);
}

/**
 * Inserta un nuevo Administrador
 * @param type $usuario Nombre de usuario de administrador
 * @param type $hash Hash de la contraseña
 * @param type $link link abierto mysql a la base de datos
 * @return type regresa true si se efectuo, false si hubo error
 */
function registraAdmin($usuario, $hash, $link) {
    $query = sprintf("INSERT INTO usuarios 
                      VALUES (NULL,'%s','%s','Administrador')
                      ON DUPLICATE KEY UPDATE usuario_clave= '%s' ", $usuario, $hash, $hash);
    $result = $link->query($query);
    return $result;
}

/**
 * Funcion no probada
 * q tre el numero de folio mediante los apellidos
 * @param type $el_paterno      apellido de el
 * @param type $el_nombre       nombre de el
 * @param type $ella_paterno    apellido de ella
 * @param type $ella_nombre     nombre de ella
 * @param type $link
 * @return type
 */
function folioId($el_paterno, $el_nombre, $ella_paterno, $ella_nombre, $link) {
    $arr_res = array();
    $query = sprintf("SELECT folio.folio_id
                        FROM el, ella, folio 
                        WHERE el.el_paterno='%s' AND el.el_nombre='%s'
                        AND ella.ella_paterno='%s' AND ella.ella_nombre='%s'
                        AND folio.el_id=el.el_id AND folio.ella_id=ella.ella_id'", $el_paterno, $el_nombre, $ella_paterno, $ella_nombre);
    $result = $link->query($query);
    if ($result) {
        while ($row = $link->fetchAssoc($result)) {
            $arr_res['folio_id'] = $row['folio_id'];
        }
    }
    $link->freeResult($result);
    return $arr_res['folio_id'];
}

/**
 * Selecciona las parejas del dia de hoy, para la pagina de cierre de curso
 * @param type $link
 * @return type
 */
function getListcierre($link) {
    $arr_res = array();
    $query = "SELECT el_paterno, el_materno,el_nombre, ella_paterno, ella_materno,ella_nombre, folio_id, termino 
        FROM el, ella, folio 
        WHERE  	folio.el_id=el.el_id AND folio.ella_id = ella.ella_id AND folio_id IN ( SELECT folio_id
                                FROM folio
                                WHERE disponible_id = CURDATE() )";
    $result = $link->query($query);
    if ($result) {
        while ($row = $link->fetchAssoc($result)) {
            $array['id'] = $row['folio_id'];
            $array['ella'] = $row['ella_paterno'] . " " . $row['ella_materno'] . ", " . $row['ella_nombre'];
            $array['el'] = $row['el_paterno'] . " " . $row['el_materno'] . ", " . $row['el_nombre'];
            $array['term'] = $row['termino'];
            $arr_res[] = $array;
        }
    }
    $link->freeResult($result);
    return $arr_res;
}

/**
 * Selecciona las parejas del dia de hoy, para la pagina de asistencia
 * @param type $link
 * @return string
 */
function getListAsistencia($hoy, $manana, $link) {
    $arr_res = array();
    $query = "SELECT el_paterno, el_materno,el_nombre, ella_paterno, ella_materno,ella_nombre, recibo, disponible_id
            FROM el, ella, folio 
            WHERE folio.el_id=el.el_id AND folio.ella_id = ella.ella_id AND folio_id IN ( 
                                SELECT folio_id
                                FROM folio
                                WHERE disponible_id = CURDATE())
            ORDER BY ella_paterno";
    $result = $link->query($query);
    if ($result) {
        while ($row = $link->fetchAssoc($result)) {
            $array['fecha'] = $row['disponible_id'];
            $array['recibo'] = $row['recibo'];
            $array['ella'] = $row['ella_paterno'] . " " . $row['ella_materno'] . ", " . $row['ella_nombre'];
            $array['el'] = $row['el_paterno'] . " " . $row['el_materno'] . ", " . $row['el_nombre'];
            $arr_res[] = $array;
        }
    }
    $link->freeResult($result);
    return $arr_res;
}

/**
 * Selecciona las parejas del dia de hoy, para la pagina de cierre de curso
 * @param type $link
 * @return type
 */
function getListdiploma($link) {
    $arr_res = array();
    $query = "SELECT el_paterno, el_materno,el_nombre, ella_paterno, ella_materno,ella_nombre, folio_id, disponible_id
        FROM el, ella, folio 
        WHERE  	folio.el_id=el.el_id AND folio.ella_id = ella.ella_id AND folio_id IN ( SELECT folio_id
                                FROM folio
                                WHERE disponible_id = CURDATE() )
                                ORDER BY ella_paterno";
    $result = $link->query($query);
    if ($result) {
        while ($row = $link->fetchAssoc($result)) {
            $array['id'] = $row['folio_id'];
            $array['fecha'] = $row['disponible_id'];
            $array['ella'] = $row['ella_paterno'] . " " . $row['ella_materno'] . ", " . $row['ella_nombre'];
            $array['el'] = $row['el_paterno'] . " " . $row['el_materno'] . ", " . $row['el_nombre'];
            $arr_res[] = $array;
        }
    }
    $link->freeResult($result);
    return $arr_res;
}

/**
 * Trae las citas 
 * @param type $link
 * @return type
 */
function getCitas($link) {
    $arr_res = array();
    $query = "SELECT disponible.* , platica.platica_capacidad, platica.platica_lugar
                FROM disponible, platica
                WHERE disponible.platica_id = platica.platica_id
                AND disponible.disponible_id > CURDATE( )
                ORDER BY disponible.disponible_id
                LIMIT 0 , 30";
    $result = $link->query($query);
    if ($result) {
        while ($row = $link->fetchAssoc($result)) {
            $array['fecha'] = $row['disponible_id'];
            $array['lugar'] = $row['platica_lugar'];
            $array['porciento'] = floor(100 * $row['disponible_contador'] / $row['platica_capacidad']) . " %";
            $array['activo'] = $row['disponible_activo'];
            $array['limite'] = $row['platica_capacidad'];
            $arr_res[] = $array;
        }
    }
    $link->freeResult($result);
    return $arr_res;
}

/**
 * Funcion que cierra citas
 * @param type $fecha fecha de la cita
 * @param type $link
 * @return type
 */
function cierraCita($fecha, $link) {
    $query = sprintf("UPDATE disponible 
                    SET disponible_activo = 'cerrado'
                    WHERE disponible_id = '%s' ", $fecha);
    $result = $link->query($query);
    return $result;
}
?>  

