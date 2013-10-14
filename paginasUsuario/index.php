<?php

/**
 * Redirige
 */
session_start();
if (!isset($_SESSION['autentificado']) || $_SESSION['autentificado'] === FALSE) {
    header('Location:../index.php');
}
if ($_SESSION['usuario_nivel'] == "usuario"){
    header('Location:menu.php');
}
if ($_SESSION['usuario_nivel'] == "Administrador"){
    header('Location:../paginasAdmin/admin.php');
}
?>