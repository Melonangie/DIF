/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    
    //animacion de la hoja
    $('body').hide().delay(400).fadeIn(1000);
    //        $('#hoy').append(now);
    //muestra la tabla 
    $('#addressesTable').dataTable({
        "bJQueryUI": true,
        "iDisplayLength": 42,
        "bPaginate": true,
        "sPaginationType": "full_numbers"
//        "sAjaxSource": "ajax_apellido_el.php"
    });

    $('.editable').editable('ajax_cerrar_curso.php', {
        data: " {'no':'No','si':'Si'}",
        type: 'select',
        tooltip: 'Presione para editar',
        indicator: "<img src='../img/indicator.gif'>",
//        event: "mouseover",
//        onblur: "submit",
        submit: 'OK',
        style: 'inline',
        submitdata: function(value, settings) {
            return {placeholder: "bar"};
        }

    });

}); // end document.ready