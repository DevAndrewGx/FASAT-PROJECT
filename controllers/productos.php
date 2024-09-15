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
        // creamos un objeto de categorias para traer las categorias
        $categoriaObj = new CategoriasModel();
        $categories = $categoriaObj->getAll();
        $subCategories = $categoriaObj->getSubCategoriesByCategory($this->getPost('categoria'));
        error_log($this->getPost('categoria'));
        error_log('Producto::render -> Carga la pagina principal');
        $this->view->render('admin/gestionInventario', ['categories' => $categories, 'subcategories' => $subCategories]);
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
        $productoObject->setIdSubcategoria($this->getPost('subcategoria'));
        $productoObject->setPrecio($this->getPost('precio'));
        $productoObject->setNombre($this->getPost('descripcion'));
        $productoObject->setNombre($this->getPost('disponibilidad'));


        // creamos un objeto de categorias para asignar la subcategoria si es que tiene al objeto
        $categoriaObject = new CategoriasModel();

        // verificamos si se pudo insertar data dentro la bd
        if($productoObject->save()) {

                // if() { 

                // }
            error_log('Productos::createProduct -> Se guardó un producto correctamente dentro de la bd');
            echo json_encode(['status' => true, 'message' => "El producto fue creado exitosamente!"]);
            return;
        }else {
            error_log('Productos::createProduct -> No se guardó el producto correctamente');
            echo json_encode(['status' => false, 'message' => "Hubo un problema al agregar producto, intentalo nuevamente"]);
            return;
        }
    }

    function getSubcategoriesByCategory()
    {
        error_log('its here');
        // Verificamos si existe el POST 'categoria'
        if ($this->existPOST('categoria')) {
            error_log('categoria'.$this->getPost('categoria'));
            // Creamos un nuevo objeto de la clase CategoriasModel
            $categoryObj = new CategoriasModel();

            // Obtenemos las subcategorías relacionadas a la categoría recibida
            $subcategories = $categoryObj->getSubCategoriesByCategory($this->getPost('categoria'));
            // Devolvemos el resultado en formato JSON
            echo json_encode(["data"=>$subcategories]);
            return;
        } else {
            // Devolvemos una respuesta en caso de que no exista 'categoria' en el POST
            echo json_encode(['error' => 'Categoría no proporcionada']);
        }
    }

}
