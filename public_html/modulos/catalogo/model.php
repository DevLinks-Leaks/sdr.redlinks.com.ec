<?php
require_once('../../core/db_abstract_model.php');

class Catalogo extends DBAbstractModel{
    //put your code here
    protected $idcatalogo;
    public $descripcion;
    protected $idpadre;
    public $cata_estado;
	
	public function set_idpadre($value)
	{   $this->idpadre = $value;
	}
	public function get_idpadre()
	{   return $this->idpadre;
	}
	public function get_all_sons_catalogo( $id_padre )
	{   $this->parametros = array( $id_padre );
        $this->sp = "cata_hijo_view";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Catálogo(s) encontrado(s)";
        }else
		{   $this->mensaje="Catálogo(s) no encontrado(s)";
        }
    }
	public function get_all_sons( $id_padre )
    {   $this->parametros = array( $id_padre );
        $this->sp = "cata_hijo_view";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen categorias en la BD.";
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
	public function get_Cursos( )
    {   $this->parametros = array( );
        $this->query = "select curs_codi, curs_deta from cursos order by curs_orden";
        $this->executeSentenciaConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen categorias en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => '', 
                                   1 => 'Curso al que aplica',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => '', 
                                   1 => 'Curso al que aplica',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{	array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
	# Método constructor
    function __construct()
	{   //$this->db_name = 'URBALINKS_FINAN';
    }
    # Método destructor del objeto
    function __destruct()
	{   unset($this);
    }
}
?>