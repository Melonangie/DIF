<?php
/**
 * Menu
 * 
 */
session_start();
if (!isset($_SESSION['autentificado']) || $_SESSION['autentificado'] === FALSE) {
    header('Location:../index.php');
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
        <link type="text/css" href="../css/bootstrap.min.css" rel="stylesheet" />
        <link type="text/css" href="../css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link type="text/css" href="../css/custom-theme/jquery-ui-1.10.0.custom.css" rel="stylesheet" />
        <link type="text/css" href="../css/font/font-awesome.min.css" rel="stylesheet" />
        <link type="text/css" href="../css/newestilo.css" rel="stylesheet" />
        <link type="text/css" href="../css/print-user.css" rel="stylesheet" />
        <link href="img/favicon.ico" rel="shortcut icon" >
        <!--[if IE 7]>
            <link rel="stylesheet" href="../css/font/font-awesome-ie7.min.css" type="text/css"  />
        <![endif]-->
        <!--[if lt IE 9]>
            <script src="../js/libs/html5shiv-3.6.1/html5shiv.js"></script>
            <link rel="stylesheet" href="../css/custom-theme/jquery.ui.1.10.0.ie.css"/>
        <![endif
                
        <!-- Le javascript
       ================================================== -->
        <script src="../js/libs/jquery-1.9.0/jquery.min.js" type="text/javascript"></script>
        <script src="../js/libs/bootstrap.min.js" type="text/javascript"></script>
        <script src="../js/libs/jqueryui-1.10.0/jquery-ui.js" type="text/javascript"></script>
    </head>

    <body>
        <!-- Cabezera
            ================================================== -->
        <div class="container-narrow"><!-- contenedor -->
            <header class="row-fluid">
                <div class="span3">
                    <img src="../img//anillo.jpg" class="img-rounded">
                </div>
                <div class="span8">
                    <h1>Pl&aacute;ticas Prematrimoniales DIF - Tijuana </h1>
                </div>
            </header>
            <hr class="headerhr">

            <!-- Contenido
            ================================================== -->

            <section class="row-fluid">
                <button class="btn no-print" OnClick="window - print()" > <i class="icon-print"></i> Imprimir </button>
                <div class="titulo centrar">Despedida</div>
                <div class="clearfix"></div>

                <div class="span8 offset2 margin-top">
                    <p>Gracias por inscribirse en las Platicas Prematimoniales. Si ingresaron una
                        direccion de correo pronto recibiran un correo con un resumen de los detalles 
                        acerca de su inscripcion.</p>

                    <div class="margin-top well well-large">
                        <p class="text-center" >
                            Su numero de inscripcion es: <strong> <?php echo $_SESSION['folio_id']; ?></strong>
                        </p>
                        <p class="text-center" >
                            Su numero de recibo es: <strong> <?php echo $_SESSION['recibo']; ?></strong>
                        </p>
                        <p class="text-center" >
                            Su fecha de platica es: <strong> <?php echo $_SESSION['disponible_id']; ?></strong>
                        </p>
                    </div>
                    <div class="margin-top">&nbsp;</div>
                    <ul>
                        <li>Tienen que venir los dos.</li>
                        <li>No se admiten ni&ntilde;os, familiares ni invitados de ningun tipo.</li>
                        <li>Triga cada uno una identificaci&oacute;n oficial, para finalizar el proceso de inscripcion.</li>
                        <li>Las platicas empizan puntualmente a las 9:00 AM y terminan a la 1:00 PM</li>
                        <li>Llegue con 15 minutos de anticipaci&oacute;n.</li>
                        <li>Las parejas que lleguen despues de las 9:00 AM no se les permitira el acceso a las platicas.</li>
                        <li>No se otorgaran reconocimientos a las parejas q no esten presentes las 4 horas que dura la platica.</li>
                    </ul>

                    <div class="margin-top">&nbsp;</div>
                    <p class="text-center" >
                        <strong>¡ Los Esperamos !</strong>
                    </p>

                    <div class="margin-top">&nbsp;</div>
                    <p class="text-center" >
                        <a class="btn admin dif center no-print" href="logout.php">Salir</a>
                    </p>

                </div>
                <div class="span2">&nbsp;</div>
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
