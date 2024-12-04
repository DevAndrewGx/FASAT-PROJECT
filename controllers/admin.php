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

    // creamos la funcion para obtener la data del backend para mostrarla en los items de analisis
    // function obtenerDatosDashboard($filtro) {
        
    //     $fechaInicio = null;
    //     $fechaFin = null;

    //     // Calcular fechas en base al filtro si existe
    //     if ($filtro) {
    //         switch ($filtro) {
    //             case 'hoy':
    //                 $fechaInicio = date('Y-m-d 00:00:00');
    //                 $fechaFin = date('Y-m-d 23:59:59');
    //                 break;
    //             case 'semana':
    //                 $fechaInicio = date('Y-m-d 00:00:00', strtotime('-7 days'));
    //                 $fechaFin = date('Y-m-d 23:59:59');
    //                 break;
    //             case 'mes':
    //                 $fechaInicio = date('Y-m-d 00:00:00', strtotime('-30 days'));
    //                 $fechaFin = date('Y-m-d 23:59:59');
    //                 break;
    //         }
    //     }

    //     // Si no se pasan fechas (ni filtro), usar rango del día actual
    //     if (!$fechaInicio || !$fechaFin) {
    //         $fechaInicio = date('Y-m-d 00:00:00');
    //         $fechaFin = date('Y-m-d 23:59:59');
    //     }

    //     // finalmente retornamos la data de las fechas 

    //     $data = [
    //     'ventasDelDia' => $dashboardObj->getVentasDelDia($fechaInicio, $fechaFin),
    //         // 'ordenes_pendientes' => $dashboardObj->getOrdenesPendientes($fechaInicio, $fechaFin),
    //         // 'productos_vendidos' => $dashboardObj->getProductosVendidos($fechaInicio, $fechaFin),
    //         // 'alertas_stock' => $dashboardObj->getAlertasStock()
    //     ];


    //     // devolvemos la data en un JSON
    //     echo json_encode($data);
    // }

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
    }
?>