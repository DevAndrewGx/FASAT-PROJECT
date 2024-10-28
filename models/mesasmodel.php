<?php
class MesasModel extends Model implements IModel, JsonSerializable
{
    private $idMesa;
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
    // funcion para obtener una mesa en especifico
    public function consultar($id){

        // usamos try catch ya que vamos a interactuar con la bd
        try { 
            // creamos la query para consultar la data
            $query = $this->prepare('SELECT * FROM mesas WHERE id_mesa = :id');
            // ejecutamos query 
            $query->execute([
                'id'=>$id
            ]);
            // como vamos a obtener un registro en especifo no hay necesidad de usar while
            $mesa = $query->fetch(PDO::FETCH_ASSOC);

            // asignamos la data a los atributos de la clase
            $this->setIdMesa($mesa['id_mesa']);
            $this->setNumeroMesa($mesa['numero_mesa']);
            $this->setEstado($mesa['estado']);

            // retornamos el objeto mesa 
            return $mesa;   
        }catch(PDOException $e) {
            error_log('USERMODEL::getId->PDOException' . $e);
        }
    }

    public function getTablasPorEstado($state)
    {
        // creamos un arreglo para retornar la data 
        $items = [];
        // creamos el try catch ya que se va interactuar con la bd
        try {
            // creamos la query con prepare ya que se va insertar data en la consulta para buscar por estado de mesa

            $query = $this->prepare("SELECT * FROM mesas ms WHERE ms.estado = :estado");
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
                $item->setIdMesa($row['id_mesa']);

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
            $sql = "SELECT * FROM mesas";

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

            if ($registrosPorPagina != null && $registrosPorPagina != -1 || $inicio != null) {
                $sql .= " LIMIT " . $registrosPorPagina . " OFFSET " . $inicio;
            }

            $query = $this->query($sql);

            while ($p = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new MesasModel();

                $item->setIdMesa($p['id_mesa']);
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
            $query = $this->query("SELECT COUNT(*) as total FROM mesas");
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            error_log('MesasModel::totalRegistros - ' . $e->getMessage());
            return 0;
        }
    }

    public function totalRegistrosFiltrados($busqueda)
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM mesas;";

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
            'id_mesa'=>$this->idMesa,
            'numeroMesa' => $this->numeroMesa,
            'estado' => $this->estado,
        ];
    }

    public function consultarTodos()
    {
    }

    public function actualizar($id) {
        // usamos try catch ya que vamos a interactuar con la BD
        try {
            // creamos la query para actualizar
            $query = $this->prepare('UPDATE mesas SET numero_mesa = :numero_mesa, estado = :estado WHERE id_mesa = :id');
            // ejecutamos la query para actualizar
            $query->execute([
                'id' => $id,
                'estado' => $this->estado,
                'numero_mesa' => $this->numeroMesa
            ]);

            // validamos que la query se ejecuta correctamente y afecta una columna
            if ($query->rowCount() > 0) {
                return true;
            } else {
                error_log('MesasModel::update -> No se actualizo ninguna fila');
                return false;
            }
        } catch (PDOException $e) {
            error_log("MesasModel::actualizar->PDOException " . $e);
        }
    }

    public function actualizarEstado($id) {

        // usamos try catch ya que vamos a interactuar con la BD
        try { 
            // creamos la query para actualizar
            $query = $this->prepare('UPDATE mesas SET estado = :estado WHERE id_mesa = :id');
            // ejecutamos la query para actualizar
            $query->execute([
                'id'=>$id,
                'estado'=>$this->estado
            ]);

            // validamos que la query se ejecuta correctamente y afecta una columna
            if($query->rowCount() > 0) { 
                return true;
            }else { 
                error_log('MesasModel::update -> No se actualizo ninguna fila'); 
                return false;
            }
        }catch(PDOException $e) { 
            error_log("MesasModel::actualizar->PDOException ".$e);
        }
    }

    public function borrar($id) {
        try {
            error_log("MesasModel::borrar -> funcion para borrar la mesa");
            $query = $this->prepare('DELETE FROM mesas WHERE id_mesa = :id_mesa');
            
            $query->execute([
                'id_mesa' => $id
            ]);

            return true;
        } catch (PDOException $e) {
            error_log('MesasModel::borrar -> PDOException' . $e);
            return false;
        }
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

    public function getIdMesa()
    {
        return $this->idMesa;
    }

    public function setNumeroMesa($numero)
    {
        $this->numeroMesa = $numero;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function setIdMesa($mesa)
    {
        $this->idMesa = $mesa;
    }
}
?>