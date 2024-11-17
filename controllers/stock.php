<?php
    class Stock extends SessionController { 
        

        private $user;


        function __construct()
        {
            parent::__construct();

            $this->user = $this->getDatosUsuarioSession();
            error_log('Producto::construct -> Controlador producto');
        }

        function render()
        {
            error_log('Users::render -> Carga la pagina principal de STOCK');
            $this->view->render('admin/gestionStock', [
                "user" => $this->user
            ]);
        }

        // funcion para cargar los pro  ductos en las datatables
        function getProductsOnStock() { 

            try {
                header('Content-Type: application/json');

                // Verificar si el usuario está autenticado
                if (!$this->existeSession()) {
                    http_response_code(401); // Código de estado HTTP 401: No autorizado
                    echo json_encode(['error' => 'No autenticado']);
                    die();
                }

                // Obtener los parámetros enviados por DataTables
                $draw = intval($_GET['draw']);
                $start = intval($_GET['start']);
                $length = intval($_GET['length']);
                $search = $_GET['search']['value'];
                $orderColumnIndex = intval($_GET['order'][0]['column']);
                $orderDir = $_GET['order'][0]['dir'];
                $columns = $_GET['columns'];
                $orderColumnName = $columns[$orderColumnIndex]['data'];

                $productsOnStockObj = new StockModel();

                $productsData = $productsOnStockObj->cargarDatosProductosEnStock($length, $start, $orderColumnIndex, $orderDir, $search, $orderColumnName);

                // guardamos la data de los filtros de busqueda
                $totalFiltered = $productsOnStockObj->totalRegistrosFiltrados($search);

                // guardamos la data del total de los registros
                $totalRecords = $productsOnStockObj->totalRegistros();

                $arrayProductsOnStock = json_decode(json_encode($productsData, JSON_UNESCAPED_UNICODE), true);

                // iteramos sobre el arreglo y agregamos las opciones de los botones a cada objecto del stock
                for($i = 0; $i<count($arrayProductsOnStock); $i++) {
                    $arrayProductsOnStock[$i]['checkmarks'] = '<label class="checkboxs"><input type="checkbox"><span class="checkmarks"></span></label>';
                    $arrayProductsOnStock[$i]['options'] = '
                    <a class="me-3 confirm-text" href="#" data-id="' . $arrayProductsOnStock[$i]['documento'] . '" >
                        <img src="' . constant("URL") . '/public/imgs/icons/eye.svg" alt="eye">
                    </a>
                    <a class="me-3 botonActualizar" data-id="' . $arrayProductsOnStock[$i]['documento'] . '" data-idfoto="' . $arrayProductsOnStock[$i]['idFoto'] . '" href="editarEmpleado.php">
                        <img src="' . constant("URL") . '/public/imgs/icons/edit.svg" alt="eye">
                    </a>
                    <a class="me-3 confirm-text botonEliminar" data-id="' . $arrayProductsOnStock[$i]['documento'] . '" data-idfoto="' . $arrayProductsOnStock[$i]['idFoto'] . '" href="editarEmpleado.php">
                        <img src="' . constant("URL") . '/public/imgs/icons/trash.svg" alt="trash">
                    </a>
                ';
                }

                // devolvemos la data al front en un arreglo
                $response = [
                    "draw" => $draw,
                    "recordsTotal" => $totalRecords,
                    "recordsFiltered" => $totalFiltered,
                    "data" => $arrayProductsOnStock,
                    "status" => true
                ];

                echo json_encode($response, JSON_UNESCAPED_UNICODE);
            }catch(Exception $e) { 
                error_log("Error en getProductsOnStock: ".$e->getMessage());
                echo json_encode(['error' => $e->getMessage()]);
            }
        }


        // Esta funciion nos permitira actualizar el nivel del stock, si el admin asi lo prefiera
        function actualizarStock() {
            // validamos que la data del formulario no venga vacia
            if (!$this->existPOST(['cantidad'])) {

                error_log('Stock::actualizarMesa -> Hay algunos parametros vacios enviados en el formulario');
                echo json_encode(['status' => false, 'message' => "Algunos datos enviados del formulario estan vacios"]);
                return;
            }

            // validamos que el usuario de la sesión no este vacio
            if ($this->user == NULL) {

                error_log('Stock::actualizarStock -> El usuario de la sesión esta vacio');

                echo json_encode(['status' => false, 'message' => "El usuario de la sesión intenlo nuevamente"]);
                return;
            }

            // si no entra a niguna validacion, significa que la data y el usuarioi estan correctos
            error_log('Stock::actualizarStock -> Es posible actualizar una mesa');

            $stockObj = new StockModel();

            $stockObj->setCantidad($this->getPost('cantidad'));
            $stockObj->setCantidadDisponible($this->getPost('cantidad'));
            $stockObj->setCantidadMinima($this->getPOst('cantidad'));

            // ejecutamos la query para actualizar una categoria
            $res = $stockObj->actualizar($this->getPost('id_stock'));

            // validamos si la consulta se ejecuto correctamente

            if ($res) {
                error_log('Stock::actualizarStock -> Se actualizo la mesa correctamente');
                echo json_encode(['status' => true, 'message' => "El stock fue actualizado exitosamente!"]);
                return;
            } else {
                error_log('Stock::actualizarStock -> Error en la consulta del Back');
                echo json_encode(['status' => false, 'message' => "Error 500, nose actualizo la data!"]);
                return;
            }
        }

    }
?>