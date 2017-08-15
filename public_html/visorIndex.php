<?php 
include("core/rutas.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Educalinks | Sistema de descarga de facturas autorizadas </title>

<link href="<?= $ruta_includes;?>/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?= $ruta_includes;?>/bootstrap/css/theme.css" rel="stylesheet">
<link href="<?= $ruta_includes;?>/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?= $ruta_includes;?>/jquery/jquery-ui/jquery-ui.css" rel="stylesheet">
<link rel="shortcut icon" href="site_media/imagenes/favicon.png" />
<link rel="stylesheet" type="text/css" media="screen" href="{ruta_includes}/bootstrap/css/datatable-bootstrap.css">
<script src="<?= $ruta_includes;?>/jquery/jquery-2.1.1.js"></script>
<script src="<?= $ruta_includes;?>/bootstrap/js/bootstrap.js"></script>
<script src="<?= $ruta_includes;?>/jquery/jquery-ui/jquery-ui.js"></script>

</head>
<body>
	<div class="container">
	  <h1 style="display:block-inline; width:500px; margin: 0px auto; text-align:center;">Visor de facturas autorizadas</h1>
      <form class="form-signin" action="<?= $ruta_main;?>documentosAutorizados/" method="post" enctype="multipart/form-data">
        <h2 class="form-signin-heading" style="text-align:center;">Inicio de sesión</h2>
         <?php 
		  session_start();
		  if (isset($_SESSION['IN']) && $_SESSION['IN']!="OK"){?>
			  <div class="alert alert-warning" role="alert">
				<label><?php echo $_SESSION['ERROR_MSG'];?></label>
              </div>
		  <?php }else{	
		  		session_start();
				session_unset();
				session_destroy();
		  }
		  session_start();
		  include("dbconf.php");
		  $params = array($domain);
		  $sql="{call dbo.clie_info_domain(?)}";
		  $resu_login = sqlsrv_query($conn, $sql, $params);  
		  $row = sqlsrv_fetch_array($resu_login);
		  $_SESSION['host']=$row['clie_instancia_db'];
		  $_SESSION['user']=$row['clie_user_db'];
		  $_SESSION['pass']=$row['clie_pass_db'];
		  $_SESSION['dbname']=$row['clie_base'];
		  ?>
        <input type="text" name="cliente_numeroIdentificacion" id="cliente_numeroIdentificacion" class="form-control first" placeholder="Cédula cliente" required autofocus>
        <input type="password" id="cliente_clave" name="cliente_clave" class="form-control last" placeholder="Contraseña" required>
        <input type="hidden" id="event" name="event" value="login">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
      </form>
    </div> <!-- /container -->
</body>
</html>