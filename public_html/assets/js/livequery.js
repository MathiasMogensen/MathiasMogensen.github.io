// PARAMETERS:
// form = the form to check for submit
// load = the html element refresh after query. Set to false to use same value as form
// url = the php file with query
// the message displayed in alert box after query

livequery = function(form, load, url) {
    $(function () {

        if(load == false) {  
            load = form;
        }
        form.preventDefault();
        $.ajax({
            type: 'post',
            url: url,
            data: $(form).serialize(),
            success: function (res) {
                var message = jQuery.parseJSON(res);
                var status = message.status;
                var msg = message.output;
                $(load).load(location.href+" "+ load +">*","");
                if ($('.alert-box')) {
                    $('.alert-box').remove();
                }
                if (status == "success") {
                    $("body").append("<div class='alert-box alert-success'><i class='material-icons'>check</i><p>"+ msg +"</p></div>");
                }
                else if (status == "error") {
                    $("body").append("<div class='alert-box alert-error'><i class='material-icons'>error</i><p>"+ msg +"</p></div>");
                }
                setTimeout( function() {
                    $('.alert-box').addClass('alert-close');
                        setTimeout( function() {
                        $('.alert-box').remove();
                    }   , 1000);
                }, 5000);
            }
        });
    });
};
// Remove alert after 5 seconds
$(document).ready(function() {
    if ($('.alert-box').length) {
        setTimeout( function() {
            $('.alert-box').addClass('alert-close');
            setTimeout( function() {
                $('.alert-box').remove();
        }   , 2000);
        }, 3000);
    }
});