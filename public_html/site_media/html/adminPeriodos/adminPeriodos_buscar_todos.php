<!-- Modal Reportes-->
<div class="modal fade" id="modal_rep" tabindex="-1" role="dialog" aria-labelledby="modal_rep_ModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_rep_ModalLabel">Reporte histórico</h4>
			</div>
			<div class="modal-body" id="modal_rep_body">
			 ...
			 </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>
<!-- /. Modal Reportes-->
<!-- Modal Cargando-->
<div class="modal modal-transparent fade" id="modal_wait" tabindex="-1"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body" id="modal_wait_body" style='text-align:center;font-size:small;'>
                <div align="center" style="height:100%;">
					Por favor, espere
					<br>
					<br>
					<i style="color:darkred;" class="fa fa-cog fa-spin"></i>
				</div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Balancear-->
<div class="modal fade" id="modal_balance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><span class='fa fa-balance-scale'></span>&nbsp;Balanceo de puntaje</h4>
			</div>
			<div class="modal-body" id="modal_balance_body">
				<input type="hidden" id="hd_cabePun_codigo" name="hd_cabePun_codigo" value='' >
				<div class='form-horizontal'>
					<div class='form-group'>
						<div class='col-sm-4'>
							Accion
						</div>
						<div class='col-sm-6'>
							<select id='cmb_balance_reason' name='cmb_balance_reason' class='form-control input-sm'
								onChange='js_adminPeriodos_change_reason();'>
								<option value='mas' selected='selected'>Aumentar puntaje</option>
								<option value='menos' >Disminuir puntaje</option>
							</select>
						</div>
					</div>
					<div class='form-group'>
						<div class='col-sm-4'>
							Motivo
						</div>
						<div class='col-sm-6'>
							<select id='cmb_balance_reason_motivo' name='cmb_balance_reason_motivo' class='form-control input-sm'>
								<option value ='1' selected='selected'>Servicio al cliente</option>
								<option value ='2'>Ingresos, salidas y permisos</option>
								<option value ='3'>Cumplimiento de cronograma y tareas</option>
								<option value ='4'>Trabajos adicionales</option>
								<option value ='6'>Cumplimiento de ingreso del zoho</option>
								<option value ='7'>Obtención/Devolución de premio</option>
								<option value ='8'>Idea genialmes</option>
								<option value ='9'>Cumplimiento de metas</option>
								<option value='10'>Multimedia</option>
							</select>
						</div>
					</div>
					<div class='form-group'>
						<div class='col-sm-4'>
							Puntos del mes
						</div>
						<div class='col-sm-6'>
							<div class="input-group">
								
								<input type="text" class="form-control input-sm" id="valor_actual" name="valor_actual"
									placeholder="0.00" disabled='disabled'>
								<span class="input-group-addon" style='background-color:#f4f4f4;'>Ptos.</span>
							</div>
						</div>
					</div>
					<div class='form-group'>
						<div class='col-sm-4'>
							<span id='span_balance_mount_label' name='span_balance_mount_label'>Monto del movimiento</span>
						</div>
						<div class='col-sm-6'>
							<div class="input-group">
								<span id='span_balance_reason' name='span_balance_reason' class="input-group-addon">(+)</span>
								<input type="text" class="form-control input-sm" id="valor_balance" name="valor_balance"
									placeholder="0" onpaste="return false;">
								<span class="input-group-addon" style='background-color:#f4f4f4;'>Ptos.</span>
							</div>
						</div>
					</div>
					<div class='form-group'>
						<div class='col-sm-4'>
							Observaciones
						</div>
						<div class='col-sm-6'>
							<textarea id='txt_balance_obs' name='txt_balance_obs'  class='form-control input-sm'
								placeholder='Información adicional sobre el movimiento'></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-info" data-dismiss="modal" onclick="js_adminPeriodos_add2(  );">Procesar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Información-->
<div class="modal fade" id="modal_infoSaf" tabindex="-1" role="dialog" aria-labelledby="modal_rep_ModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_rep_ModalLabel"><span class='fa fa-question-circle'></span>&nbsp;Acerca de puntaje de empleados</h4>
			</div>
			<div class="modal-body" id="modal_infoSaf_body">
				<p>Las acciones que incrementan o disminuyen el puntaje de los empleados son:</p>
				<ul>
					<li>Apertura de mes.</li>
					<li>Servicio al cliente.</li>
					<li>Ingresos, salidas y permisos.</li>
					<li>Cumplimiento de cronograma y metas.</li>
					<li>Cumplimiento de ingreso del zoho.</li>
					<li>Trabajos adicionales.</li>
					<li>Obtención/Devolución de premio</li>
					<li>Idea genialmes</li>
					<li>Cumplimiento de metas</li>
					<li>Multimedia</li>
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal">Entendido</button>
			</div>
		</div>
	</div>
</div>
<!-- /. Modal Información-->
<div class="modal modal-transparent fade" id="modal_open" tabindex="-1"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body" id="modal_open_body" style='text-align:center;font-size:small;'>
                <div align="center" style="height:100%;">
					Puntaje con el que va a iniciar el mes de <span id='span_mes_open'></span>:
					<br>
					<input type ='number' id='txt_ini_pts_open' name='txt_ini_pts_open' 
						value='10' min="0" max="10"
						class='form-control input-sm'/>
					<input type ='hidden' id='hd_mes_codigo' name='hd_mes_codigo' />
					<br>
					<div id='open_wait'></div>
					<button type="button" class='btn btn-default btn-sm' data-dismiss="modal" aria-label="Close">Cancelar</button>
					<button type="button" class='btn btn-warning btn-sm' id="btn_abrir_mes" name="btn_abrir_mes" onclick="js_adminPeriodos_open_followed();">Abrir mes</button>
				</div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Balancear-->
<div class="box box-default">
	<div class="box-header with-border">
		<b>Período:</b> {periodo}
		<div class="pull-right">
			<span id='span_return_meses' name='span_return_meses'></span>
			<a class="btn btn-default" onclick="js_adminPeriodos_reporte( );">
				<span style='color:red;' class="fa fa-bookmark-o"></span>&nbsp;Reporte general del año</a>
			<button type="button" class="btn btn-default"
				aria-hidden='true' data-toggle='modal' data-target='#modal_infoSaf'>
				&nbsp;<span style='color:#3c8dbc;' class='fa fa-info-circle'></span>&nbsp;</button>
		</div>
	</div>
	<div class="box-body">
		<input type="hidden" id="hd_mes_bandeja" name="hd_mes_bandeja" value='' >
		<input type="hidden" id="hd_mes_bandeja_nombre" name="hd_mes_bandeja_nombre" value='' >
		<input type="hidden" id="hd_mes_estado" name="hd_mes_estado" value='' >
		<span id='span_mes_estado' name='span_mes_estado' style='font-size:small;'></span>
		<div id="resultado">
			{tabla}
		</div>
	</div>
</div>