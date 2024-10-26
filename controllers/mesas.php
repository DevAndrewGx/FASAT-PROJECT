<?php
class Mesas extends SessionController
{

    private $user;

    function __construct()
    {
        parent::__construct();
        // obtenemos el usuario de la session
        $this->user = $this->getDatosUsuarioSession();
        error_log('Mesas::construct -> controlador usuarios');
    }

    function render()
    {
        error_log('Mesas::render -> Carga la pagina principal de las mesas');
        $this->view->render('admin/gestionMesas', [
            'user' => $this->user
        ]);
    }


    // funcion para crear una mesa
    function createTable()
    {

        error_log("Mesas::createTable -> Funcion para crear una mesa");

        // validamos que la data que venga del formulario no este vacia
        if (!$this->existPOST(['numeroMesa', 'estado'])) {
            error_log("Mesas::createTable -> Hay algun error en los paremetros enviados desde el formulario");

            // en   viamos la respuesta al fronted para mostrar las alertas al usuario
            echo json_encode(["status" => false, "message" => "Los datos enviados del formulario no son correctos"]);
            // salidamos de la validación
            return;
        }

        // validamos que el usuario de la seseión no este vacio
        if ($this->user == NULL) {
            error_log("Mesas::createTable -> El usuario de la sesión esta vacio");

            // enviamos la respuesta al front para que muestre la alerta con el mensaje
            echo json_encode(["status" => false, "message" => "El usuario de la sesión no esta autorizado"]);
            return;
        }

        // si no entra en ninguna de las validaciones podemos crear una mesa
        error_log("Mesas::createTable -> Es posible crear una mesa");

        // creamos un objeto de mesas
        $mesaModel = new MesasModel();

        // seteamos la data en el objeto de mesas
        $mesaModel->setNumeroMesa($this->getPost("numeroMesa"));
        $mesaModel->setEstado($this->getPost("estado"));

        // validamos y guardamos la data de la consulta
        if ($mesaModel->crear()) {
            error_log('Mesas::createTale -> Se guardó la mesa correctamente');
            echo json_encode(['status' => true, 'message' => "La mesa fue creada exitosamente!"]);
            return;
        } else {
            error_log('Mesas::createTable -> No se guardo la data de la mesa');
            echo json_encode(['status' => false, 'message' => "Hubo un problema al agregar mesa, intentalo nuevamente"]);
            return;
        }
    }

    function getMesas()
    {
        try {
            // Obtener los parámetros enviados por DataTables
            $draw = intval($_GET['draw']);
            $start = intval($_GET['start']);
            $length = isset($_GET['length']) ? (int) $_GET['length'] : 10;
            $search = $_GET['search']['value'];
            $orderColumnIndex = intval($_GET['order'][0]['column']);
            $orderDir = $_GET['order'][0]['dir'];
            $columns = $_GET['columns'];
            $orderColumnName = $columns[$orderColumnIndex]['data'];

            //creamos un objeto del modelocategorias

            $mesaObj = new MesasModel();

            //Obtenemos los datos filtrados
            $mesasData = $mesaObj->cargarDatosMesas($length, $start, $orderColumnIndex, $orderDir, $search, $orderColumnName);

            $totalFiltered = $mesaObj->totalRegistrosFiltrados($search);

            $totalRecords = $mesaObj->totalRegistros();

            $arrayDataMesas = json_decode(json_encode($mesasData, JSON_UNESCAPED_UNICODE), true);
            // print_r($arrayDataCategories);
            // error_log("Array: ".print_r($categoriasData));

            // Iterar sobre el arreglo y agregar 'options' a cada usuario
            for ($i = 0; $i < count($arrayDataMesas); $i++) {
                $arrayDataMesas[$i]['checkmarks'] = '<label class="checkboxs"><input type="checkbox"><span class="checkmarks"></span></label>';
                $arrayDataMesas[$i]['options'] = '
                <a class="me-3 confirm-text" href="#" data-id="' . $arrayDataMesas[$i]['id_categoria'] . '"  data-id-s="' . $arrayDataMesas[$i]['id_sub_categoria'] . '" >
                    <img src="' . constant("URL") . '/public/imgs/icons/eye.svg" alt="eye">
                </a>
                <a class="me-3 botonActualizar" data-nombre="' . $arrayDataMesas[$i]['nombre_categoria'] . '" data-id="' . $arrayDataMesas[$i]['id_categoria'] . '"  data-id-s="' . $arrayDataMesas[$i]['id_sub_categoria'] . '" href="#">
                    <img src="' . constant("URL") . '/public/imgs/icons/edit.svg" alt="eye">
                </a>
                <a class="me-3 confirm-text botonEliminar" data-id="' . $arrayDataMesas[$i]['id_categoria'] . '"  data-id-s="' . $arrayDataMesas[$i]['id_sub_categoria'] . '" href="#">
                    <img src="' . constant("URL") . '/public/imgs/icons/trash.svg" alt="trash">
                </a>
            ';
            }

            // retornamos la data en un arreglo asociativo con la data filtrada y asociada
            $response = [
                "draw" => $draw,
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalFiltered,
                "data" => $arrayDataMesas,
                "status" => true
            ];
            // devolvemos la data y terminamos el proceso
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            die();
        } catch (Exception $e) {
            error_log('Mesas::getMesas -> Error en traer los datos - getMesas' . $e->getMessage());
        }
    }

    function getTablasPorEstado()
    {
        // validamos que la data enviada exista
        if ($this->existPOST("estado")) {
            error_log("Estado " . $this->getPost('estado'));

            // creamos un objeto de la clase mesas
            $mesaObj = new MesasModel();

            $mesas = $mesaObj->getTablasPorEstado($this->getPost('estado'));

            echo json_encode(["data" => $mesas]);
            return;
        }
    }
}
