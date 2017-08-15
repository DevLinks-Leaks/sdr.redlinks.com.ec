// JavaScript Document
$(document).ready(function()
{   $('[data-toggle="popover"]').popover({html:true});
	$('#modal_balance').on('shown', function() {
       
    });
})
function js_adminPeriodos_open (mes, mes_codigo)
{   document.getElementById('hd_mes_codigo').value = mes_codigo;
	document.getElementById('span_mes_open').innerHTML = mes;
	document.getElementById('txt_ini_pts_open').value = 10;
}
function js_adminPeriodos_open_followed ()
{   if(confirm("¿Está seguro que desea abrir el mes de "+document.getElementById('span_mes_open').innerHTML+"?"))
	{   $('#modal_open').modal('hide');
		var data = new FormData();
		data.append('event', 'open_month');
		data.append('mes', document.getElementById('hd_mes_codigo').value);
		data.append('puntaje', document.getElementById('txt_ini_pts_open').value);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', document.getElementById("ruta_html").value + '/adminPeriodos/controller.php' , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   var n = xhr.responseText.length;
				if (n > 0)
				{   valida_tipo_growl(xhr.responseText);
				}
				else
				{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." + xhr.responseText });
				}
				js_adminPeriodos_carga_meses();
			} 
		};
		xhr.send(data);
	}
}
function js_adminPeriodos_close( mes, mes_codigo )
{   if(confirm("¿Está seguro que desea cerrar el mes de " + mes + "?"))
	{   var data = new FormData();
		data.append('event', 'close_month');
		data.append('mes', mes_codigo);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', document.getElementById("ruta_html").value + '/adminPeriodos/controller.php' , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   var n = xhr.responseText.length;
				if (n > 0)
				{   valida_tipo_growl(xhr.responseText);
				}
				else
				{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." + xhr.responseText });
				}
				js_adminPeriodos_carga_meses();
			} 
		};
		xhr.send(data);
	}
}
function js_adminPeriodos_carga_meses(  )
{   document.getElementById( 'resultado' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div>';
	document.getElementById( 'span_return_meses' ).innerHTML = "";
	document.getElementById( 'span_mes_estado' ).innerHTML = "";
    var data = new FormData();
	data.append('event', 'get_all_data');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', document.getElementById("ruta_html").value + '/adminPeriodos/controller.php' , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById( 'resultado' ).innerHTML = xhr.responseText;
		} 
	};
	xhr.send(data);
}
function js_adminPeriodos_carga_meses_puntaje( mes_codigo, mes, estado )
{   document.getElementById( 'resultado' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	document.getElementById( 'hd_mes_bandeja' ).value = mes_codigo;
	document.getElementById( 'hd_mes_bandeja_nombre' ).value = mes;
	document.getElementById( 'hd_mes_estado' ).value = estado;
	document.getElementById( 'span_mes_estado' ).innerHTML = '<b>' + mes + '.</b> Mes ' + estado +
		((estado == 'cerrado') ? ' (no se puede modificar puntaje)' : '') + '.';
	document.getElementById( 'span_return_meses' ).innerHTML = '<button class="btn btn-warning" type="button" onclick="js_adminPeriodos_carga_meses(  );">'+
		'<span class="fa fa-angle-left"></span>&nbsp;Volver</button>';
    var data = new FormData();
	data.append('event', 'get_all_data_puntaje');
	data.append('mes', mes_codigo );
	data.append('estado', estado );
	var xhr = new XMLHttpRequest();
	xhr.open('POST', document.getElementById("ruta_html").value + '/adminPeriodos/controller.php' , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{	document.getElementById( 'resultado' ).innerHTML=xhr.responseText;
			var table = $('#banc_table').addClass( 'nowrap' ).DataTable({
				"bPaginate": true,
				"bStateSave": false,
				"bAutoWidth": false,
				"bScrollAutoCss": true,
				"bProcessing": true,
				"bRetrieve": true,
				"sDom": '<"H"CTrf>t<"F"lip>',
				"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
				"sScrollXInner": "110%",
				"fnInitComplete": function() {
					this.css("visibility", "visible");
				},
				paging: true,
				lengthChange: true,
				searching: true,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{className: "dt-body-center" , "targets": [0]},
					{className: "dt-body-center" , "targets": [1]},
					{className: "dt-body-center" , "targets": [2],"visible":false},
					{className: "dt-body-center" , "targets": [3]},
					{className: "dt-body-center" , "targets": [4]},
					{className: "dt-body-center" , "targets": [5]},
					{className: "dt-body-center" , "targets": [6]}
				]
			});
			table.page.len(10).draw();
			table.column( '5:visible' ).order( 'desc' );
			$('#banc_table tbody').on('click', 'td.details-control', function ()
			{   var tr = $(this).closest('tr');
				var row = table.row(tr);
				if ( row.child.isShown() )
				{   // This row is already open - close it
					row.child.hide();
					tr.removeClass('shown');
					$(this).find('i').toggleClass('fa fa-minus-circle fa fa-plus-circle');
					$(this).find('i').css("color", "green");
				}
				else
				{   $(this).find('i').toggleClass('fa fa-minus-circle fa fa-plus-circle');
					$(this).find('i').css("color", "red");
					var saldoaFavorCliente = [];
					saldoaFavorCliente = row.data();
					cabeSaf_codigo = saldoaFavorCliente[1];
					cabeSaf_codigo = cabeSaf_codigo.replace('<div style="font-size:11px;">','');
					cabeSaf_codigo = cabeSaf_codigo.replace('</div>','');
					if( saldoaFavorCliente )
					{   $("#modal_wait").modal('show');
						var data2 = new FormData();
						data2.append('event', 'get_safHistorico');
						data2.append('cabeSaf_codigo', cabeSaf_codigo);
						var xhrII = new XMLHttpRequest();
						xhrII.open('POST',document.getElementById('ruta_html').value+'/adminPeriodos/controller.php', true);
						xhrII.onreadystatechange=function()
						{   if ( xhrII.readyState === 4 && xhrII.status === 200 )
							{   // Open this row
								$("#modal_wait").modal('hide');
								row.child(xhrII.responseText).show();
								tr.addClass('shown');
								var table_deuda = $( '#safHistorico_table_' + cabeSaf_codigo ).DataTable({
									language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
									"lengthChange": false,
									searching: false,
									paging:false,
									info:false,
									"order":[[0, 'asc']],
									"columnDefs": [
										{className: "dt-body-center" , "targets": [0]},
										{className: "dt-body-center" , "targets": [1]},
										{className: "dt-body-center" , "targets": [2], "visible": false},
										{className: "dt-body-right"  , "targets": [3]},
										{className: "dt-body-right"  , "targets": [4]},
										{className: "dt-body-right"  , "targets": [5]},
										{className: "dt-body-center" , "targets": [6]},
										{className: "dt-body-center" , "targets": [7]},
										{className: "dt-body-center" , "targets": [8], "visible": false}
									],
									"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
										$('td', nRow).css('background-color', '#d6f9da');
									}
								});	
							}
						};
						xhrII.send(data2);
					}
				}
			});
		}
	};
	xhr.send(data);
}
function js_adminPeriodos_change_reason()
{	document.getElementById( 'valor_balance' ).value = '0';
	if( document.getElementById( 'cmb_balance_reason' ).value =='mas' )
	{   document.getElementById( 'span_balance_reason' ).innerHTML = '( + )';
		document.getElementById( 'span_balance_mount_label' ).innerHTML = 'Punto(s) a incrementar';
	}
	else
	{   document.getElementById( 'span_balance_reason' ).innerHTML = '( - )';
		document.getElementById( 'span_balance_mount_label' ).innerHTML = 'Punto(s) a disminuir';
	}
}
function js_saldoaFavor_add( )
{   document.getElementById( 'resultado' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append( 'event', 'set' );
	data.append( 'valor', document.getElementById( 'valor' ).value );
	data.append( 'alum_codi', document.getElementById( 'codalum' ).value );
	data.append( 'tipo_persona', document.getElementById( 'cmb_per_consulta_tipo_persona' ).value );

	var xhr = new XMLHttpRequest();
	xhr.open('POST', document.getElementById('ruta_html').value+'/adminPeriodos/controller.php' , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   js_saldoaFavor_busca("",'resultado', document.getElementById('ruta_html').value+'/adminPeriodos/controller.php' );
		} 
	};
	xhr.send(data);
}
function js_adminPeriodos_add2(  )
{   document.getElementById( 'resultado' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    
	var data = new FormData();
	data.append( 'event', 'set' );
	
	if ( document.getElementById( 'cmb_balance_reason' ).value == 'mas' )
		data.append( 'valor', document.getElementById( 'valor_balance' ).value );
	if ( document.getElementById( 'cmb_balance_reason' ).value == 'menos' )
		data.append( 'valor', document.getElementById( 'valor_balance' ).value * -1 );
	
	data.append( 'cabePun_codigo', document.getElementById( 'hd_cabePun_codigo' ).value );
	data.append( 'observacion', document.getElementById( 'txt_balance_obs' ).value );
	data.append( 'mes', document.getElementById( 'hd_mes_bandeja' ).value );
	data.append( 'concepto', document.getElementById( 'cmb_balance_reason_motivo' ).value );

	var xhr = new XMLHttpRequest();
	xhr.open('POST', document.getElementById('ruta_html').value+'/adminPeriodos/controller.php' , true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   var n = xhr.responseText.length;
			if (n > 0)
			{   valida_tipo_growl(xhr.responseText);
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." + xhr.responseText });
			}
			js_adminPeriodos_carga_meses_puntaje( document.getElementById( 'hd_mes_bandeja' ).value, document.getElementById( 'hd_mes_bandeja_nombre' ).value  , document.getElementById( 'hd_mes_estado' ).value );
		}
	};
	xhr.send(data);
}
function js_saldoaFavor_balancear( cabePun_codigo )
{   document.getElementById( 'span_balance_reason' ).innerHTML = '( + )';
	document.getElementById( 'span_balance_mount_label' ).innerHTML = 'Monto a incrementar';
	document.getElementById( 'cmb_balance_reason' ).value = 'mas';
	document.getElementById( 'cmb_balance_reason_motivo' ).value = '1';
	document.getElementById( 'hd_cabePun_codigo' ).value = cabePun_codigo;
    
	$('#banc_table tbody tr').each(function()
	{   if( $(this).find('td').eq(1).text( ) == cabePun_codigo  )
		{   var p_valor = $(this).find('td').eq(3).text( );
			document.getElementById( 'valor_actual' ).value = p_valor;
			document.getElementById( 'valor_balance' ).value = 0;
		}
	});
	$("#valor_balance").numeric({ decimal : false,  negative : false, precision: 2 });
}
function js_saldoaFavor_rep_hist( cartera_codigo )
{   var cliente_codigo = '0';
	var tipo_persona = 0;
	var evento = 'get_safHistorico_pdf';
	var url = document.getElementById('ruta_html').value+'/adminPeriodos/controller.php';
	url2 = url + '?event=' + evento + '&tdrgcd=' + cartera_codigo;
	window.open(url2);
}
function js_adminPeriodos_reporte( )
{   var url = document.getElementById('ruta_html').value+'/adminPeriodos/controller.php';
	url2 = url + '?event=print_puntajes';
	window.open(url2);
}