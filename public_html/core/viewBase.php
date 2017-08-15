<?php
session_start();
require_once("modelHTML.php");
require_once("rutas.php");
require_once("diccionario_menu.php");


# ======================================================
# Procedimientos de soporte para las interfaces
# ======================================================
function get_template($form='get') {
    $file = '../../site_media/html/'.HTML_FILES.$form.'.php';
    $template = file_get_contents($file);
    return $template;
}
function get_menu(){
	global $diccionario_menu;
	if( $_SESSION["rol_descripcion"] == 'empleado' )
	{	$file="../../site_media/html/menu_empleado.php";
	}
	else
	{   $file="../../site_media/html/menu.php";
	}
	$menu=file_get_contents($file);
	for($i=0;$i<count($_SESSION['usua_permiso'])-1;$i++){
		foreach($diccionario_menu as $campo => $valor){
			$array = explode("</span>", $valor['texto']);
			if(trim($valor['permiso'])==trim($_SESSION['usua_permiso'][$i][0])){
				if($valor['href']=='../gestionFacturas/'){
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_fac_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../gestionNotascredito/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_nc_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../gestionNotasdebito/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_nd_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../gestionContifico/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_contifico"></span></a>',$menu);
				}
				elseif($valor['href']=='../valida_cheques/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_cheques_in"></span></a>',$menu);
				}
				else{
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].'</span></a>',$menu);
				}	
			}
		}
	}
	foreach($diccionario_menu as $campo => $valor){
		if(trim($valor['permiso'])!=trim($_SESSION['usua_permiso'][$i][0])){
			$menu=str_replace($campo,'',$menu);
		}
	}
	$menu = str_replace('{fotoUsuario}', $_SESSION['ruta_foto_usuario'].'admin.jpg', $menu);
	return $menu;
}
function get_navbar(){
	$file="../../site_media/html/navbar.php";
	$navbar=file_get_contents($file);
	
	$navbar = str_replace('{fotoUsuario}', $_SESSION['ruta_foto_usuario'].'admin.jpg', $navbar);
	return $navbar;
}
function get_menu_sidebar(){
	$file="../../site_media/html/menu_sidebar.php";
	$sidebar=file_get_contents($file);
	return $sidebar;
}
function get_footer(){
	$file="../../site_media/html/footer.php";
	$footer=file_get_contents($file);
	return $footer;
}
function get_menuVisor(){
    $file="../../site_media/html/menuVisor.php";
    $menu=file_get_contents($file);
    return $menu;
}
function get_navbarVisor(){
    $file="../../site_media/html/navbarVisor.php";
    $navbar=file_get_contents($file);
    return $navbar;
}



