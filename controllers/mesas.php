<?php 
    class Mesas extends SessionController { 

        private $user;

        function __construct()
        {
            parent::__construct();
            // obtenemos el usuario de la session
            $this->user = $this->getUserSessionData();
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
        function createTable() { 
            
            error_log("Mesas::createTable -> Funcion para crear una mesa");

            // validamos que la data que venga del formulario no este vacia
            if(!$this->existPOST(['numeroMesa', 'estado'])) {
                error_log("Mesas::createTable -> Hay algun error en los paremetros enviados desde el formulario");

                // en   viamos la respuesta al fronted para mostrar las alertas al usuario
                echo json_encode(["status"=>false, "message"=>"Los datos enviados del formulario no son correctos"]);
                // salidamos de la validación
                return;
            }

            // validamos que el usuario de la seseión no este vacio
            if($this->user == NULL) {
                error_log("Mesas::createTable -> El usuario de la sesión esta vacio");

                // enviamos la respuesta al front para que muestre la alerta con el mensaje
                echo json_encode(["status"=>false, "message" => "El usuario de la sesión no esta autorizado"]);
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
            if($mesaModel->save()) {
                error_log('Mesas::createTale -> Se guardó la mesa correctamente');
                echo json_encode(['status' => true, 'message' => "La mesa fue creada exitosamente!"]);
                return;
            }else {
                error_log('Mesas::createTable -> No se guardo la data de la mesa');
                echo json_encode(['status' => false, 'message' => "Hubo un problema al agregar mesa, intentalo nuevamente"]);
                return;
            }

        }
    }
?>