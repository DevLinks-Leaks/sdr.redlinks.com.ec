<div id="frm_modificacionRol" class="form-medium" >
    <div class="form-group">
    <input type="hidden" class="form-control" name="codigo_mod" id="codigo_mod" value="{rol_codigo}"></div>
	<input type="hidden" class="form-control" name="puntos_menos_mod" id="puntos_menos_mod" value="{puntos}"></div>
    <div class="form-group">
	<table width='100%'>
	<tr><td>Puntaje personal</td><td align='right'>{puntos_mios} Ptos.</td></tr>
	<tr><td>Premio ({rol_descripcion})</td><td align='right'><font color='red'>- {puntos} Ptos.</font></td></tr>
	<tr><td colspan='2'><hr></td></tr>
	<tr><td>Ptos. sobrantes</td><td align='right'><font color='black'>{puntos_sobrantes} Ptos.</font></td></tr>
	</table>
</div>