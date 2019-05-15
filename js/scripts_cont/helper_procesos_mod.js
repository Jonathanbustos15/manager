(function(){

	//console.log('hola helper mod procesos.');------------------------------------------
	self.id_proceso=0;

	//variable para los pasos
	self.paso={
		"fecha":date,
		"actual":1,
		"pkID_proceso":"-",
		"idPaso1":"0",
		"idPaso2":$("#fkID_paso_actual").val(),
		"pkID_usuario":leerCookie("log_lunelAdmin_id"),
		"pkID_usuario_asignado":''
	};

	//VARIABLES EMAIL---------------------------------------------------------------------
	
	self.email={

		"pkID_usuario":'',
		"tipo_asunto":'',
		"tipo_cuerpo":'',
		"pkID_proceso":'',
		"enviar":false
	};	

	self.email_reasigna={

		"pkID_usuario":'',
		"tipo_asunto":'',
		"tipo_cuerpo":'',
		"pkID_proceso":'',
		"enviar":false
	};

	//variable de formateo--------------------------------------------------------------
	self.options_format = {
		symbol : "$",
		decimal : ",",
		thousand: ".",
		precision : 0,
		format: "%s%v"
	};
	//-----------------------------------------------------------------------------------
	/*
	var paso_srlz = $.param( paso );
	console.log( paso_srlz );*/
	//-----------------------------------------------------------------------------------
	//FUNCIONES

	//funcion que inserta el paso

	self.crea_paso = function (paso_param){

	      //--------------------------------------
	return $.ajax({
	          url: "../controller/ajaxController12.php",
	          data: paso_param+"&tipo=inserta&nom_tabla=pasos",
	          async: false,
	        })
	        .done(function(data) {	          
	          
	        })
	        .fail(function(data) {
	          console.log(data);	                   
	        })
	        .always(function() {
	          console.log("complete crea_paso");
	        });	     
	};
	//-----------------------------------------------------------------------------------

	self.cons_proceso_id=function(){

		var consulta_proceso = "select procesos.*, pasos_proceso.nombre as nom_paso, entidades.nombre_entidad as nom_entidad, estado_proceso.nombre as nom_estado, tipo_proceso.nombre as nom_tipo"+

								" FROM procesos"+ 

								" INNER JOIN pasos_proceso ON pasos_proceso.pkID = procesos.fkID_paso_actual"+

								" INNER JOIN entidades on entidades.pkID = procesos.fkID_entidad"+

								" INNER JOIN estado_proceso on estado_proceso.pkID = procesos.fkID_estado"+

								" INNER JOIN tipo_proceso on tipo_proceso.pkID = procesos.fkID_tipo "+

								" WHERE procesos.pkID = "+id_proceso;

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_proceso+"&tipo=consulta_gen",
	        async: false,
	    })
	    .done(function(data) {
	    	//------------------------------------------
	        //this.paso_reciente = data.mensaje[0].idPaso2;		        
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/

	}

	self.cons_paso_actual=function(){

		var consulta_paso = "select * from pasos where pkID_proceso = "+id_proceso+" ORDER BY pkID DESC LIMIT 1";

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_paso+"&tipo=consulta_gen",
	        async: false,
	    })
	    .done(function(data) {
	    	//------------------------------------------
	        //this.paso_reciente = data.mensaje[0].idPaso2;		        
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/

	}

	self.cons_users=function (){

		//this.id_proceso = id_proceso;		
		/*---------------------------------------------------*/
		var query_users = "SELECT * FROM `usuarios` where (email != '') AND (email IS NOT NULL) ";

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+query_users+"&tipo=consulta_gen&nom_tabla=usuarios",
	        async: false,
	    })
	    .done(function(data) {	              	       
	        //validaDivUsers(data,id_proceso);
	    })
	    .fail(function(){
	        console.log("error");
	    })
	    .always(function(){
	        console.log("complete");
	    });
		/*---------------------------------------------------*/
	}

	self.cons_estado=function(cons){
		/*---------------------------------------------------*/
		var query_estado = "SELECT * FROM `estado_proceso` WHERE "+cons;

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+query_estado+"&tipo=consulta_gen",
	        async: false,
	    })
	    .done(function(data) {	              	       
	        //validaDivUsers(data,id_proceso);
	    })
	    .fail(function(){
	        console.log("error");
	    })
	    .always(function(){
	        console.log("complete");
	    });
		/*---------------------------------------------------*/
	}

	self.cons_estado_all=function(){
		/*---------------------------------------------------*/
		var query_estado = "SELECT * FROM `estado_proceso`";

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+query_estado+"&tipo=consulta_gen",
	        async: false,
	    })
	    .done(function(data) {	              	       
	        //validaDivUsers(data,id_proceso);
	    })
	    .fail(function(){
	        console.log("error");
	    })
	    .always(function(){
	        console.log("complete");
	    });
		/*---------------------------------------------------*/
	}

	//-----------------------------------------------------------------------------------
	//funcion que envía correos

	self.enviaCorreoResponsable = function (pkID_usuario,asunto,tipo_cuerpo,pkID_proceso){		

	return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "pkID_usuario="+pkID_usuario+"&tipo_asunto="+asunto+"&tipo_cuerpo="+tipo_cuerpo+"&pkID_proceso="+pkID_proceso+"&tipo=email",
	        beforeSend: function(){

	        	var men_email = '<strong>Un momento por favor...</strong>, Enviando correos correspondientes.';
	        	$("#pkID_usuario_asignado").attr('disabled', 'true');
	        	
	        	$("#not_proceso_email").html(men_email);
	        	$("#not_apruebaAsigna").html(men_email);
	        }
	    })
	    .done(function(data) {

	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/
	}
	//-----------------------------------------------------------------------------------


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//Funciones de asignar btn

	self.action_asig={		

		paso_reciente:0,
				
		crea_select_users:function (){		
			
			//instancia la funcion
	        var data_users = cons_users();

	        //console.log(data_users);

	        //en el success de la funcion va
	        data_users.success(function(data){

	        	var ciclo_users = $.each(data.mensaje, function(index, val) {
		        	 /* iterate through array or object */
		        	 //if( leerCookie("log_lunelAdmin_id") != val.pkID ){

		        		$("#pkID_usuario_asignado").append('<option value="'+val.pkID+'">'+val.nombre+' '+val.apellido+'</option>');
		        	 //};

		        });

	        	//al terminar el ciclo define la acción a realizar
		        $.when(ciclo_users).then(ciclo_users_ok, ciclo_users_fail);
		        
		        function ciclo_users_ok(){

		        	console.log('Terminó de cargar los usuarios en el select!');
		        	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		        	//define el paso actual 
		        	//this.def_paso_actual();
		        	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		        	//antes de abrir el modal cargar datos requridos del proceso
		        	action_asig.abre_modal();

	        		//evento change del select cargado
	        		$("#pkID_usuario_asignado").change(function(event) {
	        		
	        			//setea usuario en el paso
			        	paso.pkID_usuario_asignado = $(this).val();
			        	console.log(paso);

			        	//asigna usuario con este valor
			        	action_asig.asignar_usuario($(this).val());			        	
			        });
		        	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		        }

		        function ciclo_users_fail(){

		        	console.log('Terminó de cargar y algo salio mal!');
		        	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		        	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		        }

	        });	        	       
	    },
	    abre_modal:function(){

	    	//antes de abrir el modal cargar datos requridos del proceso
        	var cons_proess = cons_proceso_id();

        	cons_proess.success(function(data){
        		console.log(data);
        		//abre el modal
        		if (data.estado == "ok") {
        			//carga lo datos y ahi si abre el modal
        			$("#lbl_entidad_frm").html(data.mensaje[0].nom_entidad);
        			$("#lbl_objeto_frm").html(data.mensaje[0].objeto);        		
        			$("#lbl_valor_frm").html('$'+accounting.formatNumber(data.mensaje[0].cuantia,options_format));

        			$("#form_modal_aprobar_asignar").modal("show");
        		} else{
        			alert("Hay un problema con este proceso.");
        			location.reload();
        		};
    			
        	});
        	
	    },
	    crea_asig:function(){

			if ( $("#div_asigna_aprueba").length > 0 ) {
				  // Siempre será validado, incluso si #undiv no existe
				  //console.log('el asigna usuario dentro del form_aprobar_asignar ya existe!');
				  //muestra el modal para asignar
				  //$("#form_modal_aprobar_asignar").modal("show");
				  action_asig.abre_modal();
				  //resetea el select de usuarios para asignar
				  $("#pkID_usuario_asignado").html('<option></option>');
				  //ejecuta la funcion de armado del select
				  this.crea_select_users();
				  //hace aparecer el div que contiene esta operacion
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

			        this.crea_select_users();
				}
		},
		
		asignar_usuario:function(id_usuario){


			//cual es el paso actual?
			//SELECT * FROM `pasos` WHERE `pkID_proceso` = 49
			//intancia la consulta del paso actual
			var def_paso_actual = cons_paso_actual();

			def_paso_actual.success(function(data){

				if (data.estado == "ok") {

					//define el paso actual
					this.paso_reciente = data.mensaje[0].idPaso2;

					//si el paso actual es creado
					if (this.paso_reciente == "1") {
						        					        			        	
						//se debe crear el paso 5 revision--------------------------------
											
						//este paso ya no es el actual
						action_asig.update_last_paso(data.mensaje[0].pkID);
						//actualiza el paso en el proceso
		        		action_asig.update_last_paso_proceso(5);

		        		/*asigna los valores al paso nuevo*/
				        paso.idPaso1 = this.paso_reciente;
				        paso.idPaso2 = 5; //revision
				        paso.pkID_proceso = id_proceso;

				        var paso_srlz = $.param( paso );

						console.log( paso_srlz );
						//se crea el paso de creado a revision
				        //crea_paso(paso_srlz);
				        //cuando se halla creado el paso si se envia el correo de asignacion
				        var paso_revision = crea_paso(paso_srlz);

				        paso_revision.success(function(data){
				        			        
				        	if (data[0].estado == "ok") {

				        		$("#not_apruebaAsigna").html(data[0].mensaje);

				        		//setea correo de que ha sido asignado
					        	//email.enviar = true;
								email.tipo_asunto = 3;
								email.tipo_cuerpo = 'asignado';
								email.pkID_proceso = id_proceso;
								email.pkID_usuario = id_usuario;

								var email_revision = enviaCorreoResponsable(email.pkID_usuario,email.tipo_asunto,email.tipo_cuerpo,email.pkID_proceso);

								email_revision.success(function(data){
					        		//console.log(data);
					        		//alert(data.mensaje.mensaje);
					        		$("#not_apruebaAsigna").html(data.mensaje.mensaje);
					        		setTimeout(function(){
					        			location.reload();
					        		},1000);				        		        		
					        	});

				        	}else{
				        		
				        		$("#not_apruebaAsigna").append(data[0].mensaje);

				        		alert("No se pudo crear el paso 'Revisón' para este proceso.");
				        	};

				        });			        
			        }

		        }else{

		        	alert(data.mensaje);
		        	location.reload();
				}		        

			});					
	        
		},
		update_last_paso:function(id_paso){

			/*---------------------------------------------------*/
			var update_paso = "UPDATE `pasos` SET `actual` = '0' WHERE `pasos`.`pkID` ="+id_paso;

			$.ajax({
		        url: '../controller/ajaxController12.php',
		        data: "query="+update_paso+"&tipo=consulta_gen&nom_tabla=pasos",
		        async: false,
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
		},
		update_last_paso_proceso:function(id_paso){

			/*---------------------------------------------------*/
			var update_paso_proceso = "UPDATE `procesos` SET `fkID_paso_actual` = '"+id_paso+"' WHERE `procesos`.`pkID` = "+id_proceso;

			$.ajax({
		        url: '../controller/ajaxController12.php',
		        data: "query="+update_paso_proceso+"&tipo=consulta_gen&nom_tabla=procesos",
		        async: false,
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


	}	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//objeto de pasos
	self.pasos_objt = {

		paso:0,
		estado:0,
		query_pasos:'',
		carga_estados:function(){
			/**/
			//var paso_actual = this.paso;

			var estado_cons = cons_estado("pkID = 1 OR pkID = 2");

			estado_cons.success(function(data){
				console.log(data);
				if (data.estado == "ok") {
					//cargar los estados segun sea la posibilidad establecida
					//solo carga los demas estados son automáticos.
					

					//si el paso actual es 1,5,6
					if (pasos_objt.paso == '1' || pasos_objt.paso == '5' || pasos_objt.paso == '6') {
						
						pasos_objt.itera_paso(data);

						$("#fkID_estado").removeAttr('disabled');

					} else{
						//si es cualquier otro solo inhabilita el control
						var estado_todos = cons_estado_all();

						estado_todos.success(function(data){

							console.log(data);

							if (data.estado == "ok") {
								
								pasos_objt.itera_paso(data);
								
								$("#fkID_estado").attr('disabled', 'true');

							}else{
								alert("No hay estados disponibles.")
							}

						});

					};					

				} else{
					alert("No hay estados disponibles.")
				};
			});
		},
		itera_paso: function(data){

			$("#fkID_estado").html("");

			var ciclo_estados = $.each(data.mensaje, function(index, val) {
				 /* iterate through array or object */
				 $("#fkID_estado").append('<option value="'+val.pkID+'">'+val.nombre+'</option>')
				 //seleccionar el estado que es

			});

			$.when(ciclo_estados).then(ciclo_estados_ok, ciclo_estados_fail);

			function ciclo_estados_ok(){
				$("#fkID_estado").val(pasos_objt.estado);
			}

			function ciclo_estados_fail(){
				console.log('No se cargaron los estados!');
			}

		},
		carga_paso: function(){			

			switch(this.paso) {

			    case '1'://creado
			        //crea la consulta de lo que debe traer
			        this.query_pasos = "select * from pasos_proceso where pkID = 1";
			        console.log(this.query_pasos)
			        this.switch_pasos();
			        break;
			    case '5'://Revision			        
			        //crea la consulta de lo que debe traer
			        this.query_pasos = "select * from pasos_proceso where pkID = 5 or pkID = 6 or pkID = 7";
			        this.switch_pasos();
			        break;
			    case '6': //viable para presentar			        			       
			        //crea la consulta de lo que debe traer
			        this.query_pasos = "select * from pasos_proceso where pkID = 6 or pkID = 9 or pkID = 10";
			        this.switch_pasos();			       			      
			        break;
			    case '9': //Entregado		        			       
			        //crea la consulta de lo que debe traer
			        this.query_pasos = "select * from pasos_proceso where pkID = 9 or pkID = 11 or pkID = 12";
			        this.switch_pasos();			       			      
			        break;
			    default:
			    	$("#div_paso_actual").attr('hidden','true');
			    	//this.query_pasos = "select * from pasos_proceso";
			        //this.switch_pasos();
			        //default code block
			}
		},
		switch_pasos:function(){

			if (this.paso != 1) {
				$("#div_paso_actual").removeAttr('hidden');	
			}else{
				$("#div_paso_actual").attr('hidden','true');
			}			

			var pasos_revision = this.cons_pasos_proceso(this.query_pasos);

	        pasos_revision.success(function(data){
	        	console.log(data);
	        	//cargar estos datos en fkID_paso_actual
	        	pasos_objt.carga_select_pasos(data.mensaje);
	        });

		},
		cons_pasos_proceso:function(consulta){
			//pasos_proceso
			
			return $.ajax({
		        url: '../controller/ajaxController12.php',
		        data: "query="+consulta+"&tipo=consulta_gen",
		        async: false,
		    })
		    .done(function(data) {	    	
		        //console.log(data);
		    })
		    .fail(function() {
		        console.log("error");
		    })
		    .always(function() {
		        console.log("complete");
		    });
		},
		actualiza_estado: function(query_update){

			return $.ajax({
		        url: '../controller/ajaxController12.php',
		        data: "query="+query_update+"&tipo=consulta_gen",
		        async: false,
		    })
		    .done(function(data) {	    	
		        //console.log(data);
		    })
		    .fail(function() {
		        console.log("error");
		    })
		    .always(function() {
		        console.log("complete");
		    });

		},
		estado_update: function(paso_sel){

			//cambio de estado auto segun sea el caso
        	/*si paso 7,10,11,12 -> estado : cerrado
        	  si paso 9 -> estado : abierto
        	*/
        	var query_up_estado = "";

			if (paso_sel == '7' || paso_sel == '10' || paso_sel == '11' || paso_sel == '12') {
				//pasa a cerrado
				query_up_estado = "update procesos set fkID_estado = 3 where pkID = "+id_proceso;

			} else if(paso_sel == '9'){

				query_up_estado = "update procesos set fkID_estado = 2 where pkID = "+id_proceso;
			};

			var update_estado = this.actualiza_estado(query_up_estado);
			
			//var query_up_estado = "update procesos set fkID_estado = xxx where pkID = "+pasos_objt.paso;
			//var update_estado = pasos_objt.actualiza_estado(query_up_estado);
		},
		carga_select_pasos:function(data){

			//vacia el select
			$("#fkID_paso_actual").html('');

			var ciclo_pasos = $.each(data, function(index, val) {
	        	 /* iterate through array or object */	        	 
	        	$("#fkID_paso_actual").append('<option value="'+val.pkID+'">'+val.nombre+'</option>');	        
	        });

			$("#fkID_paso_actual").val(this.paso);
        	//al terminar el ciclo define la acción a realizar
	        $.when(ciclo_pasos).then(ciclo_pasos_ok, ciclo_pasos_fail);

	        function ciclo_pasos_ok(){
	        	console.log('Termino de cargar los pasos!');
	        	//------------------------------------------------------------------------------------
	        	//define el on change del select
	        	//se cambió por el click del boton de acción
	        	//$("#fkID_paso_actual").change(function(event) {
	        	$("#btn_actionproceso").click(function(event) {

	        		var paso_actual = cons_paso_actual();

					paso_actual.success(function(data){

						//este paso ya no es el actual
						action_asig.update_last_paso(data.mensaje[0].pkID);

						//actualiza el paso en el proceso seleccionado en este select
		        		action_asig.update_last_paso_proceso($("#fkID_paso_actual").val());

		        		/*asigna los valores al paso nuevo*/
				        paso.idPaso1 = data.mensaje[0].idPaso2;
				        paso.idPaso2 = $("#fkID_paso_actual").val(); //el seleccionado
				        paso.pkID_proceso = id_proceso;
				        //el mismo usuario del paso pasado
				        paso.pkID_usuario_asignado = data.mensaje[0].pkID_usuario_asignado;

				        var paso_srlz = $.param( paso );

						//console.log( paso_srlz );
						//se crea el paso

				        var paso_change = crea_paso(paso_srlz);

				        paso_change.success(function(data){				        	

				        	if (data[0].estado == "ok") {

				        		//cambio de estado auto segun sea el caso
					        	/*si paso 7,10,11,12 -> estado : cerrado
					        	  si paso 9 -> estado : abierto
					        	*/
					        	pasos_objt.estado_update(paso.idPaso2);

				        		$("#not_proceso_email").html(data[0].mensaje);
				        		//alert(data[0].mensaje);
				        		//location.reload();

				        	}else{
				        		$("#not_proceso_email").html(data[0].mensaje);
				        		alert(data[0].mensaje);
				        	};

				        });

					});
	        		
	        		
	        	});
	        	//------------------------------------------------------------------------------------
	        }

	        function ciclo_pasos_fail(){
	        	console.log('Algo salio mal cargando los pasos!');
	        }
		}
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//funciones para indicadores

	self.crea_indicador_proceso = function (ind_pro_param){

		//--------------------------------------
		return $.ajax({
		          url: "../controller/ajaxController12.php",
		          data: ind_pro_param+"&tipo=inserta&nom_tabla=indicadores_proceso",
		          async: false,
		        })
		        .done(function(data) {	          
		          
		        })
		        .fail(function(data) {
		          console.log(data);	                   
		        })
		        .always(function() {
		          console.log("complete indicador proceso");
		        });	     
	};

	self.actualiza_indicador_proceso = function (ind_pro_param){

		//--------------------------------------
		return $.ajax({
		          url: "../controller/ajaxController12.php",
		          data: ind_pro_param+"&tipo=actualizar&nom_tabla=indicadores_proceso",
		          async: false,
		        })
		        .done(function(data) {	          
		          
		        })
		        .fail(function(data) {
		          console.log("fail indicadores proceso");	                   
		        })
		        .always(function() {
		          console.log("actualiza indicadores proceso");
		        });	     
	};

	self.cons_indicador_proceso = function (pkID){

		var consulta_proceso = "select * FROM `indicadores_proceso` WHERE fkID_proceso =  "+pkID;

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_proceso+"&tipo=consulta_gen",
	        async: false,
	    })
	    .done(function(data) {
	    	//------------------------------------------
	        //this.paso_reciente = data.mensaje[0].idPaso2;		        
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/

	};


	self.indicadores = {

		objectForm : {},
		arrayForm : [],
		paramForm : "",
		form_objeto : function(form,id_pro,accion){

			this.arrayForm = form.serializeArray();

			this.objectForm["fkID_proceso"] = id_pro;

			var itera = $.each(this.arrayForm, function(index, val) {
			
				indicadores.objectForm[val.name] = val.value;

			});

			$.when(itera).then(done_fobject);
			
			function done_fobject(){
				//console.log(indicadores.objectForm)

				indicadores.paramForm =  $.param(indicadores.objectForm)

				//console.log(indicadores.paramForm)
				//console.log(accion)

				if (accion == "crear") {

					var ind_proc_ins = this.crea_indicador_proceso(indicadores.paramForm);

					ind_proc_ins.success(function(data){
						console.log(data)
					});

				} else if(accion == "editar"){

					console.log(" El id de este indicadores es: "+indicadores.objectForm.pkID)
					/**/
					if (indicadores.objectForm.pkID != "") {

						var ind_proc_up = this.actualiza_indicador_proceso(indicadores.paramForm);

						ind_proc_up.success(function(data){
							console.log(data)
							if (data.estado == "ok") {
								location.reload()
							}
						});
					}else{
						location.reload()
					}					
					
				}

			}
			
		},
		indicador_proc : function(form,id_pro,accion){

			//validar el form

			this.form_objeto(form,id_pro,accion);

			/*
			var val_form = form.valida();

			if (val_form.estado == true) {
				this.form_objeto(form,id_pro,accion);
			} else {
				alert("Los indicadores no están diligenciados completamente.")
			}*/

			//console.log(this.paramForm)
		},
		cons_indicador_proc : function(form){

			var cons_ind_proc = cons_indicador_proceso(id_proceso);

			cons_ind_proc.success(function(data){
				//console.log(data)
				//reinicia el formulario
				form[0].reset();

				if (data.estado == "ok") {
					//console.log(form)
					
					$.each(data.mensaje[0], function(index, val) {
						 
						 console.log(" index: "+index+" val: "+val)

						 //$("#"+key+"_mask").val(accounting.formatNumber(value,options_format));

						 if ( $("#"+form[0].id+" input[name="+index+"]").length > 0 ){

						 	form[0][index]["value"] = val

						 	if (index == "capital_trabajo") {
						 		$("#capital_trabajo_mask").val(accounting.formatNumber(val,options_format));
						 	}else if(index == "patrimonio"){
						 		$("#patrimonio_mask").val(accounting.formatNumber(val,options_format));
						 	}
						 }						 
						 
					});

				}				

			});
		}

	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
})();