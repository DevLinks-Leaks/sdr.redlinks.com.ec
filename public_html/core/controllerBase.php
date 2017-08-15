<?php
function get_actualEvents($controllerEvents, $defaultEvent){
	if (!isset($_POST['event'])){ if(!isset($_GET['event'])){ $event = $defaultEvent; }else{ $event =$_GET['event']; } } else { $event =$_POST['event']; }
    $uri = $_SERVER['REQUEST_URI'];
    foreach ($controllerEvents as $peticion) {
        $uri_peticion = MODULO.$peticion.'/';
        if( strpos($uri, $uri_peticion) == true ) {
            $event = $peticion;
        }
    }
    return $event;
}

function get_mainObject($clase){
	$obj = new $clase();
    return $obj;	
}

function get_frontData(){
	$data = array();
	if($_POST) {
		foreach ($_POST as $key => $value) {
			$data[$key] = $value;
		}
	} else if($_GET) {
		foreach ($_GET as $key => $value) {
			$data[$key] = $value;
		}
	}
	return $data;
}
?>