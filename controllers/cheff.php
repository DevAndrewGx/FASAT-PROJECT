<?php
class Cheff extends SessionController
{
    private $user;
    function __construct()
    {
        parent::__construct();
        $this->user = $this->getUserSessionData();
    }


    function render()
    {

        // $stats = $this->getStatistics();
        $this->view->render('cheff/index', [
            "user"=>$this->user
        ]);
    }
}
