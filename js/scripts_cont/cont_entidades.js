$(function(){
	console.log('Hola entidad...');

	//---------------------------------------------------------
	//variable para el objeto del formulario
	var objt_f_entidad = {};
	//variable de accion del boton del formulario
	var action = "";
	  //variable para el id del registro
	var id_entidad = "";

	//--------------------------------------------------------- 
	function valida_action(action){

  		if(action==="crear"){
    		crea_entidad();
    		//subida_foto();
  		}else if(action==="editar"){
    		edita_entidad();
  		};
	};
	//---------------------------------------------------------
	

	//-------------------------------------------------------------------------------------------
   

    function crea_entidad(){

	      //--------------------------------------
	      //crea el objeto formulario serializado
	      objt_f_entidad = $("#form_entidad").valida();
	      
	      //console.log(objt_f_adminPublicidad.srlz);
	      //--------------------------------------
	      /**/
	      if( objt_f_entidad.estado == true ){	      

	        $.ajax({
	          url: "../controller/ajaxController12.php",
	          data: objt_f_entidad.srlz+"&tipo=inserta&nom_tabla=entidades",
	        })
	        .done(function(data) {	          
	          //---------------------
	          console.log(data);
	          
	          //var pkID_entidad = data[0].last_id;
	         
	          //insertaArchivo("pkID_hojaVida="+pkID_hojaVida+"&url_archivo="+val[0].name+"&des_archivo="+getValoresDesc(val[0].name);
	                   
	          //$("#btn_actionentidad").attr('enabled','enabled');

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

	

	function elimina_entidad(id_entidad){

	    console.log('Eliminar el entidad: '+id_entidad);

	    var confirma = confirm("En realidad quiere eliminar esta entidad?");

	    console.log(confirma);
	    /**/
	    if(confirma == true){
	      //si confirma es true ejecuta ajax
	      $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: "pkID="+id_entidad+"&tipo=eliminar&nom_tabla=entidades",
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
    //cierra funcion eliminar entidad

	function edita_entidad(){

	    //--------------------------------------
	    //crea el objeto formulario serializado
	    objt_f_entidad = $("#form_entidad").valida();
	 		    
	    //--------------------------------------
	    /**/
	    if( objt_f_entidad.estado == true) {

	        console.log(objt_f_entidad.srlz);

	        $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: objt_f_entidad.srlz+"&tipo=actualizar&nom_tabla=entidades",
	        })
	        .done(function(data) {	           
	          //---------------------
	          console.log(data);
	          

	          id_entidad = $("#pkID").val();	         	        

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
	        alert("Faltan "+Object.keys(objt_f_entidad.objt).length+" campos por llenar.");
	    }
	    //------------------------------------------------------

    };
    //cierra funcion edita_entidad

	function carga_entidad(id_entidad){

	    console.log("Carga el entidad "+id_entidad);

	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "pkID="+id_entidad+"&tipo=consultar&nom_tabla=entidades",
	    })
	    .done(function(data) {
	    	/**/
	        $.each(data.mensaje[0], function( key, value ) {
	          console.log(key+"--"+value);
	          $("#"+key).val(value);
	        });

	        id_entidad = data.mensaje[0].pkID;

	        

	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });

	};
	//cierra carga_entidad


	//-------------------------------------------------------------------------------
	//ejecución
	//-------------------------------------------------------------------------------	
	
	/*
	Botón que carga el formulario para insertar
	*/
	$("#btn_nuevoentidad").click(function(){

	  	$("#lbl_form_entidad").html("Nueva Entidad");
	  	$("#lbl_btn_actionentidad").html("Guardar <span class='glyphicon glyphicon-save'></span>");
	  	$("#btn_actionentidad").attr("data-action","crear");

	  	$("#btn_actionentidad").removeAttr('disabled');
	     //validaBtnGuardar();

	  	$("#form_entidad")[0].reset();	      	   
	});

	/*
	Botón que carga el formulario para editar
	*/  
	$("[name*='edita_entidad']").click(function(event) {

		$("#lbl_form_entidad").html("Editar Entidad");
		$("#lbl_btn_actionentidad").html("Guardar Cambios <span class='glyphicon glyphicon-pencil'></span>");
		$("#btn_actionentidad").attr("data-action","editar");

		$("#form_entidad")[0].reset();

		id_entidad = $(this).attr('data-id-entidad');

		$("#btn_actionentidad").removeAttr('disabled');
		

		carga_entidad(id_entidad);
		//carga_propiedades(id_entidad);
	});

	/*
	Botón que elimina registro
	*/  
	$("[name*='elimina_entidad']").click(function(event) {		
		id_entidad = $(this).attr('data-id-entidad');		
		elimina_entidad(id_entidad);
	});

	/*
	Botón de accion de formulario
	*/
	$("#btn_actionentidad").click(function(){
			
		action = $(this).attr("data-action");
		valida_action(action);
		console.log("accion a ejecutar: "+action); 
		//subida_archivo();   
	});

	//-------------------------------------------------------------------------------------

});