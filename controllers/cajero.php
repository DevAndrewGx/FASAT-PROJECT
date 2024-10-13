<?php
class Cajero extends SessionController
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
        $this->view->render('cajero/index', [
            'user' => $this->user
        ]);
    }
}
?>