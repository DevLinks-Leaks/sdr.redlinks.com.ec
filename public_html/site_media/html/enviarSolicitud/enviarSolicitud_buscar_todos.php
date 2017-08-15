<div style="text-align:center; margin-bottom:10px;">
	<a href="../enviarSolicitud/" ><img src="http://www.colegioamericano.edu.ec/wp-content/uploads/2015/09/logo_colegio.png" alt="logo_americano"/></a>
</div>
<br>
<div id='div_periodo' name='div_periodo' class='grid' style='display:inline;'>
	<div class='row' id='div_row_periodo' name='div_row_periodo'>{div_periodos_seleccion}
	</div>
</div>
<div id='div_opciones_principales' name='div_opciones_principales' class='grid' style='display:none;'>
	<div class='row'>
		<div class="col-lg-6 col-xs-12">
			<div class="small-box bg-red" id='box_nuevo' name='box_nuevo'>
				<div class="inner">
					<h3>Formulario de solicitud<sup style="font-size: 20px"></sup></h3>
					<p>Formulario de solicitud para el proceso de admisión</p>
				</div>
				<div class="icon">
					<i class="ion ion-plus"></i>
				</div>
				<a href="#" class="small-box-footer" onclick='js_enviarSolicitud_get_formulario_nuevo("{ruta_html}/enviarSolicitud/controller.php");'>Haz clic aqu&iacute; <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-6 col-xs-12">
			<div class="small-box bg-green" id='box_continuar' name='box_continuar'>
				<div class="inner">
					<h3>Continuar solicitud<sup style="font-size: 20px"></sup></h3>
					<p>Continuar llenando el proceso de admisión y consultar estado del proceso</p>
				</div>
				<div class="icon">
					<i class="ion ion-edit"></i>
				</div>
				<a href="#" class="small-box-footer" onclick="js_enviarSolicitud_continuar();">Haz clic aqu&iacute; <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</div>
</div>
<div id="div_formulario_solicitud" style='display:none;'>
</div>
<div id="div_continuar_solicitud" class="box box-default" style='display:none;'>
	<div class="box-header with-border">
		<h3 class="box-title">Continuar solicitud</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
		</div>
	</div>
	<div id="formulario_continuar_solicitud"class="box-body">
		<div class="callout callout-warning">
			<h4><strong><li class='fa fa-exclamation'></li></strong></h4>
			Ingrese el ID para continuar llenando su solicitud en el sistema.
		</div>
		<div class="grid">
			<div class="row">
				<div class="col-md-1">
					<label class='control-label' for='txt_id_solicitud'>ID</label>
				</div>
				<div class="col-md-4">
					<input type='text' maxlength='11' class='form-control' id='txt_id_solicitud' name='txt_id_solicitud'>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<br>
					<a href="http://getbootstrap.com/javascript/#modals">Olvidó su ID? Haga clic aquí.</a>
					<br>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<button class="btn btn-success" onclick='js_enviarSolicitud_get_solicitud("{ruta_html}/enviarSolicitud/controller.php");'>Continuar solicitud</button>
				</div>
			</div>
		</div>
	</div>
	<div class="box-footer">
		Continuar solicitud.
	</div>
</div>