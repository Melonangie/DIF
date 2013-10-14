/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/* FADE OVER ELEMENTS ------------- */
/* Remove this if you don't need OR cutomize */
$(document).ready(function() {
    $('body').hide().delay(300).fadeIn(800);
});

$(document).ready(function() {
    $('#contact-form').validate(
            {
                rules: {
                    usuario: {
                        minlength: 6,
                        maxlength: 10,
                        required: true
                    },
                    password: {
                        maxlength: 60,
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