<?php
# Importar modelo de abstracción de base de datos
session_start();
if(!class_exists('DBAbstractModel')){require_once('../../core/db_abstract_model.php');}

class General extends DBAbstractModel{
    #propiedades
    public $usua_nombres;
    public $usua_apellidos;
    public $usua_correo;
    public $usua_codigo;
    public $usua_estado;
    public $rol_descripcion;
    public $puntaje_total;
    public $login_mensaje;
   
    #metodos
    /*
     * Consulta un usuario especifico
     * @param string Correo Electronico del usuario
     * @access public
     */
    public function login($codigo="",$clave="")
	{	if($codigo!="")
		{	$this->parametros = array($codigo,$clave);
            if ($_SESSION['rol_descripcion'] =='empleado') 
				$this->sp = "usua_login2";
			else
				$this->sp = "usua_login";
            $this->executeSPConsulta();
        }
        if (count($this->rows)>1)
		{	foreach($this->rows[0] as $propiedad=>$valor)
			{	$this->$propiedad=$valor;
            }
            //$this->mensaje="OK";
        }
		else
		{	//$this->mensaje=$this->login_mensaje;
        }
    }
    public function login2($codigo="",$clave="")
	{	if($codigo!="")
		{	$this->parametros = array($codigo,$clave);
            $this->sp = "usua_login2";
            $this->executeSPConsulta();
        }
        if (count($this->rows)>1)
		{	foreach($this->rows[0] as $propiedad=>$valor)
			{	$this->$propiedad=$valor;
            }
            //$this->mensaje="OK";
        }
		else
		{	//$this->mensaje=$this->login_mensaje;
        }
    }
	public function change_pass($data=array()) {
    if (array_key_exists('username',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($username,$newpass);
            if ($_SESSION['rol_descripcion'] =='empleado') 
				$this->sp = "usuario_change_pass2";
			else
				$this->sp = "usuario_change_pass";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Contraseña actualizada exitosamente";
            }else{
                $this->mensaje="No se ha actualizado la contraseña";
            }
        }else{
            $this->mensaje="No se ha actualizado la contraseña - Falta nombre de usuario";
        }
    }
	public function get_solicitudesIn_graphByMonth($peri_codigo=0){
        $this->parametros = array($peri_codigo);
        $this->sp = "solicitudes_in_graph";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $tmp = array();
            foreach($this->rows as $solicitudes){
                array_push($tmp, array_values($solicitudes));
            }
			array_pop($tmp);
            $this->rows = $tmp;
            unset($tmp);
        }else{
            $this->mensaje="Solicitudes no encontrados";
        }
    }
	public function get_solicitudesIn_graphByCourse($peri_codigo=0){
        $this->parametros = array($peri_codigo);
        $this->sp = "solicitudes_in_graph_by_course";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $tmp = array();
            foreach($this->rows as $solicitudes){
                array_push($tmp, array_values($solicitudes));
            }
			array_pop($tmp);
            $this->rows = $tmp;
            unset($tmp);
        }else{
            $this->mensaje="Solicitudes no encontrados";
        }
    }
	public function get_solicitudesIn_graphByGenre($peri_codigo=0){
        $this->parametros = array($peri_codigo);
        $this->sp = "solicitudes_in_graph_by_genre";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $tmp = array();
            foreach($this->rows as $solicitudes){
                array_push($tmp, array_values($solicitudes));
            }
			array_pop($tmp);
            $this->rows = $tmp;
            unset($tmp);
        }else{
            $this->mensaje="Solicitudes no encontrados";
        }
    }
	public function get_solicitudesIn_graphByAdvertising($peri_codigo=0){
        $this->parametros = array($peri_codigo);
        $this->sp = "solicitudes_in_graph_by_advertising";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $tmp = array();
            foreach($this->rows as $solicitudes){
                array_push($tmp, array_values($solicitudes));
            }
			array_pop($tmp);
            $this->rows = $tmp;
            unset($tmp);
        }else{
            $this->mensaje="Solicitudes no encontrados";
        }
    }
	public function get_solicitudesIn_graphByState($peri_codigo=0){
        $this->parametros = array($peri_codigo);
        $this->sp = "solicitudes_in_graph_by_state";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $tmp = array();
            foreach($this->rows as $solicitudes){
                array_push($tmp, array_values($solicitudes));
            }
			array_pop($tmp);
            $this->rows = $tmp;
            unset($tmp);
        }else{
            $this->mensaje="Solicitudes no encontrados";
        }
    }
	public function get_solicitudesIn_graphByLocation($peri_codigo=0){
        $this->parametros = array($peri_codigo);
        $this->sp = "solicitudes_in_graph_by_location";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $tmp = array();
            foreach($this->rows as $solicitudes){
                array_push($tmp, array_values($solicitudes));
            }
			array_pop($tmp);
            $this->rows = $tmp;
            unset($tmp);
        }else{
            $this->mensaje="Solicitudes no encontrados";
        }
    }
	public function get_fecha_head_reportes()
	{	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$fecha_det='Guayaquil, '.$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y'). '.';
		return $fecha_det;
	}
	public function pasarMayusculas($cadena)
	{   $cadena = str_replace("ñ", "Ñ", $cadena); 
		$cadena = str_replace("á", "Á", $cadena); 
		$cadena = str_replace("é", "É", $cadena); 
		$cadena = str_replace("í", "Í", $cadena); 
		$cadena = str_replace("ó", "Ó", $cadena); 
		$cadena = str_replace("ú", "Ú", $cadena); 
		return ($cadena); 
	}	
	public function pasarMinusculas($cadena)
	{   $cadena = str_replace("Ñ", "ñ", $cadena); 
		$cadena = str_replace("Á", "á", $cadena); 
		$cadena = str_replace("É", "é", $cadena); 
		$cadena = str_replace("Í", "í", $cadena); 
		$cadena = str_replace("Ó", "ó", $cadena); 
		$cadena = str_replace("Ú", "ú", $cadena); 
		return ($cadena); 
	}
	public function validarTildeHTML($cadena)
	{   $cadena = str_replace("Ñ", "&Ntilde;", $cadena);
		$cadena = str_replace("Á", "&Aacute;", $cadena);
		$cadena = str_replace("É", "&Eacute;", $cadena);
		$cadena = str_replace("Í", "&Iacute;", $cadena);
		$cadena = str_replace("Ó", "&Oacute;", $cadena);
		$cadena = str_replace("Ú", "&Uacute;", $cadena);
		$cadena = str_replace("ñ", "&ntilde;", $cadena); 
		$cadena = str_replace("á", "&Aacute;", $cadena);
		$cadena = str_replace("é", "&Eacute;", $cadena);
		$cadena = str_replace("í", "&Iacute;", $cadena);
		$cadena = str_replace("ó", "&Oacute;", $cadena);
		$cadena = str_replace("ú", "&Uacute;", $cadena); 
		return ($cadena); 
	}
	public function PrimeraMayuscula($string)
	{	$string = ucwords($this->pasarMinusculas($string));
		foreach (array('-', '\'') as $delimiter)
		{	if (strpos($string, $delimiter)!==false)
			{	$string = implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
			}
		}
		return $string;
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
/*NO QUITAR DE AQUÍ, 2 DE ABRIL, 2016.*/
require_once('../../includes/tcpdf/tcpdf.php');
class MYPDF extends TCPDF
{	public function Header() 
	{}
	public function Footer() 
	{}
}
?>