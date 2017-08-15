// JavaScript Document
function js_profesion_cargaProfesion( div_profesion, combo_nombre_profesion, url )
{   "use strict";
    if( document.getElementById( combo_nombre_profesion ) )
		var profesion_codi = document.getElementById( combo_nombre_profesion ).value;
	else
		var profesion_codi = "-1";
    var ruta_imagenes = document.getElementById( 'ruta_imagenes' ).value;
    document.getElementById( div_profesion ).innerHTML = '<div align="center" style="height:100%;"><img src="' + ruta_imagenes + '/ajax-loader.gif"/></div>';
    var data = new FormData();
    data.append( 'profesion_codi', profesion_codi );
    data.append( 'combo_nombre_profesion', combo_nombre_profesion );
    data.append( 'event', 'get_profesion' );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   document.getElementById( div_profesion ).innerHTML=xhr.responseText;
        }
		console.log(xhr.responseText);
    };
    xhr.send(data);
}