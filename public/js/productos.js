$(documento.ready(function (){

    const baseUrl = $('meta[name="base-url"]').attr("content");

    $("#modalFormCreateProduct").submit(function(e) {

        e.preventDefault();

        
        let form = $(this)[0]; // Selecciona el formulario como un elemento DOM
        const formData = new FormData(form);

        $.ajax({
            url: baseUrl+"productos/createProduct",
            type: "POST",
            processdata: false,
            contentType: false,
            data: formData,
            success: function(response) {
                let data = JSON.parse(response);
                
                if(data.status) {
                    Swal.fire({
                        icon: "success",
                        title: "Producto creado",
                        text: data.message,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        timer: 5000,
                    }).then(function () {
                        // // Vaciar el campo de email después de enviar el formulario
                        // $("#txtEmailReset").val("");
                        // // Ocultar formulario de olvido de contraseña y mostrar el de inicio de sesión
                        // $("#formOlvidoPass").fadeOut(200, function () {
                        //     $("#formLogin").fadeIn(200);
                        // });
                    });
                }
            }
        })
    })
}));