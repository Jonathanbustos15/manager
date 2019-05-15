$(function(){
	//console.log('hola proyecto documentos');
	uppercaseForm("form_docslegales");
	//---------------------------------------------------------
	//variable para el objeto del formulario
	var objt_f_doclegal = {};
	//variable de accion del boton del formulario
	var action = "";
	  //variable para el id del registro
	var id_doclegal = "";

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
           var formData = new FormData($("#form_docslegales")[0]);
           //la ruta del php que ejecuta ajax
           var ruta = "../subida_archivo/url.php";

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
                    $("#not_docs_legales").html("Subiendo archivo, por favor espere...");
                },
                //una vez finalizado correctamente
                success: function(data){
                  console.log(data);

                  	$("#not_docs_legales").html('Subido el archivo...');

                  	switch(nom_funcion){
	                  	case "crear":
	                  		crea_docslegal();
	                  	break;
	                  	case "editar":
	                  		edita_docslegal();
	                  	break;
	                  }

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
		var file = $("#form_docslegales [name='archivo']")[0].files[0];
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
      		//Reemplaza los caracteres especiales por "_"
      		fileName = fileName.replace(/ |%|-/g, "_");
      		//Toma el id del indicador financiero
      		id = $("#form_docslegales [id='pkID']").val();
      		//Concatena el nomnbre de archivo con el ID
      		fileName = id+'_'+fileName;   
      		//Asigna al campo ruta el nombre completo a subir
      		$(("#form_docslegales [id='ruta']")).val(fileName);
			console.log("Archivo para subir: "+fileName+", peso total: "+fileSize+" de tipo:"+fileType);
			$("#not_docs_legales").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
        												'Archivo para subir: '+fileName+', peso total: '+fileSize+' de tipo:'+fileType);
		}else{
			alert("El archivo supera el tamaño límite o no es de un tipo permitido.");
			$("#form_docslegales [name='archivo']").val("");
			console.log("Archivo para subir: "+fileName+", peso total: "+fileSize+" de tipo:"+fileType);
			$("#not_docs_legales").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
        												'El archivo supera el tamaño límite o no es de un tipo permitido. Archivo para subir: '+fileName+', peso total: '+fileSize+' de tipo:'+fileType);
		};
		
	
}

	function crea_docslegal(){

      //--------------------------------------
      //crea el objeto formulario serializado
      objt_f_doclegal = $("#form_docslegales").valida();
      
      //console.log(objt_f_adminPublicidad.srlz);
      //--------------------------------------
      /**/
      if( objt_f_doclegal.estado == true ){      

        $.ajax({
          url: "../controller/ajaxController12.php",
          data: objt_f_doclegal.srlz+"&tipo=inserta&nom_tabla=documentos_legales",
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

  	function elimina_docslegal(id_doclegal){

	    console.log('Eliminar el documento legal: '+id_doclegal);

	    var confirma = confirm("En realidad quiere eliminar este documento?");

	    console.log(confirma);
	    /**/
	    if(confirma == true){
	      //si confirma es true ejecuta ajax
	      $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: "pkID="+id_doclegal+"&tipo=eliminar&nom_tabla=documentos_legales",
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

	function edita_docslegal(){

	    //--------------------------------------
	    //crea el objeto formulario serializado
	    objt_f_doclegal = $("#form_docslegales").valida();		   
	    //--------------------------------------
	    /**/
	    if( objt_f_doclegal.estado == true) {

	        console.log(objt_f_doclegal.srlz);

	        $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: objt_f_doclegal.srlz+"&tipo=actualizar&nom_tabla=documentos_legales",
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
	        alert("Faltan "+Object.keys(objt_f_doclegal.objt).length+" campos por llenar.");
	    }
	    //------------------------------------------------------

    };
    //cierra funcion edita_documento

	function carga_docslegal(id_doclegal){

	    console.log("Carga el documento "+id_doclegal);

	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "pkID="+id_doclegal+"&tipo=consultar&nom_tabla=documentos_legales",
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
	          $("#form_docslegales")[0][key]["value"] = value;
	        });

	        id_doclegal = data.mensaje[0].pkID;	      
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
	$("#btn_nuevoDoclegal").click(function(){

	  	$("#lbl_form_docslegales").html("Nuevo Documento Legal");
	  	$("#lbl_btn_actiondocslegales").html("Guardar <span class='glyphicon glyphicon-save'></span>");
	  	$("#btn_actiondocslegales").attr("data-action","crear");
	  	$("#btn_actiondocslegales").removeAttr('disabled');
	     //validaBtnGuardar();

	  	$("#form_docslegales")[0].reset();	      	   
	});

	/*
	Botón que carga el formulario para editar
	*/  
	$("[name*='edita_doclegal']").click(function(event) {

		$("#lbl_form_docslegales").html("Editar Documento Legal");
		$("#lbl_btn_actiondocslegales").html("Guardar Cambios <span class='glyphicon glyphicon-pencil'></span>");
		$("#btn_actiondocslegales").attr("data-action","editar");

		$("#form_docslegales")[0].reset();

		id_doclegal = $(this).attr('data-id-docslegal');

		$("#btn_actiondocslegales").removeAttr('disabled');
		

		carga_docslegal(id_doclegal);
		//carga_propiedades(id_documento);
	});

	/*
	Botón que elimina registro
	*/  
	$("[name*='elimina_doclegal']").click(function(event) {		
		id_doclegal = $(this).attr('data-id-docslegal');		
		elimina_docslegal(id_doclegal);
	});

	/*
	Botón de accion de formulario
	*/
	$("#btn_actiondocslegales").click(function(){
		/**/
		action = $(this).attr("data-action");
		valida_action(action);
		console.log("accion a ejecutar: "+action);
		//subida_archivo();		
	});


	//valida el documento -------------------
	$("#form_docslegales [name='archivo']").change(function(event) {
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
	
	var id_li_activo = sessionStorage.getItem("id_tab_empresa");	

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
		sessionStorage.setItem("id_tab_empresa", $(this)[0].id);
	});


	//Arreglo que contiene ands
	var objt_cond = {
		'anio_expedicion':''		
	};

	var anio = '';

	function crea_consulta(){
		//----------------------------------------------------------
		console.log(objt_cond)

		var arr_cond = [];

		$.each(objt_cond, function(index, val) {
			 console.log('index:'+index+' val:'+val);
			 if (val != '') {
			 	arr_cond.push('documentos_legales.'+index+'='+val);
			 };
		});

		console.log(arr_cond)
		//----------------------------------------------------------
		var cons_final = '';

		if (arr_cond.length > 1) {
			cons_final = arr_cond.join(' AND ');
		}else if (arr_cond.length == 0) {
			cons_final = '*';
		} else{
			cons_final = arr_cond.join();
		};

		console.log(cons_final)

		location.href="detail_empresa.php?filter="+cons_final;
		//----------------------------------------------------------
	}


	$("#anio_filtro").change(function(event) {		
		anio = $(this).val();
		console.log(anio);
		objt_cond.anio_expedicion = anio;

	});

	$("#btn_filtrar").click(function(event) {		
		crea_consulta();
	});


    //-------------------------------------------------------------------------------
});