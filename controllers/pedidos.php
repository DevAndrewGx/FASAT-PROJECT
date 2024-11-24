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
            $pedidoObj->setEstadoPedido("PENDIENTE");
            $pedidoObj->setFechaHora($pedido["fechaHora"]);
            $pedidoObj->setTotal($pedido["total"]);

            // creamos un objeto de mesas ya que necesitamos cambiar el estado de la mesa cuando se ocupa
            $mesaObj = new MesasModel();
            // guardamos el objeto que retorna al momento de la consulta para devolverlo a la vista.
            $mesaObj->consultar($pedido['numeroMesa']);
            $mesaObj->setEstado("EN VENTA");
            error_log("Pedidos::CrearPedido -> numero mesa -> ".$pedido['numeroMesa']);
            // actualizamos el estado de la mesa cuando se crea un pedido para no mostrarla en la vista del mesero
            if($mesaObj->actualizarEstado($pedido["numeroMesa"])) {
                error_log("Pedidos::crearPedio -> Se actualizo el estado de la mesa correctamente");
                // ejecutamos la consulta y guardamos el id del pedido insertado en una variable 
                if ($idPedido = $pedidoObj->crear()) {
                    error_log('Pedidos::crearPedido -> Se creo el pedido correctamente');
                    // despues de realizar la validación ejecutamos un for para recorrer los productos del pedido y insertarlos en la bd
                    // creamos un array para guardar los productos del pedido
                    $productos = $pedido['pedidoProductos'];
                    foreach ($productos as $producto) {
                        $this->guardarProductoPedido($idPedido, $producto['idProducto'], $producto['cantidad'], $producto['precio'], $producto['notas']);
                    }
                    error_log('Pedidos::crearPedido -> Se guardo el producto correctamente en la bd');
                    echo json_encode(['status' => true, 'message' => "Pedido creado Exitosamente!"]);
                    return;
                } else {
                    error_log('Pedidos::crearPedido -> No se guardo el pedido, hay algo raro en la consulta bro');
                    echo json_encode(['status' => false, 'message' => "Intentelo nuevamente, error 500!"]);
                    return;
                }
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

        // creamos esta funcion para consultar todos los productos
        function consultarPedidos() { 
            
            // utilizamos para capturar cualquier exepcion y no parar la ejecución del codigo

            try {
                // Obtener los parámetros enviados por DataTables
                $draw = intval($_GET['draw']);
                $start = intval($_GET['start']);
                $length = intval($_GET['length']);
                $search = $_GET['search']['value'];
                $orderColumnIndex = intval($_GET['order'][0]['column']);
                $orderDir = $_GET['order'][0]['dir'];
                $columns = $_GET['columns'];
                $orderColumnName = $columns[$orderColumnIndex]['data'];

                // creamos un objeto del model pedidosJoinModel ya que necesitamos traer la data de ahi porque nos permitir hacer un JOIN con las 
                // tablas principales que conforman a pedidos

                $pedidoObj = new PedidosJoinModel();

                // $obtenemos los datos del modelo para mosrtarlos en el datatable
                $pedidosData = $pedidoObj->cargarDatosPedidos($length, $start, $orderColumnIndex, $orderDir, $search, $orderColumnName);
                // obtenemos el total de los producto filtrados para devolverselo al datatable para mostrarlo
                $totalRegistroFiltrados = $pedidoObj->totalRegistrosFiltrados($search);
                
                $totalRegistros = $pedidoObj->totalRegistros();


                $arrayDataPedidos = json_decode(json_encode($pedidosData, JSON_UNESCAPED_UNICODE), true);

                // Iterar sobre el arreglo y agregar 'options' a cada usuario
                for ($i = 0; $i < count($arrayDataPedidos); $i++) {
                    $arrayDataPedidos[$i]['checkmarks'] = '<label class="checkboxs"><input type="checkbox"><span class="checkmarks"></span></label>';
                    $arrayDataPedidos[$i]['options'] = '
                    <a class="me-3 confirm-text" href="#" data-id="' . $arrayDataPedidos[$i]['id_pinventario'] . '"  >
                        <img src="' . constant("URL") . '/public/imgs/icons/eye.svg" alt="eye">
                    </a>
                    <a class="me-3 botonActualizar" href="#" data-id="' . $arrayDataPedidos[$i]['id_pinventario'] . '"">
                        <img src="' . constant("URL") . '/public/imgs/icons/edit.svg" alt="eye">
                    </a>
                    <a class="me-3 confirm-text botonEliminar" href="#" data-id="' . $arrayDataPedidos[$i]['id_pinventario'] . '">
                        <img src="' . constant("URL") . '/public/imgs/icons/trash.svg" alt="trash">
                    </a>
                ';
                }

                // retornamos la data en un arreglo asociativo con la data filtrada y asociada
                $response = [
                    "draw" => $draw,
                    "recordsTotal" => $totalRegistros,
                    "recordsFiltered" =>$totalRegistroFiltrados,
                    "data" => $arrayDataPedidos,
                    "status" => true
                ];
                // devolvemos la data y terminamos el proceso
                echo json_encode($response, JSON_UNESCAPED_UNICODE);
                die();
            }catch(Exception $e) { 
                error_log("Pedidos::consultarPedidos -> Error en trear los datos - consultarPedidos ".$e->getMessage());
            }
        }


        // esta funcion nos permitira consultar un producto en especifico
        function consultarPedido() {
            // validamos si existe el id enviado desde la petición
            if (!$this->existPOST(['codigoPedido'])) {
                error_log('Pedidos::consultarPedido -> No se obtuvo el codigo del pedido correctamente');
                echo json_encode(['status' => false, 'message' => "Algunos parametros enviados estan vacios, intente nuevamente!"]);
                return false;
            }

            if ($this->user == NULL) {
                error_log('Pedidos::consultarPedido -> El usuario de la session esta vacio');
                // enviamos la respuesta al front para que muestre una alerta con el mensaje
                echo json_encode(['status' => false, 'message' => ErrorsMessages::ERROR_ADMIN_NEWDATAUSER]);
                return;
            }
            // creamos un nuevo objeto de productos
            $pedidoObj = new PedidosJoinModel();
            $res = $pedidoObj->consultar($this->getPost('codigoPedido'));

            $arrayData =  json_decode(json_encode($res, JSON_UNESCAPED_UNICODE), true);

            if ($arrayData) {
                $response = [
                    "data" => $arrayData,
                    "status" => true,
                    "message" => "Se obtuvo la data correctamente"
                ];
                echo json_encode($response, JSON_UNESCAPED_UNICODE);
                die();
            } else {
                error_log('Users::borrarUser -> No se pudo obtener el pedido correctamente');
                echo json_encode(['status' => false, 'message' => "No se pudo obtener el pedido!"]);
                return false;
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