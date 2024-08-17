<?php

class Productos extends SessionController
{

    private $user;

    function __construct()
    {
        parent::__construct();

        $this->user = $this->getUserSessionData();
        error_log('Producto::construct -> Controlador producto');
    }


    function render()
    {
        error_log('Producto::render -> Carga la pagina principal ');
        $this->view->render('admin/gestionInventario', []);
    }

    // creamos la funcion que nos permitira crear nuevos productos
    function createProduct()
    {
        // primero validamos si la data viene correctamente desde el formulario
        error_log('Productos::createProduct -> Funcion para crear nuevos productos');

        if (!$this->existPOST(['nombreProducto', 'categoria', 'subcategoria', 'precio', 'descripcion','disponibilidad'])) {
            error_log('Users::createUser -> Hay algun error en los parametros enviados en el formulario');

            // enviamos la respuesta al front para que muestre una alerta con el mensaje
            echo json_encode(['status' => false, 'message' => "Los datos que vienen del formulario estan vacios"]);
            return;
        }


        if ($this->user == NULL) {
            error_log('Users::createUser -> El usuario de la session esta vacio');
            // enviamos la respuesta al front para que muestre una alerta con el mensaje
            echo json_encode(['status' => false, 'message' => ErrorsMessages::ERROR_ADMIN_NEWDATAUSER]);
            return;
        }

        // si no entra a niguna validacion, significa que la data y el usuario estan correctos
        error_log('CreateProduct:: -> Es posible crear un nuevo producto');

        $productoObject = new ProductosModel();
        
        // asignamos los datos traidos del formulario a el objeto
        $productoObject->setNombre($this->getPost('nombreProducto'));
        $productoObject->setIdCategoria($this->getPost('categoria'));
        $productoObject->set($this->getPost('subcategoria'));
        $productoObject->setPrecio($this->getPost('precio'));
        $productoObject->setNombre($this->getPost('descripcion'));
        $productoObject->setNombre($this->getPost('disponibilidad'));

        // verificamos si se pudo insertar data dentro la bd
        if($productoObject->save()) {
            error_log('Productos::createProduct -> Se guardó un producto correctamente dentro de la bd');
            echo json_encode(['status' => true, 'message' => "El producto fue creado exitosamente!"]);
            return;
        }else {
            error_log('Productos::createProduct -> No se guardó el producto correctamente');
            echo json_encode(['status' => false, 'message' => "Hubo un problema al agregar producto, intentalo nuevamente"]);
            return;
        }
    }
}
