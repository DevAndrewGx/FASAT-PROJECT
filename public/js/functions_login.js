$(document).ready(function () {
    // Variable para la URL global

    const baseUrl = $('meta[name="base-url"]').attr("content");

    efftectsUI();

    // enviar la request con AJAX hacia el controlador EMAIL para enviar el mensaje

    $("#formOlvidoPass").submit(function (e) {
        e.preventDefault();
        console.log("HELLO");
        let form = $(this)[0]; // Selecciona el formulario como un elemento DOM
        const formData = new FormData(form);

        $.ajax({
            url: baseUrl + "cambiarPassword/sendEmail",
            type: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                let data = JSON.parse(response);

                
                if (data.status) {
                    Swal.fire({
                        icon: "success",
                        title: "Correo enviado",
                        //   text: "Hemos enviado un correo para restablecer tu contraseña.",
                        text: data.message,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        timer: 5000,
                    }).then(function () {
                        // Vaciar el campo de email después de enviar el formulario
                        $("#txtEmailReset").val("");
                        // Ocultar formulario de olvido de contraseña y mostrar el de inicio de sesión
                        $("#formOlvidoPass").fadeOut(200, function () {
                            $("#formLogin").fadeIn(200);
                        });
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error en el envio",
                        text: data.message,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        timer: 5000,
                    }).then(function () {
                        // Vaciar el campo de email después de enviar el formulario
                        $("#txtEmailReset").val("");

                        // Ocultar formulario de olvido de contraseña y mostrar el de inicio de sesión
                        $("#formOlvidoPass").fadeOut(200, function () {
                            $("#formLogin").fadeIn(200);
                        });
                    });
                }
            },
        });
    });

    // Manejar el envío del formulario para cambiar la contraseña (si el formulario existe)
    if ($("#formCambiarPass").length > 0) {
        $("#formCambiarPass").submit(function (e) {
            e.preventDefault();

            let strPassword = $("#txtPassword").val();
            let strPasswordConfirm = $("#txtPasswordConfirm").val();
            let idUsuario = $("#idUsuario").val();

            if (strPassword === "" || strPasswordConfirm === "") {
                swal("Por favor", "Escribe la nueva contraseña.", "error");
                return false;
            } else if (strPassword.length < 5) {
                swal(
                    "Atención",
                    "La contraseña debe tener un mínimo de 5 caracteres.",
                    "info"
                );
                return false;
            } else if (strPassword !== strPasswordConfirm) {
                swal("Atención", "Las contraseñas no son iguales.", "error");
                return false;
            }

            // Mostrar mensaje de carga
            $("#divLoading").css("display", "flex");

            setTimeout(function () {
                $("#divLoading").hide();

                // Mostrar mensaje de éxito con SweetAlert2
                swal(
                    {
                        title: "",
                        text: "Contraseña cambiada correctamente.",
                        type: "success",
                        confirmButtonText: "Iniciar sesión",
                        closeOnConfirm: false,
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location.href =
                                '<?php echo constant("URL") ?>/login';
                        }
                    }
                );

                // Vaciar los campos de contraseña después de cambiarla
                $("#txtPassword").val("");
                $("#txtPasswordConfirm").val("");
            }, 2000); // Simular tiempo de respuesta del servidor
        });
    }

    // Hacemos las respectiivas validaciones para cambiar la contraseña
    if (document.querySelector("#formCambiarPass")) {
        let formCambiarPass = document.querySelector("#formCambiarPass");
        formCambiarPass.onsubmit = function (e) {
            e.preventDefault();

            let strPassword = document.querySelector("#txtPassword").value;
            let strPasswordConfirm = document.querySelector(
                "#txtPasswordConfirm"
            ).value;
            let idUsuario = document.querySelector("#idUsuario").value;

            if (strPassword == "" || strPasswordConfirm == "") {
                swal("Por favor", "Escribe la nueva contraseña.", "error");
                return false;
            } else {
                if (strPassword.length < 5) {
                    swal(
                        "Atención",
                        "La contraseña debe tener un mínimo de 5 caracteres.",
                        "info"
                    );
                    return false;
                }
                if (strPassword != strPasswordConfirm) {
                    swal(
                        "Atención",
                        "Las contraseñas no son iguales.",
                        "error"
                    );
                    return false;
                }
                divLoading.style.display = "flex";
                var request = window.XMLHttpRequest
                    ? new XMLHttpRequest()
                    : new ActiveXObject("Microsoft.XMLHTTP");
                var ajaxUrl = '<?php echo constant("URL") ?>/Login/setPassword'; // Aquí se utiliza la constante URL de PHP
                var formData = new FormData(formCambiarPass);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState != 4) return;
                    if (request.status == 200) {
                        var objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            swal(
                                {
                                    title: "",
                                    text: objData.msg,
                                    type: "success",
                                    confirmButtonText: "Iniciar sessión",
                                    closeOnConfirm: false,
                                },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        window.location =
                                            '<?php echo constant("URL") ?>/login';
                                    }
                                }
                            );
                        } else {
                            swal("Atención", objData.msg, "error");
                        }
                    } else {
                        swal("Atención", "Error en el proceso", "error");
                    }
                    divLoading.style.display = "none";
                };
            }
        };
    }
});

function efftectsUI() {
    // Mostrar formulario de olvido de contraseña al hacer clic en el enlace
    $("#btn-olvido-pass").click(function (e) {
        e.preventDefault();
        $("#formLogin").hide();
        $("#formOlvidoPass").show();
    });

    // Volver al formulario de inicio de sesión al hacer clic en "Iniciar sesión"
    $("#btn-back-login").click(function (e) {
        e.preventDefault();
        $("#formOlvidoPass").hide();
        $("#formLogin").show();
    });

    // Mostrar formulario de olvido de contraseña al hacer clic en el enlace
    $("#btn-olvido-pass").click(function (e) {
        e.preventDefault();
        $("#formLogin").fadeOut(200, function () {
            $("#formOlvidoPass").fadeIn(200);
        });
    });

    // Volver al formulario de inicio de sesión al hacer clic en "Iniciar sesión"
    $("#btn-back-login").click(function (e) {
        e.preventDefault();
        $("#formOlvidoPass").fadeOut(200, function () {
            $("#formLogin").fadeIn(200);
        });
    });
}
