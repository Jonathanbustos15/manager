$(function(){

	//console.log('Hola desde procesos')
	
	//-----------------------------------------
	//form_entidad
	uppercaseForm("form_proceso");
	uppercaseForm("form_entidad");
	//-----------------------------------------


	//---------------------------------------------------------------
	//variable para el objeto del formulario
	var objt_f_proceso = {};
	//variable de accion del boton del formulario
	var action = "";
	  //variable para el id del registro
	var id_proceso = "";

	var options_format = {
		symbol : "$",
		decimal : ",",
		thousand: ".",
		precision : 0,
		format: "%s%v"
	};
	//---------------------------------------------------------------
	//funciones principales

	function valida_action(action){

  		if(action==="crear"){
    		crea_proceso();
    		//subida_foto();
  		}else if(action==="editar"){
    		edita_proceso();
  		};
	};

	//-------------------------------------------------------------------------------------------
   
	function subida_archivo(){

           //---------------------------------------------------------------------------------------
           //CREA UNA VARIABLE  DE TIPO FormData que toma el formulario
           var formData = new FormData($("#form_proceso")[0]);
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
                },
                //una vez finalizado correctamente
                success: function(data){
                  console.log(data);
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
		//obtenemos un array con los datos del archivo
		var file = $("[name='archivo']")[0].files[0];
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
		$("#url_propuesta").val(fileName);
		console.log("Archivo para subir: "+fileName+", peso total: "+fileSize+" de tipo:"+fileType);

		var sizeMax = (1024*1024)*5;

		if ( fileSize > sizeMax ) {
			alert("El archivo que trata de cargar supera los "+sizeMax+" bits, por favor cargue un archivo más pequeño.");
			$("#url_propuesta").val("");
			$("#archivo").val("");
		} else{};
	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//objeto que definira que se va ingresar dentro de la tabla pasos

	var date;
	date = new Date();
	date = date.getFullYear() + '-' +
	    ('00' + (date.getMonth()+1)).slice(-2) + '-' +
	    ('00' + date.getDate()).slice(-2);

	console.log(date);
	
	//------------------------------------------------
	//leer cookies con js document.cookie
	//poner en el helper global
	function leerCookie(nombre) {
         var lista = document.cookie.split(";");
         for (i in lista) {
             var busca = lista[i].search(nombre);
             if (busca > -1) {micookie=lista[i]}
             }
         var igual = micookie.indexOf("=");
         var valor = micookie.substring(igual+1);
         return valor;
    };

    console.log(leerCookie("log_lunelAdmin_id"));

	var paso={
		"fecha":date,
		"actual":1,
		"pkID_proceso":"-",
		"idPaso1":"0",
		"idPaso2":$("#fkID_paso_actual").val(),
		"pkID_usuario":leerCookie("log_lunelAdmin_id"),
		"pkID_usuario_asignado":leerCookie("log_lunelAdmin_id")
	};

	var email={

		"pkID_usuario":'',
		"tipo_asunto":'',
		"tipo_cuerpo":'',
		"pkID_proceso":'',
		"enviar":false
	};

	//crear otro objeto email para el correo al reasignado

	var email_reasigna={

		"pkID_usuario":'',
		"tipo_asunto":'',
		"tipo_cuerpo":'',
		"pkID_proceso":'',
		"enviar":false
	};

	//funcion para crear paso segun el last_id al crear el proceso
	//depende del cambio del paso la insersion de este registro
	$("#fkID_paso_actual").change(function(event) {
		/* Act on the event */
		/*los valores del paso actual hacen variar el objeto paso
		si el paso es de valor 1 creado
		->queda como esta definido
		si es de valor 2 aprobado
		->consultar los pasos que existan para el proceso con el
		ID que corresponda, encontrar el mas reciente y actualizar
		el campo actual a 0, el resto de datos es para reemplazar 
		en el objeto paso.
		*/
		//como quitar el actual del registro anterior???
		id_proceso = $("#pkID").val();
		
		//console.log($(this).val());

		/**/
		if ($(this).val() == "4") {

			//validar si este paso ha sido aprobado previamente
			valida_last_paso(id_proceso);

			//console.log('asignar a quien?')
			//cons_users(id_proceso);			
			//MOSTRAR EL SELECT CON LOS USUARIOS
			//AL SELECCIONAR UN USUARIO CAMBIAR EL VALOR DEL paso
			//pkID_usuario_asignado al que se seleccionó aca
			//enviar de la misma forma

			//enviar correo a persona asignada informado que ha
			//sido asignado como responsable de este proceso.		
		}else if($(this).val() == "0"){

		}else{
			cons_last_paso(id_proceso);
			//pregunta si el paso es aprobado 2
			//ejecuta el envio de correo a usuario asignado que aparezaca
			//en la tabla de paso y que sea el paso actual informando
			//informando que el proceso ha sido aprobado

			if ($(this).val() == "2") {
				email.enviar = true;
				email.tipo_asunto = 1;
				email.tipo_cuerpo = 'aprobado';
				email.pkID_proceso = id_proceso;
			}else{
				email.enviar = false;
			};
		};

		//----------------------------------------------------------------
		//valida si existe div_asigna_usuario para desaparecerlo

		if ( $("#div_asigna_usuario").length > 0 ) {

			$("#div_asigna_usuario").hide('slow');
		}
		
	}); 
	
	//enviar por ajax a la funcion de insertar, dependiendo del valor del
	//campo fkID_paso_actual cambia los valores del objeto
	
	console.log(paso);

	
	function valida_last_paso(id_proceso){

		var consulta_paso = "select * from pasos where pkID_proceso = "+id_proceso+" ORDER BY pkID DESC LIMIT 1";

		$.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_paso+"&tipo=consulta_gen&nom_tabla=pasos",
	    })
	    .done(function(data) {
	    	/*muestra data actual*/
	        console.log(data);

	        var paso_reciente = data.mensaje[0].idPaso2;

	        //cons_users(id_proceso);
	        if (paso_reciente != 1) {
	        	console.log('asignar a quien?');
	        	cons_users(id_proceso);	        	
	        } else{
	        	alert("No es posible asignar un usuario cuando el estado del proceso es 'creado'.");
	        	$("#fkID_paso_actual").val('1');
	        };				       
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/

	}

	function crea_paso(paso_param){

	      //--------------------------------------
	        $.ajax({
	          url: "../controller/ajaxController12.php",
	          data: paso_param+"&tipo=inserta&nom_tabla=pasos",
	        })
	        .done(function(data) {	          
	          //---------------------
	          console.log(data);
	          console.log('Data de la creacion del paso.');	         	         

	          //alert(data[0].mensaje);
	          //location.reload();
	          
	        })
	        .fail(function(data) {
	          console.log(data);	                   
	        })
	        .always(function() {
	          console.log("complete crea_paso");
	        });	     
	};
	//cierra crea_paso

	function cons_last_paso(id_proceso){

		/*---------------------------------------------------*/
		var consulta_paso = "select * from pasos where pkID_proceso = "+id_proceso+" ORDER BY pkID DESC LIMIT 1";

		$.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_paso+"&tipo=consulta_gen&nom_tabla=pasos",
	    })
	    .done(function(data) {
	    	/*muestra data actual*/
	        console.log(data);

	        /*actualiza el registro actual----------------------------*/
	        update_last_paso(data.mensaje[0].pkID);

	        update_last_paso_proceso(id_proceso,$("#fkID_paso_actual").val());

	        /*asigna los valores al paso nuevo*/
	        paso.idPaso1 = data.mensaje[0].idPaso2;
	        paso.idPaso2 = $("#fkID_paso_actual").val();
	        paso.pkID_proceso = data.mensaje[0].pkID_proceso;

	        console.log("Usuario asignado: "+data.mensaje[0].pkID_usuario_asignado);
	        //el usuario asignado segun la consulta a el paso actual
	        //paso.pkID_usuario_asignado = data.mensaje[0].pkID_usuario_asignado;
	        
	        if ( $("#fkID_paso_actual").val() != 4 ) {
	        	//si es diferente de asignado el usuario asignado es el de
	        	//la consulta del ultimo paso
	        	paso.pkID_usuario_asignado = data.mensaje[0].pkID_usuario_asignado;

	        	//-----------------------------------------------------------------
	        	email_reasigna.enviar = false;
	        }else {
	        	//crear la variable de asignacion de correo
	        	//con los valores de last paso
	        	email_reasigna.pkID_usuario = data.mensaje[0].pkID_usuario_asignado;
	        	email_reasigna.enviar = true;
				email_reasigna.tipo_asunto = 4;
				email_reasigna.tipo_cuerpo = 'reasignado';
				email_reasigna.pkID_proceso = id_proceso;

				console.log(email_reasigna);
	        };

	        var paso_srlz = $.param( paso );

			console.log( paso_srlz );

	        crea_paso(paso_srlz);

	        //enviar correo a persona que aparece en este paso

	        if (  (email.enviar == true) && (email.tipo_asunto == 1)  ) {	        	
	        	enviaCorreoResponsable(data.mensaje[0].pkID_usuario_asignado,email.tipo_asunto,email.tipo_cuerpo,email.pkID_proceso);	        		        
	        };

	        if ( (email_reasigna.enviar == true) && (email_reasigna.tipo_asunto == 4) ) {
        		enviaCorreoResponsable(email_reasigna.pkID_usuario,email_reasigna.tipo_asunto,email_reasigna.tipo_cuerpo,email_reasigna.pkID_proceso);
        	};	        

	        console.log('paso creado y actualizado.');
	        //----------------------------------------------------------

	        //alert("El paso ha sido actualizado.");
	        $("#not_proceso_email").append('<br> El paso ha sido actualizado.');
	        //location.reload();
	        if (email.enviar != true) {
	        	//location.reload();
	        };

	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/
	}

	function enviaCorreoResponsable(pkID_usuario,asunto,tipo_cuerpo,pkID_proceso){		

		$.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "pkID_usuario="+pkID_usuario+"&tipo_asunto="+asunto+"&tipo_cuerpo="+tipo_cuerpo+"&pkID_proceso="+pkID_proceso+"&tipo=email",
	        beforeSend: function() {
	        	//$("#pkID_usuario_asignado").attr('disabled', 'true');
		    	//$("#not_apruebaAsigna").append("<br> Enviando correo "+tipo_cuerpo+", por favor espere...");
		    	$("#btn_actionproceso").attr('disabled', 'true');
		    	$("#not_proceso_email").html('<strong>Atención! por favor espere un momento</strong>, creando proceso y enviando correos correspondientes.');
		    }
	    })
	    .done(function(data) {	    	
	        console.log(data);
	        //alert(data.mensaje.mensaje);
	        $("#not_proceso_email").append('<br>'+data.mensaje.mensaje);
	        //location.reload();
	        setTimeout(function(){
	        	location.reload();
	        }, 2000)
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/
	}

	function update_last_paso(id_paso){

		/*---------------------------------------------------*/
		var update_paso = "UPDATE `pasos` SET `actual` = '0' WHERE `pasos`.`pkID` ="+id_paso;

		$.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+update_paso+"&tipo=consulta_gen&nom_tabla=pasos",
	    })
	    .done(function(data) {	    	
	        console.log(data);
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/
	}

	function update_last_paso_proceso(id_proceso,id_paso){

		/*---------------------------------------------------*/
		var update_paso_proceso = "UPDATE `procesos` SET `fkID_paso_actual` = '"+id_paso+"' WHERE `procesos`.`pkID` = "+id_proceso;

		$.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+update_paso_proceso+"&tipo=consulta_gen&nom_tabla=procesos",
	    })
	    .done(function(data) {	    	
	        console.log(data);
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/
	}

	function cons_users(id_proceso){

		/*---------------------------------------------------*/
		var query_users = "SELECT * FROM `usuarios` where (email != '') AND (email IS NOT NULL) ";

		$.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+query_users+"&tipo=consulta_gen&nom_tabla=usuarios",
	    })
	    .done(function(data) {	    	
	        //console.log(data);

	        if ( $("#div_asigna_usuario").length > 0 ) {
			  // Siempre será validado, incluso si #undiv no existe
			  console.log('el asigna usuario ya existe!');
			  $("#div_asigna_usuario").show('slow');
			  
			}else{

				$( "#div_paso_actual" ).after(
					'<div id="div_asigna_usuario" class="form-group">'+
			            '<label for="pkID_usuario_asignado" class="control-label">Asignar Usuario</label>'+                       
			            '<select name="pkID_usuario_asignado" id="pkID_usuario_asignado" class="form-control add-selectElement">'+
			                '<option></option>'+	                                
			            '</select>'+
			        '</div>'	        
				 );

		        crea_select_users(data,id_proceso);
			}	        
	        
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/
	}

	function crea_select_users(data,id_proceso){

		/*
		$.each(data.mensaje[0], function( key, value ) {
          console.log(key+"--"+value);
          //$("#"+key).val(value);
        });*/
		
        for (var i = 0; i < data.mensaje.length; i++) {
        	//console.log('metiendo usuarios...')
        	
        	//filtrar que no se pueda seleccionar el 
        	//mismo usuario logueado

        	if( leerCookie("log_lunelAdmin_id") == data.mensaje[i].pkID ){

        	}else{
        		$("#pkID_usuario_asignado").append('<option value="'+data.mensaje[i].pkID+'">'+data.mensaje[i].alias+' -- '+data.mensaje[i].nombre+' '+data.mensaje[i].apellido+'</option>');
        	}        	
        };

        $("#pkID_usuario_asignado").change(function(event) {
        	/* Act on the event */
        	paso.pkID_usuario_asignado = $(this).val();

        	console.log(paso);

        	cons_last_paso(id_proceso);

        	//envia correo de que ha sido asignado
        	email.enviar = true;
			email.tipo_asunto = 3;
			email.tipo_cuerpo = 'asignado';
			email.pkID_proceso = id_proceso;
			email.pkID_usuario = $(this).val();

			if (email.enviar == true) {
	        	enviaCorreoResponsable(email.pkID_usuario,email.tipo_asunto,email.tipo_cuerpo,email.pkID_proceso);
	        };
        });

         

        //definir el on change del select de usuario	

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


	function crea_proceso(){

	      //--------------------------------------	      
	      //crea el objeto formulario serializado
	      objt_f_proceso = $("#form_proceso").valida();
	      console.log(objt_f_proceso);	      	     
	      //--------------------------------------
	      /**/
	      //subida_archivo();

	      if( objt_f_proceso.estado == true ){	      

	        $.ajax({
	          url: "../controller/ajaxController12.php",
	          data: objt_f_proceso.srlz+"&tipo=inserta&nom_tabla=procesos",
	        })
	        .done(function(data) {	          
	          //---------------------
	          console.log(data);

	          //console.log(data[0].last_id);

	          //crea el paso para el proceso.-----------------------------
	          
	          paso.pkID_proceso = data[0].last_id;

	          var paso_srlz = $.param( paso );

			  console.log( paso_srlz );

	          crea_paso(paso_srlz);

	          //enviar correo de solicitud de aprobacion

	          //setea el objeto email para solicitud de aprobacion
	          email.pkID_usuario=leerCookie("log_lunelAdmin_id");
	          email.pkID_proceso=data[0].last_id;
	          email.tipo_asunto=2;
	          email.tipo_cuerpo='solicitud_aprobacion';
	          email.enviar=true;	         	         

	          if (email.enviar == true) {
		        	enviaCorreoResponsable(email.pkID_usuario,email.tipo_asunto,email.tipo_cuerpo,email.pkID_proceso);
		        };
	          //-----------------------------------------------------------

	          alert(data[0].mensaje);
	          //location.reload();
	          if ( (email.enviar == false) || (email_reasigna.enviar == false) ) {
	          	setTimeout(function(){
	          		location.reload();
	          	}, 2000)
	          };
	          
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

	function carga_proceso(id_proceso){

	    console.log("Carga el proceso "+id_proceso);

	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "pkID="+id_proceso+"&tipo=consultar&nom_tabla=procesos",
	    })
	    .done(function(data) {
	    	/**/
	        $.each(data.mensaje[0], function( key, value ) {
	          console.log(key+"--"+value);         
	          
	          if (key == "cuantia") {
	          	$("#"+key).val(value);
	          	$("#"+key+"_mask").val(accounting.formatNumber(value,options_format));
	          } else{
	          	$("#"+key).val(value);
	          };

	        });

	        id_proceso = data.mensaje[0].pkID;	     
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
	};
	//cierra carga_proceso

	function edita_proceso(){

	    //--------------------------------------
	    //crea el objeto formulario serializado
	    objt_f_proceso = $("#form_proceso").valida();
	 		    
	    //--------------------------------------
	    /**/
	    //subida_archivo();

	    if( objt_f_proceso.estado == true) {

	        console.log(objt_f_proceso.srlz);

	        $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: objt_f_proceso.srlz+"&tipo=actualizar&nom_tabla=procesos",
	        })
	        .done(function(data) {	           
	          //---------------------
	          console.log(data);
	          

	          id_proceso = $("#pkID").val();	         	        

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
	        alert("Faltan "+Object.keys(objt_f_proceso.objt).length+" campos por llenar.");
	    }
	    //------------------------------------------------------

    };
    //cierra funcion edita_proceso

    function elimina_proceso(id_proceso){

	    console.log('Eliminar el proceso: '+id_proceso);

	    var confirma = confirm("En realidad quiere eliminar este proceso?");

	    console.log(confirma);
	    /**/
	    if(confirma == true){
	      //si confirma es true ejecuta ajax
	      $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: "pkID="+id_proceso+"&tipo=eliminar&nom_tabla=procesos",
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
    //cierra funcion eliminar proceso

	//-------------------------------------------------------------------------------
	//ejecución
	//-------------------------------------------------------------------------------	
		
	/*
	Botón que carga el formulario para insertar
	*/
	$("#btn_nuevoProceso").click(function(){

	  	$("#lbl_form_proceso").html("Nuevo Proceso");
	  	$("#lbl_btn_actionproceso").html("Guardar <span class='glyphicon glyphicon-save'></span>");
	  	$("#btn_actionproceso").attr("data-action","crear");
	  	$("#div_paso_actual").attr('hidden','true');


	  	$("#btn_actionproceso").removeAttr('disabled');	    

	  	$("#form_proceso")[0].reset();
	  	//---------------------------------------------
	  	//date de la line 101
	  	console.log("La fecha de hoy es: "+date);
	  	$("#fecha_creacion").val(date);
	  	//---------------------------------
	  	//$("#observaciones").val(date+" : ");
	  	$("#observaciones").removeAttr('readonly');
	  	$("#btn_nuevoobservacion").attr('disabled', 'true');
	});

	/*
	Botón que carga el formulario para editar
	*/  
	$("[name*='edita_proceso']").click(function(event) {

		$("#lbl_form_proceso").html("Edita Proceso");
	  	$("#lbl_btn_actionproceso").html("Actualizar <span class='glyphicon glyphicon-floppy-save'></span>");
	  	$("#btn_actionproceso").attr("data-action","editar");
	  	$("#div_paso_actual").removeAttr('hidden');

	  	$("#btn_actionproceso").removeAttr('disabled');	    

	  	$("#form_proceso")[0].reset();

		id_proceso = $(this).attr('data-id-proceso');
				
		carga_proceso(id_proceso);

		//---------------------------------
	  	$("#observaciones").attr('readonly', 'true');
	  	$("#btn_nuevoobservacion").removeAttr('disabled');		
	});

	/*
	Botón que elimina registro
	*/  
	$("[name*='elimina_proceso']").click(function(event) {		
		id_proceso = $(this).attr('data-id-proceso');		
		elimina_proceso(id_proceso);
	});

	/*
	Botón de accion de formulario
	*/
	$("#btn_actionproceso").click(function(){
		
		action = $(this).attr("data-action");
		$("#observaciones").val( date+" : "+$("#observaciones").val()+" -- " );
		valida_action(action);
		console.log("accion a ejecutar: "+action); 
		//subida_archivo();
	});

	//---------------------------------------------------------------	
	//calendario para la fecha de cierre
	$( "#fecha_cierre" ).datepicker({
		dateFormat: "yy-mm-dd",
		minDate: 1			
	});	
	//---------------------------------------------------------------

	//mascara de dinero para cuantia
	//$('#cuantia').mask('000000000000000', {reverse: true});
	
	$('#cuantia_mask').mask('000.000.000.000.000', {reverse: true});

	function remplazar (texto, buscar, nuevo){
	    var temp = '';
	    var long = texto.length;
	    for (j=0; j<long; j++) {
	        if (texto[j] == buscar) 
	        {
	            temp += nuevo;
	        } else
	            temp += texto[j];
	    }
	    return temp;
	}

	$('#cuantia_mask').change(function(event) {
		/* Act on the event */
		//console.log($(this).val());
		var val_cuantia = $(this).val();
		//var val_replace = val_cuantia.replace(".", "");
		$('#cuantia').val(remplazar (val_cuantia, ".", ""))
		//console.log(remplazar (val_cuantia, ".", ""))
	});
	//---------------------------------------------------------------
	/* Act on the event 
	$("#archivo").change(function(event) {
		
		validaArchivo();
	});*/
	//---------------------------------------------------------------
	$('#tbl_proceso').on( 'click', '.detail', function () {
	  window.location.href = $(this).attr('href');
	} );
	//---------------------------------------------------------------
	//Codigo para ver la url
	$("#url_propuesta").change(function(event) {
		/* Act on the event */
		var nom_link = $(this).val();
		nom_link = nom_link.replace(/https?:\/\//, '');
		console.log(nom_link)		

		if (validaUrl($(this).val()) ){
			$("#url_codigo").html('<a href="'+$(this).val()+'" target="_blank"> ir a '+nom_link+' </a>')
		} else{
			$("#url_codigo").html('Esto no es un link válido.')
			$("#url_propuesta").val('')
		};
	});
	//---------------------------------------------------------------
	//Expresiones regulares
	//http://chuwiki.chuidiang.org/index.php?title=Expresiones_regulares_en_javascript
	//http://notasjs.blogspot.com.co/2013/06/tutorial-de-expresiones-regulares-en.html
	//pagina de chuleta de expresiones regulares
	//http://www.regexr.com/
	/*
	var reg = /http:\/\/\w{2,}[.]\w{2,}/;
	var busca = "http://getbootstrap.com/css/#code".match(reg);
 	console.log(busca);*/

 	function validaUrl(valor){ 

 		var reg = /https?:\/\/\w{2,}[.?]\w{2,}/g

		var busca = valor.match(reg);		
	 	console.log(busca);

	 	if (busca) {
	 		return true;
	 	} else{
	 		return false;
	 	};
 	}
 	/*
 	var pruebaurl = validaUrl("http://getbootstrap.com/css/#code");
 	console.log(pruebaurl);*/
	//---------------------------------------------------------------
	//unsetear el elemento de las tablas
	sessionStorage.setItem("id_tab_proceso",null);
	//---------------------------------------------------------------
	//nombre en mayusculas de la entidad
	$("#nombre_entidad").keyup(function(event) {
		/* Act on the event */
		//console.log('escribiendo nombre entidad!')
		var nomEntidad = $(this).val(); 
		$(this).val(nomEntidad.toUpperCase());
	});
	//---------------------------------------------------------------
});