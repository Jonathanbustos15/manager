$(function(){
	//-----------------------------------------------------------------------
	//
	//console.log('hola tipoContactos de ingresos')
	$("#btn_nuevotipoContacto").jquery_controllerV2({
  		nom_modulo:'tipoContacto',
  		titulo_label:'Nuevo tipo de Contacto'
  	});

  	$("#btn_nuevotipoContacto").click(function(event) {
  		//cierra modal ingreso_gral
	  	$('#form_modal_contactos').modal('hide');

	  	$('#form_modal_tipoContacto').on('hidden.bs.modal', function (e) {		  
		  $('#form_modal_contactos').modal('show');
		});

		$("#btn_actiontipoContacto").removeAttr('disabled');	
  	});

  	$("#btn_actiontipoContacto").jquery_controllerV2({
  		tipo:'inserta/edita',
  		nom_modulo:'tipoContacto',
  		nom_tabla:'tipo_contacto',
  		recarga:false,
  		validarCampo:true,
  		nom_campo:'nombre',
  		ejecutarFunction:true,
  		functionResCrear:function(){
             $('#form_modal_tipoContacto').modal('hide');               
        }  		 		    		 		  
  	});
	//-----------------------------------------------------------------------

	function carga_tipoContacto(){

		var consulta_tipoContacto = "select * from tipo_contacto ";
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_tipoContacto+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	/**/
	    	$("#fkID_tipo_contacto").html('')
	        console.log(data)

	        if (data.mensaje != "No hay registros.") {

	        	$("#fkID_tipo_contacto").append('<option></option>')

	        	$.each(data.mensaje, function(index, val) {
		        	 /* iterate through array or object */
		        	 console.log(index+"--"+val)
		        	 console.log(val)

		        	 $("#fkID_tipo_contacto").append('<option value="'+val.pkID+'">'+val.nombre+'</option>')	        	 
		        });

	        
	        	$("#fkID_tipo_contacto").click();

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

	$("#fkID_tipo_contacto").focus(function(event) {
		/* Act on the event */
		console.log('cargando datos...')
		carga_tipoContacto()
	});

	//---------------------------------------------------------------
	console.log($("#descripcion")[0].type)

});