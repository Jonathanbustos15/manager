$(function(){
	console.log('Hola categorias...');

	//---------------------------------------------------------
	//variable para el objeto del formulario
	var objt_f_categoria = {};
	//variable de accion del boton del formulario
	var action = "";
	  //variable para el id del registro
	var id_categoria = "";

	//--------------------------------------------------------- 
	function valida_action(action){

  		if(action==="crear"){
    		crea_categoria();
    		//subida_foto();
  		}else if(action==="editar"){
    		edita_categoria();
  		};
	};
	//---------------------------------------------------------
	

	//-------------------------------------------------------------------------------------------
   

    function crea_categoria(){

	      //--------------------------------------
	      //crea el objeto formulario serializado
	      objt_f_categoria = $("#form_categoria").valida();
	      
	      //console.log(objt_f_adminPublicidad.srlz);
	      //--------------------------------------
	      /**/
	      if( objt_f_categoria.estado == true ){	      

	        $.ajax({
	          url: "../controller/ajaxController12.php",
	          data: objt_f_categoria.srlz+"&tipo=inserta&nom_tabla=categoria",
	        })
	        .done(function(data) {	          
	          //---------------------
	          console.log(data);
	          
	          //var pkID_categoria = data[0].last_id;
	         
	          //insertaArchivo("pkID_hojaVida="+pkID_hojaVida+"&url_archivo="+val[0].name+"&des_archivo="+getValoresDesc(val[0].name);
	                   
	          //$("#btn_actioncategoria").attr('enabled','enabled');

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

	

	function elimina_categoria(id_categoria){

	    console.log('Eliminar el categoria: '+id_categoria);

	    var confirma = confirm("En realidad quiere eliminar este categoria?");

	    console.log(confirma);
	    /**/
	    if(confirma == true){
	      //si confirma es true ejecuta ajax
	      $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: "pkID="+id_categoria+"&tipo=eliminar&nom_tabla=categoria",
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
    //cierra funcion eliminar categoria

	function edita_categoria(){

	    //--------------------------------------
	    //crea el objeto formulario serializado
	    objt_f_categoria = $("#form_categoria").valida();
	 		    
	    //--------------------------------------
	    /**/
	    if( objt_f_categoria.estado == true) {

	        console.log(objt_f_categoria.srlz);

	        $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: objt_f_categoria.srlz+"&tipo=actualizar&nom_tabla=categoria",
	        })
	        .done(function(data) {	           
	          //---------------------
	          console.log(data);
	          

	          id_categoria = $("#pkID").val();	         	        

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
	        alert("Faltan "+Object.keys(objt_f_categoria.objt).length+" campos por llenar.");
	    }
	    //------------------------------------------------------

    };
    //cierra funcion edita_categoria

	function carga_categoria(id_categoria){

	    console.log("Carga el categoria "+id_categoria);

	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "pkID="+id_categoria+"&tipo=consultar&nom_tabla=categoria",
	    })
	    .done(function(data) {
	    	/**/
	        $.each(data.mensaje[0], function( key, value ) {
	          console.log(key+"--"+value);
	          $("#"+key).val(value);
	        });

	        id_categoria = data.mensaje[0].pkID;

	        

	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });

	};
	//cierra carga_categoria


	//-------------------------------------------------------------------------------
	//ejecución
	//-------------------------------------------------------------------------------	
	
	/*
	Botón que carga el formulario para insertar
	*/
	$("#btn_nuevoCategoria").click(function(){

	  	$("#lbl_form_categoria").html("Nueva categoría");
	  	$("#lbl_btn_actionCategoria").html("Guardar <span class='glyphicon glyphicon-save'></span>");
	  	$("#btn_actionCategoria").attr("data-action","crear");

	  	$("#btn_actionCategoria").removeAttr('disabled');
	     //validaBtnGuardar();

	  	$("#form_categoria")[0].reset();	      	   
	});

	/*
	Botón que carga el formulario para editar
	*/  
	$("[name*='edita_categoria']").click(function(event) {

		$("#lbl_form_categoria").html("Editar categoría");
		$("#lbl_btn_actionCategoria").html("Guardar Cambios <span class='glyphicon glyphicon-pencil'></span>");
		$("#btn_actionCategoria").attr("data-action","editar");

		$("#form_categoria")[0].reset();

		id_categoria = $(this).attr('data-id-categoria');

		$("#btn_actionCategoria").removeAttr('disabled');
		

		carga_categoria(id_categoria);
		//carga_propiedades(id_categoria);
	});

	/*
	Botón que elimina registro
	*/  
	$("[name*='elimina_categoria']").click(function(event) {		
		id_categoria = $(this).attr('data-id-categoria');		
		elimina_categoria(id_categoria);
	});

	/*
	Botón de accion de formulario
	*/
	$("#btn_actionCategoria").click(function(){
		
		action = $(this).attr("data-action");
		valida_action(action);
		console.log("accion a ejecutar: "+action); 
		//subida_archivo();   
	});

	//-------------------------------------------------------------------------------------

});