<?php

class Mesero extends SessionController
{
    private $user;
    private $mesa;
     
    function __construct()
    {
            
        parent::__construct();
        $this->user = $this->getDatosUsuarioSession();
       
    }


    function render()
    {
        // creamos un objeto de categorias para traer las categorias
        $categoriaObj = new CategoriasModel();
        $categorias = $categoriaObj->consultarTodos();
        $this->view->render('mesero/index', [
            'user' => $this->user, 'mesa'=>$this->mesa, 'categorias'=>$categorias
        ]);
    }


    // abrirMesa nos permite abrir una mesa para generar un pedido desde la interfaz del mesero
    function abrirMesa()
    {
        error_log('Mesas::abrirMesa -> Funcion para abrir una mesa y actualizar el estado');
        // validamos la data que viene del formulario, en este caso la negamos para el primer caso
        if (!$this->existPOST(['estado', 'numeroMesa'])) {
            // Redirigimos otravez al dashboard
            error_log('Mesas::abrirMesa -> Hay algun error en los parametros enviados en el formulario');

            // enviamos la respuesta al front para que muestre una alerta con el mensaje
            echo json_encode(['status' => false, 'message' => ErrorsMessages::ERROR_ADMIN_NEWDATAUSER_EMPTY]);
            return;
        }
        if ($this->user == NULL) {
            error_log('Mesas::abrirMesa -> El usuario de la session esta vacio');
            // enviamos la respuesta al front para que muestre una alerta con el mensaje
            echo json_encode(['status' => false, 'message' => ErrorsMessages::ERROR_ADMIN_NEWDATAUSER]);
            return;
        }
        // si no entra a niguna validacion, significa que la data y el usuario estan correctos
        error_log('Mesas::abrirMesa -> Es posible actualizar el estado de la mesa');


        // creamos un objeto de mesa para guardar la data en los atributos y ejecutar el metodo 
        $mesaObj = new MesasModel();
        // guardamos el objeto que retorna al momento de la consulta para devolverlo a la vista.
        $this->mesa = $mesaObj->consultar($this->getPost('numeroMesa'));
        error_log('Valor de mesa: ' . print_r($this->mesa, true));
        error_log('Numero de mesa para mostrarla en el fronttttttttttttttttttttttttttttt'.$this->getPost('numeroMesa'));
        $mesaObj->setEstado($this->getPost("estado"));
        error_log('mesaaaaaaaaaaaaaaaaaaa ' . $this->getPost('numeroMesa'));
        if ($mesaObj->actualizarEstado($this->getPost('numeroMesa'))) {
            error_log('Mesas::abrirMesa -> Se actualizo el estado de la mesa correctamente');
            echo json_encode(['status' => true, 'dataMesa' => $this->mesa, 'message' => "Se abrio la mesa correctamente!"]);
            return;
        } else {
            error_log('Mesas::abrirMesa -> No se actualizo la mesa!');
            echo json_encode(['status' => false, 'message' => "Hubo un problema al agregar usuario, intentalo nuevamente"]);
            return;
        }
    }

    
}
