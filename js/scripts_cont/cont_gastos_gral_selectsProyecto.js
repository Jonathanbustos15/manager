$(function(){
	
	//console.log('hola selects proyecto gasto gral')------------------------------------
	
	function carga_Actividad(pkID_proyecto){

		var consulta_actividad = "SELECT * FROM `actividad` WHERE fkID_proyecto = "+pkID_proyecto;
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_actividad+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	
	    	
	        console.log(data)
	        /**/

	        $("#fkID_actividad").html('');

	        if (data.mensaje != "No hay registros.") {

	        	$("#fkID_actividad").append('<option></option>')

	        	$.each(data.mensaje, function(index, val) {
		        	 
		        	 console.log(index+"--"+val)
		        	 console.log(val)

		        	 $("#fkID_actividad").append('<option value="'+val.pkID+'">'+val.nombre+'</option>')	        	 
		        });

	        
	        	$("#fkID_actividad").click();

	        };	        
	    })
	    .fail(function() {
	        console.log("error");
	        $("#fkID_actividad").html('');
	    })
	    .always(function() {
	        console.log("complete");
	    });
	    //---------------------------------------------------------------
	}

	$("#fkID_proyecto").change(function(event) {
		carga_Actividad($(this).val())
	});

	//-------------------------------------------------------------------
	//autocomplete beneficiario
	$( "#beneficiario" ).autocomplete({
      source: "../DAO/cpc_beneficiario.php",
      select: function( event, ui ) {
        console.log(ui)
        $("#fkID_externo").val(ui.item.id);
      },
      change: function( event, ui ) {
      	//console.log('Ha cambiado el valor!')
      	console.log(ui)
      	if (ui.item == null) {
      		//console.log('No selecciono nada viejo...')
      		alert("El beneficiario que selecciono no es válido.")
      		$("#fkID_externo").val("")
      		$(this).val("")
      		$(this).focus();
      	};
      }
    });
    //--------------------------------------------------------------------    
	//estilo z index para hacer visible el autocompletado
    $("#ui-id-1").attr('style', 'display: none; top: 365px; left: 407px; z-index: 2147483647; width: 443px;');
    //-------------------------------------------------------------------

});