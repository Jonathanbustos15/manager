$(function(){

	//var p = 'fecha_pago_limite'
  /* var fe =  new Date('fecha_pago_limite');
   console.log(fe.getFullYear('fecha_pago_limite'));
   */

	//Arreglo que contiene ands
	var objt_cond = {
		'fkID_empresa':'',
		'aprobado':'',
		'pagado':'',
		'fecha_aprobacion':'',
		'anio':''
	};


	var id = ''; 
	var fecha = '';
	var anios = '';

	function crea_consulta(){
		//----------------------------------------------------------
		console.log(objt_cond)
		
		var arr_cond = [];

		$.each(objt_cond, function(index, val) {
			 
			 console.log('index:'+index+' val:'+val);

			 if (val != '') {
			 	arr_cond.push('gasto_gral.'+index+'='+val);
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
		/**/
		location.href="gastos_gral.php?filter="+cons_final;
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

		selector_filtro = 'fechas_filtro';
		//ejecutar la accion que llene la fecha 
		//segun el id de la empresa
		fill_fecha();

		console.log(objt_cond)		
	});

	//aprobado_filtro
	$("#aprobado_filtro").change(function(event) {		
		id = $(this).val();
    	objt_cond.aprobado = id;	

    	selector_filtro = 'fechas_filtro';
		//ejecutar la accion que llene la fecha 
		//segun el id de la empresa
		fill_fecha();	

	});

	//pagado_filtro
	$("#pagado_filtro").change(function(event) {		
		id = $(this).val();
		objt_cond.pagado = id;
		selector_filtro = 'fechas_filtro';
		//ejecutar la accion que llene la fecha 
		//segun el id de la empresa
		fill_fecha();			
		
	});

	$("#fechas_filtro").change(function(event) {		
		fecha = $(this).val();
		console.log(fecha);
		//objt_cond.fecha_aprobacion = "'"+fecha+"'";
		objt_cond.fecha_aprobacion = fecha;

	});

	$("#fecha_anio_filtro").change(function(event) {		
		anios = $(this).val();
		console.log(anios);
		//objt_cond.fecha_aprobacion = "'"+fecha+"'";
		objt_cond.anio = anios;

	});
	
	//------------------------------------------------------------------------------------------

	$("#btn_filtrar").click(function(event) {		
		crea_consulta();
	});
	
});