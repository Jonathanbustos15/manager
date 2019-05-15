$(function(){
	//console.log('hola proyecto documentos');

	//---------------------------------------------------------
	//variable para el objeto del formulario
	var objt_f_documento = {};
	//variable de accion del boton del formulario
	var action = "";
	  //variable para el id del registro
	var id_documento = "";

	var objt_subida = {
		upload:false		
	};

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	var valoresArchivos = [];

	var arregloDeArchivos = [];

	var contDetailName = 0;

	var archCoincide = "";
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//--------------------------------------------------------- 
	function valida_action(action){

  		if(action==="crear"){
    		//subida_archivo('crear');
    		crea_documento();
    		//subida_foto();
  		}else if(action==="editar"){
    		sube_doc_editado();
  		};
	};
	//---------------------------------------------------------	
	/*
    var table = $('#tbl_documentos').DataTable(

        {
            //"order": [[ 1, "asc" ]], //ordenando por nombre asc
            "pagingType": "full_numbers",
            "lengthMenu": [[-1, 5, 10, 25, 50], ["Todo", 5, 10, 25, 50]],

            "language": {
                "lengthMenu":     "Mostrando _MENU_ registros",
                "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                "search":         "Buscar:",
                "loadingRecords": "Cargando...",
                "processing":     "Procesando...",
                "zeroRecords": "No hay registros que coincidan.",
                "infoEmpty": "No se encuentran registros.",
                "infoFiltered":   "(Filtrando _MAX_ registros en total)",
                //------------------------------------------------------------------
                //paginador
                "paginate": {
                    "first":      "<--",
                    "last":       "-->",
                    "next":       ">",
                    "previous":   "<"
                },
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
                //------------------------------------------------------------------
            }
        }

    );

    setTimeout(function(){
        table.page.len( 10 ).draw();
        table.column( 0 ).visible( false );
        table.order( [ 0, 'desc' ] ).draw();
    }, 1000);*/


    function subida_archivo(tipo){

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
                    $("#not_documentos_proyecto").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
        												'Subiendo archivo, por favor espere...');
                },
                //una vez finalizado correctamente
                success: function(data){
                  console.log(data);
                  objt_subida.upload = true;

                  if (tipo=='crear') {
                  	crea_documento();
                  } else if(tipo=='editar'){
                  	edita_documento();
                  };
                  //alert(data.estado);
                  //$("#not_img").removeAttr('hidden');
                  //$("#not_img").html(' <br /> <br /> <div class="'+data.clase+'" role="alert">'+data.estado+'</div>');

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
			$("#not_documentos_proyecto").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
        												'Archivo para subir: '+fileName+', peso total: '+fileSize+' de tipo:'+fileType);
		}else{
			alert("El archivo supera el tamaño límite o no es de un tipo permitido.");
			$("[name='archivo']").val("");
			console.log("Archivo para subir: "+fileName+", peso total: "+fileSize+" de tipo:"+fileType);
			$("#not_documentos_proyecto").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
        												'El archivo supera el tamaño límite o no es de un tipo permitido. Archivo para subir: '+fileName+', peso total: '+fileSize+' de tipo:'+fileType);
		};
		
	}

	/*
	function crea_documento(){

      //--------------------------------------
      //crea el objeto formulario serializado
      objt_f_documento = $("#form_documentos").valida();
      
      //console.log(objt_f_adminPublicidad.srlz);
      //--------------------------------------
      
      if( objt_f_documento.estado == true ){
      
        $.ajax({
          url: "../controller/ajaxController12.php",
          data: objt_f_documento.srlz+"&tipo=inserta&nom_tabla=documentos",                 
        })
        .done(function(data) {	          
          //---------------------
          console.log(data);
          
          //var pkID_documento = data[0].last_id;
         
         // insertaArchivo("pkID_hojaVida="+pkID_hojaVida+"&url_archivo="+val[0].name+"&des_archivo="+getValoresDesc(val[0].name);
                   
          //$("#btn_actiondocumento").attr('enabled','enabled');

          $("#not_documentos_proyecto").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
        												data[0].mensaje);
          
          //alert(data[0].mensaje);
          //location.reload();
                    
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

    };*/
  	//cierra crea

  	function crea_documento(){

  		console.log(arregloDeArchivos);

  		$("#not_documentos_proyecto").html('Subiendo archivos, por favor espere ...');

  		$('#fileupload').fileupload('send', {files:arregloDeArchivos})
	    .success(function (result, textStatus, jqXHR) {

	    	console.log(result);
	    	console.log(textStatus);
	    	console.log(jqXHR);
	    	/**/
	    	var iterate = $.each(arregloDeArchivos, function(index, val) {
	          	 
		      	 //console.log(val[0].name);

		      	 //notificacion de subida de archivo
		      	 $("#btn_actiondocumentos").attr('disabled', 'true');

		      	 $("#not_documentos_proyecto").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
		        												'Guardando registro archivo: '+val.name);
		      	 
		      	 getValoresDesc(val.name);
				 inserta_documento("ruta="+val.name+"&nom_doc="+archCoincide+"&fkID_tipo="+$("#fkID_tipo").val()+"&fkID_subtipo="+$("#fkID_subtipo").val()+"&fkID_proyecto="+$("#fkID_proyecto").val());	      
		    });
	  	  
			//-----------------------------------------------------------------------------------	    
			$.when(iterate).then(subidaOK, subidaFail );

			function subidaOK(){
				//-----------------------------------------------------------------------------------
		        $("#not_documentos_proyecto").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
		    												' Subida de archivos Realizada con éxito. Por favor espere...');	        
		        
		        setTimeout(function() {
		        	location.reload();
		        }, 2000);
		        //-----------------------------------------------------------------------------------
		    }

			function subidaFail(){
				$("#not_documentos_proyecto").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
		    												'Hubo un error en la creación de registro.');	
			}
	    	
	    })
	    .error(function (jqXHR, textStatus, errorThrown) {
	    	console.log(textStatus);
	    	$("#not_documentos_proyecto").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
		    												'Estado -> ' + textStatus + ': por favor revise el archivo e intentelo de nuevo, verifique que el nombre del archivo no contenga caractéres no permitidos como (%,´).');
	    })
	    .complete(function (result, textStatus, jqXHR) {
	    	console.log(textStatus);

	    	//$("#not_documentos_proyecto").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
		        												//'Status Subida: '+textStatus);
	    });
	    //------------------------------------------------------------------------------------  			  	
  	}  	

  	function getValoresDesc(nomArch){

		console.log(nomArch);

		console.log( $("[name*='nombre']") );

		var nombreControl = "";					

		$.each($("[name*='nombre']"), function(index, val) {
			 
			 nombreControl = $(this).attr("data-name-file");

			 console.log(nombreControl);

			 if(nomArch == nombreControl){
			 	archCoincide = val.value;
			 	//console.log(val.value);
			 }
		});

	}

  	function inserta_documento(srlz){

      //--------------------------------------
      //crea el objeto formulario serializado
      objt_f_documento = $("#form_documentos").valida();
      
      //console.log(objt_f_adminPublicidad.srlz);
      //--------------------------------------
      
      if( objt_f_documento.estado == true ){

      	//console.log('Insertando documento: '+srlz);
      	/**/
        $.ajax({
          url: "../controller/ajaxController12.php",
          data: srlz+"&tipo=inserta&nom_tabla=documentos",                 
        })
        .done(function(data) {	          
          //---------------------
          console.log(data);                 

          $("#not_documentos_proyecto").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
        												data[0].mensaje);          
          //alert(data[0].mensaje);
          //location.reload();
                    
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

  	function elimina_documento(id_documento){

	    console.log('Eliminar el documento: '+id_documento);

	    var confirma = confirm("En realidad quiere eliminar este documento?");

	    console.log(confirma);
	    /**/
	    if(confirma == true){
	      //si confirma es true ejecuta ajax
	      $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: "pkID="+id_documento+"&tipo=eliminar&nom_tabla=documentos",
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


    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/*
	function edita_documento(){		

	    //--------------------------------------
	    //crea el objeto formulario serializado
	    objt_f_documento = $("#form_documentos").valida();
	 	    
	    //--------------------------------------
	    
	    if( objt_f_documento.estado == true ) {

	        console.log(objt_f_documento.srlz);

	        $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: objt_f_documento.srlz+"&tipo=actualizar&nom_tabla=documentos",		        
	        })
	        .done(function(data) {	           
	          //----------------------	          
	          	          
	          console.log(data);
	          $("#not_documentos_proyecto").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
        												data.mensaje.mensaje);	          	         	       	      
	          alert(data.mensaje.mensaje)
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

    };*/


    function sube_doc_editado(){

    	console.log(arregloDeArchivos);

    	if (arregloDeArchivos.length > 0) {

    		$('#fileupload').fileupload('send', {files:arregloDeArchivos})
		    .success(function (result, textStatus, jqXHR) {

		    	console.log(result);
		    	console.log(textStatus);
		    	console.log(jqXHR);
		    	/**/
		    	var iterate = $.each(arregloDeArchivos, function(index, val) {
		          	 
			      	 //console.log(val[0].name);
			      	 edita_documento();
			      	 
			    });
		  	  
				//-----------------------------------------------------------------------------------	    
				$.when(iterate).then(subidaOK, subidaFail );

				function subidaOK(){
					//-----------------------------------------------------------------------------------
			        $("#not_documentos_proyecto").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
			    												' Subida de archivos Realizada con éxito. Por favor espere...');	        
			        
			        setTimeout(function() {
			        	alert("Actualizado correctamente.")
			        	location.reload();
			        }, 2000);
			        //-----------------------------------------------------------------------------------
			    }

				function subidaFail(){
					$("#not_documentos_proyecto").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
			    												'Hubo un error en la creación de registro.');	
				}
		    	
		    })
		    .error(function (jqXHR, textStatus, errorThrown) {
		    	console.log(textStatus);
		    	$("#not_documentos_proyecto").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
			    												'Estado -> ' + textStatus + ': por favor revise el archivo e intentelo de nuevo, verifique que el nombre del archivo no contenga caractéres no permitidos como (%,´).');
		    })
		    .complete(function (result, textStatus, jqXHR) {
		    	console.log(textStatus);

		    	//$("#not_documentos_proyecto").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
			        												//'Status Subida: '+textStatus);
		    });
		    //------------------------------------------------------------------------------------
    	} else{

    		var edicion_doc = edita_documento();

    		console.log(edicion_doc);

    		edicion_doc.done(function(){
    			console.log('Terminó de editar!');
    			//console.log(edicion_doc.responseJSON.mensaje.mensaje);
    			alert(edicion_doc.responseJSON.mensaje.mensaje)
	            location.reload();
    		});
    	};
    	
    }

    function edita_documento(){		

	    //--------------------------------------
	    //crea el objeto formulario serializado
	    objt_f_documento = $("#form_documentos").valida();
	 	    
	    //--------------------------------------
	    
	    if( objt_f_documento.estado == true ) {

	        console.log(objt_f_documento.srlz);

	        return $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: objt_f_documento.srlz+"&tipo=actualizar&nom_tabla=documentos",		        
	        })
	        .done(function(data) {	           
	          //----------------------	          
	          	          
	          console.log(data);
	          $("#not_documentos_proyecto").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
        												data.mensaje.mensaje);	          	         	       	      
	          //alert(data.mensaje.mensaje)
	          //location.reload();
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
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    function select_subtipo(pkID,pkID_subtipo){

    	var consulta_sub_categorias = "select * FROM tipo_documento where fkID_padre ="+pkID+" order by nombre_tdoc";
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_sub_categorias+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	/**/
	    	$("#sub_tipo").removeAttr('hidden');

	    	$("#fkID_subtipo").html('')
	        console.log(data)

	        if (data.mensaje != "No hay registros.") {

	        	$("#fkID_subtipo").append('<option></option>')

	        	$.each(data.mensaje, function(index, val) {
		        	 /* iterate through array or object */
		        	 console.log(index+"--"+val)
		        	 console.log(val)

		        	 $("#fkID_subtipo").append('<option value="'+val.pkID+'">'+val.nombre_tdoc+'</option>')	        	 
		        });

	        
	        	$("#fkID_subtipo").click();

	        	//console.log($("#fkID_subtipo"));
	        	//selecciona el valor recien cargado
	        	$.each($("#fkID_subtipo")[0], function(index, val) {
	        		 /* iterate through array or object */

	        		 if ($("#fkID_subtipo")[0][index]["value"]==pkID_subtipo) {
	        		 	//selected
	        		 	//console.log($("#fkID_subtipo")[0][index]["value"]);
	        		 	$("#fkID_subtipo")[0][index]["selected"] = true;
	        		 };
	        	});

	        };       		        

	        //$( "#fkID_categoria" ).load( "formatos.php option");
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
	    //---------------------------------------------------------------

    }

	function carga_documento(id_documento){

	    console.log("Carga el documento "+id_documento);

	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "pkID="+id_documento+"&tipo=consultar&nom_tabla=documentos",
	    })
	    .done(function(data) {
	    	/**/

	    	//----------------------------------------------

	    	//----------------------------------------------
	        $.each(data.mensaje[0], function( key, value ) {
	          
	          console.log(key+"--"+value);
	          
	          $("#"+key).val(value);

	          if(key == "pkID"){
	          	console.log($("[name*='"+key+"']")[1]);

	          	$("[name*='"+key+"']")[1].value = value;
	          }
	          
	        });

	        select_subtipo(data.mensaje[0].fkID_tipo,data.mensaje[0].fkID_subtipo);

	        $("#res_form").html("");

	        $("#res_form").append(

        		'<div class="form-group">'+

        		'<label class="control-label">Nombre para el archivo: '+data.mensaje[0].ruta+'</label>'+

        		'<input type="text" class="form-control" name="nom_doc" value="'+data.mensaje[0].nom_doc+'" required="true" /> <br>'+

        		'</div>'

        		);
	        //----------------------------------------------
	        id_documento = data.mensaje[0].pkID;	      
	        //----------------------------------------------
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
	
	var id_li_activo = sessionStorage.getItem("id_tab_proyecto");	

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
		sessionStorage.setItem("id_tab_proyecto", $(this)[0].id);
	});

    //-------------------------------------------------------------------------------    
   

    $('#fileupload').fileupload({
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|rar|pdf)$/i,
        //maxFileSize: 999999999,
        add: function (e, data) {        	

        	console.log(data.files[0].size);
        	
        	console.log("La acción que se esta ejecutando es: "+$("#btn_actiondocumentos").attr("data-action"));

        	var action_actual = $("#btn_actiondocumentos").attr("data-action");

        	if (action_actual != "crear") {

        		$("#res_form").html("")

        		data.context = $("#res_form").append(

        		'<div class="form-group">'+

        		'<label class="control-label">Nombre para el archivo: '+data.files[0].name+'</label>'+

        		'<input type="hidden" class="form-control" name="ruta" value="'+data.files[0].name+'"/> <br>'+

        		'<input type="text" class="form-control" name="nom_doc" required="true" /> <br>'+

        		'</div>'

        		);

        	}else{

        		data.context = $("#res_form").append(

        		'<div class="form-group">'+

        		'<label class="control-label">Nombre para el archivo: '+data.files[0].name+'</label>'+

        		'<input type="text" class="form-control" name="nombre['+contDetailName+']" data-name-file="'+data.files[0].name+'" required="true" /> <br>'+

        		'</div>'

        		);
        	};
        	    		

    		contDetailName++;
    		
			valoresArchivos = [];

			arregloDeArchivos.push(data.files[0]);

			console.log(arregloDeArchivos);

			var iteracion = $.each(arregloDeArchivos, function(index, val) {
				 /* iterate through array or object */
				 console.log("llave: "+index+" valor: "+val);
				 console.log(val)
			});

			$.when(iteracion).then( myFunc, myFailure );

			function myFunc(){
				console.log('Termino. Muy Bien.')
			}

			function myFailure(){
				console.log('Algo salio mal!')
			}		

			//-----------------------------------------------------------------        	

        	
        },
        done: function (e, data) {
            //data.context.text('Upload finished.');
            console.log('Load finished.');
            //subidaOK();
        },
        fail: function (e, data) {
            //data.context.text('Upload finished.');
            console.log(data);
            //subidaFail();
        }

    });
    //-------------------------------------------------------------------------------
});