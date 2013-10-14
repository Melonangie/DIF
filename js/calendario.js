/* 
 * Scrip que despliega el calendario con las fechas de la base de datos
 */

// Se declaran los arrays globalmente
var casilleno = [];
var lleno = [];
//Hace un request json para trar los dias de la base de datos
traeDias();

$(document).ready(function() {

    //  añade el efecto al iniciar la pagina
    $('body').hide().delay(300).fadeIn(800);
    
    //valida la forma
    $('#cita').validate(
            {
                rules: {
                    alternate: {
                        required: true
                    },
                    alternate2: {
                        date: true,
                        required: true
                    },
                    calendario: {
                        date: true,
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
            
            
}); // end document.ready

$(function() {

    //Despliega el calendario
    $('#calendario').datepicker({
        inline: true,
        showOtherMonths: true,
        showOn: "button",
        dateFormat: 'yy-mm-dd',
        altField: "#alternate",
        altFormat: "DD, d MM, yy",
        minDate: +1,
        onSelect: otroAlternate,
        onChangeMonthYear: traeDias,
        beforeShowDay: colorDias
    });

    $('.ui-datepicker-current-day').removeClass('ui-datepicker-current-day');

    $('#alternate').val('');
});

//trae las fechas de la base de datos
function traeDias() {

    // llenamos el array lleno con las fechas
    $.ajax({
        async: false,
        type: "POST",
        url: "ajax_fechas_lleno.php",
        dataType: "json",
        success: function(data) {
            lleno = data;
        }
    });

    // llenamos el array casilleno con las fechas
    $.ajax({
        async: false,
        type: "POST",
        url: "ajax_fechas_casi.php",
        dataType: "json",
        success: function(data) {
            casilleno = data;
        }
    });
}

//Colorea los dias
function colorDias(date) {

    m = date.getMonth(), d = date.getDate(), y = date.getFullYear();

    //DEsactiva  domingos
    if (date.getDay() === 0) {
        return [false, '', 'Indisponible'];
    }

    //Ilumina dias casi llenos
    for (i = 0; i < casilleno.length; i++) {
        if ($.inArray(y + '-' + (m + 1) + '-' + d, casilleno) !== -1) {
            return [true, 'ui-datepicker-days-cell orange', 'Casi lleno'];
        }
    }

    //Ilumina y desactiva dias llenos
    for (i = 0; i < lleno.length; i++) {
        if ($.inArray(y + '-' + (m + 1) + '-' + d, lleno) !== -1) {
            return [false, 'ui-datepicker-days-cell red', 'Lleno'];
        }
    }

    //regresa un dia normal
    return [true, '', 'Con cupo'];
}

function otroAlternate(date) {
    var date = $(this).datepicker('getDate');
    $('#alternate2').val(date ? $.datepicker.formatDate('yy-mm-dd', date) : '');
}