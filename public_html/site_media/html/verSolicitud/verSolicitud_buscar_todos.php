<!-- Modal Asignar Fecha-->
<div class="modal fade" id="modal_soli_docu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><i class='fa fa-clipboard'></i>&nbsp;Documentos adjuntos a la solicitud</h4>
            </div>
			<div class="modal-body" >
				<div style='font-size:small;' id="modal_soli_docu_body" name="modal_soli_docu_body">
				</div>
			</div>
			<div id="modal_soli_docu_footer" name="modal_soli_docu_footer" class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
            </div>
		</div>
	</div>
</div>
<!-- ./ Modal Documentos-->
<!-- Modal Asignar Fecha-->
<div class="modal fade" id="modal_asign_fecha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><i class='fa fa-calendar-check-o'></i>&nbsp;Asignación de fecha</h4>
            </div>
			<div class="modal-body" >
				<div id="modal_asign_fecha_bandeja" name="modal_asign_fecha_bandeja">
				</div>
				<br>
				<div id="modal_asign_fecha_body" name="modal_asign_fecha_body" style='display:block'>
					<div class="grid" id='div_grid_modal_asign_fecha' name='div_grid_modal_asign_fecha'>
						<div class="row">
							<div class='col-sm-12'>
								<label>Asigne una fecha para los exámenes a rendir. Le podría ayudar como referencia en la fecha de exámen sobre qué estudiantes
									rendirán pruebas ese día.
								</label>
							</div>
						</div>
						<div class="row">
							<div class='col-sm-3' style='text-align:right;'>
								<br>
								<input type="hidden" id="hd_fecha_soli_codi"    name="hd_fecha_soli_codi"   value="">
								<input type="hidden" id="hd_fecha_soli_estado"  name="hd_fecha_soli_estado" value="">
								<input type="hidden" id="hd_fecha_ruta_html"    name="hd_fecha_ruta_html"   value="">
								<input type="hidden" id="hd_fecha_next"    		name="hd_fecha_next"   		value="2">
							</div>
						</div>
						<div class="row">
							<div class='col-sm-4' style='text-align:left;'>
								<label for="txt_fecha_asign_1" class="control-label">Fecha de asignaci&oacute;n</label>
							</div>
							<div class='col-sm-8' style='text-align:left;'>
								<input type="date" id="txt_fecha_asign_1" class="form-control" name="txt_fecha_asign_1" value="">
							</div>
						</div>
						<div class="row">
							<div class='col-sm-12'>
								<br>
							</div>
						</div>
						<div class="row">
							<div class='col-sm-4' style='text-align:left;'>
								<label for="txt_fecha_asign_1" class="control-label">Aactividad/Examen</label>
							</div>
							<div class='col-sm-8' style='text-align:left;'>
								<input type="text" id="txt_fecha_actividad_1" 	class="form-control" name="txt_fecha_actividad_1" value="">
								<input type="hidden" id="hd_fecha_change_est_1" name="hd_fecha_change_est_1" value="0">
								<!-- Si es 1, actualiza a 'Fecha asignada' automáticamente. Mantener en cero, si se marca como tal desde otra opción.-->
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="modal_asign_fecha_footer" name="modal_asign_fecha_footer" class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success"
					onclick="js_verSolicitud_asignar_fecha_followed(document.getElementById('hd_fecha_soli_codi').value,document.getElementById('hd_fecha_soli_estado').value,'modal_asign_fecha_bandeja', document.getElementById('hd_fecha_ruta_html').value);">
					<li class="fa fa-save" >&nbsp;</li>Asignar fecha</button>
            </div>
		</div>
	</div>
