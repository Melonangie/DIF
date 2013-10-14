<?php
/**
 * Pagina para ingresar nuevos usuarios
 */
//Documento con queries a la tabla usuarios
include ('../basededatos/usuarios.sql.php');
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
        <script src="../js/registrar.js" type="text/javascript"></script>
    </head>

    <body>
        <!-- Cabezera
        ================================================== -->
        <div class="container-narrow"><!-- contenedor -->
            <div class="masthead">
                <header class="row-fluid">
                    <div class="span3">
                        <a href="../index.php">
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
            <div class="row-fluid ">
                <div class="span2">&nbsp;</div>

                <div class="span8">
                    <?php
                    //Comienza la validacion del registro
                    if (isset($_POST['registrar']) && $_POST['registrar'] == 'registrar') {
                        if (isset($_POST['nuevo_usuario'], $_POST['clave'], $_POST['clave2'])) {
                            //abre la conexion con la base de datos
                            $db = new BD();
                            //Trae el usuario y contraseña de Post
                            $usuario = getPost('nuevo_usuario', $db);
                            $password = getPost('clave', $db);
                            $password2 = getPost('clave2', $db);
                            //Cuenta los nombres de usuario
                            $existe = existe('usuarios','usuario_nombre',$usuario, $db);
                            //verifica que la forma no tenga errores
                            $error = verifica($usuario, $password, $password2, $existe);
                            //Si el usuario existe 
                            if ($error == 0) {
                                //Hace el hash de la clave para comparalo con la base de datos
                                //$sal = substr($usuario, 0, 2);
                                //$hash = crypt($password, $sal);
                                //hace el registro
                                if (registraUsuario($usuario, $password, $db)) {
                                    //cierra la conexion
                                    $db->closeConnexion();
                                    echo "<div class='alert alert-success text-center'>
                                             <h4>¡Bien!</h4> <br />
                                             Su usuario <strong> $usuario </strong> se ha creado con exito.<br />
                                             <p><a class='btn btn-success margin-top' href='../index.php' >Ingrese</a></p>
                                          </div>";
                                } else {
                                    $error = 7;
                                    $db->closeConnexion();
                                }
                            }
                        } else 
                            $error = 123;
                        if ($error != 0)
                            despliegaError($error);
                    }

                    /**
                     * funcion q verifica los errores en la forma
                     * @param type $usuario   nombre de usuario de post
                     * @param type $password  primera contraseña
                     * @param type $passwrod2 segunda contraseña
                     * @param type $existe    resultado del query del nombre de usuario
                     * @return int regresa 0 si esta bien, un numero si hay error
                     */
                    function verifica($usuario, $password, $passwrod2, $existe) {
                        $user_regex = '/^[a-zA-Z0-9ñÑ]{6,10}$/';
                        $usuarioLength = strlen(utf8_decode($usuario));
                        //verfica q ningun campo este vacio
                        if (isEmpty($usuario) || isEmpty($password) || isEmpty($passwrod2))
                            return 1;
                        //verifica q ambos password sean iguales
                        if ($password != $passwrod2)
                            return 2;
                        //verifica q usuario solo sean letras y numeros
                        if (!preg_match($user_regex, $usuario))
                            return 3;
                        //vericia q la clave tenga los caracteres necesario
                        if (strlen($password) < 8 || strlen($password) > 60)
                            return 4;
                        if ($existe == 1)
                            return 5;
                        if ($usuarioLength < 6 || $usuarioLength > 10)
                            return 6;
                        return 0;
                    }

                    function despliegaError($error) {
                        echo '<div class="alert alert-error text-center">
                                 <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <h4>¡Error!</h4>';
                        switch ($error) {
                            case 1 : echo "Uno o varios campos estan vacios</div>";
                                break;
                            case 2 : echo "Las contrase&ntilde;as son diferentes</div>";
                                break;
                            case 3 : echo "El usuario es invalido</div>";
                                break;
                            case 4 : echo "La contraseña es muy corta o muy larga</div>";
                                break;
                            case 5 : echo "El usuario ya existe</div>";
                                break;
                            case 6 : echo "El usuario es demasiado corto o largo</div>";
                                break;
                            case 7 : echo "Hubo un error porfavor intentelo de nuevo</div>";
                                break;
                            default : echo "Los campos deben estar bien llenados</div>";
                                break;
                        }
                    }
                    ?>

                    <form method="post" id="login-form" class="form-horizontal"  action='<?php echo $_SERVER['PHP_SELF']; ?>' >
                        <fieldset>

                            <legend>Creaci&oacute;n de usuario</legend>

                            <ul>
                                <li>Debe contener solo letras y numeros</li>
                                <li>Minimo 6 caracteres y maximo 10</li>
                                <li>Sin acentos ni caracteres especiales (#$%&)</li>
                            </ul> 

                            <div class="control-group">
                                <label class="control-label" for="nuevo_usuario">Usuario</label>
                                <div class="controls">
                                    <input type="text" name="nuevo_usuario" id="nuevo_usuario" placeholder="miusuario" maxlength="10" required>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Creaci&oacute;n de contrase&ntilde;a</legend>
                            <ul>
                                <li>Debe contener minimo 8 caracteres</li>
                                <li>Use una frase o palabra facil de recordar</li>
                            </ul>

                            <div class="control-group">
                                <label class="control-label" for="clave">Contrase&ntilde;a</label>
                                <div class="controls">
                                    <input type="password" name="clave" id="clave" placeholder="mi frase favorita" maxlength="60" required>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="clave2">Repita su Contrase&ntilde;a</label>
                                <div class="controls">
                                    <input type="password" name="clave2" id="clave2" placeholder="mi frase favorita" maxlength="60" required>
                                </div>
                            </div>
                            <div class="form-actions text-center">
                                <button type="submit" class="btn dif" name="registrar" value="registrar">Registrar</button>
                            </div>

                        </fieldset>
                    </form>

                </div>
                <div class="span2">&nbsp;</div>

            </div>
        </div> <!-- /contenedor -->
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