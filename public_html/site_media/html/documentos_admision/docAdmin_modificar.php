<div id="frm_modificacionItem" class="form-medium" > 
    <div class="form-group">
    	<input type="hidden" class="form-control" name="codigo_mod" id="codigo_mod" value="{desc_codigo}" required="required">
    	<label for="descripcion_mod">Descripci&oacute;n</label>
        <input type="text" class="form-control" name="descripcion_mod" id="descripcion_mod" placeholder="Descripción del Descuento" value="{desc_descripcion}" required="required">
    </div>
    <div class="form-group"> 
    	<label for="porcentaje_mod">Porcentaje</label>
        <div class="input-group">
          <input type="text" class="form-control" name="porcentaje_mod" id="porcentaje_mod" placeholder="Porcentaje del Descuento" value="{desc_porcentaje}" required="required" aria-describedby="basic-addon2">
          <span class="input-group-addon" id="basic-addon2">%</span>
        </div>
    </div>
    <div class="form-group"> 
    	<label for="aplicaprontopago_mod" class="checkbox-inline">
    		<input type="checkbox" id="aplicaprontopago_mod" name="aplicaprontopago_mod" {desc_aplicaprontopago}/>	
            Aplica Prontopago
    	</label>
	</div>
    <div class="form-group"> 
    	<label for="aplicaprepago_mod" class="checkbox-inline">
    		<input type="checkbox" id="aplicaprepago_mod" name="aplicaprepago_mod" {desc_aplicaprepago} />	
            Aplica Prepago
    	</label>
	</div>
</div>