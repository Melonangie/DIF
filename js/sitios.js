/* 
 * Script que valida la forma de datos ingresar
 */
$(document).ready(function() {

    $('.grupo').attr('disabled', 'disabled');

    //añade un metodo q solo valida letras, numeros y diagonales
    $.validator.addMethod("interiorRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\/]+$/i.test(value);
    }, "Solo use letras y numeros");

    //añade un metodo q solo valida al menos una letra
    $.validator.addMethod("unaletrasRegex", function(value, element) {
        return this.optional(element) || /[a-z'-]+$/i.test(value);
    }, "Use algunas letras");


    // Validate
    // http://bassistance.de/jquery-plugins/jquery-plugin-validation/
    // http://docs.jquery.com/Plugins/Validation/
    // http://docs.jquery.com/Plugins/Validation/validate#toptions

$(".validar").each(function() {
    $(this).validate({
        rules: {
            lugar: {
                minlength: 2,
                maxlength: 45,
                required: true
            },
            capacidad: {
                minlength: 1,
                maxlength: 2,
                digits: true,
                required: true
            },
            colonia: {
                maxlength: 48,
                required: true
            },
            calle: {
                minlength: 2,
                maxlength: 45,
                required: true
            },
            numero: {
                minlength: 1,
                maxlength: 4,
                interiorRegex: true,
                required: true
            }
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
});
}); // end document.ready

$(document).ready(function() {

    //Da efecto a la pagina
    $('body').hide().delay(400).fadeIn(1000);

    //Desahabilita campos cuando se presiona el checkbox de la misma direccion
    enable_cb();
    $("#toggleElement").click(toggleStatus);
}); // end document.ready

//Desahabilita campos cuando se presiona el checkbox de la misma direccion
function toggleStatus() {
    if ($('#toggleElement').is(':checked')) {
        $('.grupo').removeAttr('disabled');
    } else {
        $('.grupo').attr('disabled', true);
    }
}