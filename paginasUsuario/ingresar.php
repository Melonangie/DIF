<?php
/**
 * Menu
 * 
 */
session_start();
if (!isset($_SESSION['autentificado']) || $_SESSION['autentificado'] === FALSE) {
    header('Location:../index.php');
}
//Archivo que carga paises, estados y ciudades
include '../basededatos/ingresar.sql.php';
//abre una conexion a la base de datos
$db = new BD();
$userId = getSession('usuario_id', $db);
//llena el select de pais con informacion
$paises = opcionesPaises($db);
//llena el select de colonia con informacion
$colonia = opcionesColonias($db);
////llena el select de ocupacion con informacion
$ocpacion = opcionesOcupacion($db);
////llena el select de estado civil con informacion
$civil = opcionesCivil($db);
////llena el select de escolaridad con informacion
$educacion = opcionesEducacion($db);
//verifica q el usuario no tenga una pareja registrada
if (getSession('usuario_nivel', $db) == "usuario" && getSession('folio', $db) == TRUE) {
    $errorInfo = nombres($userId, $db);
}
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
        <script src="../js/ingresar.js" type="text/javascript"></script>
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
            <div class="row-fluid ">
                <?php
                //verifica q el nombre de usuario no haya registrado una pareja
                if (isset($errorInfo)) {
                    echo "
                    <div class='modal-backdrop fade in'></div>
                    <div id='myModal' class='modal' tabindex='-1' role='dialog'>
                        <div class='modal-header text-center'>
                            <h3 id='myModalLabel'><i class='icon-exclamation-sign'></i>  Aviso</h3>
                        </div>
                        <div class='modal-body text-center'>
                            <p>Su usuario <strong>" . $errorInfo['usuario_nombre'] . "</strong> ya ha sido usado para registrar los datos de la <br /> 
                                <strong>Pareja No. " . $errorInfo['folio_id'] . " <br /> 
                                " . $errorInfo['el_nombre'] . " " . $errorInfo['el_paterno'] . " 
                                y " . $errorInfo['ella_nombre'] . " " . $errorInfo['ella_paterno'] . " </strong></p>
                            <p>&nbsp;</p>
                            <p>Porfavor cree un nuevo usuario para registrara otra pareja. </p>
                            <p>O modifique su informacion</p>
                        </div>
                        <div class='modal-footer text-center'>
                            <p>
                                <a class='btn dif' href='registrar.php' >Registrar Nuevo Usuario</a>
                                <a class='btn btn-primary' href='modificar.php' >Modificar Informacion</a>
                            </p>
                        </div>
                    </div>";
                }

                //Comienza la validacion del registro
                if (isset($_POST['ingresar']) && $_POST['ingresar'] == 'ingresar') {
                    if (isset($_POST['recibo'], $_POST['el_paterno'], $_POST['el_materno'], $_POST['el_nombre'], $_POST['el_fecha'], $_POST['el_pais'], $_POST['el_estado'], $_POST['el_curp'], $_POST['el_colonia'], $_POST['el_calle'], $_POST['el_numero'], $_POST['el_interior'], $_POST['el_telefono'], $_POST['el_movil'], $_POST['el_email'], $_POST['el_ocupacion'], $_POST['el_escolaridad'], $_POST['el_civil'], $_POST['hijos'], $_POST['ella_paterno'], $_POST['ella_materno'], $_POST['ella_nombre'], $_POST['ella_fecha'], $_POST['ella_pais'], $_POST['ella_estado'], $_POST['ella_curp'], $_POST['ella_telefono'], $_POST['ella_movil'], $_POST['ella_email'], $_POST['ella_ocupacion'], $_POST['ella_escolaridad'], $_POST['ella_civil'])) {

                        //abre la conexion con la base de datos
                        $db = new BD();

                        //limpia el array Post y lo pone en el array $datos
                        $datos = getArray($_POST, $db);

                        //verifica q la pareja no este registrada 
                        $elId = traeInfo('el_id', 'el', 'el_curp', $datos['el_curp'], $db);
                        $ellaId = traeInfo('ella_id', 'ella', 'ella_curp', $datos['ella_curp'], $db);
                        $parejaId = parejaId($elId, $ellaId, $db);
                        $parejaInfo = traerTodo('folio', 'folio_id', $parejaId, $db);
                        $parejaUsuario = traeInfo('usuario_nombre', 'usuarios', 'usuario_id', $parejaInfo['usuario_id'], $db);

                        //verifica errores en los valores de los campos
                        $error = verifica($datos, $parejaId);

                        //Si no se encontro errorres en la forma
                        if ($error == 0) {

                            //trae el codigo postal y modifica el array de datos
                            $datos['el_cp'] = traeInfo('cp', 'colonia', 'colonia', $datos['el_colonia'], $db);
                            if (isset($datos['mismadir'])) {
                                $datos = copiaDatos($datos);
                            } else {
                                $datos['ella_cp'] = traeInfo('cp', 'colonia', 'colonia', $datos['ella_colonia'], $db);
                            }
                            arreglaDatos($datos);
                            $userId = getSession('usuario_id', $db);
                            //hace el registro de usuarios
                            $registro = registrar($datos, $userId, $db);

                            //hace el registro en folio
                            if ($registro !== false) {
                                //$registro = registrarFolio($registros, $datos, $userId, $db);
                                $db->closeConnexion();

                                $_SESSION['folio_id'] = $registro;
                                $_SESSION['recibo'] = $datos['recibo'];

                                //Despliega mensaje 
                                echo "<div class='alert alert-success text-center'>
                                             <h4>¡Bien!</h4> <br />
                                             La pareja se ha agregado exitosamente con el <br />
                                             <strong> Numero de Folio " . $registro . "</strong><br />
                                             <button class='btn btn-success margin-top' onClick=\"window.location = 'calendario.php'\">Siguiente</button> 
                                          </div>";
                            }
                            else
                                $error = 6; //hubo un error
                        }
                        else
                            $db->closeConnexion();
                    }
                    else
                        $error = 7;

                    //despliega errores 
                    if ($error != 0) {
                        if ($error == 4) {
                            echo "<div class='alert alert-error text-center'>
                                <h4>¡Error!</h4>
                                La pareja ya esta registrada. <br />
                                Son la pareja con el <strong> Numero de Folio " . $parejaId . ".</strong><br />
                                Registrada el dia <strong>" . date($parejaInfo['folio_fecha']) . "</strong>
                                    con el usuario <strong>" . $parejaUsuario . "</strong>
                                </div>";
                        }
                        else
                            despliegaError($error);
                    }
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
                        case 3 : echo "El correo electronico es invalido.</div>";
                            break;
                        case 5 : echo "Algunos campos no contienen letras.</div>";
                            break;
                        case 6 : echo "Hubo un error, porfavor intentelo de nuevo.</div>";
                            break;
                        default : echo "Los campos deben estar bien llenados.</div>";
                            break;
                    }
                }

                function verifica($datos, $parejaId) {
                    //array para verificar campos numericos y alphanumericos requeridos
                    $numericos = array('recibo', 'el_telefono', 'hijos', 'ella_telefono');
                    $alpha = array('el_paterno', 'ella_paterno', 'el_materno', 'ella_materno', 'el_nombre', 'ella_nombre');
                    //verfica q ningun campo este vacio
                    if (isArrayEmpty($datos))
                        return 1;
                    //verifica q los campos numericos sean nuemricos
                    if (!onlyNumbers($datos, $numericos))
                        return 2;
                    //verifica q los correo sean validos
                    if (!validaTipo($datos['el_email'], 'email') || !validaTipo($datos['ella_email'], 'email'))
                        return 3;
                    //verifica q si la pareja ya esta registrada
                    if ($parejaId != 0)
                        return 4;
                    //verifica q los campos $alpha contengan letras
                    if (!someLetters($datos, $alpha))
                        return 5;
                    //sin error
                    return 0;
                }

                function copiaDatos($datos) {
                    $col = $datos['el_colonia'];
                    $call = $datos['el_calle'];
                    $num = $datos['el_numero'];
                    $int = $datos['el_interior'];
                    $cp = $datos['el_cp'];
                    $temp = array("ella_colonia" => $col, "ella_calle" => $call, "ella_numero" => $num, "ella_interior" => $int, "ella_cp" => $cp);
                    return array_merge($datos, $temp);
                }

                function arreglaDatos($datos) {
                    if ($datos['el_estado'] == "--Selecciona el estado--")
                        $datos['el_estado'] = $datos['el_pais'];
                    if ($datos['el_ciudad'] === '--Selecciona la ciudad--')
                        $datos['el_ciudad'] = $datos['el_estado'];
                    if ($datos['ella_estado'] == "--Selecciona el estado--")
                        $datos['ella_estado'] = $datos['ella_pais'];
                    if ($datos['ella_ciudad'] === '--Selecciona la ciudad--')
                        $datos['ella_ciudad'] = $datos['ella_estado'];
                }
                ?>

                <div class="titulo centrar">Ingrese sus datos</div>
                <div class="clearfix"></div>

                <form id="forma-ingresar" class="form-horizontal" action='<?php echo $_SERVER['PHP_SELF']; ?>' method="post">

                    <!-- Recibo
                   ================================================== -->
                    <fieldset class="relleno">
                        <div class="control-group">
                            <label class="control-label" for="recibo">Recibo de Tesoreria&nbsp;&nbsp;</label>
                            <div class="controls">
                                <input type="number" name="recibo" id="recibo" maxlength=7>
                            </div>
                        </div>
                    </fieldset>

                    <div class="visible-tablet visible-desktop">
                        <div class="span3">&nbsp;</div>
                        <div class="span4"><h3>El</h3></div>
                        <div class="span4"><h3>Ella </h3></div>
                        <div class="clearfix"></div>
                    </div>

                    <!-- Personal
                    ================================================== -->
                    <fieldset>
                        <legend>Informaci&oacute;n Personal</legend>

                        <label class="control-label span3">Apellidos paternos</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="text" name="el_paterno" id="el_paterno" autocomplete="on" maxlength="25">
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="text"  name="ella_paterno" id="ella_paterno" autocomplete="on" maxlength="25">
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span3">Apellido materno</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="text" name="el_materno" id="el_materno" autocomplete="on" maxlength="25" >
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="text"  name="ella_materno" id="ella_materno" autocomplete="on" maxlength="25" >
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span3">Nombre</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="text" name="el_nombre" id="el_nombre" autocomplete="on" maxlength="25" >
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="text"  name="ella_nombre" id="ella_nombre" autocomplete="on" maxlength="25" >
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span3">Fecha de nacimiento</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="date" name="el_fecha" id="el_fecha" >
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="date"  name="ella_fecha" id="ella_fecha" >
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span3">Pais de nacimiento</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <select name="el_pais" onchange="countryChange(this.value);">
                                    <?php
                                    echo '<option value="0">--Selecciona el pais--</option>';
                                    echo $paises;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <select name="ella_pais" onchange="countryChange2(this.value);">
                                    <?php
                                    echo '<option value="0">--Selecciona el pais--</option>';
                                    echo $paises;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span3">Estado de nacimiento</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <select name="el_estado" id="el_estado" onchange="stateChange(this.value);">
                                    <option selected>--Selecciona el estado--</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <select name="ella_estado" id="ella_estado" onchange="stateChange2(this.value);">
                                    <option selected>--Selecciona el estado--</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span3">Ciudad de nacimiento</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <select name="el_ciudad" id="el_ciudad">
                                    <option selected>--Selecciona la ciudad--</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <select name="ella_ciudad" id="ella_ciudad">
                                    <option selected>--Selecciona la ciudad--</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span3">CURP</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="text" name="el_curp" maxlength="18" />
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="text" name="ella_curp" maxlength="18" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </fieldset>

                    <!-- Direccion
                    ================================================== -->
                    <fieldset>
                        <legend>Direcci&oacute;n</legend>

                        <p>
                            <small>Marque el cuadro si es la misma direccion para los dos   </small>
                            <input class="inline"  type="checkbox" id="toggleElement" onchange="toggleStatus()" value="si" name="mismadir">
                        </p>

                        <label class="control-label span3">Colonia</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <select name="el_colonia" id="el_colonia">
                                    <?php echo $colonia; ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <select name="ella_colonia" id="ella_colonia" class="grupo">
                                    <?php echo $colonia; ?>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span3">Calle</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="text" name="el_calle" id="el_calle">
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="text"  name="ella_calle" id="ella_calle" class="grupo">
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span3">Numero</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="text" name="el_numero" id="el_numero" maxlength="8">
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="text"  name="ella_numero" id="ella_numero" maxlength="8" class="grupo">
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span3">Interior</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="text" name="el_interior" id="el_interior" maxlength="8">
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="text"  name="ella_interior" id="ella_interior" maxlength="8" class="grupo">
                            </div>
                        </div>
                        <div class="clearfix"></div>

                    </fieldset>

                    <!-- Info de Contacto
                    ================================================== -->
                    <fieldset>
                        <legend>Informaci&oacute;n de Contacto</legend>

                        <label class="control-label span3">Telefono</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="tel" name="el_telefono" id="el_telefono" maxlength="15">
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="tel"  name="ella_telefono" id="ella_telefono" maxlength="15">
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span3">Movil</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="tel" name="el_movil" id="el_movil">
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="tel"  name="ella_movil" id="ella_movil">
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span3">Correo Electronico</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="text" name="el_email" id="el_email">
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <input type="text"  name="ella_email" id="ella_email">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </fieldset>

                    <!-- Informacion General
         ================================================== -->
                    <fieldset>
                        <legend>Informacion General</legend>

                        <label class="control-label span3">Ocupacion</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <select name="el_ocupacion" id="el_ocupacion">
                                    <?php
                                    echo '<option value="0">--Selecciona su ocupaci&oacute;n--</option>';
                                    echo $ocpacion;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <select name="ella_ocupacion" id="ella_ocupacion">
                                    <?php
                                    echo '<option value="0">--Selecciona su ocupaci&oacute;n--</option>';
                                    echo $ocpacion;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span3">Estado Civil</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <select name="el_civil" id="el_civil">
                                    <?php
                                    echo '<option value="0">--Selecciona su estado civil--</option>';
                                    echo $civil;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <select name="ella_civil" id="ella_civil">
                                    <?php
                                    echo '<option value="0">--Selecciona su estado civil--</option>';
                                    echo $civil;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span3">Escolaridad</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <select name="el_escolaridad" id="el_escolaridad">
                                    <?php
                                    echo '<option value="0">--Selecciona su escolaridad--</option>';
                                    echo $educacion;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group span4">
                            <div class="controls">
                                <select name="ella_escolaridad" id="ella_escolaridad">
                                    <?php
                                    echo '<option value="0">--Selecciona su escolaridad--</option>';
                                    echo $educacion;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <label class="control-label span3">Hijos en comun</label>
                        <div class="control-group span4">
                            <div class="controls">
                                <select name="hijos" id="hijos">
                                    <?php
                                    for ($index = 0; $index < 26; $index++) {
                                        echo '<option value="' . $index . '">' . $index . '</option>';
                                    }
                                    ?>
                                    <option value="+25">M&aacute;s de 25</option>
                                </select>
                            </div>
                        </div>

                    </fieldset>

                    <!-- Botones
                    ================================================== -->
                    <div class="clearfix"></div>
                    <div class="form-actions">
                        <div class="text-center">
                            <button type="submit" class="btn dif mm" value="ingresar" name="ingresar">Registrar Informacion</button>
                            <button type="reset" class="btn mm">Borrar Formulario</button>
                        </div>

                    </div>
                </form>

            </div>





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

        <!-- Modal -->
        <!--<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">-->


    </body>
</html>