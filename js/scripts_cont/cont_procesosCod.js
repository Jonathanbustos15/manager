$(function(){	


	function carga_codProceso(){

		var consulta_codProceso = "select * from procesos ";
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_codProceso+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	/**/
	    	$("#codigo").html('')
	        console.log(data)

	        if (data.mensaje != "No hay registros.") {

	        	$("#codigo").append('<option></option>')

	        	$.each(data.mensaje, function(index, val) {
		        	 /* iterate through array or object */
		        	 console.log(index+"--"+val)
		        	 console.log(val)

		        	 $("#codigo").append('<option value="'+val.pkID+'">'+val.codigo+'</option>')	        	 
		        });

	        
	        	$("#codigo").click();

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

		
	var valida_codigo = false;

	//autocomplete proceso
	$( "#codigo" ).autocomplete({
      source: "../DAO/autocompleta_proceso.php",
      change: function(event, ui) {
        console.log(ui)
        /**/
        if (!valida_codigo) {
        	alert("Hay códigos parecidos ya registrados, por favor verifique.")
        	$(this).val("");
    	}
      },
      select: function( event, ui ) {      	
      	console.log(ui)      	
        $(this).val("")      		
      	$(this).focus();
      },
      response: function( event, ui ) {
      	//console.log(ui.content[0])
      	if (ui.content[0].value == null) {
      		valida_codigo = true;
      	} else{
      		valida_codigo = false;
      	};
      }
    });

    //--------------------------------------------------------------------    
	//estilo z index para hacer visible el autocompletado
    $("#ui-id-1").attr('style', 'display: none; top: 365px; left: 407px; z-index: 2147483647; width: 443px;');
    //-------------------------------------------------------------------


}); 
