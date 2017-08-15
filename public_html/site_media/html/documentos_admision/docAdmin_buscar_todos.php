<!-- Modal Editar-->
<div 	class="modal fade" 
		id="ModalDocuEdi" 
		tabindex="-1" 
		role="dialog" 
		aria-labelledby="myModalLabel" 
		aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button 
					type="button" 
					class="close" 
					data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Editar Documento</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_docu_edi"> 
					<form 
						id="frm_docu_edi" 
						name="frm_docu_edi" 
						method="post" 
						action="" 
						enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-3">
								<label for="docu_descr_edi">Per&iacute;odo activo</label>
							</div>
							<div class="col-sm-2"><label>{periodo_activo}</label></div>
							<input  type="hidden" 
									id="docu_codi_edi" 
									name="docu_codi_edi" 
									value="">
						</div>
						<div class="row"> 
							<div class="col-sm-3">
								<label for="docu_descr_edi">Descripci&oacute;n</label>
							</div>
							<div class="col-sm-9">
								<textarea id="docu_descr_edi" 
									name="docu_descr_edi" 
									maxlength='250'
									rows="4"
									placeholder="Ejemplo: partida de nacimiento del aspirante y/o  # cédula de ciudadanía."
									style="width: 100%; margin-top: 5px;"></textarea>
							</div>
						</div>
					</form>
				</div>
				<div class="form_element">&nbsp;</div> 
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" id='btn_docuAdmin_edi' name='btn_docuAdmin_edi'
						onClick="js_docAdmin_event('div_documentos_tabla','{ruta_html}/documentos_admision/controller.php', 'edit', 
							document.getElementById('docu_descr_edi').value,
							0,
							document.getElementById('docu_codi_edi').value,
							0,0,'ModalDocuEdi');" >Grabar</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Editar-->
<!-- Modal Agregar-->
<div class="modal fade" id="ModalDocuAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Nuevo Documento</h4>
			</div>
			<div class="modal-body" id="modal_add_body">
				<div id="div_docu_nuev" class='grid'> 
					<form 
						id="frm_docu_add" 
						name="frm_docu_add" 
						method="post" 
						action="" 
						enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-3">
								<label for="descripcion_add">Per&iacute;odo activo</label>
							</div>
							<div class="col-sm-2"><label>{periodo_activo}</label></div>
							<input  type="hidden" 
									id="docu_peri_codi_nuev" 
									name="docu_peri_codi_nuev" 
									value="{peri_act_codi}">
						</div>
						<div class="row"> 
							<div class="col-sm-3">
								<label for="porcentaje_add">Descripci&oacute;n</label>
							</div>
							<div class="col-sm-9">
								<textarea id="docu_descr_nuev" 
									name="docu_descr_nuev" 
									maxlength='250'
									rows="4"
									placeholder="Ejemplo: partida de nacimiento del aspirante y/o  # cédula de ciudadanía."
									style="width: 100%; margin-top: 5px;"></textarea>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success" id='btn_docuAdmin_add' name='btn_docuAdmin_add'
					onclick="js_docAdmin_event('div_documentos_tabla','{ruta_html}/documentos_admision/controller.php', 'set', 
							document.getElementById('docu_descr_nuev').value,
							document.getElementById('docu_peri_codi_nuev').value,
							0,0,0,'ModalDocuAdd');">
				<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Agregar-->
<div class="grid">
	<div class='row'>
		<div class='col-sm-2'> 
			<button class="btn btn-primary" type="button" aria-hidden='true' data-toggle='modal' data-target='#ModalDocuAdd' {disabled_agregar_descuento}>
			<li class='fa fa-file'></li>&nbsp;<li class='fa fa-plus'></li></button>
			<button class='btn btn-primary' id='btn_selectTipoDocAut' name='btn_selectTipoDocAut' 
					onclick="js_docAdmin_get_all('div_documentos_tabla','{ruta_html}/documentos_admision/controller.php')"><li class='fa fa-search'></li>&nbsp;
			</button>
		</div>
		<div class='col-sm-3' onmouseover='$(this).tooltip();' title='Consulte los documentos por período anual.' data-placement='right'> 
			{combo_periodo}
		</div>
	</div>
	<div class='row'>
		<div class='col-sm-12'>
			<hr/>
		</div>
	</div>
	<div class='row'>
		<div class='col-sm-12'>
			<div id="div_documentos_tabla">
				{tabla}
			</div>
		</div>
	</div>
</div>