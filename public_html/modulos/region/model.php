<?php
session_start();
if(!class_exists('DBAbstractModel')){require_once('../../core/db_abstract_model.php');}
class Region extends DBAbstractModel{
    #propiedades
    protected $CiudadDistritoCodigo;
    protected $CiudadID;
    protected $PaisCodigo;
    public $CiudadDistrito;
    public $CiudadNombre;
    public $PaisNombre;
	
	public function get_Pais( $PaisCodigo )
	{   $this->parametros = array( $PaisCodigo );
        $this->sp = "str_consultaPais_busq";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Pais(es) encontrado(s)";
        }else
		{   $this->mensaje="Pais(es) no encontrado(s)";
        }
    }
	public function get_PaisSelectFormat( $PaisCodigo ){
        $this->parametros = array( $PaisCodigo );
        $this->sp = "str_consultaPais_busq";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen colegios en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'Seleccione...',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'Seleccione...',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{	array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
	public function get_CiudadDistritoSelectFormat( $PaisCodigo, $CiudadDistritoCodigo ){
        $this->parametros = array( $PaisCodigo, $CiudadDistritoCodigo );
        $this->sp = "str_consultaCiudadDistrito_busq";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen colegios en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'Seleccione...',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'Seleccione...',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{	array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
	public function get_CiudadSelectFormat( $PaisCodigo, $CiudadDistritoCodigo, $CiudadID ){
        $this->parametros = array( $PaisCodigo, $CiudadDistritoCodigo, $CiudadID );
        $this->sp = "str_consultaCiudad_busq";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen colegios en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'Seleccione...',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'Seleccione...',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{	array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
    # Método constructor
    function __construct() {
        //$this->db_name = 'URBALINKS_FINAN';
    }
    # Método destructor del objeto
    function __destruct() {
        unset($this);
    }
}
?>