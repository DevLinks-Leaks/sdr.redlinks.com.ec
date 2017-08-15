<?php
session_start();
require_once('../../core/controllerBase.php');
require_once('constants.php');
require_once('view.php');

function handler() {
	$event = get_actualEvents(array(VIEW_GET_ALL), VIEW_GET_ALL);
	$user_data = get_frontData();

    switch ($event) {
    	case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            $data['mensaje'] = "Acerca de";
      		retornar_vista(VIEW_GET_ALL, $data);
            break;
        default :
        	break;
    }
}

handler();
?>