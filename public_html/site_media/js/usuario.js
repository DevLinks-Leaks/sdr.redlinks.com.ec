 $(document).ready(function() {
	$("#tbl_usuarios").addClass( 'nowrap' ).DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": false,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{className: "dt-body-center", "targets": [0]},
			{className: "dt-body-center", "targets": [1]},
			{className: "dt-body-center", "targets": [2]},
			{className: "dt-body-center", "targets": [3]},
			{className: "dt-body-center", "targets": [4]},
			{className: "dt-body-center", "targets": [5]},
			{className: "dt-body-center", "targets": [6]},
			{ "sWidth": "10%", "targets": [6] }
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
			$("#tbl_usuarios").DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": false,
				"ordering": true,
				"info": true,
				"autoWidth": false
			});
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
		}
	};
	xhr.send(data);
}
//Verificar si existe el nombre de usuario
function check_username(username,div,url)
{   //var ruta_imagenes=document.getElementById('ruta_imagenes').value;
	//document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
	data.append('event', 'check_username');	
	data.append('username', username);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   $("#check_username").removeClass("has-success");
			$("#check_username").removeClass("has-error");
			$("#check_username").addClass(xhr.responseText);
			if (username=="")
				$("#check_username").removeClass(xhr.responseText);
		}
	};
	xhr.send(data);
}
// Carga el formulario para editar un registro
//function js_rol_carga_edit(codigo,div,url)
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
		}
	};
	xhr.send(data);
}
// Realiza la actualizacion de los datos en la BD
//function js_rol_edit(busq,div,url){
function edit(usua_codigo,div,url)
{   $('#btn_editar').removeAttr('data-dismiss');
	if (validate_upd())
	{	$('#btn_editar').attr('data-dismiss','modal');
		if(confirm("¿Está seguro que desea editar la información del usuario?"))
		{   var ruta_imagenes=document.getElementById('ruta_imagenes').value;
			document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
			var data = new FormData();
			data.append('event', 'edit');
			data.append('usua_codigo', usua_codigo);
			data.append('usua_nombres', document.getElementById('nombres_mod').value);
			data.append('usua_apellidos', document.getElementById('apellidos_mod').value);
			data.append('usua_correo', document.getElementById('correo_mod').value);
			data.append('rol_codigo', document.getElementById('cmb_roles_mod').value);
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
}
// Realiza el ingreso de un registro nuevo
//function js_rol_add(div,url)
function add(div,url)
{   $('#btn_guardar').removeAttr('data-dismiss');
	if (validate_in())
	{	$('#btn_guardar').attr('data-dismiss','modal');
		var ruta_imagenes=document.getElementById('ruta_imagenes').value;
		document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'set');
		data.append('usua_codigo', document.getElementById('username_add').value);
		data.append('usua_nombres', document.getElementById('nombres_add').value);
		data.append('usua_apellidos', document.getElementById('apellidos_add').value);
		data.append('usua_correo', document.getElementById('correo_add').value);
		data.append('rol_codigo', document.getElementById('cmb_roles_add').value);
		
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
{   if(confirm("¿Está seguro que desea eliminar el usuario?"))
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
//Validar ingreso
function validate_in ()
{
	if ($.trim($('#nombres_add').val())=="")
	{	alert ('Ingrese los nombres del usuario');
		return false;
	}
	if ($.trim($('#apellidos_add').val())=="")
	{	alert ('Ingrese los apellidos del usuario');
		return false;
	}
	if ($.trim($('#correo_add').val())=="")
	{	alert ('Ingrese el correo del usuario');
		return false;
	}
	if (!$('#check_username').hasClass('has-success'))
	{	alert ('El nombre de usuario no es válido');
		return false;
	}
	return true;
}
//Validar actualización
function validate_upd ()
{
	if ($.trim($('#nombres_mod').val())=="")
	{	alert ('Ingrese los nombres del usuario');
		return false;
	}
	if ($.trim($('#apellidos_mod').val())=="")
	{	alert ('Ingrese los apellidos del usuario');
		return false;
	}
	if ($.trim($('#correo_mod').val())=="")
	{	alert ('Ingrese el correo del usuario');
		return false;
	}
	return true;
}