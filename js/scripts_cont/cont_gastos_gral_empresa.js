$(function(){
	//-----------------------------------------------------------------------
	//
	//console.log('hola empresas de ingresos')
	$("#btn_nuevoempresa").jquery_controllerV2({
  		nom_modulo:'empresa',
  		titulo_label:'Nueva Empresa'
  	});

  	$("#btn_nuevoempresa").click(function(event) {
  		//cierra modal ingreso_gral
	  	$('#form_modal_gasto_gral').modal('hide');

	  	$('#form_modal_empresa').on('hidden.bs.modal', function (e) {		  
		  $('#form_modal_gasto_gral').modal('show');
		});

		$("#btn_actionempresa").removeAttr('disabled');	
  	});

  	$("#btn_actionempresa").jquery_controllerV2({
  		tipo:'inserta/edita',
  		nom_modulo:'empresa',
  		nom_tabla:'empresa',
  		recarga:false,
  		ejecutarFunction:true,
  		functionResCrear:function(){
            
            console.log('Ejecutando luego de Insertar!!!');            

            $('#form_modal_empresa').modal('hide');           

        }  		 		  
  	});
	//-----------------------------------------------------------------------

	function carga_empresa(){

		var consulta_empresa = "select * from empresa ";
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_empresa+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	/**/
	    	$("#fkID_empresa").html('')
	        console.log(data)

	        if (data.mensaje != "No hay registros.") {

	        	$("#fkID_empresa").append('<option></option>')

	        	$.each(data.mensaje, function(index, val) {
		        	 /* iterate through array or object */
		        	 console.log(index+"--"+val)
		        	 console.log(val)

		        	 $("#fkID_empresa").append('<option value="'+val.pkID+'">'+val.nombre+'</option>')	        	 
		        });

	        
	        	$("#fkID_empresa").click();

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

	$("#fkID_empresa").focus(function(event) {
		/* Act on the event */
		console.log('cargando datos...')
		carga_empresa()
	});

});



