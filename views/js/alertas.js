
// Alertas.js for creating an employee
document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("formularioRegistro");
    const botonEliminar = document.getElementById("borrar-empleado");  


    if(form) {
        form.addEventListener("submit", (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            fetch("../../../controllers/registrarEmpleado.php", {
                method: "POST",
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        mostrarExito(
                            "Usuario Creado",
                            "El usuario ha sido creado exitosamente",
                            "gestionEmpleados.php"
                        );
                    } else {
                        mostrarError(
                            "Error",
                            "Ocurrió un error al registrar el usuario",
                            ""
                        );
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    mostrarError(
                        "Error",
                        "Ocurrió un error al registrar el usuario",
                        ""
                    );
                });
        });
    }

    if(botonEliminar) {
        // REMOVE FEATURES FOR EMPLOYEE
        botonEliminar.addEventListener("click", (e) => {
            e.preventDefault();
            mostrarConfirmacionBorrar();
        });
    }
    
   
});



function mostrarExito(title, text, redirectURL) {
    Swal.fire({
        title: title,
        text: text,
        icon: "success",
        confirmButtonText: "Aceptar",
        allowOutsideClick: false, //false para evitar cierre indeseado
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = redirectURL;
        }
    });
}

function mostrarError(title, text, redirectURL) {
    Swal.fire({
        title: title,
        text: text,
        icon: "error",
        confirmButtonText: "Aceptar",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = redirectURL;
        }
    });
}

// Alerts for removing an employee

function mostrarConfirmacionBorrar() {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("../../../controllers/borrarEmpleados.php", {
                method: "POST",
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        mostrarExito(
                            "Usuario eliminado",
                            "El usuario ha sido eliminado exitosamente",
                            ""
                        );
                    } else {
                        mostrarError(
                            "El usuario no se puede eliminar",
                            "Hubo un problema en la consulta",
                            ""
                        );
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    mostrarError();
                });
        }
    });
}