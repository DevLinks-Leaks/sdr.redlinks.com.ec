 $(document).ready(function() {
	$("#tbl_permisos").addClass( 'nowrap' ).DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": false,
		"pageLength": 15,
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
function busca(rol_codigo,div,url){
	var ruta_imagenes=document.getElementById('ruta_imagenes').value;
	document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
	data.append('event', 'get_all_data');
	data.append('rol_codigo', rol_codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
			$("#tbl_permisos").DataTable({
				"paging": true,
				"pageLength": 15,
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
function carga_rol_permisos(rol_codigo,div,url)
{   var ruta_imagenes=document.getElementById('ruta_imagenes').value;
	document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
	data.append('event', 'get_all_data');	
	data.append('rol_codigo', rol_codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   //document.getElementById(div).innerHTML=xhr.responseText;
			busca(rol_codigo,div,url);
		}
	};
	xhr.send(data);
}
function insertar_rol_permisos(rol_codigo,div,url)
{   var ruta_imagenes=document.getElementById('ruta_imagenes').value;
	document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
	data.append('event', 'get_all_data');	
	data.append('rol_codigo', rol_codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   //document.getElementById(div).innerHTML=xhr.responseText;
			busca(rol_codigo,div,url);
		}
	};
	xhr.send(data);
}