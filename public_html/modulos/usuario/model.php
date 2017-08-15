<?php
require_once('../../core/db_abstract_model.php');

class Usuario extends DBAbstractModel{
    #propiedades
    protected $usua_codigo;
    public $usua_nombres;
	public $usua_apellidos;
	public $usua_correo;
	public $rol_descripcion;
	public $usua_estado;

	public function get_all(){
        $this->parametros = array();
        $this->sp = "usuario_all";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Usuarios encontrados";
        }else{
            $this->mensaje="Usuarios no encontrados";
        }
    }
    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "usuario_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Usuario encontrado";
        }else{
            $this->mensaje="Usuario no encontrado";
        }
    }
	public function check_username($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "check_username";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Nombre de usuario encontrado";
        }else{
            $this->mensaje="Nombre de usuario no encontrado";
        }
    }
    public function set ($data=array()){
        if (array_key_exists('usua_codigo',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($usua_codigo,$usua_nombres,$usua_apellidos,$usua_correo,$rol_codigo,$usua_usuaingreso);
            $this->sp = "usuario_ins";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Usuario agregado exitosamente";
            }else{
                $this->mensaje="No se ha agregado al usuario";
            }
        }else{
            $this->mensaje="No se ha agregado el usuario - Falta nombre de usuario";
        }
    }
    public function edit($data=array()) {
    if (array_key_exists('usua_codigo',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($usua_codigo,$usua_nombres,$usua_apellidos,$usua_correo,$rol_codigo,$usua_usuaingreso);
            $this->sp = "usuario_upd";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Usuario actualizado exitosamente";
            }else{
                $this->mensaje="No se ha actualizado el usuario";
            }
        }else{
            $this->mensaje="No se ha actualizado el usuario - Falta nombre de usuario";
        }
    }
    public function delete($data=array()) {
    	foreach($data as $campo=>$valor){
    		$$campo=$valor;
    	}
        $this->parametros = array($codigo);
        $this->sp = "usuario_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Usuario eliminado exitosamente";
        }else{
            $this->mensaje="No se ha eliminado el usuario";
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