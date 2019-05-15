$(function(){
	//-----------------------------------------------------------------------
	//
	//console.log('hola entidads de ingresos')
	$("#btn_nuevoentidad").jquery_controllerV2({
  		nom_modulo:'entidad',
  		titulo_label:'Nueva Entidad'
  	});

  	$("#btn_nuevoentidad").click(function(event) {
  		//cierra modal ingreso_gral
	  	$('#form_modal_contactos').modal('hide');

	  	$('#form_modal_entidad').on('hidden.bs.modal', function (e) {		  
		  $('#form_modal_contactos').modal('show');
		});

		$("#btn_actionentidad").removeAttr('disabled');	
  	});

  	$("#btn_actionentidad").jquery_controllerV2({
  		tipo:'inserta/edita',
  		nom_modulo:'entidad',
  		nom_tabla:'entidades',
  		recarga:false,
  		validarCampo:true,
  		nom_campo:'nombre_entidad',
  		ejecutarFunction:true,
  		functionResCrear:function(){
             $('#form_modal_entidad').modal('hide');               
        }  		 		  
  	});
	//-----------------------------------------------------------------------

	function carga_entidad(){

		var consulta_entidad = "select * from entidades order by nombre_entidad";
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_entidad+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	/**/
	    	$("#fkID_entidad").html('')
	        console.log(data)

	        if (data.mensaje != "No hay registros.") {

	        	$("#fkID_entidad").append('<option></option>')

	        	$.each(data.mensaje, function(index, val) {
		        	 /* iterate through array or object */
		        	 console.log(index+"--"+val)
		        	 console.log(val)

		        	 $("#fkID_entidad").append('<option value="'+val.pkID+'">'+val.nombre_entidad+'</option>')	        	 
		        });

	        
	        	$("#fkID_entidad").click();

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

	$("#fkID_entidad").focus(function(event) {
		/* Act on the event */
		console.log('cargando datos...')
		carga_entidad()
	});

	//-------------------------------------------------------------------
	

});