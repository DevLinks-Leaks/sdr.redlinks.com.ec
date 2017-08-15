<?php
session_start();
require_once("../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_GET_ALL=>'Acerca de Educalinks'
                     ),
	  'rutas_head'=>array(
      	'ruta_css'=>$ruta_css,
      	'ruta_html'=>$ruta_html,
      	'ruta_js'=>$ruta_js,
      	'ruta_imagenes'=>$ruta_imagenes,
      	'ruta_includes'=>$ruta_includes
	                     ),
    'active_menu'=>array(
        'submenu'  => '{menu111}',
		'open'  => '{open7}',
        'mainmenu' => '{menu1}' 
                        ),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
?>