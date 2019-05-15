$(function(){
	//console.log('Hola selects...')
	//

	//----------------------------------------------------------------------------------------------------------------------
	//funciones para el select de categorias

	function carga_tdocumento_select(sel){

		var consulta_tdocumento = "SELECT * FROM `tipo_documento` where nombre_tdoc != 'No Aplica' AND fkID_padre IS NULL order by nombre_tdoc";
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_tdocumento+"&tipo=consulta_gen"
	    })
	    .done(function(data) {
	    	/**/
	    	$("#"+sel).html('')
	        //console.log(data)

	        
	        $("#"+sel).append('<option value=""></option>')

        	$.each(data.mensaje, function(index, val) {
	        	 /* iterate through array or object */
	        	 //console.log(index+"--"+val)
	        	 //console.log(val)

	        	 $("#"+sel).append('<option value="'+val.pkID+'">'+val.nombre_tdoc+'</option>')	        	 
	        });

	                
        	$("#"+sel).click();	        

	        //$( "#fkID_categoria" ).load( "formatos.php option");
	    })
	    .fail(function() {
	        //console.log("error");
	    })
	    .always(function() {
	        //console.log("complete");
	    });
	    //---------------------------------------------------------------
	}

	function carga_sub_tipo(pkID){

		var consulta_sub_categorias = "select * FROM tipo_documento where fkID_padre ="+pkID+" order by nombre_tdoc";
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_sub_categorias+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	/**/
	    	$("#fkID_subtipo").html('')
	        //console.log(data)

	        if (data.mensaje != "No hay registros.") {

	        	$("#fkID_subtipo").append('<option></option>')

	        	$.each(data.mensaje, function(index, val) {
		        	 /* iterate through array or object */
		        	 //console.log(index+"--"+val)
		        	 //console.log(val)

		        	 $("#fkID_subtipo").append('<option value="'+val.pkID+'">'+val.nombre_tdoc+'</option>')	        	 
		        });

	        
	        	$("#fkID_subtipo").click();

	        };       		        

	        //$( "#fkID_categoria" ).load( "formatos.php option");
	    })
	    .fail(function() {
	        //console.log("error");
	    })
	    .always(function() {
	        //console.log("complete");
	    });
	    //---------------------------------------------------------------

	}

		
	//ejecucion-------------------------------------------------------------------------------------------------------------	

	$("#fkID_tipo").focus(function(event) {
		/* Act on the event */
		//console.log('cargando datos...')
		carga_tdocumento_select('fkID_tipo')
	});

	$("#fkID_padre").focus(function(event) {
		/* Act on the event */
		console.log('cargando datos...')
		carga_tdocumento_select('fkID_padre')
	});


	var id_tipo = 0;

	$("#fkID_tipo").change(function(event) {
		/* Act on the event toma el id del option seleccionado*/
		id_tipo = $(this)[0].value
		//console.log(id_tipo)
		carga_sub_tipo(id_tipo)
		$("#sub_tipo").removeAttr('hidden');
	});


	$("#fkID_subtipo").focus(function(event) {
		/* Act on the event */
		if (id_tipo != '') {
			//console.log('cargando sub_datos...')
			carga_sub_tipo(id_tipo)
		};
		
	});

	//carga inicialmente los elementos
	carga_tdocumento_select('fkID_tipo')
	carga_tdocumento_select('fkID_padre')
	
});