$(function(){
	//
	console.log('hola ingresos!')

	//-------------------------------------------------
	//form_empresa
	uppercaseForm("form_ingreso_gral");
	uppercaseForm("form_empresa");

	var objt_iva = {
		iva_percent : 19,
		reteiva_percent : 15
	}
	//-------------------------------------------------	

	$("#btn_nuevoingreso_gral").jquery_controllerV2({
  		nom_modulo:'ingreso_gral',
  		titulo_label:'Nueva Factura',
  	});

	//---------------------------------------------------------------------
  	var getValTax = function(input){
		return parseFloat((input.val())/100);
	}

	var setIvaPercent = function(){
		$("#iva_percent").val(objt_iva.iva_percent);
		console.log("Seteado iva_percent?")
	}

	var setValsTotal = function(valor){
		$("#total").val(valor)
		$("#total_mask").val(accounting.formatNumber(valor,options_format))
	}

	var getCalcIva = function(perc, subtotal){

  		let prod = 	parseFloat(perc) * (parseFloat(subtotal));

  		console.log(prod)

  		//$("#iva").val(prod)
		$("#iva_mask").val(accounting.formatNumber(prod,options_format))

		setValsTotal( parseFloat($('#iva').val()) + parseFloat($('#subtotal').val()) )
  	}

  	var iva_tax = function (){  		

  		$("#subtotal_mask").keyup(function(event) { 

  			let val_cuantia_remp = remplazar ($(this).val(), ".", ""); 	
			
			$('#subtotal').val(val_cuantia_remp)	



			//getCalcIva(getValTax($("#iva_percent")), val_cuantia_remp)			
			
  		});



  		/*$("#iva_percent").keyup(function(event) {
  			getCalcIva(getValTax($(this)), $('#subtotal').val() )
  		});*/
  	} 


  	var pru = function(){
  			$("#iva_mask").keyup(function(event){
  				let val_cuantia_remp = remplazar ($(this).val(), ".", ""); 	
			
				$('#iva').val(val_cuantia_remp)	

				setValsTotal( parseFloat($('#iva').val()) + parseFloat($('#subtotal').val()) )
  			})

  	} 	

  	iva_tax()

  	pru()

  	self.validaPagoImpuesto = function(){

  		let pago = $("#pagado_impuesto").val();

  		if (pago === "0") {
  			return false;
  		}else{
  			return true;
  		}
  	}

  	self.ablePeriodo = function(){

  		var $fkID_periodo = $("#fkID_periodo");

  		if (validaPagoImpuesto()) {
  			$fkID_periodo.removeAttr('disabled');
  		} else {  			
  			//$fkID_periodo.attr('disabled', true);
  			$fkID_periodo.removeAttr('disabled');
  		}
  	}

  	$("#pagado_impuesto").change(function(event) {
  		//ablePeriodo();  		
  	});

  	$("#btn_nuevoingreso_gral").click(function(event) {
  		//console.log("nuevo ingreso!")  		
  		displayTax("ingreso_hide", "hide")
  		displayTax("rete_hide", "hide")
  		//carga el porcentaje de iva
  		//setIvaPercent()
  		//habilita de nuevo el formulario
  		dDom.enableArr()
  		//
  		ablePeriodo();		 					
  	});

  	//---------------------------------------------------------------------	

  	$("#btn_actioningreso_gral").jquery_controllerV2({
  		tipo:'inserta/edita',
  		nom_modulo:'ingreso_gral',
  		nom_tabla:'ingreso_gral',
  		recarga:true  		 		  
  	});

  	//-----------------------------------------------------
  	var pagado = function(){

  		var pagadoe = $("#pagado").val();

  		if(pagadoe == 0){
  			return false;
  		}else{
  			return true;
  		}
  	}
  	//-----------------------------------------------------

  	
  	var displayTax = function(selector, type){

  		switch (type) {
  			case "show":
  					$("#"+selector).removeAttr('hidden');
  				break;
			case "hide":
  					$("#"+selector).attr('hidden','true');
  				break;  			
  		}
  	}

  	var getCalcReteIva = function(perc, iva){

  		let prod = 	parseFloat(perc) * (parseFloat(iva));

  		console.log(prod)

  		$("#rete_iva").val(prod)

  		$("#rete_iva_mask").val(accounting.formatNumber(prod,options_format))

  		sumRetencion(prod)
  	}


  	var showHideTaxes = function(){

  		if (!pagado()) {

  			displayTax("rete_hide", "hide")
  			$("#pagado").removeAttr('disabled')

  		}else{
  			
  			displayTax("rete_hide", "show")

  			$("#rete_iva_percent").val(objt_iva.reteiva_percent);		
  			
  			/**/

  			if ( $("#rete_iva").val() == 0 ) {
  				
  				console.log("Realizar calculo del reteiva?")

	  			getCalcReteIva(getValTax($("#rete_iva_percent")), $("#iva").val());

	  			$("#rete_iva_percent").keyup(function(event) {
	  				getCalcReteIva(getValTax($(this)), $("#iva").val());
	  			});
	  		}

  			keyUpAccount("rete_ica")

  			keyUpAccount("rete_fuente")

  			keyUpAccount("otra_retencion")

  			var kt = new keyupTax()
  			kt.init()
  		}
  	}

  	//funcion suma valor al total  	

  	function sumRetencion(val){

  		var total_retencion = parseFloat( $("#total_retencion").val() ) + parseFloat(val);

  		console.log(total_retencion)

  		$("#total_retencion").val(total_retencion)

  		$("#total_retenido_mask").val(accounting.formatNumber(total_retencion,options_format))
  	}

  	function setValAccNumber(id, valor){

  		$('#'+id+'_mask').val(accounting.formatNumber(valor,options_format));
  	}

  	

  	$("[name*='edita_ingreso_gral']").jquery_controllerV2({
		tipo:'carga_editar',
  		nom_modulo:'ingreso_gral',
  		nom_tabla:'ingreso_gral',
  		titulo_label:'Edita Ingreso',
  		tipo_load:1,
  		ejecutarFunction:true,
  		functionResCarga:function(id,data){

  			setIvaPercent()
  			  			
			displayTax("ingreso_hide", "show")

			showHideTaxes()

			$("#pagado").change(function(event) {

				showHideTaxes()  

			});
			var arr_id_dom = [
				'fkID_empresa',
				'fkID_proyecto',
				'descripcion',
				'fecha_radicacion',
				'subtotal_mask',
				'iva_percent',
				'pagado',
				'fecha_pago',
				'rete_iva_percent',
				'rete_ica_mask',
				'rete_fuente_mask',
				'otra_retencion_mask',
				'total_retencion_mask',
				'total_recibido_mask'
			//'pagado_impuesto'			
			];
			self.dDom = new disableDOMF(arr_id_dom);
			            
			setValAccNumber('subtotal', data.mensaje[0].subtotal)
			setValAccNumber('iva', data.mensaje[0].iva)
			setValAccNumber('total', data.mensaje[0].total)
			setValAccNumber('rete_ica', data.mensaje[0].rete_ica)
			setValAccNumber('rete_iva', data.mensaje[0].rete_iva)
			setValAccNumber('rete_fuente', data.mensaje[0].rete_fuente)			
			setValAccNumber('otra_retencion', data.mensaje[0].otra_retencion)
			setValAccNumber('total_retencion', data.mensaje[0].total_retencion)
			setValAccNumber('total_recibido', data.mensaje[0].total_recibido)

			var pagado_impuesto = $("#pagado_impuesto").val();

			if(pagado_impuesto == 1){
				$("#pagado_impuesto").attr('disabled', 'true');
			}else if(pagado_impuesto == 0){
				$("#pagado_impuesto").removeAttr('disabled');
			}

			//------------------------------------------------------------------
			if ($("#total_retencion").val() != 0) {
				dDom.disableArr()
			}
			//------------------------------------------------------------------

			//ablePeriodo();
			$("#fkID_periodo").attr('disabled', true);
        }
	});

  	$("[name*='elimina_ingreso_gral']").jquery_controllerV2({
  		tipo:'eliminar',
  		nom_modulo:'ingreso_gral',
  		nom_tabla:'ingreso_gral'
  	});
  	//--------------------------------------------------

  	$("#fecha_ingreso").datepicker({
		dateFormat: "yy-mm-dd",
		minDate: 0			
	});


	$("#fecha_pago").datepicker({
		dateFormat: "yy-mm-dd",
		minDate: "2010-01-01"			
	});

	$("#fecha_radicacion").datepicker({
		dateFormat: "yy-mm-dd",
		minDate: "2010-01-01"			
	});

	$("#fecha_radicacion").change(function(event){
		var fe_pafo = $("#fecha_radicacion").val();
		var aux = fe_pafo.substring(0, 4);
		$("#anio").val(aux);
		console.log($("#anio").val());
	});
  	//-----------------------------------------------------------------------------------------  
  	

	$('#subtotal_mask').mask('000.000.000.000.000', {reverse: true});
	$('#iva_mask').mask('000.000.000.000.000', {reverse: true});
	$('#total_mask').mask('000.000.000.000.000', {reverse: true});

	
	/*
	$('#subtotal_mask').change(function(event) {		
		var val_cuantia = $(this).val();		
		$('#subtotal').val(remplazar (val_cuantia, ".", ""))		
	});*/


	//Complemento keyup para los inputs de impuestos
	//self.kt = new keyupTax();
	//kt.init();
	//-----------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------
	//seleccion en el form de la empresa -> fuente
	$("#fkID_empresa").change(function(event) {				
		id_empresa = $(this).val();
		selector_filtro = 'fkID_proyecto';
		selector_filtroP = 'fkID_periodo';
		//ejecutar la accion que llene la fuente 
		//segun el id de la empresa
		console.log(id_empresa);
		fill_fuente();
		fill_periodo();
	});
	//-----------------------------------------------------------------------------------------------------------------------------
	//seleccion en el form de pagado
	$("#pagado").change(function(event) {
		id_pagado = $(this).val();
		selector_filtro = 'pagado';
		//ejecutar la accion que llene la fuente 
		//segun el id de la empresa
		console.log(id_pagado);
		//fill_fuente();
	});
	//---
	//Filtro de ingresos
	
	//Arreglo que contiene ands
	var objt_cond = {
		'fkID_empresa':'',
		'fkID_proyecto':'',		
		'pagado':'',
		'pagado_impuesto':'',
		'fecha_ingreso':'',
		'anio':'',
		'fkID_periodo':''		
	};

	var id = '';
	var anio = '';
	var periodo = '';

	function crea_consulta(){
		//----------------------------------------------------------
		console.log(objt_cond)

		var arr_cond = [];

		$.each(objt_cond, function(index, val) {
			 console.log('index:'+index+' val:'+val);
			 if (val != '') {
			 	arr_cond.push('ingreso_gral.'+index+'='+val);
			 };
		});

		console.log(arr_cond)
		//----------------------------------------------------------
		var cons_final = '';

		if (arr_cond.length > 1) {
			cons_final = arr_cond.join(' AND ');
		}else if (arr_cond.length == 0) {
			cons_final = '*';
		} else{
			cons_final = arr_cond.join();
		};

		console.log(cons_final)

		location.href="ingresos_gral.php?filter="+cons_final;
		//----------------------------------------------------------
	}


	//empresa_filtro
	$("#empresa_filtro").change(function(event) {
		
		id = $(this).val();

		if (id == "Todo") {
			objt_cond.fkID_empresa = '';
		} else{
			objt_cond.fkID_empresa = id;
		};		
		
		id_empresa = id;
		selector_filtro = 'fuente_filtro';
		selector_filtroP = 'periodo_filtro';
		//ejecutar la accion que llene la fuente 
		//segun el id de la empresa
		fill_fuente();
		fill_periodo();
		console.log(objt_cond)
	});


	//pagado_filtro
	$("#pagado_filtro").change(function(event) {		
		id = $(this).val();
		objt_cond.pagado = id;		
	});

	//pagado_impuesto_filtro
	$("#pagado_impuesto_filtro").change(function(event) {		
		id = $(this).val();
		objt_cond.pagado_impuesto = id;		
		
	});



	//fuente_filtro
	/**/
	$("#fuente_filtro").change(function(event) {		
		id = $(this).val();
		objt_cond.fkID_proyecto = id;		
	});

	$("#btn_filtrar").click(function(event) {		
		crea_consulta();
	});


	// suma ------------------------------------------------------------------------------------------------------
	$.fn.dataTable.Api.register( 'column().data().sum()', function () {
	    return this.reduce( function (a, b) {
	        var x = parseFloat( a ) || 0;
	        var y = parseFloat( b ) || 0;
	        return x + y;
	    });
	});
 
	/* Init the table and fire off a call to get the hidden nodes.
	$(document).ready(function() {
	    var table = $('#tbl_ingresos_gral').DataTable();
	    console.log('La suma es .......' + table.column(4).data().visible().sum());
	    console.log('La suma visible es .......' + table.column(4,{page:'current'}).data().sum()); 
	});
	*/

	$('#buscador').keyup(function() {
		console.log('La suma es ..**************.' + table.column(4).data().sum());
		console.log('La suma filtrada es  es ..**************.' + table.column(4, {page:'current'}).data().sum());
		
		var sumado = table.column(4, {page:'current'}).data().sum();
		
		sumado = accounting.formatNumber(sumado,options_format);
		// sumado = $.parseNumber(sumado, {format:"#,###.00", locale:"us"});
		$("#total_ingresos").val(sumado);
	});
	//-----------------------------------------------------------------------------------------------------------------------------	
	$("#anio_filtro").change(function(event) {		
		anio = $(this).val();
		console.log(anio);
		//objt_cond.fecha_aprobacion = "'"+fecha+"'";

		objt_cond.anio = anio;

	});

	$("#periodo_filtro").change(function(event) {		
		periodo = $(this).val();
		console.log("periodo");
		console.log(periodo);
		objt_cond.fkID_periodo = periodo;

	});
});