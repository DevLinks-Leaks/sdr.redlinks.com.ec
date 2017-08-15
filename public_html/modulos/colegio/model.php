<?php
require_once('../../core/db_abstract_model.php');

class Colegio extends DBAbstractModel{
    #propiedades
    protected $codigo_codi;
    public $colegio;
    public $colegio_descripcion;
    public $colegio_ciudad;
    public $colegio_ciudad_codi;
    public $colegio_estado;

	public function get_colegioSelectFormat( $colegio_codi="", $colegio_ciudad_codi="" ){
        $this->parametros = array( $colegio_codi, $colegio_ciudad_codi );
        $this->sp = "str_consultaColegio_busq";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen colegios en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => '', 
                                   1 => 'Seleccione...',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => '', 
                                   1 => 'Seleccione...',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{	array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
	public function get_colegio( $colegio_codi="", $colegio_ciudad_codi="" )
	{   $this->parametros = array( $colegio_codi, $colegio_ciudad_codi );
        $this->sp = "str_consultaColegio_busq";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Colegio(s) encontrado(s)";
        }else
		{   $this->mensaje="Colegio(s) no encontrado(s)";
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