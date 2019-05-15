$(function(){
	//console.log('Hola selects...')
	//

	//----------------------------------------------------------------------------------------------------------------------
	//funciones para el select de categorias

	function carga_entidades_select(){

		var consulta_entidades = "select * FROM entidades order by nombre_entidad";
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_entidades+"&tipo=consulta_gen"
	    })
	    .done(function(data) {
	    	/**/
	    	$("#fkID_entidad").html('')
	        console.log(data)

	        
	        	
        	$.each(data.mensaje, function(index, val) {
	        	 /* iterate through array or object */
	        	 console.log(index+"--"+val)
	        	 console.log(val)

	        	 $("#fkID_entidad").append('<option value="'+val.pkID+'">'+val.nombre_entidad+'</option>')	        	 
	        });

        
        	$("#fkID_entidad").click();	        

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

	

	$("#fkID_entidad").focus(function(event) {
		/* Act on the event */
		console.log('cargando datos...')
		carga_entidades_select()
	});
	

});