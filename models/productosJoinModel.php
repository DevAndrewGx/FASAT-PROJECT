<?php 

// Este modelo nos ayudara a traer la data de varias tablas ya que si lo ponemos toda la data en ProductosModel
// quedara muy extenso y largo, lo cual no es recomendable 

class ProductosJoinModel extends Model implements JsonSerializable {

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
    private $nombre_subcategoria;
    private $cantidad;
    private $descripcion;


    public function consultar($idProducto) {
        try {
            // we have to use prepare because we're going to assing
            $query = $this->prepare('SELECT p.nombre, p.precio, p.descripcion, c.nombre_categoria, s.nombre_subcategoria, s.id_sub_categoria, st.cantidad FROM productos_inventario p INNER JOIN categorias c ON p.id_categoria = c.id_categoria INNER JOIN sub_categorias s ON p.id_subcategoria = s.id_sub_categoria INNER JOIN stock_inventario st ON p.id_stock = st.id_stock WHERE p.id_pinventario = :id');
            $query->execute([
                'id' => $idProducto
            ]);
            // Como solo queremos obtener un valor, no hay necesidad de tener un while
            $producto = $query->fetch(PDO::FETCH_ASSOC);

            // en este caso no hay necesidad de crear un objeto userModel, solo podemos llamar los metodos del mismo con objeto con this
            $this->setNombre($producto['nombre']);
            $this->setPrecio($producto['precio']);
            $this->setNombreCategoria($producto['nombre_categoria']);
            $this->setIdSubCategoria($producto['id_sub_categoria']);
            $this->setNombreSubcategoria($producto['nombre_subcategoria']);

            //retornamos this porque es el mismo objeto que ya contiene la informacion
            return $producto;
        } catch (PDOException $e) {
            error_log('PRODUCTOSMODEL::get->PDOException ' . $e);
        }
    }


    public function jsonSerialize(): mixed
    {
        return [
            'id_pinventario' => $this->id_producto,
            'id_sub_categoria' => $this->id_subcategoria,
            'nombre_producto' => $this->nombre,
            'foto' => $this->foto,
            'nombre_subcategoria'=>$this->nombre_subcategoria,
            'nombre_categoria' => $this->nombre_categoria,
            'cantidad' => $this->cantidad,
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

    public function setNombreSubcategoria($nombre_subcategoria)
    {
        $this->nombre_subcategoria = $nombre_subcategoria;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
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

    public function getNombreSubCategoria()
    {
        return $this->nombre_subcategoria;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

}

?>