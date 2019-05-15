$(function(){
	console.log('hola desde usuarios');

	//---------------------------------------------------------
	//variable para el objeto del formulario
	var objt_f_usuario = {};
	//variable de accion del boton del formulario
	var action = "";
	  //variable para el id del registro
	var id_usuario = "";

	var pass = "";
	//---------------------------------------------------------

	function valida_action(action){

  		if(action==="crear"){
    		crea_usuario();    		
  		}else if(action==="editar"){
    		edita_usuario();
  		};
	};


	function crea_usuario(){

	      //--------------------------------------
	      //crea el objeto formulario serializado
	      objt_f_usuario = $("#form_usuario").valida();
	      //email = $("#email").val(); && (validarEmail(email))
	      console.log(objt_f_usuario);
	      //console.log(objt_f_adminPublicidad.srlz);
	      //--------------------------------------
	      /**/
	      if( objt_f_usuario.estado == true ){

	        $.ajax({
	          url: "../controller/ajaxController12.php",
	          data: objt_f_usuario.srlz+"&tipo=inserta_registro&nom_tabla=usuarios",
	        })
	        .done(function(data) {	          
	          //---------------------
	          console.log(data);
	          
	          var id_last_usuario = data[0].last_id;

	          matrixRelation.serializa_array(matrixRelation.crea_array(matrixRelation.arrElementos,id_last_usuario));

	          alert(data[0].mensaje);

	          location.reload();          
	        })
	        .fail(function(data) {
	          console.log(data);
	          //alert(data[0].mensaje);          
	        })
	        .always(function() {
	          console.log("complete");
	        });

	      }else{
	        alert("El formulario no está totalmente diligenciado, revíselo e inténtelo de nuevo.");
	      };

	    };
	  //cierra crea

	function edita_usuario(){

	    //--------------------------------------
	    //crea el objeto formulario serializado
	    objt_f_usuario = $("#form_usuario").valida();
	    //email = $("#email").val(); ) && (validarEmail(email)) 
	    //--------------------------------------

	    if( objt_f_usuario.estado == true ){

	        console.log(objt_f_usuario.srlz);

	        $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: objt_f_usuario.srlz+"&tipo=actualizar&nom_tabla=usuarios",
	        })
	        .done(function(data) {	           
	            //---------------------
	            console.log(data.mensaje.mensaje);
	            alert(data.mensaje.mensaje);
	            location.reload();
	        })
	        .fail(function() {
	            console.log("error");
	        })
	        .always(function() {
	            console.log("complete");
	        });

	    }else{
	        alert("Faltan "+Object.keys(objt_f_usuario.objt).length+" campos por llenar.");
	    }
	    //------------------------------------------------------
	};
    //cierra funcion

    function elimina_usuario(id_usuario){

	    console.log('Eliminar el usuario: '+id_usuario);

	    var confirma = confirm("En realidad quiere eliminar este usuario?");

	    console.log(confirma);
	    /**/
	    if(confirma == true){
	      //si confirma es true ejecuta ajax
	      $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: "pkID="+id_usuario+"&tipo=eliminar&nom_tabla=usuarios",
	        })
	        .done(function(data) {            
	            //---------------------
	            console.log(data);

	            alert(data.mensaje.mensaje);
	            
	            location.reload();
	        })
	        .fail(function() {
	            console.log("error");
	        })
	        .always(function() {
	            console.log("complete");
	        });
	    }else{
	      //no hace nada
	    }
    };
    //cierra funcion eliminar usuario

	function carga_usuario(id_usuario){

	    console.log("Carga el usuario "+id_usuario);

	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "pkID="+id_usuario+"&tipo=consultar&nom_tabla=usuarios",
	    })
	    .done(function(data) {
	    	/**/
	        $.each(data.mensaje[0], function( key, value ) {
	          console.log(key+"--"+value);
	          $("#"+key).val(value);
	        });

	        matrixRelation.carga_elementos(data.mensaje[0].pkID);

	        crea_cambia_pass();
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });

    };
    //cierra carga_usuario


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

	//---------------------------------------------------------
	//ejecución
	//-------------------------------------------------------------------------------
	/*
	Botón que carga el formulario para insertar
	*/
	$("#btn_nuevoUsuario").click(function(){

	  	$("#lbl_form_usuario").html("Nuevo Registro usuario");
	  	$("#lbl_btn_actionUsuario").html("Guardar<span class='glyphicon glyphicon-chevron-right'></span>");
	  	$("#btn_actionUsuario").attr("data-action","crear");

	  	$("#form_usuario")[0].reset();
	  	
	  	destruye_cambia_pass();

	  	$("#"+matrixRelation.formulario_add).html("");
	  	matrixRelation.arrElementos.length = 0;
		matrixRelation.arrElementosRelation.length=0;	      	   
	});

	/*
    Botón que carga el formulario para editar
    */  
    $("[name*='edita_usuario']").click(function(event) {

        $("#lbl_form_usuario").html("Editar Registro usuario");
        $("#lbl_btn_actionUsuario").html("Guardar Cambios<span class='glyphicon glyphicon-chevron-right'></span>");
        $("#btn_actionUsuario").attr("data-action","editar");

        $("#form_usuario")[0].reset();
	      
        id_usuario = $(this).attr('data-id-usuario');
	      
        carga_usuario(id_usuario);

        crea_cambia_pass();
        //carga_usuarioes(id_usuario);
        
    });

    /*
	Botón de accion de formulario
	*/
	$("#btn_actionUsuario").click(function(){

      /**/
	  	action = $(this).attr("data-action");

	  	valida_action(action);

	  	console.log("accion a ejecutar: "+action);     

	});

	$("[name*='elimina_usuario']").click(function(event) {
	    /* Act on the event */
	    id_usuario = $(this).attr('data-id-usuario');

	    elimina_usuario(id_usuario);

	  });	  

  	//---------------------------------------------------------
  	//validacion de email
  	
	$("#email").change(function(event) {
		/* Act on the event */
		validarEmail( $(this) )
	});
  	//----------------------------------------------------------

  	//----------------------------------------------------------
  	//añade empresas a usuario
  	matrixRelation.nombre_modulo = "empresa";
  	matrixRelation.nombre_modulo2 = "usuario";
  	matrixRelation.nombre_tabla = "usuarios_empresas";
  	matrixRelation.seleccionador = "select_empresa";
  	matrixRelation.btn_accion = "btn_actionUsuario";
  	matrixRelation.formulario_add = "frm_usuarios_empresas";

  	matrixRelation.setup();
  	
  	//----------------------------------------------------------
}); 