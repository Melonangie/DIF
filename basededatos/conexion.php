<?php

/**
 * Clase para conectarse ala base de datos
 * @author angie
 */
//archivo con parametros de conexion
require ('datos.php');

//Inicia la clase
class BD {

    /**
     * variables de conexion
     * @var type 
     */
    protected $host, $user, $pass, $db;
    protected $debug = true;
    protected $link;

    /**
     * Constructor de la base de datos
     * @param type $h Direccion del host
     * @param type $u Nombre de usuario mysql
     * @param type $p Clave del usuario mysql
     * @param type $d Base de datos
     */
    function __construct($h = Setting::HOSTNAME, $u = Setting::USER, $p = Setting::PASSWD, $d = Setting::DB) {
        $this->host = $h;
        $this->user = $u;
        $this->pass = $p;
        $this->db = $d;
        $this->link = mysql_connect($this->host, $this->user, $this->pass);
        if (!$this->link)
            die('Conexion imposible : ' . mysql_error());
        mysql_select_db($this->db);
        mysql_set_charset('utf8', $this->link);
    }

    /**
     * Funcion que cierra la conexion a la base de datos
     */
    function closeConnexion() {
        mysql_close($this->link);
    }

    /**
     * Funcion para hacer queries a la base de datos
     * @param type $sql string de query
     * @return type regresa boolean si se ejecuto el query
     */
    function query($sql) {
        $res = mysql_query($sql);
        if ($this->debug && mysql_errno() != 0) {
            $message = '<strong>Query invalido:</strong><br /> ' . mysql_error() . "<br />";
            $message .= '<strong>Query:</strong><br /> ' . $sql;
            die($message);
        }
        return $res;
    }

    /**
     * Regresa un array asociando nombres con valores
     * @param type $result string con query
     * @return type array asociado
     */
    function fetchAssoc($result) {
        return mysql_fetch_assoc($result);
    }

    /**
     * REgresa un array con valores asociado o numericos
     * @param type $result string con el query
     * @return type array asociado o numerico o ambos
     */
    function fetchArray($result) {
        return mysql_fetch_array($result);
    }

    /**
     * Regresa los redultados de fila en fila
     * @param type $result string con el query
     * @return type array numerico, comenzando de 0
     */
    function fetchRow($result) {
        return mysql_fetch_row($result);
    }

    /**
     * Libera la memoria asociada con el query
     * @param type $result variable de conexion
     * @return type bool
     */
    function freeResult($result) {
        return mysql_free_result($result);
    }
    
    
    /* TRANSACCIONES */
    function begin() {
        $this->query("SET AUTOCOMMIT = 0");
        $this->query("START TRANSACTION");
    }

    function commit() {
        return $this->query("COMMIT");
    }

    function rollback() {
        return $this->query("ROLLBACK");
    }

}

?>
