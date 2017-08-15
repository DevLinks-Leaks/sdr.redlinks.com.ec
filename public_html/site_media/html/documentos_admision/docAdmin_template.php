<?php 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>CAG | {subtitulo}</title>
	
	<link href="{ruta_includes}/jquery/jquery-ui/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="{ruta_includes}/plugins/daterangepicker/daterangepicker-bs3.css">
	<link rel="stylesheet" href="{ruta_includes}/plugins/datepicker/datepicker3.css" />
	<link rel="shortcut icon" href="{ruta_imagenes}/favicon.ico" />
	<link href="{ruta_includes}/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="{ruta_includes}/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet">
	
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{ruta_includes}/bootstrap/css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{ruta_includes}/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{ruta_includes}/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="{ruta_includes}/plugins/select2/select2.min.css">

	
<style >
  td.details-control {
    background: url('{ruta_imagenes}/details_open.png') no-repeat center center;
        cursor: pointer;
  }
  tr.shown td.details-control {
    background: url('{ruta_imagenes}/details_close.png') no-repeat center center;
  }

  .input{
    padding: 0;
    margin: 0;
  }
</style>

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
            <li><a href="#"><i class="fa fa-home"></i> Supervisor</a></li>
            <li class="active">{subtitulo}</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
		
          <!-- SELECT2 EXAMPLE -->
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Mantenimiento documentos para admisi&oacute;n</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> NO REMOVER-->
              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
				<div id="formulario">
					{formulario}
				</div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              Mantenimiento documentos para admisi&oacute;n.
            </div>
          </div>
        </section><!-- /.content -->
		<!-- Control Sidebar -->
		{menu_sidebar}
      </div><!-- /.content-wrapper -->
	<form id="frm_rutas" name="frm_rutas" enctype="multipart/form-data" method="post">
		<input type="hidden" id="ruta_imagenes" name="ruta_imagenes" value="{ruta_imagenes}" />
		<input type="hidden" id="ruta_html" name="ruta_html" value="{ruta_html}" />
		<input type="hidden" id="ruta_js" name="ruta_js" value="{ruta_js}" />
		<input type="hidden" id="ruta_css" name="ruta_css" value="{ruta_css}" />
	</form>
	{footer}
	</div><!-- ./wrapper -->
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
    <script src="{ruta_includes}/plugins/select2/select2.full.min.js"></script>
	<!-- DataTables -->
	<script src="{ruta_includes}/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="{ruta_includes}/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="{ruta_includes}/plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="{ruta_includes}/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="{ruta_includes}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="{ruta_includes}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="{ruta_includes}/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="{ruta_includes}/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="{ruta_includes}/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{ruta_includes}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="{ruta_includes}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="{ruta_includes}/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{ruta_includes}/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{ruta_includes}/dist/js/demo.js"></script>
	
	<script src="{ruta_includes}/growl/jquery.growl.js" type="text/javascript"></script>
    <link  href="{ruta_includes}/growl/jquery.growl.css" rel="stylesheet" type="text/css" />
	<script src="{ruta_includes}/maskmoney/src/jquery.maskMoney.js" type="text/javascript"></script>
	<script src="{ruta_includes}/bootstrap-validator-master/js/validator.js" type="text/javascript"></script>
    
	<script src="{ruta_js}/menu.js"></script>
	<script src="{ruta_js}/docAdmin.js"></script>
	<script src="{ruta_js}/general.js"></script>
</body>
</html>