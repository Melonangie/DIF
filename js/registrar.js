/* 
 * Valida la forma de inscripcion
 */

$(document).ready(function() {
    
    //  añade el efecto al iniciar la pagina
    $('body').hide().delay(300).fadeIn(800);
    
    //añade un metodo q solo valida letras, numeros y ñ
    $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9ñÑ]+$/i.test(value);
    }, "Solo use letras y numeros");

    //valida la forma
    $('#login-form').validate(
            {
                rules: {
                    nuevo_usuario: {
                        minlength: 6,
                        maxlength: 10,
                        loginRegex: true,
                        required: true
                    },
                    clave: {
                        minlength: 8,
                        maxlength: 60,
                        required: true
                    },
                    clave2: {
                        equalTo: "#clave"
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