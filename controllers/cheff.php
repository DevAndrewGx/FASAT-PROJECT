<?php
class Cheff extends SessionController
{
    private $user;
    function __construct()
    {
        parent::__construct();
        $this->user = $this->getDatosUsuarioSession();
    }


    function render()
    {

        // $stats = $this->getStatistics();
        $this->view->render('cheff/index', [
            "user"=>$this->user
        ]);
    }


    // utilizamos esta funcion para consultar todos los pedidos y mostrarlos en la vista del cheff
    function consultarPedidosCheff() {
        // creamos un arreglo para guardar la data y devolver al fronted
        $res = [];

        $pedidoObj = new PedidosJoinModel();

        $res = $pedidoObj->consultarPedidosCheff();

        if($res) {
            error_log('Cheff::consultarPedidoCheff  -> La data de los pedidos fueron recuperados exitosamente');
            echo json_encode(['status' => true, 'data'=>$res, 'message' => "Se recuperan los datos correctamente"]);
            return true;
        }else {
            error_log('Cheff::consultarPedidoCheff  -> La data de los pedidos no se pudo recuperar correctamente, intentalo nuevamente!');
            echo json_encode(['status' => false, 'message' => "La data de los pedidos no se pudo recuperar correctamente, intentalo nuevamente!'"]);
        }
        
    }
}
