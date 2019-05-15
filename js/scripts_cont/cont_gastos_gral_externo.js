$(function(){
	//-----------------------------------------------------------------------
	//
	//console.log('hola externos de ingresos')
	$("#btn_nuevoexterno").jquery_controllerV2({
  		nom_modulo:'externo',
  		titulo_label:'Nuevo externo'
  	});

  	$("#btn_nuevoexterno").click(function(event) {
  		//cierra modal ingreso_gral
	  	$('#form_modal_gasto_gral').modal('hide');

	  	$('#form_modal_externo').on('hidden.bs.modal', function (e) {		  
		  $('#form_modal_gasto_gral').modal('show');
		});

		$("#btn_actionexterno").removeAttr('disabled');	
  	});

  	$("#btn_actionexterno").jquery_controllerV2({
  		tipo:'inserta/edita',
  		nom_modulo:'externo',
  		nom_tabla:'externo',
  		recarga:false,
  		ejecutarFunction:true,
  		functionResCrear:function(){
            
            console.log('Ejecutando luego de Insertar!!!');            

            $('#form_modal_externo').modal('hide');           

        }		 		  
  	});
	//-----------------------------------------------------------------------

	function carga_externo(){

		var consulta_externo = "select * from externo ";
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_externo+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	/**/
	    	$("#fkID_externo").html('')
	        console.log(data)

	        if (data.mensaje != "No hay registros.") {

	        	$("#fkID_externo").append('<option></option>')

	        	$.each(data.mensaje, function(index, val) {
		        	 /* iterate through array or object */
		        	 console.log(index+"--"+val)
		        	 console.log(val)

		        	 $("#fkID_externo").append('<option value="'+val.pkID+'">'+val.nombre+'</option>')	        	 
		        });

	        
	        	$("#fkID_externo").click();

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

	$("#fkID_externo").focus(function(event) {
		/* Act on the event */
		console.log('cargando datos...')
		carga_externo()
	});

});