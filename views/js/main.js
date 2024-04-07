(function ($) {
    "use strict";
    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $('.navbar').addClass('sticky-top shadow-sm');
        } else {
            $('.navbar').removeClass('sticky-top shadow-sm');
        }
    });
    
    
    // Dropdown on mouse hover
    const $dropdown = $(".dropdown");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu");
    const showClass = "show";
    
    $(window).on("load resize", function() {
        if (this.matchMedia("(min-width: 992px)").matches) {
            $dropdown.hover(
            function() {
                const $this = $(this);
                $this.addClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "true");
                $this.find($dropdownMenu).addClass(showClass);
            },
            function() {
                const $this = $(this);
                $this.removeClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "false");
                $this.find($dropdownMenu).removeClass(showClass);
            }
            );
        } else {
            $dropdown.off("mouseenter mouseleave");
        }
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Facts counter
    $('[data-toggle="counter-up"]').counterUp({
        delay: 10,
        time: 2000
    });

})(jQuery);


//Mesas 
// Función para alternar la selección de una mesa
function toggleSeleccion(idMesa) {
    var mesa = document.getElementById(idMesa);
    mesa.classList.toggle('seleccionada');
}

// Función para mostrar el formulario y devolver las mesas seleccionadas
function mostrarFormulario() {
    // Recolectar mesas seleccionadas
    const mesasSeleccionadas = [];
    document.querySelectorAll('.mesa.seleccionada').forEach(mesa => {
        mesasSeleccionadas.push(mesa.id);
    });

    // Mostrar la alerta con la información de las mesas seleccionadas y el formulario
    Swal.fire({
        title: 'Registrar Orden',
        html: `
        <p>Mesas Seleccionadas: ${mesasSeleccionadas.join(', ')}</p>
        <form id="formularioRegistro">
            <h5>Agregar Producto</h5>
            <div class="form-group row">
                <label for="productName" class="col-lg-4 col-form-label">Producto</label>
                <div class="col-lg-8">
                    <select class="form-control" id="productName">
                        <option value="Pizza Margarita">Pizza Margarita</option>
                        <option value="Hamburguesa con Queso">Hamburguesa con Queso</option>
                        <option value="Ensalada César">Ensalada César</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="quantity" class="col-lg-4 col-form-label">Cantidad</label>
                <div class="col-lg-8">
                    <input type="number" class="form-control" id="quantity">
                </div>
            </div>
            <div class="text-right">
                <button type="button" class="btn btn-primary" id="agregarProducto">Agregar Producto</button>
            </div>
            <hr>
            <div id="carrito">
                <h5>Carrito de Compras</h5>
                <ul id="listaProductos" class="list-group">
                    <!-- Los productos agregados se mostrarán aquí -->
                </ul>
            </div>
            <hr>
            <div id="resumenCompra">
                <h5>Resumen de la Compra</h5>
                <div class="form-group row">
                    <label for="subtotalResumen" class="col-lg-4 col-form-label">Subtotal:</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" id="subtotalResumen" readonly value="$0.00">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="totalResumen" class="col-lg-4 col-form-label">Total:</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" id="totalResumen" readonly value="$0.00">
                    </div>
                </div>
            </div>
            <hr>
            <h5>Información de Pago</h5>
            <div class="form-group row">
                <label for="metodoPago" class="col-lg-2 col-form-label">Pago</label>
                <div class="col-lg-4">
                    <select class="form-control" id="metodoPago">
                        <option>Efectivo</option>
                        <option>Tarjeta de Crédito</option>
                        <option>Tarjeta de Débito</option>
                    </select>
                </div>
            </div>
        </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Registrar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        allowOutsideClick: false, //false para evitar cierre indeseado
        preConfirm: () => {
            const metodoPago = document.getElementById('metodoPago').value;
          
            // Por ahora, simplemente mostramos una alerta 
            Swal.fire(
                'Orden Registrada!',
                `Método de Pago: ${metodoPago}`,
                'success'
            );
        },
        didOpen: () => {
            // Manejar el evento clic en el botón "Agregar Producto"
            document.getElementById('agregarProducto').addEventListener('click', () => {
                const productName = document.getElementById('productName').value;
                const quantity = document.getElementById('quantity').value;

                // Crear un nuevo elemento de lista y agregarlo al carrito de compras
                const newItem = document.createElement('li');
                newItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                newItem.innerHTML = `${productName} - Cantidad: ${quantity} - Subtotal: $${calculateSubtotal(productName, quantity).toFixed(2)}
                    <button type="button" class="btn btn-danger eliminarProducto"><i class="bx bx-x"></i></button>`;
                newItem.dataset.quantity = quantity;
                newItem.dataset.price = calculateSubtotal(productName, quantity);

                document.getElementById('listaProductos').appendChild(newItem);

                // Actualizar el subtotal y total
                actualizarResumenCompra();

                // Escuchar el clic en el botón de eliminar producto
                newItem.querySelector('.eliminarProducto').addEventListener('click', () => {
                    console.log("Se hizo clic en el botón de eliminar producto");
                    // Eliminar el elemento del DOM
                    newItem.remove();
                    // Actualizar el subtotal y total después de eliminar el producto
                    actualizarResumenCompra();
                });
            });
        }
    });

    // Devolver las mesas seleccionadas
    return mesasSeleccionadas;
}

// Función para calcular el subtotal de un producto
function calculateSubtotal(productName, quantity) {
    // Calcular el subtotal del producto
    // Por ahora, un valor fijo
    return 10 * quantity; // Precio fijo de $10 por producto
}

// Función para actualizar el resumen de la compra
function actualizarResumenCompra() {
    let subtotal = 0;
    document.querySelectorAll('#listaProductos li').forEach(item => {
        const quantity = item.dataset.quantity;
        const price = item.dataset.price;
        subtotal += quantity * price;
    });

    console.log("Subtotal actualizado:", subtotal);

    // Actualizar el campo de subtotal y total
    document.getElementById('subtotalResumen').value = `$${subtotal.toFixed(2)}`;
    document.getElementById('totalResumen').value = `$${subtotal.toFixed(2)}`; // Por ahora, el total es igual al subtotal
}

// Llamar a la función mostrarFormulario() cuando se cargue la página
document.addEventListener("DOMContentLoaded", function() {
    // Manejar el evento clic en las mesas
    document.querySelectorAll('.mesa').forEach(mesa => {
        mesa.addEventListener('click', () => {
            toggleSeleccion(mesa.id);
        });
    });

    // Llamar a la función mostrarFormulario()
    const mesasSeleccionadas = mostrarFormulario();
    // Hacer algo con las mesas seleccionadas
    console.log("Mesas seleccionadas:", mesasSeleccionadas);
});
