<?php

// Todos los modelos heredan de la clase model y implementar la interfaz IModel la cual nos permitira hacer el crud.
class ProductosModel extends Model implements JsonSerializable
{

    // creamos los atributos de la clase
    private $id_producto;
    private $id_foto;
    private $foto;
    private $id_stock;
    private $id_provedor;
    private $id_categoria;
    private $id_subcategoria;
    private $precio;
    private $nombre;
    private $nombre_categoria;
    private $descripcion;
    // private $disponibilidad;


    // creamos el constructor para inicializar los atributos
    public function __construct()
    {

        parent::__construct();

        // inicializar los atributos
        $this->id_producto = 0;
        $this->id_foto = 0;
        $this->id_stock = 0;
        $this->id_provedor = 0;
        $this->id_categoria = 0;
        $this->id_subcategoria = 0;
        $this->precio = 0;
        $this->nombre = '';
        $this->nombre_categoria = '';
        $this->descripcion = '';
        // $this->disponibilidad = '';
    }



    // creamos la funcion para crear un nuevo producto 
    public function crear()
    {
        // utilizamos siempre el try catch ya que vamos a crear consultas para manipular la bd
        try {
            // creamos la query para insertar datos dentro de la bd
            $query = $this->prepare("INSERT INTO productos_inventario(id_foto, id_categoria, id_subcategoria, id_proveedor, id_stock,  nombre, precio, descripcion) VALUES(:id_foto, :id_categoria, :id_subcategoria, :id_proveedor, :id_stock, :nombre, :precio, :descripcion)");


            // si los datos no existe los ponemos nullos para que puedan ser insertados dentro la bd
            $query->execute([
                'id_foto' => $this->id_foto ?? null,
                'id_categoria' => $this->id_categoria ?? null,
                'id_subcategoria' => $this->id_subcategoria ?? null,
                'id_proveedor' => $this->id_proveedor ?? null,
                'id_stock' => $this->id_stock ?? null,
                'nombre' => $this->nombre,
                'precio' => $this->precio,
                'descripcion' => $this->descripcion
            ]);

            // retornamos true para salirnos de la funcion
            return true;
        } catch (PDOException $e) {
            error_log('ProductoModel::crear->PDOException' . $e);
            // salimos de la funcion
            return false;
        }
    }


    // funcion para obtener un producto
    public function consultar($idProducto)
    {

        try {
            // we have to use prepare because we're going to assing
            $query = $this->prepare('SELECT p.nombre, p.precio, p.descripcion, c.nombre_categoria, s.nombre_subcategoria FROM productos_inventario p INNER JOIN categorias c ON p.id_categoria = c.id_categoria WHERE p.id_pinventario = :id');
            $query->execute([
                'id' => $idProducto
            ]);
            // Como solo queremos obtener un valor, no hay necesidad de tener un while
            $producto = $query->fetch(PDO::FETCH_ASSOC);

            // en este caso no hay necesidad de crear un objeto userModel, solo podemos llamar los metodos del mismo con objeto con this
            $this->setNombre($producto['nombre']);
            $this->setPrecio($producto['precio']);
            $this->setNombreCategoria($producto['nombre_categoria']);

            //retornamos this porque es el mismo objeto que ya contiene la informacion
            return $producto;
        } catch (PDOException $e) {
            error_log('PRODUCTOSMODEL::get->PDOException ' . $e);
        }
    }

