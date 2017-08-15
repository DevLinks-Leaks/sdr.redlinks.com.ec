function login(url)
{	var data = new FormData();
	data.append('event', 'index');
	data.append('username', document.getElementById('username').value);
	data.append('password', document.getElementById('password').value);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{	
		} 
	};
	xhr.send(data);
}
function change_periodo( url )
{	var data = new FormData();
	var select_periodo =document.getElementById('periodo_select');
	data.append('event', 'change_periodo');
	data.append('peri_codi', select_periodo.options[select_periodo.selectedIndex].value);
	data.append('peri_deta', select_periodo.options[select_periodo.selectedIndex].text);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   location.reload();
		} 
	};
	xhr.send(data);
}
function change_pass(username,url)
{	if (validarPass())
	{
		new_pass = document.getElementById('nueva_pass_add').value;
		if (confirm('¿Está seguro que desea cambiar su contraseña?'))
		{
			var data = new FormData();
			data.append('event', 'change_pass');
			data.append('username', username);
			data.append('newpass', new_pass);
			var xhr = new XMLHttpRequest();
			xhr.open('POST', url , true);
			xhr.onreadystatechange=function()
			{   if (xhr.readyState==4 && xhr.status==200)
				{	$.growl.notice({ title: "Admisiones informa:",message: "¡Contraseña actualizada!" });
					location.reload();
				} 
			};
			xhr.send(data);
		}
	}
}
function validarPass()
{	if (document.getElementById('nueva_pass_add').value.trim()=='')
	{	alert ('Ingrese una contraseña');
		return false;
	}
	if (document.getElementById('repetir_pass_add').value.trim()=='')
	{	alert ('Repita la contraseña');
		return false;
	}
	if (document.getElementById('nueva_pass_add').value!=document.getElementById('repetir_pass_add').value)
	{	alert ('Las contraseñas ingresadas no coinciden');
		return false;
	}
	return true;
}
function change_periodo_2( peri_codi, peri_deta, url )
{	var data = new FormData();
	var select_periodo =document.getElementById( 'periodo_select' );
	data.append('event', 'change_periodo' );
	data.append('peri_codi', peri_codi );
	data.append('peri_deta', peri_deta );
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById( 'div_periodo' ).style.display = 'none';
		    document.getElementById( 'div_opciones_principales' ).style.display = 'inline';
		} 
	};
	xhr.send(data);
}
function obtener_fecha_subfuncion(cuanto)
{   "use strict";
    var today = new Date();
    var dd = today.getDate() + cuanto;
    var mm = today.getMonth() + 1; //January is 0!

    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd;
    }
    if(mm<10){
        mm='0'+mm;
    }
    today = dd+'/'+mm+'/'+yyyy;
    return today;
}
function obtener_fecha(cuando)
{   "use strict";
    if(cuando=='ayer')
    {
        return obtener_fecha_subfuncion(-1);
    }
    if(cuando=='hoy')
    {
        return obtener_fecha_subfuncion(0);
    }
    if(cuando=='mañana')
    {
        return obtener_fecha_subfuncion(1);
    }
}
function check_fecha(){
    "use strict";
    var checked=document.getElementById('chk_fecha').checked;
    if(!checked)
    {
        document.getElementById('txt_fecha_ini').disabled = true;
        document.getElementById('txt_fecha_ini').value = '';
        document.getElementById('txt_fecha_fin').disabled = true;
        document.getElementById('txt_fecha_fin').value = '';
    }else
    {
        document.getElementById('txt_fecha_ini').disabled = false;
        document.getElementById('txt_fecha_fin').disabled = false;
        document.getElementById('txt_fecha_ini').value = obtener_fecha('ayer');
        document.getElementById('txt_fecha_fin').value = obtener_fecha('hoy');
    }
}
function valida_tipo_growl(str)
{   "use strict";
    var str1 =  str;
    var wordsToFind = ["¡exito!", "*¡exito!*"];
    if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
    {   str = str.replace("¡Exito!", "");
        $.growl.notice({ title: "Educalinks informa", message: str});
    }
    else
    {   wordsToFind = ["¡error!", "*¡error!*"];
        if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
        {   str = str.replace("¡Error!", "");
            $.growl.error({ title: "Educalinks informa", message: str});
        }
        else
        {   wordsToFind = ["¡advertencia!", "*¡advertencia!*"];
            if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
            {   str = str.replace("¡Advertencia!", "");
                $.growl.warning({ title: "Educalinks informa", message: str});
            }
            else
            {   $.growl({ title: "Educalinks informa", message: str});
            }
        }
    }
}
function js_general_resultado_sql(str)
{   "use strict";
    var str1 =  str;
    var wordsToFind = ["¡exito!", "*¡exito!*"];
    if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
    {   str = str.replace("¡Exito!", "");
        return 'exito';
    }
    else
    {   wordsToFind = ["¡error!", "*¡error!*"];
        if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
        {   str = str.replace("¡Error!", "");
            return 'error';
        }
        else
        {   wordsToFind = ["¡advertencia!", "*¡advertencia!*"];
            if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
            {   str = str.replace("¡Advertencia!", "");
                return 'advertencia';
            }
            else
            {   return 'nada';
            }
        }
    }
}