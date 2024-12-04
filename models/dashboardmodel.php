<?php 
    // Esta clase nos permitira realizar consultas a la bd para mostrar en los datos y items de analisis en el dashboard del administrador
    class DashboardModel extends model { 
        

        // creamos el constructor para heredar el constructor padre
        public function __construct() { 

            parent::__construct();
        }

        // Funcion para consultar las ventas del dia 
        public function getVentasDelDia($fechaInicio, $fechaFin)
        {
            try {
                $query = $this->prepare("SELECT SUM(pp.cantidad * pp.precio) AS ventasDelDia
                FROM pedidos p
                INNER JOIN pedido_producto pp ON p.id_pedido = pp.id_pedido
                WHERE p.fecha BETWEEN :fechaInicio AND :fechaFin");
                $query->execute([
                    'fechaInicio' => $fechaInicio,
                    'fechaFin' => $fechaFin
                ]);
                $result = $query->fetch(PDO::FETCH_ASSOC);

                return $result['ventasDelDia'] ?? 0;
            } catch (PDOException $e) {
                error_log('DashboardModel::getVentasDelDia -> PDOException ' . $e->getMessage());
                return 0;
            }
    }
        // funcion para consultar las ordenes que tienen estado pendiente
        public function getOrdenesPendientes($fechaInicio, $fechaFin)
        {
            try {
                $query = $this->prepare("SELECT COUNT(*) AS ordenes_pendientes FROM pedidos WHERE estado = 'PENDIENTE' AND fecha BETWEEN :fechaInicio AND :fechaFin");
                $query->execute([
                    'fechaInicio' => $fechaInicio,
                    'fechaFin' => $fechaFin
                ]);
                $result = $query->fetch(PDO::FETCH_ASSOC);

                return $result['ordenes_pendientes'] ?? 0;
            } catch (PDOException $e) {
                error_log('DashboardModel::getOrdenesActivas -> PDOException ' . $e->getMessage());
                return 0;
            }
        }
        // function para consutlar los productos vendidos
        public function getProductosVendidos($fechaInicio, $fechaFin)
        {
            try {
                $query = $this->prepare("SELECT SUM(pp.cantidad) AS productos_vendidos FROM pedidos p INNER JOIN pedido_producto pp ON p.id_pedido = pp.id_pedido WHERE p.fecha BETWEEN :fechaInicio AND :fechaFin");
                $query->execute([
                    'fechaInicio' => $fechaInicio,
                    'fechaFin' => $fechaFin
                ]);
                $result = $query->fetch(PDO::FETCH_ASSOC);

                return $result['productos_vendidos'] ?? 0;
            } catch (PDOException $e) {
                error_log('DashboardModel::getProductosVendidos -> PDOException ' . $e->getMessage());
                return 0;
            }
        }
        // funcion para consultar lo estados de las alertas
        public function getAlertasStock()
        {
            try {
                $query = $this->prepare("SELECT COUNT(*) AS alertas_stock FROM productos WHERE stock <= 5");
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);

                return $result['alertas_stock'] ?? 0;
            } catch (PDOException $e) {
                error_log('DashboardModel::getAlertasStock -> PDOException ' . $e->getMessage());
                return 0;
            }
        }
    }
?>