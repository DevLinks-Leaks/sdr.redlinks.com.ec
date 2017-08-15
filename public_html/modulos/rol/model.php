<?php
require_once('../../core/db_abstract_model.php');

class Rol extends DBAbstractModel{
    #propiedades
    protected $rol_codigo;
    public $rol_descripcion;

	public function get_all(){
        $this->parametros = array();
        $this->sp = "roles_all";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Roles encontrados";
        }else{
            $this->mensaje="Roles no encontrados";
        }
    }
	public function get_all_roles(){
        $this->parametros = array();
        $this->sp = "roles_all";
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
            $this->sp = "roles_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Rol encontrado";
        }else{
            $this->mensaje="Rol no encontrado";
        }
    }
    public function set ($data=array()){
        if (array_key_exists('descripcion',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($descripcion, $usua_codigo);
            $this->sp = "roles_ins";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Rol agregado exitosamente";
            }else{
                $this->mensaje="No se ha agregado el rol";
            }
        }else{
            $this->mensaje="No se ha agregado el rol - Falta la descripción del mismo";
        }
    }
    public function edit($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        $this->parametros = array($codigo, $descripcion);
        $this->sp = "roles_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Rol actualizado exitosamente";
        }else{
            $this->mensaje="Rol no actualizado";
        }
    }
    public function delete($codigo="") {
        $this->parametros = array($codigo);
        $this->sp = "roles_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Rol eliminado exitosamente";
        }else{
            $this->mensaje="No se ha eliminado el rol";
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