<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">Asignaci&oacute;n de descuento</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-sm-3">
			<label for="nombres" class='control-label'><b>C&oacute;digo</b></label>
			<input type="text" readonly class="form-control" name="codigo" id="codigo" placeholder="codigo" value="{clie_codigo}" required="required">
		</div>
		<div class="col-sm-6">
			<label for="nombres" class='control-label'><b>Cliente</b></label>
			<input type="text" readonly class="form-control" name="nombres" id="nombres" 
					placeholder="Ingrese los nombres" value="{clie_nombres} {clie_apellidos}" required="required">
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<label for="codigo_descto" class='control-label'><b>Descuento</b></label>
			{combo_descto}
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<label for="porcentaje_descto" class='control-label'><b>Porcentaje Sugerido</b></label>
			<div class="input-group"
						data-placement="right"
						title='Ej.: 10%.'
						onmouseover='$(this).tooltip("show")'>
				<input type="text" class="form-control" name="porcentaje_descto" id="porcentaje_descto"
						onkeypress="return spacebar_retorna_cero(event,this);" 
						pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" step="0.01"
						maxlength="15" placeholder="00.00" required='required'>
				<span class="input-group-addon" id="basic-addon">%</span>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			{tabla_descuentos}
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	<button type="button" class="btn btn-success" data-dismiss="modal" 
		onclick="save_asign('resultado','{ruta_html}/clientes/controller.php')">
			<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
</div>