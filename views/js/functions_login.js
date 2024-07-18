$(document).ready(function() {
    // Mostrar formulario de olvido de contraseña al hacer clic en el enlace
    $('#btn-olvido-pass').click(function(e) {
        e.preventDefault();
        $('#formLogin').fadeOut(200, function() {
            $('#formOlvidoPass').fadeIn(200);
        });
    });

    // Volver al formulario de inicio de sesión al hacer clic en "Iniciar sesión"
    $('#btn-back-login').click(function(e) {
        e.preventDefault();
        $('#formOlvidoPass').fadeOut(200, function() {
            $('#formLogin').fadeIn(200);
        });
    });

    // Manejar el envío del formulario para restablecer la contraseña 
    if ($('#formOlvidoPass').length > 0) {
        $('#formOlvidoPass').submit(function(e) {
            e.preventDefault();

           
            Swal.fire({
                icon: 'success',
                title: 'Correo enviado',
                text: 'Hemos enviado un correo para restablecer tu contraseña.',
                showConfirmButton: false,
                allowOutsideClick: false,
                timer: 5000
            }).then(function() {
                // Vaciar el campo de email después de enviar el formulario
                $('#txtEmailReset').val('');

                // Ocultar formulario de olvido de contraseña y mostrar el de inicio de sesión
                $('#formOlvidoPass').fadeOut(200, function() {
                    $('#formLogin').fadeIn(200);
                });
            });
        });
    }

    // Manejar el envío del formulario para cambiar la contraseña (si el formulario existe)
    if ($('#formCambiarPass').length > 0) {
        $('#formCambiarPass').submit(function(e) {
            e.preventDefault();

            let strPassword = $('#txtPassword').val(); 
            let strPasswordConfirm = $('#txtPasswordConfirm').val(); 
            let idUsuario = $('#idUsuario').val(); 

            if (strPassword === "" || strPasswordConfirm === "") {
                swal("Por favor", "Escribe la nueva contraseña.", "error");
                return false;
            } else if (strPassword.length < 5) {
                swal("Atención", "La contraseña debe tener un mínimo de 5 caracteres.", "info");
                return false;
            } else if (strPassword !== strPasswordConfirm) {
                swal("Atención", "Las contraseñas no son iguales.", "error");
                return false;
            }

            // Mostrar mensaje de carga
            $('#divLoading').css('display', 'flex');

            setTimeout(function() {
                $('#divLoading').hide();

                // Mostrar mensaje de éxito con SweetAlert2
                swal({
                    title: "",
                    text: "Contraseña cambiada correctamente.",
                    type: "success",
                    confirmButtonText: "Iniciar sesión",
                    closeOnConfirm: false,
                }, function(isConfirm) {
                    if (isConfirm) {
                        window.location.href = '<?php echo constant("URL") ?>/login';
                    }
                });

                // Vaciar los campos de contraseña después de cambiarla
                $('#txtPassword').val('');
                $('#txtPasswordConfirm').val('');
            }, 2000); // Simular tiempo de respuesta del servidor
        });
    }
});
