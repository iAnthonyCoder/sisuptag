toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
var _countModal = 0;
var progresiveLoading = "<div class='modal-loading' id='progresiveLoading'>"
    + "<div class='loader'>"
    + "<div class='circle'></div>"
    + "<div class='circle'></div>"
    + "<div class='circle'></div>"
    + "<div class='circle'></div>"
    + "<div class='circle'></div>"
    + "</div>"
    + "</div>";

$(document).ready(function () {



    //var url = window.location.href;
    // if(url.indexOf("documentos")> -1||url.indexOf("hom")> -1)
    // {
    // }
    // else
    // {
    //   $(document).find(".modulos-dropdown").addClass("hide");
    // }

    //$(document).find(".modulos-dropdown").addClass("hide");

    $(document).on("click", ".reset_button", function (e) {
        e.preventDefault();
        var el = $(this).closest("form");
        el[0].reset();
    })

    $(document).on("click", ".cancel_button", function () {
        $(document).find(".card-body").addClass("hidden");
        $(document).find(".indexDocument-section").removeClass("hidden");
        $(document).find(".control-button").removeClass("active");
        $(".edit-doc-container-trigger").addClass("disabled");
        $(".index-doc-container-trigger").addClass("active");
    })

    if ($(".errors-login").length) {
        if ($(".errors-login").val().length !== 0) {
            toastr.error($(".errors-login").val())
            var _nthChild = $(".errors-login").val() == "La verificación de captcha ha fallado, intente nuevamente." ? '4' : '2';
            $("#login-form > div:nth-child(" + _nthChild + ")").addClass("has-error");
        }
    }

});

function errorRequest(data) {

    var errors = data.responseJSON;
    $.each(errors.errors, function (key, value) {
        toastr.error(value);
        return false;
    });

}

function loadingProgresiveRing(bool) {
    _countModal += bool ? 1 : -1;

    if (_countModal < 0) _countModal = 0;

    if (_countModal == 0 && document.querySelector("#progresiveLoading")) {
        var _progresiveRing = document.querySelector("#progresiveLoading");
        $("#progresiveLoading").animate({ opacity: 0 }, 200, function () { _progresiveRing.parentElement.removeChild(_progresiveRing); });
        return false;
    }

    if (_countModal == 1 && !document.querySelector("#progresiveLoading")) {
        $("body").append(progresiveLoading);
        $("#progresiveLoading").animate({ opacity: 1 }, 200);
    }
}


