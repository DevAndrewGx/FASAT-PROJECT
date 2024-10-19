<?php

class Mesero extends SessionController
{
    private $user;
    function __construct()
    {
        
        parent::__construct();
        $this->user = $this->getUserSessionData();
        // creamos una instancia de mesas
        $mesasObj = new MesasModel();
        // traemos las mesas que estan disponibles 
        $mesasObj->getTablesByState($this->getPost('estado'));
    }


    function render()
    {
        // $stats = $this->getStatistics();

        $this->view->render('mesero/index', [
            'user' => $this->user
        ]);
    }
}
