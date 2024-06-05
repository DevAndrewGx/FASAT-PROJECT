<?php 
    class Landing extends Controller { 


        public function _construct() {
            parent::__construct();
        }

        // renderizamos el home
        function render() {
            $this->view->render('landing/index');
        }
        
    }
?>