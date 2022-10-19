<?php
class Connection extends PDO {
    // Conexión local
    //private $dsn = 'mysql:dbname=iieggob_transparencia2;host=localhost';
    //private $usuario = 'root';
    //private $pass = '';

    // Conexión servidor
    private $dsn = 'mysql:dbname=iieggob_transparencia2;host=localhost';
    private $usuario = 'iieggob_transpa';
    private $pass = 'ufLRX2KTXLsK9MH8';

    /*
     * Realiza la conexión cuando se crea el objeto
     */
    public function __construct() {
        try {
            $this->connect();
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    /*
     * Conectar a la base de datos.
     */
    private function connect() {
        parent::__construct($this->dsn, $this->usuario, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        //return new PDO($this->dsn, $this->usuario, $this->pass);
    }

    /*
     * Parametriza y ejectuta la consulta, devuelve el resultado.
     */
    public function execute($query, $params = array()) {
        // Prepara la sentencia
        $sentencia = parent::prepare($query);

        // Por cada parámetro, "parametriza el valor"
        foreach ($params as $key => $value) {
            try { // Intentará parametrizar un valor entero
                $sentencia->bindValue($key, $value, PDO::PARAM_INT);
            } catch (PDOException $ex) { // Si no lo logra, lo toma como string
                $sentencia->bindValue($key, $value);
            }
        }

        // Ejecutar la sentencia
        $sentencia->execute();
        //$sentencia->debugDumpParams();
        //var_dump($sentencia->errorInfo());

        //echo $query;
        //var_dump($params);

        // Retorna los valores
        return $sentencia->fetchAll();
    }


}
?>
