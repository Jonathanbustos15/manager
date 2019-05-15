$(function(){

	//var p = 'fecha_pago_limite'
  /* var fe =  new Date('fecha_pago_limite');
   console.log(fe.getFullYear('fecha_pago_limite'));
   */

	//Arreglo que contiene ands
	var objt_cond = {
		'fkID_empresa':''
	};


	var id = ''; 


	function crea_consultae(){
		//----------------------------------------------------------
		console.log(objt_cond)
		
		var arr_cond = [];

		$.each(objt_cond, function(index, val) {
			 
			 console.log('index:'+index+' val:'+val);

			 if (val != '') {
			 	arr_cond.push('proyectos.'+index+'='+val);
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
		location.href="proyectos.php?filter="+cons_final;
		//----------------------------------------------------------
	}

	//empresa_filtro
	$("#empresa_filtrop").change(function(event) {		
		
		id = $(this).val();
		

		if (id == "Todo") {
			objt_cond.fkID_empresa = '';
		} else{
			objt_cond.fkID_empresa = id;
		
		};		
		
		id_empresa = id;

		//selector_filtro = 'fechas_filtro';
		//ejecutar la accion que llene la fecha 
		//segun el id de la empresa
		fill_empresa();

		console.log(objt_cond)		
	});


	
	//------------------------------------------------------------------------------------------

	$("#btn_filtrar").click(function(event) {		
		crea_consultae();
	});
	
});