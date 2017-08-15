<?php
require_once('../../core/db_abstract_model.php');

class Representante extends DBAbstractModel{
    #propiedades
    protected $codigo;
    public $tipoPersona;
    public $nombres;
    public $apellidos;
    public $tipoIdentificacion;
    public $numeroIdentificacion;
    public $direccion;
    public $telefono;
    public $email;
    public $estadoCivil;
    public $fechaNacimiento;
    public $estado;

	public function get_representante( $alum_codi = "" ){
        $this->parametros = array( $alum_codi );
        //$this->sp = "str_consultaRepresentante_busq";
		$this->sp = "repr_alum_info";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="¡Exito! Representante(s) encontrado(s)";
        }else{
            $this->mensaje="¡Error! Representante(s) no encontrado(s)";
        }
		return $this;
    }
	public function get_representante_new( $estudiante_per_codi )//trae representantes, 1+ fila(s)
	{   $this->parametros = array( $estudiante_per_codi );
		$this->sp = "str_admisiones_solicitud_repr_consulta_resumen";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="¡Exito! Representante(s) encontrado(s)";
        }else{
            $this->mensaje="¡Error! Representante(s) no encontrado(s)";
        }
        return $this->rows;
	}
	public function set_main_finan( $alum_codi, $repr_codi ){
        $this->parametros = array( $alum_codi, $repr_codi );
		$this->sp = "repr_finan_alum_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="¡Exito! Representante financiero actualizado.";
        }else{
            $this->mensaje="¡Error! No se pudo actualizar representante.";
        }
		return $this;
    }
	public function set_main( $alum_codi, $repr_codi ){
        $this->parametros = array( $alum_codi, $repr_codi );
		$this->sp = "repr_alum_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="¡Exito! Representante principal actualizado.";
        }else{
            $this->mensaje="¡Error! No se pudo actualizar representante.";
        }
		return $this;
    }
	public function set_repr_finan($alum_codi, $repr_codi, $relacion ){
        $this->parametros = array( $alum_codi, $repr_codi, $relacion );
		$this->sp = "str_repr_finan_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="¡Exito! Representante financiero actualizado.";
        }else{
            $this->mensaje="¡Error! No se pudo actualizar representante.";
        }
		return $this;
    }
	public function set_repr_acad( $alum_codi, $repr_codi, $relacion ){
        $this->parametros = array( $alum_codi, $repr_codi, $relacion );
		$this->sp = "str_repr_acad_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="¡Exito! Representante académico actualizado.";
        }else{
            $this->mensaje="¡Error! No se pudo actualizar representante.";
        }
		return $this;
    }
	public function actualizar_facturas_por_autorizar( $alum_codi ){
        $this->parametros = array( $alum_codi );
		$this->sp = "str_consultaRepr_factura_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="¡Exito! Facturas y deudas actualizadas correctamente.";
        }else{
            $this->mensaje="¡Error! No se pudo actualizar las facturas.";
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