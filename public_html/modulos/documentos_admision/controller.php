<?php
session_start();
require_once('../../core/controllerBase.php');
require_once('../general/model.php');
require_once('../periodo/model.php');
require_once('constants.php');
require_once('model.php');
require_once('../verSolicitud/model.php');
require_once('view.php');

function handler() {
	require('../../core/rutas.php');
    $documento = get_mainObject('docAdmin');
    $permiso = get_mainObject('General');
    $event = get_actualEvents(array(SET, DELETE, CHECK, EDIT, GET_ALL, VIEW_GET_ALL, SINT_SUBE, SINT_BAJA, DOC_SUBE, DOC_BAJA), VIEW_GET_ALL);
    $user_data = get_frontData();
	$periodos = get_mainObject('General');
	$solicitud = get_mainObject('Solicitud');
	$periodo = get_mainObject('Periodo');

	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla= "descuento_table";}else{$tabla=$_POST['tabla'];}

    switch ($event)
	{   case SET:
			$array = array();
			$array['docu_descr'] = $user_data['docu_descr'];
			$array['peri_codi'] = $user_data['peri_codi'];
            $resultado = $documento->set($array);
			$data =array("mensaje" => $resultado->mensaje);
			retornar_result($data);
            break;
		case CHECK:
			//En vez de mandarle el peri_codi del registro, se le manda el peri_codi activado en el sistema, para que en el caso de que el registro no exista
			//en el periodo actual, cree un nuevo registro.
			$resultado = $documento->check($user_data['check'],$user_data['docu_codi'],$_SESSION['peri_codi'],$user_data['docu_peri_codi']);
			$data = array("mensaje" => $resultado->mensaje);
			retornar_result($data);			
            break;
        case DELETE:
			$resultado = $documento->delete($user_data['docu_codi']);
			$data = array("mensaje" => $resultado->mensaje);
			retornar_result($data);			
            break;
        case EDIT:
            $array = array();
			$array['docu_codi'] = $user_data['docu_codi'];
			$array['docu_descr'] = $user_data['docu_descr'];
            $resultado = $documento->edit($array);
			$data =array("mensaje" => $resultado->mensaje);
			retornar_result($data);
            break;
		case GET_ALL_DATA:
            if($user_data['peri_codi']=='-1')
				$peri_codi = $_SESSION['peri_codi'];
			else
				$peri_codi = $user_data['peri_codi'];
			$documento->get_all($peri_codi);
			if(count($documento->rows)>0)
			{   $data['mensaje'] = construct_table_documentos($documento->rows, $permiso);
            }
			else
			{   $data = array('mensaje'=>$documento->mensaje.$documento->ErrorToString());
			}
			retornar_result($data);
            break;
		case VIEW_GET_ALL:
			if (isset($_SESSION['IN']))
			{	if($_SESSION['IN']!="OK")
				{	$_SESSION['IN']="KO";
					header("Location: http://".$domain."/admisiones_americano/salir.php");
				}
			}
			else
			{	header("Location: http://".$domain."/admisiones_americano");
			}
            $documento->get_all($_SESSION['peri_codi']);
			$periodo->get_periodos_activos();
			if(count($documento->rows)>0)
			{   global $diccionario;
				$data['tabla'] = construct_table_documentos($documento->rows, $permiso);
			}
			else
			{   $data = array('mensaje'=>$documento->mensaje.$documento->ErrorToString());
			}
			$data['periodo_activo'] = $_SESSION['peri_deta'];
			$data['peri_act_codi']  = $_SESSION['peri_codi'];
			$data['{combo_periodo}']  = array("elemento"=> "combo",
											  "datos"     => $periodo->rows,
                                              "options"   => array(	"name"=>"periodos",
																	"id"=>"cmb_periodo",
																	"name"=>"cmb_periodo",
																	"required"=>"required",
																	"class"=>"form-control"),
											  "selected"  => 0);
			$periodo->get_combo_all();
			$data["{cmb_periodos}"] = array("elemento"  => "combo", 
										   "datos"     => $periodo->rows,
										   "options"   => array("name"=>"periodo_select","id"=>"periodo_select","class"=>"form-control","required"=>"required","onchange"=>"change_periodo('".$diccionario['rutas_head']['ruta_html']."/general/controller.php')","style"=>"margin-top:7px"),
										   "selected"  => $_SESSION['peri_codi']);
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		case GET_TAB_DOCUMENTOS:
			global $diccionario;
			if( !empty( $user_data['id_solicitud'] ) )
			{   $solicitud->get_solicitud_admision_especifica($user_data['id_solicitud']);
				if( ( count( $solicitud->rows )-1 )>0 )
					$data.= constructor_tabla_requisitos($documento, $solicitud->rows[0]['per_codi'], $solicitud->rows[0]['peri_codi'], $user_data['id_solicitud'], $user_data['deband'] );
				else
					$data= '<div class="callout callout-info">
								<h4><strong><li class="fa fa-exclamation"></li></strong></h4>
								Debe primero guardar los cambios en el <b>Formulario de preadmisión</b> para poder subir los documentos requeridos.
							</div>';
				print $data;
			}
			else
			{   $data= '<div class="callout callout-info">
								<h4><strong><li class="fa fa-exclamation"></li></strong></h4>
								Debe primero guardar los cambios en el <b>Formulario de preadmisión</b> para poder subir los documentos requeridos.
							</div>';
				print $data;
			}
			break;
		case DOC_SUBE:
			$directorio = '../../documentos/requisitos/'.$user_data['soli_codi'].'/';
			if( !is_dir( $directorio ) )//si no existe, crea la carpeta con el nombre del codigo.
				mkdir( $directorio , 0777 );
				
			if ( !empty( $_FILES['file'] ) )
			{	$file = uniqid().getmypid();
				$name_file = $file . '.' . pathinfo( $_FILES['file']['name'], PATHINFO_EXTENSION );
				$full_name = $directorio . $name_file;
				
				$temporal = $_FILES['file']['tmp_name'];
				//$tamano= ($_FILES['file']['size'] / 1000)."Kb";
				move_uploaded_file( $temporal, $full_name );
				$resultado = $documento->subir_persona_documento(
					$user_data['per_codi'], 		$_SESSION['peri_codi'], 
					$user_data['docu_peri_codi'],	$name_file );
				echo $resultado->mensaje;
			}
			break;
		case CHECK_VALIDO: 
			$resultado = $documento->docAdmin_validar_documento(
					$user_data['check'], 		$user_data['per_codi'], 
					$user_data['docu_peri_codi']);
			echo $resultado->mensaje;
			break;
		case SINT_SUBE:
			if ( 0 < $_FILES['file']['error'] )
			{   echo  'Error: ' . $_FILES['file']['error'] . '.';
			}
			switch ($_FILES['file']['error'])
			{   case UPLOAD_ERR_OK:
					break;
				case UPLOAD_ERR_NO_FILE:
					echo RuntimeException('No se ha enviado ningún archivo.');
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					echo RuntimeException('Límite de tamaño excedido.');
				default:
					echo RuntimeException('Error desconocido.');
			}
			if ($_FILES['file']['size'] > 10000000)
			{   echo RuntimeException('Límite de tamaño excedido.');
			}
			else
			{	$directorio = '../../documentos/sintesis/'.$user_data['soli_codi'].'/';
				if( !is_dir( $directorio ) )//si no existe, crea la carpeta con el nombre del codigo.
					mkdir( $directorio , 0777 );
					
				if ( !empty( $_FILES['file'] ) )
				{	$file = uniqid().getmypid();
					$name_file = $file . '.' . pathinfo( $_FILES['file']['name'], PATHINFO_EXTENSION );
					$full_name = $directorio . $name_file;
					
					$temporal = $_FILES['file']['tmp_name'];
					//$tamano= ($_FILES['file']['size'] / 1000)."Kb";
					move_uploaded_file( $temporal, $full_name );
					$resultado = $documento->subir_persona_sintesis($user_data['soli_codi'],
																	"",
																	$name_file,
																	$user_data['soli_sint_docu_desc'],
																	$_SERVER['HTTP_X_FORWARDED_FOR'],
																	$_SERVER['REMOTE_ADDR'] );
					echo $resultado->mensaje;
				}
				echo $resultado->mensaje;
			}
			break;
		case SINT_BAJA:
			global $diccionario;
			$documento->ver_sintesis_solicitud($user_data['soli_codi']);
			if( ( count( $documento->rows )-1 )>0 )
			{	$lista= "<b>Lista de archivos adjuntos de síntesis académica</b><br><br>".
						"<div style='background-color:#e5e5e5;height:300px;overflow-y:scroll;'>";
				$c=1;
				$tabla = array ();
				foreach ($documento->rows as $row)
				{   if( !empty( $row ) )
					{   $quitar= "<td width='10%'><span style='color:red;cursor:pointer;' class='fa fa-times' id='quitar_".$row['soli_sint_codi']."' ".
									" name='quitar_".$row['soli_sint_codi']."' ".
									" title='Quitar s&iacute;ntesis' onclick=\"js_docAdmin_sintesis_borrar( '".$row['soli_codi']."', '".$row['soli_sint_codi']."','modal_subir_archivo_bandeja', '".$diccionario['rutas_head']['ruta_html']."/documentos_admision/controller.php');\"></span></td>";
						if ( $row['soli_sint_docu_desc'] == "") 
							$tabla[]= "<td width='10%'>".$c.".</td><td><a target='_blank' href='" . $_SESSION['ruta_documentos_sintesis'] . '/' . $row['soli_codi'] . '/' . $row['soli_sint_docu_nom_file']."'> Archivo adjunto no.".$c."</a></td>".$quitar;
						else
							$tabla[]= "<td width='10%'>".$c.".</td><td><a target='_blank' href='" . $_SESSION['ruta_documentos_sintesis'] . $row['soli_codi']  . '/' . $row['soli_sint_docu_nom_file']."'>".$row['soli_sint_docu_desc']."</a></td>".$quitar;
						$c++;
					}
				}
				$lista.= genera_tabla_por_columnas($tabla, 1, 0)."</div>";
			    print $lista;
			}
			else
			{   $data= '<div class="callout callout-info">
							<h4><strong><li class="fa fa-exclamation"></li></strong></h4>
							-No se encontraron síntesis académicas subidas en el sistema-.
						</div>';
			    print $data;
			}
			break;
		case SINT_BORRA:
			global $diccionario;
			$resultado = $documento->docAdmin_sintesis_solicitud_borrar($user_data['soli_codi'],
																		$user_data['soli_sint_codi'],
																		$_SERVER['HTTP_X_FORWARDED_FOR'],
																		$_SERVER['REMOTE_ADDR'] );
			echo $resultado->mensaje;
			break;
    }
}
handler();
function construct_table_documentos($documento, $permiso)
{	global $diccionario;
	$construct_table = '
	<table class="display" id="documentos_table">
		<thead>
			<tr>
				<th style="text-align:center;">Ref.</th>
				<th style="text-align:center;">Documentos</th>
				<th style="text-align:center;">Período creaci&oacute;n</th>
				<th style="text-align:center;">Mostrar en período activo</th>
				<th style="text-align:center;">Opciones</th>
			</tr>
		</thead>
		<tbody>';
	foreach ($documento as $row_docu_busq)
	{ 	if(!empty($row_docu_busq))
		{   $cc +=1;
			$construct_table.= '
			<tr>
				<td>'.$row_docu_busq["docu_codi"].'</td>
				<td>'.$row_docu_busq["docu_descr"].'
					<input type="hidden" id="docu_descr_edi_'.$row_docu_busq["docu_codi"].'" name="docu_descr_edi_'.$row_docu_busq["docu_codi"].'" value="'.$row_docu_busq["docu_descr"].'">
					<input type="hidden" id="docu_codi_edi_'.$row_docu_busq["docu_codi"].'" name="docu_codi_edi_'.$row_docu_busq["docu_codi"].'" value="'.$row_docu_busq["docu_codi"].'">
					<input type="hidden" id="peri_codi_edi_'.$row_docu_busq["docu_codi"].'" name="peri_codi_edi_'.$row_docu_busq["docu_codi"].'" value="'.$row_docu_busq["peri_codi"].'">
				</td>
				<td>'.$row_docu_busq["peri_codi"].'
				</td>
				<td>';
					$construct_table.='
						<input class="option"
								onClick="js_docAdmin_event(\'div_documentos_tabla\',\''.$diccionario['rutas_head']['ruta_html'].'/documentos_admision/controller.php\',\'check\', 0,'.
								$_SESSION['peri_codi'].','.$row_docu_busq["docu_codi"].','.$row_docu_busq["docu_peri_codi"].',this.checked,null);"
								title="Si es un documento de un per&iacute;odo pasado, copiar&aacute; el registro al período actual."
								type="checkbox"';
					if(($row_docu_busq["docu_peri_estado"]=='I') || ($row_docu_busq["peri_codi"]!=$_SESSION["peri_codi"])) $construct_table.= ""; else $construct_table.= "checked";
					$construct_table.= '/>
				</td>
				<td><span data-toggle="modal" data-target="#ModalDocuEdi" onclick="js_docAdmin_edit('.$row_docu_busq["docu_codi"].');"
						onmouseover="$(this).tooltip(\'show\')" title="Editar"
						class="btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink">&nbsp;</span>&nbsp;';
				
				$construct_table.=
					'<span onClick="js_docAdmin_event_del(\'div_documentos_tabla\',\''.$diccionario['rutas_head']['ruta_html'].'/documentos_admision/controller.php\', \'delete\',0,0,'.$row_docu_busq["docu_codi"].',0,0);"
						onmouseover="$(this).tooltip(\'show\')" title="Eliminar"
						class="btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink">&nbsp;</span>
						';
				$construct_table.='
				</td>
			</tr>';
		}
	}
	$construct_table.='
	</table>';
	return $construct_table;
}
function genera_div_grid_por_columnas( $array_con_div_col, $num_columnas = 2)
{	//Lo que hace esta función es 'construir' una tabla con 'X' columnas, dependiendo de la variable '$num_columnas', que por default es 2.
	//Si num_columnas es 2, devuelve una tabla con 2 columnas, etc.
	//Como se usa bootstrap, sólo puedo retornar 1,2,3,4,6,12 columnas que midan exactamente igual.
	if ( $num_columnas == 5 ) $num_columnas = 4;
	if ( $num_columnas > 6 && $num_columnas < 10 ) $num_columnas = 6;
	if ( $num_columnas > 9 && $num_columnas < 13 ) $num_columnas = 12;
	$col_md = ( 12 / $num_columnas );
	$aux = 0;
	$c = count($array_con_div_col);
	$body = "";
	$body.='<div class="row">';
	while ($aux < $c)
	{	$body.= str_replace( '{columna}', 'col-md-'.$col_md, $array_con_div_col[$aux] );
		$aux+=1;
		if (fmod($aux, $num_columnas)==0) $body.='</div><div class="row">';
	}
	$body.='</div>';
	
	$table= "<div class='grid'>";
	$table.= $body;
	$table.= "</div>";
	
	return $table;
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
function constructor_tabla_requisitos( $documento, $per_codi, $peri_codi, $soli_codi, $deband )
{	global $diccionario;
	$i=0;
	$aux=array();
	$documento->get_all( $peri_codi );
	foreach ($documento->rows as $row)
	{   if( !empty( $row ) )
		{   if ( $row['docu_peri_estado'] != 'I' )
			{   $aux[$i][0] = $row['docu_peri_codi'];
				$aux[$i][1] = $row['docu_descr'];
				$i++;
			}
		}
	}
	$j=0;
	$aux2=array();
	$documento->ver_docu_solicitud( $per_codi, $peri_codi );
	foreach ($documento->rows as $row)
	{   if( !empty( $row ) )
		{   $aux2[$j][0] = $row['docu_peri_codi'];
			$aux2[$j][1] = $row['per_docu_peri_checked'];
			$aux2[$j][2] = $row['per_docu_peri_nom_file'];
			$j++;
		}
	}
	$x = $y = 0;
	$aux3=array();
	while($x<$i)
	{   $f=0;
		$y=0;
		while($y<$j)
		{   if($f==0)
			{   if( $aux[$x][0] == $aux2[$y][0] )
				{   $aux3[$x][0] = $aux[$x][0];
					$aux3[$x][1] = $aux[$x][1];
					$aux3[$x][2] = $aux2[$y][1];
					$aux3[$x][3] = $aux2[$y][2];
					$f++;
				}
			}
			$y++;
		}
		if($f==0)
		{   $aux3[$x][0] = $aux[$x][0];
			$aux3[$x][1] = $aux[$x][1];
			$aux3[$x][2] = 0;
			$aux3[$x][3] = "";
		}
		$x++;
	}
	$c=0;
	$num_subidos=0;
	$array1= array();
	$directorio_sql = $_SESSION['ruta_documentos_requisitos'] . $user_data['soli_codi'];
	if( $i > 0 )
	{	while( $c < $i )
		{   $validado = $subido = $validador = $hidden = ""; $panel_line = "primary";
			$documento_valido = $aux3[$c][2];
			$documento_subido = $aux3[$c][3];
			if( $documento_valido == 1 )
			{	$validado = '<strike>'.$aux3[$c][1].'</strike><span style="color:green;"> <span class="fa fa-check"></span> Aprobado</span><br/>';
				$panel_line = "success";
				if ( $deband != 1 )
					$hidden = 'display:none;';
			}else
			{   $validado = $aux3[$c][1];
			}
			if( strlen( $documento_subido ) > 0 )
			{	$subido.= '<li><a href="' . $directorio_sql . $documento_subido . '" target="_blank">Ver archivo subido.</a></li>';
				if ( $deband == 1 )
				{   $validador.= '<li><div style="color:black;">Marcar como documento válido '.
									'<input type="checkbox" id="ckb_val_doc_'.$aux3[$c][0].'" name="ckb_val_doc_'.$aux3[$c][0].'" class="option" onClick="js_docAdmin_validar_documento('.
									$aux3[$c][0].', '.$per_codi.',\''.$deband.'\',this.checked,\'div_documentos_admisiones\',\''.$diccionario['rutas_head']['ruta_html'].'/documentos_admision/controller.php\');"
									onmouseover="$(this).tooltip(\'show\')" title="Marcar documento como v&aacute;lido" ';
					if ( $documento_valido == 1 )
						$validador.= ' checked ';
					$validador.= '/></li>';
				}
				$validador.= '</div><br>';
				$num_subidos++;
			}
			$array1[]= '
				<div class="{columna}">
					<div class="panel box box-'.$panel_line.'">
						<div class="box-header with-border">
							<h3 class="box-title">
								'.$validado.'
							</h3>
						</div>
						<div class="panel-collapse collapse in">
							<div class="box-body">
								<table width="100%">
									<tr>
										<td colspan="2">
											<ul>
												'.$subido.'
												'.$validador.'
											</ul>
											</td>
									</tr>
									<tr><td>
											<button type="button" style="'.$hidden.'" id="btn_subir_documento_'.$aux3[$c][0].'" name="btn_subir_documento_'.$aux3[$c][0].'" 
												class="btn btn-primary" onclick="js_docAdmin_subir_documentos('.$aux3[$c][0].','.$per_codi.','.$peri_codi.',\''.$deband.'\',\'div_documentos_admisiones\',\''.$diccionario['rutas_head']['ruta_html'].'/documentos_admision/controller.php\');">'.
												'<li style="color:green" class="fa fa-upload"></li>&nbsp;Subir archivo</button>
										</td>
										<td><input type="file" id="input_file_'.$aux3[$c][0].'" style="width:100%;'.$hidden.'" />
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
			  </div>';
			$c++;
		}
	}
	else
	{   $array1[]= '<div class="col-sm-12">--No hay documentos por entregar --</div>';
	}
	if( $deband == 0 )
		$div_warning = '
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-warning" role="alert">Para su solicitud, se requiere que adjunte los documentos listados más abajo.</div>
			</div>
		</div>';
	$construct_table = '
	<div class="contenedor">
		'.$div_warning.'
		<div align="center">'.genera_div_grid_por_columnas($array1, 2).
		  '
		</div>
	</div>
	<input name="hd_num_doc_up" 	id="hd_num_doc_up"		type="hidden" value="'.$num_subidos.'"/>';
	return $construct_table;
}
?>