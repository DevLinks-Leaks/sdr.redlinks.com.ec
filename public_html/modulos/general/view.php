<?php
session_start();
require_once("../../core/viewBase.php");
$diccionario = array(
    'subtitle'=>array(  VIEW_HOME=>'Inicio',
                        VIEW_PASSWORD=>'Cambiar su Contraseña',
                        VIEW_INFO_USER=>'Información del Usuario',
						VIEW_CONFIG_SIS=>'Información del Sistema',
                     ),
    'rutas_head'=>array(
        'ruta_css'=>$ruta_css,
        'ruta_html'=>$ruta_html,
        'ruta_js'=>$ruta_js,
        'ruta_imagenes'=>$ruta_imagenes,
        'ruta_includes'=>$ruta_includes,
        'ruta_index_header'=>$ruta_index_header),
    'active_menu'=>array(
        'submenu'  => '{menu001}', 
        'mainmenu' => '{menu0}')/*,
    'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'],
        'usua_codigo' => $_SESSION['usua_codigo'])*/
);
function get_main($form='main') {
    $file = '../../site_media/html/'.HTML_FILES.$form.'.php';
    $template = file_get_contents($file);
    return $template;
}
function get_index() {
    /*$file = '../../index.php';
    $template = file_get_contents($file);
    return $template;*/
    global $diccionario;
    //echo $diccionario['rutas_head']['ruta_index_header'];
    header($diccionario['rutas_head']['ruta_index_header']);
}

function retornar_vista_general($vista, $data=array()) {
    global $diccionario;
    
    if($vista==VIEW_MAIN || $vista==VIEW_PASSWORD || $vista==VIEW_HOME || $vista==VIEW_INFO_USER || $vista==VIEW_CONFIG_SIS || $vista=PRINTREP_DEUDORES || $vista=PRINTREPVISOR){
        $html = get_main('main');
    }else{
        $html = get_index();
    }
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{formulario}', get_main($vista), $html);
    $html = str_replace('{navbar}', get_navbar(), $html);
    $html = str_replace('{menu}', get_menu(), $html);
    $html = str_replace('{menu_sidebar}', get_menu_sidebar(), $html);
	$html = str_replace('{footer}', get_footer(), $html);
    $html = render_dinamic_content($html, $diccionario['form_actions']);
    $html = render_dinamic_content($html, $diccionario['rutas_head']);
    $html = render_dinamic_content($html, $diccionario['links_menu']);
    $html = render_dinamic_content($html, array('usua_nombres'  => $_SESSION['usua_nombres'],'usua_apellidos' => $_SESSION['usua_apellidos'],'usua_codigo' => $_SESSION['usua_codigo']));
    $html = render_dinamic_content($html, $data);
    $html = activa_menu($vista, $html); 
        
    if(array_key_exists('mensaje', $data)) {
        $mensaje = $data['mensaje'];
    } else {
        $mensaje = '';
    }
    $html = str_replace('{mensaje}', $mensaje, $html);

    print $html;
}

?>