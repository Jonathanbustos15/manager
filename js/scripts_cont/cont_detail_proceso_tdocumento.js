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

  		if(action==="crear"){
    		crea_tdocumento();
    		//subida_foto();
  		}else if(action==="editar"){
    		edita_tdocumento();
  		};
	};
	//---------------------------------------------------------
	

	//-------------------------------------------------------------------------------------------
   

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
	          data: objt_f_tdocumento.srlz+"&tipo=inserta&nom_tabla=tipo_documento_proceso",
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
	          $('#form_modal_documentos').modal('show');
	          
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
});