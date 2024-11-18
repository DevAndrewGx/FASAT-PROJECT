<?php
    // Esta clase nos permitira crear la logica para la gestion de los pedidos y demasf
    class Pedidos extends SessionController {

        private $user;

        function __construct()
        {
            // llamamos al constructor del padre
            parent::__construct();
            // asingamos la data del usuario logeado
            $this->user = $this->getDatosUsuarioSession();
        }

        // creamos la funcion para crear un nuevo pedido
        function crearPedido() {

        }

        // function para realizar el filtro para consultar los productos asociados a una categoria
        function getProductsByCategory()
        {
            // Verificamos si existe el POST 'categoria'
            if ($this->existPOST('categoria')) {
                error_log('categoria' . $this->getPost('categoria'));
                // Creamos un nuevo objeto de la clase CategoriasModel
                $productoObj = new ProductosModel();

                // Obtenemos los productos relacionadas a la categoría recibida
                $productos = $productoObj->getProductsByCategory($this->getPost('categoria'));
                // Devolvemos el resultado en formato JSON
                echo json_encode(["data" => $productos]);
                return;
            } else {
                // Devolvemos una respuesta en caso de que no exista 'categoria' en el POST
                echo json_encode(['error' => 'Categoría no proporcionada']);
            }
        }

        // funcion para la creación de codigos dinamicos para los pedidos
        function crearCodigoPedido() {

            //    validamos que sea metodo GET y crearCodigoPedido
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {

                //Llamamos al metodo data para crear la fecha en la que se va crear el pedido, ademas establecemos la zona horaria porque el servidor esta  configurado de otra forma, la cual no no muestra la hora que es.

                date_default_timezone_set('Etc/GMT+5');
                $fechaHora = date('d/m/Y h:i:s A'); 

                // creamos un objeto de pedidos
                $pedidoObj = new PedidosModel();
                $codigo = $pedidoObj->generarCodigoPedido();
                // devolvemos el codigo generado en formato JSON para utilizarlo y mostrarlo en el frontend
                echo json_encode(['codigo' => $codigo, 'fecha'=>$fechaHora]);
            }
        }
    }
?>