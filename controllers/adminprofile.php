<?php 

    class AdminProfile extends SessionController { 

        function __construct()
        {
            parent::__construct();
        }


        function render() { 
            // $stats = $this->getStatistics();

            $this->view->render('admin/editarPerfil', []);
        }
    }
?>