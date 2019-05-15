(function(){
	//helper para ingresos general

	self.id_participante = 0;
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
	self.cons_tema_reunion=function(){

		var consulta_tema = "select temas.* "+ 

							"FROM `temas` "+

							"INNER JOIN reuniones ON reuniones.pkID=temas.fkID_reunion "+

							"INNER JOIN participantes ON participantes.fkID_reunion = reuniones.pkID"+

							"WHERE temas.fkID_reunion IS NOT NULL AND participantes.fkID_usuario = "+id_participante;

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_tema+"&tipo=consulta_gen",
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

	self.cons_temas_reuniones=function(){

		var consulta_tema = "select temas.* "+ 		

								"FROM `temas` "+

								"INNER JOIN reuniones ON reuniones.pkID=temas.fkID_reunion "+

								"INNER JOIN participantes ON participantes.fkID_reunion = reuniones.pkID";

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_tema+"&tipo=consulta_gen",
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

	self.fill_tema=function(){

		if (id_participante=='Todo' || id_participante=='') {
			
			var participante_todo = cons_temas_reuniones();

			participante_todo.success(function(data){
				console.log(data);
				itera_tema(data);
			});

		} else{

			var data_participante = cons_tema_reunion();

			data_participante.success(function(data){
				console.log(data);
				itera_tema(data);			
			});

		};
		
	}

	self.itera_tema=function(data){

		$("#"+selector_filtro).html('');
					
		$("#"+selector_filtro).append('<option></option>');

		if (data.estado == "ok") {

			$("#"+selector_filtro).removeAttr('disabled');

			$.each(data.mensaje, function(index, val) {							
				 $("#"+selector_filtro).append('<option value="'+val.fkID_reunion+'">"'+val.tema+'"</option>');			 
			});

		} else{

			$("#"+selector_filtro).html('');
			$("#"+selector_filtro).attr('disabled', 'true');
		};
	}
	//---------------------------------------------------------------------------------------------------

	//---------------------------------------Rango de fechas-------------------------------

	self.cons_rango_fechas=function(){

		var fecha1 = $("#fecha1").val();

		var fecha2 = $("#fecha2").val();

		var consulta_fecha = "select reuniones.* "+ 

							"FROM `reuniones` "+

							"INNER JOIN temas ON temas.fkID_reunion = reuniones.pkID "+

							"INNER JOIN participantes ON participantes.fkID_reunion = reuniones.pkID"+

							"WHERE temas.fkID_reunion IS NOT NULL AND reuniones.fecha_realizacion =  BETWEEN "+fecha1+" AND "+fecha2;

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


	

	

})();