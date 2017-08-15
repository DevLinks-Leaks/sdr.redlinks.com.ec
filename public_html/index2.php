<?php 
include("core/rutas.php");
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>SDR Links | Sistema de Redlinks</title>
<link href="<?= $ruta_includes;?>/bootstrap/css/bootstrap.css" rel="stylesheet" />
<link href="<?= $ruta_includes;?>/bootstrap/css/theme.css" rel="stylesheet" />
<link href="<?= $ruta_includes;?>/bootstrap/css/bootstrap-theme.css" rel="stylesheet" />
<link href="<?= $ruta_includes;?>/jquery/jquery-ui/jquery-ui.css" rel="stylesheet" />
<link href="<?= $ruta_imagenes;?>/favicon.ico" rel="shortcut icon" />
<link href="<?= $ruta_includes;?>/bootstrap/css/datatable-bootstrap.css" type="text/css" media="screen"  rel="stylesheet" />
<!-- AdminLTE -->
<link rel="stylesheet" href="<?= $ruta_includes;?>/dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="<?= $ruta_includes;?>/dist/css/skins/_all-skins.min.css">
<!-- AdminLTE -->
<script src="<?= $ruta_includes;?>/jquery/jquery-2.1.1.js"></script>
<script src="<?= $ruta_includes;?>/bootstrap/js/bootstrap.js"></script>
<script src="<?= $ruta_includes;?>/jquery/jquery-ui/jquery-ui.js"></script>
</head>
<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			SDR Administrativo
		</div>
		<div class="login-box-body">
			<p class="login-box-msg">Iniciar sesión</p>
			<form action="general/" method="post">
				<div class="form-group has-feedback">
					<input type="text" id="username" name="username" class="form-control" placeholder="Usuario" tabindex="1">
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" tabindex="2">
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-xs-8">
						<a href='http://sdr.redlinks.com.ec'>Empleados</a>
					</div>
					<div class="col-xs-4">
						<button type="submit" class="btn btn-primary btn-block btn-flat" tabindex="3">Ingresar</button>
						<input type="hidden" id="event" name="event" value="index" />
					</div>
				</div>
			</form>
		</div>
	</div>   
</body>
</html>
