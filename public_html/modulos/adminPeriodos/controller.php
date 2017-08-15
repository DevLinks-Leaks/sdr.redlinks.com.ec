<?php
session_start();
require_once('../../core/controllerBase.php');
require_once('../general/model.php');
require_once('../periodo/model.php');
require_once('../interesado/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{   $saldo 		= get_mainObject('saldoaFavor');
	$settings	= get_mainObject('saldoaFavor');
	$reporte 	= get_mainObject('saldoaFavor');
	$periodo 	= get_mainObject('Periodo');
    $event 		= get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL,
									VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
									VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $saldo_data = get_frontData();    
    $permiso 	= get_mainObject('General');
	$fecha	 	= get_mainObject('General');
	$cliente 	= get_mainObject('General');
	$clientePDF = get_mainObject('Interesado');

	if (!isset($_POST['busq'])){$saldo_data['busq'] = "";}else{$saldo_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla= "banc_table";}else{$tabla=$_POST['tabla'];}
	
    switch ($event)
	{   case PRINTREPVISOR:
		 	echo '
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-deuda" src="'.$saldo_data['url'].'"></iframe>
				</div>';
			break;
		case VIEW_GET_ALL:
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
			$periodo->get_combo_all();
			$data["{cmb_periodos}"] = array("elemento"  => "combo", 
										   "datos"     => $periodo->rows,
										   "options"   => array("name"=>"periodo_select","id"=>"periodo_select","class"=>"form-control","required"=>"required","onchange"=>"change_periodo('".$diccionario['rutas_head']['ruta_html']."/general/controller.php')","style"=>"margin-top:7px"),
										   "selected"  => $_SESSION['peri_codi']);
			$tabla_meses.="<table id='tbl_meses' name='tbl_meses' class='table table-bordered table-hover'>
					<thead style='text-align:center'>
						<tr><th style='text-align:center'>Mes</th>
						    <th style='text-align:center'>Puntajes</th>
							<th style='text-align:center'>Abrir mes</th>
							<th style='text-align:center'>Cerrar mes</th>
						</tr>
					</thead>
					<tbody>";
			$mes=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
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
								"<span class='fa fa-bar-chart' ></span></button></td>
						<td align='center'><button ".$disabled." onclick='js_adminPeriodos_open(\"".$mes[$i]."\",".($i+1).")' class='btn btn-warning'".
								" data-toggle='modal' data-target='#modal_open' ".
								( ( !empty( $saldo->rows[($i-$offset)]['fecha_inicio'] ) || ( $mes_anterior_activo > 0 ) ) ? ' disabled="disabled" ' : '' ).
								" onmouseover='$(this).tooltip(".'"show"'.")' title='Abrir mes de ".$mes[$i]."' data-placement='left'>".
								"<span class='fa fa-unlock' ></span></button></td>
						<td align='center'><button ".$disabled." onclick='js_adminPeriodos_close(\"".$mes[$i]."\",".($i+1).")' class='btn btn-danger'".
								( ( ( $saldo->rows[($i-$offset)]['fecha_fin'] != NULL ) || ( $mes_anterior_activo > 0 ) ) ? ' disabled="disabled" ' : '' ).
								" onmouseover='$(this).tooltip(".'"show"'.")' title='Cerrar mes de ".$mes[$i]."' data-placement='left'>".
								"<span class='fa fa-lock' ></span></button></td></tr>";
					
					if ( $saldo->rows[($i-$offset)]['fecha_fin'] == NULL )
						$mes_anterior_activo++;
				}
				else
					$offset++;
			}
			$tabla_meses.="</tbody>
				</table>";
			$data['tabla'] = $tabla_meses;
			$data['periodo'] = $_SESSION['peri_deta'];
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		
		case GET_ALL_DATA:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
			if ( $_SESSION['rol_descripcion'] != 'empleado' )
			{
				$tabla_meses.="<table id='tbl_meses' name='tbl_meses' class='table table-bordered table-hover'>
						<thead style='text-align:center'>
							<tr><th style='text-align:center'>Mes</th>
								<th style='text-align:center'>Puntajes</th>
								<th style='text-align:center'>Abrir mes</th>
								<th style='text-align:center'>Cerrar mes</th>
							</tr>
						</thead>
						<tbody>";
				$mes=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
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
									"<span class='fa fa-bar-chart' ></span></button></td>
							<td align='center'><button ".$disabled." onclick='js_adminPeriodos_open(\"".$mes[$i]."\",".($i+1).")' class='btn btn-warning'".
									" data-toggle='modal' data-target='#modal_open' ".
									( ( !empty( $saldo->rows[($i-$offset)]['fecha_inicio'] ) || ( $mes_anterior_activo > 0 ) ) ? ' disabled="disabled" ' : '' ).
									" onmouseover='$(this).tooltip(".'"show"'.")' title='Abrir mes de ".$mes[$i]."' data-placement='left'>".
									"<span class='fa fa-unlock'></span></button></td>
							<td align='center'><button ".$disabled." onclick='js_adminPeriodos_close(\"".$mes[$i]."\",".($i+1).")' class='btn btn-danger'".
									( ( ( $saldo->rows[($i-$offset)]['fecha_fin'] != NULL ) || ( $mes_anterior_activo > 0 ) ) ? ' disabled="disabled" ' : '' ).
									" onmouseover='$(this).tooltip(".'"show"'.")' title='Cerrar mes de ".$mes[$i]."' data-placement='left'>".
									"<span class='fa fa-lock'></span></button></td></tr>";
						
						if ( $saldo->rows[($i-$offset)]['fecha_fin'] == NULL )
							$mes_anterior_activo++;
					}
					else
						$offset++;
				}
				$tabla_meses.="</tbody>
					</table>";
			}
			else
			{
				$tabla_meses.="<table id='tbl_meses' name='tbl_meses' class='table table-bordered table-hover'>
						<thead style='text-align:center'>
							<tr><th style='text-align:center'>Mes</th>
								<th style='text-align:center'>Puntajes</th>
							</tr>
						</thead>
						<tbody>";
				$mes=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
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
			}
			$data['tabla'] = $tabla_meses;
            retornar_result($data);
            break;
		case OPEN_MONTH:
			if ( empty( $_SESSION['peri_codi'] ) || empty( $_SESSION['usua_codigo'] ) )
				print_r("Problemas al identificar periodo activo. Por favor, vuelva a iniciar sesion.");
			else
				$saldo->open_month( $_SESSION['peri_codi'], $saldo_data['mes'], $saldo_data['puntaje'], $_SESSION['usua_codigo'] );
			print_r($saldo->mensaje);
			break;
		case CLOSE_MONTH:
			if ( empty( $_SESSION['peri_codi'] ) || empty( $_SESSION['usua_codigo'] ) )
				print_r("Problemas al identificar periodo activo. Por favor, vuelva a iniciar sesion.");
			else
				$saldo->close_month( $_SESSION['peri_codi'], $saldo_data['mes'], $_SESSION['usua_codigo'] );
			print_r($saldo->mensaje);
			break;
		case SET:
            $saldo->set($_SESSION['peri_codi'], $saldo_data['mes'], 
						$saldo_data['valor'], $_SESSION['usua_codigo'],
						$saldo_data['cabePun_codigo'], $saldo_data['observacion'], 
						$saldo_data['concepto'] );
            print_r($saldo->mensaje);
			break;
		case GET_ALL_DATA_PUNTAJE:
            $saldo->get_all( $_SESSION['peri_codi'], $saldo_data['mes'] );
			if(count($saldo->rows)>0)
			{   global $diccionario;
				
				if( ( $saldo_data['estado'] == 'abierto' )  && ( $_SESSION['rol_descripcion']!='empleado' ) )
				{   $opciones["Balance"] = "<div align='center'>
											<button onclick='js_saldoaFavor_balancear(".'"{codigo}"'.")' class='btn btn-default' aria-hidden='true' data-toggle='modal' data-target='#modal_balance' id='{codigo}_devolver' onmouseover='$(this).tooltip(".'"show"'.")' title='Balancear' data-placement='left'><span class='fa fa-balance-scale cursorlink' ></span></button>&nbsp;";
				}
				$opciones["Imprimir"] = "	<button onclick='js_saldoaFavor_rep_hist(".'"{codigo}"'.",".$saldo_data['mes'].")'  class='btn btn-default'  id='{codigo}_print' onmouseover='$(this).tooltip(".'"show"'.")' title='Historial'><span class=' fa fa-print cursorlink' style='color:#4285F4;'></span></button>
										</div>";
				/*<!--aria-hidden='true' data-toggle='modal' data-target='#modal_rep'-->*/
				$data['{tabla}']= array("elemento"=>"tabla_anidada",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$saldo->rows,
                                        "encabezado" => array(
											"<div style='font-size:12px'>Cod. cartera.</div>",
											"<div style='font-size:12px'>Código empleado</div>",
											"<div style='font-size:12px'>Empleado</div>",
											"<div style='font-size:12px'>Puntaje del mes</div>",
											"<div style='font-size:12px'>ultima modificación</div>",
											"<div style='font-size:12px'>Opciones</div>"),
                                        "options"=>array($opciones),
                                        "campo"=>"cabePun_codigo");
			}
			else
			{   $data = array('mensaje'=>$saldo->mensaje.$saldo->ErrorToString());
			}
            retornar_result($data);
            break;
		case GET_SAF_HIST:
            $saldo->get_saf_historico( $saldo_data['cabeSaf_codigo'] );
			if(count($saldo->rows)>0)
			{   global $diccionario;
				$opciones["nothing"]="";

				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>'safHistorico_table_'.$saldo_data['cabeSaf_codigo'],
                                        "datos"=>$saldo->rows,
                                        "encabezado" => array(
											"<div style='font-size:small;'>No.</div>",
											"<div style='font-size:small;'>Motivo</div>",
											"<div style='font-size:small;'>Movimiento</div>",
											"<div style='font-size:small;'>Puntos (+/-)</div>",
											"<div style='font-size:small;'>anterior</div>",
											"<div style='font-size:small;'>final</div>",
											"<div style='font-size:small;'>modificacion</div>",
											"<div style='font-size:small;'>Usuario</div>",
											"<div style='font-size:small;'>Observación</div>"),
                                        "campo"=>"codigo");
			}
			else
			{   $data = array('mensaje'=>$saldo->mensaje.$saldo->ErrorToString());
			}
            retornar_result($data);
            break;
		case GET_SAF_HIST_PDF:
			global $diccionario;
            $hoy = getdate();
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='Hist_puntaje.pdf'");
				
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Puntaje mensual");
			$pdf->SetSubject("Puntaje mensual");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 11, '', 'false');
			$clientePDF->get_byCabePun( $saldo_data['tdrgcd'] );
			$saldo->get_saf_historico( $saldo_data['tdrgcd'] );
			$tranx = $saldo->rows;
			$pdf->AddPage('L', 'A4');//P:Portrait, L=Landscape
			$html .= '<h3>Puntaje mensual de<br>'.$clientePDF->rows[0]['inte_primer_nombre'].' '.$clientePDF->rows[0]['inte_segundo_nombre'].' '.
						$clientePDF->rows[0]['inte_primer_apellido'].' '.$clientePDF->rows[0]['inte_segundo_apellido'].
						' <br><span style="font-size:small;"></span></h3> ';
			$html .='<table width="100%" cellspacing="0" cellpadding="2" border="0"><tr><td><h5>Fecha de impresi&oacute;n: '.
					$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. Usuario: '.$_SESSION['usua_codigo'].'.</h3></td>';
			$html .='<td align="right">'.$fecha->get_fecha_head_reportes().'</td></tr></table>';
			$html .= '<hr style="height:5px;border:none;color:#333;background-color:#333;"/>';									
			$html .='<table cellspacing="0" cellpadding="2" border="0">';
			$col=0;
			// Datos
			$saldo_total=0;
			
			// Print
			$html .= "<tr><td colspan=\"10\"></td></tr>";
			$html .= "<tr>";
			$html .= "<td align=\"center\"><font size=\"9\"><strong>No.</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"10\"><strong>Motivo</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"10\"><strong>Movimiento</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"10\"><strong>Puntos(+/-)</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"10\"><strong>anterior</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"10\"><strong>final</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"10\"><strong>modificacion</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"10\"><strong>Usuario</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"10\"><strong>Observación</strong></font></td>";
			$html .= "</tr>";
			$nivel='';
			for($i=0;$i<count($tranx)-1;$i++)
			{	$col=0;
				$html .= "<tr>";
				foreach($tranx[$i] as $valor)
				{	$col=$col+1;
					/*if( $col == 3 || $col == 4 || $col == 5 )
					{	$html .= "<td align=\"right\">".$valor."</font></td>";
					}
					else
					{   $html .= "<td ><font size=\"9\">".$valor."</font></td>";
					}*/
					$html .= "<td  align=\"center\"><font size=\"11\">".$valor."</font></td>";
				}
				$html .= "</tr>";
				
			}
			$html .= "<tr><td colspan=\"10\"><hr/></td></tr>";
			$html .= "</table>";
			
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Hist_puntaje.pdf', 'I');
            break;
		case VIEW_GET_CLIENT:
			# Presenta el modal de Busqueda del cliente
			$data = array('{tablaCliente}' => array("elemento"  => "tabla",
													"clase" 	=> "table table-striped table-hover",  
													"id"		=> "clientes_table",  
													"datos"     => array(),
													"encabezado"=> array("Codigo",
																		  "Identificacion",
																		  "Nombres"),
													"options"   => array(),
													"campo"  	=> ""));
		retornar_formulario(VIEW_GET_CLIENT, $data);
			break;
		case GET_CLIENT:
			# Consulta los clientes a traves de los filtros (nombres e identificacion) y devuelve la tabla con los resultados
			$cliente->get_clientes($saldo_data);
			$data = array('{tablaCliente}' => array("elemento"  => "tabla",
													"clase" 	=> "table table-striped table-hover",  
													"id"		=> "clientes_table",  
													"datos"     => $cliente->rows,
													"encabezado"=> array("Codigo",
																		  "Identificacion",
																		  "Nombres"),
													"options"   => array(),
													"campo"  	=> ""));
			retornar_result($data);
			break;
		case PRINT_PUNTAJES:
			$hoy = getdate();
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='Reporte_puntaje.pdf'");
				
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Reporte de puntajes general");
			$pdf->SetSubject("Reporte de puntajes general");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 9, '', 'false');
			
			$reporte->get_reporte_puntaje( $_SESSION['peri_codi'] );
			$tranx = $reporte->rows;
			$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
			$html .= '<h2>Reporte de puntaje general</h2> ';
			$html .='<table width="100%" cellspacing="0" cellpadding="2" border="0"><tr><td><h5>Fecha de impresi&oacute;n: '.
					$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. Usuario: '.$_SESSION['usua_codigo'].'.</h3></td>';
			$html .='<td align="right">'.$fecha->get_fecha_head_reportes().'</td></tr></table>';
			$html .= '<hr style="height:5px;border:none;color:#333;background-color:#333;"/>';									
			$html .='<table cellspacing="0" cellpadding="2" border="0">';
			$col=0;
			// Datos
			$saldo_total=0;
			
			// Print
			$html .= "<tr><td colspan=\"3\"></td></tr>";
			$html .= "<tr>";
			$html .= "<td><font size=\"11\"><strong>Código empleado</strong></font></td>";
			$html .= "<td ><font size=\"11\" ><strong>Nombre</strong></font></td>";
			$html .= "<td align=\"right\"><font size=\"11\"><strong>Puntuaci&oacute;n</strong></font></td>";
			$html .= "</tr>";
			$nivel='';
			for($i=0;$i<count($tranx)-1;$i++)
			{	
				$col=0;
				
				foreach($tranx[$i] as $valor)
				{	$col=$col+1;
					if($col==1)
					{
						if($valor!=$nivel)
						{	$html .= "<tr><td colspan=\"3\"><hr/></td></tr>";
							$html .= "<tr><td colspan=\"3\"><font size=\"10\">Mes: ".$valor."</font></td></tr>";
							$html .= "<tr><td colspan=\"3\"><hr/></td></tr>";
							$nivel=$valor;
							$html .= "<tr>";
						}else
						{	$html .= "<tr>";
						}
					}
					if ($col == 4 ) $html .= "<td align=\"right\"><font size=\"9\">".$valor."</font></td>";
					else if ($col!=1 ) $html .= "<td ><font size=\"9\">".$valor."</font></td>";
				}
				$html .= "</tr>";
				
			}
			$html .= "<tr><td colspan=\"3\"><hr/></td></tr>";
			/*$html .= "<tr>";
			$html .= "<td><font size=\"10\"><strong>Total</strong></font></td>";
			$html .= "<td></td>";
			$html .= "<td></td>";
			$html .= "</tr>";*/
			$html .= "</table>";
			
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Reporte_puntaje.pdf', 'I');
			
			break;
		default:
			echo "Resultado desconocido";
    }
}
handler();
?>