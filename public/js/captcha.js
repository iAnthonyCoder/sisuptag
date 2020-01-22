$(document).ready(function () {

    //var a = 2;
    /* $("#login-form").submit(function (e){
 
         var data = $(this).find('input[name=captcha]').serialize(); 
         
         var thisForm = this;
     
          $.ajax(
         {
           url: $('#_urlcaptcha').val(),
           headers: {'X-CSRF-TOKEN': $('#login-form #_token').val()},
           type: 'POST',
           cache: false,
           data: data,   
           success: function(response)
           {
             
             if(response.success)
             {
                // $("#captcha").attr("disabled","disabled")
                 thisForm.submit(); 
                 
             }
             else if(response.denied)
             {
                 
                 $("#captcha-error-msg").text("No mames wey...")
                 $("#captcha-error-msg").parent().parent().addClass("has-error");
                 reloadCaptcha();
                 e.preventDefault();
             }
           }
         }); 
         e.preventDefault();
     });
 
 */

    // $('#captchaForm').submit(function (e) {

    // });
});

$('#refreshCaptcha').on("click", function (e) {
    e.preventDefault();
    reloadCaptcha()
});

function reloadCaptcha() {
    $.ajax({
        url: $('#_urlcaptcha').val() + "Refresh",
        headers: { 'X-CSRF-TOKEN': $('#login-form #_token').val() },
        type: 'GET',
        success: function (response) {
            console.log(response);
            $("#captchacontainer").html(response.captcha);
        }
    });
}