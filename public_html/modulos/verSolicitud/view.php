<?php
session_start();
require_once("../../core/viewBase.php");

//Como del menú se llama al mismo controller en más de una opción, 
//se manda desde el menu.js (funciones cuyo nombre inician con js_verSolicitud) una variable
//'submenu', que selecciona el active en el menú. Y una variable 'soli_estado', 
//que carga la misma bandeja con diferentes registros.

if( !empty ( $_POST['submenu'] ) )
	$submenu = $_POST['submenu'];
else
	$submenu = '{menuSoli01}';

$diccionario = array(
    'subtitle'	=>array(
        VIEW_GET_ALL	=> 'Bandeja de solicitudes'
                     ),
	'rutas_head'=>array(
      	'ruta_css'		=> $ruta_css,
      	'ruta_html'		=> $ruta_html,
      	'ruta_js'		=> $ruta_js,
      	'ruta_imagenes'	=> $ruta_imagenes,
      	'ruta_includes'	=> $ruta_includes
	                    ),
    'active_menu'=>array(
        'submenu'  		=> $submenu,
		'open'  		=> '{openSoli}', 
        'mainmenu' 		=> '{menuSoli}'
                        ),
	'usua_datos'=>array(
        'usua_nomb'  		=> $_SESSION['usua_nomb'], 
        'usua_apel' 		=> $_SESSION['usua_apel'],
		'usua_correo' 		=> $_SESSION["usua_correo"],
		'rol_descripcion'	=> $_SESSION["rol_descripcion"]
                        )
);
?>