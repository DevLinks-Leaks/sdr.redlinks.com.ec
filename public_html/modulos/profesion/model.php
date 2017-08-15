<?php
session_start();
if(!class_exists('DBAbstractModel')){require_once('../../core/db_abstract_model.php');}

class Profesion extends DBAbstractModel{
    #propiedades
    protected 	$profesion_codi;
    public 		$profesion_detalle;
    public 		$profesion_estado;
	
	public function get_Profesion( $profesion_codi = "" )
	{   $this->parametros = array( $profesion_codi );
        $this->sp = "str_consultaProfesion_busq";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Profesion(es) encontrada(s)";
        }else
		{   $this->mensaje="Profesion(es) no encontrada(s)";
        }
    }
	public function get_ProfesionSelectFormat( $profesion_codi = "" )
	{   $this->parametros = array( $profesion_codi );
        $this->sp = "str_consultaProfesion_busq";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen Profesiones en la BD.";
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