</div>
<!-- Modal Asignar Fecha-->
<!-- Modal Subir archivo-->
<div class="modal fade" id="modal_subir_archivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><i class='fa fa-download'></i>&nbsp;Síntesis académica</h4>
            </div>
			<div class="modal-body" >
				<div id="modal_subir_archivo_bandeja">
				</div>
				<br>
				<div id="modal_subir_archivo_body" style='display:block'>
					<div class="grid">
						<div class="row">
							<div class='col-sm-12'>
								<label>Adjunte el archivo de 'síntesis académica' del postulante que desea subir. Sólo puede subir un archivo. Si desea subir más de un archivo, se le recomienda comprimir sus archivos
									en formato *.zip, para que pueda subir todos los archivos que quiera.
								</label>
								<br>
							</div>
						</div>
						<div class="row">
							<div class='col-sm-3' style='text-align:right;'>
								<br>
								<input type="hidden" id="hd_sint_soli_codi"	name="hd_sint_soli_codi"   	value="">
								<input type="hidden" id="hd_sint_num_soli"	name="hd_sint_num_soli" 	value="">
								<input type="hidden" id="hd_sint_ruta_html"	name="hd_sint_ruta_html"   	value="">
							</div>
						</div>
						<div class="row">
							<div class='col-sm-4' style='text-align:left;'>
								<label for="ftu_sint_docu_file" class="control-label">Síntesis académica</label>
							</div>
							<div class='col-sm-8' style='text-align:left;'>
								<input type="file" name="ftu_sint_docu_file" id="ftu_sint_docu_file" required="required">
							</div>
						</div>
						<div class="row">
							<div class='col-sm-12' style='text-align:left;'>
								<br>
							</div>
						</div>
						<div class="row">
							<div class='col-sm-4' style='text-align:left;'>
								<label for="txt_sint_docu_desc" class="control-label">Desc. documento</label>
							</div>
							<div class='col-sm-8' style='text-align:left;'>
								<input type="text" class='form-control' name="txt_sint_docu_desc" id="txt_sint_docu_desc" required="required">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer" id="modal_subir_archivo_footer" style='display:block'>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success"
					onclick="js_docAdmin_subir_sintesis(document.getElementById('hd_sint_soli_codi').value,document.getElementById('hd_sint_num_soli').value,'resultado', document.getElementById('hd_sint_ruta_html').value);">
					<li class="fa fa-upload" >&nbsp;</li>Subir síntesis</button>
            </div>
		</div>
	</div>
</div>
<!-- Modal Subir archivo-->
<!-- Modal Negar pase-->
<div class="modal fade" id="modal_procesar_pase" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Procesando solicitud</h4>
            </div>
			<div class="modal-body" id="modal_procesar_pase_body">
				<input type="hidden" id="hd_procesar_pase_soli_codi" 	name="hd_procesar_pase_soli_codi" 		value="">
				<input type="hidden" id="hd_procesar_pase_per_codi" 	name="hd_procesar_pase_per_codi" 		value="">
				<input type="hidden" id="hd_procesar_pase_soli_estado"	name="hd_procesar_pase_soli_estado" 	value="">
				<input type="hidden" id="hd_procesar_pase_div"			name="hd_procesar_pase_div" 			value="resultado">
				<input type="hidden" id="hd_procesar_pase_ruta_html"	name="hd_procesar_pase_ruta_html"		value="">
                <div class="grid">
					<div class="row">
						<div class='col-sm-12'>
							Si desea, puede escribir una <b>observación</b> (opcional). El estudiante la podrá leer al ingresar al sistema de pre-admisiones, 
							y un correo electrónico le llegará al correo del representante académico.
							<br>
							<br>
							Si se está devolviendo la solicitud por falta de alguna información, por favor, indicar qué información le falta
							completar, o adjuntar, para que el postulante sepa
							el motivo específico de la negación de su solicitud.
							
						</div>
					</div>
					<div class="row">
						<div class='col-sm-12'>
							<br>
						</div>
					</div>
					<div class="row">
						<div class='col-sm-12'>
							<textarea rows="2" cols="80" maxlength="1000" name="txt_procesar_pase_obs" id="txt_procesar_pase_obs"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="checkbox checkbox-info col-sm-12">
							<label for='ckb_gestionFactura_opc_adv'>
								<input type="checkbox" id='ckb_gestionFactura_opc_adv' name='ckb_gestionFactura_opc_adv'>
									<span style="text-align:left;font-size:small;font-weight:bold;">Enviar copia al correo del representante legal</span>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" data-dismiss="modal"
					onclick="js_verSolicitud_procesar(document.getElementById('hd_procesar_pase_soli_codi').value,
														document.getElementById('hd_procesar_pase_per_codi').value,
														document.getElementById('hd_procesar_pase_soli_estado').value,
														document.getElementById('hd_procesar_pase_div').value,
														document.getElementById('hd_procesar_pase_ruta_html').value,
														document.getElementById('txt_procesar_pase_obs').value,
														document.getElementById('ckb_gestionFactura_opc_adv').checked );">
					<li class="fa fa-upload" >&nbsp;</li>Procesar solicitud</button>
            </div>
		</div>
	</div>
