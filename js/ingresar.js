/* 
 * Script que valida la forma de datos ingresar
 */
$(document).ready(function() {

    //añade un metodo q solo valida letras, numeros
    $.validator.addMethod("alphaRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9]+$/i.test(value);
    }, "Solo use letras y numeros");

    //añade un metodo q solo valida letras, numeros y diagonales
    $.validator.addMethod("interiorRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\/]+$/i.test(value);
    }, "Solo use letras y numeros");

    //añade un metodo q solo valida letras y espacios
    $.validator.addMethod("letrasRegex", function(value, element) {
        return this.optional(element) || /^[a-z ]+$/i.test(value);
    }, "Solo use letras");

    //añade un metodo q solo valida al menos una letra
    $.validator.addMethod("unaletrasRegex", function(value, element) {
        return this.optional(element) || /[a-z'-]+$/i.test(value);
    }, "Use algunas letras");


    // Validate
    // http://bassistance.de/jquery-plugins/jquery-plugin-validation/
    // http://docs.jquery.com/Plugins/Validation/
    // http://docs.jquery.com/Plugins/Validation/validate#toptions

    $('#forma-ingresar').validate({
        rules: {
            recibo: {
                minlength: 7,
                maxlength: 7,
                digits: true,
                required: true
            },
            el_paterno: {
                minlength: 2,
                maxlength: 25,
                unaletrasRegex: true,
                required: true
            },
            el_materno: {
                minlength: 2,
                maxlength: 25,
                unaletrasRegex: true,
                required: true
            },
            el_nombre: {
                minlength: 2,
                maxlength: 25,
                unaletrasRegex: true,
                required: true
            },
            el_fecha: {
                date: true,
                required: true
            },
            el_pais: {
                minlength: 1,
                maxlength: 52,
                required: true
            },
            el_estado: {
                minlength: 1,
                maxlength: 20,
                required: true
            },
            el_ciudad: {
                minlength: 1,
                maxlength: 35,
                required: true
            },
            el_curp: {
                minlength: 18,
                maxlength: 18,
                alphaRegex: true,
                required: true
            },
            el_colonia: {
                minlength: 1,
                maxlength: 45,
                unaletrasRegex: true,
                required: true
            },
            el_calle: {
                minlength: 1,
                maxlength: 45,
                unaletrasRegex: true,
                required: true
            },
            el_numero: {
                minlength: 1,
                maxlength: 8,
                interiorRegex: true,
                required: true
            },
            el_interior: {
                minlength: 1,
                maxlength: 8,
                interiorRegex: true,
                required: true
            },
            el_telefono: {
                minlength: 7,
                maxlength: 15,
                digits: true,
                required: true
            },
            el_movil: {
                minlength: 7,
                maxlength: 25,
                digits: true,
                required: true
            },
            el_email: {
                email: true,
                required: true
            },
            el_ocupacion: {
                minlength: 1,
                maxlength: 15,
                letrasRegex: true,
                required: true
            },
            el_civil: {
                minlength: 1,
                maxlength: 15,
                letrasRegex: true,
                required: true
            },
            el_escolaridad: {
                minlength: 1,
                maxlength: 15,
                letrasRegex: true,
                required: true
            },
            hijos: {
                minlength: 1,
                maxlength: 2,
                digits: true,
                required: true
            },
            ella_paterno: {
                minlength: 2,
                maxlength: 25,
                unaletrasRegex: true,
                required: true
            },
            ella_materno: {
                minlength: 2,
                maxlength: 25,
                unaletrasRegex: true,
                required: true
            },
            ella_nombre: {
                minlength: 2,
                maxlength: 25,
                unaletrasRegex: true,
                required: true
            },
            ella_fecha: {
                date: true,
                required: true
            },
            ella_pais: {
                minlength: 1,
                maxlength: 52,
                required: true
            },
            ella_estado: {
                minlength: 1,
                maxlength: 20,
                required: true
            },
            ella_ciudad: {
                minlength: 1,
                maxlength: 35,
                required: true
            },
            ella_curp: {
                minlength: 18,
                maxlength: 18,
                alphaRegex: true,
                required: true
            },
            ella_colonia: {
                minlength: 1,
                maxlength: 45,
                required: true
            },
            ella_calle: {
                minlength: 1,
                maxlength: 45,
                required: true
            },
            ella_numero: {
                minlength: 1,
                maxlength: 8,
                interiorRegex: true,
                required: true
            },
            ella_interior: {
                minlength: 1,
                maxlength: 8,
                interiorRegex: true,
                required: true
            },
            ella_telefono: {
                minlength: 7,
                maxlength: 15,
                digits: true,
                required: true
            },
            ella_movil: {
                minlength: 7,
                maxlength: 25,
                digits: true,
                required: true
            },
            ella_email: {
                email: true,
                required: true
            },
            ella_ocupacion: {
                minlength: 1,
                maxlength: 15,
                letrasRegex: true,
                required: true
            },
            ella_civil: {
                minlength: 1,
                maxlength: 15,
                letrasRegex: true,
                required: true
            },
            ella_escolaridad: {
                minlength: 1,
                maxlength: 15,
                letrasRegex: true,
                required: true
            },
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element
                    .text('OK!').addClass('valid')
                    .closest('.control-group').removeClass('error').addClass('success');
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

}); // end document.ready

$(document).ready(function() {

    //Da efecto a la pagina
    $('body').hide().delay(400).fadeIn(1000);

    //muestra calendarios
    var ef_nacimientoOpts =
            {
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: '1920:1995',
                defaultDate: new Date(1985, 00, 01),
                showButtonPanel: false,
                showAnim: 'show'
            };
    $("#el_fecha").datepicker(ef_nacimientoOpts);

    var f_nacimientoOpts =
            {
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: '1920:1995',
                defaultDate: new Date(1985, 00, 01),
                showButtonPanel: false,
                showAnim: 'show'
            };
    $("#ella_fecha").datepicker(f_nacimientoOpts);

    //Desahabilita campos cuando se presiona el checkbox de la misma direccion
    enable_cb();
    $("#toggleElement").click(toggleStatus);

    //modal en caso q el usuario este ya usado
    $('#myModal').modal({
        backdrop: true,
        static : true,
        keyboard: false
    });
    
}); // end document.ready


//Desahabilita campos cuando se presiona el checkbox de la misma direccion
function toggleStatus() {
    if ($('#toggleElement').is(':checked')) {
        $('.grupo').attr('disabled', true);
    } else {
        $('.grupo').removeAttr('disabled');
    }
}

//DESPLIEGA LOS ESTADOS
function countryChange(selectObj) {
    var id = selectObj;
    var dataString = 'id=' + id;
    $.ajax
            ({
                type: "POST",
                url: "ajax_state.php",
                data: dataString,
                cache: false,
                success: function(html)
                {
                    $("#el_estado").html(html);
                }
            });
}
function countryChange2(selectObj) {
    var id = selectObj;
    var dataString = 'id=' + id;
    $.ajax
            ({
                type: "POST",
                url: "ajax_state.php",
                data: dataString,
                cache: false,
                success: function(html)
                {
                    $("#ella_estado").html(html);
                }
            });
}

//DESPLIEGA LAS CIUDADES
function stateChange(selectObj) {
    var id = selectObj;
    var dataString = 'id=' + id;
    $.ajax
            ({
                type: "POST",
                url: "ajax_city.php",
                data: dataString,
                cache: false,
                success: function(html)
                {
                    $("#el_ciudad").html(html);
                }
            });
}
function stateChange2(selectObj) {
    var id = selectObj;
    var dataString = 'id=' + id;
    $.ajax
            ({
                type: "POST",
                url: "ajax_city.php",
                data: dataString,
                cache: false,
                success: function(html)
                {
                    $("#ella_ciudad").html(html);
                }
            });
}
