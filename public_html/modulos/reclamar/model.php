<?php
require_once('../../core/db_abstract_model.php');

class Premio extends DBAbstractModel{
    #propiedades
    protected $premio_codigo;
    public $premio_descripcion;
	public $premio_puntaje;

	public function get_all_all( )
	{   $this->parametros = array( );
        $this->sp = "premios_all";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Premios encontrados";
        }else{
            $this->mensaje="Premios no encontrados";
        }
    }
	public function get_specific_price_name( $premio_codigo ){
        $this->parametros = array( $premio_codigo );
        $this->sp = "premios_all_alt";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Premio encontrado";
        }else{
            $this->mensaje="Premio no encontrado";
        }
    }
	public function get_users_mails( $rol_codigo )
	{	//Si rol_codigo = -1, trae todos.
        $this->parametros = array( $rol_codigo );
        $this->sp = "str_consulta_usuariosMails";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Usuario encontrado";
        }else{
            $this->mensaje="Usuario no encontrado";
        }
    }
	public function get_all_roles(){
        $this->parametros = array();
        $this->sp = "premios_all";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $tmp = array();
            foreach($this->rows as $roles){
                array_push($tmp, array_values($roles));
            }

            $this->rows = $tmp;
            unset($tmp);
        }else{
            $this->mensaje="Periodos no encontrados";
        }
    }
    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "premios_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Premio encontrado";
        }else{
            $this->mensaje="Premio no encontrado";
        }
    }
    public function set ($data=array()){
        if (array_key_exists('descripcion',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array( $descripcion, $puntos, $usua_codigo );
            $this->sp = "premios_ins";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Premio agregado exitosamente";
            }else{
                $this->mensaje="No se ha agregado el Premio";
            }
        }else{
            $this->mensaje="No se ha agregado el Premio - Falta la descripción del mismo";
        }
    }
    public function edit($data=array())
	{   foreach ($data as $campo=>$valor)
		{   $$campo = $valor;
        }
        $this->parametros = array( $_SESSION['usua_codigo'], $codigo, $_SESSION['peri_codi'] );
        $this->sp = "premios_reclamar";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Premio reclamado correctamente";
        }
		else
		{   $this->mensaje="¡Error! Premio no se pudo reclamar";
        }
		//var_dump($this->mensaje.$this->error['mySQLmensaje']);
    }
    public function delete($codigo="")
	{   $this->parametros = array($codigo);
        $this->sp = "roles_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Premio eliminado exitosamente";
        }
		else
		{   $this->mensaje="¡Error! No se ha eliminado el Premio";
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