</div>
<!-- /. Modal Negar pase-->
<!-- Modal Cambiar estado solicitud-->
<div class="modal fade" id="modal_cambiar_estado" tabindex="-1" role="dialog" aria-labelledby="modal_cambiar_estado" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cambio de estado de solicitud no. "<span id="span_mce_soli_codi"></span>"</h4>
            </div>
			<div class="modal-body" id="modal_cambiar_estado_body">
				<input type="hidden" id="hd_mce_soli_codi"	name="hd_mce_soli_codi" value="">
				<div class="form-horizontal">
					<div class="form-group">
						<label class='col-sm-4 control-label' style="text-align:right;">
							Estado anterior:
						</label>
						<div class='col-sm-4'>
							<input type='text' class='form-control input-sm' id="txt_mce_estado_anterior" name="txt_mce_estado_anterior" disabled='disabled' readonly='readonly'/>
						</div>
					</div>
					<div class="form-group">
						<label class='col-sm-4 control-label' style="text-align:right;">
							Nuevo estado:
						</label>
						<div class='col-sm-6'>
							<select id='cmb_mce_estado_nuevo' name='cmb_mce_estado_nuevo' class='form-control input-sm'>
								<option value="GUARDADA">GUARDADA</option>
								<option value="ENVIADA">ENVIADA</option>
								<option value="DEVUELTA">DEVUELTA</option>
								<option value="PDTE. PAGO">PDTE. PAGO</option>
								<option value="NO INTERESADO">NO INTERESADO</option>
								<option value="PAGADA">PAGADA</option>
								<option value="FECHA ASIGNADA">FECHA ASIGNADA</option>
								<option value="EX. REPROBADO">EX. REPROBADO</option>
								<option value="EX. APROBADO">EX. APROBADO</option>
								<option value="APROBADO DIRECTORES">APROBADO DIRECTORES</option>
								<option value="ADMITIDO">ADMITIDO</option>
								<option value="RESERVA PAGADA">RESERVA PAGADA</option>
								<option value="NO ADMITIDO">NO ADMITIDO</option>
								<option value="INACTIVO">INACTIVO</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" onclick='js_verSolicitud_cambiar_estado_followed(
												document.getElementById("hd_mce_soli_codi").value,
												document.getElementById("cmb_mce_estado_nuevo").value,
												"resultado",
												document.getElementById("ruta_html").value + "/verSolicitud/controller.php")' 
					class='btn btn-success'><li class="fa fa-save" ></li>&nbsp;Guardar cambios</button>
            </div>
		</div>
	</div>
</div>
<!-- /. Modal Cambiar estado solicitud -->
<!-- Modal Formulario PDF-->
<div class="modal fade" id="modal_formulario_pdf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><i class='fa fa-file-pdf-o'></i>&nbsp;Formulario (PDF)</h4>
            </div>
			<div class="modal-body" id="modal_formulario_pdf_body">
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
		</div>
	</div>
</div>
<!-- /.  Modal Formulario PDF

