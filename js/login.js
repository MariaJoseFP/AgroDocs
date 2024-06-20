
$(document).ready(function() {
    $("#btnLogin").click(function() {
        console.log("vemos si te logueamos");
        // Obtener los datos del formulario
        var usuario = $("#username").val();
        var contraseña = $("#password").val();
        // Realizar la solicitud AJAX
        $.ajax({
            type: "POST",
            url: "php/login.php", // Ajusta el nombre del archivo que manejará la lógica de inicio de sesión
            data: { username: usuario, password: contraseña},
            success: function(response) {
                if (response.status === "success") {
                    console.log(response);
                    // Redirigir a la página de inicio después del inicio de sesión exitoso
                    if(response.area === "lyt"){
                        window.location.href = "inicio_lyt.php";
                    }else if(response.area === "movilizacion"){
                        window.location.href = "inicio_m.php";
                    }
                    

                } else {
                    // Mostrar mensaje de error
                    $("#alert-error").css("display", "block");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX: " + textStatus + ", " + errorThrown);
            }
        });
    });
});
