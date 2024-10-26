<?php
// esta interfaz nos va permitir definir los metodos basicos del crud para extenderlos a sus respectivos controladores 
// para hacer polimorfismo en los modelos 
interface IModel
{


    public function crear();
    public function consultarTodos();
    public function consultar($id);
    public function borrar($id);
    public function actualizar($id);
    public function asignarDatosArray($array);
}
?>