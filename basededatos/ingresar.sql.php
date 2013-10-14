<?php

/**
 * PAgina que valida el ingreso de un usuario
 */
//Documento para conexion a la base de datos
include ('conexion.php');
//Documento para conexion a la base de datos
include ('funciones.php');

/**
  Lee los nombres de pais y los pone en opciones de un select
 * @return string deopciones con id del pais y nombre
 */
function opcionesPaises($link) {
//query
    $query = "SELECT * FROM pais ORDER BY pais_nombre";
//cadena con opciones del select pais
    $opcionesPais = null;
//array vacio
    $arr_res = array();
//    query
    $result = $link->query($query);
    if ($result) {
        while ($row = $link->fetchAssoc($result)) {
            $arr_res[$row['pais_id']] = $row['pais_nombre'];
        }
        foreach ($arr_res as $sCode => $sName) {
            $opcionesPais .= '<option value="' . $sCode . '">' . $sName . '</option>';
        }
    }
    return $opcionesPais;
}

/**
  Lee los nombres de las colonias de tijuana y los pone en opciones de un select
 * @return string deopciones con id del pais y nombre
 */
function opcionesColonias($link) {
//query
    $query = "SELECT * FROM colonia ORDER BY colonia";
//cadena con opciones del select pais
    $opcionesColonias = null;
//array vacio
    $arr_res = array();
//    query
    $result = $link->query($query);
    if ($result) {
        while ($row = $link->fetchAssoc($result)) {
            $arr_res[$row['colonia']] = $row['colonia'];
        }
        foreach ($arr_res as $sCode => $sName) {
            $opcionesColonias.= '<option value="' . $sCode . '">' . $sName . '</option>';
        }
    }
    return $opcionesColonias;
}

/**
  Lee las ocupaciones y los pone en opciones de un select
 * @return string deopciones con id del pais y nombre
 */
function opcionesOcupacion($link) {
//query
    $query = "SELECT ocupacion FROM ocupacion ORDER BY ocupacion";
//cadena con opciones del select pais
    $opcionesOcupacion = null;
//array vacio
    $arr_res = array();
//    query
    $result = $link->query($query);
    if ($result) {
        while ($row = $link->fetchAssoc($result)) {
            $arr_res[$row['ocupacion']] = $row['ocupacion'];
        }
        foreach ($arr_res as $sCode => $sName) {
            $opcionesOcupacion.= '<option value="' . $sCode . '">' . $sName . '</option>';
        }
    }
    return $opcionesOcupacion;
}

/**
  Lee los estados civiles y los pone en opciones de un select
 * @return string deopciones con id del pais y nombre
 */
function opcionesCivil($link) {
//query
    $query = "SELECT civil FROM civil ORDER BY civil";
//cadena con opciones del select pais
    $opcionesCivil = null;
//array vacio
    $arr_res = array();
//    query
    $result = $link->query($query);
    if ($result) {
        while ($row = $link->fetchAssoc($result)) {
            $arr_res[$row['civil']] = $row['civil'];
        }
        foreach ($arr_res as $sCode => $sName) {
            $opcionesCivil.= '<option value="' . $sCode . '">' . $sName . '</option>';
        }
    }
    return $opcionesCivil;
}

/**
  Lee los estados civiles y los pone en opciones de un select
 * @return string deopciones con id del pais y nombre
 */
function opcionesEducacion($link) {
//query
    $query = "SELECT escolaridad FROM escolaridad";
//cadena con opciones del select pais
    $opcionesEducacion = null;
//array vacio
    $arr_res = array();
//    query
    $result = $link->query($query);
    if ($result) {
        while ($row = $link->fetchAssoc($result)) {
            $arr_res[$row['escolaridad']] = $row['escolaridad'];
        }
        foreach ($arr_res as $sCode => $sName) {
            $opcionesEducacion.= '<option value="' . $sCode . '">' . $sName . '</option>';
        }
    }
    return $opcionesEducacion;
}

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
                      FROM %s 
                      WHERE %s='%s'", $table, $campo, $valor);
//realiza el query
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
 * Regresa el id de una pareja en la tabla folio
 * @param type $el id de usuario en la tabla El
 * @param type $ella id de usuario en la tabla Ella
 * @param type $link conexion abierta ala base de datos
 * @return type regresa un array con un numero
 */
