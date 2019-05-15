$(function(){


	$("#btn_nuevoUsuario").jquery_controllerV2({
  		nom_modulo:'usuario',
  		titulo_label:'Nuevo Usuario',
  		ejecutarFunction:true,
  		functionBefore:function(ajustes){
  			console.log('Ejecutando antes de todo...');
  			console.log(ajustes);
  			//$("#btn_actionusuario").html("Esto es antes...")
  		},
  		functionAfter:function(ajustes){
  			console.log('Ejecutando despues de todo...');
  			//console.log(ajustes);
  			destruye_cambia_pass();
  		}
  	});  	

  	$("#btn_actionusuario").jquery_controllerV2({
  		tipo:'inserta/edita',
  		nom_modulo:'usuario',
  		nom_tabla:'usuarios',
  		//recarga:true,
  		ejecutarFunction:true,
  		functionBefore:function(ajustes){
  			console.log('Ejecutando antes de todo...');
  			console.log(ajustes);
  			//$("#btn_actionusuario").html("Esto es antes...")
  		},
  		functionAfter:function(data){
  			console.log('Ejecutando despues de todo...');
  			console.log(data);  		
  		}  		 		  
  	});

  	$("[name*='edita_usuario']").jquery_controllerV2({
		tipo:'carga_editar',
  		nom_modulo:'usuario',
  		nom_tabla:'usuarios',
  		titulo_label:'Editar Usuario',
  		tipo_load:1,
  		ejecutarFunction:true,
  		functionBefore:function(ajustes){
  			console.log('Ejecutando antes de todo...');
  			console.log(ajustes);
  			crea_cambia_pass();
  		},
  		functionAfter:function(data){
  			console.log('Ejecutando despues de todo...');
  			console.log(data);  		
  		}
	});	

  	$("[name*='elimina_usuario']").jquery_controllerV2({
  		tipo:'eliminar',
  		nom_modulo:'usuario',
  		nom_tabla:'usuarios',
  		ejecutarFunction:true,
  		functionBefore:function(ajustes){
  			console.log('Ejecutando antes de todo...');
  			console.log(ajustes);  			
  		},
  		functionAfter:function(data){
  			console.log('Ejecutando despues de todo...');
  			console.log(data);  		
  		}
  	}); 

  	//funciones cambiar de pass---------------------------------------------------------------------

    function crea_cambia_pass(){

    	destruye_cambia_pass();

    	$("#pass").attr("readonly","true");

    	$(".modal-footer").append('<button id="btn_passUsuario" type="button" class="btn btn-warning" data-action="-">'+
            '<span id="lbl_btn_passUsuario"></span>'+
        '</button>');

        
        $("#btn_passUsuario").html("Cambiar Contraseña");

        $("#btn_passUsuario").attr('data-action', 'cambia_pass');

        $("#btn_passUsuario").click(function(event) {
	  		/* Act on the event */
	  		$("#btn_actionUsuario").attr('class', 'hidden');
	  		pass = $("#pass").val();

	  		var action_pass = $(this).attr('data-action');
	  		valida_action_pass(action_pass);
	  	});

	  	function valida_action_pass(action_pass){

	  		if(action_pass == "cambia_pass"){
	  			cambia_pass();
	  		}else if(action_pass == "edita_pass"){
	  			
	  			edita_pass(pass);
	  		}
	  	}

	  	function cambia_pass(){

	  		$("#btn_passUsuario").attr('data-action', 'edita_pass');
	  		$("#btn_passUsuario").html("Guardar Contraseña");

	  		$("#pass").removeAttr('readonly');

	  		$("#pass").val("");

	  		$("#pass").focus();
	  	}

	  	function edita_pass(pass){

	    	console.log("Carga pass "+pass);

		    $.ajax({
		        url: '../controller/ajaxController12.php',
		        data: "pkID="+id_usuario+"&pass="+pass+"&tipo=actualiza_usuario&nom_tabla=usuarios",
		    })
		    .done(function(data) {
		    	console.log(data);
		    	alert(data.mensaje);
		    	location.reload();
		    })
		    .fail(function() {
		        console.log("error");
		    })
		    .always(function() {
		        console.log("complete");
		    });
	    }
    };    
    

    function destruye_cambia_pass(){

    	$("#pass").removeAttr('readonly');

    	$("#btn_passUsuario").remove();
    }

    //-------------------------------------------------------------------------
    //validacion del email con funcion de helper_global.js
    $("#email").change(function(event) {
		/* Act on the event */
		validarEmail( $(this) )
	});
	//-------------------------------------------------------------------------
})