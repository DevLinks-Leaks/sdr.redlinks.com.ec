<?php
session_start();
require_once('../../core/controllerBase.php');
require_once('../periodo/model.php');
require_once('../adminPeriodos/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {
	require('/../../core/rutas.php');
	
    if (!isset($_POST['event']))
	{	if(!isset($_GET['event']))
		{	if ($_SESSION['rol_descripcion'] == 'empleado' )
				$event = INDEX_EMPLOYEE;
			else
				$event = INDEX;
		}
		else
		{	$event =$_GET['event'];
		}
	}
	else
	{	$event =$_POST['event'];
	}
	
    $uri = $_SERVER['REQUEST_URI'];
    $peticiones = array(MAIN, VIEW_MAIN,PASS_CHANGED,PRINTREP_DEUDORES,PRINTREPVISOR,VIEW_CONFIG_SIS);
	
    foreach ($peticiones as $peticion)
	{	$uri_peticion = MODULO.$peticion.'/';
        if( strpos($uri, $uri_peticion) == true )
		{	$event = $peticion;
        }
    }
    $gene_data = helper_data();	//variables que llegan por post desde el javascript
	$user_data = get_frontData(); //variables que llegan por post desde el javascript
	$periodo = get_mainObject('Periodo');
	$periodo = get_mainObject('Periodo');
	$general = set_obj();
	
    switch ($event) 
	{	case INDEX:
			global $diccionario;
			if (!isset($_SESSION['IN']))
			{
				$general->login($user_data["username"],$user_data["password"]);
				array_pop($general->rows);
				if (count($general->rows)>0 && $general->rows[0]['usua_codigo'] != NULL)
				{	$_SESSION['IN']='OK';
					$_SESSION['usua_codigo']=$general->usua_codigo;
					$_SESSION['usua_nomb']=$general->usua_nombres;
					$_SESSION['usua_apel']=$general->usua_apellidos;
					$_SESSION['usua_correo']=$general->usua_correo;
					$_SESSION['rol_descripcion']=$general->rol_descripcion;
					$_SESSION['puntaje']=$general->puntaje_total;
					$_SESSION['ruta_documentos_requisitos'] = $ruta_documentos_requisitos;
					$_SESSION['ruta_documentos_sintesis'] = $ruta_documentos_sintesis;
					$periodo->get_periodo_activo();
					if (count($periodo->rows)>0)
					{	$_SESSION['peri_codi']=$periodo->peri_codigo;
						$_SESSION['peri_deta']=$periodo->peri_descripcion;
					}
					else
					{	$_SESSION['peri_codi']="0";
						$_SESSION['peri_deta']="No existe un periodo activo";
					}
					$data["usua_nomb"]			= $_SESSION['usua_nomb'];
					$data["usua_apel"]			= $_SESSION['usua_apel'];
					$data["usua_correo"]		= $_SESSION['usua_correo'];
					$data["rol_descripcion"]	= $_SESSION['rol_descripcion'];
					$periodo->get_combo_all();
					$data["{cmb_periodos}"] = array("elemento"  => "combo", 
												   "datos"     => $periodo->rows,
												   "options"   => array("name"=>"periodo_select","id"=>"periodo_select","class"=>"form-control","required"=>"required","onchange"=>"change_periodo('".$diccionario['rutas_head']['ruta_html']."/general/controller.php')","style"=>"margin-top:7px"),
												   "selected"  => $_SESSION['peri_codi']);
					$general->get_solicitudesIn_graphByLocation($_SESSION['peri_codi']);
					$data["{barras_solicitudes_por_sector}"] = array("elemento"  	=> "barChart", 
																	"datos"     	=> $general->rows,
																	"contenedor"	=> "bar_solicitudes_por_sector",
																	"label"	   		=>"Solicitudes por estado");
					$general->get_solicitudesIn_graphByState($_SESSION['peri_codi']);
					$data["{barras_solicitudes_por_estado}"] = array("elemento"  	=> "barChart", 
																	"datos"     	=> $general->rows,
																	"contenedor"	=> "bar_solicitudes_por_estado",
																	"label"	   		=>"Solicitudes por estado");
					$general->get_solicitudesIn_graphByAdvertising($_SESSION['peri_codi']);
						$data["{barras_solicitudes_por_publicidad}"] = array("elemento"  	=> "barChart", 
																		"datos"     	=> $general->rows,
																		"contenedor"	=> "bar_solicitudes_por_publicidad",
																		"label"	   		=>"Solicitudes por publicidad");
					$general->get_solicitudesIn_graphByCourse($_SESSION['peri_codi']);
					$data["{lineas_solicitudes_por_curso}"] = array("elemento"  	=> "lineChart", 
																	"datos"     	=> $general->rows,
																	"contenedor"	=> "line_solicitudes_por_curso",
																	"label"	   		=>"Solicitudes por curso");
					$general->get_solicitudesIn_graphByMonth($_SESSION['peri_codi']);
					$data["{pie_solicitudes_por_mes}"] = array("elemento"  	=> "pieChart", 
																	"datos"     	=> $general->rows,
																	"contenedor"	=> "pie_solicitudes_por_mes");
					$data['resultado']="¡Bienvenido!";
					retornar_vista_general(VIEW_HOME, $data);
				}
				else
				{	$_SESSION['IN']='KO';
					header("Location: http://".$domain."/salir.php");
				}
			}
			else
			{	if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";header("Location: http://".$domain."/salir.php");}
				else
				{
					$data["usua_nomb"]			= $_SESSION['usua_nomb'];
					$data["usua_apel"]			= $_SESSION['usua_apel'];
					$data["usua_correo"]		= $_SESSION['usua_correo'];
					$data["rol_descripcion"]	= $_SESSION['rol_descripcion'];
					$periodo->get_combo_all();
					$data["{cmb_periodos}"] = array("elemento"  => "combo", 
												   "datos"     => $periodo->rows,
												   "options"   => array("name"=>"periodo_select","id"=>"periodo_select","class"=>"form-control","required"=>"required","onchange"=>"change_periodo('".$diccionario['rutas_head']['ruta_html']."/general/controller.php')","style"=>"margin-top:7px"),
												   "selected"  => $_SESSION['peri_codi']);
					
					$tabla_meses.="<table id='tbl_meses' name='tbl_meses' class='table table-bordered table-hover'>
							<thead style='text-align:center'>
								<tr><th style='text-align:center'>Mes</th>
									<th style='text-align:center'>Puntajes</th>
								</tr>
							</thead>
							<tbody>";
					$mes=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
					$saldo = new Saldoafavor();
					$saldo->search_month( $_SESSION['peri_codi'] );
					$infogeneral = new Saldoafavor();
					$infogeneral->month_general_info( $_SESSION['peri_codi'] );
					$disabled = "";
					$mes_anterior_activo = 0;
					$peri_fechainicio = $infogeneral->rows[0]['peri_fechainicio'];
					$peri_fechafin = $infogeneral->rows[0]['peri_fechafin'];
					$offset = 0; //En caso de que la apertura del año sea despues de enero
					for( $i = 0; $i < $peri_fechafin; $i++ )
					{	if ( ( $i + 1 ) >= $peri_fechainicio )
						{   if( ( $i + 1 ) > date('m') )
								$disabled = ' disabled = "disabled" ';
							$tabla_meses.="<tr><td align='center'>".$mes[$i]."</td>
								<td align='center'><button ".$disabled." onclick='js_adminPeriodos_carga_meses_puntaje(".($i+1).",\"".$mes[$i]."\",\"".
										( ( ( $saldo->rows[($i-$offset)]['fecha_fin'] == NULL ) ) ? 'abierto' : 'cerrado' ).
										"\")' class='btn btn-info'".
										( ( $mes_anterior_activo > 0 ) ? ' disabled="disabled" ' : '' ).
										" onmouseover='$(this).tooltip(".'"show"'.")' title='Puntajes de ".$mes[$i]."' data-placement='left'>".
										"<span class='fa fa-bar-chart' ></span></button></td>";
							
							if ( $saldo->rows[($i-$offset)]['fecha_fin'] == NULL )
								$mes_anterior_activo++;
						}
						else
							$offset++;
					}
					$tabla_meses.="</tbody>
						</table>";
					
					$data['resultado'] = "Puntaje personal: " . $_SESSION['puntaje'] . '<br>';
					$data['resultado'].= $tabla_meses;
					
					retornar_vista_general(VIEW_HOME, $data);
				}
			}
		break;
		case INDEX_EMPLOYEE:
			global $diccionario;
			if (!isset($_SESSION['IN']))
			{
				$general->login2($user_data["username"],$user_data["password"]);
				array_pop($general->rows);
				if (count($general->rows)>0 && $general->rows[0]['usua_codigo'] != NULL)
				{	$_SESSION['IN']='OK';
					$_SESSION['usua_codigo']=$general->usua_codigo;
					$_SESSION['usua_nomb']=$general->usua_nombres;
					$_SESSION['usua_apel']=$general->usua_apellidos;
					$_SESSION['usua_correo']=$general->usua_correo;
					$_SESSION['rol_descripcion']=$general->rol_descripcion;
					$_SESSION['puntaje'] = $general->puntaje_total;
					$_SESSION['ruta_documentos_requisitos'] = $ruta_documentos_requisitos;
					$_SESSION['ruta_documentos_sintesis'] = $ruta_documentos_sintesis;
					$periodo->get_periodo_activo();
					if (count($periodo->rows)>0)
					{	$_SESSION['peri_codi']=$periodo->peri_codigo;
						$_SESSION['peri_deta']=$periodo->peri_descripcion;
					}
					else
					{	$_SESSION['peri_codi']="0";
						$_SESSION['peri_deta']="No existe un periodo activo";
					}
											
					$data["usua_nomb"]=$_SESSION['usua_nomb'];
					$data["usua_apel"]=$_SESSION['usua_apel'];
					$data["usua_correo"]=$_SESSION['usua_correo'];
					$data["rol_descripcion"]=$_SESSION['rol_descripcion'];
					$data["puntaje"]=$_SESSION['puntaje'];
					$periodo->get_combo_all();
					$data["{cmb_periodos}"] = array("elemento"  => "combo", 
												   "datos"     => $periodo->rows,
												   "options"   => array("name"=>"periodo_select","id"=>"periodo_select","class"=>"form-control","required"=>"required","onchange"=>"change_periodo('".$diccionario['rutas_head']['ruta_html']."/general/controller.php')","style"=>"margin-top:7px"),
												   "selected"  => $_SESSION['peri_codi']);
					
					$tabla_meses.="<table id='tbl_meses' name='tbl_meses' class='table table-bordered table-hover'>
							<thead style='text-align:center'>
								<tr><th style='text-align:center'>Mes</th>
									<th style='text-align:center'>Puntajes</th>
								</tr>
							</thead>
							<tbody>";
					$mes=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
					$saldo = new Saldoafavor();
					$saldo->search_month( $_SESSION['peri_codi'] );
					$infogeneral = new Saldoafavor();
					$infogeneral->month_general_info( $_SESSION['peri_codi'] );
					$disabled = "";
					$mes_anterior_activo = 0;
					$peri_fechainicio = $infogeneral->rows[0]['peri_fechainicio'];
					$peri_fechafin = $infogeneral->rows[0]['peri_fechafin'];
					$offset = 0; //En caso de que la apertura del año sea despues de enero
					for( $i = 0; $i < $peri_fechafin; $i++ )
					{	if ( ( $i + 1 ) >= $peri_fechainicio )
						{   if( ( $i + 1 ) > date('m') )
								$disabled = ' disabled = "disabled" ';
							$tabla_meses.="<tr><td align='center'>".$mes[$i]."</td>
								<td align='center'><button ".$disabled." onclick='js_adminPeriodos_carga_meses_puntaje(".($i+1).",\"".$mes[$i]."\",\"".
										( ( ( $saldo->rows[($i-$offset)]['fecha_fin'] == NULL ) ) ? 'abierto' : 'cerrado' ).
										"\")' class='btn btn-info'".
										( ( $mes_anterior_activo > 0 ) ? ' disabled="disabled" ' : '' ).
										" onmouseover='$(this).tooltip(".'"show"'.")' title='Puntajes de ".$mes[$i]."' data-placement='left'>".
										"<span class='fa fa-bar-chart' ></span></button></td>";
							
							if ( $saldo->rows[($i-$offset)]['fecha_fin'] == NULL )
								$mes_anterior_activo++;
						}
						else
							$offset++;
					}
					$tabla_meses.="</tbody>
						</table>";
					
					$data['resultado'] = "Puntaje personal: " . $_SESSION['puntaje'] . '<br>';
					$data['resultado'].= $tabla_meses;
					
					retornar_vista_general(VIEW_HOME, $data);
				}
				else
				{	$_SESSION['IN']='KO';
					header("Location: http://".$domain."/salir.php");
				}
			}
			else
			{	if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";header("Location: http://".$domain."/salir.php");}
				else
				{	
					$data["usua_nomb"]			= $_SESSION['usua_nomb'];
					$data["usua_apel"]			= $_SESSION['usua_apel'];
					$data["usua_correo"]		= $_SESSION['usua_correo'];
					$data["rol_descripcion"]	= $_SESSION['rol_descripcion'];
					$periodo->get_combo_all();
					$data["{cmb_periodos}"] = array("elemento"  => "combo", 
												   "datos"     => $periodo->rows,
												   "options"   => array("name"=>"periodo_select","id"=>"periodo_select","class"=>"form-control","required"=>"required","onchange"=>"change_periodo('".$diccionario['rutas_head']['ruta_html']."/general/controller.php')","style"=>"margin-top:7px"),
												   "selected"  => $_SESSION['peri_codi']);
					
					$tabla_meses.="<table id='tbl_meses' name='tbl_meses' class='table table-bordered table-hover'>
							<thead style='text-align:center'>
								<tr><th style='text-align:center'>Mes</th>
									<th style='text-align:center'>Puntajes</th>
								</tr>
							</thead>
							<tbody>";
					$mes=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
					$saldo = new Saldoafavor();
					$saldo->search_month( $_SESSION['peri_codi'] );
					$infogeneral = new Saldoafavor();
					$infogeneral->month_general_info( $_SESSION['peri_codi'] );
					$disabled = "";
					$mes_anterior_activo = 0;
					$peri_fechainicio = $infogeneral->rows[0]['peri_fechainicio'];
					$peri_fechafin = $infogeneral->rows[0]['peri_fechafin'];
					$offset = 0; //En caso de que la apertura del año sea despues de enero
					for( $i = 0; $i < $peri_fechafin; $i++ )
					{	if ( ( $i + 1 ) >= $peri_fechainicio )
						{   if( ( $i + 1 ) > date('m') )
								$disabled = ' disabled = "disabled" ';
							$tabla_meses.="<tr><td align='center'>".$mes[$i]."</td>
								<td align='center'><button ".$disabled." onclick='js_adminPeriodos_carga_meses_puntaje(".($i+1).",\"".$mes[$i]."\",\"".
										( ( ( $saldo->rows[($i-$offset)]['fecha_fin'] == NULL ) ) ? 'abierto' : 'cerrado' ).
										"\")' class='btn btn-info'".
										( ( $mes_anterior_activo > 0 ) ? ' disabled="disabled" ' : '' ).
										" onmouseover='$(this).tooltip(".'"show"'.")' title='Puntajes de ".$mes[$i]."' data-placement='left'>".
										"<span class='fa fa-bar-chart' ></span></button></td>";
							
							if ( $saldo->rows[($i-$offset)]['fecha_fin'] == NULL )
								$mes_anterior_activo++;
						}
						else
							$offset++;
					}
					$tabla_meses.="</tbody>
						</table>";
					
					$data['resultado'] = "Puntaje personal: " . $_SESSION['puntaje'] . '<br>';
					$data['resultado'].= $tabla_meses;
					
					retornar_vista_general(VIEW_HOME, $data);
				}
			}
		break;
		case CHANGE_PERIODO:
			$_SESSION['peri_codi']=$_POST['peri_codi'];
			$_SESSION['peri_deta']=$_POST['peri_deta'];
		break;
        default:
			$_SESSION['IN']="KO";
			$_SESSION['ERROR_MSG']="Por favor inicie sesión";
			header("Location:".$domain);
		break;
    }
}


function set_obj() {
    $obj = new General();
    return $obj;
}

function helper_data() {
    $gene_data = array();
    if($_POST) {
        if(array_key_exists('usua_codigo', $_POST)) { 
            $gene_data['usua_codigo'] = $_POST['usua_codigo']; 
        }
		if(array_key_exists('usua_clave', $_POST)) { 
            $gene_data['usua_clave'] = $_POST['usua_clave']; 
        }
    }
    return $gene_data;
}

handler();
?>