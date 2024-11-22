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

            // Verifica que los campos clave existan en el array $pedido
            if (!$this->existKeys($pedido, ['codigoPedido',
                'fechaHora',
                'numeroMesa',
                'idMesero',
                'numeroPersonas',
                'notasPedido',
                'total'
            ])) {
                echo json_encode(['status' => false, 'message' => "Faltan datos obligatorios en el pedido."]);
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


            $pedidoObj->setCodigoPedido($pedido["codigoPedido"]);
            $pedidoObj->setIdMesa($pedido["numeroMesa"]);
            $pedidoObj->setIdMesero($pedido["idMesero"]);
            $pedidoObj->setPersonas($pedido["numeroPersonas"]);
            $pedidoObj->setNotasPedido($pedido["notasPedido"]);
            $pedidoObj->setFechaHora($pedido["fechaHora"]);
            $pedidoObj->setTotal($pedido["total"]);


            // ejecutamos la consulta y guardamos el id del pedido insertado en una variable 
            if($idPedido = $pedidoObj->crear()) {
                error_log('Pedidos::crearPedido -> Se creo el pedido correctamente');
                // despues de realizar la validación ejecutamos un for para recorrer los productos del pedido y insertarlos en la bd
                // creamos un array para guardar los productos del pedido
                $productos = $pedido['pedidoProductos'];
                foreach($productos as $producto) { 
                    $this->guardarProductoPedido($idPedido, $producto['idProducto'], $producto['cantidad'], $producto['precio'], $producto['notas']);
                }
                error_log('Pedidos::crearPedido -> Se guardo el producto correctamente en la bd');
                echo json_encode(['status' => true, 'message' => "Pedido creado Exitosamente!"]);
                return;
            }else {
                error_log('Pedidos::crearPedido -> No se guardo el pedido, hay algo raro en la consulta bro');
                echo json_encode(['status' => false, 'message' => "Intentelo nuevamente, error 500!"]);
                return;
            }
            
        }

        // creamos una funcion aparte para guardar la data relacionada de productos y pedidos

        function guardarProductoPedido($pedidoId, $productoId, $cantidad, $precio, $notas) {
            // validamos que la data que venga del formulario exista
            error_log('Pedidos::crearPedido -> Funcion para crear nuevos pedidos');

            if (!isset($pedidoId) || !isset($productoId) || !isset($cantidad) || !isset($precio) || !isset($notas)) {
                error_log('Pedidos::crearPedido -> Hay algun error en los parametros recibiidos');

                // enviamos la respuesta al front para que muestre una alerta con el mensaje
                echo json_encode(['status' => false, 'message' => "Los datos que vienen del formulario estan vacios"]);
            return;
            }

            // creamos un nuevo objeto de pedidosProductos
            $productosPedidoObj = new PedidosProductosModel();

            // asignamos los datos al objeto
            $productosPedidoObj->setIdPedido($pedidoId);
            $productosPedidoObj->setIdProducto($productoId);
            $productosPedidoObj->setCantidad($cantidad);
            $productosPedidoObj->setPrecio($precio);
            $productosPedidoObj->setNotasProducto($notas);

            if($productosPedidoObj->crear()) {
                error_log('Pedidos::crearPedido -> se guardo el producto en la tabla pedidosProductos OMGG!!!!!!');
            }else {
                error_log('Pedidos::crearPedido -> No se guardo el producto en la tabla pedidosProductos OMGG!!!!!!');
            }
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