<!-- Modal Observación-->
<div class="modal fade" id="modal_obs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><span id='spn_obs_set_obs' name='spn_obs_set_obs' >Ovservación de la solicitud</span></h4>
            </div>
			<div class="modal-body" id="modal_obs_body">
				<input type='hidden' id='hd_obs_set_soli_codi' name='hd_obs_set_soli_codi' value='' />
				<label class='control-label' for='txt_obs_set_observacion'></label>
				<textarea type='text' class='form-control input-sm' id='txt_obs_set_observacion' name='txt_obs_set_observacion' value='' placeholder='Ingresar observación...' ></textarea>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success" data-dismiss="modal" 
					onclick='js_verSolicitud_observacion_set_followed( "{ruta_html_admisiones}/verSolicitud/controller.php" );' >
					<span class='fa fa-floppy-o'></span> Guardar cambios</button>
            </div>
		</div>
	</div>
</div>
<form id="file_form" action="{ruta_html}/verSolicitud/controller.php" enctype="multipart/form-data" method="post" target="_blank">
	<input type='hidden' id='hd_main_soli_estado' name='hd_main_soli_estado' value="{soli_estado}"/>
	<input type='hidden' name="event" id="evento" value="print_excel"/>
	<div class="grid">
		<div class='row'>
			<div class='col-md-12'>
				<div id='div_opc_adv' name='div_opc_adv' class='panel panel-info'>
					<div class="panel-heading">
						Búsqueda
					</div>
					<div class="panel-body">
						<div class='row'>
							<div class='col-sm-2'>
								<div class="btn-group">
									<button type="button" 
											title="Exportar búsqueda" onmouseover="$(this).tooltip('show');"
											class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										<span style='color:green;' class='fa fa-file-excel-o'>&nbsp;</span><span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#" onclick="js_verSolicitud_consulta_general_xls('file_form');">Reporte reducido</a></li>
										<li><a href="#" onclick="js_verSolicitud_consulta_general_xls_completo('file_form');">Reporte completo</a></li>
									</ul>
								</div>
								<button type="button" class="btn btn-danger fa fa-file-excel-o" title="Exportar reporte de documentos pendientes" onmouseover="$(this).tooltip('show');"
										onclick="js_verSolicitud_consulta_docu_pdtes_xls('file_form');">
								</button>
								<button type='button' class='btn btn-primary fa fa-search' id='btn_selectTipoDocAut' name='btn_selectTipoDocAut' 
										onclick="js_verSolicitud_buscar_todos( 'get_all', 'resultado', '{ruta_html}/verSolicitud/controller.php',
												document.getElementById('hd_main_soli_estado').value,
												document.getElementById('txt_s_fecha_ini').value,
												document.getElementById('txt_s_fecha_fin').value,
												document.getElementById('txt_s_id_solicitud').value,
												document.getElementById('cmb_s_curso_aplica').value,
												document.getElementById('txt_s_id_repr').value,
												document.getElementById('txt_s_num_intentos').value,
												'',
												'',
												'');">
								</button>
							</div>
							<div class="col-sm-6" id="div_fini" name="div_fini" >
								<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
									 title='Fecha de registro al sistema, desde, hasta.'
									 onmouseover='$(this).tooltip("show")'>
									<span class="input-group-addon">
										<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='js_verSolicitud_check_fecha();' >
									</span>
									<span class="input-group-addon">
										<span style="text-align:left;font-size:small;font-weight:bold;">F. registro</span>
									</span>				
									<span class="input-group-addon">
										<small>Desde</small></span>
									<input type="date" class="form-control" name="txt_s_fecha_ini" id="txt_s_fecha_ini" 
												value="" placeholder="dd/mm/yyyy" required="required" disabled='disabled'>
								
									<span class="input-group-addon">
										<small>Hasta</small></span>
									<input type="date" class="form-control" name="txt_s_fecha_fin" id="txt_s_fecha_fin" 
												value="" placeholder="dd/mm/yyyy" required="required" disabled='disabled'>
								</div>
							</div>
						</div>
						<div class='row'>
							<div class="col-sm-2" style="text-align:left;">
								<br>
							</div>
						</div>
						<div class='row'>
							<div class="col-sm-2" style="text-align:left;">
								<label class='control-label' for='txt_s_id_solicitud'><span style="font-size:small;font-weight:bold;">Id. Solicitud</span></label>
							</div>
							<div class="col-sm-3"
									data-placement="bottom"
									title='C&oacute;digo del representado'
									onmouseover='$(this).tooltip("show")'>
								<input type="text" class="form-control input-sm" name="txt_s_id_solicitud" id="txt_s_id_solicitud" >
							</div>
							<div class="col-sm-2" style="text-align:left;">
								<label class='control-label' for='txt_nom_cliente'><span style="font-size:small;font-weight:bold;">Curso al que aplica</span></label>
							</div>
							<div class="col-sm-3">
								{cmb_s_curso_aplica}
							</div>
						</div>
						<div class='row'>
							<div class="col-sm-2" style="text-align:left;">
								<br>
							</div>
						</div>
						<div class='row'>
							<label class='col-sm-2 control-label' for='txt_s_id_repr'><span style="font-size:small;font-weight:bold;">Id. Repr. Académico</span></label>
							<div class="col-sm-3"
									data-placement="bottom"
									title='N&uacute;mero de identificaci&oacute;n del titular del documento autorizado'
									onmouseover='$(this).tooltip("show")'>
								<input type="text" class="form-control input-sm" name="txt_s_id_repr" id="txt_s_id_repr" >
							</div><!-- 
							<div class="col-sm-2" style="text-align:left;">
								<label class='control-label' for='txt_s_nom_repr'><span style="font-size:small;font-weight:bold;">Nombre Repr. Académico</span></label>
							</div>
							<div class="col-sm-3"
									data-placement="bottom"
									title='Nombre del titular del documento autorizado'
									onmouseover='$(this).tooltip("show")'>
								<input type="text" class="form-control input-sm" name="txt_s_nom_repr" id="txt_s_nom_repr" >
							</div> -->
						</div>
						<!-- 
						<div class='row'>
							<div class="col-sm-2" style="text-align:left;">
								<br>
							</div>
						</div>
						<div class='row'>
							<div class="col-sm-2" style="text-align:left;">
								<label class='control-label' for='txt_s_id_postulante'><span style="font-size:small;font-weight:bold;">Id. postulante</span></label>
							</div>
							<div class="col-sm-3"
									data-placement="bottom"
									title='C&oacute;digo del representado'
									onmouseover='$(this).tooltip("show")'>
								<input type="text" class="form-control input-sm" name="txt_s_id_postulante" id="txt_s_id_postulante" >
							</div>
							<div class="col-sm-2" style="text-align:left;">
								<label class='control-label' for='txt_s_nom_postulante'><span style="font-size:small;font-weight:bold;">Nombre postulante</span></label>
							</div>
							<div class="col-sm-3"
									data-placement="bottom"
									title='Nombre del cliente representado'
									onmouseover='$(this).tooltip("show")'>
								<input type="text" class="form-control input-sm" name="txt_s_nom_postulante" id="txt_s_nom_postulante" >
							</div>
						</div> -->
						<div class='row'>
							<div class="col-sm-2" style="text-align:left;">
								<br>
							</div>
						</div>
						<div class='row'>
							<div class="col-sm-2" style="text-align:left;">
								<label class='control-label' for='txt_s_num_intentos'><span style="font-size:small;font-weight:bold;">Numero intentos</span></label>
							</div>
							<div class="col-sm-3"
									data-placement="bottom"
									title='Número de veces que ha vuelto a intenter la admisión luego de reprobar.'
									onmouseover='$(this).tooltip("show")'>
								<input type="number" step=1 min=0 class="form-control input-sm" name="txt_s_num_intentos" id="txt_s_num_intentos" >
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-12'>
				<div id="div_btn_back" name="div_btn_back" style="display:none;">
					<button type="button" class="btn btn-warning" 
						onclick="js_verSolicitud_buscar_todos( 'get_all', 'resultado', '{ruta_html}/verSolicitud/controller.php',
											 document.getElementById('hd_main_soli_estado').value, '', '', '', '', '', '', '', '', '' );
								 document.getElementById('div_btn_back').style.display = 'none';"><li class="fa fa-angle-left"></li>&nbsp;Volver a bandeja</button>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-12'>
				<br>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-12'>
				<div id="resultado">
					{tabla}
				</div>
			</div>
		</div>
	</div>
</form>