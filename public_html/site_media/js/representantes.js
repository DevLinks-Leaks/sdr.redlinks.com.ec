$(document).ready(function() {
	$(".detalle").tooltip({
		'html': 		true,
        'selector': 	'',
        'placement': 	'bottom',
        'container': 	'body',
		'tooltipClass': 'detalleTooltip'
    });
});
function carga_tabla_asign_repr(codigo,div,url){
    var ruta_imagenes=document.getElementById('ruta_imagenes').value;
    document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="'+ruta_imagenes+'/ajax-loader.gif"/></div>';
    var data = new FormData();
    data.append('event', 'asignar');
    data.append('alum_codi', codigo);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200){
            document.getElementById(div).innerHTML=xhr.responseText;
			$('#tabla_asigna_repr').addClass('nowrap').DataTable({
				lengthChange: false, 
				responsive: true, 
				searching: false,
				orderClasses: false,
				paging:false,
				//"scrollX": '100%',
				bInfo: false,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{className: "dt-body-center" , "targets": [0]},
					{className: "dt-body-center" , "targets": [1]},
					{className: "dt-body-center" , "targets": [2]},
					{className: "dt-body-center" , "targets": [3]},
					{className: "dt-body-center" , "targets": [4]},
					{className: "dt-body-center" , "targets": [5]},
					{className: "dt-body-center" , "targets": [6]}
						
				]
			});
			var table_fac = $('#tabla_asigna_repr').DataTable();
			table_fac.column( '2:visible' ).order( 'asc' );
        }
    };
    xhr.send(data);
}
function js_representantes_repr_upd_princ(div,url,alum_codi,repr_cedu)
{	//document.getElementById(div).innerHTML='';
	var data = new FormData();
    data.append('event', 'upd_repr_princ');
    data.append('repr_cedu', repr_cedu);
    data.append('alum_codi', alum_codi);
	var xhr = new XMLHttpRequest();
	xhr.open("POST",url,true);
	xhr.onreadystatechange=function()
	{	if (xhr.readyState==4 && xhr.status==200)
		{	var n = xhr.responseText.length;
			if (n > 0)
			{   valida_tipo_growl(xhr.responseText);
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
			}
		}
	};
	xhr.send(data);	
}
function js_representantes_repr_upd_princ_finan(div,url,alum_codi,repr_cedu)
{	//document.getElementById(div).innerHTML='';
	var data = new FormData();
    data.append('event', 'upd_repr_princ_finan');
    data.append('repr_cedu', repr_cedu);
    data.append('alum_codi', alum_codi);
	var xhr = new XMLHttpRequest();
	xhr.open("POST",url,true);
	xhr.onreadystatechange=function()
	{	if (xhr.readyState==4 && xhr.status==200)
		{	var n = xhr.responseText.length;
			if (n > 0)
			{   valida_tipo_growl(xhr.responseText);
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
			}
		}
	};
	xhr.send(data);	
}
////////////////////////TABLA PERSONA
function js_representantes_get_representantes( codigo, div, url, toggle_opc )
{   var ruta_imagenes=document.getElementById('ruta_imagenes').value;
    document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="'+ruta_imagenes+'/ajax-loader.gif"/></div>';
    var data = new FormData();
    data.append('event', 'get_representantes');
    data.append('alum_codi', codigo);
    data.append('toggle_opc', toggle_opc);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200){
            document.getElementById(div).innerHTML=xhr.responseText;
			$('#tabla_asigna_repr').addClass('nowrap').DataTable({
				lengthChange: false, 
				responsive: true, 
				searching: false,
				orderClasses: false,
				paging:false,
				//"scrollX": '100%',
				bInfo: false,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{className: "dt-body-center" , "targets": [0]},
					{className: "dt-body-center" , "targets": [1]},
					{className: "dt-body-center" , "targets": [2]},
					{className: "dt-body-center" , "targets": [3]},
					{className: "dt-body-center" , "targets": [4]},
					{className: "dt-body-center" , "targets": [5]}
						
				]
			});
			var table_fac = $('#tabla_asigna_repr').DataTable();
			table_fac.column( '1:visible' ).order( 'asc' );
        }
    };
    xhr.send(data);
}
function js_representantes_set_repr_acad( div, url, alum_codi, repr_codi, relacion )
{	var data = new FormData();
    data.append('event', 'set_repr_acad');
    data.append('alum_codi', alum_codi);
    data.append('repr_codi', repr_codi);
    data.append('relacion', relacion);
	var xhr = new XMLHttpRequest();
	xhr.open("POST",url,true);
	xhr.onreadystatechange=function()
	{	if (xhr.readyState==4 && xhr.status==200)
		{	var n = xhr.responseText.length;
			if (n > 0)
			{   valida_tipo_growl(xhr.responseText);
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
			}
		}
	};
	xhr.send(data);	
}

function js_representantes_set_repr_finan( div, url, alum_codi, repr_codi, relacion )
{	var data = new FormData();
    data.append('event', 'set_repr_finan');
    data.append('alum_codi', alum_codi);
    data.append('repr_codi', repr_codi);
    data.append('relacion', relacion);
	var xhr = new XMLHttpRequest();
	xhr.open("POST",url,true);
	xhr.onreadystatechange=function()
	{	if (xhr.readyState==4 && xhr.status==200)
		{	var n = xhr.responseText.length;
			if (n > 0)
			{   valida_tipo_growl(xhr.responseText);
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
			}
		}
	};
	xhr.send(data);	
}
function js_representantes_upd_fact_por_aut(div,alum_codi,url)
{	if(confirm("¿Está seguro de querer actualizar TODAS las facturas por autorizar y deudas generadas hasta ahora?"))
	{	var ruta_imagenes=document.getElementById('ruta_imagenes').value;
		document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><small><i>Procesando pedido, por favor espere... </i></small><img src="'+ruta_imagenes+'/ajax-loader.gif"/></div>';
		var data = new FormData();
		data.append('event', 'upd_facturas_por_autorizar');
		data.append('alum_codi', alum_codi);
		var xhr = new XMLHttpRequest();
		xhr.open("POST",url,true);
		xhr.onreadystatechange=function()
		{	if (xhr.readyState==4 && xhr.status==200)
			{	var n = xhr.responseText.length;
				if (n > 0)
				{   valida_tipo_growl(xhr.responseText);
				}
				else
				{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
				}
				document.getElementById(div).innerHTML="";
			}
		};
		xhr.send(data);
	}
}
function js_representantes_delete_repr_relacion( alum_codi, repr_codi, url )
{	if( confirm( "¿Está seguro de querer eliminar la relación con esta persona? Asegúreses de haber guardado todos los cambios en la solicitud." ) )
	{	var data = new FormData();
		data.append( 'event', 'delete_repr_relacion' );
		data.append( 'alum_codi', alum_codi );
		data.append( 'repr_codi', repr_codi );
		var xhr = new XMLHttpRequest();
		xhr.open( "POST", url, true );
		xhr.onreadystatechange=function()
		{	if ( xhr.readyState === 4 && xhr.status === 200 )
			{	var n = xhr.responseText.length;
				if ( n > 0 )
				{   valida_tipo_growl( xhr.responseText );
				}
				else
				{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
				}
				alert( "Para poder ver los cambios realizados en los registros, por favor, cierre y vuelva a abrir la solicitud.");
			}
		};
		xhr.send( data );
	}
}