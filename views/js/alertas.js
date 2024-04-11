// alertas.js
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
