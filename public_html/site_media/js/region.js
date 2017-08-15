// JavaScript Document
function js_region_cargaPais( div_ciudad, div_ciudaddistrito, div_pais, combo_nombre_pais, combo_nombre_ciudaddistrito, url )
{   "use strict";
    if( document.getElementById( combo_nombre_pais ) )
		var paisCodigo = document.getElementById( combo_nombre_pais ).value;
	else
		var paisCodigo = "-1";
    var ruta_imagenes = document.getElementById( 'ruta_imagenes' ).value;
    document.getElementById( div_pais ).innerHTML = '<div align="center" style="height:100%;"><img src="' + ruta_imagenes + '/ajax-loader.gif"/></div>';
    var data = new FormData();
    data.append( 'paisCodigo', paisCodigo );
    data.append( 'combo_nombre_ciudaddistrito', combo_nombre_ciudaddistrito );
    data.append( 'combo_nombre_pais', combo_nombre_pais );
    data.append( 'div_ciudad', div_ciudad );
    data.append( 'div_ciudaddistrito', div_ciudaddistrito );
    data.append( 'event', 'get_pais' );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState === 4 && xhr.status === 200){
            document.getElementById( div_pais ).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
function js_region_cargaCiudadDistrito( div_ciudad, div_ciudaddistrito, combo_nombre_ciudad, combo_nombre_ciudaddistrito, combo_nombre_pais, url )
{   "use strict";
    var paisCodigo = document.getElementById( combo_nombre_pais ).value;
	/*if( document.getElementById( combo_nombre_ciudaddistrito ) )
		var ciudadDistritoCodigo = document.getElementById( combo_nombre_ciudaddistrito ).value;
	else*/
		var ciudadDistritoCodigo = "-1";
	var ruta_imagenes = document.getElementById( 'ruta_imagenes' ).value;
    document.getElementById( div_ciudaddistrito ).innerHTML = '<div align="center" style="height:100%;"><img src="' + ruta_imagenes + '/ajax-loader.gif"/></div>';
    var data = new FormData();
    data.append( 'paisCodigo', paisCodigo );
    data.append( 'ciudadDistritoCodigo', ciudadDistritoCodigo );
    data.append( 'combo_nombre_ciudad', combo_nombre_ciudad );
    data.append( 'combo_nombre_ciudaddistrito', combo_nombre_ciudaddistrito );
    data.append( 'combo_nombre_pais', combo_nombre_pais );
    data.append( 'div_ciudad', div_ciudad );
    data.append( 'event', 'get_ciudaddistrito' );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState === 4 && xhr.status === 200){
            document.getElementById(div_ciudaddistrito).innerHTML=xhr.responseText;
			js_region_cargaCiudad( div_ciudad, combo_nombre_ciudad, combo_nombre_ciudaddistrito, combo_nombre_pais, url )
        }
    };
    xhr.send(data);
}
function js_region_cargaCiudad( div_ciudad, combo_nombre_ciudad, combo_nombre_ciudaddistrito, combo_nombre_pais, url )
{   "use strict";
    var paisCodigo = document.getElementById( combo_nombre_pais ).value;
	var ciudadDistritoCodigo = document.getElementById( combo_nombre_ciudaddistrito ).value;
	/*if( document.getElementById( combo_nombre_ciudad ) )
		var ciudadID = document.getElementById( combo_nombre_ciudad ).value;
	else*/
		var ciudadID = "-1";
	var ruta_imagenes = document.getElementById( 'ruta_imagenes' ).value;
    document.getElementById( div_ciudad ).innerHTML = '<div align="center" style="height:100%;"><img src="' + ruta_imagenes + '/ajax-loader.gif"/></div>';
    var data = new FormData();
    data.append( 'paisCodigo', paisCodigo );
    data.append( 'ciudadDistritoCodigo', ciudadDistritoCodigo );
    data.append( 'ciudadID', ciudadID );
    data.append( 'combo_nombre_ciudad', combo_nombre_ciudad );
    data.append( 'combo_nombre_ciudaddistrito', combo_nombre_ciudaddistrito );
    data.append( 'combo_nombre_pais', combo_nombre_pais );
    data.append( 'event', 'get_ciudad' );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState === 4 && xhr.status === 200){
            document.getElementById( div_ciudad ).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}