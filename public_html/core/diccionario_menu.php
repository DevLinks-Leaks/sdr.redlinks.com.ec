<?php 
$diccionario_menu=array(
'{CobroGeneral}'	=>	array(
					'href'=>'../cobros/',
					'texto'=>'<span class=\'fa fa-dollar\'></span>&nbsp;Cobrar deuda',
					'permiso'=>'126',
				),
'{Deuda}'	=>	array(
					'href'=>'../facturas/',
					'texto'=>'<span class=\'fa fa-paperclip\'></span>&nbsp;Generar deuda',
					'permiso'=>'130',
				),
'{NotadeCredito}'	=>	array(
					'href'=>'../notaCredito/',
					'texto'=>'<span class=\'fa fa-minus\'></span>&nbsp;Generar n/cr&eacute;dito',
					'permiso'=>'133',
				),
'{NotadeDebito}'	=>	array(
					'href'=>'../notaDebito/',
					'texto'=>'<span class=\'fa fa-plus\'></span>&nbsp;Generar n/d&eacute;bito',
					'permiso'=>'133',
				),
'{GestionFacturas}'	=> 	array(
						'href'=>'../gestionFacturas/',
						'texto'=>'<span class=\'icon icon-sri\'></span>&nbsp;Gestión factura',
						'permiso'=>'104'
				),
'{GestionNotascredito}'	=> 	array(
						'href'=>'../gestionNotascredito/',
						'texto'=>'<span class=\'icon icon-sri\'></span>&nbsp;Gesti&oacute;n n/c',
						'permiso'=>'207'
				),
'{GestionNotasdebito}'	=> 	array(
						'href'=>'../gestionNotasdebito/',
						'texto'=>'<span class=\'icon icon-sri\'></span>&nbsp;Gesti&oacute;n n/d',
						'permiso'=>'207'
				),
'{GestionContifico}'	=>	array(
					'href'=>'../gestionContifico/',
					'texto'=>'<span class=\'fa fa-send\'></span>&nbsp;Cont&iacute;fico',
					'permiso'=>'119',
				),
'{CierredeCaja}'	=>	array(
					'href'=>'../cierre_caja/',
					'texto'=>'<span class=\'fa fa-folder\'></span>&nbsp;Cerrar caja',
					'permiso'=>'170',
				),
'{Contabilidad}'	=>	array(
					'href'=>'../contabilidad/',
					'texto'=>'<span class=\'fa fa-send-o\'></span>&nbsp;Contabilidad',
					'permiso'=>'226',
				),
'{VerSaldoaFavor}'	=>	array(
					'href'=>'../saldoaFavor/',
					'texto'=>'<span class=\'fa fa-balance-scale\'></span>&nbsp;Saldos a favor',
					'title'=>'ver y administrar Saldos a favor',
					'permiso'=>'209',
				),
'{VerDocumentosAutorizados}'	=>	array(
					'href'=>'../VerDocumentosAutorizados/',
					'texto'=>'<span class=\'fa fa-barcode\'></span>&nbsp;Doc. autorizados',
					'permiso'=>'227',),
'{VerPagos}'	=>	array(
					'href'=>'../pagos/',
					'texto'=>'<span class=\'fa fa-list\'></span>&nbsp;Pagos recibidos',
					'permiso'=>'227',),
'{VerCaja}'	=>	array(
					'href'=>'../verCaja/',
					'texto'=>'<span class=\'fa fa-history\'></span>&nbsp;Historial cajas',
					'permiso'=>'170',
				),
'{Categorias}'	=>	array(
					'href'=>'../categorias/',
					'texto'=>'<span class=\'fa fa-tags\'></span>&nbsp;Categorías',
					'permiso'=>'136',
				),
'{Items}'	=>	array(
					'href'=>'../items/',
					'texto'=>'<span class=\'fa fa-shopping-cart\'></span>&nbsp;Items',
					'permiso'=>'139',
				),
'{Precios}'	=>	array(
					'href'=>'../precios/',
					'texto'=>'<span class=\'fa fa-dollar\'></span>&nbsp;Precios',
					'permiso'=>'143',
				),
'{GruposEconomicos}'	=>	array(
					'href'=>'../gruposEconomico/',
					'texto'=>'<span class=\'fa fa-users\'></span>&nbsp;Grupo economico',
					'permiso'=>'145',
				),
'{NivelEconomico}'	=>	array(
					'href'=>'../nivelEconomico/',
					'texto'=>'<span class=\'fa fa-diamond\'></span>&nbsp;Nivel económico',
					'permiso'=>'149',
				),
'{AgrupaciondeCursos}'	=>	array(
					'href'=>'../nivelEconomicoCursos/',
					'texto'=>'<span class=\'fa fa-object-group\'></span>&nbsp;Agrupación de cursos',
					'permiso'=>'153',
				),
'{Clientes}'	=>	array(
					'href'=>'../clientes/',
					'texto'=>'<span class=\'fa fa-graduation-cap\'></span>&nbsp;Clientes',
					'permiso'=>'103',
				),
'{Sucursales}'	=>	array(
					'href'=>'../sucursales/',
					'texto'=>'<span class=\'fa fa-institution\'></span>&nbsp;Sucursales',
					'permiso'=>'106',
				),
'{Bancos}'	=>	array(
					'href'=>'../bancos/',
					'texto'=>'<span class=\'glyphicon glyphicon-piggy-bank\'></span>&nbsp;Bancos',
					'permiso'=>'186',
				),
'{tarjetasCredito}'	=>	array(
					'href'=>'../tarjetasCredito/',
					'texto'=>'<span class=\'fa fa-cc-mastercard\'></span>&nbsp;Tarjetas de crédito',
					'permiso'=>'193',
				),
'{PuntosdeEmision}'	=>	array(
					'href'=>'../puntos_emision/',
					'texto'=>'<span class=\'glyphicon glyphicon-tent\'></span>&nbsp;Puntos de emisión',
					'permiso'=>'110',
				),
'{TiposdeDescuentos}'	=>	array(
					'href'=>'../tipo_descuento/',
					'texto'=>'<span class=\'fa fa-wrench\'></span>&nbsp;Tipos de descuentos',
					'permiso'=>'115',
				),
'{PeriodosAnuales}'	=>	array(
					'href'=>'../aniosPeriodo/',
					'texto'=>'<span class=\'fa fa-calendar\'></span>&nbsp;Periodos anuales',
					'permiso'=>'119',
				),
'{Usuarios}'	=>	array(
					'href'=>'../usuarios/',
					'texto'=>'<span class=\'fa fa-users\'></span>&nbsp;Usuarios',
					'permiso'=>'16',
				),
'{Liquidez}'	=>	array(
					'href'=>'../liquidez/',
					'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Reporte de liquidez',
					'permiso'=>'192',
				),
'{Cobranza}'	=>	array(
					'href'=>'../cobranza/',
					'texto'=>'<span class=\'fa fa-phone-square\'></span>&nbsp;Cobranza',
					'permiso'=>'173',
				),
'{Resultados}'	=>	array(
					'href'=>'../crm_resultados/',
					'texto'=>'<span class=\'fa fa-book\'></span>&nbsp;Resultados',
					'permiso'=>'175',
				),
'{ValidadorCheques}'	=> 	array(
						'href'=>'../valida_cheques/',
						'texto'=>'<span class=\'fa fa-check-circle-o\'></span>&nbsp;Validar cheques',
						'permiso'=>'196'
				),
'{ConvenioMandato}'	=> 	array(
						'href'=>'../convenioMandato/',
						'texto'=>'<span class=\'fa fa-hand-grab-o\'></span>&nbsp;Convenio mandato',
						'permiso'=>'198'
				),
'{Descuentofacturas}'	=> 	array(
						'href'=>'../descuentofacturas/',
						'texto'=>'<span class=\'fa fa-barcode\'></span>&nbsp;Descuento de facturas',
						'permiso'=>'205'
			 	),
'{Reporte_CRM_Cobranza}'	=>	array(
					'href'=>'../rep_cobranza/',
					'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;CRM Cobranza',
					'permiso'=>'194',
				),
'{RepNC}'	=> 	array(
						'href'=>'../rep_notaCredito/',
						'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Notas de Crédito',
						'permiso'=>'201'
				),
'{RepND}'	=> 	array(
						'href'=>'../rep_notaDebito/',
						'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Notas de Débito',
						'permiso'=>'201'
				),
'{RepFACT}'	=> 	array(
						'href'=>'../rep_facturas/',
						'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Facturas emitidas',
						'permiso'=>'202'
				),
'{RepDescuentos}'	=> 	array(
						'href'=>'../rep_descuentos/',
						'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Descuentos otorgados',
						'permiso'=>'203'
				),
'{RepSaldosAFavor}'	=> 	array(
						'href'=>'../rep_saldosafavor/',
						'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Saldos a favor',
						'permiso'=>'224'
				),
'{RepFacturas}'	=> 	array(
						'href'=>'../rep_facturas/',
						'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Facturas',
						'permiso'=>'202'
				),
'{DebitosAutomaticos}'	=> 	array(
						'href'=>'../debitosAutomaticos/',
						'texto'=>'<span class=\'glyphicon glyphicon-import\'></span>&nbsp;Débitos bancarios',
						'permiso'=>'206'
				),
'{DescuentoAlumnos}'	=> 	array(
						'href'=>'../descuentoalumnos/',
						'texto'=>'<span class=\'fa fa-graduation-cap\'></span>&nbsp;Descuento por alumno',
						'permiso'=>'208'
				),
);
?>