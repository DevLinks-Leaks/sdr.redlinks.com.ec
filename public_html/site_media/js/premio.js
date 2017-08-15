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
	var ruta_imagenes=document.getElementById('ruta_imagenes').value;
	document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
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
// Carga el formulario para ingresar un nuevo registro
//function js_rol_carga_add(busq,div,url){
function carga_add(div,url)
{   var ruta_imagenes=document.getElementById('ruta_imagenes').value;
	document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
	data.append('event', 'agregar');	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
			$("#puntos_add").numeric({ decimal : false,  negative : false, precision: 3 });
		}
	};
	xhr.send(data);
}
// Carga el formulario para editar un registro
function carga_edit(codigo,div,url)
{   var ruta_imagenes=document.getElementById('ruta_imagenes').value;
	document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
	data.append('event', 'get');
	data.append('codigo', codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
			$("#puntos_mod").numeric({ decimal : false,  negative : false, precision: 3});
		}
	};
	xhr.send(data);
}
// Realiza la actualizacion de los datos en la BD
//function js_rol_edit(busq,div,url){
function edit(rol_codigo,div,url)
{   $('#btn_editar').removeAttr('data-dismiss');
	if (validar_upd())
	{	$('#btn_editar').attr('data-dismiss','modal');
		if(confirm("¿Está seguro que desea editar la información del premio?"))
		{   var ruta_imagenes=document.getElementById('ruta_imagenes').value;
			document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
			var data = new FormData();
			data.append('event', 'edit');
			data.append('codigo', document.getElementById('codigo_mod').value);
			data.append('descripcion', document.getElementById('descripcion_mod').value);
			data.append('puntos', document.getElementById('puntos_mod').value);
			var xhr = new XMLHttpRequest();
			xhr.open('POST', url , true);
			xhr.onreadystatechange=function()
			{   if (xhr.readyState==4 && xhr.status==200)
				{   console.log(xhr.responseText);
					busca("",div,url);
				}
			};
			xhr.send(data);
		}
	}
}
// Realiza el ingreso de un registro nuevo
//function js_rol_add(div,url)
function add(div,url)
{   $('#btn_guardar').removeAttr('data-dismiss');
	if (validar_in())
	{	$('#btn_guardar').attr('data-dismiss','modal');
		var ruta_imagenes=document.getElementById('ruta_imagenes').value;
		document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'set');
		data.append('descripcion', document.getElementById('descripcion_add').value);
		data.append('puntos', document.getElementById('puntos_add').value);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   busca("",div,url);
			} 
		};
		xhr.send(data);
	}
}
// Realiza la eliminacion del cliente en la BD
//function js_rol_del(codigo,div,url)
function del(codigo,div,url)
{   
	if(confirm("¿Está seguro que desea eliminar el premio?"))
	{   var ruta_imagenes=document.getElementById('ruta_imagenes').value;
		document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('codigo', codigo);	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   busca("",div,url)
			} 
		};
		xhr.send(data);
	}
}
//Validar ingreso de rol
function validar_in()
{	if ($.trim($('#descripcion_add').val())=="")
	{	alert ('Ingrese la descripción del premio');
		return false;
	}
	if ($.trim($('#puntos_add').val())=="")
	{	alert ('Ingrese los puntos del premio');
		return false;
	}
	return true;
}
//Validar actualización de rol
function validar_upd()
{	if ($.trim($('#descripcion_mod').val())=="")
	{	alert ('Ingrese la descripción del premio');
		return false;
	}
	if ($.trim($('#puntos_mod').val())=="")
	{	alert ('Ingrese los puntos del premio');
		return false;
	}
	return true;
}