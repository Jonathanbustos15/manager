$(function(){
	//console.log('hola desde selects formatos')
	//

	//----------------------------------------------------------------------------------------------------------------------
	//funciones para el modal de tdocumentos
	console.log('Hola tdocumentos...');

	//---------------------------------------------------------
	//variable para el objeto del formulario
	var objt_f_tdocumento = {};
	//variable de accion del boton del formulario
	var action = "";
	  //variable para el id del registro
	var id_tdocumento = "";

	//--------------------------------------------------------- 
	function valida_action_tdocumento(action){

		var campo = validaCampo('tdocumento','tipo_documento','nombre_tdoc');

		campo.success(function(data){
			console.log(data);

			if (data.estado == "Error") {
				//esta bien
				/**/
		  		if(action==="crear"){
		    		crea_tdocumento();
		    		//subida_foto();
		  		}else if(action==="editar"){
		    		edita_tdocumento();
		  		};
			} else{
				//ya esta creado
				alert("El registro que esta tratando de crear ya existe y no se puede duplicar.");
			};
		});

		
	};
	//---------------------------------------------------------
	

	//-------------------------------------------------------------------------------------------

	function validaCampo(nom_modulo,nom_tabla,nom_campo){
      //SELECT nombre FROM `estudio` where nombre LIKE 'Ingeniería de Sistemas'
      
      var val_campo = $("#form_"+nom_modulo)[0][nom_campo]["value"];
      //console.log(val_campo)
      var cons_validaCampo = 'select '+nom_campo+' from '+nom_tabla+' where '+nom_campo+' LIKE "'+val_campo+'" ';
      console.log(cons_validaCampo)
      
      /**/
      return $.ajax({
          url: '../controller/ajaxController12.php',
          data: "query="+cons_validaCampo+"&tipo=consulta_gen",
      })
      .done(function(data) {
        
        //console.log(data)            
        
      })
      .fail(function() {
          console.log("error");
      })
      .always(function() {
          console.log("complete");
      });
      //---------------------------------------------------------------          
    }
   

    function crea_tdocumento(){

	      //--------------------------------------
	      //crea el objeto formulario serializado
	      objt_f_tdocumento = $("#form_tdocumento").valida();
	      
	      console.log(objt_f_tdocumento.srlz);
	      //--------------------------------------
	      /**/
	      if( objt_f_tdocumento.estado == true ){	      

	        $.ajax({
	          url: "../controller/ajaxController12.php",
	          data: objt_f_tdocumento.srlz+"&tipo=inserta&nom_tabla=tipo_documento",
	        })
	        .done(function(data) {	          
	          //---------------------
	          console.log(data);
	          
	          //var pkID_tdocumento = data[0].last_id;
	         
	          //insertaArchivo("pkID_hojaVida="+pkID_hojaVida+"&url_archivo="+val[0].name+"&des_archivo="+getValoresDesc(val[0].name);
	                   
	          //$("#btn_actiontdocumento").attr('enabled','enabled');

	          alert(data[0].mensaje);
	          //location.reload();
	          $('#form_modal_tdocumento').modal('hide');

	          $('#form_modal_tdocumento').on('hidden.bs.modal', function (e) {
				  // do something...
				  //console.log(e)
				  $('#form_modal_documentos').modal('show');
				  $('#form_modal_documentos').modal('handleUpdate');
				});	
	          
	          
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
	$("#btn_nuevotdocumento").click(function(){

	  	$("#lbl_form_tdocumento").html("Nuevo Tipo de Documento");
	  	$("#lbl_btn_actiontdocumento").html("Guardar <span class='glyphicon glyphicon-save'></span>");
	  	$("#btn_actiontdocumento").attr("data-action","crear");

	  	$("#btn_actiontdocumento").removeAttr('disabled');
	     //validaBtnGuardar();

	  	$("#form_tdocumento")[0].reset();

	  	//cierra modal formato
	  	$('#form_modal_documentos').modal('hide');

	  	$('#form_modal_tdocumento').on('hidden.bs.modal', function (e) {
		  // do something...
		  //console.log(e)
		  $('#form_modal_documentos').modal('show');
		  $('#form_modal_documentos').modal('handleUpdate');
		});	      	   
	});	

	/*
	Botón de accion de formulario
	*/
	$("#btn_actiontdocumento").click(function(){
		
		action = $(this).attr("data-action");
		valida_action_tdocumento(action);
		console.log("accion a ejecutar: "+action); 
		//subida_archivo();   
	});

	//-------------------------------------------------------------------------------------

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
	function valida_action_subtipo(action){

		var campo = validaCampo('subtdocumento','tipo_documento','nombre_tdoc');

		campo.success(function(data){
			
			console.log(data);

			if (data.estado == "Error") {
				//esta bien
				/**/
		  		if(action==="crear"){
		    		crea_subcategoria();
		    		//subida_foto();
		  		}else if(action==="editar"){
		    		//edita_subcategoria();
		  		};
			} else{
				//ya esta creado
				alert("El registro que esta tratando de crear ya existe y no se puede duplicar.");
			};

		});
		
	};
	//---------------------------------------------------------
	

	//-------------------------------------------------------------------------------------------
   

    function crea_subcategoria(){

	      //--------------------------------------
	      //crea el objeto formulario serializado
	      objt_f_subcategoria = $("#form_subtdocumento").valida();
	      
	      //console.log(objt_f_adminPublicidad.srlz);
	      //--------------------------------------
	      /**/
	      if( objt_f_subcategoria.estado == true ){	      

	        $.ajax({
	          url: "../controller/ajaxController12.php",
	          data: objt_f_subcategoria.srlz+"&tipo=inserta&nom_tabla=tipo_documento",
	        })
	        .done(function(data) {	          
	          //---------------------
	          console.log(data);
	          
	          //var pkID_subcategoria = data[0].last_id;
	         
	          //insertaArchivo("pkID_hojaVida="+pkID_hojaVida+"&url_archivo="+val[0].name+"&des_archivo="+getValoresDesc(val[0].name);
	                   
	          //$("#btn_actionsubcategoria").attr('enabled','enabled');

	          alert(data[0].mensaje);

	          $('#form_modal_subtdocumento').modal('hide');
	          
	          $('#form_modal_subtdocumento').on('hidden.bs.modal', function (e) {
				  // do something...
				  //console.log(e)
				  $('#form_modal_documentos').modal('show');
				  $('#form_modal_documentos').modal('handleUpdate');
				});
	          
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
	$("#btn_nuevosubtdocumento").click(function(){
		/**/
	  	$("#lbl_form_subtdocumento").html("Nueva Sub-categoría");
	  	$("#lbl_btn_actionsubtdocumento").html("Guardar <span class='glyphicon glyphicon-save'></span>");
	  	$("#btn_actionsubtdocumento").attr("data-action","crear");

	  	$("#btn_actionsubtdocumento").removeAttr('disabled');
	     //validaBtnGuardar();

	  	$("#form_subtdocumento")[0].reset();

	  	//cierra modal 
	  	$('#form_modal_documentos').modal('hide');

	  	$('#form_modal_subtdocumento').on('hidden.bs.modal', function (e) {
		  // do something...
		  //console.log(e)
		  $('#form_modal_documentos').modal('show');
		  $('#form_modal_documentos').modal('handleUpdate');
		});

	});

	
	/*
	Botón de accion de formulario
	*/
	$("#btn_actionsubtdocumento").click(function(){
		/**/
		action = $(this).attr("data-action");
		valida_action_subtipo(action);
		console.log("accion a ejecutar: "+action); 
		//subida_archivo(); 
	});

	//-------------------------------------------------------------------------------------
});