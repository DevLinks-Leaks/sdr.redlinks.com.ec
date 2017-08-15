<?php
session_start();
require_once('../../core/controllerBase.php');
require_once('../general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{	require('../../core/rutas.php');
	$periodo = get_mainObject('Periodo');
	$general = get_mainObject('General');
	$event = get_actualEvents(array(VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
	$user_data = get_frontData();

    switch ($event)
	{	case VIEW_GET_ALL:
			if (isset($_SESSION['IN']))
			{	if($_SESSION['IN']!="OK")
				{	$_SESSION['IN']="KO";
					header("Location: http://".$domain."/admisiones_americano/salir.php");
				}
				else
				{	$data["usua_nomb"]=$_SESSION["usua_nomb"];
					$data["usua_apel"]=$_SESSION["usua_apel"];
					$data["usua_correo"]=$_SESSION["usua_correo"];
					$data["rol_descripcion"]=$_SESSION["rol_descripcion"];
				}
			}
			else
			{	header("Location: http://".$domain."/admisiones_americano");
			}
            $periodo->get_all();
      		if(count($periodo->rows)>0)
			{	
				global $diccionario;
				$opciones["Editar"] = "<span onclick='carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/periodo/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
				$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/periodo/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
				$data['{tabla}']= array("elemento"=>"tabla",
								  "clase"=>"display datatable",
								  "id"=>"tbl_periodos",
								  "datos"=>$periodo->rows,
								  "encabezado" => array("Código",
														"Descripción",
														"Inicio",
														"Fin",
														"Estado",
														"Opciones"),
														"options"=>array($opciones),
														"campo"=>"peri_codigo");
				$data['mensaje'] = "Listado de periodos:";
      		}
			else
			{	$data = array('mensaje'=>$periodo->mensaje.$periodo->ErrorToString());
      		}
			$periodo->get_combo_all();
			$data["{cmb_periodos}"] = array("elemento"  => "combo", 
										   "datos"     => $periodo->rows,
										   "options"   => array("name"=>"periodo_select","id"=>"periodo_select","class"=>"form-control","required"=>"required","onchange"=>"change_periodo('".$diccionario['rutas_head']['ruta_html']."/general/controller.php')","style"=>"margin-top:7px"),
										   "selected"  => $_SESSION['peri_codi']);
      		retornar_vista(VIEW_GET_ALL, $data);
            break;
        case GET_ALL_DATA:
            $periodo->get_all();
			if(count($periodo->rows)>0)
			{	
				global $diccionario;
				$opciones["Editar"] = "<span onclick='carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/periodo/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
				$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/periodo/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
				$data['{tabla}']= array("elemento"=>"tabla",
								  "clase"=>"display datatable",
								  "id"=>"tbl_periodos",
								  "datos"=>$periodo->rows,
								  "encabezado" => array("Código",
														"Descripción",
														"Inicio",
														"Fin",
														"Estado",
														"Opciones"),
														"options"=>array($opciones),
														"campo"=>"peri_codigo");
				$data['mensaje'] = "Listado de periodos:";
      		}
			else
			{	
				$data = array('mensaje'=>$periodo->mensaje.$categoria->ErrorToString());
      		}
            retornar_result($data);
            break;
        case VIEW_SET:
            $data = array ();
            retornar_formulario(VIEW_SET, $data);
            break;
        case SET:
            $user_data['usua_codigo'] = 'SYSTEM';
            $periodo->set($user_data);
            break;  
        case GET:
            $periodo->get($user_data['codigo']);
            $data = array('periodo_codigo'=>$user_data['codigo'],
                          'periodo_descripcion'=>$periodo->peri_descripcion,
            			  'periodo_fechainicio'=>$periodo->peri_fechainicio,
            			  'periodo_fechafin'=>$periodo->peri_fechafin);
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
        	$user_data["usua_codigo"]="SYSTEM";
            $periodo->delete($user_data);
            break;
        case EDIT:
        	$user_data['usua_codigo'] = 'SYSTEM';
            $periodo->edit($user_data);
          break;
        default :
        	break;
    }
}

handler();
?>