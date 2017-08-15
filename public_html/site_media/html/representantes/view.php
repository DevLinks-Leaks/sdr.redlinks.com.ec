<?php
session_start();
require_once("../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear un nuevo cliente',
		    VIEW_SET_GET_ALL=>'Crear y mostrar los clientes',
        VIEW_GET=>'Buscar cliente',
        VIEW_GET_ALL=>'Consultar todos los clientes',					  
        VIEW_DELETE=>'Eliminar un cliente',
        VIEW_EDIT=>'Modificar cliente'
                     ),
    /*'links_menu'=>array(
        'VIEW_SET'=>MODULO.VIEW_SET.'/',
		'VIEW_SET_GET_ALL'=>MODULO.VIEW_SET_GET_ALL.'/',
        'VIEW_GET'=>MODULO.VIEW_GET.'/',
        'VIEW_GET_ALL'=>MODULO.VIEW_GET_ALL.'/',		
        'VIEW_EDIT'=>MODULO.VIEW_EDIT.'/',
        'VIEW_DELETE'=>MODULO.VIEW_DELETE.'/'
                      ),
    'form_actions'=>array(
        'SET'=>API.MODULO.SET.'/',
		    'SET_GET_ALL'=>API.MODULO.SET_GET_ALL.'/',
        'GET'=>API.MODULO.GET.'/',
        'GET_ALL'=>API.MODULO.GET_ALL.'/',
        'DELETE'=>API.MODULO.DELETE.'/',
        'EDIT'=>API.MODULO.EDIT.'/'
                          ),*/
	  'rutas_head'=>array(
      	'ruta_css'=>$ruta_css,
      	'ruta_html'=>$ruta_html,
      	'ruta_js'=>$ruta_js,
      	'ruta_imagenes'=>$ruta_imagenes,
      	'ruta_includes'=>$ruta_includes
	                     ),
    'active_menu'=>array(
        'submenu'  => '{menu304}',
		'open'  => '{open3}', 
        'mainmenu' => '{menu3}' 
                        ),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
?>