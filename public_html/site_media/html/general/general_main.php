<?php 
session_start();
include("core/rutas.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>SDRLinks | {subtitulo}</title>
	<!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
    
	<!-- DataTables css -->
	<link href="{ruta_includes}/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="{ruta_includes}/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet">
	
	<!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{ruta_includes}/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{ruta_includes}/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{ruta_includes}/dist/css/skins/_all-skins.min.css">
	<link href="{ruta_imagenes}/favicon.ico" rel="shortcut icon" />
</head>
<body class="hold-transition skin-black-light sidebar-mini">
    <div class="wrapper">
	{navbar}
    <!-- MENU-->
	  {menu}
	  <!-- Left side column. contains the logo and sidebar -->
    <!-- /.MENU-->
	<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            {subtitulo}
            <small>{mensaje}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i></a></li>
            <li class="active">{subtitulo}</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<br>
			<div class="box box-default">
				<div class="box-header with-border">
					<div class="pull-right">
						<span id='span_return_meses' name='span_return_meses'></span>
					</div>
				</div>
				<div class="box-body">
					<input type="hidden" id="hd_mes_bandeja" name="hd_mes_bandeja" value='' >
					<input type="hidden" id="hd_mes_bandeja_nombre" name="hd_mes_bandeja_nombre" value='' >
					<input type="hidden" id="hd_mes_estado" name="hd_mes_estado" value='' >
					<span id='span_mes_estado' name='span_mes_estado' style='font-size:small;'></span>
					<div id="resultado">
						{resultado}
					</div>
				</div>
			</div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
		<!-- jQuery 2.1.4 -->
		<script src="{ruta_includes}/plugins/jQuery/jQuery-2.1.4.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
			$.widget.bridge('uibutton', $.ui.button);
		</script>
		<!-- Bootstrap 3.3.5 -->
		<script src="{ruta_includes}/bootstrap/js/bootstrap.min.js"></script>
		<!-- ChartJS 1.0.1 -->
		<script src="{ruta_includes}/plugins/chartjs/Chart.min.js"></script>
		<!-- FastClick -->
		<script src="{ruta_includes}/plugins/fastclick/fastclick.min.js"></script>
		<!-- AdminLTE App -->
		<script src="{ruta_includes}/dist/js/app.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="{ruta_includes}/dist/js/demo.js"></script>
		
		<!-- DataTables -->
		<script src="{ruta_includes}/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="{ruta_includes}/plugins/datatables/dataTables.bootstrap.min.js"></script>
		
		<script src="{ruta_js}/menu.js"></script>
		<script src="{ruta_js}/general.js"></script>
		<script src="{ruta_js}/adminPeriodos.js"></script>
		
		<script>
		{barras_solicitudes_por_sector}
		{barras_solicitudes_por_estado}
		{barras_solicitudes_por_publicidad}
		{lineas_solicitudes_por_curso}
		{pie_solicitudes_por_mes}
		</script>
	<!-- page script -->
	  {footer}
	<form id="frm_rutas" name="frm_rutas" enctype="multipart/form-data" method="post">
		<input type="hidden" id="ruta_imagenes" name="ruta_imagenes" value="{ruta_imagenes}" />
		<input type="hidden" id="ruta_html" name="ruta_html" value="{ruta_html}" />
		<input type="hidden" id="ruta_js" name="ruta_js" value="{ruta_js}" />
		<input type="hidden" id="ruta_css" name="ruta_css" value="{ruta_css}" />
		<input type="hidden" id="index" name="index" value="{tipoid}" />
	</form>
	</div><!-- ./wrapper -->
</body>
</html>
