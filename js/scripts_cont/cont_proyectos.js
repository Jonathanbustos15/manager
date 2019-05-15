$(function(){
	console.log('hola desde proyectos.');

	//---------------------------------------------------------
	//
	uppercaseForm("form_proyecto");
	//---------------------------------------------------------
	//variable para el objeto del formulario
	var objt_f_proyecto = {};
	//variable de accion del boton del formulario
	var action = "";
	  //variable para el id del registro
	var id_proyecto = "";

	var options_format = {
		symbol : "$",
		decimal : ",",
		thousand: ".",
		precision : 0,
		format: "%s%v"
	};
	//--------------------------------------------------------- 
	function valida_action(action){

  		if(action==="crear"){
    		crea_proyecto();  
    	
  		}else if(action==="editar"){
    		edita_proyecto();
  		};
	};
	//---------------------------------------------------------

	function crea_proyecto(){

	      //--------------------------------------
	      //crea el objeto formulario serializado
	      objt_f_proyecto = $("#form_proyecto").valida();	      	     
	      //--------------------------------------
	      /**/

	      if( objt_f_proyecto.estado == true ){	      

	        $.ajax({
	          url: "../controller/ajaxController12.php",
	          data: objt_f_proyecto.srlz+"&tipo=inserta&nom_tabla=proyectos",
	        })
	        .done(function(data) {	          
	          //---------------------
	          console.log(data);	         	         

	          alert(data[0].mensaje);
	          location.reload();
	          
	        })
	        .fail(function(data) {
	          console.log(data);	                   
	        })
	        .always(function() {
	          console.log("complete");
	        });

	      }else{
	        alert("El formulario no está totalmente diligenciado, revíselo e inténtelo de nuevo.");
	      };

	};
	//cierra crea

	function carga_proyecto(id_proyecto){

	    console.log("Carga el proyecto "+id_proyecto);

	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "pkID="+id_proyecto+"&tipo=consultar&nom_tabla=proyectos",
	    })
	    .done(function(data) {
	    	/**/
	        $.each(data.mensaje[0], function( key, value ) {
	          console.log(key+"--"+value);
	          $("#"+key).val(value);

	          if (key == "subtotal") {
	          	$("#subtotal_mask").val(accounting.formatNumber(value,options_format));
	          };

	          if (key == "iva") {
	          	$("#iva_mask").val(accounting.formatNumber(value,options_format));
	          };

	          if (key == "total") {
	          	$("#total_mask").val(accounting.formatNumber(value,options_format));
	          };

	        });

	        id_proyecto = data.mensaje[0].pkID;
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
	};
	//cierra carga_proyecto

	function edita_proyecto(){

	    //--------------------------------------
	    //crea el objeto formulario serializado
	    objt_f_proyecto = $("#form_proyecto").valida();
	 		    
	    //--------------------------------------
	    /**/
	    if( objt_f_proyecto.estado == true ) {

	        console.log(objt_f_proyecto.srlz);

	        $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: objt_f_proyecto.srlz+"&tipo=actualizar&nom_tabla=proyectos",
	        })
	        .done(function(data) {	           
	          //---------------------
	          console.log(data);
	          

	          id_proyecto = $("#pkID").val();	         	        

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
	        alert("Faltan "+Object.keys(objt_f_proyecto.objt).length+" campos por llenar.");
	    }
	    //------------------------------------------------------

    };
    //cierra funcion edita_proyecto

    function elimina_proyecto(id_proyecto){

	    console.log('Eliminar el proyecto: '+id_proyecto);

	    var confirma = confirm("En realidad quiere eliminar este proyecto?");

	    console.log(confirma);
	    /**/
	    if(confirma == true){
	      //si confirma es true ejecuta ajax
	      $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: "pkID="+id_proyecto+"&tipo=eliminar&nom_tabla=proyectos",
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
    //cierra funcion eliminar proyecto

	//-------------------------------------------------------------------------------
	//ejecución
	//-------------------------------------------------------------------------------	
	
	/*
	Botón que carga el formulario para insertar
	*/
	$("#btn_nuevoProyecto").click(function(){

	  	$("#lbl_form_proyecto").html("Nuevo Proyecto");
	  	$("#lbl_btn_actionProyecto").html("Guardar <span class='glyphicon glyphicon-save'></span>");
	  	$("#btn_actionProyecto").attr("data-action","crear");

	  	$("#btn_actionProyecto").removeAttr('disabled');	    

	  	$("#form_proyecto")[0].reset();

	});

	/*
	Botón que carga el formulario para editar
	*/  
	$("[name*='edita_proyecto']").click(function(event) {

		$("#lbl_form_proyecto").html("Editar Proyecto");
		$("#lbl_btn_actionProyecto").html("Guardar Cambios <span class='glyphicon glyphicon-pencil'></span>");
		$("#btn_actionProyecto").attr("data-action","editar");

		$("#form_proyecto")[0].reset();

		id_proyecto = $(this).attr('data-id-proyecto');

		$("#btn_actionProyecto").removeAttr('disabled');
		
		carga_proyecto(id_proyecto);		
	});

	/*
	Botón que elimina registro
	*/  
	$("[name*='elimina_proyecto']").click(function(event) {		
		id_proyecto = $(this).attr('data-id-proyecto');		
		elimina_proyecto(id_proyecto);
	});

	/*
	Botón de accion de formulario
	*/
	$("#btn_actionProyecto").click(function(){
		
		action = $(this).attr("data-action");
		valida_action(action);
		console.log("accion a ejecutar: "+action); 
		//subida_archivo();   
	});

	//-------------------------------------------------------------------------------------
	$("#nombre_entidad").keyup(function(event) {
		/* Act on the event */
		//console.log('escribiendo el nombre de la entidad.')
		var cadena = $(this).val();
		$(this).val(cadena.toUpperCase());
	});

	//-------------------------------------------------------------------------------------
	//unsetear el elemento de las tablas
	sessionStorage.setItem("id_tab_proyecto",null);
});