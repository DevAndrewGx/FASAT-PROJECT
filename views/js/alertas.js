export function mostrarExito(title, text, redirectURL) {
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

export function mostrarError(title, text, redirectURL) {
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

export function mostrarConfirmacionBorrar(id_usuario) {
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
                body: JSON.stringify({
                    id_usuario,
                }),
                headers: {
                    "Content-Type": "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        mostrarExito(
                            "Usuario Eliminado Exitosamente",
                            "El usuario ha sido eliminado exitosamente",
                            ""
                        );
                    } else {
                        mostrarError(
                            "Usuario no se eliminado",
                            "El usuario no ha sido eliminado",
                            ""
                        );
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    mostrarError(
                        "Usuario no se eliminado",
                        "El usuario no ha sido eliminado",
                        ""
                    );
                });
        }
    });
}


// function to remove employees 

// creamos una funcion para recivir la data del sevidor para poner mostrarla en el fomrulario
export function enviarDatosAlFormulario(data) {
  
}