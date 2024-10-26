
<?php
// controlador para cerrar sesion   
class Logout extends SessionController
{

    function __construct()
    {
        parent::__construct();
    }

    public function render()
    {
        $this->cerrarSesion();
        $this->redirect('', []);
    }
}

?>