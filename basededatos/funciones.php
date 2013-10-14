<?php

/*
 * Archivo con funciones basicas para hacer queries
 * @author angie
 */

/**
 * Escapa datos sin una conexion a la base de daots abierta
 * @param type $var Nombre e la variable
 * @return type Valor delavarible escapada
 */
function sanitizeString($variable) {
    if (get_magic_quotes_gpc())
        $limpio = stripslashes($variable);
    $limpio = htmlentities($variable);
    return strip_tags($limpio);
}

/**
 * Escapa datos antes de ponerlos en la base de datos
 * @param type $var   Nombre e la variable
 * @return type Valor delavarible escapada
 */
function getPost($variable, $link) {
    $limpio = mysql_real_escape_string($_POST[$variable]);
    return sanitizeString($limpio);
}

/**
 * Escapa datos antes de ponerlos en la base de datos
 * @param type $var   Nombre e la variable
 * @return type Valor delavarible escapada
 */
function getSession($variable, $link) {
    $limpio = mysql_real_escape_string($_SESSION[$variable]);
    return sanitizeString($limpio);
}

/**
 * Escapa datos antes de ponerlos en la base de datos
 * @param type $var   Nombre e la variable
 * @return type Valor delavarible escapada
 */
function getGet($variable, $link) {
    $limpio = mysql_real_escape_string($_GET[$variable]);
    return sanitizeString($limpio);
}

/**
 * Escapa datos del array Post antes de ponerlos en la base de datos
 * @param type $array $_POST
 * @param type $link  conexion abierta a la base de datos
 * @return type regresa un array escapado
 */
function getArray($array, $link) {
    $limpio = array_map("mysql_real_escape_string", $array);
    return array_map("sanitizeString", $limpio);
}

/**
 * Limpia datos antes de impriirlos enHTML
 * @param type $var
 * @return type
 */
function putPost($variable) {
    $limpio = preg_replace('#]*>.*?#is', '', $variable);
    return htmlspecialchars($limpio, ENT_QUOTES, 'UTF-8');
}

/**
 * Verifica si un string esta vacio
 * @param type $input string
 * @return type bool
 */
function isEmpty($input) {
    return (!isset($input) || trim($input) === '');
}

/**
 * Verifica si un array tiene algun valor vacio
 * @param type $datos array asociativo
 * @return boolean true vacio, false lleno
 */
function isArrayEmpty($array) {
    foreach ($array as $k => $v) {
        if ((trim($array[$k]) === ''))
            return true;
    }
    return false;
}

/**
 * Valida si es de un tipo especifico
 * @param type $input string
 * @param type $tipo tipo esperadp
 * @return type bool
 */
function validaTipo($input, $tipo) {
    $ok = false;
    setLocale(LC_CTYPE, 'es_ES.UTF-8');
    switch ($tipo) {
        case 'letras' : $ok = ctype_alpha($input);
            break;
        case 'numeros' : $ok = ctype_digit($input);
            break;
        case 'email': $ok = filter_var($input, FILTER_VALIDATE_EMAIL);
            break;
        case 'alpha': $ok = (preg_match("/[a-z'-]+$/i", $input));
            break;
        case 'date': $ok = (date('Y-m-d', strtotime($input)) == $input);
            break;
    }
    return $ok;
}

/**
 * Valida campos numericos
 * @param type $array array de datos asociativo
 * @param type $numericos array de campos
 * @return boolean 
 */
function onlyNumbers($array, $numericos) {
    foreach ($numericos as $field) {
        if (!validaTipo($array[$field], 'numeros'))
            return false;
    }
    return true;
}

/**
 * Valida campos numericos
 * @param type $array array de datos asociativo
 * @param type $numericos array de campos
 * @return boolean 
 */
function someLetters($array, $alpha) {
    foreach ($alpha as $field) {
        if (!validaTipo($array[$field], 'alpha'))
            return false;
    }
    return true;
}

/**
 * Recibe una fecha y regesa un dia
 * @param type $fecha año-mes-dia
 * @return string dia de la semana
 */
function traduceDias($fecha) {
    $dia = date("D", strtotime($fecha));
    switch ($dia) {
        case 'Mon': $dia = "Lunes";
            break;
        case 'Tue': $dia = "Martes";
            break;
        case 'Wed': $dia = "Miercoles";
            break;
        case 'Thu': $dia = "Jueves";
            break;
        case 'Fri': $dia = "Viernes";
            break;
        case 'Sat': $dia = "Sabado";
            break;
        default :$dia = "mmm";
            break;
    }
    return $dia;
}

/**
 * Recibe una fecha y regresa un mes en español
 * @param type $fecha año-mes-dia
 * @return string mes en español
 */
function traduceMes($fecha) {
    $mes = substr($fecha, 5, 2);
    switch ($mes) {
        case "01":$mes = "Enero";
            break;
        case "02":$mes = "Febrero";
            break;
        case "03":$mes = "Marzo";
            break;
        case "04":$mes = "Abril";
            break;
        case "05":$mes = "Mayo";
            break;
        case "06":$mes = "Junio";
            break;
        case "07":$mes = "Julio";
            break;
        case "08":$mes = "Agosto";
            break;
        case "09":$mes = "Septiembre";
            break;
        case "10":$mes = "Octubre";
            break;
        case "11":$mes = "Noviembre";
            break;
        case "12":$mes = "Diciembre";
            break;
    }
    return $mes;
}

?>
