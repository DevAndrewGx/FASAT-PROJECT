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
    // getMesas nos permite traer y realizar el filtrado de las mesas para mostrarlas en el datatable
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
                <a class="me-3 confirm-text" href="#" data-id="' . $arrayDataMesas[$i]['id_mesa'] . '" >
                    <img src="' . constant("URL") . '/public/imgs/icons/eye.svg" alt="eye">
                </a>
                <a class="me-3 botonActualizar" data-id="' . $arrayDataMesas[$i]['id_mesa'] . '"href="#">
                    <img src="' . constant("URL") . '/public/imgs/icons/edit.svg" alt="eye">
                </a>
                <a class="me-3 confirm-text botonEliminar" data-id="' . $arrayDataMesas[$i]['id_mesa'] . '" href="#">
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
    

    // funcion para consultar una mesa especifica
    function consultarMesa() {
        // validamos si existe el id enviado desde la petición
        if(!$this->existPOST(['id_mesa'])) {
            error_log('Mesas::consultarMesa -> No se obtuvo el id de la mesa correctamente');
            echo json_encode(['status' => false, 'message' => "No se pudo eliminar la mesa, intente nuevamente!"]);
            return false;
        }

        if ($this->user == NULL) {
            error_log('Users::createUser -> El usuario de la session esta vacio');
            // enviamos la respuesta al front para que muestre una alerta con el mensaje
            echo json_encode(['status' => false, 'message' => ErrorsMessages::ERROR_ADMIN_NEWDATAUSER]);
            return;
        }

        $res = $this->model->consultar($this->getPost('id_mesa'));

        $arrayData =  json_decode(json_encode($res, JSON_UNESCAPED_UNICODE), true);

        if ($arrayData) {
            error_log('Mesa::consultarMesa -> La mesa se obtuvo correctamente-> ' . $res);
            $response = [
                "data" => $arrayData,
                "status" => true,
                "message" => "Se obtuvo la data correctamente"
            ];
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            die();
        } else {
            error_log('Users::borrarUser -> No se pudo obtener el usuario correctamente');
            echo json_encode(['status' => false, 'message' => "No se pudo obtener el usuario!"]);
            return false;
        }
    }

    function actualizarMesa() { 
        
        // validamos que la data del formulario no venga vacia
        if(!$this->existPOST(['numeroMesa', 'estado'])) {

            error_log('MesaModal::actualizarMesa -> Hay algunos parametros vacios enviados en el formulario');
            echo json_encode(['status' => false, 'message' => "Algunos datos enviados del formulario estan vacios"]);
            return;
        }

        // validamos que el usuario de la sesión no este vacio
        if ($this->user == NULL) {

            error_log('MesaModal::actualizarMesa -> El usuario de la sesión esta vacio');

            echo json_encode(['status' => false, 'message' => "El usuario de la sesión intenlo nuevamente"]);
            return;
        }

        // si no entra a niguna validacion, significa que la data y el usuarioi estan correctos
        error_log('MesaModal::actualizarMesa -> Es posible actualizar una mesa');

        $mesaObj = new MesasModel();

        $mesaObj->setNumeroMesa($this->getPost('numeroMesa'));
        $mesaObj->setEstado($this->getPost('estado'));

        // ejecutamos la query para actualizar una categoria
        $res = $mesaObj->actualizar($this->getPost('id_mesa'));

        // validamos si la consulta se ejecuto correctamente

        if ($res) {
            error_log('MesaModal::actualizarMesa -> Se actualizo la mesa correctamente');
            echo json_encode(['status' => true, 'message' => "La mesa fue actualizada exitosamente!"]);
            return;
        } else {
            error_log('MesaModal::actualizarMesa -> Error en la consulta del Back');
            echo json_encode(['status' => false, 'message' => "Error 500, nose actualizo la data!"]);
            return;
        }

    }

    // funcion para elimiinar una mesa desde la interfaz del admin
    function borrarMesa() {
        // validamos si existe el id enviado desde la petición
        error_log("id_mesa:   ".$this->getPost('id_mesa'));
        if (!$this->existPOST(['id_mesa'])) {
            error_log('Mesas::borrarMesa -> No se obtuvo el id de la mesa correctamente');
            echo json_encode(['status' => false, 'message' => "No se pudo eliminar la mesa, intente nuevamente!"]);
            return false;
        }

        if ($this->user == NULL) {
            error_log('Mesas::borrarMesa  -> El usuario de la session esta vacio');
            // enviamos la respuesta al front para que muestre una alerta con el mensaje
            echo json_encode(['status' => false, 'message' => "El usuario de la sessión esta vacio"]);
            return;
        }
        // guardamos la ejecución de la query en res
        $res = $this->model->borrar($this->getPost('id_mesa'));

        if ($res) {
            error_log('Mesas::borrarMesa  -> Se eliminó la mesa correctamente');
            echo json_encode(['status' => true, 'message' => "La mesa fue eliminada exitosamente!"]);
            return true;
        } else {
            error_log('Mesas::borrarMesa  -> No se pudo eliminar la subcategoria, intente nuevamente');
            echo json_encode(['status' => false, 'message' => "No se pudo eliminar la mesa, intente nuevamente!"]);
            return false;
        }
    }
    

    // getTablasPorEstado nos permite traer la mesas dependiendo del estado 'DISPONIBLE', 'VENTA', 'CERRADA'
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
