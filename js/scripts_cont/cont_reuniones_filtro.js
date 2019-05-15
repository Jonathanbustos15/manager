$(function(){

	//Arreglo que contiene ands
	self.objt_cond = {
		'fkID_usuario':'',
		'fkID_reunion':'',
		'fecha1':'',
		'fecha2':''
	};

	var id = ''; 


	function crea_consulta(){
		//----------------------------------------------------------
		console.log(objt_cond)
		
		var arr_cond = [];

		$.each(objt_cond, function(index, val) {
			 
			 console.log('index:'+index+' val:'+val);

			 if (val != '') {

			 	if (  (index !== "fecha1") && (index !== "fecha2") ) {

			 		arr_cond.push('participantes.'+index+'='+val);
			 	}
			 	
			 	//arr_cond.push('temas.'+index+'='+val);
			 };
		});

		if (  (objt_cond.fecha1) || (objt_cond.fecha2) ) {
			arr_cond.push('reuniones.fecha_realizacion BETWEEN \''+objt_cond.fecha1+'\' AND \''+objt_cond.fecha2+'\'');
		}

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
		location.href="reuniones.php?filter="+cons_final;
		//----------------------------------------------------------
	}

	//usuario_filtro
	$("#usuario_filtro").change(function(event) {		
		id = $(this).val();
		

		if (id == "Todo") {
			objt_cond.fkID_usuario = '';
		} else{
			objt_cond.fkID_usuario = id;
		
		};		
		
		id_participante = id;
		selector_filtro = 'tema_filtro';

		fill_tema();

		
		//ejecutar la accion que llene la fecha 
		//segun el id de la empresa
		//fill_fecha();
		//console.log(objt_cond)		
	});

	//aprobado_filtro
	$("#tema_filtro").change(function(event) {		
		id = $(this).val();
		objt_cond.fkID_reunion = id;

	
		//fill_participante();
	});

	$("#fecha1").change(function(event){
		id = $(this).val();
		objt_cond.fecha1 = id;
	});

	$("#fecha2").change(function(event){
		id = $(this).val();
		objt_cond.fecha2 = id;
	});



	//inicializacion del plugin de fecha datetimepicker

	//calendario para la fecha de inicio
	$( "#fecha1" ).datepicker({
		dateFormat: "yy-mm-dd",
		yearRange: "1930:2040",
		changeYear: true,
		onClose: function( selectedDate ) {
	        $( "#fecha2" ).datepicker( "option", "minDate", selectedDate );
	      }			
	});
	//calendario para la fecha de inicio
	$( "#fecha2" ).datepicker({
		dateFormat: "yy-mm-dd",
		yearRange: "1930:2040",
		changeYear:true			
	});	
/*
	$( "#fecha1" ).datepicker({
		dateFormat: "yy-mm-dd",
		yearRange: "1930:2040",
    	changeYear: true
		//minDate: 0			
	});

	$( "#fecha2" ).datepicker({
		dateFormat: "yy-mm-dd",
		yearRange: "1930:2040",
    	changeYear: true
		//minDate: 0			
	});

*/	
	
	//------------------------------------------------------------------------------------------

	$("#btn_filtrar").click(function(event) {		
		crea_consulta();
	});
	
});