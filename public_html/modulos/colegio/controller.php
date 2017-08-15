<?php
session_start();
require_once('../../core/controllerBase.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{   $colegio	= get_mainObject('Colegio');
	$event 		= get_actualEvents(array(VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
	$user_data 	= get_frontData();
	
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla = "categoria_table";}else{$tabla =$_POST['tabla'];}

    switch ($event)
	{   case GET_COLEGIO:
			global $diccionario;
			$colegio->get_ColegioSelectFormat( '', $user_data['ciudadID'] );
			$data['{'.$user_data['combo_nombre_colegio'].'}'] = array ( "elemento"  => 	"combo", 
																		"datos"     => 	$colegio->rows, 
																		"options"   => 	array(	"name"		=>$user_data['combo_nombre_colegio'],
																								"id"		=>$user_data['combo_nombre_colegio'],
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