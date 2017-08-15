<?php
session_start();
require_once('../../core/controllerBase.php');
require_once('../general/model.php');
require_once('../periodo/model.php');
require_once('../rol/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{	
	require('/../../core/rutas.php');
	$usuario = get_mainObject('Usuario');
	$periodo = get_mainObject('Periodo');
	$rol = get_mainObject('Rol');
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
            $usuario->get_all();
      		if(count($usuario->rows)>0)
			{	
				global $diccionario;
				$opciones["Editar"] = "<span onclick='carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/usuario/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
				$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/usuario/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
				$data['{tabla}']= array("elemento"=>"tabla",
								  "clase"=>"display datatable",
								  "id"=>"tbl_usuarios",
								  "datos"=>$usuario->rows,
								  "encabezado" => array("Usuario",
														"Nombres",
														"Apellidos",
														"Correo",
														"Rol",
														"Estado",
														"Opciones"),
														"options"=>array($opciones),
														"campo"=>"usua_codigo");
				$data['mensaje'] = "Listado de usuarios:";
      		}
			else
			{	
				$data = array('mensaje'=>$usuario->mensaje.$usuario->ErrorToString());
      		}
			$periodo->get_combo_all();
			$data["{cmb_periodos}"] = array("elemento"  => "combo", 
										   "datos"     => $periodo->rows,
										   "options"   => array("name"=>"periodo_select","id"=>"periodo_select","class"=>"form-control","required"=>"required","onchange"=>"change_periodo('".$diccionario['rutas_head']['ruta_html']."/general/controller.php')","style"=>"margin-top:7px"),
										   "selected"  => $_SESSION['peri_codi']);
      		retornar_vista(VIEW_GET_ALL, $data);
            break;
        case GET_ALL_DATA:
            $usuario->get_all();
			if(count($usuario->rows)>0)
			{	
				global $diccionario;
				$opciones["Editar"] = "<span onclick='carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/usuario/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
				$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/usuario/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
				$data['{tabla}']= array("elemento"=>"tabla",
								  "clase"=>"display datatable",
								  "id"=>"tbl_usuarios",
								  "datos"=>$usuario->rows,
								  "encabezado" => array("Usuario",
														"Nombres",
														"Apellidos",
														"Correo",
														"Rol",
														"Estado",
														"Opciones"),
														"options"=>array($opciones),
														"campo"=>"usua_codigo");
				$data['mensaje'] = "Listado de usuarios:";
      		}
			else
			{	
				$data = array('mensaje'=>$usuario->mensaje.$usuario->ErrorToString());
      		}
            retornar_result($data);
            break;
        case VIEW_SET:
			$rol->get_all_roles();
            $data['{cmb_roles_add}'] = array("elemento"  => "combo", 
                                                       "datos"     => $rol->rows,
                                                       "options"   => array("name"=>"cmb_roles_add","id"=>"cmb_roles_add","class"=>"form-control","required"=>"required"),
                                                       "selected"  => 0);
            retornar_formulario(VIEW_SET, $data);
            break;
        case SET:
            $user_data['usua_usuaingreso'] = $_SESSION['usua_codigo'];
            $usuario->set($user_data);
            break;  
        case GET:
            $usuario->get($user_data['codigo']);
            $data = array('usuario_username'=>$user_data['codigo'],
                          'usuario_nombres'=>$usuario->usua_nombres,
            			  'usuario_apellidos'=>$usuario->usua_apellidos,
            			  'usuario_correo'=>$usuario->usua_correo);
			$rol->get_all_roles();
			$data['{cmb_roles_mod}'] = array("elemento"  => "combo", 
                                                       "datos"     => $rol->rows,
                                                       "options"   => array("name"=>"cmb_roles_mod","id"=>"cmb_roles_mod","class"=>"form-control","required"=>"required"),
                                                       "selected"  => $usuario->rol_codigo);
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
        	$user_data['usua_usuaingreso'] = $_SESSION['usua_codigo'];
            $usuario->delete($user_data);
            break;
        case EDIT:
        	$user_data['usua_usuaingreso'] = $_SESSION['usua_codigo'];
            $usuario->edit($user_data);
          break;
		case CHECK_USERNAME:
			global $diccionario;
			$usuario->check_username($user_data['username']);
			if (count($usuario->rows)>1)
			{	$existe = "has-error";
			}
			else
			{
				$existe = "has-success";
			}
			$data=array($existe);
			retornar_result($data);
			break;
			
        default :
        	break;
    }
}

handler();
?>