$(function(){
	//console.log('hola proyecto documentos');

	//---------------------------------------------------------
	//variable para el objeto del formulario
	var objt_f_documento = {};
	//variable de accion del boton del formulario
	var action = "";
	  //variable para el id del registro
	var id_documento = "";

	//--------------------------------------------------------- 
	function valida_action(action){

  		if(action==="crear"){

    		//crea_documento();
    		subida_archivo("crear");

  		}else if(action==="editar"){
    		//edita_documento();
    		subida_archivo("editar");
  		};
	};
	//----------------------------------------------------------

    function subida_archivo(nom_funcion){

           //---------------------------------------------------------------------------------------
           //CREA UNA VARIABLE  DE TIPO FormData que toma el formulario
           var formData = new FormData($("#form_documentos")[0]);
           //la ruta del php que ejecuta ajax
           var ruta = "../subida_archivo/ctrl_sub_objt.php";

           //hacemos la petición ajax
            $.ajax({
                url: ruta,
                type: 'POST',
                // Form data
                //datos del formulario
                data: formData,
                //necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
                //mientras enviamos el archivo
                beforeSend: function(){
                    console.log("Subiendo archivo, por favor espere...");
                    $("#not_docs_proceso").html("Subiendo archivo, por favor espere...");
                },
                //una vez finalizado correctamente
                success: function(data){
                  console.log(data);

                  if (data.clase == "alert alert-success") {

                  	$("#not_docs_proceso").html(data.estado);

                  	switch(nom_funcion){
	                  	case "crear":
	                  		crea_documento();
	                  	break;
	                  	case "editar":
	                  		edita_documento();
	                  	break;
	                  }

                  } else{
                  	$("#not_docs_proceso").html(data.estado);
                  };
                  //alert(data.estado);
                  //$("#not_img").removeAttr('hidden');
                  //$("#not_img").html(' <br /> <br /> <div class="'+data.clase+'" role="alert">'+data.estado+'</div>');
                  /*
                  switch(nom_funcion){
                  	case:"crear"
                  		crea_documento();
                  	break;
                  	case:"editar"
                  		edita_documento();
                  	break;
                  }*/

                },
                //si ha ocurrido un error
                error: function(){
                    console.log("Ha ocurrido un error.");
                }
            });
		//---------------------------------------------------------------------------------------
    };//cierra función subida*/

    function validaArchivo(){

    	var max_file = (1024*1024)*500;    	
    	
    	console.log(max_file);

		//obtenemos un array con los datos del archivo
		var file = $("[name='archivo']")[0].files[0];
		console.log(file)
		//obtenemos el nombre del archivo
		var fileName = file.name;
		//obtenemos la extensión del archivo
		var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
		//obtenemos el tamaño del archivo
		var fileSize = file.size;
		//obtenemos el tipo de archivo image/png ejemplo
		var fileType = file.type;
		//mensaje con la información del archivo
		//$("#respuesta").html("<span>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
		//application/x-rar
		if ( (fileSize <= max_file) && ( (fileType == "application/vnd.oasis.opendocument.text") || (fileType == "application/msword") || (fileType == "application/pdf") || (fileType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") || (fileType == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") || (fileType == "application/vnd.ms-excel") || (fileType == "application/x-rar") || (fileType == "") ) ) {
			$("#ruta").val(fileName);
			console.log("Archivo para subir: "+fileName+", peso total: "+fileSize+" de tipo:"+fileType);
			$("#not_docs_proceso").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
        												'Archivo para subir: '+fileName+', peso total: '+fileSize+' de tipo:'+fileType);
		}else{
			alert("El archivo supera el tamaño límite o no es de un tipo permitido.");
			$("[name='archivo']").val("");
			console.log("Archivo para subir: "+fileName+", peso total: "+fileSize+" de tipo:"+fileType);
			$("#not_docs_proceso").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
        												'El archivo supera el tamaño límite o no es de un tipo permitido. Archivo para subir: '+fileName+', peso total: '+fileSize+' de tipo:'+fileType);
		};
		
	}

	function crea_documento(){

      //--------------------------------------
      //crea el objeto formulario serializado
      objt_f_documento = $("#form_documentos").valida();
      
      //console.log(objt_f_adminPublicidad.srlz);
      //--------------------------------------
      /**/
      if( objt_f_documento.estado == true ){      

        $.ajax({
          url: "../controller/ajaxController12.php",
          data: objt_f_documento.srlz+"&tipo=inserta&nom_tabla=documentos_proceso",
        })
        .done(function(data) {	          
          //---------------------
          console.log(data);
          
          //var pkID_documento = data[0].last_id;
         
         // insertaArchivo("pkID_hojaVida="+pkID_hojaVida+"&url_archivo="+val[0].name+"&des_archivo="+getValoresDesc(val[0].name);
                   
          //$("#btn_actiondocumento").attr('enabled','enabled');

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

  	function elimina_documento(id_documento){

	    console.log('Eliminar el documento: '+id_documento);

	    var confirma = confirm("En realidad quiere eliminar este documento?");

	    console.log(confirma);
	    /**/
	    if(confirma == true){
	      //si confirma es true ejecuta ajax
	      $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: "pkID="+id_documento+"&tipo=eliminar&nom_tabla=documentos_proceso",
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
    //cierra funcion eliminar documento

	function edita_documento(){

	    //--------------------------------------
	    //crea el objeto formulario serializado
	    objt_f_documento = $("#form_documentos").valida();		   
	    //--------------------------------------
	    /**/
	    if( objt_f_documento.estado == true) {

	        console.log(objt_f_documento.srlz);

	        $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: objt_f_documento.srlz+"&tipo=actualizar&nom_tabla=documentos_proceso",
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
	        alert("Faltan "+Object.keys(objt_f_documento.objt).length+" campos por llenar.");
	    }
	    //------------------------------------------------------

    };
    //cierra funcion edita_documento

	function carga_documento(id_documento){

	    console.log("Carga el documento "+id_documento);

	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "pkID="+id_documento+"&tipo=consultar&nom_tabla=documentos_proceso",
	    })
	    .done(function(data) {
	    	/**/
	        $.each(data.mensaje[0], function( key, value ) {
	          console.log(key+"--"+value);
	          //$("#"+key).val(value);

	          /*
	          if(key == "pkID"){
	          	console.log($("[name*='"+key+"']")[1]);

	          	$("[name*='"+key+"']")[1].value = value;
	          }*/
	          $("#form_documentos")[0][key]["value"] = value;
	        });

	        id_documento = data.mensaje[0].pkID;	      
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });

	};
	//cierra carga_documento

    //-------------------------------------------------------------------------------
    /*
	Botón que carga el formulario para insertar
	*/
	$("#btn_nuevoDocumento").click(function(){

	  	$("#lbl_form_documentos").html("Nuevo documento");
	  	$("#lbl_btn_actiondocumentos").html("Guardar <span class='glyphicon glyphicon-save'></span>");
	  	$("#btn_actiondocumentos").attr("data-action","crear");
	  	//$("#btn_actiondocumento").attr('disabled','disabled');
	     //validaBtnGuardar();

	  	$("#form_documentos")[0].reset();	      	   
	});

	/*
	Botón que carga el formulario para editar
	*/  
	$("[name*='edita_documento']").click(function(event) {

		$("#lbl_form_documentos").html("Editar documento");
		$("#lbl_btn_actiondocumentos").html("Guardar Cambios <span class='glyphicon glyphicon-pencil'></span>");
		$("#btn_actiondocumentos").attr("data-action","editar");

		$("#form_documentos")[0].reset();

		id_documento = $(this).attr('data-id-documento');

		$("#btn_actiondocumentos").removeAttr('disabled');
		

		carga_documento(id_documento);
		//carga_propiedades(id_documento);
	});

	/*
	Botón que elimina registro
	*/  
	$("[name*='elimina_documento']").click(function(event) {		
		id_documento = $(this).attr('data-id-documento');		
		elimina_documento(id_documento);
	});

	/*
	Botón de accion de formulario
	*/
	$("#btn_actiondocumentos").click(function(){
		/**/
		action = $(this).attr("data-action");
		valida_action(action);
		console.log("accion a ejecutar: "+action);
		//subida_archivo();		
	});


	//valida el documento -------------------
	$("#archivo").change(function(event) {
		/* Act on the event */
		validaArchivo();
	});
	//---------------------------------------

	//-------------------------------------------------------------------------------

	//mostrar todos los li con attr role=presentation
	/*
	$('#myTabs a').click(function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	})*/
	
	var id_li_activo = sessionStorage.getItem("id_tab_proceso");	

	//console.log($("[role=presentation]"));

	console.log(id_li_activo);

	if( (id_li_activo == "null") || (id_li_activo == null) ){

		$("#li_general").addClass('active');

		$("#general").addClass('active');

	}else{

		$("#"+id_li_activo).addClass('active');

		$('ul a[href="#'+id_li_activo.slice(3,20)+'"]').tab('show');

		$("#"+id_li_activo.slice(3,20)).addClass('active');

		//console.log( $('ul a[href="#'+id_li_activo.slice(3,20)+'"]') );
	}	

	
	$("[role=presentation]").click(function(event) {
		/* Act on the event */
		id_li_activo = $(this)[0].id;

		console.log($(this)[0].id);

		// Store
		sessionStorage.setItem("id_tab_proceso", $(this)[0].id);
	});

    //-------------------------------------------------------------------------------
});