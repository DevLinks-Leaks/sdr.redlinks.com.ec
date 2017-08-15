<div id="div_docu_nuev"> 
	<form 
		id="frm_docu_add" 
		name="frm_docu_add" 
		method="post" 
		action="" 
		enctype="multipart/form-data">
		<div class="form-group">
			<label for="descripcion_add">Per&iacute;odo activo</label>
			<label>
				<?php echo $_SESSION['peri_deta']; ?>
			</label>
		</div>
		<div class="form-group"> 
			<label for="porcentaje_add">Descripci&oacute;n</label>
			<textarea id="docu_descr_nuev" 
					  name="docu_descr_nuev" 
					  maxlength='250'
					  rows="4"
					  placeholder="Ingrese descripci&oacute;n del documento... Ejemplo: artida de nacimiento del aspirante y/o  # cédula de ciudadanía."
					  style="width: 100%; margin-top: 5px;">
			</textarea>
		</div>
	</form>
</div>