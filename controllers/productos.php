<?php

class Productos extends SessionController
{

    private $user;

    function __construct()
    {
        parent::__construct();

        $this->user = $this->getDatosUsuarioSession();
        error_log('Producto::construct -> Controlador producto');
    }


    function render()
    {
        // creamos un objeto de categorias para traer las categorias
        $categoriaObj = new CategoriasModel();
        $categories = $categoriaObj->consultarTodos();
        $subCategories = $categoriaObj->getSubCategoriesByCategory($this->getPost('categoria'));
        error_log($this->getPost('categoria'));
        error_log('Producto::render -> Carga la pagina principal');
        $this->view->render('admin/gestionInventario', ['categories' => $categories, 'subcategories' => $subCategories, 'user' => $this->user]);
    }

    // creamos la funcion que nos permitira crear nuevos productos
    function crearProducto()
    {
    // primero validamos si la data viene correctamente desde el formulario
        error_log('Productos::createProduct -> Funcion para crear nuevos productos');

        if (!$this->existPOST(['nombreProducto', 'categoria', 'subcategoria', 'precio', 'descripcion'])) {
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
        $productoObject->setIdSubcategoria($this->getPost('subcategoria') === '' ? null : $this->getPost('subcategoria'));

        error_log('LOOK AT THIS BITCH'.$this->getPost('subcategoria'));
        $productoObject->setPrecio($this->getPost('precio'));
        $productoObject->setDescripcion($this->getPost('descripcion'));

        // creamos un nuevo objeto para guardar una foto
        $photoObj = new FotoModel();

        // creamos un nuevo objeto de stock para asignar los valores a sus respectivo atributos
        $stockObj = new StockModel();

        $stockObj->setCantidad($this->getPost('cantidad'));
        $stockObj->setCantidadMinima($this->getPost('cantidad'));
        $stockObj->setCantidadDisponible($this->getPost('cantidad'));

        $this->createPhoto($photoObj, "productos");
          // verificamos si la consulta de las fotos se ejecuta correctamente
        if ($photoObj->crear()) {
            error_log('Users::createUser -> Se guardó la foto correctamente');
            $idPhoto = $photoObj->getIdFoto();
            // error_log('Users::createUser -> idFoto: ' . $photoObj);

            if($stockObj->crear()) {
                error_log("Productos::createProduct -> se guardo la data del id stock correctamente");
                $idStock = $stockObj->getIdStock();
                $productoObject->setIdStock($idStock);

                if ($idPhoto) {
                    $productoObject->setIdFoto($idPhoto);
                    // verificamos si se pudo insertar data dentro la bd
                    if ($productoObject->crear()) {
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
                <a class="me-3 botonActualizar" href="#" data-id="' . $arrayDataProducts[$i]['id_pinventario'] . '"  data-idFoto="'.$arrayDataProducts[$i]['id_foto'].'">
                    <img src="' . constant("URL") . '/public/imgs/icons/edit.svg" alt="eye">
                </a>
                <a class="me-3 confirm-text botonEliminar" href="#" data-id="' . $arrayDataProducts[$i]['id_pinventario'] . '">
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

    // funcion para consultar una mesa en especifico
    function consultarProducto() {
        // validamos si existe el id enviado desde la petición
        if (!$this->existPOST(['id_producto'])) {
            error_log('Productos::consultarProducto -> No se obtuvo el id del producto correctamente');
            echo json_encode(['status' => false, 'message' => "Algunos parametros enviados estan vacios, intente nuevamente!"]);
            return false;
        }

        if ($this->user == NULL) {
            error_log('Productos::consultarProductos -> El usuario de la session esta vacio');
            // enviamos la respuesta al front para que muestre una alerta con el mensaje
            echo json_encode(['status' => false, 'message' => ErrorsMessages::ERROR_ADMIN_NEWDATAUSER]);
            return;
        }
        // creamos un nuevo objeto de productos
        $productoObj = new ProductosJoinModel();
        $res = $productoObj->consultar($this->getPost('id_producto'));

        $arrayData =  json_decode(json_encode($res, JSON_UNESCAPED_UNICODE), true);

        if ($arrayData) {
            error_log('Productos::consultarProductos -> El producto se obtuvo correctamente-> ' . $res);
            $response = [
                "data" => $arrayData,
                "status" => true,
                "message" => "Se obtuvo la data correctamente"
            ];
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            die();
        } else {
            error_log('Users::borrarUser -> No se pudo obtener el usuario correctamente');
            echo json_encode(['status' => false, 'message' => "No se pudo obtener el usuario!"]);
            return false;
        }
    }
  // function para traer la data de las subcategorias asociadasa a una categoria
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


    

    function actualizarProducto() {
        // primero validamos si la data viene correctamente desde el formulario
        error_log('Productos::actualizarProduct -> Funcion para crear nuevos productos');

        if (!$this->existPOST(['nombreProducto', 'categoria', 'subcategoria', 'precio', 'descripcion', 'id_producto'])) {
            error_log('Productos::actualizarProducto -> Hay algun error en los parametros enviados en el formulario');

            // enviamos la respuesta al front para que muestre una alerta con el mensaje
            echo json_encode(['status' => false, 'message' => "Los datos que vienen del formulario estan vacios"]);
            return;
        }

        if ($this->user == NULL) {
            error_log('Productos::actualizarProducto -> El usuario de la session esta vacio');
            // enviamos la respuesta al front para que muestre una alerta con el mensaje
            echo json_encode(['status' => false, 'message' => ErrorsMessages::ERROR_ADMIN_NEWDATAUSER]);
            return;
        }

        $productoObj = new ProductosModel();

        // asignamos los datos traidos del formulario a el objeto
        $productoObj->setNombre($this->getPost('nombreProducto'));
        $productoObj->setIdCategoria($this->getPost('categoria'));
        $productoObj->setIdSubcategoria($this->getPost('subcategoria') === '' ? null : $this->getPost('subcategoria'));
        $productoObj->setPrecio($this->getPost('precio'));
        $productoObj->setDescripcion($this->getPost('descripcion'));


        // creamos un objeto de productoJoinModel para traer la data del stock y setearla en productosModel
        $productoJoinObj = new ProductosJoinModel();
        $dataProductJoin = $productoJoinObj->consultar($this->getPost('id_producto'));
        $idStock = $dataProductJoin['id_stock'];

        error_log("IDSTOCKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK ".$idStock);

        // creamos un objeto de stockmodel para setear y actualizar la data
        $stockObj = new StockModel();
        
        $stockObj->setCantidad($this->getPost('cantidad'));
        $stockObj->setCantidadMinima($this->getPost('cantidad'));
        $stockObj->setCantidadDisponible($this->getPost('cantidad'));
        error_log("La cantidad para el stock es ".$this->getPost('cantidad'));
        // creamos un objeto de tipo foto
        $fotoObj = new FotoModel();

        $this->createPhoto($fotoObj, "users");

        // validamos primero si la foto se actualiza en la tablas fotos y despues actualiamos la data del producto
        // idFoto para actualizar la data
        $idFoto = $this->getPost('id_foto');

        if ($fotoObj->actualizar($idFoto)) {
            error_log("Productos::actualizarProducto -> se actualiizo la foto correctamente");
            error_log("Productos::actualizarProducto -> el id de la foto es -> " . $idFoto);
            $productoObj->setIdFoto($idFoto);
            if($stockObj->actualizar($idStock)) {
                $productoObj->setIdStock($idStock);

                // actualizamos la data del usuario
                error_log('The products isssssssssssssssssssssssssssss: ' . $this->getPost('id_producto'));
                $res = $productoObj->actualizar($this->getPost("id_producto"));
                // validamos si la consulta o la respuesta es correcta
                if ($res) {
                    error_log('Productos::actualizarProducto -> Se actualizo el producto correctamente');
                    echo json_encode(['status' => true, 'message' => "El producto fue actualizado exitosamente!"]);
                    return;
                } else {
                    error_log('Productos::actualizarProducto -> Error en la consulta del Back');
                    echo json_encode(['status' => false, 'message' => "Error 500, nose actualizo la data!"]);
                    return;
                }
            }else {
                error_log('Productos::actualizarProducto -> No se pudo actualizar en el modelo stock hay algo mal');
            }
            
        } else {
            error_log('Productos::actualizarProducto -> No se pudo actualizar la foto');
            echo json_encode(['status' => false, 'message' => "Error 500, NO se actualizo la foto!"]);
            return;
        }
    }

    // esta funcion nos permitira eliminar los productos
    function borrarProducto() {
        // validamos si el id enviado desde la peticion existe
        if (!$this->existPOST(['id_producto'])) {
            error_log('Productos::borrarProducto -> No se obtuvo el id de la mesa correctamente');
            echo json_encode(['status' => false, 'message' => "No se pudo eliminar el producto, intente nuevamente!"]);
            return false;
        }

        if ($this->user == NULL) {
            error_log('Productos::borrarProducto  -> El producto de la session esta vacio');
            // enviamos la respuesta al front para que muestre una alerta con el mensaje
            echo json_encode(['status' => false, 'message' => "El producto de la sessión esta vacio"]);
            return;
        }
        $productObj = new ProductosModel();
        // guardamos el resultado de la consuta en una variable
        $res = $productObj->borrar($this->getPost('id_producto'));

        if($res) { 
            error_log("Productos::borrarProducto -> Se elimino un producto correctamente");
            echo json_encode(['status' => true, 'message' => "El producto fue eliminado exitosamente!"]);
            return true;
        }else {
            error_log('Productos::borrarProducto  -> No se pudo eliminar el producto, intente nuevamente');
            echo json_encode(['status' => false, 'message' => "No se pudo eliminar el producto, intente nuevamente!"]);
            return false;
        }
    }
}
