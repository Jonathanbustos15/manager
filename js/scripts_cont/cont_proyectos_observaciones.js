$(function(){

	var date;
	date = new Date();
	date = date.getFullYear() + '-' +
	    ('00' + (date.getMonth()+1)).slice(-2) + '-' +
	    ('00' + date.getDate()).slice(-2);

	var observacionAnterior = '';
	var observacionFinal = '';

	function selectObservacion(pkID_proceso){

		var consulta_Observacion = "SELECT observaciones FROM `proyectos` WHERE pkID = "+pkID_proceso;
		//---------------------------------------------------------------
		/**/
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_Observacion+"&tipo=consulta_gen",
	    })
	    .done(function(data) {	    		    
	        console.log(data)
	        //
	        if (data.mensaje[0].observaciones != null){
	        	observacionAnterior=data.mensaje[0].observaciones;
	        	console.log(observacionAnterior);
	        }
	        	        
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
	    //---------------------------------------------------------------
	}

	function creaObservacionNueva(pkID_proceso){
		//UPDATE procesos SET observaciones = 'carajo' WHERE pkID = 6
		observacionFinal = observacionAnterior + $("#fecha_observacion").val() + " : " + $("#observacionesNuevo").val() + " -- ";

		var consulta_Observacion = "UPDATE proyectos SET observaciones = '"+observacionFinal+"' WHERE pkID = "+pkID_proceso;
		//---------------------------------------------------------------
		/**/
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_Observacion+"&tipo=consulta_gen",
	    })
	    .done(function(data) {	    		    
	        console.log(data)
	        //
	        alert("El campo se actualizó correctamente.");
	        location.reload();	        	     
	    })
	    .fail(function() {
	    	alert("Hubo un error al actualizar.");
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
		console.log(consulta_Observacion);
	    //---------------------------------------------------------------
	}


	$("#btn_nuevoobservacion").jquery_controllerV2({
  		nom_modulo:'observacion',
  		titulo_label:'Nueva Observación',
  		ejecutarFunction:true,  		
        functionBefore:function(ajustes){
        	//--------------------------------------------------
        	console.log("Ejecutando nueva observacion.")
        	//--------------------------------------------------
        	$("#btn_actionobservacion").removeAttr('disabled');
	  		$("#fecha_observacion").val(date);
	  		console.log($("#pkID").val())
	  		$("#pkID_proceso").val($("#pkID").val());
	  		//---------------------------------------
	  		//carga la observacion anterior
	  		selectObservacion($("#pkID").val());
	  		//---------------------------------------
	  		//cierra modal
		  	$('#frm_modal_proyecto').modal('hide');

		  	$('#form_modal_observacion').on('hidden.bs.modal', function (e) {			  
			  $('#frm_modal_proyecto').modal('show');
			});
		  	//--------------------------------------------------        	
        }
  	});

  	$("#btn_actionobservacion").click(function(event) {
  		var frm_observa = $("#form_observacion").valida();

  		console.log(frm_observa);

  		if (frm_observa.estado) {
  			creaObservacionNueva($("#pkID").val());
  		} else {
  			alert("No se permiten observaciones vacías.");
  		}

  	});

  	//-------------------------------------------
  	$("#observacionesNuevo").keyup(function(event) {  		
  		$(this).val(observ.valida($(this).val()))
  	});
  	//-------------------------------------------
});