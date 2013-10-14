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
//Archivo que carga paises, estados y ciudades
include '../basededatos/ingresar.sql.php';
//abre la conexion con la base de datos
$db = new BD();
//tare la tabla de lugares
$lugar = getSitios($db);
//llena el select de colonia con informacion
$colonia = opcionesColonias($db);
//cierra la conexion a la base de datos
$db->closeConnexion();
if(isset($cierre)) unset ($cierre);
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
        <script src="../js/libs/jquery-validate-1.10.0/jquery.validate.min.js" type="text/javascript"></script>
        <script src="../js/sitios.js" type="text/javascript"></script>

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
                <div class="titulo centrar  title-print">Administracion de Sitios</div>
                <div class="clearfix no-print"></div>

                <div class="margin-top text-center nomargin-print ">
                    <h4>Modifique los Datos de Sitios</h4>
                </div>

                <?php
                //verifica la forma
                if (isset($_POST['ingresar']) && $_POST['ingresar'] == 'ingresar') {
                    if (isset($_POST['lugar'], $_POST['capacidad'], $_POST['colonia'], $_POST['calle'], $_POST['numero'])) {
                        //abre la conexion con la base de datos
                        $db = new BD();
                        //Trae la fecha de Post
                        $sitio = getArray($_POST, $db);
                        //verifica errores en los valores de los campos
                        $error = verifica($sitio);
                        //Si no se encontro errorres en la forma
                        if ($error == 0) {
                            //registra el cambio
                            $cierre = updateSitios($sitio, $db);
                            $db->closeConnexion();
                            if ($cierre) {
                                echo "<div class='alert alert-success text-center'>
                                        <h4>¡Bien!</h4> 
                                        El sitio <strong>" . $sitio['id'] . "</strong> se ha modificado exitosamente.<br />
                                        <button class='btn btn-success' onClick=\"window.location = 'menu.php'\">Regresar al Menu</button> 
                                        <button class='btn' onClick=\"window.location.reload()\">Actulaizar valores</button>
                                      </div>";
                            }
                            else
                                $error = "Hubo un error, porfavor intentelo de nuevo.";
                        }
                        else
                            $db->closeConnexion();
                    }
                    else
                        $error = "Los campos deben estar bien llenados.";
                    //En caso de error en el formulario, desplegara un mensaje
                    if ($error != 0) {
                        echo "<div class='alert alert-error text-center'> 
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        <i class='icon-exclamation-sign icon-white'></i>
                        <strong>Error:&nbsp;</strong><br /> $error
                      </div>";
                    }
                }

                function verifica($datos) {
                    //array para verificar campos numericos y alphanumericos requeridos
                    $alpha = array('lugar', 'calle');
                    //verfica q ningun campo este vacio
                    if (isArrayEmpty($datos))
                        return $error = "Uno o varios campos estan vacios.</div>";
                    //verifica q los campos numericos sean nuemricos
                    if (!validaTipo($datos['capacidad'], 'numeros'))
                        return $error = "Los datos numericos son incorrectos.</div>";
                    //verifica q los campos $alpha contengan letras
                    if (!someLetters($datos, $alpha))
                        return $error = "Algunos campos no contienen letras.</div>";
                    //sin error
                    return 0;
                }
                ?>

                <!-- Imprime los lugares en pantalla
                ================================================== -->
                <?php for ($i = 0; $i < count($lugar); $i++) : ?>
                    <form class="form-horizontal validar" action='<?php echo $_SERVER['PHP_SELF']; ?>' method="post" >

                        <div class="clearfix"></div>
                        <fieldset class="span9 offset1">
                            <legend>Sitio <?php echo $lugar[$i]['id']; ?></legend>
                            <input type="hidden" value="<?php echo $lugar[$i]['id']; ?>" name="id">

                            <label class="control-label span4" for="lugar<?php echo $i; ?>" >Lugar de Platica</label>
                            <div class="control-group span7">
                                <div class="controls">
                                    <input type="text" value="<?php echo $lugar[$i]['lugar']; ?>" name="lugar" id="lugar<?php echo $i; ?>" autocomplete="on" maxlength="45">
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <label class="control-label span4" for="capacidad<?php echo $i; ?>" >Capacidad</label>
                            <div class="control-group span7">
                                <div class="controls">
                                    <input type="text" value="<?php echo $lugar[$i]['capacidad']; ?>" name="capacidad" id="capacidad<?php echo $i; ?>" autocomplete="on" maxlength="2">
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <label class="control-label span4">Colonia</label>
                            <div class="control-group span7">
                                <select name="colonia">
                                    <option selected="selected" value="<?php echo $lugar[$i]['colonia']; ?>"><?php echo $lugar[$i]['colonia']; ?></option>
                                    <?php echo $colonia; ?>
                                </select>
                            </div>
                            <div class="clearfix"></div>

                            <label class="control-label span4" for="calle<?php echo $i; ?>" >Calle</label>
                            <div class="control-group span7">
                                <div class="controls">
                                    <input type="text" value="<?php echo $lugar[$i]['calle']; ?>" name="calle" id="calle<?php echo $i; ?>" autocomplete="on" maxlength="45">
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <label class="control-label span4" for="numero<?php echo $i; ?>" >Numero</label>
                            <div class="control-group span7">
                                <div class="controls">
                                    <input type="text" value="<?php echo $lugar[$i]['numero']; ?>" name="numero" id="numero<?php echo $i; ?>" autocomplete="on" maxlength="8">
                                </div>
                            </div>
                            <div class="clearfix"></div>

                        </fieldset>
                        <!-- Botones
                    ================================================== -->
                        <div class="clearfix"></div>
                        <div class="text-center">
                            <button type="submit" class="btn dif mm" value="ingresar" name="ingresar">Registrar Informacion</button>
                        </div>
                    </form>
                <?php endfor; ?>

                <!-- Vuevo Sitio
                ================================================== -->
                <div class="clearfix"></div>

                <form class="form-horizontal validar" action='<?php echo $_SERVER['PHP_SELF']; ?>' method="post">
                    <fieldset class="span10 offset1">
                        <legend>Sitio <?php echo count($lugar) + 1; ?></legend>
                        <input type="hidden" value="<?php echo count($lugar) + 1; ?>" name="id">
                        <p>
                            <small>Marque el cuadro para agregar un nuevo sitio   </small>
                            <input class="inline"  type="checkbox" id="toggleElement" onchange="toggleStatus()" value="si" name="nuevositio">
                        </p>

                        <label class="control-label span4" for="lugar" >Lugar de Platica</label>
                        <div class="control-group span7">
                            <div class="controls">
                                <input type="text" name="lugar" id="lugar" autocomplete="on" maxlength="45" class="grupo">
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span4" for="capacidad" >Capacidad</label>
                        <div class="control-group span7">
                            <div class="controls">
                                <input type="text" name="capacidad" id="capacidad" autocomplete="on" maxlength="2" class="grupo">
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span4">Colonia</label>
                        <div class="control-group span7">
                            <select name="colonia" class="grupo">
                                <option selected="selected">--Seleccione la Colonia--</option>
                                <?php echo $colonia; ?>
                            </select>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span4" for="calle" >Calle</label>
                        <div class="control-group span7">
                            <div class="controls">
                                <input type="text" name="calle" id="calle" autocomplete="on" maxlength="45" class="grupo">
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span4" for="numero" >Numero</label>
                        <div class="control-group span7">
                            <div class="controls">
                                <input type="text" name="numero" id="numero" autocomplete="on" maxlength="8" class="grupo">
                            </div>
                        </div>
                        <div class="clearfix"></div>

                    </fieldset>

                    <!-- Botones
                    ================================================== -->
                    <div class="clearfix"></div>
                    <div class="text-center">
                        <button type="submit" class="btn dif mm grupo" value="ingresar" name="ingresar">Registrar Informacion</button>
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