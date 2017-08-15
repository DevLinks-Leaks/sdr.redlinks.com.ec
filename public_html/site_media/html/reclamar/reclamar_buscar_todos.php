<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Reclamar Premio</h4>
      </div>
      <div class="modal-body" id="modal_edit_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" id="btn_editar" 
			onclick="edit(document.getElementById('codigo_mod').value,'resultado','{ruta_html}/reclamar/controller.php')">
				<span class='fa fa-gift'></span>&nbsp;Reclamar premio</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Editar-->
<div class="form-medium">
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 id='head_with_puntaje' name='head_with_puntaje' class="box-title">Puntaje personal: {puntaje_personal}</h3>
			<input type='hidden' id='hd_puntaje_personal' name='hd_puntaje_personal' value='{puntaje_personal}'/>
		</div>
		<div class="box-body">
			<div id="resultado">
				{tabla}
			</div>
		</div>
		<div class="box-footer">
		</div>
	</div>
</div>