<?php
session_start();
require_once("../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear un nuevo registro de empleado',
		VIEW_SET_GET_ALL=>'Crear y mostrar',
        VIEW_GET=>'Buscar empleado',
        VIEW_GET_ALL=>'Administración de períodos',					  
        VIEW_DELETE=>'Eliminar',
        VIEW_EDIT=>'Editar'
                     ),
	  'rutas_head'=>array(
      	'ruta_css'=>$ruta_css,
      	'ruta_html'=>$ruta_html,
      	'ruta_js'=>$ruta_js,
      	'ruta_imagenes'=>$ruta_imagenes,
      	'ruta_includes'=>$ruta_includes
	                     ),
    'active_menu'=>array(
        'submenu'	=> '{menuadminPeriodos}', 
		'open'		=> '',
        'mainmenu'	=> ''
                        ),
	'usua_datos'=>array(
        'usua_nomb'  		=> $_SESSION['usua_nomb'], 
        'usua_apel' 		=> $_SESSION['usua_apel'],
		'usua_correo' 		=> $_SESSION["usua_correo"],
		'rol_descripcion'	=> $_SESSION["rol_descripcion"]
                        )
);
?>