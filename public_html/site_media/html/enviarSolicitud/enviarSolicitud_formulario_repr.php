<input type="hidden" name="{repr}_codi" 	 id="{repr}_codi" 	   value="{repr_codi}" /> 
<input type="hidden" name="{repr}_empr_codi" id="{repr}_empr_codi" value="{repr_empr_codi}" /> 
<input type="hidden" name="{repr}_per_empr_codi" id="{repr}_per_empr_codi" value="{repr_per_empr_codi}" /> 
<div class="grid">
	<div class="row">
		<div class="col-sm-6">
			<label>RELACIÓN CON EL ESTUDIANTE </label>
		</div>
		<div class="col-sm-6">
			{cmb_persona_relacion}
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			{cmb_repr_tipo_identificacion}
		</div>
		<div class="col-sm-6">
			<input type="text" class="form-control" name="{repr}_numero_identificacion" id="{repr}_numero_identificacion"  required="required" value="{repr_numero_identificacion}"
					placeholder="No. de identificaci&oacute;n" pattern="[a-zA-Z0-9]+"
					maxlength="20" />
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<input name="{repr}_nomb" id="{repr}_nomb"  type="text" class="form-control" value="{repr_nomb}" placeholder="Nombre" 
				pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
		</div>
		<div class="col-sm-6">
			<input name="{repr}_nomb_seg" id="{repr}_nomb_seg"  type="text" class="form-control" value="{repr_nomb_seg}" placeholder="Segundo nombre" 
				pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<input name="{repr}_apel" id="{repr}_apel"  type="text" class="form-control" value="{repr_apel}" placeholder="Apellido paterno" 
				pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
		</div>
		<div class="col-sm-6">
			<input name="{repr}_apel_mat" id="{repr}_apel_mat"  type="text" class="form-control" value="{repr_apel_mat}" placeholder="Apellido materno" 
				pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label>DIRECCIÓN Y TELÉFONO DE DOMICILIO </label>
			<div class="checkbox" style='display:inline;'>
				<label>
					<input type="checkbox" id="ckb_{repr}_per_dir_igual" name="ckb_{repr}_per_dir_igual"
						onchange="js_enviarSolicitud_direccion_igual_a_postulante(this);">
						(Hacer clic aquí si es igual al del postulante)
				</label>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8">
			<input name="{repr}_dir" id="{repr}_dir" type="text" class="form-control" value="{repr_dir}" placeholder="Dirección" maxlength="150"/>
		</div>
		<div class="col-sm-4">
			<input name="{repr}_telf" id="{repr}_telf" type="text" class="form-control" value="{repr_telf}" placeholder="Teléfono"
				pattern='[0-9]+' maxlength="25"/>
		</div>
	</div>
	<!--<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8"></div>
		<div class="col-sm-4">
			<input name="{repr}_email_personal" id="{repr}_email_personal"  type="text" class="form-control" value="{repr_email_personal}" 
				pattern = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
				maxlength="200"placeholder="Correo electrónico personal"/>
		</div>
	</div>-->
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label>FECHA Y LUGAR DE NACIMIENTO</label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-3">
			<label>Fecha de nacimiento </label>
			<input name="{repr}_fecha_nac" id="{repr}_fecha_nac"  type="text" class="form-control" value="{repr_fecha_nac}" placeholder="Fec. Nacimiento"/>
		</div>
		<div class="col-sm-3">
			<label>Pais</label>
			{cmb_pais_repr_lugar_nac}
		</div>
		<div class="col-sm-3">
			<label>Provincia/Estado</label>
			<div id='div_provincia_{repr}_lugar_nac' name='div_provincia_{repr}_lugar_nac'>{cmb_provincia_repr_lugar_nac}</div>
		</div>
		<div class="col-sm-3">
			<label>Ciudad</label>
			<div id='div_ciudad_{repr}_lugar_nac' name='div_ciudad_{repr}_lugar_nac'>{cmb_ciudad_repr_lugar_nac}</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4"><label>Estado civil</label>{cmb_estado_civil_repr}</div>
		<div class="col-sm-8"><label>Título</label>{cmb_profesion_repr}</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label>DATOS LABORALES</label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8"><input name="{repr}_empr_nomb" id="{repr}_empr_nomb"  type="text" class="form-control" value="{repr_empr_nomb}" placeholder="Empresa donde Trabaja (Razón Social)"/></div>
		<div class="col-sm-4"><input name="{repr}_empr_ruc" id="{repr}_empr_ruc"  type="text" pattern="[0-9]*" class="form-control" 
			value="{repr_empr_ruc}" maxlength='13' placeholder="RUC"/></div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12"><input name="{repr}_empr_dir" id="{repr}_empr_dir"  type="text" class="form-control" value="{repr_empr_dir}" placeholder="Dirección de la Empresa"/></div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12"><input name="{repr}_empr_cargo" id="{repr}_empr_cargo"  type="text" class="form-control" value="{repr_empr_cargo}" placeholder="Cargo que desempeña"/></div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<div class="input-group">
				<span class="input-group-addon">$</span>
				<input name="{repr}_empr_ingreso_mensual" id="{repr}_empr_ingreso_mensual"  type="number" min="0" class="form-control" 
					value="{repr_empr_ingreso_mensual}" placeholder="Ingreso mensual"/>
			</div>
		</div>
		<div class="col-sm-4">
			<input name="{repr}_empr_telf" id="{repr}_empr_telf"  type="text" class="form-control" value="{repr_empr_telf}" 
				placeholder="Teléfono"/>
		</div>
		<div class="col-sm-4">
			<input name="{repr}_empr_mail" id="{repr}_empr_mail"  type="text" class="form-control" value="{repr_empr_mail}" 
				pattern = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
				maxlength="200"placeholder="Correo electrónico empresa"/>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class="checkbox" style='display:inline;'>
				<label>
					<input type="checkbox" id="ckb_{repr}_es_exalumno" name="ckb_{repr}_es_exalumno"
						onchange="js_enviarSolicitud_es_exalumno(this);" {repr_es_exalumno_check}>
						¿Es ex-Alumno?
				</label>
			</div>
		</div>
		<div class="col-sm-6">
			{repr_cmb_es_exalumno}
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="input-group" id="div_{repr}_es_extrabajador" name="div_{repr}_es_extrabajador" >
				<span class="input-group-addon">
					<input type="checkbox" id='ckb_{repr}_es_extrabajador' name='ckb_{repr}_es_extrabajador' 
						onclick='js_enviarSolicitud_es_extrabajador(this);' {repr_es_exworker_check}/>
				</span>
				<span class="input-group-addon">
					<span style="text-align:left;font-size:small;font-weight:bold;">¿Ha trabajado antes en la institución?</span>
				</span>				
				<span class="input-group-addon">
					<small>Inicio</small></span>
				<input type="text" class="form-control" name="{repr}_es_extrabajador_fecha_ini" id="{repr}_es_extrabajador_fecha_ini" 
					value="{repr_es_extrabajador_fecha_ini}" placeholder="dd/mm/yyyy" required="required" {repr_exworker_fini_disabled}>
			
				<span class="input-group-addon">
					<small>Fin</small></span>
				<input type="text" class="form-control" name="{repr}_es_extrabajador_fecha_fin" id="{repr}_es_extrabajador_fecha_fin" 
					value="{repr_es_extrabajador_fecha_fin}" placeholder="dd/mm/yyyy" required="required" {repr_exworker_ffin_disabled}>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<button type="button" class="btn btn-default" onclick="$('#modal_add_repr').modal('hide');">Cancelar</button><!--Debe ser llamado de un modal llamado tal cual.-->
			<button type="button" class="btn btn-success" 
				onclick="js_enviarSolicitud_guarda_formulario_repr('{ruta_html}/enviarSolicitud/controller.php');$('#modal_add_repr').modal('hide');">
				<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
		</div>
	</div>
</div>