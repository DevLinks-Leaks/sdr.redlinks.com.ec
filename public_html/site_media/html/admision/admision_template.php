<?php 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Educalinks | {subtitulo}</title>
	
	<link href="{ruta_includes}/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="{ruta_includes}/bootstrap/css/theme.css" rel="stylesheet">
    <link href="{ruta_includes}/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <link href="{ruta_includes}/jquery/jquery-ui/jquery-ui.css" rel="stylesheet">
    <link href="{ruta_imagenes}/favicon.ico" rel="shortcut icon" />
    <script src="{ruta_includes}/jquery/jquery-2.1.1.js"></script>
    <script src="{ruta_includes}/bootstrap/js/bootstrap.js"></script>
    <script src="{ruta_includes}/jquery/jquery-ui/jquery-ui.js"></script>

	<link href="{ruta_includes}/datatables/jquery.dataTables.css" rel="stylesheet">
	<script type="text/javascript" src="{ruta_includes}/datatables/jquery.dataTables.min.js"></script>
	
	<script src="{ruta_includes}/growl/jquery.growl.js" type="text/javascript"></script>
    <link  href="{ruta_includes}/growl/jquery.growl.css" rel="stylesheet" type="text/css" />
	<script src="{ruta_includes}/maskmoney/src/jquery.maskMoney.js" type="text/javascript"></script>
	<script src="{ruta_includes}/bootstrap-validator-master/js/validator.js" type="text/javascript"></script>
	
	<script src="{ruta_js}/menu.js"></script>
	<script src="{ruta_js}/clientes.js"></script>
	<script src="{ruta_js}/representantes.js"></script>
	<script src="{ruta_js}/general.js"></script>
	<style>
		 div.to0ltip-inner {
			max-width: 300px;
		}

		div.tooltip
		{
			word-wrap: break-word;
		}
		.detalleTooltip{
			background: #fff;
			color: #fff;
			border-radius:4px;
			box-shadow: 5px 5px 8px #CCC;
		}
	</style>
</head>
<body>
	{navbar}
	<div class="container-fluid">
      <!-- MENU-->
      {menu}
      <!-- MENU-->
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main main_content">
        <h1 class="page-header">{subtitulo}</h1>
        <div id="mensaje">
            <h3>{mensaje}</h3>
        </div>
        <div id="formulario">
            {formulario}
        </div>
        <form id="frm_rutas" name="frm_rutas" enctype="multipart/form-data" method="post">
        <input type="hidden" id="ruta_imagenes" name="ruta_imagenes" value="{ruta_imagenes}" />
        <input type="hidden" id="ruta_html" name="ruta_html" value="{ruta_html}" />
        <input type="hidden" id="ruta_js" name="ruta_js" value="{ruta_js}" />
        <input type="hidden" id="ruta_css" name="ruta_css" value="{ruta_css}" />
        </form>
      </div>
    </div>
	<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		var table = $('#tabla_estadoCuenta').DataTable();
		//Si no da click al boton cerrar, sino que da click fuera del modal, las tablas no se reseteaban.
		//Esta funcion arregla eso.
		$('#modal_showDebtState').on('hidden.bs.modal', function () {
			table.destroy();
			$('#tabla_estadoCuenta').empty();
		})
	});
	</script>
</body>
</html>