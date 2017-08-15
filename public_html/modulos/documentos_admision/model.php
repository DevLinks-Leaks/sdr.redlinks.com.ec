<?php
//session_start();
require_once('../../core/db_abstract_model.php');

class docAdmin extends DBAbstractModel{
    #propiedades
    protected $docu_codi;
    public $docu_descr;
    public $docu_peri_codi;
    public $desc_estado;

	public function get_all($peri_codi="",$texto="%")
	{   $this->parametros = array($peri_codi, $texto);
		$this->sp = "docu_busq";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Documento(s) encontrado(s).";
        }
		else
		{   $this->mensaje="Documento(s) no encontrado(s).";
        }
        return $this->rows;
    }
	public function set ( $data=array( ) )
	{   $oneEmpty = false;
		foreach( $data as $val )
		{	if(strlen($val)==0)
			{	$oneEmpty = true;
			}
		}
		if($oneEmpty == false)
		{   if (array_key_exists( 'docu_descr', $data ) && array_key_exists( 'peri_codi', $data ) )
			{   foreach($data as $campo=>$valor)
				{   $$campo=$valor;
				}
				$this->parametros = array($docu_descr,$peri_codi);
				$this->sp = "str_admisiones_documento_periodo_add";
				$this->executeSPAccion();
				if($this->filasAfectadas>0){
					$this->mensaje="¡Exito! Documento agregado exitosamente";
				}else{
					$this->mensaje="¡Error! No se ha agregado el documento";
				}
			}else{
				$this->mensaje="¡Error! No se ha agregado el documento.";
			}
		}
		else
		{   $this->mensaje="¡Error! Faltan campos importantes.";
		}
		return $this;
    }
	public function edit($data=array())
	{   $oneEmpty = false;
		foreach( $data as $val )
		{	if(strlen($val)==0)
			{	$oneEmpty = true;
			}
		}
		if($oneEmpty == false)
		{   if (array_key_exists('docu_codi',$data) && array_key_exists('docu_descr',$data))
			{   foreach($data as $campo=>$valor)
				{   $$campo=$valor;
				}
				$this->parametros = array($docu_codi,$docu_descr);
				$this->sp = "docu_upd";
				$this->executeSPConsulta();
				if(count($this->rows)>0)
				{   $this->mensaje="¡Exito! Documento modificado exitosamente";
				}else
				{   $this->mensaje="¡Error! No se ha modificado el documento";
				}
			}
			else
			{   $this->mensaje="¡Error! No se ha modificado el documento.";
			}
		}
		else
		{   $this->mensaje="¡Error! Faltan campos importantes.";
		}
		return $this;
    }
	//set_alumno_documento y el sp 'docu_check' sirven para checar por periodo activo los documentos desde el Mantenimiento.
	public function check($check, $docu_codi, $peri_codi, $docu_peri_codi)
	{   if ($check =='true')$check = 1;
		if ($check =='false')$check = 0;
		$this->parametros = array($check, $docu_codi, $peri_codi, $docu_peri_codi);
		$this->sp = "docu_check";
		$this->executeSPConsulta();
		if(count($this->rows)>0)
		{   $this->mensaje="¡Exito! Checado.";
		}
		else
		{   $this->mensaje="¡Error! No se pudo hacer checado.";
		}
		return $this;
    }
	public function delete($docu_codi) {
        $this->parametros = array($docu_codi);
        $this->sp = "docu_del";
		$this->executeSPConsulta();
		if(count($this->rows)>0)
		{   $this->mensaje="¡Exito! Documento eliminado exitosamente.";
        }
		else
		{   $this->mensaje="¡Error! No se ha eliminado el documento.";
        }
		return $this;
		//falta auditoría.
    }
	public function ver_docu_solicitud( $per_codi, $peri_codi )
	{   $this->parametros = array( $per_codi, $peri_codi );
		$this->sp = "str_admisiones_docu_ver";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Documento(s) encontrado(s).";
        }
		else
		{   $this->mensaje="¡Error! Documento(s) no encontrado(s).";
        }
        return $this->rows;
    }
	public function ver_sintesis_solicitud( $soli_codi )
	{	$this->id_solicitud_out = 0;
		$this->parametros =	array( $soli_codi );
        $this->sp = "str_admisiones_sintesis_ver";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Sintesis encontrada(s).";
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema al intentar procesar su solicitud. Por favor, intente nuevamente luego de unos minutos..";
        }
		return $this;
    }
	public function subir_persona_documento( $per_codi, $peri_codi, $docu_peri_codi, $per_docu_peri_nom_file = "" )
	{	$this->id_solicitud_out = 0;
		$this->parametros =	array( $per_codi, $peri_codi, $docu_peri_codi, $per_docu_peri_nom_file );
        $this->sp = "str_admisiones_docu_upload";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Documento subido exitosamente.";
			$this->id_solicitud_out = $this->rows[0]['docu_peri_codi'];
			$this->estado_out = $this->rows[0]['fecha_reg'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema al intentar procesar su solicitud. Por favor, intente nuevamente luego de unos minutos..";
        }
		return $this;
    }
	public function subir_persona_sintesis( $soli_codi, $soli_sint_codi=0, $soli_sist_docu_nom_file, $soli_sint_docu_desc = "", $usuario_o_ip_forwarded, $ip_remote )
	{   if($soli_sint_codi == "") $soli_sint_codi = 0; $this->parametros = array( $soli_codi, $soli_sint_codi, $soli_sist_docu_nom_file, $soli_sint_docu_desc, $usuario_o_ip_forwarded, $ip_remote );
		$this->sp = "str_admisiones_sintesis_upload";
		$this->executeSPConsulta();
		if(count($this->rows)>0)
		{   $this->mensaje="¡Exito! Sintesis subida(s) exitosamente.".$this->error['mySQLmensaje'];
		}
		else
		{   $this->mensaje="¡Error! No se pudo hacer la carga.".$this->error['mySQLmensaje'];
		}
		return $this;
    }
	public function docAdmin_validar_documento( $check, $per_codi, $docu_peri_codi )
	{   if ($check =='true')$check = 1;
		if ($check =='false')$check = 0;
		$this->parametros = array( $check, $per_codi, $docu_peri_codi );
		$this->sp = "str_admisiones_alum_info_docu_check";
		$this->executeSPConsulta();
		if(count($this->rows)>0)
		{   $this->mensaje="¡Exito! Documento validado exitosamente.";
		}
		else
		{   $this->mensaje="¡Error! No se pudo validar el documento.";
		}
		return $this;
    }
	public function docAdmin_sintesis_solicitud_borrar( $soli_codi, $soli_sint_codi, $usuario_o_ip_forwarded, $ip_remote )
	{   $this->parametros = array( $soli_codi, $soli_sint_codi, $usuario_o_ip_forwarded, $ip_remote );
		$this->sp = "str_admisiones_sintesis_erase";
		$this->executeSPConsulta();
		if(count($this->rows)>0)
		{   $this->mensaje="¡Exito! Síntesis borrada exitosamente.";
		}
		else
		{   $this->mensaje="¡Error! No se pudo borrar el documento.";
		}
		return $this;
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