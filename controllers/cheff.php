<?php
class Cheff extends Controller
{

    function __construct()
    {
        parent::__construct();
    }


    function render()
    {
        // $stats = $this->getStatistics();
        $this->view->render('cheff/index', []);
    }
}
