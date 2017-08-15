 $(document).ready(function() {
	$("#tbl_interesados").DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": false,
		"ordering": true,
		"info": true,
		"autoWidth": false
	});
});
// Consulta filtrada
//function js_rol_busca(busq,div,url){
function busca(busq,div,url)
{   document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
	data.append('event', 'get_all_data');
	data.append('busq', busq);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
			$("#tbl_interesados").DataTable({
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
{   document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
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
// Carga el formulario para editar un registro
//function js_rol_carga_edit(codigo,div,url)
function carga_edit(codigo,div,url)
{   document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
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
function edit(interesado_codigo,div,url)
{   $('#btn_editar').removeAttr('data-dismiss');
	if (validate_upd())
	{	$('#btn_editar').attr('data-dismiss','modal');
		if(confirm("¿Está seguro que desea editar la información del interesado?"))
		{   document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
			var data = new FormData();
			data.append('event', 'edit');
			data.append('codigo', interesado_codigo);
			data.append('primer_nombre', document.getElementById('primer_nombre_mod').value);
			data.append('segundo_nombre', document.getElementById('segundo_nombre_mod').value);
			data.append('primer_apellido', document.getElementById('primer_apellido_mod').value);
			data.append('segundo_apellido', document.getElementById('segundo_apellido_mod').value);
			data.append('telefono', document.getElementById('telefono_mod').value);
			data.append('celular', document.getElementById('celular_mod').value);
			data.append('correo', document.getElementById('correo_mod').value);
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
		document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'set');
		data.append('primer_nombre', document.getElementById('primer_nombre_add').value);
		data.append('segundo_nombre', document.getElementById('segundo_nombre_add').value);
		data.append('primer_apellido', document.getElementById('primer_apellido_add').value);
		data.append('segundo_apellido', document.getElementById('segundo_apellido_add').value);
		data.append('telefono', document.getElementById('telefono_add').value);
		data.append('celular', document.getElementById('celular_add').value);
		data.append('correo', document.getElementById('correo_add').value);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   var n = xhr.responseText.length;
				if (n > 0)
				{   valida_tipo_growl(xhr.responseText);
				}
				else
				{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." + xhr.responseText });
				}
				busca("",div,url);
			} 
		};
		xhr.send(data);
	}
}
// Realiza la eliminacion del cliente en la BD
//function js_rol_del(codigo,div,url)
function del(codigo,div,url)
{   if(confirm("¿Está seguro que desea eliminar al interesado?"))
	{   document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
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
//Validar ingreso de interesado
function validate_in ()
{
	if ($.trim($('#primer_nombre_add').val())=="")
	{	alert ('Ingrese el primer nombre');		
		return false;
	}
	if ($.trim($('#primer_apellido_add').val())=="")
	{	alert ('Ingrese el primer apellido');		
		return false;
	}
	if ($.trim($('#telefono_add').val())=="" && 
		$.trim($('#celular_add').val())=="" && 
		$.trim($('#correo_add').val())=="")
	{	alert ('Ingrese al menos una forma de contacto (teléfono, celular o correo)');		
		return false;
	}
	return true;
}
//Validar actualización de interesado
function validate_upd ()
{
	if ($.trim($('#primer_nombre_mod').val())=="")
	{	alert ('Ingrese el primer nombre');		
		return false;
	}
	if ($.trim($('#primer_apellido_mod').val())=="")
	{	alert ('Ingrese el primer apellido');		
		return false;
	}
	if ($.trim($('#telefono_mod').val())=="" && 
		$.trim($('#celular_mod').val())=="" && 
		$.trim($('#correo_mod').val())=="")
	{	alert ('Ingrese al menos una forma de contacto (teléfono, celular o correo)');		
		return false;
	}
	return true;
}