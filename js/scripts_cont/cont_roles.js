$(function(){
	//console.log('hola desde roles');

	//---------------------------------------------------------------
	//.jquery_controller('nombre_del_modulo','tipo','nombre de la tabla en BD','upload true/false','tipo de carga 1,2','reload true/false')

	$("#btn_nuevoRol").jquery_controller('rol','nuevo','',false,'',false);

	$("#btn_actionrol").jquery_controller('rol','inserta/edita','permisos',false,'',true);

	$("[name*='edita_rol']").jquery_controller('rol','carga_editar','permisos',false,1,false);

  	$("[name*='elimina_rol']").jquery_controller('rol','eliminar','permisos',false,'',true);

  	//------------------------------------------------------------------------------------------------------------------

  	//------------------------------------------------------------------------------------------------------------------
  	//Tipo de usuario

  	function carga_tUsuario_select(){

		var consulta_categorias = "select * FROM tipo_usuario";
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_categorias+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	/**/
	    	$("#fkID_tipo_usuario").html('')
	    	
	        console.log(data)

	        $("#fkID_tipo_usuario").append('<option></option>')	        
	        	
        	$.each(data.mensaje, function(index, val) {
	        	 /* iterate through array or object */
	        	 console.log(index+"--"+val)
	        	 console.log(val)

	        	 $("#fkID_tipo_usuario").append('<option value="'+val.pkID+'">'+val.nombre+'</option>')
	        	 
	        });
        
        	$("#fkID_tipo_usuario").click();	        

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

	$("#fkID_tipo_usuario").focus(function(event) {
		/* Act on the event */
		console.log('cargando datos...')
		carga_tUsuario_select()
	});

  	$("#btn_nuevotUsuario").jquery_controller('tUsuario','nuevo','',false,'',false);
  	
  	$("#btn_nuevotUsuario").click(function(event) {
  		/* Act on the event */
  		//cierra modal
	  	$('#form_modal_rol').modal('hide');

	  	$("#btn_actiontUsuario").removeAttr('disabled');

	  	$('#form_modal_tUsuario').on('hidden.bs.modal', function (e) {
		  // do something...
		  //console.log(e)
		  $('#form_modal_rol').modal('show');
		});	
  	});

  	$("#btn_actiontUsuario").jquery_controller('tUsuario','inserta/edita','tipo_usuario',false,'',false);
  	//------------------------------------------------------------------------------------------------------------------

  	//------------------------------------------------------------------------------------------------------------------
  	//Modulos

  	function carga_modulo_select(){

		var consulta_categorias = "select * FROM modulos";
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_categorias+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	/**/
	    	$("#fkID_modulo").html('')
	    	
	        console.log(data)

	        $("#fkID_modulo").append('<option></option>')
	        
	        	
        	$.each(data.mensaje, function(index, val) {
	        	 /* iterate through array or object */
	        	 console.log(index+"--"+val)
	        	 console.log(val)

	        	 $("#fkID_modulo").append('<option value="'+val.pkID+'">'+val.Nombre+'</option>')
	        	 
	        });

        
        	$("#fkID_modulo").click();	        

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

	$("#fkID_modulo").focus(function(event) {
		/* Act on the event */
		console.log('cargando datos...')
		carga_modulo_select()
	});

  	$("#btn_nuevomodulo").jquery_controller('modulo','nuevo','',false,'',false);
  	
  	$("#btn_nuevomodulo").click(function(event) {
  		/* Act on the event */
  		//cierra modal
	  	$('#form_modal_rol').modal('hide');

	  	$("#btn_actionmodulo").removeAttr('disabled');

	  	$('#form_modal_modulo').on('hidden.bs.modal', function (e) {
		  // do something...
		  //console.log(e)
		  $('#form_modal_rol').modal('show');
		});	
  	});

  	$("#btn_actionmodulo").jquery_controller('modulo','inserta/edita','modulos',false,'',false);
  	//------------------------------------------------------------------------------------------------------------------
});