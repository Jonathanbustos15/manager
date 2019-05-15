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
	          //location.reload();
	          $("#form_modal_entidad").modal('hide');
	          
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
	$("#btn_nuevoentidad").click(function(){

	  	$("#lbl_form_entidad").html("Nueva Entidad");
	  	$("#lbl_btn_actionentidad").html("Guardar <span class='glyphicon glyphicon-save'></span>");
	  	$("#btn_actionentidad").attr("data-action","crear");

	  	$("#btn_actionentidad").removeAttr('disabled');
	     //validaBtnGuardar();

	  	$("#form_entidad")[0].reset();

	  	$("#nombre_entidad").keyup(function(event) {
			/* Act on the event */
			//console.log('escribiendo el nombre de la entidad.')
			var cadena = $(this).val();
			$(this).val(cadena.toUpperCase());
		});

	  	$("#form_modal_proyecto").modal('hide');
	  	//--------------------------------------
	  	$("#form_modal_proceso").modal('hide');	      	   
	});

	$("#form_modal_entidad").on('hidden.bs.modal', function () {
	  //console.log('esconde el modal de entidad')
	  	$("#form_modal_proyecto").modal('show');
	  	//--------------------------------------
	  	$("#form_modal_proceso").modal('show');	
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
	//-------------------------------------------------------------------------------------
	
	//-------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------
	
	//-------------------------------------------------------------------------------------

});