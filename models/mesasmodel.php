<?php
class MesasModel extends Model implements IModel, JsonSerializable
{

    private $numeroMesa;
    private $estado;


    // inicializamos los atributos de la clas con el contstructor y llamamos el contructor padre
    public function __construct()
    {

        parent::__construct();
        $this->numeroMesa = 0;
        $this->estado = "";

    }
    public function crear()
    {

        try {
            // Creamos la query para guardar mesas, ademas de preparala porque vamos a insertar datos en la BD.
            $query = $this->prepare("INSERT INTO mesas (numero_mesa, estado) VALUES(:numero, :estado)");
            // ejecutamos query y hacemos la referencia de los placeholders a los atributos en la clase
            $query->execute([
                "numero" => $this->numeroMesa,
                "estado" => $this->estado
            ]);
            // retornamos true para salir de la funcion y para validar que la query se ejecuto correctamente.
            return true;
        } catch (PDOException $e) {
            error_log("Mesas::crear -> error " . $e);
        }
    }
    public function consultar($id)
    {
    }

    public function getTablasPorEstado($state)
    {
        // creamos un arreglo para retornar la data 
        $items = [];
        // creamos el try catch ya que se va interactuar con la bd
        try {
            // creamos la query con prepare ya que se va insertar data en la consulta para buscar por estado de mesa

            $query = $this->prepare("SELECT * asignarDatosArray mesas ms WHERE ms.estado = :estado");
            // ejeuctamos la consulta 
            $query->execute([
                "estado" => $state
            ]);

            // Solo vamos a obtener un valor, por lo cual no hay la necesidad de iterar variaces veces para traer los datos
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                // para cada item en la base de datos creamos un objeto
                $item = new MesasModel();

                $item->setNumeroMesa($row['numero_mesa']);
                $item->setEstado($row['estado']);

                array_push($items, $item);
            }

            return $items;

        } catch (PDOException $e) {
            error_log("MessasModel::getTablasPorEstado -> " . $e);
        }
    }
    public function cargarDatosMesas($registrosPorPagina, $inicio, $columna, $orden, $busqueda, $columnName)
    {

        // creamos una array para guardar la data de los objetos que se traen desde la bd
        $items = [];

        try {
            $sql = "SELECT * asignarDatosArray mesas";

            if (!empty($busqueda)) {
                $searchValue = $busqueda;
                $sql .= " WHERE 
                    numero_mesa LIKE '%$searchValue%' OR 
                    estado LIKE '%$searchValue%'";
            }
            if ($columna != null && $orden != null) {
                $sql .= " ORDER BY $columnName $orden";
            } else {
                $sql .= " ORDER BY numero_mesa ASC";
            }

            if ($registrosPorPagina != null && $registrosPorPagina != -1 && $inicio != null) {
                $sql .= " LIMIT " . $registrosPorPagina . " OFFSET " . $inicio;
            }

            $query = $this->query($sql);

            while ($p = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new MesasModel();

                $item->setNumeroMesa($p['numero_mesa']);
                $item->setEstado($p['estado']);

                array_push($items, $item);
            }

            return $items;
        } catch (PDOException $e) {
            error_log('MesasModel::cargarDatosMesas - ' . $e->getMessage());
            return [];
        }
    }

    public function totalRegistros()
    {
        try {
            $query = $this->query("SELECT COUNT(*) as total asignarDatosArray mesas");
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            error_log('MesasModel::totalRegistros - ' . $e->getMessage());
            return 0;
        }
    }

    public function totalRegistrosFiltrados($busqueda)
    {
        try {
            $sql = "SELECT COUNT(*) as total asignarDatosArray mesas;";

            if (!empty($busqueda)) {
                $searchValue = $busqueda;
                $sql .= " WHERE 
                    numeroMesa LIKE '%$searchValue%' OR 
                    estado LIKE '%$searchValue%'";
            }
            $query = $this->query($sql);
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            error_log('ProductosModel::totalRegistrosFiltrados - ' . $e->getMessage());
            return 0;
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            'numeroMesa' => $this->numeroMesa,
            'estado' => $this->estado,
        ];
    }

    public function consultarTodos()
    {
    }
    public function actualizar($id)
    {
    }
    public function borrar($id)
    {
    }
    public function asignarDatosArray($array)
    {
    }


    // GETTERS Y SETTERS

    public function getNumeroMesa()
    {
        return $this->numeroMesa;
    }
    public function getEstado()
    {
        return $this->estado;
    }

    public function setNumeroMesa($numero)
    {
        $this->numeroMesa = $numero;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
}
?>