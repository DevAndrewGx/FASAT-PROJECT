<?php
    // Esta clase nos permitira crear la logica para la gestion de los pedidos y demasf
    class Pedidos extends SessionController {

        private $user;

        function __construct()
        {
            // llamamos al constructor del padre
            parent::__construct();
            // asingamos la data del usuario logeado
            $this->user = $this->getDatosUsuarioSession();
        }

        // creamos la funcion para crear un nuevo pedido
        function crearPedido() {

        }

        // funcion para generar codigos en cada nuevo pedido que se cree
    }
?>