function parejaId($el, $ella, $link) {
    $query = sprintf("SELECT folio_id 
                      FROM folio 
                      WHERE el_id ='%d' AND ella_id ='%d'
                      LIMIT 1", $el, $ella);
    $result = $link->query($query);
    $row = $link->fetchArray($result);
    $link->freeResult($result);
    return $row['folio_id'];
}

function registrar($array, $userId, $link) {
    $resp = array();
    $ok = TRUE;

    $el = sprintf("REPLACE INTO el 
                   VALUES (NULL,'%s','%s','%s','%s','%s','%s','%s',
                      '%s','%s','%s','%s','%s','Tijuana','%d','%d',
                      '%s','%s','%s','%s','%s',NULL)", $array['el_paterno'], $array['el_materno'], $array['el_nombre'], $array['el_fecha'], $array['el_pais'], $array['el_estado'], $array['el_ciudad'], strtoupper($array['el_curp']), $array['el_calle'], $array['el_numero'], $array['el_interior'], $array['el_colonia'], $array['el_cp'], $array['el_telefono'], $array['el_movil'], $array['el_email'], $array['el_ocupacion'], $array['el_escolaridad'], $array['el_civil']);

    $ella = sprintf("REPLACE INTO ella 
                     VALUES (NULL,'%s','%s','%s','%s','%s','%s','%s',
                      '%s','%s','%s','%s','%s','Tijuana','%d','%d',
                      '%s','%s','%s','%s','%s',NULL)", $array['ella_paterno'], $array['ella_materno'], $array['ella_nombre'], $array['ella_fecha'], $array['ella_pais'], $array['ella_estado'], $array['ella_ciudad'], strtoupper($array['ella_curp']), $array['ella_calle'], $array['ella_numero'], $array['ella_interior'], $array['ella_colonia'], $array['ella_cp'], $array['ella_telefono'], $array['ella_movil'], $array['ella_email'], $array['ella_ocupacion'], $array['ella_escolaridad'], $array['ella_civil']);

    $link->begin();
    $ok = $ok && ($link->query($el));
    $ok = $ok && ($resp['el_id'] = mysql_insert_id());
    $ok = $ok && ($link->query($ella));
    $ok = $ok && ($resp['ella_id'] = mysql_insert_id());

    $folio = sprintf("INSERT INTO folio 
                      VALUES (NULL,NULL,'%d','%d','%d','%d','La Mesa','%d','no',NULL)", (int) $resp['el_id'], (int) $resp['ella_id'], (int) $array['recibo'], (int) $array['hijos'], (int) $userId);

    $ok = $ok && ($link->query($folio));
    $ok = $ok && ($resp['folio_id'] = mysql_insert_id());

    if ($ok) {
        $link->commit();
        return $resp['folio_id'];
    } else {
        $link->rollback();
        return false;
    }
}

/**
 * Registra una fecha en la tablafolio para una pareja
 * @param type $fecha       fecha seleccionada
 * @param type $folio_id    id del folio del usuario
 * @param type $platica_id  fecha de la platica
 * @param type $link
 * @return type regresa falso si no re hizo el registro
 */
function registraFecha($fecha, $folio_id, $platica_id, $link) {
    $ok = TRUE;

    // Comienza la transaccion
    $link->begin();
    $select_contador = sprintf("SELECT *
                FROM disponible 
                WHERE disponible_id = '%s' 
                FOR UPDATE", $fecha);

    $create_contador = sprintf("INSERT INTO disponible
                VALUES ('%s','%d','1','abierto')
                ON DUPLICATE KEY UPDATE disponible_contador = disponible_contador + 1", $fecha, (int) $platica_id);

    $select_folio = sprintf("SELECT *
                FROM folio 
                WHERE folio_id = '%d' 
                FOR UPDATE", $folio_id);

    $update_folio = sprintf("UPDATE folio 
                SET disponible_id ='%s'
                WHERE folio_id = '%d'", $fecha, $folio_id);

    $ok = $ok && ($link->query($select_contador));
    $ok = $ok && ($link->query($create_contador));
    $ok = $ok && ($link->query($select_folio));
    $ok = $ok && ($link->query($update_folio));

    // Si no hay errores hace el registro 
    if ($ok) {
        $link->commit();
        return TRUE;
    }
    // Si hay un error no se hace ningun registro
    else {
        $link->rollback();
        return FALSE;
    }
}

/**
 * Modifica el registro de una pareja
 * @param type $datos   array con informacion de la pareja
 * @param type $folio   array de datos de la tabla folio
 * @param type $link
 * @return type regresa falso si no re hizo el registro
 */
function modificaRegistros($array, $folio, $link) {
    $ok = TRUE;

    $select_el = sprintf("SELECT *
                FROM el 
                WHERE el_id = '%s' 
                FOR UPDATE;", $folio['el_id']);

    $select_ella = sprintf("SELECT *
                FROM ella 
                WHERE ella_id = '%s' 
                FOR UPDATE;", $folio['ella_id']);

    $modifica_el = sprintf("UPDATE el
        SET el_paterno='%s',el_materno='%s',el_nombre='%s',
        el_fecha='%s',el_pais_nombre='%s',el_estado_nombre='%s',
        el_ciudad_nombre='%s',el_curp='%s',el_calle='%s',
        el_numero='%s',el_interior='%s',el_colonia='%s',
        el_cp='%d',el_telefono='%d',el_movil='%s',
        el_email='%s',el_ocupacion='%s',
        el_escolaridad='%s',el_civil='%s'
        WHERE el_id = '%s' ", $array['el_paterno'], $array['el_materno'], $array['el_nombre'], $array['el_fecha'], $array['el_pais'], $array['el_estado'], $array['el_ciudad'], strtoupper($array['el_curp']), $array['el_calle'], $array['el_numero'], $array['el_interior'], $array['el_colonia'], $array['el_cp'], $array['el_telefono'], $array['el_movil'], $array['el_email'], $array['el_ocupacion'], $array['el_escolaridad'], $array['el_civil'], $folio['el_id']);

    $modifica_ella = sprintf("UPDATE ella
        SET ella_paterno='%s',ella_materno='%s',ella_nombre='%s',
        ella_fecha='%s',ella_pais_nombre='%s',ella_estado_nombre='%s',
        ella_ciudad_nombre='%s',ella_curp='%s',ella_calle='%s',
        ella_numero='%s',ella_interior='%s',ella_colonia='%s',
        ella_cp='%d',ella_telefono='%d',ella_movil='%s',
        ella_email='%s',ella_ocupacion='%s',
        ella_escolaridad='%s',ella_civil='%s'
        WHERE ella_id = '%s' ", $array['ella_paterno'], $array['ella_materno'], $array['ella_nombre'], $array['ella_fecha'], $array['ella_pais'], $array['ella_estado'], $array['ella_ciudad'], strtoupper($array['ella_curp']), $array['ella_calle'], $array['ella_numero'], $array['ella_interior'], $array['ella_colonia'], $array['ella_cp'], $array['ella_telefono'], $array['ella_movil'], $array['ella_email'], $array['ella_ocupacion'], $array['ella_escolaridad'], $array['ella_civil'], $folio['ella_id']);

    // Comienza la transaccion
    $link->begin();
    $ok = $ok && ($link->query($select_el));
    $ok = $ok && ($link->query($modifica_el));
    $ok = $ok && ($link->query($select_ella));
    $ok = $ok && ($link->query($modifica_ella));

    // Si no hay errores hace el registro 
    if ($ok)
        $link->commit();
    // Si hay un error no se hace ningun registro
    else
        $link->rollback();

    return $ok;
}

/**
 * Funcion llamada para llenar un mensaje de error
 * @param type $id  user id
 * @param type $link
 * @return type
 */
function nombres($id, $link) {
    $arr_res = array();
    $query = sprintf("SELECT el.el_nombre, el.el_paterno, ella.ella_nombre, ella.ella_paterno, folio.folio_id, usuarios.usuario_nombre 
        FROM el, ella, folio, usuarios 
        WHERE el.el_id=folio.el_id AND ella.ella_id=folio.ella_id 
        AND usuarios.usuario_id='%s' AND folio.usuario_id='%s'", $id, $id);
    //realiza el query
    $result = $link->query($query);
    if ($result) {
        while ($row = $link->fetchAssoc($result)) {
            $arr_res['el_nombre'] = $row['el_nombre'];
            $arr_res['el_paterno'] = $row['el_paterno'];
            $arr_res['ella_nombre'] = $row['ella_nombre'];
            $arr_res['ella_paterno'] = $row['ella_paterno'];
            $arr_res['folio_id'] = $row['folio_id'];
            $arr_res['usuario_nombre'] = $row['usuario_nombre'];
        }
    }
    $link->freeResult($result);
    return $arr_res;
}

/**
 * Regresa un multiarray con la informacion de las platicas
 * @param type $link
 * @return type
 */
function getSitios($link) {
    $arr_res = array();
    $query = "SELECT * FROM platica";
    //realiza el query
    $result = $link->query($query);
    if ($result) {
        while ($row = $link->fetchAssoc($result)) {
            $arr['id'] = $row['platica_id'];
            $arr['lugar'] = $row['platica_lugar'];
            $arr['calle'] = $row['platica_calle'];
            $arr['numero'] = $row['platica_numero'];
            $arr['colonia'] = $row['platica_colonia'];
            $arr['capacidad'] = $row['platica_capacidad'];
            $arr_res[] = $arr;
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
function updateSitios($sitio, $link) {
    $query = sprintf("INSERT INTO platica 
                     (platica_id,platica_lugar,platica_calle,platica_numero,platica_colonia,platica_capacidad)
                     VALUES (%d,'%s','%s','%s','%s',%d)
                     ON DUPLICATE KEY UPDATE platica_lugar='%s',platica_calle='%s',platica_numero='%s',platica_colonia='%s',platica_capacidad=%d 
                    ", $sitio['id'],$sitio['lugar'], $sitio['calle'], $sitio['numero'], $sitio['colonia'], $sitio['capacidad'], $sitio['lugar'], $sitio['calle'], $sitio['numero'], $sitio['colonia'], $sitio['capacidad']);
    $result = $link->query($query);
    return $result;
}
?>  
