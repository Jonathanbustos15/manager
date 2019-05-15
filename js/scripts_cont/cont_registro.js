$(function(){
	console.log('hola registro');

	//-------------------------------------------------------------
	//variables
	//variable para el objeto del formulario
	var objt_f_registro = {};	
	//variable de accion del boton del formulario
	var action = "";

	//-------------------------------------------------------------

	//functions--------------------------------------------------------------------

	function valida_action(action){

  		if(action==="crear"){
    		crea_registro();
    		//subida_foto();
  		}else if(action==="editar"){
    		//edita_registro();
  		};
	};
	//-------------------------------------------------------------
	
	function validarEmail( email ) {
	    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	    if ( !expr.test(email) ){
	    	alert("Error: La dirección de correo " + email + " es incorrecta.");
	    }else{
	    	return true;
	    }	    
	}

	function validarContrasena( pass ){

		if (pass != $("#pass").val()) {
			
			$("#pass").val("");
			$("#pass_conf").val("");

			$("#pass").focus();

			alert("Las contraseñas no coinciden.");
		};
	}

	function validaAlias( alias ){

		//sentencia sql a evaluar

		var valida_alias_sql = "SELECT * FROM `usuarios` WHERE `alias` = '"+alias+"'";

		$.ajax({
          url: "../controller/ajaxController12.php",
          data: "query="+valida_alias_sql+"&tipo=consulta_gen",
        })
        .done(function(data) {	          
          //---------------------
          console.log(data);
          console.log(data.mensaje);
          if ( data.mensaje != "No hay registros." ) {
          	alert("Este nombre de usuario no está disponible, por favor seleccione uno diferente.");
          	$("#alias").val("");
          	$("#alias").focus();
          };
        })
        .fail(function(data) {
          console.log(data);
          alert(data[0].mensaje);
        })
        .always(function() {
          console.log("complete");
        });
	}

	function crea_registro(){

	      //--------------------------------------
	      //crea el objeto formulario serializado
	      objt_f_registro = $("#form_registro").valida();
	      //email = $("#email").val();
	      console.log(objt_f_registro);
	      //console.log(objt_f_adminPublicidad.srlz);
	      //--------------------------------------
	      
	      if( (objt_f_registro.estado == true) && ( $("#pass").val() == $("#pass_conf").val() ) ){
	      	/**/
	        $.ajax({
	          url: "../controller/ajaxController12.php",
	          data: objt_f_registro.srlz+"&tipo=inserta_registro&nom_tabla=usuarios",
	        })
	        .done(function(data) {	          
	          //---------------------
	          console.log(data);
	          //crea_cliente();
	          alert(data[0].mensaje);
	          //location.reload();
	          window.location.href = "login.php";          
	        })
	        .fail(function(data) {
	          console.log(data);
	          alert(data[0].mensaje);
	        })
	        .always(function() {
	          console.log("complete");
	        });

	      }else{
	        alert("El formulario no está totalmente diligenciado, revíselo e inténtelo de nuevo.");
	      };

	    };
	  //cierra crea

	//-----------------------------------------------------------------------------

	//execution--------------------------------------------------------------------
	/*
	Botón de accion de formulario
	*/
	$("#btn_register").click(function(){

	     /**/
		  action = $(this).attr("data-action");

		  valida_action(action);

		  console.log("accion a ejecutar: "+action);     

	});

	$("#pass").change(function(event) {
		/* Act on the event */

		if ( $("#pass_conf").length ) {
		    

		}else{

			$( "#div_pass" ).after(
				'<div class="form-group">'+                     
	             	'<input id="pass_conf" name="pass_conf" class="form-control" placeholder="Confirmar Contraseña" type="password" value="">'+
	             '</div>'
			);
		}		

		$("#pass_conf").focus();

		$("#pass_conf").change(function(event) {
			/* Act on the event */
			validarContrasena($(this).val());
		});

	});

	$("#alias").change(function(event) {
		/* Act on the event */
		//hacer consulta por medio de ajax, para saber si
		//existe el alias en la base de datos.
		validaAlias( $(this).val() );
	});
	//-----------------------------------------------------------------------------
});