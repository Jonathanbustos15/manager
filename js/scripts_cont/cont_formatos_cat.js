$(function(){
	//console.log('hola desde selects formatos')
	//

	//----------------------------------------------------------------------------------------------------------------------
	//funciones para el modal de categorias
	console.log('Hola categorias...');

	//---------------------------------------------------------
	//variable para el objeto del formulario
	var objt_f_categoria = {};
	//variable de accion del boton del formulario
	var action = "";
	  //variable para el id del registro
	var id_categoria = "";

	//--------------------------------------------------------- 
	function valida_action_categoria(action){

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
	      
	      console.log(objt_f_categoria.srlz);
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
	          //location.reload();
	          $('#form_modal_categoria').modal('hide');
	          $('#form_modal_formato').modal('show');
	          
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

	  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


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

	  	//cierra modal formato
	  	$('#form_modal_formato').modal('hide');

	  	$('#form_modal_categoria').on('hidden.bs.modal', function (e) {
		  // do something...
		  //console.log(e)
		  $('#form_modal_formato').modal('show');
		});	      	   
	});	

	/*
	Botón de accion de formulario
	*/
	$("#btn_actionCategoria").click(function(){
		
		action = $(this).attr("data-action");
		valida_action_categoria(action);
		console.log("accion a ejecutar: "+action); 
		//subida_archivo();   
	});

	//validación de duplicidad de los nombres de las categorías.--------------------------

	var valida_nombre = true;
	//autocomplete formato
	$( "#nombre_cat" ).autocomplete({
      //source: "../DAO/autocompleta_formatos.php",
      
	  source: function(request, response) {
		    $.ajax({
		        url: "../DAO/autocompleta_formatos.php",
		        dataType: "json",
		        data: {
		            term : request.term,
		            tipo : "categoria"
		        },
		        success: function(data) {
		            response(data);
		        }
		    });
		},
      change: function(event, ui) {
        console.log(ui)
        /**/
        if (!valida_nombre) {
        	alert("Hay categorías parecidas ya registradas, por favor verifique.")
        	$(this).val("");
    	}
      },
      select: function( event, ui ) {      	
      	console.log(ui)      	
        $(this).val("")      		
      	$(this).focus();
      },
      response: function( event, ui ) {
      	//console.log(ui.content[0])
      	if (ui.content[0].value == null) {
      		valida_nombre = true;
      	} else{
      		valida_nombre = false;
      	};
      }
    });

    $( "#form_subcategoria [name='nombre_cat']" ).autocomplete({
      //source: "../DAO/autocompleta_formatos.php",
      
	  source: function(request, response) {
		    $.ajax({
		        url: "../DAO/autocompleta_formatos.php",
		        dataType: "json",
		        data: {
		            term : request.term,
		            tipo : "subcategoria"
		        },
		        success: function(data) {
		            response(data);
		        }
		    });
		},
      change: function(event, ui) {
        console.log(ui)
        /**/
        if (!valida_nombre) {
        	alert("Hay subcategorías parecidas ya registradas, por favor verifique.")
        	$(this).val("");
    	}
      },
      select: function( event, ui ) {      	
      	console.log(ui)      	
        $(this).val("")      		
      	$(this).focus();
      },
      response: function( event, ui ) {
      	//console.log(ui.content[0])
      	if (ui.content[0].value == null) {
      		valida_nombre = true;
      	} else{
      		valida_nombre = false;
      	};
      }
    });

    //--------------------------------------------------------------------    
	//estilo z index para hacer visible el autocompletado
    $("#ui-id-1").attr('style', 'display: none; top: 365px; left: 407px; z-index: 2147483647; width: 443px;');
    $("#ui-id-2").attr('style', 'display: none; top: 365px; left: 407px; z-index: 2147483647; width: 443px;');
    //-------------------------------------------------------------------


	//-------------------------------------------------------------------------------------


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

	          $('#form_modal_subcategoria').modal('hide');
	          $('#form_modal_formato').modal('show');
	          
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

	  	//cierra modal formato
	  	$('#form_modal_formato').modal('hide');

	  	$('#form_modal_subcategoria').on('hidden.bs.modal', function (e) {
		  // do something...
		  //console.log(e)
		  $('#form_modal_formato').modal('show');
		});

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