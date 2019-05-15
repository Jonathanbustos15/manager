$(function(){
	//console.log('Hola selects...')
	//

	//----------------------------------------------------------------------------------------------------------------------
	//funciones para el select de categorias

	function carga_tdocumento_select(){

		var consulta_tdocumento = "select * FROM tipo_documento_proceso order by nombre_tdoc";
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_tdocumento+"&tipo=consulta_gen"
	    })
	    .done(function(data) {
	    	/**/
	    	$("#fkID_tipo").html('')
	        console.log(data)

	        $("#fkID_tipo").append('<option></option>')
	        	
        	$.each(data.mensaje, function(index, val) {
	        	 /* iterate through array or object */
	        	 console.log(index+"--"+val)
	        	 console.log(val)

	        	 $("#fkID_tipo").append('<option value="'+val.pkID+'">'+val.nombre_tdoc+'</option>')	        	 
	        });

        
        	$("#fkID_tipo").click();	        

	        //$( "#fkID_categoria" ).load( "formatos.php option");
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
	    //---------------------------------------------------------------
	}

		
	//ejecucion-------------------------------------------------------------------------------------------------------------	

	$("#fkID_tipo").focus(function(event) {
		/* Act on the event */
		console.log('cargando datos...')
		carga_tdocumento_select()
	});
	

});