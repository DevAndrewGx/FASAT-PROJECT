$(document).ready(function() {
    // Mostrar formulario de olvido de contraseña al hacer clic en el enlace
    $('#btn-olvido-pass').click(function(e) {
        e.preventDefault();
        $('#formLogin').hide();
        $('#formOlvidoPass').show();
    });

    // Volver al formulario de inicio de sesión al hacer clic en "Iniciar sesión"
    $('#btn-back-login').click(function(e) {
        e.preventDefault();
        $('#formOlvidoPass').hide();
        $('#formLogin').show();
    });
});


if (document.querySelector("#formCambiarPass")) {
    let formCambiarPass = document.querySelector("#formCambiarPass");
    formCambiarPass.onsubmit = function(e) {
        e.preventDefault();

        let strPassword = document.querySelector('#txtPassword').value;
        let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;
        let idUsuario = document.querySelector('#idUsuario').value;

        if (strPassword == "" || strPasswordConfirm == "") {
            swal("Por favor", "Escribe la nueva contraseña.", "error");
            return false;
        } else {
            if (strPassword.length < 5) {
                swal("Atención", "La contraseña debe tener un mínimo de 5 caracteres.", "info");
                return false;
            }
            if (strPassword != strPasswordConfirm) {
                swal("Atención", "Las contraseñas no son iguales.", "error");
                return false;
            }
            divLoading.style.display = "flex";
            var request = (window.XMLHttpRequest) ?
                new XMLHttpRequest() :
                new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = '<?php echo constant("URL") ?>/Login/setPassword'; // Aquí se utiliza la constante URL de PHP
            var formData = new FormData(formCambiarPass);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function() {
                if (request.readyState != 4) return;
                if (request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        swal({
                            title: "",
                            text: objData.msg,
                            type: "success",
                            confirmButtonText: "Iniciar sessión",
                            closeOnConfirm: false,
                        }, function(isConfirm) {
                            if (isConfirm) {
                                window.location = '<?php echo constant("URL") ?>/login';
                            }
                        });
                    } else {
                        swal("Atención", objData.msg, "error");
                    }
                } else {
                    swal("Atención", "Error en el proceso", "error");
                }
                divLoading.style.display = "none";
            }
        }
    }
}
