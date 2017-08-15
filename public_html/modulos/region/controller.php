<?php
session_start();
require_once('../../core/controllerBase.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{   $pais 		= get_mainObject('Region');
	$provincia 	= get_mainObject('Region');
	$ciudad 	= get_mainObject('Region');
	$event = get_actualEvents(array(VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
	$user_data = get_frontData();
	
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla = "categoria_table";}else{$tabla =$_POST['tabla'];}

    switch ($event)
	{   case GET_PAIS:
			global $diccionario;
			$pais->get_PaisSelectFormat( $user_data['paisCodigo'] );
			$data['{'.$user_data['combo_nombre_pais'].'}'] = array ("elemento"  => 	"combo", 
																	"datos"     => 	$pais->rows, 
																	"options"   => 	array(	"name"		=>$user_data['combo_nombre_pais'],
																							"id"		=>$user_data['combo_nombre_pais'],
																							"required"	=>"required",
																							"class"		=>"form-control",
																							"onChange"	=> "js_region_cargaCiudadDistrito('".$user_data['div_ciudad']."','".$user_data['div_ciudaddistrito']."','".$user_data['combo_nombre_ciudad']."','".$user_data['combo_nombre_ciudaddistrito']."','".$user_data['combo_nombre_pais']."', '".$diccionario['rutas_head']['ruta_html']."/region/controller.php')"),
																	"selected"  => 	0);
			retornar_result($data);
            break;
		case GET_CIUDADDISTRITO:
			global $diccionario;
			if( $user_data['paisCodigo'] == -1 )
			{   $data['{'.$user_data['combo_nombre_ciudaddistrito'].'}'] = array (  "elemento"  => 	"combo", 
																					"datos"     => 		array(0 => array(	0 => -1, 
																															1 => 'Seleccione...',
																															3 => ''), 
																											  2=> array()), 
																					"options"   => 	array(	"name"		=>$user_data['combo_nombre_ciudaddistrito'],
																											"id"		=>$user_data['combo_nombre_ciudaddistrito'],
																											"required"	=>"required",
																											"class"		=>"form-control",
																											"onChange"	=> "js_region_cargaCiudad('".$user_data['div_ciudad']."','".$user_data['combo_nombre_ciudad']."','".$user_data['combo_nombre_ciudaddistrito']."','".$user_data['combo_nombre_pais']."','".$diccionario['rutas_head']['ruta_html']."/region/controller.php')"),
																					"selected"  => 	0);
			}
			else
			{   $provincia->get_CiudadDistritoSelectFormat( $user_data['paisCodigo'], $user_data['ciudadDistritoCodigo'] );
				$data['{'.$user_data['combo_nombre_ciudaddistrito'].'}'] = array (  "elemento"  => 	"combo", 
																					"datos"     => 	$provincia->rows, 
																					"options"   => 	array(	"name"		=>$user_data['combo_nombre_ciudaddistrito'],
																											"id"		=>$user_data['combo_nombre_ciudaddistrito'],
																											"required"	=>"required",
																											"class"		=>"form-control",
																											"onChange"	=> "js_region_cargaCiudad('".$user_data['div_ciudad']."','".$user_data['combo_nombre_ciudad']."','".$user_data['combo_nombre_ciudaddistrito']."','".$user_data['combo_nombre_pais']."','".$diccionario['rutas_head']['ruta_html']."/region/controller.php')"),
																					"selected"  => 	0);
			}
			retornar_result($data);
			break;
		case GET_CIUDAD:
			global $diccionario;
			if( $user_data['ciudadDistritoCodigo'] == -1 )
			{   $data['{'.$user_data['combo_nombre_ciudad'].'}'] = array (  "elemento"  => 	"combo", 
																			"datos"     => 		array(0 => array(	0 => -1, 
																													1 => 'Seleccione...',
																													3 => ''), 
																									  2=> array()), 
																			"options"   => 	array(	"name"		=>$user_data['combo_nombre_ciudad'],
																									"id"		=>$user_data['combo_nombre_ciudad'],
																									"required"	=>"required",
																									"class"		=>"form-control",
																									"onChange"	=>	""),
																			"selected"  => 	0);
			}
			else
			{   $ciudad->get_CiudadSelectFormat( $user_data['paisCodigo'], $user_data['ciudadDistritoCodigo'], $user_data['ciudadID'] );
				$data['{'.$user_data['combo_nombre_ciudad'].'}'] = array (  "elemento"  => 	"combo", 
																			"datos"     => 	$ciudad->rows, 
																			"options"   => 	array(	"name"		=>$user_data['combo_nombre_ciudad'],
																									"id"		=>$user_data['combo_nombre_ciudad'],
																									"required"	=>"required",
																									"class"		=>"form-control",
																									"onChange"	=>	""),
																			"selected"  => 	0);
			}
			retornar_result($data);
            break;
        default :
        	break;
    }
}

handler();
?>