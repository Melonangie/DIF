<?php
/**
 * Menu
 * 
 */
session_start();
if (!isset($_SESSION['autentificado']) || $_SESSION['autentificado'] === FALSE) {
    header('Location:../index.php');
}
if ($_SESSION['usuario_nivel'] == "usuario") {
    die('Prohibido');
}
include '../basededatos/usuarios.sql.php';
//abre la conexion con la base de datos
$db = new BD();
//tare la tabla de usuarios
$citas = getCitas($db);
//cierra la conexion a la base de datos
$db->closeConnexion();
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Metas
        ================================================== -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Pl&aacute;ticas Prematrimoniales</title>
        <meta name="description" content="DIF-Tijuana, 2013. Registrarse y asiste a Pl&aacute;ticas Prematrimoniales en el DIF de Tijuana" />
        <meta name="generator" content="DIF-Tijuana, B. C. 2013  www.dif-tijuana.gob.mx">
        <meta name="keywords" content="DIF, Tijuana, Baja California, Mexico" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="author" content="Israel Cardona, Renato Martinez" />
        <meta name="viewport" content="width=device-width"/>
        <meta name="HandheldFriendly" content="True" />
        <meta name="MobileOptimized" content="320" />
        <meta http-equiv="cleartype" content="On" />
        <!-- CSS
        ================================================== -->
        <link type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine" rel="stylesheet">
        <link type="text/css" href="../css/bootstrap.min.css" rel="stylesheet" />
        <link type="text/css" href="../css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link type="text/css" href="../css/custom-theme/jquery-ui-1.10.0.custom.css" rel="stylesheet" />
        <link type="text/css" href="../css/font/font-awesome.min.css" rel="stylesheet" />
        <link type="text/css" href="../css/newestilo.css" rel="stylesheet" />
        <link type="text/css" href="../css/print-admin.css" rel="stylesheet" />
        <link href="img/favicon.ico" rel="shortcut icon" >
        <!--[if IE 7]>
            <link rel="stylesheet" href="../css/font/font-awesome-ie7.min.css" type="text/css"  />
        <![endif]-->
        <!--[if lt IE 9]>
            <script src="../js/libs/html5shiv-3.6.1/html5shiv.js"></script>
            <link rel="stylesheet" href="../css/custom-theme/jquery.ui.1.10.0.ie.css"/>
        <![endif]-->
        <!-- Le javascript
   ================================================== -->
        <script src="../js/libs/jquery-1.9.0/jquery.min.js" type="text/javascript"></script>
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../js/libs/jqueryui-1.10.0/jquery-ui.js" type="text/javascript"></script>

    <body>
        <!-- Cabezera
            ================================================== -->
        <div class="container-narrow"><!-- contenedor -->
            <header class="row-fluid">
                <div class="span3">
                    <img src="../img/anillo.jpg" class="img-rounded">
                </div>
                <div class="span8">
                    <h1>Pl&aacute;ticas Prematrimoniales DIF - Tijuana </h1>
                </div>
            </header>
            <hr class="headerhr no-print">

            <!-- Contenido
            ================================================== -->
            <section class="row-fluid ">
                <div class="titulo centrar  title-print">Administracion de Calendarios</div>
                <div class="clearfix no-print"></div>

                <div class="margin-top text-center nomargin-print ">
                    <h4>Cursos Abiertos</h4>
                </div>

                <div class="margin-top"></div>  
                <?php
                //verifica la forma
                if (isset($_POST['cerrar']) && $_POST['cerrar'] == 'cerrar') {
                    if (isset($_POST['fecha'])) {
                        //abre la conexion con la base de datos
                        $db = new BD();

                        //Trae la fecha de Post
                        $fecha = getPost('fecha', $db);
                        //registra el cambio
                        $cierre = cierraCita($fecha, $db);
                        $db->closeConnexion();
                        if ($cierre) {
                            echo "<div class='alert alert-success text-center'>
                        <h4>¡Bien!</h4> 
                        La platica del dia <strong>" . $fecha . "</strong> se ha cerrado exitosamente.<br />
                        <button class='btn btn-success' onClick=\"window.location = 'menu.php'\">Regresar al Menu</button> 
                        <button class='btn' onClick=\"window.location.reload()\">Actulaizar valores</button>
                    </div>";
                        }
                        else
                            $error = "Hubo un error, porfavor intentelo de nuevo.";
                    }
                    else
                        $error = "Los campos deben estar bien llenados.";
                    //En caso de error en el formulario, desplegara un mensaje
                    if (isset($error)) {
                        echo "<div class='alert alert-error text-center'> 
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        <i class='icon-exclamation-sign icon-white'></i>
                        <strong>Error:&nbsp;</strong><br /> $error
                      </div>";
                    }
                }

                //imprime la tabla de asistentes
                for ($i = 0; $i < count($citas); $i++) {
                    //Convierte dia a español
                    $dia = traduceDias($citas[$i]['fecha']);
                    $dia2 = substr($citas[$i]['fecha'], 8, 2);
                    $ano = substr($citas[$i]['fecha'], 0, 4);
                    $dia = traduceDias($citas[$i]['fecha']);
                    $mes = traduceMes($citas[$i]['fecha']);

                    //empieza la mpresion de fechas
                    echo '<div class="well">';
                    echo '<div class="span9 margin-bottom">';
                    echo '<strong>' . $dia . ", " . $dia2 . " de " . $mes . " de " . $ano . "</strong>";
                    echo "</div>";
                    echo '<div class="span3 margin-bottom ">';
                    echo "El Curso esta: ";
                    if ($citas[$i]['activo'] == 'cerrado') {
                    echo '<span class="label label-important">'. $citas[$i]['activo'] . "</span>";
                    }else
                        echo '<span class="label label-success">'. $citas[$i]['activo'] . "</span>";
                    echo '</div>';
                    echo '<div class="clearfix"></div>';
                    echo '<div class="span3 margin-super">';
                    echo 'Lugar: <span class="label label-info">' . $citas[$i]['lugar'] . '</span>';
                    echo '</div>';
                    echo '<div class="span3 margin-super">';
                    echo 'Capacidad: <span class="badge badge-success">' . $citas[$i]['limite'] . '</span>';
                    echo '</div>';
                    echo '<div class="span3 margin-super">';
                    echo 'Lleno: <span class="badge badge-warning">' . $citas[$i]['porciento'] . '</span>';
                    echo '</div>';
                    echo '<div class="span2 margin-super ">';
                    if ($citas[$i]['activo'] == 'abierto') {
                        echo '<form method="post" action=' . $_SERVER['PHP_SELF'] . '>';
                        echo '<input type="hidden" value="' . $citas[$i]['fecha'] . '" name="fecha" />';
                        echo '<button class="btn btn-danger centrar" type="submit" name="cerrar" value="cerrar">Cerrar Curso</button>';
                        echo '</form>';
                    }
                    echo '</div>';
                    echo '</div>';
                }
                ?>

                <!-- Botones
                ================================================== -->
                <div class="clearfix"></div>
                <p class="text-center margin-top" >
                    <button class="btn dif center no-print" onClick="window.location = 'menu.php'">Regresar al Menu</button>
                </p>

            </section>
        </div>


        <!-- Footer
        ================================================== -->
        <footer class="footer">
            <div class="container-narrow">
                <div class="row-fluid marketing">
                    <div class="span4">
                        <address>
                            Blvd. de los Insurgentes #17608<br />
                            Fracc. Los &aacute;lamos<br />
                            Tijuana, B. C. M&eacute;xico<br /> 
                            C. P. 22100
                        </address>
                    </div>
                    <div class="span4">
                        <a href="http://www.dif-tijuana.gob.mx/">
                            <img src="../img/logodif.png" alt="logodif"/>
                        </a>
                        <p>© DIF Municipal de Tijuana, B. C.</p>
                    </div>
                    <div class="span4 last">
                        <address>
                            <a href="tel:6088200">Tel&eacute;fono: 608-8200</a><br />
                            <a href="mailto:info@dif-tijuana.gob.mx">info@dif-tijuana.gob.mx</a><br />
                            <a href="http://www.dif-tijuana.gob.mx/contact-form/index.php">Forma El&eacute;ctronica</a>
                        </address>
                    </div>
                </div>
            </div>
        </footer>

    </body>
</html>