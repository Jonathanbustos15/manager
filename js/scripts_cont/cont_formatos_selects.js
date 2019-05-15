$(function(){
	//console.log('Hola selects...')
	//

	//----------------------------------------------------------------------------------------------------------------------
	//funciones para el select de categorias

	function carga_categorias_select(){

		var consulta_categorias = "select * FROM categoria WHERE fkID_padre IS NULL order by nombre_cat";
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_categorias+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	/**/
	    	$("#fkID_categoria").html('')
	    	$("#fkID_padre").html('')
	        console.log(data)

	        $("#fkID_categoria").append('<option></option>')
	        $("#fkID_padre").append('<option></option>')
	        	
        	$.each(data.mensaje, function(index, val) {
	        	 /* iterate through array or object */
	        	 console.log(index+"--"+val)
	        	 console.log(val)

	        	 $("#fkID_categoria").append('<option value="'+val.pkID+'">'+val.nombre_cat+'</option>')
	        	 $("#fkID_padre").append('<option value="'+val.pkID+'">'+val.nombre_cat+'</option>')
	        });

        
        	$("#fkID_categoria").click();	        

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

	function carga_sub_categoria(pkID){

		var consulta_sub_categorias = "select * from categoria where fkID_padre ="+pkID;
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_sub_categorias+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	/**/
	    	$("#fkID_subcategoria").html('')
	        console.log(data)

	        if (data.mensaje != "No hay registros.") {

	        	$("#fkID_subcategoria").append('<option></option>')

	        	$.each(data.mensaje, function(index, val) {
		        	 /* iterate through array or object */
		        	 console.log(index+"--"+val)
		        	 console.log(val)

		        	 $("#fkID_subcategoria").append('<option value="'+val.pkID+'">'+val.nombre_cat+'</option>')	        	 
		        });

	        
	        	$("#fkID_subcategoria").click();

	        };       		        

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

	var id_categoria = 0;

	$("#fkID_categoria").focus(function(event) {
		/* Act on the event */
		console.log('cargando datos...')
		carga_categorias_select()
	});

	$("#fkID_padre").focus(function(event) {
		/* Act on the event */
		console.log('cargando datos...')
		carga_categorias_select()
	});

	$("#fkID_categoria").change(function(event) {
		/* Act on the event toma el id del option seleccionado*/
		id_categoria = $(this)[0].value
		console.log(id_categoria)
		carga_sub_categoria(id_categoria)
		$("#sub_categoria").removeAttr('hidden');
	});


	$("#fkID_subcategoria").focus(function(event) {
		/* Act on the event */
		console.log('cargando sub_datos...')
		carga_sub_categoria(id_categoria)
	});

});