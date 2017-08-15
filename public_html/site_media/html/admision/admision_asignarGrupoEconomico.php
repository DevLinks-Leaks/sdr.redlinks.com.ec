<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">Asignar Grupo Económico</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-sm-6">
			<input type="hidden" class="form-control" name="codigoGrupoEconomico" id="codigoGrupoEconomico" value="{codigoGrupoEconomico}" required="required">
			<input type="hidden" class="form-control" name="codigoEstudiante" id="codigoEstudiante" value="{codigoEstudiante}" required="required">
			<label for="nombreGrupoEconomico" class='control-laber'><b>Grupo econ&oacute;mico anterior</b></label>
			<input type="text" readonly class="form-control" name="nombreGrupoEconomico" id="nombreGrupoEconomico" value="{nombreGrupoEconomico}" required="required">
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<label for="combo_grupoEconomico" class='control-laber'><b>Nuevo grupo econ&oacute;mico</b></label>
			{combo_grupoEconomicos}
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	<button type="button" class="btn btn-success" data-dismiss="modal" 
			onclick="asign_grupoEconomico('resultado','{ruta_html}/clientes/controller.php')">
			<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
</div>
