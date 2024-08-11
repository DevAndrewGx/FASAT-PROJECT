$(document).ready(function () {
    // Variable para la URL global

    const baseUrl = $('meta[name="base-url"]').attr("content");

    efftectsUI();

    // enviar la request con AJAX hacia el controlador EMAIL para enviar el mensaje

    $("#formOlvidoPass").submit(function (e) {
        e.preventDefault();

        let form = $(this)[0]; // Selecciona el formulario como un elemento DOM
        const formData = new FormData(form);

        $.ajax({
            url: baseUrl + "cambiarpassword/sendEmail",
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

            let password = $("#password").val();
            let repassword = $("#repassword").val();
            // let idUsuario = $("#idUsuario").val();
            if (password === "" || repassword === "") {
                Swal.fire({
                    icon: "error",
                    title: "Error cambiar contraseña",
                    text: "Las contraseñas no deben estar vacias",
                    allowOutsideClick: false,
                    timer: 2000,
                });
                return;
            } else if (password.length < 8) {
               Swal.fire({
                   icon: "error",
                   title: "Error cambiar contraseña",
                   text: "La nueva contraseña debe ser mayor a 8 caracteres",
                   allowOutsideClick: false,
                   timer: 2000,
               });

                return;
            } else if (password !== repassword) {
                Swal.fire({
                    icon: "error",
                    title: "Error cambiar contraseña",
                    text: "Las contraseñas deben ser iguales",
                    allowOutsideClick: false,
                    timer: 2000,
                });
                return;
            }else {

                let form = $(this)[0]; // Selecciona el formulario como un elemento DOM
                const formData = new FormData(form);

                $.ajax({
                    url: baseUrl + "cambiarpassword/changePassword",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        let data = JSON.parse(response);

                        if (data.status) {
                            Swal.fire({
                                icon: "success",
                                title: "Cambio de contraseña exitoso",
                                //   text: "Hemos enviado un correo para restablecer tu contraseña.",
                                text: data.message,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                timer: 5000,
                            }).then(function () {
                                //Vaciar los campos de contraseña después de cambiarla
                                $("#password").val("");
                                $("#repassword").val("");
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error en el envio",
                                text: data.message,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                timer: 5000,
                            }).then(function () {});
                        }
                    },
                });

               
            }

            
        });
    }

    // Hacemos las respectiivas validaciones para cambiar la contraseña
    // if (document.querySelector("#formCambiarPass")) {
    //     let formCambiarPass = document.querySelector("#formCambiarPass");
    //     formCambiarPass.onsubmit = function (e) {
    //         e.preventDefault();

    //         let strPassword = document.querySelector("#txtPassword").value;
    //         let strPasswordConfirm = document.querySelector(
    //             "#txtPasswordConfirm"
    //         ).value;
    //         let idUsuario = document.querySelector("#idUsuario").value;

    //         if (strPassword == "" || strPasswordConfirm == "") {
    //             swal("Por favor", "Escribe la nueva contraseña.", "error");
    //             return false;
    //         } else {
    //             if (strPassword.length < 5) {
    //                 swal(
    //                     "Atención",
    //                     "La contraseña debe tener un mínimo de 5 caracteres.",
    //                     "info"
    //                 );
    //                 return false;
    //             }
    //             if (strPassword != strPasswordConfirm) {
    //                 swal(
    //                     "Atención",
    //                     "Las contraseñas no son iguales.",
    //                     "error"
    //                 );
    //                 return false;
    //             }
    //             divLoading.style.display = "flex";
    //             var request = window.XMLHttpRequest
    //                 ? new XMLHttpRequest()
    //                 : new ActiveXObject("Microsoft.XMLHTTP");
    //             var ajaxUrl = '<?php echo constant("URL") ?>/Login/setPassword'; // Aquí se utiliza la constante URL de PHP
    //             var formData = new FormData(formCambiarPass);
    //             request.open("POST", ajaxUrl, true);
    //             request.send(formData);
    //             request.onreadystatechange = function () {
    //                 if (request.readyState != 4) return;
    //                 if (request.status == 200) {
    //                     var objData = JSON.parse(request.responseText);
    //                     if (objData.status) {
    //                         swal(
    //                             {
    //                                 title: "",
    //                                 text: objData.msg,
    //                                 type: "success",
    //                                 confirmButtonText: "Iniciar sessión",
    //                                 closeOnConfirm: false,
    //                             },
    //                             function (isConfirm) {
    //                                 if (isConfirm) {
    //                                     window.location =
    //                                         '<?php echo constant("URL") ?>/login';
    //                                 }
    //                             }
    //                         );
    //                     } else {
    //                         swal("Atención", objData.msg, "error");
    //                     }
    //                 } else {
    //                     swal("Atención", "Error en el proceso", "error");
    //                 }
    //                 divLoading.style.display = "none";
    //             };
    //         }
    //     };
    // }
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
