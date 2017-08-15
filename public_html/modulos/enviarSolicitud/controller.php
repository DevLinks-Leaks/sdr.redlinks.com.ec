<?php
session_start();
if(!class_exists('DBAbstractModel')){require_once('../../core/db_abstract_model.php');}
require_once('../../core/controllerBase.php');
require_once('../general/model.php');
require_once('../periodo/model.php');
require_once('constants.php');
require_once('../verSolicitud/model.php');
require_once('../documentos_admision/model.php');
require_once('../colegio/model.php');
require_once('../profesion/model.php');
require_once('../region/model.php');
require_once('../representantes/model.php');
require_once('view.php');
require_once('../../core/funciones.php');
function handler()
{   $solicitud 		= get_mainObject('Solicitud');
	$solicitud_fecha= get_mainObject('Solicitud');
    $documentos 	= get_mainObject('docAdmin');
    $event 			= get_actualEvents(array(VIEW_GET_ALL, VIEW_SET, VIEW_SET_HOME), VIEW_GET_ALL);
    $user_data 		= get_frontData();
    $permiso 		= get_mainObject('General');
	$cursos 		= get_mainObject('Solicitud');
	$profesion 		= get_mainObject('Profesion');
	$pais 			= get_mainObject('Region');
	$provincia 		= get_mainObject('Region');
	$ciudad 		= get_mainObject('Region');
	$colegio		= get_mainObject('Colegio');
	$estado_civil	= get_mainObject('Solicitud');
	$parentesco		= get_mainObject('Solicitud');
	$representante	= get_mainObject('Representante');
	$periodo 		= get_mainObject('Periodo');

    if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
    if (!isset($_POST['tabla'])){$tabla = "cliente_table";}else{$tabla =$_POST['tabla'];}

    switch ($event)
	{   case VIEW_GET_ALL:
			$periodo->get_all();
			if(count($periodo->rows)>0)
			{   $data['div_periodos_seleccion'] = construct_div_periodo($periodo);
            }
			else
			{   $data = array('mensaje'=>$periodo->mensaje.$periodo->ErrorToString());
			}
            retornar_vista(VIEW_GET_ALL, $data);
            break;
		case FORMULARIO:
			global $diccionario;
			$parentesco->get_Catalogo_by_idPadre(2);
			
			/*-------------------------------------------------------------------------------------
				FOTO PLACEHOLDER
			  -------------------------------------------------------------------------------------*/
			
			$data['fotoUsuario'] = '../site_media/imagenes/user2-160x160.png';
			
			/*-------------------------------------------------------------------------------------
				VARIABLES
			  -------------------------------------------------------------------------------------*/
			
			$data['id_solicitud'] = '';
			$data['per_codi'] = '';
			$data['soli_estado'] = '';
			$data['where_from'] = $user_data['deband']; //lo correcto es que, por aquí, sea siempre '0'.
			$data['num_docu'] = '0';
			//$data['repr1_codi'] = ''; --variables como estas existen desde el constructor de formulario representantes.
			
			/*-------------------------------------------------------------------------------------
				BLANQUEANDO DATOS DEL ESTUDIANTE
			  -------------------------------------------------------------------------------------*/
			
			$data = constructor_combo_regiones( $data );
			
			$preadm_ant= "<select id='cmb_per_preadmision_anterior' name='cmb_per_preadmision_anterior' class='form-control' style='display:block;' disabled='disabled' >
					<option value=''>Seleccione...</option>";
			$last_y = date("Y");
			$first_y = date("Y") - 12;
			while( $first_y <= $last_y )
			{   $preadm_ant.= "<option value='".$first_y."'>".$first_y."</option>";
				$first_y++;
			}
			$preadm_ant.= "
				</select>";
			$data['cmb_per_tipo_identificacion'] = constructor_combo_tipo_id('cmb_per_tipo_identificacion', 0); //falta el selected de este
			$data['per_numero_identificacion'] = '';
			$data['per_apel'] = '';
			$data['per_apel_mat'] = '';
			$data['per_nomb'] = '';
			$data['per_nomb_seg'] = '';
			$data['per_dir'] = '';
			$data['per_telf'] = '';
			$data['per_sector_residencia_fuera'] = '';
			$data['per_email_personal'] = '';
			$data['per_fecha_nac'] = '';
			$data['per_genero_m'] = " checked ";
			$data['per_genero_f'] = " ";
			$data['per_col_anterior'] = '';
			$data['per_col_anterior_dir'] = '';
			$data['per_con_quien_vive'] = '';
			$data['per_tiempo_residencia'] = '';
			$data['cmb_per_preadmision_anterior'] = $preadm_ant;
			$data['per_num_hermanos'] = '';
			$data['per_tiene_hermanos_en_colegio'] = '';
			$data['per_tiene_familiares_en_colegio'] = '';
			$data['opc_1'] = '';
			$data['opc_2'] = '';
			$data['opc_3'] = '';
			$data['opc_4'] = '';
			$data['opc_5'] = '';
			$data['per_como_se_entero'] = '';
			$data['per_ruc_facturacion'] = '';
			
			//CHECKS
			$data['checked_colegio_no_encontrado'] = "";
			$data['checked_tiene_hermanos_en_colegio'] = "";
			$data['checked_tiene_familiares_en_colegio'] = "";
			$data['checked_relizo_proceso_previamente'] = "";
			$data['checked_ha_sido_alumno_antes'] = "";
			
			//DISABLED
			$data['per_sector_residencia_fuera_disabled'] = " disabled='disabled' ";
			$data['per_hermanos_cole_disabled'] = " disabled='disabled' ";
			$data['per_familiares_cole_disabled'] = " disabled='disabled' ";
			$data['per_col_anterior_disabled'] = " disabled='disabled' ";
			
			//VIVE EN
			$data['per_vive_casa_propia'] = "";
			$data['per_vive_casa_alquilada'] = "";
			$data['per_vive_casa_otros'] = "";
			
			/*-------------------------------------------------------------------------------------
				REPRESENTANTE PADRE Y MADRE
			  -------------------------------------------------------------------------------------*/
			$data = constructor_formulario_repr( $data, 'repr1' );
			$data = constructor_formulario_repr( $data, 'repr2' );
			
			retornar_formulario(VIEW_FORMULARIO, $data);
            break;
		case FORMULARIO_REPR: 
			if ( $user_data['id_solicitud'] != "" )
			{   $data = constructor_formulario_repr( $data, $user_data['reprX'], 'repr' );
				retornar_formulario( VIEW_FORMULARIO_REPR, $data );
			}
			else
			{   $data['mensaje'] = '<div class="callout callout-info">
							<h4><strong><li class="fa fa-exclamation"></li></strong></h4>
							Debe primero guardar los cambios en el <b>Formulario de preadmisión</b> para poder agregar más representantes.
						</div>';
				retornar_result( $data );
			}
			break;
		case FORMULARIO_CONTINUAR:
			global $diccionario;
			if( ( $user_data['deband'] == 1 ) ) //si es bandeja, o si es del formulario de solicitud web.
			{   $data['list_enviar_display'] = " style='display:none' ";
			    $data['btn_tab_4_next_display'] = " style='display:none' ";
			}
			else
			{   $data['list_enviar_display'] = "";
			    $data['btn_tab_4_next_display'] = "";
			}
			if ( isset( $user_data['id_solicitud'] ) )
			{   $solicitud->get_solicitud_persona_consulta( $user_data['id_solicitud'], $user_data['estudiante_per_codi'] );
				if( ( count( $solicitud->rows )-1 )>0 )
				{	/*-------------------------------------------------------------------------------------
						FOTO POSTULANTE
					  -------------------------------------------------------------------------------------*/
					if( $solicitud->rows[0]['soli_foto'] == "" )
						$data['fotoUsuario'] = '../site_media/imagenes/user2-160x160.png';
					else
					{   $directorio = '../documentos/solicitudes_fotos/'.$solicitud->rows[0]['soli_codi'].'/';
						$data['fotoUsuario'] = $directorio.$solicitud->rows[0]['soli_foto'];
					}
					
					/*-------------------------------------------------------------------------------------
						VARIABLES
					  -------------------------------------------------------------------------------------*/
					$data['id_solicitud'] = $solicitud->rows[0]['soli_codi'];
					$data['per_codi'] = $solicitud->rows[0]['per_codi'];
					$data['soli_estado'] = $solicitud->rows[0]['soli_estado'];
					$data['num_docu_up'] = $solicitud->rows[0]['num_doc_up'];
					$data['num_docu'] = $solicitud->rows[0]['num_doc'];
					$data['where_from'] = $user_data['deband']; //si es bandeja, o si es del formulario de solicitud web.
					
					$data = constructor_combo_regiones( 
								$data, 
								$solicitud->rows[0]['soli_curso_aplicado'], 
								$solicitud->rows[0]['per_pais_nacionalidad'], 
								$solicitud->rows[0]['per_provincia'],
								$solicitud->rows[0]['per_ciudad'], 
								$solicitud->rows[0]['soli_cole_pais'], 
								$solicitud->rows[0]['soli_cole_provincia'], 
								$solicitud->rows[0]['soli_cole_ciudad'], 
								$solicitud->rows[0]['soli_colegio_ant_codi'] );
					
					$pre_admin_selected = "";
					if( $solicitud->rows[0]['soli_anho_proceso_previo'] == "" )
						$pre_admin_selected = " disabled='disabled' ";
					$preadm_ant= "<select id='cmb_per_preadmision_anterior' name='cmb_per_preadmision_anterior' class='form-control' style='display:block;' ".$pre_admin_selected." >
							<option value=''>Seleccione...</option>";
					$last_y = date("Y");
					$first_y = date("Y") - 12;
					while( $first_y <= $last_y )
					{   $selected = "";
						if( $solicitud->rows[0]['soli_anho_proceso_previo'] == $first_y )
							$selected = " selected='selected' ";
						$preadm_ant.= "<option ".$selected." value='".$first_y."'>".$first_y."</option>";
						$first_y++;
					}
					$preadm_ant.= "
						</select>";
					
					if( ( $solicitud->rows[0]['soli_tiene_hermanos_inscritos'] == TRUE ) || ( $solicitud->rows[0]['soli_tiene_hermanos_inscritos'] == 1 ) )
					{	$data['checked_tiene_hermanos_en_colegio'] = " checked ";
						$data['per_hermanos_cole_disabled'] = "";
					}
					else
					{	$data['checked_tiene_hermanos_en_colegio'] = "";
						$data['per_hermanos_cole_disabled'] = " disabled='disabled' ";
					}
					if( ( $solicitud->rows[0]['soli_tiene_familiares_inscritos'] == TRUE ) || ( $solicitud->rows[0]['soli_tiene_familiares_inscritos'] == 1 ) )
					{	$data['checked_tiene_familiares_en_colegio'] = " checked ";
						$data['per_familiares_cole_disabled'] = "";
					}
					else
					{	$data['checked_tiene_familiares_en_colegio'] = "";
						$data['per_familiares_cole_disabled'] = " disabled='disabled' ";
					}
					if( ( $solicitud->rows[0]['soli_relizo_proceso_previamente'] == TRUE ) || ( $solicitud->rows[0]['soli_relizo_proceso_previamente'] == 1 ) )
						$data['checked_relizo_proceso_previamente'] = " checked ";
					else
						$data['checked_relizo_proceso_previamente'] = "";
					
					if( ( $solicitud->rows[0]['soli_examen_psicologico'] == TRUE ) || ( $solicitud->rows[0]['soli_examen_psicologico'] == 1 ) )
						$data['checked_pruebas_psicologicas'] = " checked ";
					else
						$data['checked_pruebas_psicologicas'] = "";
					
					if( ( $solicitud->rows[0]['soli_ha_sido_alumno_antes'] == TRUE ) || ( $solicitud->rows[0]['soli_ha_sido_alumno_antes'] == 1 ) )
						$data['checked_ha_sido_alumno_antes'] = " checked ";
					else
						$data['checked_ha_sido_alumno_antes'] = "";
					
					if( ( $solicitud->rows[0]['soli_colegio_no_encontrado'] == TRUE ) || ( $solicitud->rows[0]['soli_colegio_no_encontrado'] == 1  ) )
					{   $data['checked_colegio_no_encontrado'] = " checked ";
						$data['per_col_anterior_disabled'] = "";
					}
					else
					{	$data['checked_colegio_no_encontrado'] = "";
						$data['per_col_anterior_disabled'] = " disabled='disabled' ";
					}
					$data['per_vive_casa_propia'] = "";
					$data['per_vive_casa_alquilada'] = "";
					$data['per_vive_casa_otros'] = "";
					
					if ( $solicitud->rows[0]['per_sector_residencia'] == 'NORTE' )
						$data['per_sector_residencia_norte'] = " selected='selected' ";
					if ( $solicitud->rows[0]['per_sector_residencia'] == 'SUR' )
						$data['per_sector_residencia_sur'] = " selected='selected' ";
					if ( $solicitud->rows[0]['per_sector_residencia'] == 'ESTE' )
						$data['per_sector_residencia_este'] = " selected='selected' ";
					if ( $solicitud->rows[0]['per_sector_residencia'] == 'OESTE' )
						$data['per_sector_residencia_oeste'] = " selected='selected' ";
					if ( $solicitud->rows[0]['per_sector_residencia'] == 'CENTRO' )
						$data['per_sector_residencia_centro'] = " selected='selected' ";
					if ( $solicitud->rows[0]['per_sector_residencia'] == 'VIA DAULE' )
						$data['per_sector_residencia_via_daule'] = " selected='selected' ";
					if ( $solicitud->rows[0]['per_sector_residencia'] == 'VIA DURAN TAMBO' )
						$data['per_sector_residencia_via_duran'] = " selected='selected' ";
					if ( $solicitud->rows[0]['per_sector_residencia'] == 'VIA SAMBO' )
						$data['per_sector_residencia_via_sambo'] = " selected='selected' ";
					if ( $solicitud->rows[0]['per_sector_residencia'] == 'VIA PERIMETRAL' )
						$data['per_sector_residencia_via_perimetral'] = " selected='selected' ";
					if ( $solicitud->rows[0]['per_sector_residencia'] == 'VIA A LA COSTA' )
						$data['per_sector_residencia_via_alacosta'] = " selected='selected' ";
					if ( $solicitud->rows[0]['per_sector_residencia'] == 'FUERA PAIS' )
						$data['per_sector_residencia_fuera_pais'] = " selected='selected' ";

					if ( ( $solicitud->rows[0]['per_sector_residencia'] != 'FUERA PAIS' ) || empty( $solicitud->rows[0]['per_sector_residencia'] ) )
						$data['{per_sector_residencia_fuera_disabled}'] = " disabled='disabled' ";
					
					if( $solicitud->rows[0]['per_vive_en_casa_propia'] == 'PROPIA' )
						$data['per_vive_casa_propia'] = " selected='selected' ";
					
					if( $solicitud->rows[0]['per_vive_en_casa_propia'] == 'ALQUILADA' )
						$data['per_vive_casa_alquilada'] = " selected='selected' ";
					
					if( $solicitud->rows[0]['per_vive_en_casa_propia'] == 'FAMILIARES' )
						$data['per_vive_casa_familiares'] = " selected='selected' ";
					
					if( $solicitud->rows[0]['per_vive_en_casa_propia'] == 'AMIGOS' )
						$data['per_vive_casa_amigos'] = " selected='selected' ";
					
					if( $solicitud->rows[0]['per_vive_en_casa_propia'] == 'OTROS' )
						$data['per_vive_casa_otros'] = " selected='selected' ";
					
					if( $solicitud->rows[0]['per_genero'] == 'M' )
					{   $data['per_genero_m'] = " checked ";
						$data['per_genero_f'] = " ";
					}
					if( $solicitud->rows[0]['per_genero'] == 'F' )
					{   $data['per_genero_m'] = " ";
						$data['per_genero_f'] = " checked ";
					}
					$data['cmb_per_tipo_identificacion'] = constructor_combo_tipo_id('cmb_per_tipo_identificacion', 0, $solicitud->rows[0]['per_tipo_id'] );
					$data['per_numero_identificacion'] = $solicitud->rows[0]['per_id'];
					$data['per_apel'] = $solicitud->rows[0]['per_apel'];
					$data['per_apel_mat'] = $solicitud->rows[0]['per_apel_mat'];
					$data['per_nomb'] = $solicitud->rows[0]['per_nomb'];
					$data['per_nomb_seg'] = $solicitud->rows[0]['per_nomb_seg'];
					$data['per_dir'] = $solicitud->rows[0]['per_dir_personal'];
					$data['per_telf'] = $solicitud->rows[0]['cont_det_numero'];
					$data['per_sector_residencia_fuera'] = $solicitud->rows[0]['per_sector_otros'];
					$data['per_email_personal'] = $solicitud->rows[0]['per_email_personal'];
					$data['per_fecha_nac'] = $solicitud->rows[0]['per_fecha_nac'];
					$data['per_col_anterior'] = $solicitud->rows[0]['soli_colegio_procedencia'];
					$data['per_col_anterior_dir'] = $solicitud->rows[0]['soli_colegio_direccion'];
					
					switch ($solicitud->rows[0]['soli_vive_con'])
					{	case 'PAPÁ':
							$data['opc_vive_con_papa'] = 'selected';
							$data['opc_vive_con_mama'] = '';
							$data['opc_vive_con_papa_mama'] = '';
							$data['opc_vive_con_familiares'] = '';
						break;
						case 'MAMÁ':
							$data['opc_vive_con_papa'] = '';
							$data['opc_vive_con_mama'] = 'selected';
							$data['opc_vive_con_papa_mama'] = '';
							$data['opc_vive_con_familiares'] = '';
						break;
						case 'PAPÁ Y MAMÁ':
							$data['opc_vive_con_papa'] = '';
							$data['opc_vive_con_mama'] = '';
							$data['opc_vive_con_papa_mama'] = 'selected';
							$data['opc_vive_con_familiares'] = '';
						break;
						case 'FAMILIARES':
							$data['opc_vive_con_papa'] = '';
							$data['opc_vive_con_mama'] = '';
							$data['opc_vive_con_papa_mama'] = '';
							$data['opc_vive_con_familiares'] = 'selected';
						break;
						default:
							$data['opc_vive_con_papa'] = '';
							$data['opc_vive_con_mama'] = '';
							$data['opc_vive_con_papa_mama'] = '';
							$data['opc_vive_con_familiares'] = '';
						break;
					}
					
					
					$data['per_tiempo_residencia'] = $solicitud->rows[0]['per_tiempo_de_recidencia'];
					$data['cmb_per_preadmision_anterior'] = $preadm_ant;
					
					switch ($solicitud->rows[0]['soli_como_se_entero_proceso_de_admision'])
					{	case 'REFERENCIAS':
							$data['opc_1'] = 'selected';
							$data['opc_2'] = '';
							$data['opc_3'] = '';
							$data['opc_4'] = '';
							$data['opc_5'] = '';
							$data['opc_6'] = '';
						break;
						case 'CIRCULAR A PADRES':
							$data['opc_2'] = 'selected';
							$data['opc_1'] = '';
							$data['opc_3'] = '';
							$data['opc_4'] = '';
							$data['opc_5'] = '';
							$data['opc_6'] = '';
						break;
						case 'DIRECTO EN ADMISIONES':
							$data['opc_3'] = 'selected';
							$data['opc_1'] = '';
							$data['opc_2'] = '';
							$data['opc_4'] = '';
							$data['opc_5'] = '';
							$data['opc_6'] = '';
						break;
						case 'REDES SOCIALES':
							$data['opc_4'] = 'selected';
							$data['opc_1'] = '';
							$data['opc_2'] = '';
							$data['opc_3'] = '';
							$data['opc_5'] = '';
							$data['opc_6'] = '';
						break;
						case 'PRENSA ESCRITA/RADIO':
							$data['opc_1'] = '';
							$data['opc_2'] = '';
							$data['opc_3'] = '';
							$data['opc_4'] = '';
							$data['opc_5'] = 'selected';
							$data['opc_6'] = '';
						break;
						case 'RADIO':
							$data['opc_1'] = '';
							$data['opc_2'] = '';
							$data['opc_3'] = '';
							$data['opc_4'] = '';
							$data['opc_5'] = '';
							$data['opc_6'] = 'selected';
						break;
						default:
							$data['opc_1'] = '';
							$data['opc_2'] = '';
							$data['opc_3'] = '';
							$data['opc_4'] = '';
							$data['opc_5'] = '';
							$data['opc_6'] = '';
						break;
					}
					
					
					$data['per_num_hermanos'] = $solicitud->rows[0]['soli_num_hermanos'];
					$data['per_ruc_facturacion'] = $solicitud->rows[0]['soli_ruc_facturacion'];
					$data['per_tiene_familiares_en_colegio'] = $solicitud->rows[0]['soli_datos_familiares_inscritos'];
					$data['per_tiene_hermanos_en_colegio'] = $solicitud->rows[0]['soli_datos_hermanos_inscritos'];
					
					/*-------------------------------------------------------------------------------------
						REPRESENTANTES
					  -------------------------------------------------------------------------------------*/
					$solicitud->get_solicitud_repr_consulta( $user_data['estudiante_per_codi'] );
					if( ( count( $solicitud->rows )-1 )>0 )
					{	$c = 0; $tiene_padre = 0; $tiene_madre = 0;
						while( $c < ( count( $solicitud->rows )-1 ) )
						{   if( $solicitud->rows[$c]['per_rel_de_p1_a_p2'] == 8) // 8 es PADRE
							{   $data = sub_constructor_formulario_repr_load($solicitud, $c, $data, 'repr1', 'repr1');
								$tiene_padre = 1;
							}
							if( $solicitud->rows[$c]['per_rel_de_p1_a_p2'] == 9) // 9 es MADRE
							{   $data = sub_constructor_formulario_repr_load($solicitud, $c, $data, 'repr2', 'repr2');
								$tiene_madre = 1;
							}
							$c++;
						}
					}
					if( $tiene_padre == 0)
						$data = constructor_formulario_repr( $data, 'repr1' );
					if( $tiene_madre == 0)
						$data = constructor_formulario_repr( $data, 'repr2' );
				}
			}
			retornar_formulario(VIEW_FORMULARIO, $data);
            break;
		case GET_REPR_ESPECIFICO:
			global $diccionario;
			$solicitud->get_solicitud_repr_consulta_especifica( $user_data['alum_codi'], $user_data['repr_codi'] );
			if( ( count( $solicitud->rows )-1 )>0 )
			{	$data = sub_constructor_formulario_repr_load($solicitud, '0', $data, $user_data['reprX'], 'repr');
				retornar_formulario( VIEW_FORMULARIO_REPR, $data );
			}
			else
			{   echo "No se encontraron resultados";
			}
			break;
		case GET_SOLICITUD_ESPECIFICA:
			global $diccionario;
			$solicitud->get_solicitud_admision_especifica($user_data['id_solicitud']);
			if( ( count( $solicitud->rows )-1 )>0 )
			{   if( $solicitud->rows[0]['soli_estado'] != 'NO ADMITIDO' &&
					$solicitud->rows[0]['soli_estado'] != 'INACTIVO' &&
					$solicitud->rows[0]['soli_estado'] != 'EX. REPROBADO' &&
					$solicitud->rows[0]['soli_estado'] != 'NO INTERESADO' )
				{   $data=' <div class="callout callout-info">
								<h4><strong><li class="fa fa-exclamation"></li> Bienvenido, '.$solicitud->rows[0]['per_nomb'].' '.$solicitud->rows[0]['per_apel'].'.</strong></h4>
								ID DE LA SOLICITUD: "'.$solicitud->rows[0]['soli_codi'].'". 
								<br>
							</div>';
				}
				if( $solicitud->rows[0]['soli_estado'] == 'FECHA ASIGNADA' )
				{   $solicitud_fecha->solicitud_fecha_examen_ver( $user_data['id_solicitud'] );
					if( ( count( $solicitud_fecha->rows )-1 )>0 )
					{	
						$data='<div class="callout callout-information">
								<h4><strong><li class="fa fa-exclamation"></li></strong></h4>
								EN PROCESO DE EVALUACIÓN.
							</div>';
							
						$data.= "<div style='background-color:#e5e5e5;height:300px;overflow-y:scroll;'>";
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
						$data.= "	<div class='callout callout-success'>
										<b>Fechas de exámenes/activiades asignadas</b><br><br>".
										genera_tabla_por_columnas($tabla, 1, 0)."
									</div>
								</div>";
					}
					else
					{   $data.= '<div class="callout callout-success">
									<h4><strong><li class="fa fa-exclamation"></li></strong></h4>
									No hay registro de fechas asignadas. Acérquese a administración, para averiguar más acerca de su fecha asignada.
								</div>
							</div>';	
					}
				}
				else if( $solicitud->rows[0]['soli_estado'] == 'ENVIADA' )
				{   $data.= '<div class="callout callout-success">
								<h4><strong><li class="fa fa-exclamation"></li></strong></h4>
								Su solicitud fue recibida. Una vez que su solicitud haya sido procesada, un mensaje le llegará a su dirección de correo electrónico,
								o puede visitar este mismo sitio dentro de los próximos días para verificar el estado de su solicitud. ¡Muchas gracias!
							</div>';
				}
				else if( $solicitud->rows[0]['soli_estado'] == 'GUARDADA' )
				{   $data.= '<div>
								<a id="btn_continuar_solicitud" name="btn_continuar_solicitud" class="btn btn-app"
									onclick="js_enviarSolicitud_carga_formulario(\''.$solicitud->rows[0]['soli_codi'].'\',\''.$solicitud->rows[0]['per_codi'].'\',\'div_formulario_solicitud\',\''.$diccionario['rutas_head']['ruta_html'].'/enviarSolicitud/controller.php\', 0 )">
									<i class="fa fa-pencil"></i> Continuar llenando formulario
								</a>
							</div>';	
				}
				else if( $solicitud->rows[0]['soli_estado'] == 'DEVUELTA' )
				{	if( $solicitud->rows[0]['soli_observacion'] != "" )
					{	$data.= '<div class="callout callout-warning">
									<h4><strong><li class="fa fa-exclamation"></li></strong></h4>
									Su solicitud ha sido devuelta por el (los) siguiente(s) motivo(s):<br><br><b>"'.
									$solicitud->rows[0]['soli_observacion'].'"</b><br><br>'.
									'Haga clic en continuar para llenar los requisitos faltantes y, una vez terminado, sírvase en hacer clic en "ENVIAR", y 
									volveremos a procesar su solicitud sin problemas. ¡Gracias!
								</div>
								<br>';
					}
					$data.= '<div>
								<a id="btn_continuar_solicitud" name="btn_continuar_solicitud" class="btn btn-app" 
									onclick="js_enviarSolicitud_carga_formulario(\''.$solicitud->rows[0]['soli_codi'].'\',\''.$solicitud->rows[0]['per_codi'].'\',\'div_formulario_solicitud\',\''.$diccionario['rutas_head']['ruta_html'].'/enviarSolicitud/controller.php\', 0 )">
									<i class="fa fa-pencil"></i> Continuar llenando formulario
								</a>
							</div>';
				}
				else if( $solicitud->rows[0]['soli_estado'] == 'NO ADMITIDO' || 
							$solicitud->rows[0]['soli_estado'] == 'INACTIVO' || 
							$solicitud->rows[0]['soli_estado'] == 'EX. REPROBADO' || 
							$solicitud->rows[0]['soli_estado'] == 'NO INTERESADO' )
				{   $data.= '<div class="callout callout-information">
								<h4><strong><li class="fa fa-exclamation"></li></strong></h4>
								POR FAVOR COMUNICARSE CON EL DEPARTAMENTO DE ADMISIONES.
							</div>';
				}
				else if( $solicitud->rows[0]['soli_estado'] == 'EX. APROBADO' || 
							$solicitud->rows[0]['soli_estado'] == 'APROBADO DIRECTORES' )
				{   $data.= '<div class="callout callout-information">
								<h4><strong><li class="fa fa-exclamation"></li></strong></h4>
								EN PROCESO DE EVALUACIÓN.
							</div>';
				}
				else
				{   if( $solicitud->rows[0]['soli_observacion'] != "" )
						$data.= '<div class="callout callout-info">
									<h4><strong><li class="fa fa-exclamation"></li></strong></h4>
									Mensaje del departamento de pre-admisiones:<br><br><b>"'.$solicitud->rows[0]['soli_observacion'].'"</b><br><br>
								</div>';
				}
			}
			else
				$data= '<div class="callout callout-danger">
							<h4><strong><li class="fa fa-exclamation"></li></strong></h4>
							Solicitud NO encontrada
						</div>';
			print $data;
			break;
		case GET_ALL_CURSOS_BY_ECON_LEVEL_LIST:
			global $diccionario;
			$cursos->get_Cursos( );
            $data['{combo}'] = array(				"elemento"  => 	"combo", 
													"datos"     => 	$cursos->rows, 
                                                    "options"   => 	array(	"name"=>"cursos",
																			"id"=>"curso",
																			"required"=>"required",
																			"class"=>"form-control",
																			"onChange"	=>	""),
													"selected"  => 	0);
			retornar_result($data);
            break;
		case FORMULARIO_GUARDAR:
			global $diccionario;
			//un procedimiento para datos del alumno, 3 para datos de los repr.
			$directorio = '../../documentos/solicitudes_fotos/'.$user_data['id_solicitud'].'/';
			if( !is_dir( $directorio ) )//si no existe, crea la carpeta con el nombre del codigo.
				mkdir( $directorio , 0777 );
				
			if ( !empty( $_FILES['soli_foto'] ) )
			{	$file = uniqid().getmypid();
				$name_file = $file . '.' . pathinfo( $_FILES['soli_foto']['name'], PATHINFO_EXTENSION );
				$full_name = $directorio . $name_file;
				
				$temporal = $_FILES['soli_foto']['tmp_name'];
				move_uploaded_file( $temporal, $full_name );
			}
			$resultado_ingreso_solicitud = $solicitud->set_solicitud_preadmision(
				$user_data['id_solicitud'],
				$user_data['per_codi'],
				$name_file,
				$user_data['cmb_per_tipo_identificacion'], 
				$user_data['per_numero_identificacion'],
				$user_data['per_nomb'],
				$user_data['per_nomb_seg'],
				$user_data['per_apel'],
				$user_data['per_apel_mat'],
				$user_data['per_dir'],
				$user_data['per_telf'],
				$user_data['cmb_sector_residencia'],
				$user_data['per_sector_residencia_fuera'],
				$user_data['per_fecha_nac'],
				$user_data['per_rdb_genero'],
				$user_data['per_email_personal'],
				$user_data['cmb_pais_per_lugar_nac'],
				$user_data['cmb_provincia_per_lugar_nac'],
				$user_data['cmb_ciudad_per_lugar_nac'],
				$user_data['cmb_curso_aplica'],
				$user_data['cmb_pais_colegio_anterior'],
				$user_data['cmb_provincia_colegio_anterior'],
				$user_data['cmb_ciudad_colegio_anterior'],
				$user_data['cmb_colegio_anterior'],
				$user_data['ckb_colegio_no_encontrado'],
				$user_data['per_col_anterior'],
				$user_data['per_col_anterior_dir'],
				$user_data['per_num_hermanos'],
				$user_data['ckb_tiene_hermanos_en_colegio'],
				$user_data['per_tiene_hermanos_en_colegio'],
				$user_data['ckb_tiene_familiares_en_colegio'],
				$user_data['per_tiene_familiares_en_colegio'],
				$user_data['per_con_quien_vive'],
				$user_data['ckb_preadmision_anterior'],
				$user_data['cmb_per_preadmision_anterior'],
				$user_data['ckb_matriculado_anteriormente'],
				$user_data['ckb_pruebas_psicologicas'],
				$user_data['per_vive_casa'],
				$user_data['per_tiempo_residencia'],
				$user_data['per_como_se_entero'],
				$user_data['per_ruc_facturacion'],
				$_SESSION['peri_codi'],
				$_SERVER['HTTP_X_FORWARDED_FOR'], //éste último es IP.
				$_SERVER['REMOTE_ADDR'],
				$user_data['soli_estado']);
			$data = array("ID_SOLICITUD"=> $resultado_ingreso_solicitud->id_solicitud_out,
						  "PER_CODI"	=> $resultado_ingreso_solicitud->per_codi_out,
						  "MENSAJE"		=> $resultado_ingreso_solicitud->mensaje);
			if ( !empty( $resultado_ingreso_solicitud->id_solicitud_out ) )
			{	if ( !empty( $user_data['repr1_numero_identificacion'] ) )
				{   $resultado_padre = set_representante( $resultado_ingreso_solicitud->id_solicitud_out, $resultado_ingreso_solicitud->per_codi_out,
											$user_data, 'repr1', 8); //8 es padre, 9 es madre
					$data["REPR1_CODI"] = $resultado_padre->per_codi_out;
					$data["REPR1_EMPR_CODI"] = $resultado_padre->inst_codi_out;
					$data["REPR1_PER_EMPR_CODI"] = $resultado_padre->per_inst_codi_out;
					$data["REPR1_MENSAJE"] = $resultado_padre->mensaje." (datos del padre)";
				}
			}
			if ( !empty( $resultado_ingreso_solicitud->id_solicitud_out ) )
			{	if ( !empty( $user_data['repr2_numero_identificacion'] ) )
				{   $resultado_madre = set_representante( $resultado_ingreso_solicitud->id_solicitud_out, $resultado_ingreso_solicitud->per_codi_out,
											$user_data, 'repr2', 9); //8 es padre, 9 es madre
					$data["REPR2_CODI"] = $resultado_madre->per_codi_out;
					$data["REPR2_EMPR_CODI"] = $resultado_madre->inst_codi_out;
					$data["REPR2_PER_EMPR_CODI"] = $resultado_madre->per_inst_codi_out;
					$data["REPR2_MENSAJE"] = $resultado_madre->mensaje." (datos de la madre)";
				}
			}
			echo json_encode($data, true);
			break;
		case SET_REPR_ESPECIFICO:
			if ( !empty( $user_data['id_solicitud'] ) )
			{	if ( !empty( $user_data['repr3_numero_identificacion'] ) )
				{   $resultado = set_representante( $user_data['id_solicitud'], $user_data['per_codi'],
											$user_data, 'repr3', $user_data['cmb_persona_relacion']);
					$data["MENSAJE"] = $resultado->mensaje." (datos del familiar/representante)";
				}
			}
			echo json_encode($data, true);
			break;
		case ENVIAR_SOLICITUD:
			$resultado_ingreso_solicitud = $solicitud->set_solicitud_estado($user_data['id_solicitud'], 
																			'ENVIADA',
																			$_SERVER['HTTP_X_FORWARDED_FOR'],
																			$_SERVER['REMOTE_ADDR'] );
			$data = array("ID_SOLICITUD"=> $resultado_ingreso_solicitud->id_solicitud_out,
						  "ESTADO"	=> $resultado_ingreso_solicitud->per_codi_out,
						  "MENSAJE"	=> $resultado_ingreso_solicitud->mensaje);
			echo json_encode($data, true);
			break;
	}
}
handler();
function constructor_combo_tipo_id( $nombre, $completo, $tipo = "" )
{	$selected = array();
	if ( $tipo == "CI" )
	{ 	$selected[0] = ' selected="selected" ';
	}
	else if ( $tipo == "RUC" )
	{ 	$selected[1] = ' selected="selected" ';
	}
	else if ( $tipo == "PAS" )
	{ 	$selected[2] = ' selected="selected" ';
	}
	else if ( $tipo == "CF" )
	{ 	$selected[3] = ' selected="selected" ';
	}
	else if ( $tipo == "IDE" )
	{ 	$selected[4] = ' selected="selected" ';
	}
	else if ( $tipo == "PLC" )
	{ 	$selected[5] = ' selected="selected" ';
	}
	if ( $completo == 1 )
		$whole_set = '
				<option '.$selected[1].' value="RUC">RUC</option>
				<option '.$selected[3].' value="CF">Consumidor final</option>
				<option '.$selected[4].' value="IDE">Exterior</option>
				<option '.$selected[5].' value="PLC">Placa</option>';
	
	return '<select id="'.$nombre.'" name="'.$nombre.'" class="form-control">
				<option value="">Tipo de identificaci&oacute;n</option>
				<option '.$selected[0].' value="CI">Cédula</option>
				<option '.$selected[2].' value="PAS">Pasaporte</option>'
				.$whole_set.'
			</select>';
}
function set_representante( $codigo_solicitud, $estudiante_per_codi, $user_data, $repr, $relacion)
{	//Registra un representante nuevo en la base.
	$direccion_igual = $user_data[ 'ckb_'.$repr.'_per_dir_igual' ];
	$dir = $telf = "";
	if( ( $direccion_igual == 1 ) || ( $direccion_igual == 'true' ) ) //Valida si la dirección del repr. es igual a la del estudiante, para no tipearla dos veces.
	{   $dir = $user_data['per_dir'];
		$telf = $user_data['per_telf'];
	}
	else
	{   $dir = $user_data[ $repr.'_dir' ];
		$telf = $user_data[ $repr.'_telf' ];
	}
	$solicitud = new Solicitud();
	$solicitud->set_solicitud_representante(
		$codigo_solicitud,
		$estudiante_per_codi,
		$user_data[ $repr.'_codi'], //vacío si es insert, lleno si es update.
		$user_data[ 'cmb_'.$repr.'_tipo_identificacion' ],
		$user_data[ $repr.'_numero_identificacion' ],
		$user_data[ $repr.'_nomb' ],
		$user_data[ $repr.'_nomb_seg' ],
		$user_data[ $repr.'_apel' ],
		$user_data[ $repr.'_apel_mat' ],
		$dir,
		$telf,
		$user_data[ $repr.'_email_personal' ],
		$user_data[ $repr.'_fecha_nac' ],
		$user_data[ 'cmb_pais_'.$repr.'_lugar_nac' ],
		$user_data[ 'cmb_provincia_'.$repr.'_lugar_nac' ],
		$user_data[ 'cmb_ciudad_'.$repr.'_lugar_nac' ],
		$user_data[ 'cmb_estado_civil_'.$repr ],
		$user_data[ 'cmb_profesion_'.$repr ],
		$user_data[ $repr.'_empr_codi' ],
		$user_data[ $repr.'_per_empr_codi' ],
		$user_data[ $repr.'_empr_nomb' ],
		$user_data[ $repr.'_empr_ruc' ],
		$user_data[ $repr.'_empr_dir' ],
		$user_data[ $repr.'_empr_cargo' ],
		$user_data[ $repr.'_empr_ingreso_mensual' ],
		$user_data[ $repr.'_empr_telf' ],
		$user_data[ $repr.'_empr_mail' ],
		$user_data[ 'ckb_'. $repr.'_es_exalumno' ],
		$user_data[ $repr.'_cmb_es_exalumno' ],
		$user_data[ 'ckb_'.$repr.'_es_extrabajador' ],
		$user_data[ $repr.'_es_extrabajador_fecha_ini' ],
		$user_data[ $repr.'_es_extrabajador_fecha_fin' ],
		$relacion,
		$_SESSION['peri_codi'],
		$_SERVER['HTTP_X_FORWARDED_FOR'], //éste último es IP.
		$_SERVER['REMOTE_ADDR']);
	return $solicitud;
}
function constructor_combo_regiones( $data, $curso = 0, $pais_nac = 'ECU', $prov_nac = 10, $ciudad_nac = 0, 
										$pais_cole = 'ECU', $prov_cole = 10, $ciudad_cole = 4376, $cole_anterior = 0 )
{   if ( $curso == '' )
		$curso = 0;
	if ( $pais_nac == '' )
		$pais_nac = 'ECU';
	if ( $prov_nac == '' )
		$prov_nac = 10;
	if ( $ciudad_nac == '' )
		$ciudad_nac = 0;
	if ( $pais_cole == '' )
		$pais_cole = 'ECU';
	if ( $prov_cole == '' )
		$prov_cole = 10;
	if ( $ciudad_cole == '' )
		$ciudad_cole = 4376;
	if ( $cole_anterior == '' )
		$cole_anterior = 0;

	$pais 			= new Region();
	$provincia 		= new Region();
	$ciudad 		= new Region();
	$ciudadColegio 	= new Region();
	$colegio		= new Colegio();
	$cursos			= new Solicitud();
	global $diccionario;
	$pais->get_PaisSelectFormat( );
	$provincia->get_CiudadDistritoSelectFormat( 'ECU' );
	$ciudad->get_CiudadSelectFormat( 'ECU', $prov_nac );
	$ciudadColegio->get_CiudadSelectFormat( 'ECU', $prov_cole );
	$colegio->get_ColegioSelectFormat( '', $ciudad_cole );
	$cursos->get_Cursos( );//$user_data['nivel_economico'] debe traer el nivel economico según lo solicitado. EDUCALINKS PENDIENTE
	$data['{cmb_curso_aplica}'] = array("elemento"  => 	"combo", 
										"datos"     => 	$cursos->rows, 
										"options"   => 	array(	"name"		=>"cmb_curso_aplica",
																"id"		=>"cmb_curso_aplica",
																"required"	=>"required",
																"class"		=>"form-control",
																"onChange"	=>	""),
										"selected"  => 	$curso);
	$data['{cmb_pais_per_lugar_nac}'] = array("elemento"  => 	"combo", 
									"datos"     => 	$pais->rows, 
									"options"   => 	array(	"name"		=>"cmb_pais_per_lugar_nac",
															"id"		=>"cmb_pais_per_lugar_nac",
															"required"	=>"required",
															"class"		=>"form-control",
															"onChange"	=> "js_region_cargaCiudadDistrito('div_ciudad_per_lugar_nac','div_provincia_per_lugar_nac','cmb_ciudad_per_lugar_nac','cmb_provincia_per_lugar_nac','cmb_pais_per_lugar_nac','".$diccionario['rutas_head']['ruta_html']."/region/controller.php')"),
									"selected"  => 	$pais_nac);
	$data['{cmb_provincia_per_lugar_nac}'] = array("elemento"  => 	"combo", 
									"datos"     => 	$provincia->rows,
									"options"   => 	array(	"name"		=>"cmb_provincia_per_lugar_nac",
															"id"		=>"cmb_provincia_per_lugar_nac",
															"required"	=>"required",
															"class"		=>"form-control",
															"onChange"	=>"js_region_cargaCiudad('div_ciudad_per_lugar_nac','cmb_ciudad_per_lugar_nac','cmb_provincia_per_lugar_nac','cmb_pais_per_lugar_nac','".$diccionario['rutas_head']['ruta_html']."/region/controller.php')"),
									"selected"  => 	$prov_nac);
	$data['{cmb_ciudad_per_lugar_nac}'] = array("elemento"  => 	"combo", 
									"datos"     => 	$ciudad->rows, 
									"options"   => 	array(	"name"		=>"cmb_ciudad_per_lugar_nac",
															"id"		=>"cmb_ciudad_per_lugar_nac",
															"required"	=>"required",
															"class"		=>"form-control",
															"onChange"	=>	""),
									"selected"  => 	$ciudad_nac);
	$data['{cmb_pais_colegio_anterior}'] = array(	"elemento"  => 	"combo", 
													"datos"     => 	$pais->rows, 
													"options"   => 	array(	"name"		=>"cmb_pais_colegio_anterior",
																			"id"		=>"cmb_pais_colegio_anterior",
																			"required"	=>"required",
																			"class"		=>"form-control",
																			"onChange"	=> "js_region_cargaCiudadDistrito('div_ciudad_colegio_anterior','div_provincia_colegio_anterior','cmb_ciudad_colegio_anterior','cmb_provincia_colegio_anterior','cmb_pais_colegio_anterior','".$diccionario['rutas_head']['ruta_html']."/region/controller.php')"),
													"selected"  => 	$pais_cole);
	$data['{cmb_provincia_colegio_anterior}'] = array(  "elemento"  => 	"combo", 
														"datos"     => 	$provincia->rows, 
														"options"   => 	array(	"name"		=>"cmb_provincia_colegio_anterior",
																				"id"		=>"cmb_provincia_colegio_anterior",
																				"required"	=>"required",
																				"class"		=>"form-control",
																				"onChange"	=>"js_region_cargaCiudad('div_ciudad_colegio_anterior','cmb_ciudad_colegio_anterior','cmb_provincia_colegio_anterior','cmb_pais_colegio_anterior','".$diccionario['rutas_head']['ruta_html']."/region/controller.php')"),
														"selected"  => 	$prov_cole);
	$data['{cmb_ciudad_colegio_anterior}'] = array( "elemento"  => 	"combo", 
													"datos"     => 	$ciudadColegio->rows, 
													"options"   => 	array(	"name"		=>"cmb_ciudad_colegio_anterior",
																			"id"		=>"cmb_ciudad_colegio_anterior",
																			"required"	=>"required",
																			"class"		=>"form-control",
																			"onChange"	=>	""),
													"selected"  => 	$ciudad_cole);
	$data['{cmb_colegio_anterior}'] = array("elemento"  => 	"combo", 
											"datos"     => 	$colegio->rows, 
											"options"   => 	array(	"name"		=>"cmb_colegio_anterior",
																	"id"		=>"cmb_colegio_anterior",
																	"required"	=>"required",
																	"class"		=>"form-control",
																	"onChange"	=>	""),
											"selected"  => 	$cole_anterior);
	return $data;
}
//EDUCALINKS PENDIENTE
function sub_constructor_formulario_repr_load($solicitud, $c, $data, $repr, $reprctrl )
{   $data = constructor_formulario_repr( $data, $repr, $reprctrl, 
		$solicitud->rows[$c]['per_codi'],
		$solicitud->rows[$c]['per_pais_nacionalidad'], 			$solicitud->rows[$c]['per_provincia'], 
		$solicitud->rows[$c]['per_ciudad'], 					$solicitud->rows[$c]['per_estado_civil'], 
		$solicitud->rows[$c]['per_profesion'],					$solicitud->rows[$c]['per_rel_de_p1_a_p2'],
		$solicitud->rows[$c]['per_tipo_id'],
		$solicitud->rows[$c]['per_id'],							$solicitud->rows[$c]['per_apel'], 
		$solicitud->rows[$c]['per_apel_mat'], 					$solicitud->rows[$c]['per_nomb'],
		$solicitud->rows[$c]['per_nomb_seg'], 					$solicitud->rows[$c]['per_dir_personal'],	
		$solicitud->rows[$c]['cont_det_numero'],				$solicitud->rows[$c]['per_email_personal'],
		$solicitud->rows[$c]['per_fecha_nac'], 					$solicitud->rows[$c]['soli_reprInfo_es_exalumno'], 	
		$solicitud->rows[$c]['soli_reprInfo_anho_promocion'],	$solicitud->rows[$c]['soli_reprInfo_es_extrabajador'],
		$solicitud->rows[$c]['soli_reprInfo_f_trabajo_desde'],	$solicitud->rows[$c]['soli_reprInfo_f_trabajo_hasta'],
		
		$solicitud->rows[$c]['empr_codi'],						$solicitud->rows[$c]['per_empr_codi'],
		$solicitud->rows[$c]['empr_nomb'],						$solicitud->rows[$c]['empr_ruc'],	
		$solicitud->rows[$c]['empr_dir'],						$solicitud->rows[$c]['empr_cargo'],
		$solicitud->rows[$c]['empr_ingreso_mensual'],			$solicitud->rows[$c]['empr_telf'],
		$solicitud->rows[$c]['empr_mail']);
		
	return $data;
}
function constructor_formulario_repr( $data, $repr, $repr_ctrl = "", $per_codi,
	$pais_nac = 'ECU', 	$prov_nac = 10, 			$ciudad_nac = 0, 
	$s_est_civil = 0, 	$s_profesion = 0, 			$repr_relacion = 0,
	$tipo_id="", 		$numero_id="",				$apel="",
	$apel_mat="", 		$nomb="", 					$nomb_seg="",
	$dir="", 			$telf="", 					$email_personal="",
	$fecha_nac="", 		$es_exalumno="", 			$exalumno_anho_promo="",
	$es_exworker="",	$exworker_f_ini="",			$exworker_f_fin="",
	
	$empr_codi="", 		$per_empr_codi="",
	$empr_nomb="", 		$empr_ruc="",				$empr_dir="",
	$empr_cargo="", 	$empr_ingreso_mensual="",
	$empr_telf="", 		$empr_mail="" )
{	
	global $diccionario;
	$profesion 		= new Profesion();
	$pais 			= new Region();
	$provincia 		= new Region();
	$ciudad 		= new Region();
	$estado_civil	= new Solicitud();
	$parentesco		= new Solicitud();
	$profesion->get_ProfesionSelectFormat( );
	$pais->get_PaisSelectFormat( );
	$provincia->get_CiudadDistritoSelectFormat($pais_nac);
	$ciudad->get_CiudadSelectFormat($pais_nac, $prov_nac);
	$estado_civil->get_Catalogo_by_idPadre(1);
	$parentesco->get_Catalogo_by_idPadre(2);
	if( $repr_ctrl == "" ) $repr_ctrl = $repr;
	
	/*-------------------------------------------------------------------------------------
		COMBO PARA REPRESENTANTES ADICIONALES, SELECCIONA RELACIÓN/PARENTESCO CON EL ESTUDIANTE
	  -------------------------------------------------------------------------------------*/
	  
	$data['{cmb_persona_relacion}'] = array("elemento"  => 	"combo", 
											"datos"     => 	$parentesco->rows, 
											"options"   => 	array(	"name"		=> "cmb_persona_relacion",
																	"id"		=> "cmb_persona_relacion",
																	"required"	=> "required",
																	"class"		=> "form-control",
																	"onChange"	=> ""),
											"selected"  =>  $repr_relacion );
															
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DEL NUEVO REPRESENTANTE
	  -------------------------------------------------------------------------------------*/
	$data['{cmb_pais_'.$repr_ctrl.'_lugar_nac}'] = array(	"elemento"  => 	"combo", 
															"datos"     => 	$pais->rows, 
															"options"   => 	array(	"name"		=>"cmb_pais_".$repr."_lugar_nac",
																					"id"		=>"cmb_pais_".$repr."_lugar_nac",
																					"required"	=>"required",
																					"class"		=>"form-control",
																					"onChange"	=> "js_region_cargaCiudadDistrito('div_ciudad_".$repr."_lugar_nac','div_provincia_".$repr."_lugar_nac','cmb_ciudad_".$repr."_lugar_nac','cmb_provincia_".$repr."_lugar_nac','cmb_pais_".$repr."_lugar_nac','".$diccionario['rutas_head']['ruta_html']."/region/controller.php')"),
															"selected"  => 	$pais_nac);
	$data['{cmb_provincia_'.$repr_ctrl.'_lugar_nac}'] = array(  "elemento"  => 	"combo", 
																"datos"     => 	$provincia->rows,
																"options"   => 	array(	"name"		=>"cmb_provincia_".$repr."_lugar_nac",
																						"id"		=>"cmb_provincia_".$repr."_lugar_nac",
																						"required"	=>"required",
																						"class"		=>"form-control",
																						"onChange"	=>	"js_region_cargaCiudad('div_ciudad_".$repr."_lugar_nac','cmb_ciudad_".$repr."_lugar_nac','cmb_provincia_".$repr."_lugar_nac','cmb_pais_".$repr."_lugar_nac','".$diccionario['rutas_head']['ruta_html']."/region/controller.php')"),
														"selected"  => 	$prov_nac);
	$data['{cmb_ciudad_'.$repr_ctrl.'_lugar_nac}'] = array( "elemento"  => 	"combo", 
															"datos"     => 	$ciudad->rows, 
															"options"   => 	array(	"name"		=>"cmb_ciudad_".$repr."_lugar_nac",
																					"id"		=>"cmb_ciudad_".$repr."_lugar_nac",
																					"required"	=>"required",
																					"class"		=>"form-control",
																					"onChange"	=>	""),
															"selected"  => 	$ciudad_nac);
	$data['{cmb_profesion_'.$repr_ctrl.'}'] = array("elemento"  => 	"combo", 
													"datos"     => 	$profesion->rows, 
													"options"   => 	array(	"name"		=>"cmb_profesion_".$repr,
																			"id"		=>"cmb_profesion_".$repr,
																			"required"	=>"required",
																			"class"		=>"form-control",
																			"onChange"	=>	""),
													"selected"  => 	$s_profesion);
	$data['{cmb_estado_civil_'.$repr_ctrl.'}'] = array( "elemento"  => 	"combo", 
														"datos"     => 	$estado_civil->rows, 
														"options"   => 	array(	"name"		=>"cmb_estado_civil_".$repr,
																				"id"		=>"cmb_estado_civil_".$repr,
																				"required"	=>"required",
																				"class"		=>"form-control",
																				"onChange"	=>	""),
													"selected"  => 	$s_est_civil);
	$cmb_ex_alum_disabled = "";
	if ( $es_exalumno == 1 )
	{   $data[ $repr_ctrl.'_es_exalumno_check'] = " checked ";
		$cmb_ex_alum_disabled = "";
	}	
	else
	{   $data[ $repr_ctrl.'_es_exalumno_check'] = "";
		$cmb_ex_alum_disabled = " disabled='disabled' ";
	}
	if ( $es_exworker == 1 )
	{   $data[ $repr_ctrl.'_es_exworker_check'] = " checked ";
		$data[ $repr_ctrl.'_exworker_fini_disabled'] = "";
		$data[ $repr_ctrl.'_exworker_ffin_disabled'] = "";
	}
	else
	{   $data[ $repr_ctrl.'_es_exworker_check'] = "";
		$data[ $repr_ctrl.'_exworker_fini_disabled'] = " disabled='disabled' ";
		$data[ $repr_ctrl.'_exworker_ffin_disabled'] = " disabled='disabled' ";
	}
	$repr_es_exalumno= "<select id='".$repr."_cmb_es_exalumno' name='".$repr."_cmb_es_exalumno' class='form-control' style='display:block;' ".$cmb_ex_alum_disabled." >
			<option value=''>Seleccione Año de promoción</option>";
	$last_y = date("Y");
	$first_y = 1949;//Año de la primera promoción del Colegio Americano (para quienes originalmente se hizo 'Admisiones').
	while( $first_y <= $last_y )
	{   $selected = "";
		if( $exalumno_anho_promo == $first_y )
			$selected = " selected='selected' ";
		$repr_es_exalumno.= "<option ".$selected." value='".$first_y."'>Año lectivo ".$first_y." - ".($first_y + 1)."</option>";
		$first_y++;
	}
	$repr_es_exalumno.= "
		</select>";
	/*-------------------------------------------------------------------------------------
		VARIABLES
	  -------------------------------------------------------------------------------------*/
	
	$data[ $repr_ctrl.'_codi'] = $per_codi;
	
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS PERSONALES DEL REPRESENTANTE
	  -------------------------------------------------------------------------------------*/
	
	$data['cmb_'.$repr_ctrl.'_tipo_identificacion'] = constructor_combo_tipo_id('cmb_'.$repr.'_tipo_identificacion', 1, $tipo_id);
	$data[ $repr_ctrl.'_numero_identificacion'] = $numero_id;
	$data[ $repr_ctrl.'_apel'] = $apel;
	$data[ $repr_ctrl.'_apel_mat'] = $apel_mat;
	$data[ $repr_ctrl.'_nomb'] = $nomb;
	$data[ $repr_ctrl.'_nomb_seg'] = $nomb_seg;
	$data[ $repr_ctrl.'_dir'] = $dir;
	$data[ $repr_ctrl.'_telf'] = $telf;
	$data[ $repr_ctrl.'_email_personal'] = $email_personal;
	$data[ $repr_ctrl.'_fecha_nac'] = $fecha_nac;
	$data['cmb_estado_civil_'.$repr_ctrl.'_selected'] = '';
	$data['cmb_profesion_'.$repr_ctrl.'_selected'] = '';
	$data[ $repr_ctrl.'_cmb_es_exalumno'] = $repr_es_exalumno;
	$data[ $repr_ctrl.'_es_extrabajador_fecha_ini'] = $exworker_f_ini; //falta checked
	$data[ $repr_ctrl.'_es_extrabajador_fecha_fin'] = $exworker_f_fin;
	
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE TRABAJO DEL NUEVO REPRESENTANTE
	  -------------------------------------------------------------------------------------*/
	
	$data[ $repr_ctrl.'_empr_codi'] = $empr_codi;
	$data[ $repr_ctrl.'_per_empr_codi'] = $per_empr_codi;
	$data[ $repr_ctrl.'_empr_nomb'] = $empr_nomb;
	$data[ $repr_ctrl.'_empr_ruc'] = $empr_ruc;
	$data[ $repr_ctrl.'_empr_dir'] = $empr_dir;
	$data[ $repr_ctrl.'_empr_cargo'] = $empr_cargo;
	$data[ $repr_ctrl.'_empr_ingreso_mensual'] = $empr_ingreso_mensual;
	$data[ $repr_ctrl.'_empr_telf'] = $empr_telf;
	$data[ $repr_ctrl.'_empr_mail'] = $empr_mail;
	
	$data['repr'] = $repr;
	return $data;
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
function construct_div_periodo ( $periodo )
{   global $diccionario;
	$i=0;
	$array1=array();
	$color = "purple,red,green,yellow,orange,maroon,blue,warning,gray,info,default";
	$colors = explode(",", $color);
	foreach ($periodo->rows as $row)
	{   if( !empty( $row ) && $row['peri_estado_2'] == 'Activo' )
		{   $array1[]= '
				<div class="{columna}">
					<div class="small-box bg-'.$colors[$i].'" id="div_peri'.$i.'" name="div_peri'.$i.'"">
						<div class="inner">
							<h3>'.$row['peri_descripcion'].'<sup style="font-size: 20px"></sup></h3>
							<p>Del: '.$row['peri_fechainicio'].' <!-- - Hasta: '.$row['peri_fechafin'].'--></p>
						</div>
						<div class="icon">
							<i class="ion ion-calendar"></i>
						</div>
						<a href="#" class="small-box-footer" onclick="change_periodo_2('.$row['peri_codigo'].',\''.$row['peri_descripcion'].'\',\''.$diccionario['rutas_head']['ruta_html'].'/general/controller.php\')">Haz clic aqu&iacute; <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>';
			$i++;
		}
	}
	if( $i == 0)
		$array1[]= '<div class="col-sm-12">No hay períodos creados en el sistema.</div>';
	$construct_table = '
	<div class="contenedor">
		<div align="center">'.genera_div_grid_por_columnas($array1, $i).
		  '
		</div>
	</div>';
	return $construct_table;
}
?>