{password}
<div id="alta_usuario" class="form-medium" >
    <div class="form-group">
    <input type="hidden" class="form-control" name="usua_codigo" id="usua_codigo" value='{usua_codigo}'>
    <label for="pass_old">Contraseña anterior</label>
    <input type="password" class="form-control" name="pass_old" id="pass_old" placeholder="Ingrese su contraseña anterior" required="required"></div>
    <div class="form-group">
    <label for="pass_new">Contraseña Nueva</label>
    <input type="password" class="form-control" name="pass_new" id="pass_new" placeholder="Ingrese su contraseña nueva" required="required"></div>
    <div class="form-group">
    <label for="pass_new2">Reingrese Contraseña Nueva</label>
    <input type="password" class="form-control" name="pass_new2" id="pass_new2" placeholder="Reingrese su contraseña nueva" required="required"></div>
    <div class="form-group">
    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="password_change(document.getElementById('pass_old').value,document.getElementById('pass_new').value,document.getElementById('pass_new2').value,document.getElementById('usua_codigo').value,'{ruta_html}/general/controller.php')">Guardar</button>
    </div>
</div>