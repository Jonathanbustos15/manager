$(function(){

	//var p = 'fecha_pago_limite'
  /* var fe =  new Date('fecha_pago_limite');
   console.log(fe.getFullYear('fecha_pago_limite'));
   */

	//Arreglo que contiene ands
	var objt_cond = {
		'fkID_estado':''
	};

	var id = ''; 

	function crea_consulta(){
		//----------------------------------------------------------
		console.log(objt_cond)
		
		var arr_cond = [];

		$.each(objt_cond, function(index, val) {
			 
			 console.log('index:'+index+' val:'+val);

			 if (val != '') {
			 	arr_cond.push('hoja_vida.'+index+'='+val);
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
		location.href="hvida.php?filter="+cons_final;
		//----------------------------------------------------------
	}

	

	/*$("#estado_filtro").change(function(event) {		
		id = $(this).val();
		//console.log(fecha);
		//objt_cond.fecha_aprobacion = "'"+fecha+"'";
		objt_cond.fkID_estado = id;

	});*/


	$("#estado_filtro").change(function(event) {		
		
		id = $(this).val();
		

		if (id == "Todo") {
			objt_cond.fkID_estado = '';
		} else{
			objt_cond.fkID_estado = id;
		
		};		
		
		

		console.log(objt_cond)		
	});

	
	
	//------------------------------------------------------------------------------------------

	$("#btn_filtrar").click(function(event) {		
		crea_consulta();
	});
});