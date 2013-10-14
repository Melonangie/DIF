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
        <script src="../js/libs/jquery-validate-1.10.0/jquery.validate.min.js" type="text/javascript"></script>
        <script src="../js/libs/autocomplete/jquery.ui.autocomplete.accentFolding.js" type="text/javascript"></script>
        <script src="../js/libs/autocomplete/jquery.ui.autocomplete.autoSelect.js" type="text/javascript"></script>
        <script src="../js/buscar.js" type="text/javascript"></script>

    </head>

    <body>
        <!-- Cabezera
            ================================================== -->
        <div class="container-narrow"><!-- contenedor -->
            <header class="row-fluid">
                <div class="span3">
                    <img src="../img//anillo.jpg" class="img-rounded">
                </div>
                <div class="span9">
                    <h1>Pl&aacute;ticas Prematrimoniales <br />DIF - Tijuana</h1>
                </div>
            </header>
            <hr class="headerhr">

            <!-- Contenido
            ================================================== -->

            <section class="row-fluid ">
                <?php
                //Comienza la validacion del registro
                if (isset($_POST['Buscar']) && $_POST['Buscar'] == 'Buscar') {
                    //abre la conexion con la base de datos
                    $db = new BD();
                    //limpia el array Post y lo pone en el array $datos
                    $datos = getArray($_POST, $db);
                    //Si se hizo la busqueda por numero de folio
                    if (isset($datos['pareja']) && $datos['pareja'] == 'pareja') {
                        //Valida que solo sean numeros
                        if (validaTipo($datos['folio'], 'numeros')) {
                            //Si la pareja existe redirige a otra pagina
                            if (existe('folio', 'folio_id', $datos['folio'], $db) == 1) {
                                //cierra la conexion a la base de datos
                                $db->closeConnexion();
                                header('Location:modificar.php?id=' . $datos['folio']);
                            }
                            else
                                $error = 5;
                        }
                        else
                            $error = 2;
                        // Si se hizo la busqueda por numero de recibo
                    } elseif (isset($datos['numero']) && $datos['numero'] == 'numero') {
                        //Valida que solo sean numeros
                        if (validaTipo($datos['recibo'], 'numeros')) {
                            //Si la pareja existe redirige a otra pagina
                            if (existe('folio', 'recibo', $datos['recibo'], $db) == 1) {
                                $id = traeInfo('folio_id', 'folio', 'recibo', $datos['recibo'], $db);
                                if (count($id) > 1) {
                                    $error = 6;
                                } elseif (count($id) == 1) {
                                    //cierra la conexion a la base de datos
                                    $db->closeConnexion();
                                    header('Location:modificar.php?id=' . $id);
                                }
                                else
                                    $error = 4;
                            }
                            else
                                $error = 5;
                        }
                        else
                            $error = 2;
                        // Si se hizo la busqueda por npmbres
                    } elseif (isset($datos['el_nombre'], $datos['el_paterno'], $datos['ella_nombre'], $datos['ella_paterno'])) {
                        //si se registro el id de el y ella 
                        if (isset($datos['el_id'], $datos['ella_id']) && !isEmpty($datos['el_id']) && !isEmpty($datos['ella_id'])) {
                            if (existenId($datos['el_id'], $datos['ella_id'], $db) == 1) {
                                $id = infoId('folio_id', 'folio', 'el_id', 'ella_id', $datos['el_id'], $datos['ella_id'], $db);
                                //cierra la conexion a la base de datos
                                $db->closeConnexion();
                                header("Location:modificar.php?id=" . $id);
                            }
                            else
                                $error = 5;
                        } else {
                            //Valida que tenga letras
                            $alpha = array('el_paterno', 'ella_paterno', 'el_nombre', 'ella_nombre');
                            if (someLetters($datos, $alpha)) {
                                //valida que los nombres existan en la base dedatos
                                $el = existeId('el', 'el_paterno', 'el_nombre', $datos['el_paterno'], $datos['el_nombre'], $db);
                                $ella = existeId('ella', 'ella_paterno', 'ella_nombre', $datos['ella_paterno'], $datos['ella_nombre'], $db);
                                //si los nombres estan registrados busca el numero de folio
                                if ($el != 0 && $ella != 0) {
                                    $id = folioId($datos['el_paterno'], $datos['el_nombre'], $datos['ella_nombre'], $datos['ella_paterno'], $db);
                                    //si encuentra el numero de folio
                                    if ($id != 0) {
                                        //cierra la conexion a la base de datos
                                        $db->closeConnexion();
                                        header('Location:modificar.php?id=' . $id);
                                    }
                                    else
                                        $error = 5;
                                }
                                else
                                    $error = 5;
                            }
                            else
                                $error = 3;
                        }
                    }
                    else
                        $error = 1;
                    //cierra la conexion a la base de datos
                    $db->closeConnexion();
                    if (isset($error))
                        despliegaError($error);
                }

                function despliegaError($error) {
                    echo '<div class="alert alert-error text-center">
                             <button type="button" class="close" data-dismiss="alert">&times;</button>
                             <h4>¡Error!</h4>';
                    switch ($error) {
                        case 1 : echo "Uno o varios campos estan vacios.</div>";
                            break;
                        case 2 : echo "Los datos numericos son incorrectos<.</div>";
                            break;
                        case 3 : echo "Algunos campos no contienen letras.</div>";
                            break;
                        case 4 : echo "Hubo un error, porfavor intentelo de nuevo.</div>";
                            break;
                        case 5 : echo "La pareja no existe.</div>";
                            break;
                        case 6 : echo "Existen varios registros con el mismo numero.</div>";
                            break;
                        default : echo "Los campos deben estar bien llenados.</div>";
                            break;
                    }
                }
                ?>
                <div class="titulo centrar">Buscar Pareja</div>
                <div class="clearfix"></div>

                <img class="centrar margin-top" src="../img/parejita.jpg"  alt="parejita"/><br>

                <form id="buscar" class="form-horizontal" action='<?php echo $_SERVER['PHP_SELF']; ?>' method="post">

                    <div class="visible-tablet visible-desktop span12">
                        <div class="span3 offset3"><h3>El</h3></div>
                        <div class="span3"><h3>Ella </h3></div>
                    </div>
                    <div class="clearfix"></div>

                    <fieldset>
                        <label class="control-label ui-widget span3" style="margin-left:2.5641%">Apellido Paterno</label>
                        <div class="control-group span3">
                            <div class="controls">
                                <input type="text" name="el_paterno" id="el_paterno" class="grupo" autocomplete="off" maxlength="25" >
                                <input type="hidden" name="el_id" id="el_id" onchange="buscaElla(this.value);"/>
                            </div>
                        </div>
                        <div class="control-group ui-widget span3">
                            <div class="controls">
                                <input type="text" name="ella_paterno" id="ella_paterno" class="grupo" autocomplete="off" maxlength="25" >
                                <input type="hidden" name="ella_id" id="ella_id" />
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span3">Nombre</label>
                        <div class="control-group span3">
                            <div class="controls">
                                <input type="text" name="el_nombre" id="el_nombre" class="grupo" autocomplete="off" maxlength="25" >
                            </div>
                        </div>
                        <div class="control-group span3">
                            <div class="controls">
                                <input type="text"  name="ella_nombre" id="ella_nombre" class="grupo" autocomplete="off" maxlength="25" >
                            </div>
                        </div>
                        <div class="clearfix"></div>

                    </fieldset>

                    <fieldset>
                        <fieldset class="margin-top" >
                            <div class="span2" style="margin-left:2.5641%">&nbsp;</div>
                            <label class="control-label span3" >
                                Numero de Folio <input class="inline" type="checkbox" id="toggleElement3" name="pareja" value="pareja" onchange="toggleStatus()" >
                            </label>
                            <div class="control-group span3">
                                <div class="controls" >
                                    <input type="text" name="folio" id="folio" class="grupo3" autocomplete="on" maxlength="7" >
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="span2">&nbsp;</div>
                            <label class="control-label span3">
                                Numero de Recibo <input class="inline" type="checkbox" id="toggleElement2" name="numero" value="numero" onchange="toggleStatus2()" >
                            </label>
                            <div class="control-group span3">
                                <div class="controls">
                                    <input type="text" name="recibo" id="recibo" class="grupo2" autocomplete="on" maxlength="7" >
                                </div>
                            </div>
                            <div class="clearfix"></div>

                        </fieldset>

                        <!-- Botones
                            ================================================== -->
                        <div class="span2" style="margin-left:2.5641%">&nbsp;</div>
                        <div class="form-actions span8" >
                            <div class="text-center" >
                                <button type="submit" class="btn dif mm" value="Buscar" name="Buscar">  Buscar Pareja  </button>
                                <button type="reset" class="btn mm">Borrar Formulario</button>
                            </div>
                        </div>

                </form>

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
