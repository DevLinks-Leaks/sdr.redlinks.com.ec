<?php
session_start();
require_once('../../core/controllerBase.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{   $profesion	= get_mainObject('Profesion');
	$event 		= get_actualEvents(array(VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
	$user_data 	= get_frontData();
	
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla = "categoria_table";}else{$tabla =$_POST['tabla'];}

    switch ($event)
	{   case GET_PROFESION:
			global $diccionario;
			$profesion->get_ProfesionSelectFormat( $user_data['profesion_codi'] );
			$data['{'.$user_data['combo_nombre_profesion'].'}'] = array("elemento"  => 	"combo", 
																		"datos"     => 	$profesion->rows, 
																		"options"   => 	array(	"name"		=>$user_data['combo_nombre_profesion'],
																								"id"		=>$user_data['combo_nombre_profesion'],
																								"required"	=>"required",
																								"class"		=>"form-control",
																								"onChange"	=> ""),
																		"selected"  => 	0);
			retornar_result($data);
            break;
        default :
        	break;
    }
}

handler();
?>