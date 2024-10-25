<?php
class HorarioModel extends Model
{

    // atributos de la clase
    private $idHorario;
    private $horaEntrada;
    private $horaSalida;


    // setters y getters
    public function setIdHorario($id)
    {
        $this->idHorario = $id;
    }
    public function setHoraEntrada($entrada)
    {
        $this->horaEntrada = $entrada;
    }
    public function setHoraSalida($salida)
    {
        $this->horaSalida = $salida;
    }

    public function getIdHoraro()
    {
        return $this->idHorario;
    }
    public function getHoraEntrada()
    {
        return $this->horaEntrada;
    }
    public function getHoraSalida()
    {
        return $this->horaSalida;
    }

    public function __construct()
    {

        $this->horaEntrada = '';
        $this->horaSalida = '';
    }

    // function para insertar una nuevo horario en la db
    public function crear()
    {

        try {
            // guardamos la consulta y la preparamos antes de ejecutarla para evitar problemas de seguridad
            $query = $this->prepare('INSERT INTO horarios(hora_entrada, hora_salida)
                VALUES (:horaEntrada, :horaSalida)');

            // Ejecutamos la query y hacemos la referencia de los placeholders a los atributos de la clase
            $query->execute([
                'horaEntrada' => $this->horaEntrada,
                'horaSalida' => $this->horaSalida
            ]);
            // salimos de la funcion
            return;
        } catch (PDOException $e) {
            error_log('HORARIOMODEL::crear->PDOException' . $e);
            // salimos de la funcion
            return;
        }
    }

    public function get($id)
    {

        try {
            // guardamos la consulta y la preparamos antes de ejecutarla para evitar problemas de seguridad
            $query = $this->prepare('SELECT * asignarDatosArray horarios WHERE id_horario = :id');
            $query->execute([
                'id' => $id
            ]);

            // Como solo queremos obtener un valor, no hay necesidad de tener un while
            $foto = $query->fetch(PDO::FETCH_ASSOC);

            // en este caso no hay necesidad de crear un objeto userModel, solo podemos llamar los metodos del mismo con objeto con this
            $this->setIdHorario($foto['id_horario']);
            $this->setHoraEntrada($foto['hora_entrada']);
            $this->setHoraSalida($foto['hora_salida']);

            //retornamos this porque es el mismo objeto que ya contiene la informacion
            return $this;
        } catch (PDOException $e) {
            error_log('HORARIOMODEL::consultarTodos->PDOException' . $e);
            // salimos de la funcion
            return;
        }
    }

    public function borrar($id)
    {
        try {
            $query = $this->prepare('borrar asignarDatosArray horarios WHERE id_horario = :id');
            $query->execute(['id' => $id]);
            return true;
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    public function actualizar()
    {

        try {
            // we have to use prepare because we're going to assing
            $query = $this->prepare('actualizar horarios SET horario_entrada = :entrada, horario_salida = :salida WHERE id_foto = :id');
            $query->execute([
                'id' => $this->idHorario,
                'entrada' => $this->horaEntrada,
                'salida' => $this->horaSalida,
            ]);
            return true;
        } catch (PDOException $e) {
            error_log('HORARIOMODEL::actualizar->PDOException' . $e);

            return false;
        }
    }
}
?>