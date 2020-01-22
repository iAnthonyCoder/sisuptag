
$(document).ready(function () {

    $('#refreshCaptcha').on("click", function (e) {
        e.preventDefault();
        reloadCaptcha();
    });

})

// RELOAD CAPTCHA
function reloadCaptcha() {

    $.when(_request.captcha({ url: $('#_urlcaptcha').val() + "Refresh" }))
        .done(function (response) {
            $("#captchacontainer").html(response.captcha);
        })
}

// AGREGAR
$('#newDocument').submit(function (e) {
    e.preventDefault();

    var submit_button = $(this).find('.submit_button');
    var $btn = submit_button.button('loading');

    loadingProgresiveRing(true);
    $.when(_request.postProfile({ url: $('#newDocument #_url').val(), data: $('#newDocument').serialize() }))
        .done(function (response) {

            if (response.success) {

                toastr.success(response.res);
                reloadCaptcha();

            }
            else if (response.error) {

                toastr.error(response.res);

                if (response.id == "0") {

                    $("#captcha-error-msg").parent().parent().addClass("has-error");
                    reloadCaptcha();
                    e.preventDefault();
                    reloadCaptcha();

                }
                if (response.id == "1") {
                    $("#current_password").parent().parent().addClass("has-error");
                }
                if (response.id == "2") {
                    $("#password").parent().parent().addClass("has-error");
                    $("#password_confirmation").parent().parent().addClass("has-error");
                }
            }
        }).fail(function (data) {
            errorRequest(data); // en config.js esta esta funcion declarada
        }).always(function(){
            $("#newDocument")[0].reset();
            $btn.button('reset');
            loadingProgresiveRing(false);
        })

    return false;
});

var _request = {

    captcha: function (_data) {

        return $.ajax({
            url: _data.url,
            headers: { 'X-CSRF-TOKEN': $('#login-form #_token').val() },
            type: 'GET',
            dataType: "json",
        })

    },

    postProfile: function (_data) {

        return $.ajax({
            url: _data.url,
            headers: { 'X-CSRF-TOKEN': $('#newDocument #_token').val() },
            type: 'GET',
            cache: false,
            data: _data.data,
            dataType: "json"
        })

    }

}
