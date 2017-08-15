<?php
/* 
 * Clase para establecer la conexión con la BD y gestion de los procesos a ejecutar.
 * @package core
 * @abstract
 */
 session_start();


//require_once('../core/db_abstract_model.php');

abstract class DBAbstractModel{
	
    private $configuracion;     /*Arreglo con la configuracion global de conexion del archivo settings.ini.php. @var array @access private */
    private $connectionInfo;    /*Arreglo con la configuracion de conexion a la BD. @var array @access private */
    private $conn;              /*Objeto de conexion @var object @access Private  */
    protected $query;           /*Sentencia SQL a ejecutar @var string @access protected */
    protected $sp;              /*Nombre del procedimiento almacenado a ejecutar @var string @access protected */
    protected $parametros;      /*Arreglo con los valores de los parametros de los procedimientos almacenados @var array @access */
    public $rows= array();      /*Filas devueltas de la consulta @var array @access Public */
    public $filasAfectadas = 0; /*Numero de filas afectadas con la sentencia o procedimiento almacenado @var integer @access public */
    public $filasDevueltas = 0; /*Numero de filas devuletas con la sentencia o procedimiento almacenado @var integer @access public */
    public $error = array();    /*Arreglo con los errores por excepcion o de BD. @var array @access public */
    
    public $mensaje;
	public $temp;
	
    # métodos abstractos para ABM de clases que hereden
    /*abstract protected function get();
    abstract protected function set();
    abstract protected function edit();
    abstract protected function delete();*/
    # los siguientes métodos pueden definirse con exactitud y
    # no son abstractos 
    # Conectar a la base de datos

    
    /*
     * Crea la conexion a la base de datos.
     * 
     * @access Private
     */
    private function open_connection(){
        $this->configuracion = parse_ini_file("settings.ini.php");
        $this->connectionInfo = array(	$this->configuracion['host'], 
        								$this->configuracion['user'], 
        								$this->configuracion['pass'], 
        								$this->configuracion['dbname']);
        $this->conn= new mysqli($this->configuracion['host'],$this->configuracion['user'], $this->configuracion['pass'], $this->configuracion['dbname']);
        if( $this->conn->connect_errno){
			echo "Failed to connect to MySQL: (" . $this->conn->connect_errno . ") " . $this->conn->connect_error;
        }
    }
    /*
     * Cierra la conexion existente con la base de datos.
     * 
     * @access Private
     */
    private function close_connection(){
        mysqli_close($this->conn);
    }
    /*
     * Mantiene de manera temporal informacion del error ocurrido.
     * 
     * @access Private
     * @param String $funcion Nombre del procedimiento donde sucedio el error.
     * @param String $sentencia Nombre de la sentencia o procedimiento almacenado donde se origino el error.
     * @param String $excecion Mensaje del error arrojado por el try catch.
     * @param Array $sqlsrv Arreglo con los errores generados por la libreria sqlsrv.
     */
    private function guardaError($funcion = '', $sentencia = '', $excepcion = ''){
        $this->error['funcion'] = $funcion;
        $this->error['sentencia'] = $sentencia;
        $this->error['excepcion'] = $excepcion;
		$this->error['mySQLestado'] = $this->conn->sqlstate;
		$this->error['mySQLcodigo'] = $this->conn->errno;
		$this->error['mySQLmensaje'] = $this->conn->error;						
    }
    /*
     * Retorna lo almacenado en el arreglo $error formateado en un mensaje tecnico.
     * @access Public
     * @return String Mensaje del error.
     */
    public function ErrorToString(){
        $mensaje = "";
        if(count($this->error)>0){
            $mensaje = " Error en la funcion ".$this->error['funcion'].", al ejecutar la sentencia ".$this->error['sentencia'];
            $mensaje .= "Excepcion: ".$this->error['excepcion'];
            $mensaje .= "MySQLSTATE: ".$this->error['mySQLestado']."; MySQLCODE: ".$this->error['mySQLcodigo']."; MySQLMESSAGE: ".$this->error['mySQLmensaje'];
        }
        return $mensaje;	
    }
	  /*
     * Crea las variables que serán enviada en los parámetros del procedimiento almacenado
     * 
     * @access Private
     * @return String Ejemplo de variables: $mysqli->query("SET @variable  = " . "'" . $mysqli->real_escape_string("Valor") . "'");
     */
    private function parametrizacion_1(){
		$cont=1;
        if(count($this->parametros)>0){
            foreach($this->parametros as $parametro){
                $this->conn->query("SET @p".$cont." ='".$this->conn->real_escape_string($parametro)."'");
				$cont++;
            }
        }
    }
    /*
     * Genera el patron de parametrizacion del procedimiento almacenado deacuerdo al numero de 
     * elementos definidos en la variable $parametros.
     * 
     * @access Private
     * @return String Patron de parametrizacion: (?,?,..)
     */
    private function parametrizacion_2(){
        $parametrizacion = "";
		$cont=1;
        if(count($this->parametros)>0){
            $parametrizacion = "(";
            foreach($this->parametros as $parametro){
                $parametrizacion .= "@p".$cont.",";
				$cont++;
            }
            $parametrizacion = substr_replace($parametrizacion, ")", -1);
        }
        return $parametrizacion;
    }
    /*
     * Ejecuta un procedimiento almacenado de tipo no consulta.
     * 
     * @access protected
     * @return Integer Numero de filas afectadas.
     */
    protected function executeSPAccion(){
        $this->filasAfectadas = 0;
        try{
            $this->open_connection();
            $this->query = "CALL ".$this->sp.$this->parametrizacion_2();
			$this->parametrizacion_1();
            $result = $this->conn->query($this->query);

            if(!$result){ 
                $this->guardaError("executeSPAccion", $this->sp, "Error MySQL  "); 
            }else{ 
                $this->filasAfectadas = $this->conn->affected_rows; 
            }
            $this->close_connection();          
        }catch(Exception $e){
            $this->guardaError("executeSPAccion", $this->sp, $e->getMessage());
        }
        return $this->filasAfectadas;
    }

