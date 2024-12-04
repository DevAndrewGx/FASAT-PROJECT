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


        // funcion para obtener los prodcutos mas vendidos para mostralos en los graficos
        public function getProductosMasVendidos($fechaFin, $fechaInicio) {
            // utilizamos try catch ya que vamos a interactuar con la bd 
            try { 
                $query = $this->prepare("SELECT p.nombre, SUM(v.total) AS total_vendido
                        FROM pedido_producto pp INNER JOIN productos_inventario p ON p.id_pinventario = pp.id_producto 
                        JOIN VENTAS v ON v.id_pedido = pp.id_pedido
                        WHERE v.fecha BETWEEN :inicio AND :fin
                        GROUP BY p.nombre
                        ORDER BY total_vendido DESC
                        LIMIT 10");

                $query->execute([
                    'inicio' => $fechaInicio,
                    'fin' => $fechaFin
                ]);
                // retornamos todos los objetos que coinciden con la consulta
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }catch(PDOException $e) {
                error_log('DashboardModel::getProductosMasVendidos -> PDOException ' . $e->getMessage());
                return 0;
            }
        }

        public function getCategoriasMasVendidas($fechaInicio, $fechaFin)
        {
            try {
                $query = $this->prepare("SELECT c.nombre_categoria, SUM(v.total) AS total_vendido
                                        FROM categorias c
                                        JOIN productos_inventario p ON c.id_categoria = p.id_categoria
                                        JOIN pedido_producto pp ON p.id_pinventario = pp.id_producto
                                        JOIN ventas v ON pp.id_pedido = v.id_pedido
                                        WHERE v.fecha BETWEEN :inicio AND :fin
                                        GROUP BY c.nombre_categoria
                                        ORDER BY total_vendido DESC
                                        LIMIT 10");

                // Ejecutar la consulta con los parámetros
                $query->execute([
                    'inicio' => $fechaInicio,
                    'fin' => $fechaFin
                ]);

                // Retornar los resultados como un arreglo asociativo
                return $query->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log('DashboardModel::getCategoriasMasVendidas -> PDOException ' . $e->getMessage());
                return [];
            }
        }

    }
?>