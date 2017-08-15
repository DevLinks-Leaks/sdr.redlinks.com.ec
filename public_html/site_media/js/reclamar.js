$(document).ready(function() {
	$("#tbl_roles").addClass( 'nowrap' ).DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": false,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{ "sWidth": "10%", "targets": [0] },
			{ "sWidth": "80%", "targets": [1] },
			{ "sWidth": "10%", "targets": [2] },
			{className: "dt-body-center", "targets": [0]},
			{className: "dt-body-left", "targets": [1]},
			{className: "dt-body-center"  , "targets": [2]}
		]
	});
});
// Consulta filtrada
//function js_rol_busca(busq,div,url){
function busca(busq,div,url){
	document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
	var data = new FormData();
	data.append('event', 'get_all_data');
	data.append('busq', busq);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
			$("#tbl_roles").DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": false,
				"ordering": true,
				"info": true,
				"autoWidth": false
			});
			//var table = $('#tbl_roles').DataTable();
			//table.column( '0:visible' ).order( 'asc' );
		} 
	};
	xhr.send(data);
}
function carga_edit(codigo,div,url)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
	var data = new FormData();
	data.append('event', 'get');
	data.append('codigo', codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
		}
	};
	xhr.send(data);
}
// Realiza la actualizacion de los datos en la BD
//function js_rol_edit(busq,div,url){
function edit(rol_codigo,div,url)
{   if(confirm("¿Está seguro que desea adquirir este premio?"))
	{   if(confirm("¿Segurísimo?"))
		{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
			document.getElementById('btn_editar').disabled = true;
			var puntos_mios = document.getElementById('hd_puntaje_personal').value;
			var puntos_menos = document.getElementById('puntos_menos_mod').value;
			var sobrante = puntos_mios - puntos_menos;
			hd_puntaje_personal
			var data = new FormData();
			data.append('event', 'edit');
			data.append('codigo', document.getElementById('codigo_mod').value);
			data.append('puntos', puntos_menos );
			var xhr = new XMLHttpRequest();
			xhr.open('POST', url , true);
			xhr.onreadystatechange=function()
			{   if (xhr.readyState==4 && xhr.status==200)
				{   console.log(xhr.responseText);
					var n = xhr.responseText.length;
					if (n > 0)
					{   valida_tipo_growl(xhr.responseText);
						if(xhr.responseText == '¡Exito! Premio reclamado correctamente')
						{   document.getElementById('head_with_puntaje').innerHTML = 'Puntaje  personal: ' + sobrante.toString();
							document.getElementById('hd_puntaje_personal').value =  puntos_mios - puntos_menos;
						}	
					}
					else
					{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." + xhr.responseText });
					}
					$('#modal_edit').modal('hide');
					document.getElementById('btn_editar').disabled = false;
					busca("",div,url);
				}
			};
			xhr.send(data);
		}
	}
}