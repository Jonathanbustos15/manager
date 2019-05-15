(function(){
	//helper para ingresos general

	self.id_empresa = 0;
	self.selector_filtro = '';

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
	self.cons_proyectos_empresa=function(){

		var consulta_empresa = "select DISTINCT proyectos.*, empresa.nombre as nombre_empresa FROM proyectos INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa WHERE proyectos.fkID_empresa = "+id_empresa+" ORDER BY proyectos.fkID_empresa DESC LIMIT 10";

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_empresa+"&tipo=consulta_gen",
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

	self.cons_proyectos_empresas_todo=function(){

		var consulta_empresa = "select DISTINCT proyectos.*, empresa.nombre as nombre_empresa FROM proyectos INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa";

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_empresa+"&tipo=consulta_gen",
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

	self.fill_empresa=function(){

		if (id_empresa=='Todo' || id_empresa=='') {
			
			var fecha_todo = cons_proyectos_empresas_todo();

			fecha_todo.success(function(data){
				console.log(data);
				//itera_fecha(data);
			});

		} else{

			var data_fecha = cons_proyectos_empresa();

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