<?php
if(!class_exists('DBAbstractModel')){require_once('../../core/db_abstract_model.php');}

class Periodo extends DBAbstractModel{
    #propiedades
    public $peri_codigo;
    public $peri_descripcion;
	public $peri_fechainicio;
	public $peri_fechafin;
	public $peri_estado;
	public $peri_estado_2;

	public function get_all(){
        $this->parametros = array();
        $this->sp = "periodos_all";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Periodos encontrados";
        }else{
            $this->mensaje="Periodos no encontrados";
        }
    }
	public function get_combo_all(){
        $this->parametros = array();
        $this->sp = "periodos_combo_all";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $tmp = array();
            foreach($this->rows as $periodos){
                array_push($tmp, array_values($periodos));
            }

            $this->rows = $tmp;
            unset($tmp);
        }else{
            $this->mensaje="Periodos no encontrados";
        }
    }
	public function get_periodos_activos(){
        $this->parametros = array();
        $this->sp = "periodos_activos_all";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $tmp = array();
            foreach($this->rows as $periodos){
                array_push($tmp, array_values($periodos));
            }

            $this->rows = $tmp;
            unset($tmp);
        }else{
            $this->mensaje="Periodos no encontrados";
        }
    }
	public function get_periodo_activo(){
		$this->parametros = array();
		$this->sp = "periodo_activo_single";
		$this->executeSPConsulta();
        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Periodo encontrado";
        }else{
            $this->mensaje="Periodo no encontrado";
        }
    }
    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "periodo_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Periodo encontrado";
        }else{
            $this->mensaje="Periodo no encontrado";
        }
    }
    public function set ($data=array()){
        if (array_key_exists('descripcion',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($descripcion,$fechainicio,$fechafin, $usua_codigo);
            $this->sp = "periodo_ins";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Periodo agregado exitosamente";
            }else{
                $this->mensaje="No se ha agregado el periodo";
            }
        }else{
            $this->mensaje="No se ha agregado el periodo - Falta la descripción del mismo";
        }
    }
    public function edit($data=array()) {
    if (array_key_exists('descripcion',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($codigo,$descripcion,$fechainicio,$fechafin, $usua_codigo);
            $this->sp = "periodo_upd";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Periodo actualizado exitosamente";
            }else{
                $this->mensaje="No se ha actualizado el periodo";
            }
        }else{
            $this->mensaje="No se ha actualizado el periodo - Falta la descripción del mismo";
        }
    }
    public function delete($data=array()) {
    	foreach($data as $campo=>$valor){
    		$$campo=$valor;
    	}
        $this->parametros = array($codigo,$usua_codigo);
        $this->sp = "periodo_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Periodo eliminado exitosamente";
        }else{
            $this->mensaje="No se ha eliminado el periodo";
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