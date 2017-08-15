<?php
session_start();
require_once('../../core/controllerBase.php');
require_once('../general/model.php');
require_once('../periodo/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');
function handler()
{	require('/../../core/rutas.php');
	$interesado = get_mainObject('Interesado');
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
            $interesado->get_all();
      		if(count($interesado->rows)>0)
			{	
				global $diccionario;
				$opciones["Editar"] = "<span onclick='carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/interesado/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
				$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/interesado/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
				$data['{tabla}']= array("elemento"=>"tabla",
								  "clase"=>"display datatable",
								  "id"=>"tbl_interesados",
								  "datos"=>$interesado->rows,
								  "encabezado" => array("Código",
														"Nombres",
														"Apellidos",
														"C&eacute;dula",
														"Celular",
														"Correo",
														"Opciones"),
														"options"=>array($opciones),
														"campo"=>"inte_codigo");
				$data['mensaje'] = "Listado de empleados";
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
            $interesado->get_all();
      		if(count($interesado->rows)>0)
			{	
				global $diccionario;
				$opciones["Editar"] = "<span onclick='carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/interesado/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
				$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/interesado/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
				$data['{tabla}']= array("elemento"=>"tabla",
								  "clase"=>"display datatable",
								  "id"=>"tbl_interesados",
								  "datos"=>$interesado->rows,
								  "encabezado" => array("Código",
														"Nombres",
														"Apellidos",
														"C&eacute;dula",
														"Celular",
														"Correo",
														"Opciones"),
														"options"=>array($opciones),
														"campo"=>"inte_codigo");
				$data['mensaje'] = "Listado de interesados:";
      		}
			else
			{	
				$data = array('mensaje'=>$interesado->mensaje.$periodo->ErrorToString());
      		}
            retornar_result($data);
            break;
        case VIEW_SET:
            $data = array ();
            retornar_formulario(VIEW_SET, $data);
            break;
        case SET:
            $user_data['usua_codigo'] = $_SESSION['usua_codigo'];
            $interesado->set($user_data);
			print_r($interesado->mensaje);
            break;  
        case GET:
            $interesado->get($user_data['codigo']);
            $data = array('codigo'=>$user_data['codigo'],
                          'interesado_primer_nombre'=>$interesado->inte_primer_nombre,
            			  'interesado_segundo_nombre'=>$interesado->inte_segundo_nombre,
            			  'interesado_primer_apellido'=>$interesado->inte_primer_apellido,
						  'interesado_segundo_apellido'=>$interesado->inte_segundo_apellido,
						  'interesado_telefono'=>$interesado->inte_telefono,
						  'interesado_celular'=>$interesado->inte_celular,
						  'interesado_correo'=>$interesado->inte_correo);
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $interesado->delete($user_data);
            break;
        case EDIT:
        	$user_data['usua_codigo'] = $_SESSION['usua_codigo'];
            $interesado->edit($user_data);
          break;
        default :
        	break;
    }
}

handler();
?>