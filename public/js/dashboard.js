
const baseUrl = $('meta[name="base-url"]').attr("content");
    let autoUpdate = true;
    let interval = null;
$(document).ready(function () {


    // Evento para el filtro de fechas
    $("#filtro-fechas").on("change", function () {
        const filtro = $(this).val();
        console.log(filtro);

        let fechaInicio, fechaFin;

        // Obtener la fecha actual en la zona horaria local
        const hoy = new Date();
        const zonaHorariaOffset = hoy.getTimezoneOffset() * 60000; // Desfase de zona horaria en ms (UTC-5)

        // Función para generar fechas en formato YYYY-MM-DD
        function obtenerFechaLocal(fecha) {
            return new Date(fecha - zonaHorariaOffset)
                .toISOString()
                .slice(0, 10); // Formato YYYY-MM-DD
        }

        if (filtro === "hoy") {
            console.log("entra hoy");

            // Fecha de inicio y fin para el día actual
            fechaInicio = obtenerFechaLocal(new Date(hoy.setHours(0, 0, 0, 0)));
            fechaFin = fechaInicio; // La misma fecha porque es el mismo día

            console.log("Fecha Inicio Hoy:", fechaInicio);
            console.log("Fecha Fin Hoy:", fechaFin);
        } else if (filtro === "semana") {
            // Fecha de inicio: hace 7 días
            fechaInicio = obtenerFechaLocal(
                new Date(hoy.setDate(hoy.getDate() - 7))
            );

            // Fecha de fin: el día actual
            fechaFin = obtenerFechaLocal(new Date());

            console.log("Semana:", fechaInicio, " - ", fechaFin);
        } else if (filtro === "mes") {
            // Fecha de inicio: hace 1 mes
            fechaInicio = obtenerFechaLocal(
                new Date(hoy.setMonth(hoy.getMonth() - 1))
            );

            // Fecha de fin: el día actual
            fechaFin = obtenerFechaLocal(new Date());

            console.log("Mes:", fechaInicio, " - ", fechaFin);
        }

        autoUpdate = filtro === ""; // Desactivar actualización automática si se selecciona filtro
        cargarDataDasboard(fechaInicio, fechaFin);
        cargarDataProductosMasVendidos(fechaInicio, fechaFin);
        

        if (autoUpdate) startAutoUpdate(); // Reiniciar auto-update si no hay filtro
    });

    // Cargar datos iniciales
    cargarDataDasboard();
    cargarDataProductosMasVendidos();
    startAutoUpdate();
});

// funcion para actualizar la data del dashboard cada minuto
function startAutoUpdate() {
    // Actualiza datos cada minuto
    if (interval) clearInterval(interval);
    interval = setInterval(function () {
        if (autoUpdate) cargarDataDasboard();
    }, 60000);
}


function cargarDataDasboard(fechaInicio = null, fechaFin = null) {
    // Construimos la URL para enviar la peticion y traer los datos
    let url = baseUrl + "admin/obtenerDatosDashboard";
    if (fechaInicio && fechaFin) {
        url += `/${fechaInicio}/${fechaFin}`;
    }

    // AJAX para cargar datos
    $.ajax({
        url: url, // Ruta basada en tu sistema de enrutamiento
        method: "GET",
        dataType: "json",
        success: function (data) {
            $("#ventas-del-dia").text(`$${data.ventasDelDia}`);
            $("#ordenes-pendientes").text(
                `${data.ordenesActivas}`
            );
            $("#productos-vendidos").text(
                `${data.productosVendidos}`
            );
            $("#alertas-stock").text(`Alertas de stock: ${data.alertasStock}`);
        },
        error: function (xhr, status, error) {
            console.error("Error cargando datos del dashboard:", error);
        },
    });
}

function cargarDataProductosMasVendidos(fechaInicio = null, fechaFin = null) {
    // construimos la URL para envar la petición y traer los datos

    let url = baseUrl + "admin/obtenerDatosGraficos";
    if (fechaInicio && fechaFin) {
        url += `/${fechaInicio}/${fechaFin}`;
    }

    $.ajax({
        url: url, // Ruta basada en tu sistema de enrutamiento
        method: "GET",
        dataType: "json",
        success: function (data) {
            // Gráfico de Productos Más Vendidos
            const categorias = data.productosMasVendidos.map(
                (item) => item.nombre
            );
            const cantidades = data.productosMasVendidos.map(
                (item) => item.total_vendido
            );

            var opcionesProductos = {
                series: [
                    {
                        name: "Cantidad Vendida",
                        data: cantidades,
                    },
                ],
                chart: { type: "bar", height: 350 },
                xaxis: { categories: categorias },
                // title: { text: "Productos Más Vendidos" },
            };
            var chartProductos = new ApexCharts(
                document.querySelector("#chart-productos"),
                opcionesProductos
            );
            chartProductos.render();
        },
        error: function (xhr, status, error) {
            console.error("Error cargando datos en los graficos", error);
        },
    });
}
