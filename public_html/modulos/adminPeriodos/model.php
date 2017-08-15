<?php
session_start();
if(!class_exists('DBAbstractModel')){require_once('../../core/db_abstract_model.php');}

class saldoaFavor extends DBAbstractModel{
    #propiedades
    public $banc_nombre;
   
    protected $banc_codigo;
	public $banc_estado;
	public $banc_fechcreacion;
	public $banc_usucreacion;
   
    #metodos
    /*
     * Consulta un usuario especifico
     * @param string Correo Electronico del usuario
     * @access public
     */
    public function get_all( $peri_codi, $mes )
	{   
        if ($_SESSION['rol_descripcion'] =='empleado') 
		{	$this->parametros = array( $peri_codi, $mes, $_SESSION['usua_codigo'] );
			$this->sp = "str_consultaPuntaje_busq2";
		}
		else
		{	$this->parametros = array( $peri_codi, $mes  );
			$this->sp = "str_consultaPuntaje_busq";
		}
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Carteras de puntajes encontradas";
        }
		else
		{   $this->mensaje="¡Error! Carteras de puntajes no encontradas";
        }
    }
	
	public function get_saf_historico( $cabeSaf_codigo  )
	{   $this->parametros = array( $cabeSaf_codigo  );
        $this->sp = "str_consultaPuntaje_hist";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Historico de saldo a favor encontrado";
        }
		else
		{   $this->mensaje="¡Error! Historico de saldo a favor no encontrado";
        }
    }
	
    public function set( $peri_codi, $mes, $valor, $usuario, $cabePun_codigo, $observacion, $concepto )
	{   if ( $valor == '' )
			$valor = 0;
		$this->parametros = array( $peri_codi, $mes, $valor, $usuario, $cabePun_codigo, $observacion, $concepto);
		//El procedimiento tiene otra variable, id_documento. que por aquí no se envía, así que se 'manda' como NULL.
		$this->sp = "str_consultaPuntaje_add";
		$this->executeSPAccion();
		if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Puntaje modificado exitosamente";
		}
		else
		{   $this->mensaje="¡Error! No se ha podido completar la modificacion".$this->error['mySQLmensaje'];
		}
		return $this->mensaje.$this->error['mySQLmensaje'];
	}
	public function month_general_info( $peri_codi )
	{   $this->parametros = array( $peri_codi );
		//El procedimiento tiene otra variable, id_documento. que por aquí no se envía, así que se 'manda' como NULL.
		$this->sp = "month_general_info";
		$this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Informacion cargada correctamente";
		}
		else
		{   $this->mensaje="¡Error! No se ha podido abrir el mes";
		}
		return $this->mensaje;
	}
	public function search_month( $peri_codi )
	{   $this->parametros = array( $peri_codi );
		//El procedimiento tiene otra variable, id_documento. que por aquí no se envía, así que se 'manda' como NULL.
		$this->sp = "month_search";
		$this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Informacion cargada correctamente";
		}
		else
		{   $this->mensaje="¡Error! No se ha podido abrir el mes";
		}
		return $this->mensaje;
	}
	public function open_month( $peri_codi, $mes, $puntaje_inicial, $usuario )
	{   $this->parametros = array( $peri_codi, $mes, $puntaje_inicial, $usuario );
		//El procedimiento tiene otra variable, id_documento. que por aquí no se envía, así que se 'manda' como NULL.
		$this->sp = "month_open";
		$this->executeSPConsulta();
        if (count($this->rows)>0)
		{   if ( $this->rows[0]['PROCESO'] == 'OK' )
				$this->mensaje="¡Exito! Mes abierto correctamente";
			else
				$this->mensaje="¡Error! No se ha podido abrir el mes";
		}
		else
		{   $this->mensaje="¡Error! No se ha podido abrir el mes";
		}
		return $this->mensaje;
		//var_dump($this->error['mySQLmensaje']);
	}
    public function close_month( $peri_codi, $mes, $usua_codigo )
	{   $this->parametros = array( $peri_codi, $mes, $usua_codigo );
        $this->sp = "month_close";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Mes cerrado correctmente";
        }
		else
		{   $this->mensaje="¡Error! No se ha podido cerrar el mes";
        }
    }
	public function get_reporte_puntaje( $peri_codi )
	{   $this->parametros = array( $peri_codi );
        $this->sp = "str_consultarpt_puntajes";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Registro(s) de persona(s) con puntaje encontrado(s)";
        }else{
            $this->mensaje="Registro(s) de persona(s) con puntaje NO encontrado(s)";
        }
    }
	
    public function saldo_marcar_como_devuelto($codigo='')
	{   $this->parametros = array($codigo);
        $this->sp = "str_consultaSaldo_devolver";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="¡Exito! ¡Saldo a favor marcado como devuelto!";
        }else{
            $this->mensaje="¡Error! No se completó la operación";
        }
    }
	public function set_saldoafavor_config( $saldo )
	{	$this->parametros = array( $saldo );
        $this->sp = "str_consultaSaldoadavor_config_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{	$this->mensaje="¡Exito! Su configuración ha sido cambiada.";
        }
		else
		{	$this->mensaje="¡Error! Ocurrió un problema con el cambio de la configuración";
        }
    }
	public function get_saldoafavor_config()
	{   $this->parametros = array();
        $this->sp = "str_consultaSaldoadavor_config_info";
        $this->executeSPConsulta();
        if(count($this->rows)>0)
		{	foreach($this->rows[0] as $propiedad=>$valor)
			{	$this->$propiedad=$valor;
            }
        }
		else
		{	$this->mensaje="KO";
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