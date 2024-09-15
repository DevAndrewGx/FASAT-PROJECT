const optionMenu = document.querySelector('.select-menu');
const selectBtn = document.querySelector(".select-btn");
const options = document.querySelectorAll(".option");
const selectPlaceholder = document.querySelector(".select-placeholder");

selectBtn.addEventListener('click', () => { 
    optionMenu.classList.toggle('active');
})

options.forEach(option =>  {
    option.addEventListener('click', () => { 
        let selectedOption = option.querySelector('.option-text').textContent;
        selectPlaceholder.textContent = selectedOption;
        console.log(selectedOption);
    })

    console.log(option);
})


// funciones para el crud
$(document).ready(function (){
    
    
    console.log("hello bitch");
    const baseUrl = $('meta[name="base-url"]').attr("content");

    $("#formProduct").submit(function(e) {
        console.log("It's here");
        e.preventDefault();
        let form = $(this)[0];
        console.log(form);
        // let form = $(this)[0]; // Selecciona el formulario como un elemento DOM
        const formData = new FormData(form);

        $.ajax({
            url: baseUrl+"productos/createProduct",
            type: "POST",
            processData: false,
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
    });


     // funcion para filtrar categorias segun la categoria seleccionada
     $("#modalFormCreateProduct #formProduct #categoria").on("change", function (e) {
             // cancelamos el evento por default
             e.preventDefault();
             console.log("it's changing");
             // creamos la variable para almacenar el valor que viene del formulario
             const categoriaNombre = e.target.value;
             console.log(categoriaNombre); 
             // Cambiado a la variable correcta
             // Enviamos los datos mediante $.post
             $.post(`${baseUrl}productos/getSubcategoriesByCategory`,{ categoria: categoriaNombre },function (response) {
                    let subcategories = JSON.parse(response);
                    console.log(subcategories);
                    let template = "";
                   
                   if (subcategories.data.length === 0) {
                       template += `
                        <option value="#">No existen categorías asociadas</option>
                    `;
                       $("#subcategoria").html(template);
                       return;
                   }

                    template += "<option ='#'>Seleccione subcategoria</option>"
                    subcategories.data.forEach((subcategory) => {
                        template += `
                            <option value="${subcategory.id_sub_categoria}">${subcategory.nombre_subcategoria}</option>
                        `;
                        
                    })
                    // $("#subcategoria").html(template);
                    $("#subcategoria").html(template);
                    console.log("Data enviada correctamente");
                    console.log(response);
                    return;
                }
            );
         }
     );
});

