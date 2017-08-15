// JavaScript Document
$(document).ready(function() {
	js_docAdmin_datatable_documentos_table();
	$('#ModalDocuAdd').on('hidden.bs.modal', function (){
		document.getElementById('docu_descr_nuev').value="";
	});
});
function js_docAdmin_edit(docu_codi)
{   document.getElementById('docu_descr_edi').value=document.getElementById('docu_descr_edi_'+docu_codi).value;
	document.getElementById('docu_codi_edi').value=document.getElementById('docu_codi_edi_'+docu_codi).value;
}
function js_docAdmin_event_del(div, url, opc, docu_descr, peri_codi, docu_codi, docu_peri_codi, check)
{   if(confirm("¿Está seguro que desea eliminar el Documento?"))
	{   js_docAdmin_event(div, url, opc, docu_descr, peri_codi, docu_codi, docu_peri_codi, check, null);
	}
}
function js_docAdmin_event(div, url, opc, docu_descr, peri_codi, docu_codi, docu_peri_codi, check, this_modal)
{   document.getElementById('btn_docuAdmin_add').disabled = true;
	var data = new FormData();
	data.append('event', opc);
	data.append('docu_descr', docu_descr);
	data.append('peri_codi', peri_codi);
	data.append('docu_codi', docu_codi);
	data.append('docu_peri_codi', docu_peri_codi);
	data.append('check', check);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   var n = xhr.responseText.length;
			if (n > 0)
			{   valida_tipo_growl(xhr.responseText);
				if (js_general_resultado_sql(xhr.responseText)=='exito')
				{	if(this_modal)
					{   $('#'+this_modal).modal('hide');
					}
					js_docAdmin_get_all(div,url);
				}
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
				if(this_modal)
				{   $('#'+this_modal).modal('hide');
				}
				js_docAdmin_get_all(div,url);
			}
		}
		document.getElementById('btn_docuAdmin_add').disabled = false;
	};
	xhr.send(data);
}
function js_docAdmin_get_all(div, url)
{   var ruta_imagenes = document.getElementById( 'ruta_imagenes' ).value;
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="'+ruta_imagenes+'/ajax-loader.gif"/></div>';
	var data = new FormData();
	var peri_codi = document.getElementById('cmb_periodo').value;
	data.append('event', 'get_all_data');
	data.append('peri_codi', peri_codi);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   if (xhr.responseText.length > 0)
			{   document.getElementById(div).innerHTML = xhr.responseText;
				js_docAdmin_datatable_documentos_table();
			}
		}
	};
	xhr.send(data);
}
function js_docAdmin_datatable_documentos_table()
{   $('#documentos_table').DataTable({
		"bPaginate": true,
		"bStateSave": false,
		"bAutoWidth": false,
		"bScrollAutoCss": true,
		"bProcessing": true,
		"bRetrieve": true,
		"sDom": '<"H"CTrf>t<"F"lip>',
		"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
		"sScrollXInner": "110%",
		"fnInitComplete": function() {
			this.css("visibility", "visible");
		},
		paging: true,
		lengthChange: true,
		searching: true,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{className: "dt-body-center" , "targets": [0]},
			{className: "dt-body-left"   , "targets": [1]},
			{className: "dt-body-center" , "targets": [2]},
			{className: "dt-body-center" , "targets": [3]},
			{className: "dt-body-center" , "targets": [4]}
		]
	});
}
function js_docAdmin_get_documentos_periodo_actual( div, url, deband )
{	var id_solicitud = document.getElementById('hd_id_solicitud').value;
	var ruta_imagenes = document.getElementById('ruta_imagenes').value;
	document.getElementById( div ).innerHTML = '<div align="center" style="height:100%;"><img src="'+ruta_imagenes+'/ajax-loader.gif"/></div>';
	var data = new FormData();
	data.append( 'event' , 'get_tab_documentos' );
	data.append( 'id_solicitud' , id_solicitud );
	data.append( 'deband' , deband );
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , url , true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{	document.getElementById( div ).innerHTML = xhr.responseText;
		}
	};
	xhr.send(data);
}
function js_docAdmin_get_documentos_periodo_actual_2( div, url, id_solicitud ) //Usado para llamar los documentos desde las bandejas generales.
{	var ruta_imagenes = document.getElementById('ruta_imagenes').value;
	document.getElementById( div ).innerHTML = '<div align="center" style="height:100%;"><img src="'+ruta_imagenes+'/ajax-loader.gif"/></div>';
	var data = new FormData();
	data.append( 'event' , 'get_tab_documentos' );
	data.append( 'id_solicitud' , id_solicitud );
	data.append( 'deband' , 2 );
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , url , true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{	document.getElementById( div ).innerHTML = xhr.responseText;
		}
	};
	xhr.send(data);
}
function js_docAdmin_subir_sintesis( soli_codi, num_soli, modal, url )
{   if ( confirm( "¿Subir síntesis?" ) )
	{   //var file_data = document.getElementById( 'ftu_sint_docu_file' ).prop('files')[0];
		var file_data = document.getElementById( 'ftu_sint_docu_file' ).files[0];
		var soli_sint_docu_desc = document.getElementById( 'txt_sint_docu_desc' ).value;
		var data = new FormData();
		data.append( 'event' , 'sint_sube' );
		data.append( 'soli_codi' , soli_codi );
		data.append( 'num_soli' , num_soli );
		data.append( 'soli_sint_docu_desc' , soli_sint_docu_desc );
		
		data.append( 'file', file_data );
		//alert (soli_codi);
		var xhr = new XMLHttpRequest();
		xhr.open( 'POST' , url , true );
		xhr.upload.onprogress = function(e)
		{   if ( e.lengthComputable )
			{   var percentComplete = ( e.loaded / e.total ) * 100;
				console.log( percentComplete + '% uploaded' );
			}
		};
		xhr.onreadystatechange = function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{	var n = xhr.responseText.length;
				if ( n > 0 )
				{   valida_tipo_growl( xhr.responseText );
				}
				else
				{   $.growl.warning( { title: "Educalinks informa:", message: "Proceso realizado." } );
				}
				js_docAdmin_ver_sintesis( soli_codi, 'modal_subir_archivo_bandeja', url );
				document.getElementById( 'ftu_sint_docu_file' ).value = "";
				document.getElementById( 'txt_sint_docu_desc' ).value = "";
			}
		};
		xhr.send(data);	
	}
}
function js_docAdmin_ver_sintesis( soli_codi, div_modal, url )
{   var ruta_imagenes = document.getElementById( 'ruta_imagenes' ).value;
	document.getElementById( div_modal ).innerHTML='<div align="center" style="height:100%;"><img src="'+ruta_imagenes+'/ajax-loader.gif"/></div>';
	var data = new FormData();
	data.append( 'event' , 'sint_baja' );
	data.append( 'soli_codi' , soli_codi );
	var xhr = new XMLHttpRequest();
	xhr.open( 'POST' , url , true );
	xhr.onreadystatechange = function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{	var n = xhr.responseText.length;
			if ( n > 0 )
			{   document.getElementById( div_modal ).innerHTML = xhr.responseText;
			}
			else
			{   $.growl.warning( { title: "Educalinks informa:", message: "No se ha obtenido resultado del sistema." } );
			}
		}
	};
	xhr.send(data);	
}
function js_docAdmin_sintesis_borrar( soli_codi, soli_sint_codi, div_modal, url )
{   if ( confirm( "¿Borrar síntesis?" ) )
	{   var ruta_imagenes = document.getElementById( 'ruta_imagenes' ).value;
		document.getElementById( div_modal ).innerHTML='<div align="center" style="height:100%;"><img src="'+ruta_imagenes+'/ajax-loader.gif"/></div>';
		var data = new FormData();
		data.append( 'event' , 'sint_borra' );
		data.append( 'soli_codi' , soli_codi );
		data.append( 'soli_sint_codi' , soli_sint_codi );
		var xhr = new XMLHttpRequest();
		xhr.open( 'POST' , url , true );
		xhr.onreadystatechange = function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{	var n = xhr.responseText.length;
				if ( n > 0 )
				{   valida_tipo_growl( xhr.responseText );
					js_docAdmin_ver_sintesis( soli_codi, div_modal, url );
				}
				else
				{   $.growl.warning( { title: "Educalinks informa:", message: "No se ha obtenido resultado del sistema." } );
				}
			}
		};
		xhr.send(data);
	}
}
function js_docAdmin_subir_documentos( docu_peri_codi, per_codi, peri_codi, deband, div, url )
{   if ( confirm( "¿Subir documento?" ) )
	{   var file_data = document.getElementById( 'input_file_' + docu_peri_codi ).files[0];
		var data = new FormData();
		data.append( 'event' , 'doc_sube' );
		data.append( 'per_codi' , per_codi );
		data.append( 'peri_codi' , peri_codi );
		data.append( 'docu_peri_codi' , docu_peri_codi );
		data.append( 'file', file_data );
		var xhr = new XMLHttpRequest();
		xhr.open( 'POST' , url , true );
		xhr.upload.onprogress = function(e)
		{   if ( e.lengthComputable )
			{   var percentComplete = ( e.loaded / e.total ) * 100;
				console.log( percentComplete + '% uploaded' );
			}
		};
		xhr.onreadystatechange = function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{	var n = xhr.responseText.length;
				if ( n > 0 )
				{   valida_tipo_growl( xhr.responseText );
					js_docAdmin_get_documentos_periodo_actual( div, url, deband ) //actualiza bandeja de documentos requeridos.
				}
				else
				{   $.growl.warning( { title: "Educalinks informa:", message: "Proceso realizado." } );
				}
			}
		};
		xhr.send(data);	
	}
}
function js_docAdmin_validar_documento( docu_peri_codi, per_codi, deband, check, div, url )
{   var data = new FormData();
	data.append( 'event' , 'check_valido' );
	data.append( 'check' , check );
	data.append( 'per_codi' , per_codi );
	data.append( 'docu_peri_codi' , docu_peri_codi );
	var xhr = new XMLHttpRequest();
	xhr.open( 'POST' , url , true );
	xhr.onreadystatechange = function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{	var n = xhr.responseText.length;
			if ( n > 0 )
			{   valida_tipo_growl( xhr.responseText );
				js_docAdmin_get_documentos_periodo_actual( div, url, deband ) //actualiza bandeja de documentos requeridos.
			}
			else
			{   $.growl.warning( { title: "Educalinks informa:", message: "Proceso realizado." } );
			}
		}
	};
	xhr.send(data);
}