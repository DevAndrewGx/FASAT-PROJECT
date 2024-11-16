<?php

class CategoriasModel extends Model implements JsonSerializable
{

    // atributos de la clase
    private $id_categoria;
    private $nombre_categoria;
    // atributos adicionales para las subcategorias
    private $id_sub_categoria;
    private $nombre_subcategoria;
    private $tipo;


    // constructor para inicializar parametros
    public function __construct()
    {
        parent::__construct();

        $this->id_categoria = 0;
        $this->id_sub_categoria = 0;
        $this->nombre_categoria = "";
        $this->tipo = "";
    }

    // funcion para crear una nueva categoria

    public function crearCategory()
    {

        try {
            $conn = $this->db->connect();
            // creamos la consulta
            $query = $conn->prepare("INSERT INTO categorias(nombre_categoria, tipo_categoria) VALUES (:nombre_categoria, :tipo_categoria)");

            // Ejecutamos la consulta con los atributos seteados anteriormente
            $query->execute([
                'nombre_categoria' => $this->nombre_categoria,
                'tipo_categoria' => $this->tipo,
            ]);

            $getLastInsertId = $conn->lastInsertId();
            error_log('FotoModel::crear -> lastId -> ' . $getLastInsertId);

            // Asignar el ID de la foto al modelo actual
            $this->setIdCategoria($getLastInsertId);
            // saliimos de la funcion
            return true;
        } catch (PDOException $e) {
            error_log('CategoriasModel::crear->PDOException' . $e);
            // salimos de la funcion
            return false;
        }
    }



    // Funcion paraa crear subCategorias
    public function crearSubCategory()
    {
        try {
            // creamos la consulta
            $query = $this->prepare("INSERT INTO sub_categorias(nombre_subcategoria, id_categoria) VALUES (:nombre, :id)");

            // Ejecutamos la consulta con los atributos seteados anteriormente
            $query->execute([
                'nombre' => $this->nombre_subcategoria,
                'id' => $this->id_categoria,
            ]);
            // saliimos de la funcion
            return true;
        } catch (PDOException $e) {
            error_log('CategoriasModel::crearSubCategory->PDOException' . $e);
            // salimos de la funcion
            return false;
        }
    }


    // La funcion consultarTodos() nos permitira obtener todos los usuarios medo un arreglo de objetos

