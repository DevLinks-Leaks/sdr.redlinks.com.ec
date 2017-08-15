<?php
session_start();
require_once('/../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');
function handler()
{
	$representante = get_mainObject('Representante');
	$tablacliente = get_mainObject('Representante');
	$cliente_descuentos = get_mainObject('Representante');
	$event = get_actualEvents(array(VIEW_GET_ALL, VIEW_ASIGN, SET_MAIN_REPR, SET_MAIN_FINAN), VIEW_GET_ALL);
	$user_data = get_frontData();
	$general = get_mainObject('General');

	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla = "cliente_table";}else{$tabla =$_POST['tabla'];}

    switch ($event)
	{	case VIEW_ASIGN :
			global $diccionario;
			$general = new General();
            $representante->get_representante($user_data['alum_codi']);
			$titulo_tabla="";
			$construct_table=
			"<br>
			 <table class='display' id='tabla_asigna_repr' width='100%'>
				<thead>
					<tr>       
						<th style='text-align:center;font-size:11px;'>Ref.</th>
						<th style='text-align:center;font-size:11px;'>Nombre</th>
						<th style='text-align:center;font-size:11px;'>Apellido</th>
						<th style='text-align:center;font-size:11px;'>Id.</th>
						<th style='text-align:center;font-size:11px;'>Parentesco</th>
						<th style='text-align:center;font-size:11px;'>Acad&eacute;mico</th>
						<th style='text-align:center;font-size:11px;'>Financiero</th>
					</tr>
				</thead>";
			$construct_table.= "</tr></thead>";
			$body="<tbody>";
			$c=0;
			$aux=0;
			$codigo="";
			$cedula="";
			foreach($representante->rows as $row)
			{	$aux++;
			}
			foreach($representante->rows as $row)
			{	if($c<($aux-1))
				{	$body.="<tr>";
					$x=0;
					$datos="";
					foreach($row as $column)
					{	if(($x==0)||($x==1)||($x==2)||($x==3)||($x==9))
						{	$body.="<td><div style='font-size:11px;'>".$column."</div></td>";
						}
						$alum_codi = $row['alum_codi'];
						$repr_codi = $row['repr_codi'];
						if($x==0) $titulo_tabla="<br><div style='text-align:left'><b>Representantes de ".$general->PrimeraMayuscula($row['alum_nomb'])." ".$row['alum_apel']."</b></div>";
						$x++;
					}
					$radioMain="<input type='radio' name='principal' onclick='js_representantes_repr_upd_princ(\"div_repr_list\",".'"'.$diccionario['rutas_head']['ruta_html'].'/representantes/controller.php"'.",\"".$alum_codi."\",\"".$repr_codi."\");' ".
										"id='".$codigo."_hacer_principal' title='Hacer principal acad&eacute;mico' onmouseover='$(this).tooltip(".'"show"'.")' data-placement='left'";
										
					if($row['repre_alum_princ']=='P'){$radioMain.=" checked='checked' ";}
					$radioMain.="/>";
					
					$radioFina="<input type='radio' name='financiero' onclick='js_representantes_repr_upd_princ_finan(\"div_repr_list\",".'"'.$diccionario['rutas_head']['ruta_html'].'/representantes/controller.php"'.",\"".$alum_codi."\",\"".$repr_codi."\");' ".
										"id='".$codigo."_hacer_financiero' title='Hacer principal financiero' onmouseover='$(this).tooltip(".'"show"'.")' data-placement='left'";
					if($row['repre_alum_fact']=='S'){$radioFina.=" checked='checked' ";}
					$radioFina.="/>";
					
					$body.= "<td style='text-align:center'>".$radioMain."</td>";
					$body.= "<td style='text-align:center'>".$radioFina."</td>";
				}
				$body.="</tr>";
				$c++;
			}
			$construct_table.=$body;
			$construct_table.="</tbody></table>
				<br>
				<div class='col-md-6' style='text-align:left'><small><i>Los cambios se guardar&aacute;n autom&aacute;ticamente.</i></small></div>
				<br>
				<div class='col-md-6' style='text-align:left'>
					<button id='btn_upd_fact_por_aut' class='btn btn-success' name='id='btn_upd_fact_por_aut' 
						onclick='return js_representantes_upd_fact_por_aut(\"div_upd_fact_por_aut_response\",\"".$alum_codi."\",\"".$diccionario['rutas_head']['ruta_html']."/representantes/controller.php\");'
						>Actualizar deudas</button></div>
				<div id='div_upd_fact_por_aut_response'></div>";
			$data['tabla_asigna_repr'] = $titulo_tabla.$construct_table;
			retornar_result($data);
            break;
		case SET_MAIN_REPR :
			$resultado = $representante->set_main($user_data['alum_codi'],$user_data['repr_cedu']);
			$data =array("mensaje" => $resultado->mensaje);
			retornar_result($data);
			break;
		case SET_MAIN_FINAN :
			$resultado = $representante->set_main_finan($user_data['alum_codi'],$user_data['repr_cedu']);
			$data =array("mensaje" => $resultado->mensaje);
			retornar_result($data);
			break;
		case GET_REPRESENTANTES : //tabla personal
			global $diccionario;
			$general = new General();
			if( empty( $user_data['alum_codi'] ) )
			{   $data= '<div class="callout callout-info">
								<h4><strong><li class="fa fa-exclamation"></li></strong></h4>
								Debe primero guardar los datos del <b>estudiante</b> y, luego, guardar los datos de <b>el/los representante(s)</b>,
								para poder seleccionar el <b>representante académico</b> y el <b>representante económico</b>.
							</div>';
				print $data;
			}
			else
			{    $representante->get_representante_new($user_data['alum_codi']);
				$titulo_tabla="";
				$construct_table=
				"<br>
				 <table class='display' id='tabla_asigna_repr' width='100%'>
					<thead>
						<tr>       
							<th style='text-align:center;font-size:11px;'>Ref.</th>
							<th style='text-align:center;font-size:11px;'>Nombre</th>
							<th style='text-align:center;font-size:11px;'>Id.</th>
							<th style='text-align:center;font-size:11px;'>Parentesco</th>
							<th style='text-align:center;font-size:11px;'>Repr. acad&eacute;mico</th>
							<th style='text-align:center;font-size:11px;'>Repr. financiero</th>
							<th style='text-align:center;font-size:11px;'>Editar informaci&oacute;n</th>
						</tr>
					</thead>";
				$construct_table.= "</tr></thead>";
				$body="<tbody>";
				$c=0;
				$aux=0;
				$codigo="";
				$cedula="";
				foreach($representante->rows as $row)
				{	$aux++;
				}
				foreach($representante->rows as $row)
				{	if($c<($aux-1))
					{	$body.="<tr>";
						$x=0;
						$datos="";
						foreach($row as $column)
						{	if( ($x==1) || ($x==2) || ($x==3) || ($x==7) )
							{	$body.="<td><div style='font-size:11px;'>".$column."</div></td>";
							}
							$alum_codi = $row['alum_codi'];
							$repr_codi = $row['repr_codi'];
							$relacion  = $row['rel_codi'];
							if($x==0) $titulo_tabla="<br><div style='text-align:left'><b>Listado de representantes ingresados</b></div>";
							$x++;
						}
						$radioMain="<input type='radio' name='principal' onclick='js_representantes_set_repr_acad(\"div_repr_list\",".'"'.$diccionario['rutas_head']['ruta_html'].'/representantes/controller.php"'.",\"".$alum_codi."\",\"".$repr_codi."\",\"".$relacion."\");' ".
											"id='".$codigo."_hacer_principal' title='Marcar como repr. acad&eacute;mico' onmouseover='$(this).tooltip(".'"show"'.")' data-placement='left'";
											
						if($row['repr_acad']=='S'){$radioMain.=" checked='checked' ";}
						$radioMain.="/>";

						$radioFina="<input type='radio' name='financiero' onclick='js_representantes_set_repr_finan(\"div_repr_list\",".'"'.$diccionario['rutas_head']['ruta_html'].'/representantes/controller.php"'.",\"".$alum_codi."\",\"".$repr_codi."\",\"".$relacion."\");' ".
											"id='".$codigo."_hacer_financiero' title='Marcar como repr. financiero' onmouseover='$(this).tooltip(".'"show"'.")' data-placement='left'";
						if($row['repr_finan']=='S'){$radioFina.=" checked='checked' ";}
						$radioFina.="/>";
						$botonEditar = "<span onclick='js_enviarSolicitud_editar_datos_admision(\"".$alum_codi."\",\"".$repr_codi."\",".'"modal_add_repr_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/enviarSolicitud/controller.php"'.")' 
								class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_add_repr' id='".$repr_codi."_editar' onmouseover='$(this).tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
						
						if ( $relacion == 8 || $relacion == 9 && $user_data['toggle_opc'] == 'off' )
							$botonEditar = "";
						
						$body.= "<td style='text-align:center'>".$radioMain."</td>";
						$body.= "<td style='text-align:center'>".$radioFina."</td>";
						$body.= "<td style='text-align:center'>".$botonEditar."</td>";
					}
					$body.="</tr>";
					$c++;
				}
				$construct_table.=$body;
				$construct_table.="</tbody></table>";
				if( $user_data['toggle_opc'] == 'on' )
				{   $construct_table.="
					<br>
					<div class='col-md-6' style='text-align:left'><small><i>Los cambios se guardar&aacute;n autom&aacute;ticamente.</i></small></div>
					<br>
					<div class='col-md-6' style='text-align:left'>
						<button id='btn_upd_fact_por_aut' class='btn btn-success' name='id='btn_upd_fact_por_aut' 
							onclick='return js_representantes_upd_fact_por_aut(\"div_upd_fact_por_aut_response\",\"".$alum_codi."\",\"".$diccionario['rutas_head']['ruta_html']."/representantes/controller.php\");'
							>Actualizar deudas</button></div>
					<div id='div_upd_fact_por_aut_response'></div>";
				}
					
				$data['tabla_asigna_repr'] = $titulo_tabla.$construct_table;
				retornar_result($data);
			}
            break;
		case SET_REPR_ACAD : //tabla personal
			$resultado = $representante->set_repr_acad($user_data['alum_codi'], $user_data['repr_codi'], $user_data['relacion'] );
			$data =array("mensaje" => $resultado->mensaje);
			retornar_result($data);
			break;
		case SET_REPR_FINAN : //tabla personal
			$resultado = $representante->set_repr_finan($user_data['alum_codi'], $user_data['repr_codi'], $user_data['relacion'] );
			$data =array("mensaje" => $resultado->mensaje);
			retornar_result($data);
			break;
		case UPD_FACTURAS_POR_AUTORIZAR :
			$resultado = $representante->actualizar_facturas_por_autorizar($user_data['alum_codi']);
			$data =array("mensaje" => $resultado->mensaje);
			retornar_result($data);
			break;
			
        default :
			break;
    }
}

handler();
?>