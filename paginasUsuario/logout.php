<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

session_start(); //to ensure you are using same session
session_destroy(); //destroy the session
header("location:http://www.dif-tijuana.gob.mx/"); //to redirect back to "index.php" after logging out
exit();

?>
