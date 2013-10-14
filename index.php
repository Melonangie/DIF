<?php
/**
 * Pagina principal del sitio de Platicas
 */
session_start();

//Documento con queries a la tabla usuarios
include ('basededatos/usuarios.sql.php');

//Comienza la validacion de ingreso login
if (isset($_POST['ingresar']) && $_POST['ingresar'] == 'ingresar') {
    //limpia mensajes de error
    if (isset($error)) {
        unset($error);
    }
    if (isset($_POST['usuario'], $_POST['password'])) {
        //abre la conexion con la base de datos
        $db = new BD();
        //Trae el usuario y contraseña de Post
        $usuario = getPost('usuario', $db);
        $password = getPost('password', $db);
        //Hace el hash de la clave para comparalo con la base de datos
//        $sal = substr($usuario, 0, 2);
//        $hash = crypt($password, $sal);
        //Cuenta si hay un match entre usuarios y contraseñas
        $existe = existeUsuario($usuario, $password, $db);
        //Si el usuario existe 
        if ($existe == 1) {
            //trae la informacion del usuario
            $info = traerTodo('usuarios', 'usuario_nombre', $usuario, $db);
            if (!isArrayEmpty($info)) {
                $_SESSION['usuario_id'] = $info['usuario_id'];
                $_SESSION['usuario_nivel'] = $info['usuario_nivel'];
                $_SESSION['autentificado'] = TRUE;

                //configurar Location, dependiendo a donde uds quieren que redireccione si es Administrador, Usuario o Director.
                if ($_SESSION['usuario_nivel'] == "Administrador") {
                    //cierra la conexion
                    $db->closeConnexion();
                    header('Location:paginasAdmin/menu.php');
                } elseif ($_SESSION['usuario_nivel'] == "usuario") {
                    $existefolio = existe('folio', 'usuario_id', $info['usuario_id'], $db);
                    if ($existefolio == 1) {
                        $folio = traeInfo('folio_id', 'folio', 'usuario_id', $info['usuario_id'], $db);
                        $recibo = traeInfo('recibo', 'folio', 'usuario_id', $info['usuario_id'], $db);
                        $_SESSION['folio'] = TRUE;
                        $_SESSION['folio_id'] = $folio;
                        $_SESSION['recibo'] = $recibo;
                    }
                    else
                        $_SESSION['folio'] = FALSE;
                    //cierra la conexion
                    $db->closeConnexion();
                    header('Location:paginasUsuario/menu.php');
                }
            } else {
                $error = "Hubo un error, porfavor intentelo de nuevo";
            }
        } elseif ($existe !== 1) {
            $error = "Nombre de usuario o Contrase&ntilde;a incorrecta";
        }
    } else {
        $error = "Un campo esta vacio, porfavor intentelo de nuevo";
        $db->closeConnexion();
    }
}
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
        <link type="text/css" href="css/bootstrap.min.css" rel="stylesheet" />
        <link type="text/css" href="css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link type="text/css" href="css/custom-theme/jquery-ui-1.10.0.custom.css" rel="stylesheet" />
        <link type="text/css" href="css/font/font-awesome.min.css" rel="stylesheet" />
        <link type="text/css" href="css/newestilo.css" rel="stylesheet" />
        <link href="img/favicon.ico" rel="shortcut icon" >
        <!--[if IE 7]>
            <link rel="stylesheet" href="css/font/font-awesome-ie7.min.css" type="text/css"  />
        <![endif]-->
        <!--[if lt IE 9]>
            <script src="js/libs/html5shiv-3.6.1/html5shiv.js"></script>
            <link rel="stylesheet" href="css/custom-theme/jquery.ui.1.10.0.ie.css"/>
        <![endif]-->
        <!-- Le javascript
       ================================================== -->
        <script src="js/libs/jquery-1.9.0/jquery.min.js" type="text/javascript"></script>
        <script src="js/libs/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/libs/jqueryui-1.10.0/jquery-ui.js" type="text/javascript"></script>
        <script src="js/libs/jquery-validate-1.10.0/jquery.validate.min.js" type="text/javascript"></script>
        <script src="js/index.js" type="text/javascript"></script>
    </head>
    <body>

        <section class="container-narrow"><!-- contenedor -->
            <div class="container-fluid">

                <!-- Cabezara
                ================================================== -->
                <header class="row-fluid">
                    <div class="span3">
                        <img src="img/anillo.jpg" class="img-rounded">
                    </div>
                    <div class="span9">
                        <h1>Pl&aacute;ticas Prematrimoniales DIF - Tijuana</h1>    
                    </div>
                    <div class="clearfix"></div>
                    <hr class="headerhr"> 
                </header>

                <!-- Contenido
                ================================================== -->
                <article class="row-fluid ">

                    <div class="span2">&nbsp;</div>
                    <div class="span8">
                        <!--En caso de error en el formulario, desplegara un mensaje-->
                        <?php
                        if (isset($error)) {
                            echo "<div class='alert alert-error text-center'> 
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                    <i class='icon-exclamation-sign icon-white'></i>
                                    <strong>Error:&nbsp;</strong> $error
                                </div>";
                        }
                        ?>

                        <!-- Comienza la forma --> 
                        <form method="post"  id="contact-form" class="form-horizontal margin-top" action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                            <fieldset>
                                <legend>Inicie Sesi&oacute;n</legend>
                                <div class="control-group">
                                    <label class="control-label" for="usuario">Nombre de Usuario&nbsp;</label>
                                    <div class="controls">
                                        <input type="text" name="usuario" id="usuario" autocomplete="on" maxlength="10">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="password">Contrase&ntilde;a&nbsp;</label>
                                    <div class="controls">
                                        <input type="password" name="password" id="password" autocomplete="on" maxlength="60">
                                    </div>
                                </div>
                                <div class="form-actions text-center">
                                    <button type="submit" class="btn dif" name="ingresar" value="ingresar">Ingresar</button>
                                </div>
                            </fieldset>
                        </form>

                        <!-- /forma -->
                        <hr class="soften">
                        <p class="text-center">No tengo clave de usuario. 
                            <button  class="btn" onClick="window.location = 'paginasUsuario/registrar.php';">Registrar</button>
                        </p> 
                    </div> <!-- /columna2 -->
                    <div class="span2">&nbsp;</div> <!-- /columna3 -->
                </article>
            </div>
        </section><!-- /contenedor -->

        <!-- Footer
        ================================================== -->
        <footer>
            <div class="container-narrow">
                <div class="row-fluid">
                    <div class="span4"> <!-- /columna -->
                        <address>
                            Blvd. de los Insurgentes #17608<br />
                            Fracc. Los &aacute;lamos<br />
                            Tijuana, B. C. M&eacute;xico<br /> 
                            C. P. 22100
                        </address>
                    </div>
                    <div class="span4"> <!-- /columna -->
                        <a href="http://www.dif-tijuana.gob.mx/">
                            <img src="img/logodif.png" alt="logodif"/>
                        </a>
                        <p>© DIF Municipal de Tijuana, B. C.</p>
                    </div>
                    <div class="span4"> <!-- /columna -->
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