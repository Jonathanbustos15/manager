(function(){
	//helper para ingresos general

	self.id_estado = 0;
	

	self.options_format = {
		symbol : "$",
		decimal : ",",
		thousand: ".",
		precision : 0,
		format: "%s%v"
	};


	self.remplazar = function (texto, buscar, nuevo){
	    var temp = '';
	    var long = texto.length;
	    for (j=0; j<long; j++) {
	        if (texto[j] == buscar) 
	        {
	            temp += nuevo;
	        } else
	            temp += texto[j];
	    }
	    return temp;
	}

	//---------------------------------------------------------------------------------------------------
	self.cons_fecha_aprobacion_estado=function(){

		var consulta_fecha = "select hoja_vida.* FROM hoja_vida WHERE fkID_estado = "+id_estado+" ORDER BY nombre DESC LIMIT 10";

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_fecha+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	//------------------------------------------
	        //this.paso_reciente = data.mensaje[0].idPaso2;		        
	    })
	    .fail(function() {
	        console.log("error");
	        //quita todo? o pone todo?
	        //location.reload();
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/
	}

	self.cons_fecha_aprobacion_estado_todo=function(){

		var consulta_fecha = "select hoja_vida.* FROM hoja_vida ";

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_fecha+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	//------------------------------------------
	        //this.paso_reciente = data.mensaje[0].idPaso2;		        
	    })
	    .fail(function() {
	        console.log("error");
	        //quita todo? o pone todo?
	        //location.reload();
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/
	}

	self.fill_estado=function(){

		if (id_estado=='Todo' || id_estado=='') {
			
			var fecha_todo = cons_fecha_aprobacion_estado_todo();

			fecha_todo.success(function(data){
				console.log(data);
				itera_fecha(data);
			});

		} else{

			var data_fecha = cons_fecha_aprobacion_estado();

			data_fecha.success(function(data){
				console.log(data);
				//itera_fecha(data);			
			});

		};
		
	}

	self.itera_fecha=function(data){

		$("#"+selector_filtro).html('');
					
		$("#"+selector_filtro).append('<option></option>');

		if (data.estado == "ok") {

			$("#"+selector_filtro).removeAttr('disabled');

			$.each(data.mensaje, function(index, val) {							
				 $("#"+selector_filtro).append('<option value="\''+val.fecha_aprobacion+'\'">'+val.fecha_aprobacion+'</option>');			 
			});

		} else{

			$("#"+selector_filtro).html('');
			$("#"+selector_filtro).attr('disabled', 'true');
		};
	}
	//---------------------------------------------------------------------------------------------------

})();