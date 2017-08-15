<?php
session_start();
require_once("../../core/viewBase.php");

$diccionario = array(
	  'rutas_head'=>array(
      	'ruta_css'=>$ruta_css,
      	'ruta_html'=>$ruta_html,
      	'ruta_js'=>$ruta_js,
      	'ruta_imagenes'=>$ruta_imagenes,
      	'ruta_includes'=>$ruta_includes
	                     ),
	'usua_datos'=>array(
        'usua_nomb'  		=> $_SESSION['usua_nomb'], 
        'usua_apel' 		=> $_SESSION['usua_apel'],
		'usua_correo' 		=> $_SESSION["usua_correo"],
		'rol_descripcion'	=> $_SESSION["rol_descripcion"]
                        )
);
?>