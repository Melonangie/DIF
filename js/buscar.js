/* 
 * Script que valida la forma de datos ingresar
 */

    $('body').hide().delay(400).fadeIn(1000);
$(document).ready(function() {

    //añade un metodo q solo valida al menos una letra
    $.validator.addMethod("unaletrasRegex", function(value, element) {
        return this.optional(element) || /[a-z'-]+$/i.test(value);
    }, "Use algunas letras");

    // Validate
    // http://bassistance.de/jquery-plugins/jquery-plugin-validation/
    // http://docs.jquery.com/Plugins/Validation/
    // http://docs.jquery.com/Plugins/Validation/validate#toptions

    $('#buscar').validate({
        rules: {
            el_paterno: {
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
            ella_paterno: {
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
            folio: {
                minlength: 1,
                maxlength: 7,
                digits: true,
                required: true
            },
            recibo: {
                minlength: 7,
                maxlength: 7,
                digits: true,
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

    //autocompleta el apeelido de EL
    $("#el_paterno").autocomplete({
        source: "ajax_apellido_el.php?term=",
        minLength: 2,
        autoFocus: true,
        focus: function(event, ui) {
            $("#el_paterno").val(ui.item.value);
        },
        select: function(event, ui) {
            $("#el_id").val(ui.item.el_id);
            $("#el_nombre").val(ui.item.el_nombre);
        }
    })
            .data("ui-autocomplete")._renderItem = function(ul, item) {
        return $("<li>")
                .append("<a>" + item.el_paterno + " " + item.el_materno + ", " + item.el_nombre + "</a>")
                .appendTo(ul);
    };

  //autocompleta el apeelido de EL
    $("#ella_paterno").autocomplete({
        source: "ajax_apellido_ella.php?term=",
        minLength: 2,
        autoFocus: true,
        focus: function(event, ui) {
            $("#ella_paterno").val(ui.item.value);
        },
        select: function(event, ui) {
            $("#ella_id").val(ui.item.ella_id);
            $("#ella_nombre").val(ui.item.ella_nombre);
        }
    })
            .data("ui-autocomplete")._renderItem = function(ul, item) {
        return $("<li>")
                .append("<a>" + item.ella_paterno + " " + item.ella_materno + ", " + item.ella_nombre + "</a>")
                .appendTo(ul);
    };
    
    //Da efecto a la pagina
    $('#recibo,#folio').attr('disabled', 'disabled');
    //Desahabilita campos cuando se presiona el checkbox de la misma direccion
    $("#toggleElement3").click(toggleStatus).removeAttr('disabled');
    $("#toggleElement2").click(toggleStatus2).removeAttr('disabled');


}); // end document.ready

//Desahabilita campos cuando se presiona el checkbox de la misma direccion
function toggleStatus() {
    if ($('#toggleElement3').is(':checked')) {
        $('#toggleElement2').prop('checked', false);
        $('.grupo').attr('disabled', true);
        $('.grupo2').attr('disabled', true);
        $('.grupo3').removeAttr('disabled');
    } else {
        $('.grupo').removeAttr('disabled');
        $('.grupo3').attr('disabled', true);
    }
}

//Desahabilita campos cuando se presiona el checkbox de la misma direccion
function toggleStatus2() {
    if ($('#toggleElement2').is(':checked')) {
        $('#toggleElement3').prop('checked', false);
        $('.grupo').attr('disabled', true);
        $('.grupo3').attr('disabled', true);
        $('.grupo2').removeAttr('disabled');
    } else {
        $('.grupo').removeAttr('disabled');
        $('.grupo2').attr('disabled', true);
    }
}