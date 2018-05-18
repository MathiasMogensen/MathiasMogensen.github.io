function validateInput(input, msg, allowed) {
    if (allowed == "letters") {reMsg="Kun bogstaver fra a-Å tilladt"; re = /^[a-åA-Å ]+$/}
    if (allowed == "email") {reMsg="Ugyldig e-mail"; re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/}
    if ($(input).val() == "") {
        errorMsg(input, msg);
        return false;
    } else if (allowed != "all" && !re.test($(input).val())) {
        errorMsg(input, reMsg);
        return false;
    } else {
        if ($(input+"Alert").length) {
            $(input+"Alert").remove();
            $(input).removeClass('border-danger');
        }
        return true;
    }
}
function validatePasswords(input, input2, msg, msgAlike) {
    input1Val = $(input).val();
    input2Val = $(input2).val();
    if ($(input).val() == "") {
        errorMsg(input, msg);
        return false;
    }
    if ($(input2).val() == "") {
        errorMsg(input2, msg);
        return false;
    }
    if (input1Val !== input2Val) {
        errorMsg(input2, msgAlike);
        return false;
    } else {
        if ($(input2+"Alert").length) {
            $(input2+"Alert").remove();
            $(input2).removeClass('border-danger');
        }
        return true;
    }
}
function errorMsg(input, msg) {
    id = input.replace('#','');
    if($(input+"Alert").after().length) {
    } else {
        $(input).after('<span id="'+ id +'Alert" style="color:red"> '+ msg + ' </span>');
        $(input).addClass('border-danger');
    }
    $(input).keydown( function(){
        $(input+"Alert").remove();
        $(input).removeClass('border-danger');
    });
}