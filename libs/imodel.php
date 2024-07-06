<?php 
    // esta interfaz nos va permitir definir los metodos basicos del crud para extenderlos a sus respectivos controladores 
    // para hacer polimorfismo en los modelos 
    interface IModel { 


        public function save();
        public function getAll();
        public function get($id);
        public function delete($id);
        public function update($id);
        public function from($array);
    
    }
?>