<?php
/**
 * Calendario
 * Pagina para capturara fechas de los asistentes
 * Pagina con una forma para seleccionar la fecha de la cita
 */
session_start();
if (!isset($_SESSION['autentificado']) || $_SESSION['autentificado'] === FALSE) {
    header('Location:../index.php');
}

//Archivo que carga paises, estados y ciudades
include '../basededatos/ingresar.sql.php';
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
        <link type="text/css" href="../css/font/font-awesome.min.css" rel="stylesheet" />
        <link type="text/css" href="../css/newestilo.css" rel="stylesheet" />
        <link type="text/css" href="../css/calendario.css" rel="stylesheet" />
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
        <script src="../js/libs/bootstrap.min.js" type="text/javascript"></script>
        <script src="../js/libs/jqueryui-1.10.0/jquery-ui.js" type="text/javascript"></script>
        <script src="../js/libs/jqueryui-1.10.0/jquery.ui.datepicker-es.js" type="text/javascript"></script>
        <script src="../js/libs/jquery-validate-1.10.0/jquery.validate.min.js" type="text/javascript"></script>
        <script src="../js/calendario.js" type="text/javascript"></script>
    </head>

    <body>
        <!-- Cabezera
            ================================================== -->
        <div class="container-narrow"><!-- contenedor -->

            <div class="masthead">
                <header class="row-fluid">
                    <div class="span3">
                        <a href="menu.php">
                            <img src="../img//anillo.jpg" class="img-rounded">
                        </a>
                    </div>
                    <div class="span9">
                        <h1>Pl&aacute;ticas Prematrimoniales DIF - Tijuana</h1>
                    </div>
                </header>
            </div>
            <hr class="headerhr">

            <!-- Contenido
            ================================================== -->
            <?php
            //verifica q el usuario no tenga una pareja registrada
            if ($_SESSION['folio_id'] == FALSE) {
                echo "
                    <div class='modal-backdrop fade in'></div>
                    <div id='myModal' class='modal' tabindex='-1' role='dialog'>
                        <div class='modal-header text-center'>
                            <h3 id='myModalLabel'><i class='icon-exclamation-sign'></i>  Aviso </h3>
                        </div>
                        <div class='modal-body text-center'>
                            <p>Ahun no ha capturado los datos de la pareja.</p>
                            <p>Porfavor capture primero su informacion. </p>
                        </div>
                        <div class='modal-footer text-center'>
                            <p>
                                <a class='btn dif mm' href='ingresar.php' >Ingresar Informacion</a>
                            </p>
                        </div>
                    </div>";
            }

            //Comienza la validacion del formulario
            if (isset($_POST['fecha']) && $_POST['fecha'] == 'fecha') {
                if (isset($error)) {
                    unset($error);
                }
                if (isset($_POST['alternate'], $_POST['alternate2'])) {

                    //abre la conexion con la base de datos
                    $db = new BD();

                    //Trae la fecha de Post
                    $fecha = getPost('alternate2', $db);
                    $fecha2 = getPost('alternate', $db);

                    if (!isEmpty($fecha) && !isEmpty($fecha2) && validaTipo($fecha, 'date')) {
                        //trae el id del folio
                        $parejaId = getSession('folio_id', $db);
                        //verifica el id dela platica
                        if (substr($fecha2, 0, 2) == 'Sa')
                            $dia = 2;
                        else
                            $dia = 1;

                        //registra la fecha
                        $registrofecha = registraFecha($fecha, $parejaId, $dia, $db);
                        $db->closeConnexion();

                        //Despliega mensaje 
                        if ($registrofecha) {
                            $_SESSION['disponible_id'] = $fecha2;
                            echo "<div class='alert alert-success text-center'>
                        <h4>¡Bien!</h4> 
                        La fecha <strong>" . $fecha2 . "</strong> se ha agregado exitosamente.<br />
                        <button class='btn btn-success' onClick=\"window.location = 'despedida.php'\">Siguiente</button> 
                      </div>";
                        }
                        else
                            $error = "Hubo un error, porfavor intentelo de nuevo.";
                    }
                    else
                        $error = "Uno o varios campos estan vacios.";
                }else {
                    $error = "Los campos deben estar bien llenados.";
                    $db->closeConnexion();
                }
                //En caso de error en el formulario, desplegara un mensaje
                if (isset($error)) {
                    echo "<div class='alert alert-error text-center'> 
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        <i class='icon-exclamation-sign icon-white'></i>
                        <strong>Error:&nbsp;</strong><br /> $error
                      </div>";
                }
            }
            ?>

            <div class="titulo centrar">Seleccione la fecha de la cita</div>
            <form method="post" id="cita" action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                <div class="margin-top text-center">
                    <div class="control-group">
                        <div class="controls">
                            <input type="text" class="text-center" id="alternate" name="alternate" size="30" readonly="readonly"/>
                            <input type="text" id="alternate2" name="alternate2" size="30" style="display:none" />
                            <button type="submit" class="btn dif mm" name="fecha" value="fecha">Seleccionar</button>
                        </div>
                    </div>
                </div>
                <hr class="soften">
                <div class="m3 text-center" ><span class="gray">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><strong>  Disponible</strong></div>
                <div class="m3 text-center" ><span class="naranja">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><strong>   Cupo Casi Lleno</strong></div>
                <div class="m3 text-center" ><span class="red">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><strong>   Cupo Lleno</strong></div>
                <div class="clearfix"></div>

                <div id="calendario" class="margin-top"></div>
            </form>
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