    // funcion para mostrar los datos en las datatables
    public function cargarDatosProductos($registrosPorPagina, $inicio, $columna, $orden, $busqueda, $columnName)
    {
        $items = [];

        try {
            $sql = "SELECT p.id_pinventario, f.foto, f.id_foto, p.nombre, p.precio, c.nombre_categoria FROM productos_inventario p LEFT JOIN categorias c ON p.id_categoria = c.id_categoria LEFT JOIN fotos f ON f.id_foto = p.id_foto";

            error_log('ejecucion de la query cargarCategorias' . $sql);
            if (!empty($busqueda)) {
                $searchValue = $busqueda;
                $sql .= " WHERE 
                    p.nombre LIKE '%$searchValue%' OR 
                    p.precio LIKE '%$searchValue%' OR 
                    c.nombre_categoria LIKE '%$searchValue%'";
            }
            if ($columna != null && $orden != null) {
                $sql .= " ORDER BY $columnName $orden";
            } else {
                $sql .= " ORDER BY p.nombre DESC";
            }

            if ($registrosPorPagina != null && $registrosPorPagina != -1 && $inicio != null) {
                $sql .= " LIMIT " . $registrosPorPagina . " OFFSET " . $inicio;
            }

            $query = $this->query($sql);

            while ($p = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new ProductosModel();

                $item->setIdProducto($p['id_pinventario']);
                $item->setIdFoto($p['id_foto']);
                $item->setNombre($p['nombre']);
                $item->setPrecio($p['precio']);
                $item->setFoto($p['foto']);
                $item->setNombreCategoria($p['nombre_categoria']);

                array_push($items, $item);
            }

            return $items;
        } catch (PDOException $e) {
            error_log('ProductosModel::cargarDatosProductos - ' . $e->getMessage());
            return [];
        }
    }

    public function totalRegistros()
    {
        try {
            $query = $this->query("SELECT COUNT(*) as total FROM productos_inventario");
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            error_log('ProductosModel::totalRegistros - ' . $e->getMessage());
            return 0;
        }
    }

    public function totalRegistrosFiltrados($busqueda)
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM productos_inventario p JOIN categorias c ON c.id_categoria = p.id_categoria";