    public function consultarTodos()
    {

        $items = [];


        try {
            // ejecutamos la consulta con query porque no se estan enviando parametros
            $query = $this->query("SELECT * FROM categorias");

            // iteramos con un while para extraer la data con fetch y FETCH_ASSOC para almacenarla
            // FETCH_ASSOC retorna un objeto de clave y valor
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                // creamos un objeto de categorias para que cada vez que itere guarde la data 

                $item = new CategoriasModel();

                $item->setIdCategoria($row['id_categoria']);
                $item->setNombreCategoria($row['nombre_categoria']);
                $item->setNombreSubCategoria($row['nombre_subcategoria']);
                $item->setTipoCategoria($row['tipo_categoria']);

                // ya que seteamos la data en cada objeto, lo agregamos al objeto principal
                array_push($items, $item);
                // finalmente retornamos el objeto

            }

            return $items;
        } catch (PDOException $e) {
            error_log('CategoriasModel::consultarTodos -> SQL error ' . $e);
        }
    }

    public function get($nombreCategoria)
    {

        try {
            // we have to use prepare because we're going to assing
            $query = $this->prepare('SELECT * FROM categorias WHERE nombre_categoria = :nombre LIMIT 1');
            $query->execute([
                'nombre' => $nombreCategoria
            ]);

            // Como solo queremos obtener un valor, no hay necesidad de tener un while
            $category = $query->fetch(PDO::FETCH_ASSOC);

            // en este caso no hay necesidad de crear un objeto userModel, solo podemos llamar los metodos del mismo con objeto con this
            $this->setIdCategoria($category['id_categoria']);
            $this->setNombreCategoria($category['nombre_categoria']);
            $this->setTipoCategoria($category['tipo_categoria']);

            //retornamos this porque es el mismo objeto que ya contiene la informacion
            return $category;
        } catch (PDOException $e) {
            error_log('CategoriesModel::getId->PDOException' . $e);
        }
    }

    // funcion para traer la subcategorias con las con las categorias
    public function getSubCategory($idSubCategoria)
    {
        try {
            // Obtener los datos de la subcategoría y la categoría asociada
            $querySubCategory = $this->prepare('
                SELECT su.nombre_subcategoria, ca.id_categoria, ca.nombre_categoria 
                FROM sub_categorias su 
                INNER JOIN categorias ca 
                ON su.id_categoria = ca.id_categoria 
                WHERE su.id_sub_categoria = :id');

            $querySubCategory->execute([
                'id' => $idSubCategoria
            ]);

            $subCategory = $querySubCategory->fetch(PDO::FETCH_ASSOC);

            // Obtener todas las categorías
            $queryCategories = $this->prepare('SELECT id_categoria, nombre_categoria FROM categorias');
            $queryCategories->execute();
            $allCategories = $queryCategories->fetchAll(PDO::FETCH_ASSOC);

            // Armar la respuesta
            return [
                'nombre_subcategoria' => $subCategory['nombre_subcategoria'],
                'id_categoria' => $subCategory['id_categoria'],  // Categoria asociada
                'categorias' => $allCategories  // Lista de todas las categorías
            ];
        } catch (PDOException $e) {
            error_log('CategoriesModel::getSubCategory->PDOException' . $e);
            return null;
        }
    }



    // funciones para dibujar los datos con datatables
    public function cargarDatosCategorias($registrosPorPagina, $inicio, $columna, $orden, $busqueda, $columnName)
    {
        $items = [];

        try {
            $sql = "SELECT c.*, s.nombre_subcategoria, s.id_sub_categoria FROM categorias c LEFT JOIN sub_categorias s ON c.id_categoria = s.id_categoria";
            error_log('ejecucion de la query cargarCategorias' . $sql);
            if (!empty($busqueda)) {
                $searchValue = $busqueda;
                $sql .= " WHERE 
                    c.nombre_categoria LIKE '%$searchValue%' OR 
                    s.nombre_subcategoria LIKE '%$searchValue%' OR 
                    c.tipo_categoria LIKE '%$searchValue%'";
            }
            if ($columna != null && $orden != null) {
                $sql .= " ORDER BY $columnName $orden";
            } else {
                $sql .= " ORDER BY c.nombre_categoria DESC";
            }
            error_log("Registros por pagina: ->>>>>>>>>>>>>>>>> " . $registrosPorPagina);
            error_log("Inicio por pagina: ->>>>>>>>>>>>>>" . $inicio);
            if ($registrosPorPagina != null && $registrosPorPagina != -1 || $inicio != null) {
                $sql .= " LIMIT " . $registrosPorPagina . " OFFSET " . $inicio;
            }
            error_log("Consulta 1 : ->>>>>>>>>>>>>>" . $registrosPorPagina != null && $registrosPorPagina != -1 || $inicio != null);
            error_log("Consulta 2 : ->>>>>>>>>>>>>>" . $registrosPorPagina != null && $registrosPorPagina != -1 && $inicio != null);
            error_log("Consulta: ->>>>>>>>>>>>>>" . $sql);
            $query = $this->query($sql);

            while ($p = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new CategoriasModel();

                $item->setIdCategoria($p['id_categoria']);
                $item->setNombreCategoria($p['nombre_categoria']);
                $item->setNombreSubCategoria($p['nombre_subcategoria']);
                $item->setIdSubCategoria($p['id_sub_categoria']);
                $item->setTipoCategoria($p['tipo_categoria']);

                array_push($items, $item);
            }

            return $items;
        } catch (PDOException $e) {
            error_log('CategoriasModel::cargarDatosCategorias - ' . $e->getMessage());
            return [];
        }
    }

    public function totalRegistros()
    {
        try {
            $query = $this->query("SELECT COUNT(*) as total FROM categorias");
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            error_log('CategoriasModel::cargarDataosCategorias - ' . $e->getMessage());
            return 0;
        }
    }

    public function totalRegistrosFiltrados($busqueda)
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM categorias c JOIN sub_categorias s ON c.id_categoria = s.id_categoria";

            if (!empty($busqueda)) {
                $searchValue = $busqueda;
                $sql .= " WHERE 
                        c.nombre_categoria LIKE '%$searchValue%' OR 
                        c.nombre_subcategoria LIKE '%$searchValue%' OR 
                        u.tipo_categoria LIKE '%$searchValue%'";
            }

            $query = $this->query($sql);
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            error_log('JoinUserRelationsModel::totalRegistrosFiltrados - ' . $e->getMessage());
            return 0;
        }
    }

    public function borrar($id_categoria)
    {
        try {
            error_log("CategoriasModel::borrar -> Funcion para borrar categorias");
            $query = $this->prepare('DELETE FROM categorias WHERE id_categoria = :id_categoria');
            $query->execute([
                'id_categoria' => $id_categoria
            ]);

            return true;
        } catch (PDOException $e) {
            error_log('CategoriasModel::borrar->PDOException' . $e);
            return false;
        }
    }

    public function borrarSubCategoria($idSubCategoria)
    {
        try {
            error_log("CategoriasModel::borrar -> Funcion para borrar las subcategorias asociadas a una categoria");
            $query = $this->prepare('DELETE FROM sub_categorias WHERE id_sub_categoria = :id');
            $query->execute([
                'id' => $idSubCategoria
            ]);

            return true;
        } catch (PDOException $e) {
            error_log('CategoriasModel::borrar->PDOException' . $e);
            return false;
        }
    }

    // funcion para actualizar una categoria
    public function actualizarCategory($idCategoria)
    {
        try {
            error_log("CategoriasModel::actualizar -> Funcion para actualizar una categoria");

            $query = $this->prepare('UPDATE categorias SET nombre_categoria = :nombreCategoria, tipo_categoria = :tipoCategoria WHERE id_categoria = :id');

            $query->execute([
                'nombreCategoria' => $this->nombre_categoria,
                'tipoCategoria' => $this->tipo,
                'id' => $idCategoria
            ]);

            // verificamos si se actualizo alguna fila
            if ($query->rowCount() > 0) {
                return true;
            } else {
                error_log('CategoriasModle::actualizar -> No se actualizó ninguna fila');
                return false;
            }
        } catch (PDOException $e) {
            error_log('CategoriasModel::actualizar->PDOException' . $e);
            return false;
        }
    }

    // funcion para actualizar una subcategoria
    public function actualizarSubCategory($idSubCategoria)
    {

        try {
            error_log("CategoriasModel::actualizar -> Funcion para actualizar una subcategoria");

            $query = $this->prepare('UPDATE sub_categorias SET nombre_subcategoria = :nombre_subcategoria, id_categoria = :id_categoria WHERE id_sub_categoria = :id');

            $query->execute([
                'nombre_subcategoria' => $this->nombre_subcategoria,
                'id_categoria' => $this->id_categoria,
                'id' => $idSubCategoria
            ]);

            // verificamos si se actualizo alguna fila
            if ($query->rowCount() > 0) {
                return true;
            } else {
                error_log('CategoriasModle::actualizar -> No se actualizó ninguna fila');
                return false;
            }
        } catch (PDOException $e) {
            error_log('CategoriasModel::actualizar->PDOException' . $e);
            return false;
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id_categoria' => $this->id_categoria,
            'nombre_categoria' => $this->nombre_categoria,
            'nombre_subcategoria' => $this->nombre_subcategoria,
            'id_sub_categoria' => $this->id_sub_categoria,
            'tipo_categoria' => $this->tipo
        ];
    }

    public function FROM($array)
    {
        // $this->id_categoria             = $array['id_categoria'];
        $this->nombre_categoria = $array['nombre_categoria'];
        $this->nombre_subcategoria = $array['nombre_subcategoria'];
        $this->tipo = $array['tipo_categoria'];
    }

    public function existCategory($categoria)
    {

        try {
            $query = $this->prepare('SELECT nombre_categoria FROM categorias WHERE nombre_categoria = :nombre');

            $query->execute([
                'nombre' => $categoria
            ]);
            //Si al momento de contar el resultado de la query y es mayor a cero eso significa que 
            // ya existe una categoria con ese nombre
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log('USERMODEL::existsUser->PDOException' . $e);
            return;
        }
    }

    // funcion para validar si ya existe una subcategoria dentro la bd

    public function existSubCategory($subCategoria)
    {
        try {
            $query = $this->prepare('SELECT nombre_subcategoria  FROM sub_categorias WHERE nombre_subcategoria = :nombre');

            $query->execute([
                'nombre' => $subCategoria
            ]);
            //Si al momento de contar el resultado de la query y es mayor a cero eso significa que 
            // ya existe una categoria con ese nombre
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log('USERMODEL::existsUser->PDOException' . $e);
            return;
        }
    }
    

    // funcion para consultar las subcategorias por las categorias
    function getSubCategoriesByCategory($idCategoria)
    {
        $items = [];
        try {

            // ejecutamos la consulta con query porque no se estan enviando parametros
            $query = $this->prepare('SELECT * FROM sub_categorias s INNER JOIN categorias c ON s.id_categoria = c.id_categoria WHERE c.id_categoria = :id');

            $query->execute([
                'id' => $idCategoria
            ]);

            // iteramos con un while para extraer la data con fetch y FETCH_ASSOC para almacenarla
            // FETCH_ASSOC retorna un objeto de clave y valor
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                // creamos un objeto de categorias para que cada vez que itere guarde la data 
                $item = new CategoriasModel();

                $item->setIdSubCategoria($row['id_sub_categoria']);
                $item->setNombreCategoria($row['nombre_categoria']);
                $item->setNombreSubCategoria($row['nombre_subcategoria']);


                // ya que seteamos la data en cada objeto, lo agregamos al objeto principal
                array_push($items, $item);
                // finalmente retornamos el objeto
            }

            return $items;
        } catch (PDOException $e) {
            error_log('CategoriasModel::getId->PDOException' . $e);
        }
    }

    public function getIdCategoria()
    {
        return $this->id_categoria;
    }
    public function getNombreCategoria()
    {
        return $this->nombre_categoria;
    }
    public function getIdSubCategoria()
    {
        return $this->id_sub_categoria;
    }
    public function getNombreSubCategoria()
    {
        return $this->nombre_subcategoria;
    }
    public function getTipoCategoria()
    {
        return $this->tipo;
    }
    public function setIdCategoria($id)
    {
        return $this->id_categoria = $id;
    }
    public function setNombreCategoria($nombre)
    {
        $this->nombre_categoria = $nombre;
    }
    public function setTipoCategoria($tipo)
    {
        $this->tipo = $tipo;
    }
    public function setIdSubCategoria($id)
    {
        $this->id_sub_categoria = $id;
    }
    public function setNombreSubCategoria($nombre)
    {
        return $this->nombre_subcategoria = $nombre;
    }
}
?>