function js_menu_inicio_empleado( )
{   var url =  '../general/';
	var f = document.createElement('form');
	f.action = url;
	f.method = 'POST';
	//f.target = '_blank';
	var i = document.createElement( 'input' );
	i.type = 'hidden';
	i.name = 'event';
	i.id = 'event';
	i.value = 'index_empleados';
	f.appendChild(i);
	document.body.appendChild(f);
	f.submit();
}