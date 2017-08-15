<div id="visorEstadoCuenta_cliente" class="form-horizontal" >

    <fieldset>
		<legend class="form-group">
			<div class="col-sm-6" style='height:40px'>Filtros</div>
		</legend>
        <input type="hidden" class="form-control" name="codigoEstudiante" id="codigoEstudiante" value="{alumno_codigo}" required="required">
        <div class="form-group">
			<label class="checkbox-inline" >
				<div class="col-sm-3">
					<input type="checkbox" id="chk_periodo" onchange="validaFiltros(this,'resultadoDeudas','{ruta_html}/clientes/controller.php')" value=""> 
					Periodo:
				</div>
				<div class="col-sm-4">
					{combo_periodos}
				</div>
			</label>
        </div>
        <div class="form-group">
			<label class="checkbox-inline" >
				<div class="col-sm-1">
					<input type="checkbox" id="chk_fechas" onchange="validaFiltros(this,'resultadoDeudas','{ruta_html}/clientes/controller.php')" value=""> 
					Fechas:
				</div>
				<div class="col-sm-4">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon">Desde</span>
						<div id="xx"><input type="text" class="form-control" name="fechaInicio" id="fechaInicio" placeholder="dd/mm/aaaa" 
							onchange="consultaDeudas('resultadoDeudas','{ruta_html}/clientes/controller.php')"  required="required" readonly=""></div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon">Hasta</span>
						<div id="yy"><input type="text" class="form-control" name="fechaFin" id="fechaFin" placeholder="dd/mm/aaaa" 
							onchange="consultaDeudas('resultadoDeudas','{ruta_html}/clientes/controller.php')" required="required" readonly=""></div>
					</div>
				</div>
			</label>
		</div>
    </fieldset>

    <fieldset>
		<legend class="form-group">
			<div class="col-sm-6"  style='height:40px'>Deudas</div>
		</legend>
		<div class="form-group">
			<div class="col-sm-12">
				<div id="resultadoDeudas">
					{tablaDeudas}
				</div>
			</div>
		</div>
    </fieldset>
</div>