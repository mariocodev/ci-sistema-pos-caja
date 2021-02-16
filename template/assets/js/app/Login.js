$(document).ready(function(){
    //$(".footer").hide();
});

function enviar_datos() {
    $("form").submit(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        iniciar();
    });
}
function iniciar() {
    var url;
    url = "login/iniciar_sesion_post";
    // ajax adding data to database
    $.ajax({
        url: url,
        type: "POST",
        data: $("#formLogin").serialize(),
        dataType: "JSON",
        beforeSend: function () {
            $("#login").html("Conectando...");
        },
        success: function (data) {
            //if success
            if (data) {
                $("#login").html("Iniciando...");
                $("body")
                    .load("login")
                    .hide()
                    .fadeIn(1500)
                    .delay(6000);
                window.location.href = ""; // Se redirecciona (admin) y el routes se encarga
                console.log('iniciando sesión...')
            } else {
                //$("#login").html("Loguearse");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#forgotPass").effect("shake");
            $("#forgotPass").prepend(
                "<small class='label label-danger invalidas'>Credenciales inválidas.</small>  "
            );
            setTimeout(function () {
                $("#forgotPass .invalidas").addClass("d-none");
            }, 3000);
            $("#login").html("Loguearsse");
        },
    });
}
