<div id="frm_ingresoUsuario" class="form-medium">
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group"> 
				<label for="nombres_add">Nombres</label>
				<input type="text" class="form-control" name="nombres_add" id="nombres_add" placeholder="Nombres del usuario" required="required">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group"> 
				<label for="apellidos_add">Apellidos</label>
				<input type="text" class="form-control" name="apellidos_add" id="apellidos_add" placeholder="Apellidos del usuario" required="required">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group"> 
				<label for="correo_add">Correo</label>
				<input type="text" class="form-control" name="correo_add" id="correo_add" placeholder="Correo del usuario" required="required">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group"> 
				<label for="rol_add">Rol</label>
				{cmb_roles_add}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div id="check_username" class="form-group"> 
				<label for="username_add">Username</label>
				<input type="text" class="form-control" name="username_add" id="username_add" placeholder="Username del usuario" onkeyup="check_username(this.value,'check_username','{ruta_html}/usuario/controller.php')" required="required">
			</div>
		</div>
	</div>
</div>