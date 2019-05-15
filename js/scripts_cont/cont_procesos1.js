$(function(){
	
	uppercaseForm("form_proceso");
	//------------------------------------------

	$("#btn_nuevoProceso").jquery_controllerV2({
  		nom_modulo:'proceso',
  		titulo_label:'Nuevo Proceso',
  		ejecutarFunction:true,
  		functionBefore:function(ajustes){            

  			//setea fecha de creacion
            $("#fecha_creacion").val(date);
            //quita disabled al boton de accion
			$("#btn_actionproceso").removeAttr('disabled');
			//--------------------------------------------------
			$("#observaciones").removeAttr('readonly');
		  	$("#btn_nuevoobservacion").attr('disabled', 'true');		  	                       
		  	//--------------------------------------------------
		  	$("#div_tipo_proceso").removeAttr('hidden');

		  	//--------------------------------------------------
		  	$("#fkID_tipo").change(function(event) {
		  		tipo_proceso($(this).val())
		  	});
		  	//--------------------------------------------------
		  	//evento click del checkbox recurrente
		  	//si esta check muestra el campo de fecha revision 
		  	//de lo contrario no y borra el valor.
		  	$("#chk_recurrente").click(function(event) {
		  		//console.log($(this)[0]["checked"]);
		  		chk_rec($(this)[0]["checked"]);		  		
		  	});		  	
		  	//--------------------------------------------------
		  	//console.log($("#fkID_paso_actual").val());
		  	pasos_objt.paso = '1';
		  	//console.log(pasos_objt.paso);
		  	pasos_objt.carga_paso();
		  	pasos_objt.carga_estados();
		  	//--------------------------------------------------
		  	$("#div-observaciones").attr('hidden', 'true');
		  	//--------------------------------------------------
		  	$("#form_indicadores_proceso")[0].reset();
        }
  	});

	function chk_rec(tipo){

		if (tipo == true) {
  			$("#div_fecha_revision").removeAttr('hidden');
  			$("#chk_recurrente").val('1');
  		} else{
  			$("#div_fecha_revision").attr('hidden','true');
  			$("#chk_recurrente").val('0');
  			$("#fecha_revision").val('');
  		};
	}

  	function tipo_proceso(id_paso){

  		$("#fecha_apertura").val('');

  		if (id_paso == "6") {
  			//muestra la fecha
  			$("#div_fecha_apertura").removeAttr('hidden');

  		}else{
  			//la esconde
  			$("#div_fecha_apertura").attr('hidden','true');
  		};
  	}

/*
  	function validaEqualProceso(num_id){

		console.log("busca valor "+encodeURI(num_id));

		var consEqual = "SELECT COUNT(*) as res_equal FROM `procesos` WHERE `codigo` = '"+num_id+"'";

	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consEqual+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	/**/
	        //console.log(data.mensaje[0].res_equal);
/*
	        if(data.mensaje[0].res_equal > 0){
	        	alert("El Código de referencia del proceso ya existe, por favor ingrese un Código diferente.");
				$("#codigo").val("");
	        }else{
	        	//return false;
	        }
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });

	}

*/

	function codProceso(id){

		//nom_tabla=log_rt
		var codProceso = "select * from procesos WHERE pkID="+id;

		$.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+codProceso+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	/*muestra data actual*/
	        console.log(data);
	        $("#codigo").val(data.mensaje[0].codigo);	        			      
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/		
	}



  	//---------------------------------------------------------------	
	//calendario para la fecha de cierre
	$( "#fecha_cierre" ).datepicker({
		dateFormat: "yy-mm-dd",
		minDate: 1			
	});
	//calendario para la fecha de apertura
	$( "#fecha_apertura" ).datepicker({
		dateFormat: "yy-mm-dd",
		minDate: 0			
	});
	//calendario para la fecha de revision
	$( "#fecha_revision" ).datepicker({
		dateFormat: "yy-mm-dd",
		minDate: 30			
	});		
	//---------------------------------------------------------------

	//---------------------------------------------------------------
	//Click en la grilla y va al detalle

	$('.table').on( 'click', '.detail', function () {
	  window.location.href = $(this).attr('href');
	} );
	//---------------------------------------------------------------

	//---------------------------------------------------------------
	//mascara de dinero para cuantia	
	
	$('#cuantia_mask').mask('000.000.000.000.000', {reverse: true});	

	$('#cuantia_mask').change(function(event) {		
		var val_cuantia = $(this).val();		
		$('#cuantia').val(remplazar(val_cuantia, ".", ""))		
	});

	$('#capital_trabajo_mask').mask('000.000.000.000.000', {reverse: true});	

	$('#capital_trabajo_mask').change(function(event) {		
		var val_capital = $(this).val();		
		$('#capital_trabajo').val(remplazar(val_capital, ".", ""))		
	});

	$('#patrimonio_mask').mask('000.000.000.000.000', {reverse: true});	

	$('#patrimonio_mask').change(function(event) {		
		var val_patrimonio = $(this).val();		
		$('#patrimonio').val(remplazar(val_patrimonio, ".", ""))		
	});
	//---------------------------------------------------------------

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
	$("#btn_actionproceso").jquery_controllerV2({
  		tipo:'inserta/edita',
  		nom_modulo:'proceso',
  		nom_tabla:'procesos',
  		recarga:false,
  		ejecutarFunction:true,
  		functionResEditar:function(){
  			//console.log(data)  			
  			//editar indicadores
  			//console.log($("#btn_actionproceso").attr('data-action'))
  			indicadores.indicador_proc($("#form_indicadores_proceso"),id_proceso,$("#btn_actionproceso").attr('data-action'));            
            //--------------------------------------------------
            //location.reload();            
        },
        functionResCrear:function(data){
            //console.log('El ultimo creado fue: '+ajustes.id_resCrear);
            console.log(data);
            console.log('Ejecutando luego de Insertar!!!');
            //location.reload();

            $("#btn_actionproceso").attr('disabled', 'true');

            $("#not_proceso_email").html('<strong>Atención! por favor espere un momento</strong>, creando proceso y paso correspondiente.');

            paso.pkID_proceso = data[0].last_id;

            //-----------------------------------------------------------------
            //insertar indicadores
            //console.log($(this).data('action'));
            indicadores.indicador_proc($("#form_indicadores_proceso"),data[0].last_id,$("#btn_actionproceso").attr('data-action'));
            //-----------------------------------------------------------------

	        var paso_srlz = $.param( paso );
			console.log( paso_srlz );

	        var paso_creado = crea_paso(paso_srlz);

	        //console.log(paso_creado);

	        paso_creado.success(function(data){
	        	
	        	console.log(data);

	        	if (data[0].estado == "ok") {
	        		//envia el correo
	        		//enviar correo de solicitud de aprobacion

			        //setea el objeto email para solicitud de aprobacion
			        email.pkID_usuario=leerCookie("log_lunelAdmin_id");
			        email.pkID_proceso=paso.pkID_proceso;
			        email.tipo_asunto=2;
			        email.tipo_cuerpo='solicitud_aprobacion';
			        email.enviar=true;			         

			        if (email.enviar == true) {

			        	//console.log(email);
			        	/**/       	

			        	var email_enviado = enviaCorreoResponsable(email.pkID_usuario,email.tipo_asunto,email.tipo_cuerpo,email.pkID_proceso);

			        	//console.log(email_enviado);
			        	
			        	email_enviado.success(function(data){
			        		console.log(data);
			        		//alert(data.mensaje.mensaje);
			        		$("#not_proceso_email").html(data.mensaje.mensaje);
			        		
			        		setTimeout(function(){
			        			location.reload();
			        		},1000)
			        		
			        	});

			        }else{
			        	location.reload();
			        };

	        	} else{
	        		alert(data[0].mensaje);
	        	};
	        });

        },
        functionBefore:function(ajustes){
        	console.log('Ejecutando antes de hacer cualquier cosa');
        	//setea el campo de observaciones
        	if (ajustes.action != "editar") {
        		$("#observaciones").val( date+" : Creado. -- " );
        	};
        	
        }  		 		  
  	});  	
	//---------------------------------------------------------------

	//---------------------------------------------------------------
	$("[name*='edita_proceso']").jquery_controllerV2({
		tipo:'carga_editar',
  		nom_modulo:'proceso',
  		nom_tabla:'procesos',
  		titulo_label:'Edita Proceso',
  		tipo_load:1,
  		ejecutarFunction:true,
  		functionBefore:function(ajustes){                
            console.log('Ejecutando antes de cualquier cosa!!!');
            $("#div-observaciones").removeAttr('hidden');                
        },
  		functionResCarga:function(id,data){
            //console.log('El eliminar registro: '+ajustes.id_resCrear);
            console.log('Ejecutando luego de Cargar!!!');

            //setea paso a pasos_objt
          	pasos_objt.paso = data.mensaje[0].fkID_paso_actual;

          	//setea el estado actual
          	pasos_objt.estado = data.mensaje[0].fkID_estado;

          	//--------------------------------------------------
		  	//carga el estado segun sea el paso actual
		  	//console.log($("#fkID_paso_actual").val());
		  	pasos_objt.carga_estados();
		  	//--------------------------------------------------

            $.each(data.mensaje[0], function( key, value ) {
	          
	          console.log(key+"--"+value);

	          $("#"+key).val(value);         
	          
	          if (key == "cuantia") {
	          	$("#"+key).val(value);
	          	$("#"+key+"_mask").val(accounting.formatNumber(value,options_format));
	          }; 

	          if (key=="pkID") {
	          	id_proceso = value;
	          };     	          

	        });

	        //-----------------------------------------------
	        //---------------------------------
	  		$("#observaciones").attr('readonly', 'true');
	  		$("#btn_actionproceso").removeAttr('disabled');
	  		//$("#btn_nuevoobservacion").removeAttr('disabled');
	  		//-----------------------------------------------
	  		//luego de cargar validar el paso actual
	  		//si es 1 creado no muestra paso actual
	  		//si es 5 revision muestra 6 viable para presentar y 7 Descartar
	  		//si es 6 viable para presentar muestra 9 Entregado o No entregado
	  		//si es 9 Entregado o No entregado o 7 Descartar se esconde paso actual

          	pasos_objt.carga_paso();

          	//manifestacion de interes? fkID_tipo == 6??
          	if (data.mensaje[0].fkID_tipo == "6") {
          		//div_tipo_proceso
          		//div_fecha_apertura
          		$("#div_tipo_proceso").removeAttr('hidden')
          		$("#div_fecha_apertura").removeAttr('hidden')
          	}else{
          		$("#div_tipo_proceso").removeAttr('hidden')
          		$("#div_fecha_apertura").attr('hidden','true')
          	};

          	//--------------------------------------------------
		  	$("#fkID_tipo").change(function(event) {
		  		tipo_proceso($(this).val())
		  	});	        	  	
	  		//--------------------------------------------------
	  		if (data.mensaje[0].recurrente == "1") {
	  			$("#chk_recurrente")[0]["checked"] = true;
	  			chk_rec(true)
	  		} else{
	  			$("#chk_recurrente")[0]["checked"] = false;
	  			chk_rec(false)
	  		};

	  		$("#chk_recurrente").click(function(event) {
		  		//console.log($(this)[0]["checked"]);
		  		chk_rec($(this)[0]["checked"]);		  		
		  	});
		  	//--------------------------------------------------
		  	//cargar indicadores
		  	indicadores.cons_indicador_proc($("#form_indicadores_proceso"));
		  	//--------------------------------------------------
        }
	});


/*
	$("#codigo").keyup(function(event) {
		/* Act on the event */
/*		if (( (event.keyCode < 48) && (event.keyCode != 8)) || (event.keyCode > 57)){
			console.log(String.fromCharCode(event.which));
			alert("El Código de identificación NO puede llevar valores alfanuméricos.");			
			$(this).val("");
		}
	});


	$("#codigo").change(function(event) {
		/* valida que no tenga menos de 8 caracteres */
/*		var valores_idCli = $(this).val().length;
		console.log(valores_idCli);
		if(valores_idCli < 7){
			alert("El codigo de identificación no puede ser menor a 7 valores.");
			$(this).val("");
			$(this).focus();
		}

		validaEqualProceso($(this).val());
	});

*/

	$("[name*='elimina_proceso']").jquery_controllerV2({
  		tipo:'eliminar',
  		nom_modulo:'proceso',
  		nom_tabla:'procesos'
  	});
	//---------------------------------------------------------------

	//modal recarga, evita error de varias instanciaciones
	$("#form_modal_proceso").on('hidden.bs.modal', function (e) {	  
	  //resetea el change de paso actual para que al 
	  //cargar lo defina de nuevo
	  //https://api.jquery.com/unbind/
	  //$("#fkID_paso_actual").unbind("change");
	  $("#btn_actionproceso").unbind("click");
	})


	//---------------------------------------------------------------
	//console.log(leerCookie("log_lunelAdmin_id"));
	//resetear el elemento de las tablas, esto se ejecuta al inicio
	sessionStorage.setItem("id_tab_proceso",null);	
	//---------------------------------------------------------------


	$("#chk_recurrente").click(function(event) {
		
		if(document.getElementById("chk_recurrente").checked) {
		    document.getElementById('chk_recurrente_hidden').disabled = true;
		}else{
			document.getElementById('chk_recurrente_hidden').disabled = false;
		}

	}); 

}); 