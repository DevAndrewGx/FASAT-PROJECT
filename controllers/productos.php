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
        error_log($this->getPost('categoria'));
        $productoObject->setIdSubcategoria($this->getPost('subcategoria'));
        $productoObject->setPrecio($this->getPost('precio'));
        $productoObject->setDescripcion($this->getPost('descripcion'));
        $productoObject->setDisponibilidad($this->getPost('disponibilidad'));

        // creamos un nuevo objeto para guardar una foto
        $photoObj = new FotoModel();

        $this->createPhoto($photoObj, "productos");
          // verificamos si la consulta de las fotos se ejecuta correctamente
        if ($photoObj->save()) {
            error_log('Users::createUser -> Se guardó la foto correctamente');
            $idPhoto = $photoObj->getIdFoto();
            // error_log('Users::createUser -> idFoto: ' . $photoObj);

            if ($idPhoto) {
                $productoObject->setIdFoto($idPhoto);
                // verificamos si se pudo insertar data dentro la bd
                if ($productoObject->save()) {
                    error_log('Productos::createProduct -> Se guardó un producto correctamente dentro de la bd');
                    echo json_encode(['status' => true, 'message' => "El producto fue creado exitosamente!"]);
                    return;
                } else {
                    error_log('Productos::createProduct -> No se guardó el producto correctamente');
                    echo json_encode(['status' => false, 'message' => "Hubo un problema al agregar producto, intentalo nuevamente"]);
                    return;
                }
            }
        }
        
    }


    // funcion para obtener los productos
    function getProducts() {
        try {
            // Obtener los parámetros enviados por DataTables
            $draw = intval($_GET['draw']);
            $start = intval($_GET['start']);
            $length = intval($_GET['length']);
            $search = $_GET['search']['value'];
            $orderColumnIndex = intval($_GET['order'][0]['column']);
            $orderDir = $_GET['order'][0]['dir'];
            $columns = $_GET['columns'];
            $orderColumnName = $columns[$orderColumnIndex]['data'];


            //creamos un objeto del modelocategorias

            $productosObj = new ProductosModel();

            //Obtenemos los datos filtrados
            $productsData = $productosObj->cargarDatosProductos($length, $start, $orderColumnIndex, $orderDir, $search, $orderColumnName);

            $totalFiltered = $productosObj->totalRegistrosFiltrados($search);

            $totalRecords = $productosObj->totalRegistros();

            $arrayDataProducts = json_decode(json_encode($productsData, JSON_UNESCAPED_UNICODE), true);
            // print_r($arrayDataCategories);
            // error_log("Array: ".print_r($categoriasData));

            // Iterar sobre el arreglo y agregar 'options' a cada usuario
            for ($i = 0; $i < count($arrayDataProducts); $i++) {
                $arrayDataProducts[$i]['checkmarks'] = '<label class="checkboxs"><input type="checkbox"><span class="checkmarks"></span></label>';
                $arrayDataProducts[$i]['options'] = '
                <a class="me-3 confirm-text" href="#" data-id="' . $arrayDataProducts[$i]['id_pinventario'] . '"  >
                    <img src="' . constant("URL") . '/public/imgs/icons/eye.svg" alt="eye">
                </a>
                <a class="me-3 botonActualizar" data-id="' . $arrayDataProducts[$i]['id_pinventario'] . '" >
                    <img src="' . constant("URL") . '/public/imgs/icons/edit.svg" alt="eye">
                </a>
                <a class="me-3 confirm-text botonEliminar" data-id="' . $arrayDataProducts[$i]['id_pinventario'] . '">
                    <img src="' . constant("URL") . '/public/imgs/icons/trash.svg" alt="trash">
                </a>
            ';
            }

            // retornamos la data en un arreglo asociativo con la data filtrada y asociada
            $response = [
                "draw" => $draw,
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalFiltered,
                "data" => $arrayDataProducts,
                "status" => true
            ];
            // devolvemos la data y terminamos el proceso
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            die();
        } catch (Exception $e) {
            error_log('Categorias::getCategories -> Error en traer los datos - getCategories' . $e->getMessage());
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