    /*protected function executeSPAccionOut(){
        $this->filasAfectadas = 0;
        try{
            $this->open_connection();
            $this->query = "{CALL ".$this->sp.$this->parametrizacion().'}';
            $stmt = sqlsrv_query($this->conn,$this->query,$this->parametros);

            if(!$stmt){ 
                $this->guardaError("executeSPAccion", $this->sp, "Error SQL  ", sqlsrv_errors() ); 
            }else{ 
                sqlsrv_next_result($stmt); // Esto es para los SPs con parametros de salida
                $this->filasAfectadas =  sqlsrv_rows_affected($stmt); 
            }
            sqlsrv_free_stmt($stmt);
            $this->close_connection();          
        }catch(Exception $e){
            $this->guardaError("executeSPAccion", $this->sp, $e->getMessage(), array() );
        }
        return $this->filasAfectadas;
    }*/
    /*
     * Ejecuta un procedimiento almacenado de tipo consulta.
     * 
     * @access protected
     * @return Integer Numero de filas devueltas.
     */
    protected function executeSPConsulta(){
        $this->rows = array();
        $this->filasDevueltas = 0;
        try{
            $this->open_connection();
            $this->query = "CALL ".$this->sp.$this->parametrizacion_2();
			$this->parametrizacion_1();
			$result = $this->conn->query($this->query);
            if(!$result){
                $this->guardaError("executeSPConsulta", $this->sp, "Error MySQL");	
            }else{
                while ($this->rows[]=mysqli_fetch_array($result, MYSQLI_ASSOC));
                $this->filasDevueltas = count($this->rows);
            }
            $this->close_connection();			
        }catch(Exception $e){
            $this->guardaError("executeSPConsulta", $this->sp, $e->getMessage());
        }
        return $this->rows;	
    }
    /*
     * Ejecuta una sentencia de tipo consulta.
     * 
     * @access protected
     * @return Integer Numero de filas devueltas.
     */
    protected function executeSentenciaConsulta(){
        $this->rows = array();
        $this->filasDevueltas = 0;
        try{
            $this->open_connection();
			$result = $this->conn->query($this->query);
            if(!$result){
                $this->guardaError("executeSentenciaConsulta", $this->query, "Error MySQL", "Error MySQL" );	
            }else{
                while ($this->rows[]=mysqli_fetch_array($result, MYSQLI_ASSOC));
                $this->filasDevueltas = count($this->rows);
            }
            $this->close_connection();			
        }catch(Exception $e){
            $this->guardaError("executeSentenciaConsulta", $this->query, $e->getMessage(), array() );
        }
        return $this->rows;	
    }
    /*
     * Ejecuta una sentencia de tipo no consulta.
     * 
     * @access protected
     * @return Integer Numero de filas afectadas.
     */
    protected function executeSentenciaAccion(){
        $this->filasAfectadas = 0;
        try{
            $this->open_connection();
            $result = $this->conn->query($this->query);

            if(!$result){ 
                $this->guardaError("executeSentenciaAccion", $this->query, "Error MySQL  "); 
            }else{ 
                $this->filasAfectadas = $this->conn->affected_rows; 
            }
            $this->close_connection();          
        }catch(Exception $e){
            $this->guardaError("executeSentenciaAccion", $this->query, $e->getMessage());
        }
        return $this->filasAfectadas;
    }
}
?>