function activa_menu($vista,$html){
	global $diccionario;
    $html = str_replace($diccionario['active_menu']['mainmenu'] , 'in', $html);
    $html = str_replace($diccionario['active_menu']['submenu'] , 'active', $html);
	$html = str_replace($diccionario['active_menu']['open'] , 'active', $html);
	return $html;
}
function render_dinamic_content($html, $data){
    foreach ($data as $clave=>$valor) {
        if( $clave[0]=="{" && $clave[strlen($clave)-1]=="}" ){
            # Elementos HTML con contenido dinamico
            switch ($valor['elemento']) {
				case 'a':
                    $html = str_replace($clave, HTML::a($valor['href'],$valor['content'],$valor['optional']), $html);
					break;
				case 'barChart':
                    $html = str_replace($clave, HTML::barChart($valor['datos'], $valor['label'], $valor['contenedor']), $html);
                    break;
				case 'lineChart':
                    $html = str_replace($clave, HTML::lineChart($valor['datos'], $valor['label'], $valor['contenedor']), $html);
                    break;
				case 'pieChart':
                    $html = str_replace($clave, HTML::pieChart($valor['datos'], $valor['contenedor']), $html);
                    break;
                case 'combo':
                    $html = str_replace($clave, HTML::select($valor['datos'],$valor['options'],$valor['selected']), $html);
                    break;
				case 'div':
                    $html = str_replace($clave, HTML::div($valor['content'],$valor['optional']), $html);
                    break;
                case 'tabla':
                    $html = str_replace($clave, HTML::table($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'],$valor['campo']), $html);
                    break;
				case 'tabla_deudas':
                    $html = str_replace($clave, HTML::TableDeudasPendientes($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'],$valor['campo']), $html);
                    break;
                case 'tabla_anidada':
                    $html = str_replace($clave, HTML::table_anidada($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'],$valor['campo'], (array_key_exists('anidada', $valor)?$valor['anidada']:false )), $html);
					break;
				case 'lista':
                    $html = str_replace($clave, HTML::ul($valor['datos'],$valor['options']), $html);
                    break;
                case 'text_box':
                    $html = str_replace($clave, HTML::input($valor['valor'], $valor['options']), $html);
                    break;
                case 'tablaSencilla':
                    $html = str_replace($clave, HTML::singleTable($valor['datos'], $valor['encabezado'], $valor['atributos']), $html); 
					break;                   
				case 'checkListBox':
                    $html = str_replace($clave, HTML::checkListBox($valor['datos'], $valor['campoVisualizacion'], $valor['campoValor'], /*$valor['atributos'],*/ $valor['valoresSeleccionados'], $valor['funcion']), $html);                
                    break;
                case 'tablaVisor':
                    $html = str_replace($clave, HTML::tableVisor($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'], (array_key_exists('anidada', $valor)?$valor['anidada']:false )), $html);
                    break;
				case 'tablaArrayIn':
                    $html = str_replace($clave, HTML::tableArrayIn($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'], (array_key_exists('anidada', $valor)?$valor['anidada']:false )), $html);
                    break;
                default:
                    break;
			 case 'tablaInputsencilla':
                    $html = str_replace($clave, HTML::tablaInputsencilla($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'],$valor['campo'], (array_key_exists('anidada', $valor)?$valor['anidada']:false )), $html);
					break;   
            }
        }else{
            # Datos estaticos
            $html = str_replace('{'.$clave.'}', $valor, $html);
        }
    }
    return $html;
}

# ======================================================
# Interfaces para el controlador
# ======================================================

function retornar_vista_submit($vista, $data=array()) {
	
    global $diccionario;
    $html = get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{formulario}', get_template($vista), $html);
    $html = str_replace('{menu}', get_menu(), $html);
	$html = str_replace('{navbar}', get_navbar(), $html);
	$html = str_replace('{menu_sidebar}', get_menu_sidebar(), $html);
	$html = str_replace('{footer}', get_footer(), $html);
    $html = render_dinamic_content($html, $diccionario['form_actions']);
    $html = render_dinamic_content($html, $diccionario['rutas_head']);
    $html = render_dinamic_content($html, $diccionario['links_menu']);
	$html = render_dinamic_content($html, $diccionario['usua_datos']);
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
function retornar_vista($vista, $data=array()) {
    global $diccionario;
    $html = get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{formulario}', get_template($vista), $html);
    $html = str_replace('{menu}', get_menu(), $html);
	$html = str_replace('{navbar}', get_navbar(), $html);
	$html = str_replace('{menu_sidebar}', get_menu_sidebar(), $html);
	$html = str_replace('{footer}', get_footer(), $html);
    $html = render_dinamic_content($html, $diccionario['form_actions']);
    $html = render_dinamic_content($html, $diccionario['rutas_head']);
    $html = render_dinamic_content($html, $diccionario['links_menu']);
	$html = render_dinamic_content($html, $diccionario['usua_datos']);
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
function retornar_vista_in($vista, $data_in=array()) {
    global $diccionario;
    $html = get_template($vista);
    $html = render_dinamic_content($html, $data_in);
        
    if(array_key_exists('mensaje_in', $data_in)) {
        $mensaje = $data_in['mensaje_in'];
    } else {
        $mensaje = '';
    }
    $html = str_replace('{mensaje_in}', $mensaje, $html);
	return $html;
    
}
function retornar_formulario($vista, $data=array()) {
    global $diccionario;
    $html = get_template($vista);
    $html = render_dinamic_content($html, $diccionario['form_actions']);
    $html = render_dinamic_content($html, $diccionario['rutas_head']);
    $html = render_dinamic_content($html, $diccionario['links_menu']);
    $html = render_dinamic_content($html, $data);
    $html = str_replace('{mensaje}', $mensaje, $html);
    print $html;
}

function retornar_result($data=array()){
    $html = "";
    foreach ($data as $elemento => $valor) {
        if( $elemento[0]=="{" && $elemento[strlen($elemento)-1]=="}" ){
            $html .= $elemento;
        }else{
            $html .= "{".$elemento."}";
        }
    }
    $html = render_dinamic_content($html,$data);

    print $html;
}

function retornar_pagina($vista, $data=array()) {
    $html = get_template($vista);
    $html = render_dinamic_content($html, $data);
    print $html;
}

function retornar_mensaje($mensaje) {
    //$html = get_template($vista);
    $html = $mensaje;
    print $html;
}


function retornar_vistaVisor($vista, $data=array()) {
    global $diccionario;
    $html = get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{formulario}', get_template($vista), $html);
    //$html = str_replace('{menu}', get_menuVisor(), $html);
    $html = str_replace('{navbar}', get_navbarVisor(), $html);
    $html = render_dinamic_content($html, $diccionario['form_actions']);
    $html = render_dinamic_content($html, $diccionario['rutas_head']);
    $html = render_dinamic_content($html, $diccionario['links_menu']);
    $html = render_dinamic_content($html, $diccionario['usua_datos']);
    $html = render_dinamic_content($html, $data);
    $html = activa_menu($vista, $html);
        
    if(array_key_exists('mensaje', $data)) {
        $mensaje = $data['mensaje'];
    } else {
        $mensaje = 'Listado de usuarios:';
    }
    $html = str_replace('{mensaje}', $mensaje, $html);

    print $html;
}
?>