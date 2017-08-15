<?php

require_once("../../core/viewBase.php");
session_start();
$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Nuevo documento para admisi&oacute;n',	 
        VIEW_GET=>'Consulta documentos para admisi&oacute;n',
        VIEW_GET_ALL=>'Consulta de documentos para admisi&oacute;n',
        VIEW_DELETE=>'Eliminar un documento para admisi&oacute;n',
        VIEW_EDIT=>'Modificar un documento para admisi&oacute;n'
                     ),
	  'rutas_head'=>array(
      	'ruta_css'=>$ruta_css,
      	'ruta_html'=>$ruta_html,
      	'ruta_js'=>$ruta_js,
      	'ruta_imagenes'=>$ruta_imagenes,
      	'ruta_includes'=>$ruta_includes
	                     ),
    'active_menu'=>array(
        'submenu'  => '{menuSoliConfigSist02}',
		'open'  => '{openSoliConfigSist}', 
        'mainmenu' => '{menuSoliConfigSist}' 
                        ),
	'usua_datos'=>array(
        'usua_nomb'  		=> $_SESSION['usua_nomb'], 
        'usua_apel' 		=> $_SESSION['usua_apel'],
		'usua_correo' 		=> $_SESSION["usua_correo"],
		'rol_descripcion'	=> $_SESSION["rol_descripcion"]
                        )
);
?>