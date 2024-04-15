// Alertas.js for creating an employee
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formularioRegistro"); 

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
                    mostrarExito();
                } else {
                    mostrarError();
                }
            })
            .catch((error) => {
                alert("we have a fuck error");
                console.error("Error:", error);
                mostrarError();
            });
    });
});

function mostrarExito() {
    Swal.fire({
        title: "Usuario Creado",
        text: "El usuario ha sido creado exitosamente",
        icon: "success",
        confirmButtonText: "Aceptar",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "gestionEmpleados.php";
        }
    });
}

function mostrarError() {
    Swal.fire({
        title: "Error",
        text: "Ocurrió un error al registrar el usuario",
        icon: "error",
        confirmButtonText: "Aceptar",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "";
        }
    });
}

// Alerts for removing an employee

document.addEventListener("DOMContentLoaded", () => {
    const botonEliminar = document.getElementById("borrar-empleado"); // Reemplaza 'botonEliminar' con el ID de tu botón para eliminar

    botonEliminar.addEventListener("click", (e) => {
        e.preventDefault();
        // Aquí tu código para enviar una solicitud AJAX para borrar el registro

        fetch("../../../controllers/borrarEmpleados.php", {
            method: "POST",
            // Aquí tus datos para enviar al controlador, si es necesario
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    mostrarExitoBorrar();
                } else {
                    mostrarErrorBorrar();
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                mostrarErrorBorrar();
            });
    });
});

function mostrarExitoBorrar() {
    Swal.fire({
        title: "Registro Eliminado",
        text: "El registro ha sido eliminado exitosamente",
        icon: "success",
        confirmButtonText: "Aceptar",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.reload(); // Recargar la página actual
        }
    });
}

function mostrarErrorBorrar() {
    Swal.fire({
        title: "Error",
        text: "Ocurrió un error al eliminar el registro",
        icon: "error",
        confirmButtonText: "Aceptar",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.reload(); // Recargar la página actual
        }
    });
}