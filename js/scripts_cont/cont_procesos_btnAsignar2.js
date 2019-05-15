$(function(){

	var id_proceso = "";
	var paso_reciente = "";
	
	/*
	//console.log('hola btn_asignar...');

	var date;
	date = new Date();
	date = date.getFullYear() + '-' +
	    ('00' + (date.getMonth()+1)).slice(-2) + '-' +
	    ('00' + date.getDate()).slice(-2);

	//console.log(date);
	
	//------------------------------------------------
	//leer cookies con js document.cookie

	function leerCookie(nombre) {
         var lista = document.cookie.split(";");
         for (i in lista) {
             var busca = lista[i].search(nombre);
             if (busca > -1) {micookie=lista[i]}
             }
         var igual = micookie.indexOf("=");
         var valor = micookie.substring(igual+1);
         return valor;
    };*/

    //console.log(leerCookie("log_lunelAdmin_id"));
    /*
	var paso={
		"fecha":date,
		"actual":1,
		"pkID_proceso":"-",
		"idPaso1":"0",
		"idPaso2":"",
		"pkID_usuario":leerCookie("log_lunelAdmin_id"),
		"pkID_usuario_asignado":""
	};

	var email={

		"pkID_usuario":'',
		"tipo_asunto":'',
		"tipo_cuerpo":'',
		"pkID_proceso":'',
		"enviar":false
	};

	var email_reasigna={

		"pkID_usuario":'',
		"tipo_asunto":'',
		"tipo_cuerpo":'',
		"pkID_proceso":'',
		"enviar":false
	};*/


	function cons_userActual(id_proceso){

		var consulta_paso = "select * from pasos where pkID_proceso = "+id_proceso+" ORDER BY pkID DESC LIMIT 1";

		$.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_paso+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	/*muestra data actual*/
	        console.log(data.mensaje)

	        paso_reciente = data.mensaje[0].idPaso2;

	        console.log($("#pkID_usuario_asignado"))
	        $.each($("#pkID_usuario_asignado")[0], function(index, val) {
	        	 /* iterate through array or object */
	        	 console.log('index:'+index+'--val:'+val)
	        	 if (val.value == data.mensaje[0].pkID_usuario_asignado) {
	        	 	// statement
	        	 	console.log(val.text)
	        	 	val.text = val.text+" (Usuario -asignado,responsable.)"
	        	 } else {
	        	 	// statement
	        	 }
	        });
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

	        if ( $("#div_asigna_aprueba").length > 0 ) {
			  // Siempre será validado, incluso si #undiv no existe
			  console.log('el asigna usuario dentro del form_aprobar_asignar ya existe!');
			  $("#form_modal_aprobar_asignar").modal("show");
			  $("#pkID_usuario_asignado").html('<option></option>');
			  crea_select_users(data,id_proceso);
			  $("#div_asigna_aprueba").show('slow');
			  
			}else{				

				$( "#form_aprobar_asignar" ).append(
					'<div id="div_asigna_aprueba" class="form-group">'+
			            '<label for="pkID_usuario_asignado" class="control-label">Asignar Usuario</label>'+                       
			            '<select name="pkID_usuario_asignado" id="pkID_usuario_asignado" class="form-control">'+
			                '<option></option>'+	                                
			            '</select>'+
			        '</div>'	        
				 );

		        crea_select_users(data,id_proceso);
			}	        
	        
	    })
	    .fail(function(){
	        console.log("error");
	    })
	    .always(function(){
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
        		$("#pkID_usuario_asignado").append('<option value="'+data.mensaje[i].pkID+'">'+data.mensaje[i].nombre+' '+data.mensaje[i].apellido+'</option>');
        	}        	
        };

        //
        cons_userActual(id_proceso);

        //abre el modal
        $("#form_modal_aprobar_asignar").modal("show");

        $("#pkID_usuario_asignado").change(function(event) {
        	/* Act on the event */
        	paso.pkID_usuario_asignado = $(this).val();

        	console.log(paso);

        	if (paso_reciente == "1") {
	        	
	        	//setea el objeto email
				email.enviar = true;
				email.tipo_asunto = 1;
				email.tipo_cuerpo = 'aprobado';
				email.pkID_proceso = id_proceso;

				cons_last_paso_aa(id_proceso,2);

	        }else{
	        	//envia correo de que ha sido asignado
	        	email.enviar = true;
				email.tipo_asunto = 3;
				email.tipo_cuerpo = 'asignado';
				email.pkID_proceso = id_proceso;
				email.pkID_usuario = $(this).val();

				cons_last_paso_aa(id_proceso,4);
	        }			

			if (email.enviar == true) {
	        	enviaCorreoResponsable(email.pkID_usuario,email.tipo_asunto,email.tipo_cuerpo,email.pkID_proceso);
	        };
        });
    }

    

	function cons_last_paso_aa(id_proceso,id_paso_actual){

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

	        update_last_paso_proceso(id_proceso,id_paso_actual);

	        /*asigna los valores al paso nuevo*/
	        paso.idPaso1 = data.mensaje[0].idPaso2;
	        paso.idPaso2 = id_paso_actual;
	        paso.pkID_proceso = data.mensaje[0].pkID_proceso;
	        
	        
	        //si el paso no es asignado setea el usuario segun el reg de paso
	        if (id_paso_actual != 4) {
	        	paso.pkID_usuario_asignado = data.mensaje[0].pkID_usuario_asignado;
	        	//-----------------------------------------------------------------
	        	email_reasigna.enviar = false; 
	        }else {
	        	//crear la variable de asignacion de correo
	        	//con los valores de last paso
	        	//solo reasigna si
	        	email_reasigna.pkID_usuario = data.mensaje[0].pkID_usuario_asignado;
	        	email_reasigna.enviar = true;
				email_reasigna.tipo_asunto = 4;
				email_reasigna.tipo_cuerpo = 'reasignado';
				email_reasigna.pkID_proceso = id_proceso;

				console.log(email_reasigna);
	        };

	        console.log("Usuario asignado: "+data.mensaje[0].pkID_usuario_asignado);
	        //el usuario asignado segun la consulta a el paso actual
	        //paso.pkID_usuario_asignado = data.mensaje[0].pkID_usuario_asignado;
	        
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

	        //carga el modal con el select de los usuarios
	        //$("#form_modal_aprobar_asignar").modal("show");

	        console.log('paso creado y actualizado.');
	        //----------------------------------------------------------

	        if (id_paso_actual == 2) {

	        	/*
	        	var conf_asignar = confirm("Desea asignar una persona a este Proceso?");

	        	if (conf_asignar == true) {
	        		
	        		$("#form_modal_aprobar_asignar").modal("show");

					cons_users(id_proceso);
	        	};*/

	        	$("#form_modal_aprobar_asignar").modal("show");

				cons_users(id_proceso);
	        	
	        };

	        //alert("El paso ha sido actualizado.");
	        //console.log("El paso ha sido actualizado.");
	        $("#not_apruebaAsigna").append("<br> El paso ha sido actualizado.");

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

	function enviaCorreoResponsable(pkID_usuario,asunto,tipo_cuerpo,pkID_proceso){		

		$.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "pkID_usuario="+pkID_usuario+"&tipo_asunto="+asunto+"&tipo_cuerpo="+tipo_cuerpo+"&pkID_proceso="+pkID_proceso+"&tipo=email",
	        beforeSend: function() {
	        	//$("#pkID_usuario_asignado").attr('disabled', 'true');

		    	$("#not_apruebaAsigna").append("<br> Enviando correo "+tipo_cuerpo+", por favor espere...");
		    }
	    })
	    .done(function(data) {	    	
	        console.log(data);
	        //alert(data.mensaje.mensaje);
	        $("#not_apruebaAsigna").append("<br> "+data.mensaje.mensaje);
	        $("#pkID_usuario_asignado").removeAttr('disabled');
	        //location.reload();
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/
	}

	//--------------------------------------------------------------------------------------------------
	$("[name*='aprobar_asignar']").click(function(event) {
		/* Act on the event */
		console.log('aprobar o asignar proceso '+$(this).attr('data-id-proceso'));

		//valida_paso_action($(this).attr('data-id-proceso'));
		cons_users($(this).attr('data-id-proceso'));

		$("#not_apruebaAsigna").html("");
		$("#not_apruebaAsigna").append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');	
	});

});