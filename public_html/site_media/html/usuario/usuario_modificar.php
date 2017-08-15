<div id="frm_modificacionPeriodo" class="form-medium" >
    <div class="row">
		<div class="col-sm-6">
			<div class="form-group"> 
				<label for="nombres_mod">Nombres</label>
				<input type="text" class="form-control" name="nombres_mod" id="nombres_mod" placeholder="Nombres del usuario" required="required" value="{usuario_nombres}">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group"> 
				<label for="apellidos_mod">Apellidos</label>
				<input type="text" class="form-control" name="apellidos_mod" id="apellidos_mod" placeholder="Apellidos del usuario" required="required" value="{usuario_apellidos}">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group"> 
				<label for="correo_mod">Correo</label>
				<input type="text" class="form-control" name="correo_mod" id="correo_mod" placeholder="Correo del usuario" required="required" value="{usuario_correo}">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group"> 
				<label for="rol_mod">Rol</label>
				{cmb_roles_mod}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group"> 
				<label for="correo_mod">Username</label>
				<input type="text" class="form-control" name="username_mod" id="username_mod" placeholder="Username del usuario" required="required" value="{usuario_username}" disabled>
				<input type="hidden" class="form-control" name="codigo_mod" id="codigo_mod" required="required" value="{usuario_username}">
			</div>
		</div>
	</div>
</div>