            if (!empty($busqueda)) {
                $searchValue = $busqueda;
                $sql .= " WHERE 
                        p.nombre LIKE '%$searchValue%' OR 
                        p.precio LIKE '%$searchValue%' OR 
                        p.descripcion LIKE '%$searchValue%' OR 
                        c.nombre_categoria";
            }
            $query = $this->query($sql);
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            error_log('ProductosModel::totalRegistrosFiltrados - ' . $e->getMessage());
            return 0;
        }
    }

    // funcion para consultar los productos por las categorias
    function getProductsByCategory($idCategoria)
    {
        // arreglo para guardar la data que viene de la bd
        $items = [];
        // encerramos la logica entre try catch ya que vamos a interactuar con la bd
        try {
            //creamos la consulta, en este caso tenemos que realizar un JOIN para traer la data

            $query  = $this->prepare('SELECT p.nombre, p.precio, p.descripcion, c.nombre_categoria FROM productos_inventario p INNER JOIN categorias c ON  c.id_categoria = p.id_categoria WHERE c.id_categoria = :id');

            $query->execute([
                "id" => $idCategoria
            ]);

            // iteramos con un while para extraer la data con fetch y FETCH_ASSOC para almacenarla
            // FETCH_ASSOC retorna un objeto de clave y valor
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                // creamos un objeto de categorias para que cada vez que itere guarde la data 
                $item = new ProductosModel();
                // seteamos los valores que fueron devueltos por la consulta
                $item->setIdProducto($row['id_pinventario']);   
                $item->setNombre($row['nombre']);
                $item->setNombreCategoria($row['nombre_categoria']);
                $item->setPrecio($row['precio']);

                // ya que seteamos la data en cada objeto, lo agregamos al objeto principal
                array_push($items, $item);
                // finalmente retornamos el objeto
            }

            return $items;
        } catch (PDOException $e) {
            error_log('CategoriasModel::getId->PDOException' . $e);
        }
    }

    // Este metodo nos permitira actualizar la de los productos en la bd
    public function actualizar($idProducto)
    {
        try {
            /* Consulta los valores actuales para el producto específico, ya que se estaba teniendo un 
            inconveniente al momento de actualizar data, porque como se realizan pruebas enviando la misma data, 
            entonces la query no se ejecuta correctamente por lo cual se realiza este paso adicional para evitar errores como estos*/
            $currentQuery = $this->prepare("SELECT id_foto, id_categoria, id_subcategoria, id_proveedor, id_stock, nombre, precio, descripcion 
                                        FROM productos_inventario 
                                        WHERE id_pinventario = :id_producto");
            $currentQuery->execute(['id_producto' => $idProducto]);
            $currentData = $currentQuery->fetch();

            // Verifica si los valores han cambiado
            if (
                $currentData &&
                $currentData['id_foto'] == $this->id_foto &&
                $currentData['id_categoria'] == $this->id_categoria &&
                $currentData['id_subcategoria'] == $this->id_subcategoria &&
                $currentData['id_proveedor'] == $this->id_provedor &&
                $currentData['id_stock'] == $this->id_stock &&
                $currentData['nombre'] == $this->nombre &&
                $currentData['precio'] == $this->precio &&
                $currentData['descripcion'] == $this->descripcion
            ) {
                error_log('ProductosModel::actualizar -> No hay cambios en los valores, omitiendo actualización');
                return true; // Retornamos true ya que no hay ningun cambio, entonces salimos de la actualizacion
            }

            // Despues de eso si hay cambios en los datos en cualquiera, podemos realizar la query para actualizar data
            $query = $this->prepare("UPDATE productos_inventario SET 
                                 id_foto = :id_foto, 
                                 id_categoria = :id_categoria, 
                                 id_subcategoria = :id_subcategoria, 
                                 id_proveedor = :id_proveedor, 
                                 id_stock = :id_stock, 
                                 nombre = :nombre, 
                                 precio = :precio, 
                                 descripcion = :descripcion 
                                 WHERE id_pinventario = :id_producto");
            
            // ejecutamos la query 
            $query->execute([
                'id_producto' => $idProducto ?? null,
                'id_foto' => $this->id_foto ?? null,
                'id_categoria' => $this->id_categoria ?? null,
                'id_subcategoria' => $this->id_subcategoria ?? null,
                'id_proveedor' => $this->id_proveedor ?? null,
                'id_stock' => $this->id_stock ?? null,
                'nombre' => $this->nombre,
                'precio' => $this->precio,
                'descripcion' => $this->descripcion
            ]);

            // verificamos si se afecto alguna fiila para asi retornar true y continuar con el flujo
            if ($query->rowCount() > 0) {
                return true;
            } else {
                error_log('ProductosModel::actualizar -> No se actualizó ninguna fila');
                return false;
            }
        } catch (PDOException $e) {
            error_log('ProductoModel::actualizar->PDOException ' . $e);
            return false;
        }
    }

    
    // Este metodo nos permitira borrar un producto de la bd
    public function borrar($id) {
        // utilizamos try catch para capturar cualquier exception sin afectar la visualización del aplicativo
        try {
            error_log("ProductosModel::borrar -> funcion para borrar el producto");
            $query = $this->prepare('DELETE FROM productos_inventario WHERE id_pinventario = :id_pinventario');
            $query->execute([
                'id_pinventario' => $id
            ]);

            return true;
        } catch (PDOException $e) {
            error_log('ProductosModel::borrar -> PDOException' . $e);
            return false;
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id_pinventario' => $this->id_producto,
            'id_foto' => $this->id_foto,
            'nombre_producto' => $this->nombre,
            'foto' => $this->foto,
            'nombre_categoria' => $this->nombre_categoria,
            'precio' => $this->precio,
        ];
    }

    // getters and setters
    public function setIdProducto($id)
    {
        $this->id_producto = $id;
    }
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }
    public function setIdFoto($id)
    {
        $this->id_foto = $id;
    }
    public function setIdStock($id)
    {
        $this->id_stock = $id;
    }
    public function setIdProvedor($id)
    {
        $this->id_provedor = $id;
    }
    public function setIdCategoria($categoria)
    {
        $this->id_categoria = $categoria;
    }
    public function setIdSubCategoria($subcategoria)
    {
        $this->id_subcategoria = $subcategoria;
    }
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setNombreCategoria($nombre)
    {
        $this->nombre_categoria = $nombre;
    }
    
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    // public function setDisponibilidad($disponibilidad) { $this->disponibilidad = $disponibilidad;}


    public function getIdProducto()
    {
        return $this->id_producto;
    }

    public function getFoto()
    {
        return $this->foto;
    }
    public function getIdFoto()
    {
        return $this->id_foto;
    }
    public function getIdStock()
    {
        return $this->id_stock;
    }
    public function getIdProvedor()
    {
        return $this->id_provedor;
    }
    public function getIdCategoria()
    {
        return $this->id_categoria;
    }
    public function getIdSubCategoria()
    {
        return $this->id_subcategoria;
    }
    public function getPrecio()
    {
        return $this->precio;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getNombreCategoria()
    {
        return $this->nombre_categoria;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
}

?>