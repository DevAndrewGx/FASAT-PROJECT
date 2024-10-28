export function mostrarExito(title, text, redirectURL) {
    Swal.fire({
        title: title,
        text: text,
        icon: "success",
        confirmButtonText: "Aceptar",
        allowOutsideClick: false,
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
        allowOutsideClick: false,
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
        allowOutsideClick: false,
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


 $("#ordersTable").DataTable();

 $("#openOrderForm").on("click", function () {
     const currentDate = new Date().toISOString().split("T")[0];
     const meseroName = "Mesero Actual";

     $("#mesero").val(meseroName);
     $("#fecha").val(currentDate);

     $("#orderModal").modal("show");
 });

 function calculateTotals() {
     let subtotalPlatos = 0;
     let subtotalBebidas = 0;

     $("#platosTable tbody tr").each(function () {
         const price = parseFloat(
             $(this).find("td").eq(2).text().replace("$", "")
         );
         const quantity = parseInt($(this).find("td").eq(1).text());
         subtotalPlatos += price * quantity;
     });

     $("#bebidasTable tbody tr").each(function () {
         const price = parseFloat(
             $(this).find("td").eq(2).text().replace("$", "")
         );
         const quantity = parseInt($(this).find("td").eq(1).text());
         subtotalBebidas += price * quantity;
     });

     const total = subtotalPlatos + subtotalBebidas;
     $("#total").val("$" + total.toFixed(2));
 }

 $("#addMesa").on("click", function () {
     const mesaValue = $("#mesaInput").val();
     if (mesaValue && !isNaN(mesaValue) && mesaValue > 0) {
         $("#mesasTable tbody").append(`
                <tr>
                    <td>${mesaValue}</td>
                    <td><button type="button" class="btn btn-danger btn-sm removeMesa">Eliminar</button></td>
                </tr>
            `);
         $("#mesaInput").val("");
         $("#mesasError").hide();
     } else {
         $("#mesasError").show();
     }
 });

 $(document).on("click", ".removeMesa", function () {
     $(this).closest("tr").remove();
 });

 $("#addPlato").on("click", function () {
     const platoNombre = $("#platoSelect option:selected").val();
     const platoPrecio = $("#platoSelect option:selected").data("price");
     const platoCantidad = $("#platoCantidad").val();
     if (
         platoNombre &&
         platoPrecio &&
         !isNaN(platoCantidad) &&
         platoCantidad > 0
     ) {
         $("#platosTable tbody").append(`
                <tr>
                    <td>${platoNombre}</td>
                    <td>${platoCantidad}</td>
                    <td>$${platoPrecio}</td>
                    <td>$${(platoPrecio * platoCantidad).toFixed(2)}</td>
                    <td><button type="button" class="btn btn-danger btn-sm removePlato">Eliminar</button></td>
                </tr>
            `);
         $("#platoSelect").val("");
         $("#platoCantidad").val("");
         $("#platosError").hide();
         calculateTotals();
     } else {
         $("#platosError").show();
     }
 });

 $(document).on("click", ".removePlato", function () {
     $(this).closest("tr").remove();
     calculateTotals();
 });

 $("#addBebida").on("click", function () {
     const bebidaNombre = $("#bebidaSelect option:selected").val();
     const bebidaPrecio = $("#bebidaSelect option:selected").data("price");
     const bebidaCantidad = $("#bebidaCantidad").val();
     if (
         bebidaNombre &&
         bebidaPrecio &&
         !isNaN(bebidaCantidad) &&
         bebidaCantidad > 0
     ) {
         $("#bebidasTable tbody").append(`
                <tr>
                    <td>${bebidaNombre}</td>
                    <td>${bebidaCantidad}</td>
                    <td>$${bebidaPrecio}</td>
                    <td>$${(bebidaPrecio * bebidaCantidad).toFixed(2)}</td>
                    <td><button type="button" class="btn btn-danger btn-sm removeBebida">Eliminar</button></td>
                </tr>
            `);
         $("#bebidaSelect").val("");
         $("#bebidaCantidad").val("");
         $("#bebidasError").hide();
         calculateTotals();
     } else {
         $("#bebidasError").show();
     }
 });

 $(document).on("click", ".removeBebida", function () {
     $(this).closest("tr").remove();
     calculateTotals();
 });

 $("#submitOrder").on("click", function () {
     const mesas = [];
     $("#mesasTable tbody tr").each(function () {
         mesas.push($(this).find("td").first().text());
     });

     const platos = [];
     $("#platosTable tbody tr").each(function () {
         platos.push({
             nombre: $(this).find("td").eq(0).text(),
             cantidad: $(this).find("td").eq(1).text(),
             precio: $(this).find("td").eq(2).text(),
             subtotal: $(this).find("td").eq(3).text(),
         });
     });

     const bebidas = [];
     $("#bebidasTable tbody tr").each(function () {
         bebidas.push({
             nombre: $(this).find("td").eq(0).text(),
             cantidad: $(this).find("td").eq(1).text(),
             precio: $(this).find("td").eq(2).text(),
             subtotal: $(this).find("td").eq(3).text(),
         });
     });

     if (mesas.length === 0 || platos.length === 0 || bebidas.length === 0) {
         $("#mesasError").show();
         $("#platosError").show();
         $("#bebidasError").show();
     } else {
         console.log({
             mesas,
             platos,
             bebidas,
             mesero: $("#mesero").val(),
             fecha: $("#fecha").val(),
         });

         $("#orderModal").modal("hide");
     }
 });