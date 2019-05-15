$(function(){
	console.log('Hola subcategoria...');

	//---------------------------------------------------------
	//variable para el objeto del formulario
	var objt_f_subcategoria = {};
	//variable de accion del boton del formulario
	var action = "";
	  //variable para el id del registro
	var id_subcategoria = "";

	//--------------------------------------------------------- 
	function valida_action(action){

  		if(action==="crear"){
    		crea_subcategoria();
    		//subida_foto();
  		}else if(action==="editar"){
    		edita_subcategoria();
  		};
	};
	//---------------------------------------------------------
	

	//-------------------------------------------------------------------------------------------
   

    function crea_subcategoria(){

	      //--------------------------------------
	      //crea el objeto formulario serializado
	      objt_f_subcategoria = $("#form_subcategoria").valida();
	      
	      //console.log(objt_f_adminPublicidad.srlz);
	      //--------------------------------------
	      /**/
	      if( objt_f_subcategoria.estado == true ){	      

	        $.ajax({
	          url: "../controller/ajaxController12.php",
	          data: objt_f_subcategoria.srlz+"&tipo=inserta&nom_tabla=categoria",
	        })
	        .done(function(data) {	          
	          //---------------------
	          console.log(data);
	          
	          //var pkID_subcategoria = data[0].last_id;
	         
	          //insertaArchivo("pkID_hojaVida="+pkID_hojaVida+"&url_archivo="+val[0].name+"&des_archivo="+getValoresDesc(val[0].name);
	                   
	          //$("#btn_actionsubcategoria").attr('enabled','enabled');

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

	

	function elimina_subcategoria(id_subcategoria){

	    console.log('Eliminar el subcategoria: '+id_subcategoria);

	    var confirma = confirm("En realidad quiere eliminar este subcategoria?");

	    console.log(confirma);
	    /**/
	    if(confirma == true){
	      //si confirma es true ejecuta ajax
	      $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: "pkID="+id_subcategoria+"&tipo=eliminar&nom_tabla=categoria",
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
    //cierra funcion eliminar subcategoria

	function edita_subcategoria(){

	    //--------------------------------------
	    //crea el objeto formulario serializado
	    objt_f_subcategoria = $("#form_subcategoria").valida();
	 		    
	    //--------------------------------------
	    /**/
	    if( objt_f_subcategoria.estado == true) {

	        console.log(objt_f_subcategoria.srlz);

	        $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: objt_f_subcategoria.srlz+"&tipo=actualizar&nom_tabla=categoria",
	        })
	        .done(function(data) {	           
	          //---------------------
	          console.log(data);
	          

	          id_subcategoria = $("#pkID").val();	         	        

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
	        alert("Faltan "+Object.keys(objt_f_subcategoria.objt).length+" campos por llenar.");
	    }
	    //------------------------------------------------------

    };
    //cierra funcion edita_subcategoria

	function carga_subcategoria(id_subcategoria){

	    console.log("Carga el subcategoria "+id_subcategoria);

	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "pkID="+id_subcategoria+"&tipo=consultar&nom_tabla=categoria",
	    })
	    .done(function(data) {
	    	/**/
	        $.each(data.mensaje[0], function( key, value ) {
	          console.log(key+"--"+value);
	          $("#"+key).val(value);
	        });

	        id_subcategoria = data.mensaje[0].pkID;

	        

	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });

	};
	//cierra carga_subcategoria


	//-------------------------------------------------------------------------------
	//ejecución
	//-------------------------------------------------------------------------------	
	
	/*
	Botón que carga el formulario para insertar
	*/
	$("#btn_nuevosubcategoria").click(function(){

	  	$("#lbl_form_subcategoria").html("Nueva Sub-categoría");
	  	$("#lbl_btn_actionsubcategoria").html("Guardar <span class='glyphicon glyphicon-save'></span>");
	  	$("#btn_actionsubcategoria").attr("data-action","crear");

	  	$("#btn_actionsubcategoria").removeAttr('disabled');
	     //validaBtnGuardar();

	  	$("#form_subcategoria")[0].reset();	      	   
	});

	/*
	Botón que carga el formulario para editar
	*/  
	$("[name*='edita_subcategoria']").click(function(event) {

		$("#lbl_form_subcategoria").html("Editar Sub-categoría");
		$("#lbl_btn_actionsubcategoria").html("Guardar Cambios <span class='glyphicon glyphicon-pencil'></span>");
		$("#btn_actionsubcategoria").attr("data-action","editar");

		$("#form_subcategoria")[0].reset();

		id_subcategoria = $(this).attr('data-id-subcategoria');

		$("#btn_actionsubcategoria").removeAttr('disabled');
		

		carga_subcategoria(id_subcategoria);
		//carga_propiedades(id_subcategoria);
	});

	/*
	Botón que elimina registro
	*/  
	$("[name*='elimina_subcategoria']").click(function(event) {		
		id_subcategoria = $(this).attr('data-id-subcategoria');		
		elimina_subcategoria(id_subcategoria);
	});

	/*
	Botón de accion de formulario
	*/
	$("#btn_actionsubcategoria").click(function(){
		
		action = $(this).attr("data-action");
		valida_action(action);
		console.log("accion a ejecutar: "+action); 
		//subida_archivo();   
	});

	//-------------------------------------------------------------------------------------

});