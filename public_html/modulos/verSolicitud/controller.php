<?php
session_start();
require_once('../../core/controllerBase.php');
require_once('../general/model.php');
require_once('../catalogo/model.php');
require_once('../periodo/model.php');
require_once('constants.php');
require_once('model.php');
require_once('../colegio/model.php');
require_once('../profesion/model.php');
require_once('../region/model.php');
require_once('view.php');
require_once('../../core/funciones.php');
//require_once('/../../includes/tcpdf/tcpdf.php');

function handler() {
	$solicitud 		= get_mainObject('Solicitud');
	$catalogo		= get_mainObject('Catalogo'); //estado civil, relación (padre, madre, etc.)
	$event 			= get_actualEvents(array(VIEW_GET_ALL, VIEW_SET, VIEW_SET_HOME), VIEW_GET_ALL);
	$user_data		= get_frontData();
	$fecha			= get_mainObject('General');
	$cursos 		= get_mainObject('Solicitud');
	$profesion 		= get_mainObject('Profesion');
	$pais 			= get_mainObject('Region');
	$provincia 		= get_mainObject('Region');
	$ciudad 		= get_mainObject('Region');
	$colegio		= get_mainObject('Colegio');
	$periodo 		= get_mainObject('Periodo');
  //$permiso = get_mainObject('General');
  
	if (!isset($_POST['busq'])){ $user_data['busq'] = ""; }else{ $user_data['busq'] = $_POST['busq']; }
	if (!isset($_POST['tabla'])){ $tabla = "tbl_solicitud"; }else{ $tabla = $_POST['tabla']; }

    switch ($event)
	{   case VIEW_GET_ALL:
			global $diccionario;
			if (isset($_SESSION['IN']))
			{	if($_SESSION['IN']!="OK")
				{	$_SESSION['IN']="KO";
					header("Location: http://".$domain."/admisiones_americano/salir.php");
				}
			}
			else
			{	header("Location: http://".$domain."/admisiones_americano");
			}
			if( empty( $user_data['soli_estado'] ) )
				$soli_estado = 'ENVIADA';
			else if( $user_data['soli_estado'] == 'MANT' )
				$soli_estado = '';
			else
				$soli_estado = $user_data['soli_estado'];
			$solicitud->get_solicitudes( $soli_estado, 'zzz', 'zzz', '0', 'zzz', 'zzz',-1, $_SESSION['peri_codi'] );
            if(count($solicitud->rows)>0)
			{	$data['tabla'] = construct_table_solicitud( $tabla, $solicitud, $soli_estado );
                $data['mensaje'] = "Bandeja de solicitudes";
				$data['soli_estado'] = $soli_estado;
            }
			else
			{   $data = array('mensaje'=>$usuario->mensaje.$usuario->ErrorToString());
            }
			$cursos->get_Cursos( );//$user_data['nivel_economico'] debe traer el nivel economico según lo solicitado. EDUCALINKS PENDIENTE
			$data['{cmb_s_curso_aplica}'] = array("elemento"  => 	"combo", 
												"datos"     => 	$cursos->rows, 
												"options"   => 	array(	"name"		=>"cmb_s_curso_aplica",
																		"id"		=>"cmb_s_curso_aplica",
																		"class"		=>"form-control input-sm"),
												"selected"  => 	$curso);
										
			$periodo->get_combo_all();
			$data["{cmb_periodos}"] = array("elemento"  => "combo", 
										   "datos"     => $periodo->rows,
										   "options"   => array("name"=>"periodo_select","id"=>"periodo_select","class"=>"form-control","required"=>"required","onchange"=>"change_periodo('".$diccionario['rutas_head']['ruta_html']."/general/controller.php')","style"=>"margin-top:7px"),
										   "selected"  => $_SESSION['peri_codi']);
            retornar_vista(VIEW_GET_ALL, $data);
			break;
		case GET_ALL:
			if( empty( $user_data['soli_estado'] ) )
				$soli_estado = '';
			else if( $user_data['soli_estado'] == 'MANT' )
				$soli_estado = '';
			else 
				$soli_estado = $user_data['soli_estado'];
			
			$soli_codi = $user_data['soli_codi'];
			$id_repr_acad = $user_data['id_repr_acad'];
			$curso_aplicado = $user_data['curso_aplicado'];
			$fini_ingreso = $user_data['fini_ingreso'];
			$ffin_ingreso = $user_data['ffin_ingreso'];
			$num_intento = $user_data['num_intento'];
			$peri_codi = $_SESSION['peri_codi'];
			
			$solicitud->get_solicitudes($soli_estado, 	$soli_codi, 	$id_repr_acad, 	$curso_aplicado, 
										$fini_ingreso, 	$ffin_ingreso, 	$num_intento, 	$peri_codi );
			
            if(count($solicitud->rows)>0)
			{	$data['tabla'] = construct_table_solicitud( $tabla, $solicitud, $soli_estado );
            }
			else
			{   $data = array('mensaje'=>$usuario->mensaje.$usuario->ErrorToString().$solicitud->error['mySQLmensaje']);
            }
            retornar_result( $data );
			break;
		case PRINT_DOCU_PDTES_EXCEL:
			if( empty( $user_data['hd_main_soli_estado'] ) )
				$soli_estado = 'ENVIADA';
			else
				$soli_estado = $user_data['hd_main_soli_estado'];
			
			/*if( empty( $user_data['soli_estado'] ) )
				$soli_estado = '';
			else if( $user_data['soli_estado'] == 'MANT' )
				$soli_estado = '';
			else 
				$soli_estado = $user_data['soli_estado'];*/
			
			$soli_codi = $user_data['soli_codi'];
			$id_repr_acad = $user_data['id_repr_acad'];
			$curso_aplicado = $user_data['curso_aplicado'];
			$fini_ingreso = $user_data['fini_ingreso'];
			$ffin_ingreso = $user_data['ffin_ingreso'];
			$num_intento = $user_data['num_intento'];
			$peri_codi = $_SESSION['peri_codi'];
			
			/////////////////
			require_once('../../includes/PHPExcel/Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
			->setCreator( 'Redlinks' )
			->setLastModifiedBy( 'Redlinks' )
			->setTitle("Solicitudes de pre-admisión")
			->setSubject("Reporte de documentos entregados por los postulantes")
			->setDescription("Reporte de documentos entregados por los postulantes.");
			
			//Escala de impresión
			$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(55);
			//Horizontal
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			
			//Márgenes
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.25);
			
			//ESPACIO AMPLIO PARA CABECERAS
			$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
			$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			//CONTENIDO DEL ARCHIVO
			//IMPRIMIENDO CABECERAS
			$cabecera = array();
			$cabecera[]= 'SOLICITUD';
			$cabecera[]= 'NO. POSTULANTE';
			$cabecera[]= 'NOMBRE POSTULANTE';
			$solicitud->get_documentosPdtes_cabecera( $peri_codi );
			foreach( $solicitud->rows as $documento )
			{   if ( !empty($documento) )
					$cabecera[] = $documento['docu_descr'];
			}
			$cabecera[]= 'CURSO APLICADO';
			$cabecera[]= 'ESTADO';
			$i_cabe=0;//Contador de cabeceras
			$column = 'A';
			foreach($cabecera as $head)
			{	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i_cabe, 1, $head);
				$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(25);
				$i_cabe=$i_cabe+1;
				$column++;
			}
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$column.'1')->getFont()->setBold(true);
			$solicitud->get_documentosPdtes($soli_estado, 	$soli_codi, 	$id_repr_acad, 	$curso_aplicado, 
											$fini_ingreso, 	$ffin_ingreso, 	$num_intento, 	$peri_codi );
            $solicitudes=$solicitud->rows;
			$i_deta_fila=2;
			$latestBLColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
			$column = 'A';
			$row = 1;
			for ($column = 'A'; $column != $latestBLColumn; $column++)
			{	$objPHPExcel->getActiveSheet()->getStyle($column.$row)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			}
			foreach ($solicitudes as $registro)
			{	$i_deta_col=0;
			  	foreach ($registro as $campo =>$valor )
				{	$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($i_deta_col, $i_deta_fila, $valor);       
					$i_deta_col=$i_deta_col+1;
				}
				$i_deta_fila=$i_deta_fila+1;
			}
			
			$objPHPExcel->getActiveSheet()->setTitle('BandejaAdmisiones');
			$objPHPExcel->setActiveSheetIndex(0);
			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte_bandeja_admisiones.xlsx"');
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
			break;
		case PRINT_EXCEL:
			if( empty( $user_data['hd_main_soli_estado'] ) )
				$soli_estado = 'zzz'; //$soli_estado = 'ENVIADA';
			else
				$soli_estado = $user_data['hd_main_soli_estado'];
			
			$soli_codi = $user_data['txt_s_id_solicitud'];
			$id_repr_acad = $user_data['txt_s_id_repr'];
			$curso_aplicado = $user_data['cmb_s_curso_aplica'];
			$fini_ingreso = $user_data['txt_s_fecha_ini'];
			$ffin_ingreso = $user_data['txt_s_fecha_fin'];
			$num_intento = $user_data['txt_s_num_intentos'];
			$peri_codi = $_SESSION['peri_codi'];
			
			require_once('../../includes/PHPExcel/Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
			->setCreator( 'Redlinks' )
			->setLastModifiedBy( 'Redlinks' )
			->setTitle("Solicitudes de pre-admisión")
			->setSubject("Archivo de solicitudes de admisiones")
			->setDescription("Archivo de solicitudes de admisiones.");
			
			//Escala de impresión
			$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(55);
			//Horizontal
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			
			//Márgenes
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.25);
			
			//ESPACIO AMPLIO PARA CABECERAS
			$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
			$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			//CONTENIDO DEL ARCHIVO
			//IMPRIMIENDO CABECERAS
			$cabeceras = 'Solicitud,Código Persona,Código Periodo,Cédula Representante,Nombre Representante,Nombre Postulante,Fecha de nacimiento,No. Reprobaciones,Curso,Fecha de envío solicitud,Estado solicitud';
			$cabecera = explode( ",", $cabeceras );
			$i_cabe=0;//Contador de cabeceras
			$column = 'A';
			foreach($cabecera as $head)
			{	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i_cabe, 1, $head);
				$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(25);
				$i_cabe=$i_cabe+1;
				$column++;
			}
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$column.'1')->getFont()->setBold(true);
			$solicitud->get_solicitudes($soli_estado, 	$soli_codi, 	$id_repr_acad, 	$curso_aplicado, 
										$fini_ingreso, 	$ffin_ingreso, 	$num_intento, 	$peri_codi );
            $solicitudes=$solicitud->rows;
			$i_deta_fila=2;
			$latestBLColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
			$column = 'A';
			$row = 1;
			for ($column = 'A'; $column != $latestBLColumn; $column++)
			{	$objPHPExcel->getActiveSheet()->getStyle($column.$row)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			}
			foreach ($solicitudes as $registro)
			{	$i_deta_col=0;
			  	foreach ($registro as $campo =>$valor )
				{	$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($i_deta_col, $i_deta_fila, $valor);       
					$i_deta_col=$i_deta_col+1;
				}
				$i_deta_fila=$i_deta_fila+1;
			}
			
			$objPHPExcel->getActiveSheet()->setTitle('BandejaAdmisiones');
			$objPHPExcel->setActiveSheetIndex(0);
			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte_bandeja_admisiones.xlsx"');
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
			break;
		case DELETE_SOLICITUD:
			$resultado = $solicitud->delete_solicitud_maint($user_data['soli_codi'],
															$_SERVER['HTTP_X_FORWARDED_FOR'],
															$_SERVER['REMOTE_ADDR'] );
			echo $resultado->mensaje;
			break;
		case SET_OBSERVACION:
			$resultado = $solicitud->set_observacion( $user_data['id_solicitud'], $user_data['observacion'] );
			echo $resultado->mensaje;
			break;
		case GET_OBSERVACION:
			$solicitud->get_observacion( $user_data['id_solicitud'] );
			if( ( count( $solicitud->rows )-1 )>0 )
			{	$c = 0;
				while( $c < ( count( $solicitud->rows )-1 ) )
				{   $html .= $solicitud->rows[$c]['soli_observacion'] ;
					$c++;
				}
			}
			echo $html;
			break;
		case SET_ESTADO_MAINT:
			$resultado = $solicitud->set_solicitud_estado_maint($user_data['soli_codi'],
																$user_data['soli_estado'],
																$_SERVER['HTTP_X_FORWARDED_FOR'],
																$_SERVER['REMOTE_ADDR'] );
			echo $resultado->mensaje;
			break;
		case SET_ESTADO:
			$mail_para = $detail_para = "";
			$resultado_ingreso_solicitud = $solicitud->set_solicitud_estado($user_data['soli_codi'],
																			$user_data['soli_estado'],
																			$user_data['soli_observacion'],
																			$_SERVER['HTTP_X_FORWARDED_FOR'],
																			$_SERVER['REMOTE_ADDR'] );
			$data = array("MENSAJE"=>$resultado_ingreso_solicitud->mensaje,
						  "ID_SOLICITUD"=> $resultado_ingreso_solicitud->id_solicitud_out,
						  "ESTADO"	=> $resultado_ingreso_solicitud->per_codi_out);
		   if ( strlen( $resultado_ingreso_solicitud->mensaje ) > 0 )
			{   if( $user_data['enviar_mail'] == 'true' || $user_data['enviar_mail'] == 1 )
				{   $solicitud->get_solicitud_repr_consulta( $user_data['per_codi'] );
					if( ( count( $solicitud->rows )-1 )>0 )
					{	$c = 0;
						while( $c < ( count( $solicitud->rows )-1 ) )
						{   if ( ( $solicitud->rows[$c]['per_rel_repr_acad'] == 'S' ) )
							{	//$mail_para = $solicitud->rows[$c]['empr_mail'];
								$mail_para = $solicitud->rows[$c]['per_email_personal'];
								$detail_para = 	$solicitud->rows[$c]['per_nomb'] . ' ' . $solicitud->rows[$c]['per_nomb_seg'] . ' ' . 
												$solicitud->rows[$c]['per_apel'] . ' ' . $solicitud->rows[$c]['per_apel_mat'];								
								//$mail_para = 'markdan2091@hotmail.com';
								//$detail_para = 'Marcos Daniel Alvear';
							}
							$c++;
						}
						require '../../includes/mailer/PHPMailer/PHPMailerAutoload.php';
						$mail = new PHPMailer(true);                                  // the true param means it will throw exceptions on errors, which we need to catch
						$mail->isSMTP();   
						// Activamos / Desactivamos el "debug" de SMTP 
						// 0 = Apagado 
						// 1 = Mensaje de Cliente 
						// 2 = Mensaje de Cliente y Servidor 
						$mail->SMTPDebug = 0; 

						// Log del debug SMTP en formato HTML 
						$mail->Debugoutput = 'html';

						// telling the class to use SMTP transport
						$mail->Host = 'localhost';                    			// Specify main and backup SMTP servers
						$mail->SMTPAuth = true;                                      // Enable SMTP authentication
						$mail->Username = 'admisiones@colegioamericano.edu.ec';    // SMTP username
						$mail->Password = 'iridium123';                            // SMTP password
						$mail->SMTPSecure = 'ssl';                                    // Enable TLS encryption, `ssl` also accepted
						$mail->Port = 465;
						
						$mail->AddAddress( $mail_para, $detail_para );
						$mail->AddAddress('admisiones@colegioamericano.edu.ec');
						$mail->SetFrom('no-responder@colegioamericano.edu.ec');
						$mail->Subject = 'Actualización de su estado de solicitud de pre-selección';
						$mail->AltBody = 'Para ver este correo, por favor use un visualizador de email compatible con HTML.'; 
						$body="<html><head><meta charset='UTF-8'><title></title></head><body>";
						
						$body .="<h1>Sistema de Admisiones</h1>";
						$body .="<p>Estimado ".$detail_para."</p>";
						$body .="<blockquote><b><i>".$user_data['soli_observacion']."</i></b></blockquote>";
						$body .="<p>ID de la solicitud: ".$user_data['soli_codi']." y el estado es: ".$user_data['soli_estado']."</p>";

						if( $user_data['soli_estado'] == 'FECHA ASIGNADA' )
						{   $solicitud_fecha = new Solicitud();
					        $solicitud_fecha->solicitud_fecha_examen_ver( $user_data['soli_codi'] );
							if( ( count( $solicitud_fecha->rows )-1 )>0 )
							{	$body.= "";
								$c=1;
								$tabla = array ();
								foreach ($solicitud_fecha->rows as $row_soli_fex)
								{   if( !empty( $row_soli_fex ) )
									{   if ( $row_soli_fex['soli_fex_actividad'] == "") 
										{	$tabla[]= "<td width='10%'>".$c.".</td><td>".$row_soli_fex['soli_fex_fecha_asignada']."</td><td>-No hay detalles-</td>";
										}
										else
										{	$tabla[]= "<td width='10%'>".$c.".</td><td>".$row_soli_fex['soli_fex_fecha_asignada']."</td><td> ".$row_soli_fex['soli_fex_actividad']."</td>";
										}
										$c++;
									}
								}
								$body.= "
											<div class='callout callout-success'>
												<b>Fechas de exámenes/activiades asignadas</b><br><br>".
												genera_tabla_por_columnas($tabla, 1, 0)."
											</div>";
							}
							else
							{   $body.= '
										<div class="callout callout-success">
											<h4><strong><li class="fa fa-exclamation"></li></strong></h4>
											No hay registro de fechas asignadas. Acérquese a administración, para averiguar más acerca de su fecha asignada.
										</div>';
							}
						}
						$body .="<p>Por favor, anotar la id de su solicitud. </p>";
						
						$body.="<p>Para acceder a revisar el estado de su solicitud, ingresar a ".
								"<a href='http://www.colegioamericano.edu.ec/admisiones/'>www.colegioamericano.edu.ec/admisiones/</a></p>";
						$body .="<p></p>";
						$body .="<p>Atentamente, </p>";
						$body .="<p>Preadmisión - Colegio Americano de Guayaquil</p>";
						$body.="</body></html>";
						$mail->MsgHTML($body);                                        // optional - MsgHTML will create an alternate automatically
						$mail->isHTML(true);                                          // Set email format to HTML
						$mail->CharSet = 'UTF-8';
						$mail->Send();
					}
				}
			}
			echo json_encode( $data, true );
			break;
		case SET_FECHA_ASIGN:
			$resultado_ingreso_solicitud = $solicitud->set_solicitud_fecha( $user_data['soli_codi'], 
																			"",
																			$user_data['soli_fex_fecha_asignada'], 
																			$user_data['soli_fex_actividad'],
																			$_SERVER['HTTP_X_FORWARDED_FOR'],
																			$_SERVER['REMOTE_ADDR'],
																			$user_data['cambiar_estado'] );
			$data = array("MENSAJE"=>$resultado_ingreso_solicitud->mensaje,
						  "ID_SOLICITUD"=> $resultado_ingreso_solicitud->id_solicitud_out,
						  "ESTADO"	=> $resultado_ingreso_solicitud->per_codi_out);
			echo json_encode( $data, true );
			break;
		case FECHA_EXAMEN_VER:
			global $diccionario;
			$solicitud->solicitud_fecha_examen_ver( $user_data['soli_codi'] );
			if( ( count( $solicitud->rows )-1 )>0 )
			{	$lista= "<b>Fechas de exámenes/activiades asignadas</b><br><br>".
						"<div style='background-color:#e5e5e5;height:300px;overflow-y:scroll;'>";
				$c=1;
				$tabla = array ();
				foreach ($solicitud->rows as $row)
				{   if( !empty( $row ) )
					{   $quitar= "<td width='10%'><span style='color:red;cursor:pointer;' class='fa fa-times' id='quitar_".$row['soli_fex_codi']."' ".
									" name='quitar_".$row['soli_fex_codi']."' ".
									" title='Quitar fecha' onclick=\"js_verSolicitud_fecha_examen_borrar( '".$row['soli_codi']."', '".$row['soli_fex_codi']."','modal_asign_fecha_bandeja', '".$diccionario['rutas_head']['ruta_html']."/verSolicitud/controller.php');\"></span></td>";
						if ( $row['soli_fex_actividad'] == "") 
						{	$tabla[]= "<td width='10%'>".$c.".</td><td>".$row['soli_fex_fecha_asignada']."</td><td>-No hay detalles-</td>".$quitar;
						}
						else
						{	$tabla[]= "<td width='10%'>".$c.".</td><td>".$row['soli_fex_fecha_asignada']."</td><td> ".$row['soli_fex_actividad']."</td>".$quitar;
						}
						$c++;
					}
				}
				$lista.= genera_tabla_por_columnas($tabla, 1, 0)."</div>";
			    print $lista;
			}
			else
			{   $data= '<div class="callout callout-info">
							<h4><strong><li class="fa fa-exclamation"></li></strong></h4>
							-No se encontraron fechas de ex&aacute;menes/actividades asignadas para este postulantes en el sistema-.
						</div>';
			    print $data;
			}
			break;
		case FECHA_EXAMEN_BORRAR:
			global $diccionario;
			$resultado = $solicitud->solicitud_fecha_examen_borrar( $user_data['soli_codi'],
																	$user_data['soli_fex_codi'],
																	$_SERVER['HTTP_X_FORWARDED_FOR'],
																	$_SERVER['REMOTE_ADDR'] );
			echo $resultado->mensaje;
			break;
		case PRINTREPVISOR:
			echo '
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-deuda" src="'.$user_data['url'].'"></iframe>
				</div>';
			break;
		case PRINTREP_OBS_PDF:
			global $diccionario;
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='Formulario.pdf'");
				
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("HISTORIAL DE OBSERVACIONES");
			$pdf->SetSubject("HISTORIAL DE OBSERVACIONES");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 8, '', 'false');
			$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
			$pdf->Image($diccionario['rutas_head']['ruta_imagenes'].'/logo_americano_large.jpg', 'C', 15, '', '', 'JPG', '', 'C', false, 300, 'C', false, false, 0, false, false, false);
			
			$html .='<table width="100%" cellspacing="0" cellpadding="2" border="0">
					 <tr><td style="text-align:center;"><h3>HISTORIAL DE OBSERVACIONES ('.$_GET['id'].')</h3></td></tr>';
			$html .='<tr><td style="text-align:center;"><h4>Per&iacute;odo '.$_SESSION['peri_deta'].'</h4></td></tr>';
			$html .= '<hr style="height:3px;border:none;color:#333;background-color:#333;"/>';									
			$solicitud->get_observaciones( $_GET['id'] );
			$html .='<table cellspacing="0" cellpadding="2" border="1">';
			if( ( count( $solicitud->rows )-1 )>0 )
			{	$c = 0;
				while( $c < ( count( $solicitud->rows )-1 ) )
				{   $html .='
					<tr>
						<td colspan="10"><b>Estado:</b> ' . $solicitud->rows[$c]['soli_estado'] . '</td>
						<td colspan="10"><b>Observacion:</b> ' . $solicitud->rows[$c]['soli_observacion'] . '</td>
						<td colspan="10"><b>Fecha:</b> ' . $solicitud->rows[$c]['soli_fecha_ingr'] . '</td>
					</tr>';
					$c++;
				}
			}
			$html .= "</table>";
			$html .= '<h3>OBSERVACIONES DE LA SOLICITUD</h3>';
			
			$solicitud->solicitud_ver_observacion($_GET['id']);
			$html .= '<p>'.$solicitud->rows[0]['soli_observacion'].'</p>';
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Reporte_observaciones.pdf', 'I');
			break;
		case PRINTREP_FORMULARIO_PDF:
			global $diccionario;
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='Formulario.pdf'");
				
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Formulario de pre-admisión");
			$pdf->SetSubject("Formulario de pre-admisión");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 8, '', 'false');
			$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
			//$pdf->Image($diccionario['rutas_head']['ruta_imagenes'].'/logo_americano_large.jpg', 'C', 15, '', '', 'JPG', '', 'C', false, 300, 'C', false, false, 0, false, false, false);
			
			$html .='<table width="100%" cellspacing="0" cellpadding="2" border="0">
					 <tr><td style="text-align:center;"><h3>SOLICITUD DE PREADMISIÓN</h3></td></tr>';
			$html .='<tr><td style="text-align:center;"><h4>Per&iacute;odo '.$_SESSION['peri_deta'].'</h4></td></tr>';
			$html .= '<hr style="height:3px;border:none;color:#333;background-color:#333;"/>';									
			$solicitud->get_solicitud_persona_consulta( $_GET['id'], $_GET['perc'] );
			$colegio_procedencia1 = $colegio_procedencia2 = $curso_aplica = $pais_nacionalidad = "";
			/* FORMATEA LAS RESPUESTAS */
			if( $solicitud->rows[0]['soli_relizo_proceso_previamente'] == true ) 
				$relizo_proceso_previamente = 'SI';
			else
				$relizo_proceso_previamente = 'NO';
			if( $solicitud->rows[0]['soli_ha_sido_alumno_antes'] == true )
				$checked_ha_sido_alumno_antes = 'SI';
			else
				$checked_ha_sido_alumno_antes = 'NO';
			/* /. FORMATEA LAS RESPUESTAS */
			if( empty($solicitud->rows[0]['soli_colegio_procedencia']) )
				$colegio_procedencia1 = "";
			else
				$colegio_procedencia1 = $solicitud->rows[0]['soli_colegio_procedencia'];
			if( empty($solicitud->rows[0]['colegio_descripcion']) )
				$colegio_procedencia2 = "";
			else
				$colegio_procedencia2 = $solicitud->rows[0]['colegio_descripcion'];
			if ( empty ( $pais->rows[0]['PaisNombre'] ) )
				$pais_nacionalidad = " -No indicó- ";
			else
				$pais_nacionalidad = utf8_encode( $pais->rows[0]['PaisNombre'] );
			
			if ( $solicitud->rows[0]['per_sector_residencia'] == 'NORTE' )
				$per_sector_residencia = "NORTE";
			if ( $solicitud->rows[0]['per_sector_residencia'] == 'SUR' )
				$per_sector_residencia = "SUR";
			if ( $solicitud->rows[0]['per_sector_residencia'] == 'ESTE' )
				$per_sector_residencia = "ESTE";
			if ( $solicitud->rows[0]['per_sector_residencia'] == 'OESTE' )
				$per_sector_residencia = "OESTE";
			if ( $solicitud->rows[0]['per_sector_residencia'] == '1' )
				$per_sector_residencia = "";
			if ( $solicitud->rows[0]['per_sector_residencia'] == '2' )
				$per_sector_residencia = "";
			if ( $solicitud->rows[0]['per_sector_residencia'] == '3' )
				$per_sector_residencia = "";
			if ( $solicitud->rows[0]['per_sector_residencia'] == '4' )
				$per_sector_residencia = "";
			if ( $solicitud->rows[0]['per_sector_residencia'] == '5' )
				$per_sector_residencia = "";
			if ( $solicitud->rows[0]['per_sector_residencia'] == '6' )
				$per_sector_residencia = "FUERA DEL PAÍS";
			$colegio->get_colegio( $solicitud->rows[0]['soli_colegio_ant_codi'] );
			$pais->get_Pais( $solicitud->rows[0]['per_pais_nacionalidad'] );
			$cursos->get_Curso( $solicitud->rows[0]['soli_curso_aplicado'] );
			if( empty($cursos->rows[0]['curs_deta']) )
				$curso_aplica = "-no indicó-";
			else
				$curso_aplica = utf8_encode( $cursos->rows[0]['curs_deta'] );
			$soli_foto = $foto = "";
			if( ( count( $solicitud->rows ) )>0 )
			{	if( $solicitud->rows[0]['soli_foto'] != "")
				{   $soli_foto = $directorio = '../../documentos/solicitudes_fotos/'.$user_data['id_solicitud'].'/'.$solicitud->rows[0]['soli_codi'].'/'.$solicitud->rows[0]['soli_foto'];
					if(file_exists($soli_foto))
					{   $foto = '<div><img src="'.utf8_encode($soli_foto).'" style="max-width:75%;max-height:100%;"></div>';
						if ( strtoupper ( substr( utf8_encode($soli_foto), -3 ) ) <> 'PNG' && strtoupper ( substr( utf8_encode($soli_foto), -3 ) ) <> 'JPG' && 
							strtoupper ( substr( utf8_encode($soli_foto), -4 ) ) <> 'PNEG' )
							$foto = '-SIN IMAGEN-';
					}
					else
						$foto = '-SIN IMAGEN-';
				}
				else
					$foto = ' FOTO ';
				$html .='<table cellspacing="0" cellpadding="2" border="1">';
				$html .='<tr><td colspan="10"><b>DATOS DEL POSTULANTE:</b></td>
							 <td colspan="2" rowspan="8" style="text-align:center;">'.$foto.'</td></tr>';
				$html .='<tr><td colspan="5"><b>APELLIDOS:</b> '.$solicitud->rows[0]['per_apel'] . ' ' . $solicitud->rows[0]['per_apel_mat'] .'</td>
							 <td colspan="5"><b>NOMBRES:</b> ' . $solicitud->rows[0]['per_nomb'] . ' ' . $solicitud->rows[0]['per_nomb_seg'] .'</td></tr>';
				$html .='<tr><td colspan="5"><b>DIRECCION:</b> '. $solicitud->rows[0]['per_dir_personal'] . '</td>
							 <td colspan="5"><b>TELEFONO:</b> ' . $solicitud->rows[0]['cont_det_numero'] . '</td></tr>';
				$html .='<tr><td colspan="5"><b>SECTOR:</b> '. $per_sector_residencia . '</td>
							 <td colspan="5"><b>SI ES FUERA DEL PAÍS:</b> ' . $solicitud->rows[0]['per_sector_otros'] . '</td></tr>';
				$html .='<tr><td colspan="5"><b>FECHA NACIMIENTO:</b> '.$solicitud->rows[0]['per_fecha_nac'] . '</td>
							 <td colspan="5"><b>LUGAR NACIMIENTO:</b> ' . $pais_nacionalidad . '</td></tr>';
				$html .='<tr><td colspan="5"><b>TIPO ID:</b> '.$solicitud->rows[0]['per_tipo_id'] . '</td>
							 <td colspan="5"><b>NÚMERO ID:</b> ' . $solicitud->rows[0]['per_id'] . '</td></tr>'; 
				$html .='<tr><td colspan="10"><b>CURSO AL QUE APLICA:</b> ' . $curso_aplica . '</td></tr>'; 
				$html .='<tr><td colspan="10"><b>COLEGIO DE PROCEDENCIA:</b> '.$colegio_procedencia1 . $colegio_procedencia2. '</td></tr>'; 
				$html .='<tr><td colspan="10"><b>DIRECCIÓN DEL COLEGIO DE PROCEDENCIA:</b> '.$solicitud->rows[0]['soli_colegio_direccion'] . '</td></tr>'; 
				$html .='<tr><td colspan="12"><b>No. DE HERMANOS (EDAD, ACTV. Y ESTUDIOS):</b> '.$solicitud->rows[0]['soli_num_hermanos'] . '</td></tr>'; 
				$html .='<tr><td colspan="12"><b>¿El postulante tiene hermanos en el Colegio?</b><br>'.$solicitud->rows[0]['soli_datos_hermanos_inscritos'] . '</td></tr>'; 
				$html .='<tr><td colspan="12"><b>¿Tiene algún familiar que sean estudiantes o trabajen en el Colegio Americano (especificar grado y parentesco)?</b><br>'.$solicitud->rows[0]['soli_datos_familiares_inscritos'] . '</td></tr>'; 
				$html .='<tr><td colspan="6"><b>¿Ha realizado antes el proceso de pre-admisión?</b> '. $relizo_proceso_previamente . '</td>
							 <td colspan="6"><b>Año en que aplicó:</b> ' . $solicitud->rows[0]['soli_anho_proceso_previo'] . '</td></tr>'; 
				$html .='<tr><td colspan="12"><b>¿Ha sido alumno del Colegio antes?</b> '.$checked_ha_sido_alumno_antes . '</td></tr>'; 
				$html .='<tr><td colspan="6"><b>¿Vive en casa propia/alquilada/otros?</b> '.$solicitud->rows[0]['per_vive_en_casa_propia'] . '</td>
							 <td colspan="6"><b>Tiempo de residencia (años):</b> ' . $solicitud->rows[0]['per_tiempo_de_recidencia'] . '</td></tr>';  
				$html .='<tr><td colspan="12"><b>¿Cómo se enteró del proceso de pre-admisión?</b> '. $solicitud->rows[0]['soli_como_se_entero_proceso_de_admision'] . '</td></tr>'; 
				$html .='<tr><td colspan="12"><b>RUC para la facturación</b> '. $solicitud->rows[0]['soli_ruc_facturacion'] . '</td></tr>'; 
				$html .= "</table>";
				/*-------------------------------------------------------------------------------------
					REPRESENTANTES
				  -------------------------------------------------------------------------------------*/
				$solicitud->get_solicitud_repr_consulta( $solicitud->rows[0]['per_codi'] );
				$repr_econ = $repr_acad = '';
				if( ( count( $solicitud->rows )-1 )>0 )
				{	$c = 0;
					while( $c < ( count( $solicitud->rows )-1 ) )
					{   
						if ( ( $solicitud->rows[$c]['per_rel_repr_finan'] == 'S' ) || ( $solicitud->rows[$c]['per_rel_repr_acad'] == 'S' )  
							|| ( $solicitud->rows[$c]['descripcion'] == 'PADRE' ) || ( $solicitud->rows[$c]['descripcion'] == 'MADRE' ) )
						{	
							if( $solicitud->rows[$c]['per_rel_repr_acad'] == 'S' ) $repr_acad = utf8_encode( $solicitud->rows[$c]['descripcion'] );
							if( $solicitud->rows[$c]['per_rel_repr_finan'] == 'S' ) $repr_econ = utf8_encode( $solicitud->rows[$c]['descripcion'] );
							$html .= "<br><br>";
							$html .='<table cellspacing="0" cellpadding="2" border="1">';
							$html .='<tr><td colspan="2"><b>DATOS DE EL/LA '. utf8_encode( $solicitud->rows[$c]['descripcion'] ) .':</b></td></tr>'; 
							$html.= construct_html_pdf_repr( $solicitud, $c );
							$html .= "</table>";
						}
						$c++;
					}
				}
				$html .= "<br><br>";
				$html .='<table cellspacing="0" cellpadding="2" border="1">';
				$html .='<tr><td colspan="2"><b>REPRESENTANTE ACADÉMICO:</b> '.$repr_acad.'</td></tr>';
				$html .='<tr><td colspan="2"><b>REPRESENTANTE ECONÓMICO:</b> '.$repr_econ.'</td></tr>';
				//$html .='<tr><td colspan="2"><b>FECHA DE ENVÍO DE LA SOLICITUD:</b> '.$repr_econ.'</td></tr>';
				$html .= "</table>";
			}
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Reporte.pdf', 'I');
			break;
		case PRINT_EXCEL_COMPLETO:
			if( empty( $user_data['hd_main_soli_estado'] ) )
				$soli_estado = 'zzz'; //$soli_estado = 'ENVIADA';
			else
				$soli_estado = $user_data['hd_main_soli_estado'];
			
			$soli_codi = $user_data['txt_s_id_solicitud'];
			$id_repr_acad = $user_data['txt_s_id_repr'];
			$curso_aplicado = $user_data['cmb_s_curso_aplica'];
			$fini_ingreso = $user_data['txt_s_fecha_ini'];
			$ffin_ingreso = $user_data['txt_s_fecha_fin'];
			$num_intento = $user_data['txt_s_num_intentos'];
			$peri_codi = $_SESSION['peri_codi'];
			
			require_once('../../includes/PHPExcel/Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
			->setCreator( 'Redlinks' )
			->setLastModifiedBy( 'Redlinks' )
			->setTitle("Solicitudes de pre-admisión")
			->setSubject("Archivo de solicitudes de admisiones")
			->setDescription("Archivo de solicitudes de admisiones.");
			
			//Escala de impresión
			$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(55);
			//Horizontal
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			
			//Márgenes
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.25);
			
			//ESPACIO AMPLIO PARA CABECERAS
			$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
			$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			//CONTENIDO DEL ARCHIVO
			//IMPRIMIENDO CABECERAS
			$cabecerax= 'CODIGO SOLICITUD,ESTADO,APELLIDOS,NOMBRES,DIRECCION,TELEFONO,FECHA NACIMIENTO,LUGAR NACIMIENTO,TIPO ID,NÚMERO ID,'.
						'CURSO AL QUE APLICA,COLEGIO DE PROCEDENCIA,DIRECCIÓN DEL COLEGIO DE PROCEDENCIA,'.
						'No. DE HERMANOS (EDAD y ACTV. Y ESTUDIOS),¿El postulante tiene hermanos en el Colegio?,'.
						'¿Ha realizado antes el proceso de pre-admisión?,Año en que aplicó,¿Ha sido alumno del Colegio antes?,'.
						'¿Vive en casa propia/alquilada/otros?,Tiempo de residencia (años),¿Cómo se enteró del proceso de pre-admisión?';
			$cabecera_repr =',PARENTESCO,ES REPR. ACAD.,ES REPR. ECON.,APELLIDOS,NOMBRES,TIPO ID,NÚMERO ID,FECHA DE NACIMIENTO,LUGAR NACIMIENTO,DIRECCION,TELEFONO,TÍTULO PROFESIONAL,E-MAIL,ESTADO CIVIL,'.
							'EMPRESA DONDE TRABAJA (RAZÓN SOCIAL),RUC,DIRECCION EMPRESA,TELEFONO EMPRESA,CARGO QUE DESEMPEÑA,INGRESOS MENSUALES,'.
							'¿HA TRABAJADO ANTES EN EL COLEGIO?,TIEMPO QUE TRABAJÓ, ES EX-ALUMNO,AÑO DE PROMOCIÓN';
			
			$cabeceras = $cabecerax;
			
			$solicitud_aux = new Solicitud();
			$solicitud_aux->get_max_parientes(  );
			for($aux_max=0; $aux_max < $solicitud_aux->rows[0]['max_repr']; $aux_max++)
				$cabeceras.= $cabecera_repr;
			$cabecera = explode( ",", $cabeceras );
			$i_cabe=0;//Contador de cabeceras
			$column = 'A';
			foreach($cabecera as $head)
			{	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i_cabe, 1, $head);
				$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(25);
				$i_cabe=$i_cabe+1;
				$column++;
			}
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$column.'1')->getFont()->setBold(true);
			$solicitud->get_listado_alumnos( $soli_estado, 	$peri_codi );
            $solicitudes=$solicitud->rows;
			
			$i_deta_fila=2;
			$latestBLColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
			$column = 'A';
			$row = 1;
			for ($column = 'A'; $column != $latestBLColumn; $column++)
			{	$objPHPExcel->getActiveSheet()->getStyle($column.$row)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			}
			//por cada registro...
			$c = 0;
			foreach ($solicitudes as $registro)
			{	//...una fila de detalles.
			
				/* FORMATEA LAS RESPUESTAS */
				if( $solicitud->rows[$c]['soli_relizo_proceso_previamente'] == true ) 
					$relizo_proceso_previamente = 'SI';
				else
					$relizo_proceso_previamente = 'NO';
				if( $solicitud->rows[$c]['soli_ha_sido_alumno_antes'] == true )
					$checked_ha_sido_alumno_antes = 'SI';
				else
					$checked_ha_sido_alumno_antes = 'NO';
				/* /. FORMATEA LAS RESPUESTAS */
				
				/*$colegio->get_colegio( $solicitud->rows[$c]['soli_colegio_ant_codi'] );
				$pais->get_Pais( $solicitud->rows[$c]['per_pais_nacionalidad'] );*/
				//$cursos->get_Curso( $solicitud->rows[$c]['soli_curso_aplicado'] );
				
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(0, $i_deta_fila, $solicitud->rows[$c]['soli_codi'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(1, $i_deta_fila, $solicitud->rows[$c]['soli_estado'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(2, $i_deta_fila, $solicitud->rows[$c]['per_apel'] . ' ' . $solicitud->rows[$c]['per_apel_mat'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(3, $i_deta_fila, $solicitud->rows[$c]['per_nomb'] . ' ' . $solicitud->rows[$c]['per_nomb_seg'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(4, $i_deta_fila, $solicitud->rows[$c]['per_dir_personal'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(5, $i_deta_fila, $solicitud->rows[$c]['cont_det_numero'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(6, $i_deta_fila, $solicitud->rows[$c]['per_fecha_nac'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(7, $i_deta_fila, $solicitud->rows[$c]['paisnombre'] );
				//$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(7, $i_deta_fila, $pais->rows[0]['PaisNombre']  );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(8, $i_deta_fila, $solicitud->rows[$c]['per_tipo_id'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(9, $i_deta_fila, $solicitud->rows[$c]['per_id'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(10, $i_deta_fila, utf8_encode($solicitud->rows[$c]['curs_detalle']) );
				//$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(10, $i_deta_fila, $cursos->rows[0]['curs_deta'] );
				//$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(11, $i_deta_fila, $solicitud->rows[$c]['soli_colegio_procedencia'] . $colegio->rows[0]['colegio_descripcion'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(11, $i_deta_fila, $solicitud->rows[$c]['colegio_descripcion'].' '.$solicitud->rows[$c]['soli_colegio_procedencia'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(12, $i_deta_fila, $solicitud->rows[$c]['soli_colegio_direccion'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(13, $i_deta_fila, $solicitud->rows[$c]['soli_num_hermanos'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(14, $i_deta_fila, $solicitud->rows[$c]['soli_datos_hermanos_inscritos'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(15, $i_deta_fila, $relizo_proceso_previamente );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(16, $i_deta_fila, $solicitud->rows[$c]['soli_anho_proceso_previo'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(17, $i_deta_fila, $checked_ha_sido_alumno_antes );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(18, $i_deta_fila, $solicitud->rows[$c]['per_vive_en_casa_propia'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(19, $i_deta_fila, $solicitud->rows[$c]['per_tiempo_de_recidencia'] );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(20, $i_deta_fila, $solicitud->rows[$c]['soli_como_se_entero_proceso_de_admision'] );
				$columna = 21;
				$solicitud_repr = new Solicitud();
				$solicitud_repr->get_solicitud_repr_consulta( $solicitud->rows[$c]['per_codi'] );
				$repr_econ = $repr_acad = '';
				if( ( count( $solicitud_repr->rows )-1 )>0 )
				{	$i = 0;
					while( $i < ( count( $solicitud_repr->rows )-1 ) )
					{   
						if ( ( $solicitud_repr->rows[$i]['per_rel_repr_finan'] == 'S' ) || ( $solicitud_repr->rows[$i]['per_rel_repr_acad'] == 'S' )  
							|| ( $solicitud_repr->rows[$i]['descripcion'] == 'PADRE' ) || ( $solicitud_repr->rows[$i]['descripcion'] == 'MADRE' ) )
						{	
							if( $solicitud_repr->rows[$i]['per_rel_repr_acad'] == 'S' ) $repr_acad = 'SI'; else $repr_acad = 'NO';
							if( $solicitud_repr->rows[$i]['per_rel_repr_finan'] == 'S' ) $repr_econ = 'SI'; else $repr_econ = 'NO';
							
							$html = $rango_trabajo = $v_estado_civil = '';
							$soli_reprInfo_es_extrabajador = $soli_reprInfo_es_exalumno = 'NO';
							
							/*$pais = new Region();
							$pais->get_Pais($solicitud_repr->rows[$i]['per_pais_nacionalidad']);
							
							$profesion = new Profesion();
							$profesion->get_Profesion($solicitud_repr->rows[$i]['per_profesion']);
							
							$estado_civil = new Catalogo();
							$estado_civil->get_all_sons_catalogo(1);*/
							
							/*$aux = 0;
							while( $aux < ( count( $estado_civil->rows )-1 ) )
							{	if( $estado_civil->rows[$aux]['codigo'] == $solicitud_repr->rows[$i]['per_estado_civil'] )
									$v_estado_civil = $estado_civil->rows[$aux]['descripcion'];
								$aux++;
							}*/
							if ( $solicitud_repr->rows[$i]['soli_reprInfo_es_extrabajador'] == 1 ) $soli_reprInfo_es_extrabajador = 'SI';
							if ( $solicitud_repr->rows[$i]['soli_reprInfo_es_exalumno'] == 1 ) $soli_reprInfo_es_exalumno = 'SI';
							if ( $soli_reprInfo_es_extrabajador == 'SI') $rango_trabajo = '<b>DESDE :</b> ' . $solicitud_repr->rows[$i]['soli_reprInfo_f_trabajo_desde'] . ' <b>HASTA :</b> '.$solicitud_repr->rows[$i]['soli_reprInfo_f_trabajo_hasta'];
							
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['descripcion'] );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $repr_acad );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $repr_econ );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['per_apel'] . ' ' . $solicitud_repr->rows[$i]['per_apel_mat']  );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['per_nomb'] . ' ' . $solicitud_repr->rows[$i]['per_nomb_seg'] );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['per_tipo_id'] );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['per_id'] );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['per_fecha_nac'] );
							$columna++;
							//$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $pais->rows[0]['PaisNombre'] );
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['PaisNombre'] );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['per_dir_personal'] );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['cont_det_numero'] );
							$columna++;
							//$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $profesion->rows[0]['profesion_detalle'] );
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['profesion'] );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['per_email_personal'] );
							$columna++;
							//$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $v_estado_civil );
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['est_civ_descripcion'] );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['empr_nomb'] );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['empr_ruc'] );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['empr_dir'] );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['empr_telf'] );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['empr_cargo'] );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['empr_ingreso_mensual'] );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $soli_reprInfo_es_extrabajador );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $rango_trabajo );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $soli_reprInfo_es_exalumno );
							$columna++;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($columna, $i_deta_fila, $solicitud_repr->rows[$i]['soli_reprInfo_anho_promocion'] );
							$columna++;
						}
						$i++;
					}
				}
				$i_deta_fila = $i_deta_fila + 1;
				$c++;
			}
			
			$objPHPExcel->getActiveSheet()->setTitle('BandejaAdmisiones');
			$objPHPExcel->setActiveSheetIndex(0);
			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte_bandeja_admisiones.xlsx"');
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
		break;
    }
}
handler();
function construct_html_pdf_repr( $solicitud, $c )
{   $html = $rango_trabajo = $v_estado_civil = $profesion_detalle = $pais_nacionalidad = '';
	$soli_reprInfo_es_extrabajador = $soli_reprInfo_es_exalumno = 'NO';
	
	$pais = new Region();
	$pais->get_Pais($solicitud->rows[$c]['per_pais_nacionalidad']);
	
	$profesion = new Profesion();
	$profesion->get_Profesion($solicitud->rows[$c]['per_profesion']);
	
	$estado_civil = new Catalogo();
	$estado_civil->get_all_sons_catalogo(1);
	
	$aux = 0;
	while( $aux < ( count( $estado_civil->rows )-1 ) )
	{	if( $estado_civil->rows[$aux]['codigo'] == $solicitud->rows[$c]['per_estado_civil'] )
			$v_estado_civil = utf8_encode( $estado_civil->rows[$aux]['descripcion'] );
		$aux++;
	}
	if ( $solicitud->rows[$c]['soli_reprInfo_es_extrabajador'] == 1 ) $soli_reprInfo_es_extrabajador = 'SI';
	if ( $solicitud->rows[$c]['soli_reprInfo_es_exalumno'] == 1 ) $soli_reprInfo_es_exalumno = 'SI';
	if ( $soli_reprInfo_es_extrabajador == 'SI') $rango_trabajo = '<b>DESDE :</b> ' . $solicitud->rows[$c]['soli_reprInfo_f_trabajo_desde'] . ' <b>HASTA :</b> '.$solicitud->rows[$c]['soli_reprInfo_f_trabajo_hasta'];
	
	if( empty( $profesion->rows[0]['profesion_detalle'] ) )
		$profesion_detalle = "-No seleccionó-";
	else
		$profesion_detalle = utf8_encode( $profesion->rows[0]['profesion_detalle'] );
	if ( empty ( $pais->rows[0]['PaisNombre'] ) )
		$pais_nacionalidad = " -No indicó- ";
	else
		$pais_nacionalidad = utf8_encode( $pais->rows[0]['PaisNombre'] );
	$html.='<tr><td><b>APELLIDOS:</b> '.$solicitud->rows[$c]['per_apel'] . ' ' . $solicitud->rows[$c]['per_apel_mat'] .'</td>
				<td><b>NOMBRES:</b> ' . $solicitud->rows[$c]['per_nomb'] . ' ' . $solicitud->rows[$c]['per_nomb_seg'] .'</td></tr>';
	$html.='<tr><td><b>TIPO ID:</b> '.$solicitud->rows[$c]['per_tipo_id'] . '</td>
				<td><b>NÚMERO ID:</b> ' . $solicitud->rows[$c]['per_id'] . '</td></tr>'; 
	$html.='<tr><td><b>EDAD:</b> '.obtener_edad( $solicitud->rows[$c]['per_fecha_nac'] ) . '</td>
				<td><b>LUGAR NACIMIENTO:</b> ' . $pais_nacionalidad . '</td></tr>';
	
	$html.='<tr><td><b>DIRECCION:</b> '.$solicitud->rows[$c]['per_dir_personal'] . '</td>
				<td><b>TELEFONO:</b> ' . $solicitud->rows[$c]['cont_det_numero'] . '</td></tr>';
	$html.='<tr><td><b>TÍTULO PROFESIONAL:</b>'.$profesion_detalle.'</td>
				<td><b>E-MAIL:</b> ' . $solicitud->rows[$c]['per_email_personal'] . '</td></tr>'; 
	$html .='<tr><td colspan="2"><b>ESTADO CIVIL:</b> '. $v_estado_civil . '</td></tr>';
	
	$html.='<tr><td><b>EMPRESA DONDE TRABAJA (RAZÓN SOCIAL):</b> '.$solicitud->rows[$c]['empr_nomb'] . '</td>
				<td><b>RUC:</b> ' . $solicitud->rows[$c]['empr_ruc'] . '</td></tr>';
	$html.='<tr><td><b>DIRECCION EMPRESA:</b> '.$solicitud->rows[$c]['empr_dir'] . '</td>
				<td><b>TELEFONO EMPRESA:</b> ' . $solicitud->rows[$c]['empr_telf'] . '</td></tr>';
	$html.='<tr><td><b>CARGO QUE DESEMPEÑA:</b> '.$solicitud->rows[$c]['empr_cargo'] . '</td>
				<td><b>INGRESOS MENSUALES:</b> ' . $solicitud->rows[$c]['empr_ingreso_mensual'] . '</td></tr>';
	
	$html.='<tr><td><b>¿HA TRABAJADO ANTES EN EL COLEGIO AMERICANO?:</b> '. $soli_reprInfo_es_extrabajador . '</td>
				<td>'.$rango_trabajo.'</td></tr>';
	
	$html.='<tr><td><b>ES EX-ALUMNO:</b> '. $soli_reprInfo_es_exalumno . '</td>
				<td><b>AÑO DE PROMOCIÓN:</b> ' . $solicitud->rows[$c]['soli_reprInfo_anho_promocion'] . '</td></tr>';
	return $html;
}
/*	'GUARDADA'
	'ENVIADA' --BANDEJA LORENA --REVISA DOCUMENTOS, REVISA FORMULARIO. DOS OPCIONES: GENERAR DEUDA, DEVOLVER.
		'DEVUELTA'
	'PDTE. PAGO' --BANDEJA CAJERA -- MARCAR COMO PAGADO, DAR DE BAJA LA DEUDA PORQUE 'NO LE INTERESA'.
		'NO INTERESADO'
	'PAGADA' --BANDEJA LUPITA --ASIGNAR UNA FECHA DE EXAMEN. (MAS DE 1 DIA). --MOSTRAR LAS PAGADAS Y LOS 'EX. REPROBADOS'
	'FECHA ASIGNADA' -- BANDEJA LORENA, SUBE SINTESIS ESCANEADAS. DOS OPCIONES: APRB, REPR.
		'EX. REPROBADO' --CAMPO 'SOLI_NUM_SOLICITUD' AUMENTAR +1. SI ES 4 PONERLE, NO ADMITIDO.
		'NO ADMITIDO'
	'EX. APROBADO' --BANDEJA DIRECTORES -- 2 OPCIONES: APROBAR, NO ADMITIDO
		no 'REPROBADO DIRECTORES'
		'NO ADMITIDO'
	'APROBADO DIRECTORES'  --BANDEJA CONSEJO -- 2 OPCIONES: ADMITIDO, NO ADMITIDO
		no 'REPROBADO CONSEJO'
		'NO ADMITIDO'
	'ADMITIDO' --BANDEJA LORENA -- ESTUDIANTES ADMITIDOS. REPORTES, FORMULARIOS, ETC.
	'RESERVA PAGADA' --BANDEJA LORENA -- ESTUDIANTES ADMITIDOS QUE HAN PAGADO LA RESERVA. REPORTES, FORMULARIOS, ETC.
*/
function construct_table_solicitud( $tabla, $solicitud, $soli_estado )
{	global $diccionario; $mant = 0;
	if ( $soli_estado == "" ) $mant = 1;
	$body= "<table id='".$tabla."' name='".$tabla."' class='table table-bordered table-hover'>";
	/*  0 solicitud.soli_codi --
	  , 1 tbl_solicitud.per_codi
	  , 2 tbl_solicitud.peri_codi--
	  , 3 repr.per_id --
	  , 4 repr_nombre --
	  , 5 alum_nombre --
	  , 6 a.per_fecha_nac --
	  , 7 soli_num_por_per --
	  , 8 soli_curso_aplicado --
	  , 9 soli_fecha_ingr --
	  , 10 soli_estado--
	*/
	$body.= "<thead>".
				"<th style='text-align:center;font-size:small;'>Codigo solicitud</th>".
				//"<th style='text-align:center;font-size:small;'>Ref. persona</th>".
				//"<th style='text-align:center;font-size:small;'>Período</th>".
				//"<th style='text-align:center;font-size:small;'>Id. repr. académico</th>".
				"<th style='text-align:center;font-size:small;'>Repr. academico</th>".
				"<th style='text-align:center;font-size:small;'>Estudiante</th>".
				"<th style='text-align:center;font-size:small;'>F. Nacimiento</th>".
				//"<th style='text-align:center;font-size:small;'>Reprobado examen</th>".
				"<th style='text-align:center;font-size:small;'>Curso aplica</th>".
				"<th style='text-align:center;font-size:small;'>F. envio solicitud</th>";
	if ( $mant == 1 )
	{   $body.= "<th style='text-align:center;font-size:small;'>Estado</th>";
		$body.= "<th style='text-align:center;font-size:small;'><i class='fa fa-wrench'></i></th>";
	}
	else
		$body.= "<th style='text-align:center;font-size:small;'>Opciones</th>";
	$body.="</thead>";
	$body.="<tbody>";
	//o poner un if con varios TD dependiendo del estado.
	$c=0;
	$aux=0;
	foreach($solicitud->rows as $row)
	{	$aux++;
	}
	foreach($solicitud->rows as $row)
	{	if($c<($aux-1))
		{	$body.= "<tr>";
			$x = 0;
			$soli_codi = "";
			$alum_codi = "";
			$peri_codi = "";
			$id_repr_acad = "";
			$num_soli = "";
			$soli_estado = "";
			foreach($row as $column)
			{	if( $x == 0 ) $soli_codi = $column;
				if( $x == 1 ) $alum_codi = $column;
				if( $x == 2 ) $peri_codi = $column;
				if( $x == 3 ) $id_repr_acad = $column;
				if( $x == 7 ) $num_soli = $column;
				if( $x == 10 )
				{   $soli_estado = $column;
					if ( $mant == 1 )// es igual a esto: && ( $x != 10 )
						$body.="<td style='text-align:center;font-size:small;'>".$column."</td>";
				}
				if( ( $x == 0 ) )
				{   $body.="<td style='text-align:center;font-size:small;'>{".$column."}</td>";
				}
				if( ( $x != 0 ) && ( $x != 1 ) && ( $x != 2 ) && ( $x != 3 ) && ( $x != 7 ) && ( $x != 10 ) )
				{   $body.="<td style='text-align:center;font-size:small;'>".utf8_decode($column)."</td>";
				}
				$x++;
			}
			$tt_table = "<div style=\"text-align:left\"><table>";
			$tt_table.= "<tr><td><b>Id. repr.:</b>&nbsp;</td><td>". $id_repr_acad."</td></tr>";
			$tt_table.= "<tr><td><b>No. veces reprobado:</b>&nbsp;</td><td>". $num_soli."</td></tr>";
			$tt_table.= "<tr><td><b>Estado solicitud:</b>&nbsp;</td><td>". $soli_estado."</td></tr>";
			$tt_table.= "</table></div>";
			$var_tooltip="<span class='detalle' id='".$soli_codi."_soli_tooltip' onmouseover='$(this).tooltip(".'"show"'.")' title='".$tt_table."' data-placement='bottom'>".
						$soli_codi."</span>";
			$body = str_replace( "{".$soli_codi."}", $var_tooltip, $body );
			if ( $mant == 1 )
			{   $body.="<td style='text-align:center;font-size:small;'>";
				$opcm="";
				$opcm.= "<span     onclick='js_verSolicitud_cambiar_estado(\"".$soli_codi."\",\"".$soli_estado."\",\"resultado\",".'"'.$diccionario['rutas_head']['ruta_html'].'/verSolicitud/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil  cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_cambiar_estado' onmouseover='$(this).tooltip(".'"show"'.");' title='Cambiar estado' data-placement='left'></span>&nbsp;&nbsp;";
				$opcm.= "<span onclick='js_verSolicitud_eliminar_solicitud(\"".$soli_codi."\",\"resultado\",".'"'.$diccionario['rutas_head']['ruta_html'].'/verSolicitud/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' onmouseover='$(this).tooltip(".'"show"'.");'  title='Eliminar solicitud' data-placement='left'></span>";
				$body.=$opcm."</td>";
			}
			else
			$body.="<td style='text-align:center'>".get_solicitud_opciones( $soli_estado, $soli_codi, $alum_codi, $num_soli, $diccionario['rutas_head']['ruta_html'], 'span' )."</td>";
		}
		$body.="</tr>";
		$c++;
	}
	$body.="</tbody>";
	$body.="</table>";
	return utf8_encode($body);
}
function get_solicitud_opciones($estado, $soli_codi, $alum_codi, $num_soli, $ruta, $type='span')//Dependiendo del ESTADO, carga opciones.
{	if($type=='span')
	{	$tag=''; 
		$space='&nbsp;';
	}
	if($type=='button')
	{	$tag='button'; 
		$space='';
	}
	$opciones="";
	if( $estado == 'GUARDADA' || $estado == 'DEVUELTA')
	{   $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_carga_formulario(\"".$soli_codi."\",\"".$alum_codi."\",\"resultado\",".'"'.$ruta.'/enviarSolicitud/controller.php"'.", 1 )' style='color:#F0AD4E;' class='fa fa-folder cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign'  id='".$soli_codi."_asignar' onmouseover='$(this).tooltip(".'"show"'.");' title='Formulario de preinscripci&oacute;n'  data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_get_documentos_periodo_actual(".'"modal_soli_docu_body"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.",\"".$soli_codi."\")' class='fa fa-clipboard cursorlink' aria-hidden='true'  id='".$soli_codi."_documentos' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver documento(s) adjuntos' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_enviar(\"".$soli_codi."\",".'"resultado"'.",".'"'.$ruta.'/enviarSolicitud/controller.php"'.")' style='color:lightblue' class='fa fa-send cursorlink' aria-hidden='true' id='".$codigoCliente."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Enviar solicitud' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
	}
	if( $estado == 'ENVIADA' || $estado == 'DEVUELTA' || $estado == 'NO INTERESADO')
	{   $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_carga_formulario(\"".$soli_codi."\",\"".$alum_codi."\",\"resultado\",".'"'.$ruta.'/enviarSolicitud/controller.php"'.", 1 )' style='color:#F0AD4E;' class='fa fa-folder cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign'  id='".$soli_codi."_asignar' onmouseover='$(this).tooltip(".'"show"'.");' title='Formulario de preinscripci&oacute;n'  data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_get_documentos_periodo_actual(".'"modal_soli_docu_body"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.",\"".$soli_codi."\")' class='fa fa-clipboard cursorlink' aria-hidden='true'  id='".$soli_codi."_documentos' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver documento(s) adjuntos' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",\"".$alum_codi."\",".'"PDTE. PAGO"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:green' class='fa fa-check cursorlink' aria-hidden='true' id='".$soli_codi."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Aprobar solicitud' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",\"".$alum_codi."\",".'"DEVUELTA"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:red' class='fa fa-times cursorlink' aria-hidden='true' id='".$soli_codi."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Rechazar solicitud' data-placement='left'>".$space."</".$type.">";
	}
	if( $estado == 'PDTE. PAGO' ) //OPCIONES: 1. PAGADA. 2. NO INTERESADO
	{   $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",\"".$alum_codi."\",".'"PAGADA"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:green' class='fa fa-usd cursorlink' aria-hidden='true' id='".$soli_codi."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Marcar como cobrado' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",\"".$alum_codi."\",".'"NO INTERESADO"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:red' class='fa fa-times cursorlink' aria-hidden='true' id='".$soli_codi."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='No est&aacute; interesado en pagar' data-placement='left'>".$space."</".$type.">";
	}
	if( $estado == 'PAGADA' || $estado == 'EX. REPROBADO') //OPCIONES: 1. FECHA ASIGNADA
	{   $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_get_documentos_periodo_actual(".'"modal_soli_docu_body"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.",\"".$soli_codi."\")' class='fa fa-clipboard cursorlink' aria-hidden='true'  id='".$soli_codi."_documentos' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver documento(s) adjuntos' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_asignar_fecha(\"".$soli_codi."\",".'"FECHA ASIGNADA"'.",".'"modal_asign_fecha"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.", 1)' class='fa fa-calendar-check-o cursorlink' aria-hidden='true' id='".$soli_codi."_asignar' onmouseover='$(this).tooltip(".'"show"'.");' title='Asignar fecha(s)'  data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",\"".$alum_codi."\",".'"FECHA ASIGNADA"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:green' class='fa fa-check cursorlink' aria-hidden='true' id='".$soli_codi."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Marcar como con fechas asignadas' data-placement='left'>".$space."</".$type.">";
	}
	if( $estado == 'FECHA ASIGNADA' ) //OPCIONES:  SUBIR SINTESIS. 1. EX. APROBADO. 2. EX. REPROBADO (ALT. (si ha repr. 2 veces) NO ADMITIDO.
	{   $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_get_documentos_periodo_actual(".'"modal_soli_docu_body"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.",\"".$soli_codi."\")' class='fa fa-clipboard cursorlink' aria-hidden='true'  id='".$soli_codi."_documentos' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver documento(s) adjuntos' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_asignar_fecha(\"".$soli_codi."\",".'"FECHA ASIGNADA"'.",".'"modal_asign_fecha"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.", 0)' class='fa fa-calendar-check-o cursorlink' aria-hidden='true' id='".$soli_codi."_asignar' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver fecha(s) asignadas'  data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_subir_sintesis(\"".$soli_codi."\",\"".$num_soli."\",".'"modal_subir_archivo"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.", 1)' class='fa fa-upload cursorlink' aria-hidden='true'  id='".$soli_codi."_subirSintesis' onmouseover='$(this).tooltip(".'"show"'.");' title='Subir s&iacute;ntesis al sistema' data-placement='left'>".$space."</".$type.">";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",\"".$alum_codi."\",".'"EX. APROBADO"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:green' class='fa fa-check cursorlink' aria-hidden='true' id='".$soli_codi."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Aprob&oacute; ex&aacute;menes' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		if( $num_soli < 2 ) $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",\"".$alum_codi."\",".'"EX. REPROBADO"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:red' class='fa fa-times cursorlink' aria-hidden='true' id='".$soli_codi."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Reprob&oacute; ex&aacute;menes' data-placement='left'>".$space."</".$type.">";
		else 				$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",\"".$alum_codi."\",".'"NO ADMITIDO"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:red' class='fa fa-times cursorlink' aria-hidden='true' id='".$soli_codi."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='No fue admitido' data-placement='left'>".$space."</".$type.">";
	}
	if( $estado == 'EX. APROBADO' ) //OPCIONES: 1. APROBADO DIRECTORES, 2. NO ADMITIDO
	{   $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_get_documentos_periodo_actual(".'"modal_soli_docu_body"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.",\"".$soli_codi."\")' class='fa fa-clipboard cursorlink' aria-hidden='true'  id='".$soli_codi."_documentos' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver documento(s) adjuntos' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_asignar_fecha(\"".$soli_codi."\",".'"FECHA ASIGNADA"'.",".'"modal_asign_fecha"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.", 0)' class='fa fa-calendar-check-o cursorlink' aria-hidden='true' id='".$soli_codi."_asignar' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver fecha(s) asignadas'  data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_subir_sintesis(\"".$soli_codi."\",\"".$num_soli."\",".'"modal_subir_archivo"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.", 0)' class='fa fa-download cursorlink' aria-hidden='true'  id='".$soli_codi."_subirSintesis' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver s&iacute;ntesis del estudiante' data-placement='left'>".$space."</".$type.">";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",\"".$alum_codi."\",".'"APROBADO DIRECTORES"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:green' class='fa fa-check cursorlink' aria-hidden='true' id='".$soli_codi."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Aprobar solicitud' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",\"".$alum_codi."\",".'"NO ADMITIDO"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:red' class='fa fa-times cursorlink' aria-hidden='true' id='".$soli_codi."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Rechazar solicitud' data-placement='left'>".$space."</".$type.">";
	}
	if( $estado == 'APROBADO DIRECTORES' ) //OPCIONES: 1. ADMITIDO, 2. NO ADMITIDO
	{   $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_get_documentos_periodo_actual(".'"modal_soli_docu_body"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.",\"".$soli_codi."\")' class='fa fa-clipboard cursorlink' aria-hidden='true'  id='".$soli_codi."_documentos' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver documento(s) adjuntos' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_asignar_fecha(\"".$soli_codi."\",".'"FECHA ASIGNADA"'.",".'"modal_asign_fecha"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.", 0)' class='fa fa-calendar-check-o cursorlink' aria-hidden='true' id='".$soli_codi."_asignar' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver fecha(s) asignadas'  data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_subir_sintesis(\"".$soli_codi."\",\"".$num_soli."\",".'"modal_subir_archivo"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.", 0)' class='fa fa-download cursorlink' aria-hidden='true'  id='".$soli_codi."_subirSintesis' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver s&iacute;ntesis del estudiante' data-placement='left'>".$space."</".$type.">";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",\"".$alum_codi."\",".'"ADMITIDO"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:green' class='fa fa-check cursorlink' aria-hidden='true' id='".$soli_codi."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Aprobar solicitud' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",\"".$alum_codi."\",".'"NO ADMITIDO"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:red' class='fa fa-times cursorlink' aria-hidden='true' id='".$soli_codi."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Rechazar solicitud' data-placement='left'>".$space."</".$type.">";
	}
	if( $estado == 'ADMITIDO' ) //OPCIONES: REPORTES, FORMULARIOS, ETC.
	{   $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_carga_formulario(\"".$soli_codi."\",\"".$alum_codi."\",\"resultado\",".'"'.$ruta.'/enviarSolicitud/controller.php"'.", 1 )' style='color:#F0AD4E;' class='fa fa-folder cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign'  id='".$soli_codi."_asignar' onmouseover='$(this).tooltip(".'"show"'.");' title='Formulario de preinscripci&oacute;n'  data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_get_documentos_periodo_actual(".'"modal_soli_docu_body"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.",\"".$soli_codi."\")' class='fa fa-clipboard cursorlink' aria-hidden='true'  id='".$soli_codi."_documentos' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver documento(s) adjuntos' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_asignar_fecha(\"".$soli_codi."\",".'"FECHA ASIGNADA"'.",".'"modal_asign_fecha"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.", 0)' class='fa fa-calendar-check-o cursorlink' aria-hidden='true' id='".$soli_codi."_asignar' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver fecha(s) asignadas'  data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_subir_sintesis(\"".$soli_codi."\",\"".$num_soli."\",".'"modal_subir_archivo"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.", 1)' class='fa fa-download cursorlink' aria-hidden='true'  id='".$soli_codi."_subirSintesis' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver s&iacute;ntesis del estudiante' data-placement='left'>".$space."</".$type.">";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",\"".$alum_codi."\",".'"RESERVA PAGADA"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:green' class='fa fa-dollar cursorlink' aria-hidden='true' id='".$soli_codi."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Reserva pagada' data-placement='left'>".$space."</".$type.">";
	}
	if( $estado == 'RESERVA PAGADA' ) //OPCIONES: REPORTES, FORMULARIOS, ETC.
	{   $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_carga_formulario(\"".$soli_codi."\",\"".$alum_codi."\",\"resultado\",".'"'.$ruta.'/enviarSolicitud/controller.php"'.", 1 )' style='color:#F0AD4E;' class='fa fa-folder cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign'  id='".$soli_codi."_asignar' onmouseover='$(this).tooltip(".'"show"'.");' title='Formulario de preinscripci&oacute;n'  data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_get_documentos_periodo_actual(".'"modal_soli_docu_body"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.",\"".$soli_codi."\")' class='fa fa-clipboard cursorlink' aria-hidden='true'  id='".$soli_codi."_documentos' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver documento(s) adjuntos' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_asignar_fecha(\"".$soli_codi."\",".'"FECHA ASIGNADA"'.",".'"modal_asign_fecha"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.", 0)' class='fa fa-calendar-check-o cursorlink' aria-hidden='true' id='".$soli_codi."_asignar' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver fecha(s) asignadas'  data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_subir_sintesis(\"".$soli_codi."\",\"".$num_soli."\",".'"modal_subir_archivo"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.", 1)' class='fa fa-download cursorlink' aria-hidden='true'  id='".$soli_codi."_subirSintesis' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver s&iacute;ntesis del estudiante' data-placement='left'>".$space."</".$type.">";
	}
	$opciones.= "&nbsp;&nbsp;<".$type." ".$tag." onclick='js_verSolicitud_formulario_PDF(\"".$soli_codi."\",\"".$alum_codi."\",".'"modal_formulario_pdf_body"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:black' class='fa fa-file-pdf-o cursorlink cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_formulario_pdf'  id='".$soli_codi."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Ver formulario PDF' data-placement='left'>".$space."</".$type.">";
	$opciones.= "&nbsp;&nbsp;<".$type." ".$tag." onclick='js_verSolicitud_observaciones_PDF(\"".$soli_codi."\",".'"modal_formulario_pdf_body"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:green' class='fa fa-file-pdf-o cursorlink cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_formulario_pdf'  id='".$soli_codi."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Ver observaciones en PDF' data-placement='left'>".$space."</".$type.">";
	$opciones.= "&nbsp;&nbsp;<".$type." ".$tag." onclick='js_verSolicitud_observacion_set(\"".$soli_codi."\",".'"'.$ruta.'/verSolicitud/controller.php"'.")' class='fa fa-eye cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_obs'  id='".$soli_codi."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Agregar observaci&oacute;n' data-placement='left'>".$space."</".$type.">";
	return $opciones;
}
function genera_tabla_por_columnas($array_con_td, $num_columnas=2, $border=0, $width='100%', $align='center')
{	//Lo que hace esta función es 'construir' una tabla con 'X' columnas, dependiendo de la variable '$num_columnas', que por default es 2.
	//Si num_columnas es 2, devuelve una tabla con 2 columnas, etc.
	$aux = 0;
	$c = count($array_con_td);
	$body = "";
	$body.='<tr style="vertical-align:top;">';
	while ($aux < $c)
	{	$body.=  $array_con_td[$aux];
		$aux+=1;
		if (fmod($aux, $num_columnas)==0) $body.='</tr><tr style="vertical-align:top;">';
	}
	$body.='</tr>';
	
	$table= "<table class='table table-bordered table-condensed table-responsive' style=\"table-layout: fixed;\" cellspacing='0' cellpadding='0' ".
			" width='".$width."' align='".$align."' border='".$border."'><tbody>";
	$table.= $body;
	$table.= "</tbody></table>";
	
	return $table;
}
function obtener_edad( $birthDate )
{   //date in mm/dd/yyyy format; or it can be in other formats as well
	//la variable viene como año, mes, dia. así que el orden cambia a 1,2,0
	//explode the date to get month, day and year
	$birthDate = explode("/", $birthDate);
	//get age from date or birthdate
	$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
		? ((date("Y") - $birthDate[0]) - 1)
		: (date("Y") - $birthDate[0]));
	return $age;
}
?>