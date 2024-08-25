<?php

class Categorias extends SessionController
{


    private $user;

    function __construct()
    {
        parent::__construct();

        $this->user = $this->getUserSessionData();
        error_log('Categorias::construct -> Controlador categorias');
    }


    function render()
    {
        error_log('Categorias::render -> Carga la pagina principal de categorias');
        $this->view->render('admin/gestionCategorias', []);
    }

    // Funcion para crear una nueva categoria

    function createCategory() {
        // primero validamos si la data viene correctamente desde el formulario
        error_log('Categorias::createCategory -> Funcion para crear nuevas categorias');

        if (!$this->existPOST(['nombreCategoria', 'tipoCategoria'])) {
            error_log('Categorias::createCategoria -> Hay algun error en los parametros enviados en el formulario');

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
        error_log('createCategory:: -> Es posible crear una nueva categoria');

        // creamos un nuevo objeto de categorias
        $categoriaObj = new CategoriasModel();
        // seteamos los valores que vienen del formulario
        $categoriaObj->setNombreCategoria($this->getPost('nombreCategoria'));
        $categoriaObj->setTipoCategoria($this->getPost('tipoCategoria'));
        // validamos si la consulta fue correcta


        // Si no existe la subcategoria insertamosla categoria sin ningun paso adicional mas
        if (!$this->existPOST(['subCategoriaNombre'])) {
            error_log('Categorias::createCategory -> No existe la subcategoria, se inserta data de la categoria');

            if ($categoriaObj->saveCategory()) {
                error_log('Categorias::createCategory -> Se guardó un producto correctamente dentro de la bd');
                echo json_encode(['status' => true, 'message' => "La categoria fue creada exitosamente!"]);
                return;
            }
        }else {
            // insertamos primero la data de categorias

            if ($categoriaObj->saveCategory()) {
                error_log('Categorias::createCategory -> Se guardó la categoria correctamente');
                $idCategoria = $categoriaObj->getIdCategoria();
                $categoriaObj->setIdCategoria($idCategoria);
                // hacemos la inserción de la subcategoria con el id de la categoria para realizar la asociación
                $categoriaObj->setNombreSubCategoria($this->getPost('subCategoriaNombre'));
                
                if($categoriaObj->saveSubCategory()) {
                    echo json_encode(['status' => true, 'message' => "La categoria y subcategoria fueron creadas exitosamente"]);
                    return;
                }else {
                    echo json_encode(['status' => true, 'message' => "No se guardo la data correctamente en subcategorias"]);   
                    return;
                }
                
            }
        }
        
        
    }

}
