<?php
if(!class_exists('DBAbstractModel')){require_once('../../core/db_abstract_model.php');}

class Interesado extends DBAbstractModel{
    #propiedades
    protected $inte_codigo;
    public $inte_primer_nombre;
	public $inte_segundo_nombre;
	public $inte_nombres;
	public $inte_primer_apellido;
	public $inte_segundo_apellido;
	public $inte_apellidos;
	public $inte_telefono;
	public $inte_celular;
	public $inte_correo;
	

	public function get_all()
	{   $this->parametros = array();
        $this->sp = "interesados_all";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $this->mensaje="Personas interesadas encontradas";
        }
		else
		{   $this->mensaje="Personas interesadas no encontradas";
        }
    }
	public function get_periodos_activos()
	{   $this->parametros = array();
        $this->sp = "periodos_activos_all";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $tmp = array();
            foreach($this->rows as $periodos)
			{   array_push($tmp, array_values($periodos));
            }
            $this->rows = $tmp;
            unset($tmp);
        }
		else
		{   $this->mensaje="Periodos no encontrados";
        }
    }
    public function get_byCabePun( $cabePun_codigo )
	{   if($cabePun_codigo!="")
		{   $this->parametros = array( $cabePun_codigo );
            $this->sp = "interesado_info_byCabePun";
            $this->executeSPConsulta();
        }
        if (count($this->rows)>=1)
		{   foreach($this->rows[0] as $propiedad=>$valor)
			{   $this->$propiedad=$valor;
            }
            $this->mensaje="Interesado encontrado";
        }
		else
		{   $this->mensaje="Interesado no encontrado";
        }
    }
    public function get($codigo="")
	{   if($codigo!="")
		{   $this->parametros = array($codigo);
            $this->sp = "interesado_info";
            $this->executeSPConsulta();
        }
        if (count($this->rows)>=1)
		{   foreach($this->rows[0] as $propiedad=>$valor)
			{   $this->$propiedad=$valor;
            }
            $this->mensaje="Interesado encontrado";
        }
		else
		{   $this->mensaje="Interesado no encontrado";
        }
    }
    public function set ($data=array())
	{   if (array_key_exists('primer_nombre',$data))
		{   foreach($data as $campo=>$valor)
			{   $$campo=$valor;
            }
            $this->parametros = array(	$primer_nombre,	$segundo_nombre,	$primer_apellido,	$segundo_apellido,
										$telefono,		$celular,			$correo,			$usua_codigo,		$_SESSION['peri_codi']);
            $this->sp = "interesado_ins";
            $this->executeSPConsulta();
            if (count($this->rows)>0)
			{   if ( $this->rows[0]['PROCESO'] == 'OK' )
					$this->mensaje="¡Exito! Empleado ingresado correctamente";
				else
					$this->mensaje="¡Error! No se ha podido ingresar el usuario";//.$this->error['mySQLmensaje'];
			}
			else
			{   $this->mensaje="¡Error! No se ha podido ingresar el usuario";//.$this->error['mySQLmensaje'];
            }
        }
		else
		{   $this->mensaje="No se ha agregado el interesado - Faltan datos del mismo";
        }
		//return $this->mensaje.$this->error['mySQLmensaje'];
		//var_dump($this->error['mySQLmensaje']);
    }
    public function edit($data=array())
	{   if (array_key_exists('primer_nombre',$data))
		{   foreach($data as $campo=>$valor)
			{   $$campo=$valor;
            }
            $this->parametros = array($codigo,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$telefono,$celular,$correo,$usua_codigo);
            $this->sp = "interesado_upd";
            $this->executeSPAccion();
            if($this->filasAfectadas>0)
			{   $this->mensaje="Interesado actualizado exitosamente";
            }
			else
			{   $this->mensaje="No se ha actualizado el interesado";
            }
        }
		else
		{   $this->mensaje="No se ha actualizado el interesado - Faltan datos del mismo";
        }
    }
    public function delete($data=array())
	{   foreach($data as $campo=>$valor)
		{   $$campo=$valor;
    	}
        $this->parametros = array($codigo);
        $this->sp = "interesado_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="Interesado eliminado exitosamente";
        }
		else
		{   $this->mensaje="No se ha eliminado el interesado";
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