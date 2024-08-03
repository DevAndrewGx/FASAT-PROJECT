
<?php 

    // Todos los modelos heredan de la clase model y implementar la interfaz IModel la cual nos permitira hacer el crud.
    class ProductoModel extends Model {


        // creamos los atributos de la clase

        private $id_producto;
        private $id_foto;
        private $id_stock;
        private $id_provedor;
        private $id_categoria;
        private $precio;
        private $tipo;
        private $nombre;
        private $unidad_medida;
        
    
    }
?>