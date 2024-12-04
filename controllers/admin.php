<?php 

    class Admin extends SessionController { 

        private $user;

        function __construct()
        {
            parent::__construct();
            $this->user = $this->getDatosUsuarioSession();
        }


        function render() { 
            // $stats = $this->getStatistics();

            $this->view->render('admin/index', [
                'user' => $this->user
            ]);
        }
        public function obtenerDatosDashboard()

        {
            $dashboardObj = new DashboardModel();
            // Recuperamos los datos enviados por POST
            $fechaInicio = isset($_POST['fechaInicio']) ? $_POST['fechaInicio']: date('Y-m-d');
            $fechaFin = isset($_POST['fechaFin']) ? $_POST['fechaFin']: date('Y-m-d');

            error_log("inicio".$fechaInicio);
            error_log("fin" . $fechaFin);

            // Llamamos al modelo para obtener los datos
            $data = [
                'ventasDelDia' => $dashboardObj->getVentasDelDia($fechaInicio, $fechaFin),
                'ordenesActivas' => $dashboardObj->getOrdenesPendientes($fechaInicio, $fechaFin),
                'productosVendidos' => $dashboardObj->getProductosVendidos($fechaInicio, $fechaFin),
                // 'alertasStock' => $this->model->getAlertasStock(),
            ];

            // Devolvemos los datos en formato JSON
            echo json_encode($data);
        }

        // esta funcion nos permitira traer la data del back para mostrarla en los graficos
        public function obtenerDatosGraficos() {



            $dashboardObj = new DashboardModel();

            $fechaInicio = isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : date('Y-m-d');
            $fechaFin = isset($_POST['fechaFin']) ? $_POST['fechaFin'] : date('Y-m-d');

            // Obtener los productos más vendidos
            $productosMasVendidos = $dashboardObj->getProductosMasVendidos($fechaInicio, $fechaFin);

            // Obtener las ventas por categoría
            // $ventasPorCategoria = $dashboardObj->getVentasPorCategoria($fechaInicio, $fechaFin);

            // Devolver los datos en formato JSON
            echo json_encode([
                'productosMasVendidos' => $productosMasVendidos,
                // 'ventasPorCategoria' => $ventasPorCategoria
            ]);
        }
    }
?>