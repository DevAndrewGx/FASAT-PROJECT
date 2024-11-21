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
            // decodificamos la data que viene del formulario para manipularla en el contralador
            $pedido = json_decode($_POST['pedido'], true);
            // validamos que la data que venga del formulario exista

            error_log('Pedidos::crearPedido -> Funcion para crear nuevos pedidos');

            if (!$this->existPOST([$pedido['codigo'], $pedido['fechaHora'], $pedido['numeroMesa'], $pedido["idMesero"], $pedido['numeroPersonas'], $pedido['notasPedido'], $pedido['total']])) {
                error_log('Pedidos::crearPedido -> Hay algun error en los parametros enviados en el formulario');

                // enviamos la respuesta al front para que muestre una alerta con el mensaje
                echo json_encode(['status' => false, 'message' => "Los datos que vienen del formulario estan vacios"]);
                return;
            }

            if ($this->user == NULL) {
                error_log('Pedidos::crearPedio -> El usuario de la sesion esta vacio');
                // enviamos la respuesta al front para que muestre una alerta con el mensaje
                echo json_encode(['status' => false, 'message' => ErrorsMessages::ERROR_ADMIN_NEWDATAUSER]);
                return;
            }

            // si no entra a niguna validacion, significa que la data y el usuario estan correctos
            error_log('Pedidos::CrearPedido -> Es posible crear un nuevo pedido');

            $pedidoObj = new PedidosModel();


            $pedidoObj->setCodigoPedido($this->getPost($pedido["codigo"]));
            $pedidoObj->setIdMesa($this->getPost($pedido["numeroMesa"]));
            $pedidoObj->setIdMesero($this->getPost($pedido["idMesero"]));
            $pedidoObj->setPersonas($this->getPost($pedido["numeroPersonas"]));
            $pedidoObj->setNotasPedido($this->getPost($pedido["notasPedido"]));
            $pedidoObj->setTotal($this->getPost($pedido["total"]));
            
        }

        // creamos una funcion aparte para guardar la data relacionada de productos y pedidos
        

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
                return;
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