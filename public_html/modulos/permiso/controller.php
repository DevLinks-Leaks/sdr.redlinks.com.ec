<?php
session_start();
require_once('/../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('/../periodo/model.php');
require_once('/../rol/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{	require('/../../core/rutas.php');
	$rol = get_mainObject('Rol');
	$permiso = get_mainObject('Permiso');
	$periodo = get_mainObject('Periodo');
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
			global $diccionario;
			$rol->get_all_roles();
            $data['{cmb_roles}'] = array("elemento"  => "combo", 
                                                       "datos"     => $rol->rows,
                                                       "options"   => array("name"=>"cmb_roles","id"=>"cmb_roles","class"=>"form-control","required"=>"required","onchange"=>"carga_rol_permisos(this.value,'permisos','".$diccionario['rutas_head']['ruta_html']."/permiso/controller.php')"),
                                                       "selected"  => 0);
			$periodo->get_periodos_activos();
			$data["{cmb_periodos}"] = array("elemento"  => "combo", 
										   "datos"     => $periodo->rows,
										   "options"   => array("name"=>"periodo_select","id"=>"periodo_select","class"=>"form-control","required"=>"required","onchange"=>"change_periodo('".$diccionario['rutas_head']['ruta_html']."/general/controller.php')","style"=>"margin-top:7px"),
										   "selected"  => $_SESSION['peri_codi']);
      		retornar_vista(VIEW_GET_ALL, $data);
            break;
        case GET_ALL_DATA:
            $permiso->get_all($user_data["rol_codigo"]);
			global $diccionario;
      		if(count($permiso->rows)>0)
			{	global $diccionario;
				$tabla ="<table class='display datatable' id='tbl_permisos'>";
				$tabla.="<thead>";
				$tabla.="<tr>";
				$tabla.="<th style='text-align:center' width='10%'>Código</th>";
				$tabla.="<th style='text-align:center' width='80%'>Permiso</th>";
				$tabla.="<th style='text-align:center'>Permitir</th>";
				$tabla.="</tr>";
				$tabla.="</thead>";
				$tabla.="<tbody>";
				array_pop($permiso->rows);
				foreach ($permiso->rows as $row)
				{	$tabla .= "<tr>";
					$tabla .= "<td>";
					$tabla .= $row["perm_codigo"];
					$tabla .= "</td>";
					$tabla .= "<td>";
					$tabla .= $row["perm_descripcion"];
					$tabla .= "</td>";
					$tabla .= "<td align='center'>";
					$tabla .= "<input type='checkbox' onclick='insertar_rol_permisos(this.value,\"permisos\",\"".$diccionario['rutas_head']['ruta_html']."/permiso/controller.php\");' ".($row['rol_perm_estado']=='A'?'checked':'')."/>";
					$tabla .= "</td>";
					$$tabla.="</tr>";
				}
				$tabla.="</tbody>";
				$tabla.="</table>";
				$data["permisos"]=$tabla;
				$data['mensaje'] = "Listado de permisos:";
      		}
			else
			{	$data = array('mensaje'=>$permiso->mensaje.$permiso->ErrorToString());
      		}
            retornar_result($data);
            break;
        case VIEW_SET:
            $data = array ();
            retornar_formulario(VIEW_SET, $data);
            break;
        case SET:
            $user_data['usua_codigo'] = 'SYSTEM';
            $rol->set($user_data);
            break;  
        case GET:
            $rol->get($user_data['codigo']);
            $data = array('rol_codigo'=>$user_data['codigo'],
                          'rol_descripcion'=>$rol->rol_descripcion);
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $rol->delete($user_data['codigo']);
            break;
        case EDIT:
            $rol->edit($user_data);
          break;
        default :
        	break;
    }
}

handler();
?>