$(function(){

	var id_aliado_select = "";
	//-------------------------------------------------------------------
	//viene de http://trentrichardson.com/examples/timepicker/#basic_examples
	$( "[data-type*='datepicker']" ).datetimepicker({
		dateFormat: "yy-mm-dd",
	});
	//traer datos de la BD-----------------------------------------------

	//var c_agenda = "select * from agenda where estado = 'activo' ";
	var c_agenda = "select * from evento";

	$.ajax({
		url: "../Controller/interfaz_ajax.php",
		data: "consulta="+c_agenda+"&tipo=mostrar",
	})
	.done(function(data) {
		console.log(data.mensaje);
		//---------------------------------------------------------------
		$('#calendario').fullCalendar({
		    //weekends: false // will hide Saturdays and Sundays
		    dayClick: function() {
		        console.log($(this));
		    },
		    eventClick: function(calEvent) {//aca ya tiene todos los eventos y sus datos
		    	//le cambia el data action al boton de guardar por actualizar
		    	//$("#btn_guardaevento").attr("data-action","actualizar");
		    	//$("#btn_guardaevento").html('<span class="glyphicon glyphicon-floppy-disk"></span>&nbspEditar');
					$("#btn_editarEvento").attr("data-action","actualizar");
					$("#btn_editarEvento").html('<span class="glyphicon glyphicon-floppy-disk"></span>&nbspEditar');
		    	//
		        console.log(calEvent);
		        //$("#f_evento")[0].reset();
						$("#f_evento_modal")[0].reset();
		        //carga los datos
		        $("#id_evento_modal").attr("value",calEvent.pkID);
		        $("#titulo_modal").attr("value",calEvent.title);
		        $("#start_modal").attr("value",calEvent.start._i);
		        $("#end_modal").attr("value",calEvent.end._i);
		        $("#descripcion_modal").html(calEvent.descripcion);
						$("#direccion_modal").attr("value",calEvent.direccion);
		        $("#estado_modal").val(calEvent.estado);
		        //----------------------------------------
		        //muestra el modal con los datos cargados
		        //$('#form_calendario').modal('show');
						$("#eventosModal").modal("show");
						//muestra el boton de agregar aliados
						//$("#agregaAliado").removeAttr('hidden');
		        //console.log(jsEvent);
		        //console.log(view);
						//---------------------------------------------------------------------------------------------
						//cargar los aliados que estan relacionados con el evento
						//peticion ajax de consulta a la tabla de aliado en aliado_evento que
						//sea igual al id de cada uno, eso se carga en un div dentro de la
						/*pestaña de gestion de aliados, en caso de que no halla nada se muestra
						una notificacion de que no hay aliados relacionados con este evento
						y se da la opción de seleccionar de un select un aliado y un boton para
						insertarlo y poderlo relacionar, estos cambios se van a ver el el div
						dispuesto para esto y en el registro del aliado al darle click en la
						opcion ver eventos. //recuerde quitar las opciones de edicion en ese registro.
						*/
						/*peticion ajax que trae la consulta de que aliados está relacionados con este evento
						*/
						var c_aliado_evento = "SELECT aliados.*, evento.pkID as id_evento, evento.title as nom_evento, localidades.nombre as loc_nombre "+

						" FROM `aliados` "+

						" inner join evento_aliado on aliados.pkID = evento_aliado.id_aliado"+

						" inner join evento on evento.pkID = evento_aliado.id_evento"+

						" inner join localidades on localidades.pkID = aliados.localidad_id"+

						" WHERE evento.pkID = "+calEvent.pkID+" order by localidades.nombre asc";

						$.ajax({
							url: "../Controller/interfaz_ajax.php",
							data: "consulta="+c_aliado_evento+"&tipo=mostrar",
						})
						.done(function(data) {
							//console.log("success");
							console.log(data.mensaje);

							$("#listaAliados").html("");

							$.each(data.mensaje,function(index, valor) {
								//console.log(valor.nombre_1);
								$("#listaAliados").append(
									"<li class='list-group-item'> <span>ID-:"+valor.n_identificacion+" "+valor.nombre_1+" "+valor.apellido_1+" Localidad:"+valor.loc_nombre+"</span> <a id='aliado"+valor.pkID+"' data-id-aliado='"+valor.pkID+"' data-id-evento='"+$("#id_evento_modal").val()+"' data-action='elimina_evento_aliado'><span class='glyphicon glyphicon-remove'></span>&nbspQuitar</a> "+"</li>"
								);
							});

							//--------------------------------------------
							//funcion seleccion del aliado a añadir
							$('#select_aliado').on('change',function(){
							    id_aliado_select = $(this).val();
							    console.log(id_aliado_select);
							});
							//--------------------------------------------

							//--------------------------------------------
							//funcion para quitar el aliado en la consulta inicial
							$("a[id*='aliado']").click(function(){
								console.log("se ha hecho click a un quitar aliado.");

								//var c_elimina_evento_aliado =

								//"consulta="+c_elimina_evento_aliado+"&tipo=mostrar",

								var id_aliado = $(this).attr("data-id-aliado");
								var id_evento = $(this).attr("data-id-evento");
								var action = $(this).attr("data-action");

								$.ajax({
									url: "../Controller/interfaz_ajax.php",
									data: "id_aliado="+id_aliado+"&id_evento="+id_evento+"&tipo="+action,
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

								return false;

							});
							//--------------------------------------------

						})
						.fail(function() {
							console.log("error");
						})
						.always(function() {
							console.log("complete");
						});

						//---------------------------------------------------------------------------------------------
		    },
		    header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				editable: false,
				eventLimit: true, // allow "more" link when too many events
				events: data.mensaje
		});
		//---------------------------------------------------------------
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
	//-------------------------------------------------------------------
	//crear evento
	$("#btn_crea_e").click(function(){
		//limpia el form
		var form_de_eventos = $("#f_evento")[0];
		$.each(form_de_eventos, function(index, val) {
			 $("#"+val.id).val("");
		});
		//-------------
		$("#btn_guardaevento").html('<span class="glyphicon glyphicon-floppy-disk"></span>&nbspGuardar');
		$("#btn_guardaevento").attr("data-action","crear");
		//-------------------------------------------------
		$("#agregaAliado").attr("hidden","true");
		//-------------------------------------------------
	});
	//guarda evento
	//objt_f_aliado = $("#form_aliado").valida();

	$("#btn_guardaevento").click(function(event) {

		var inicio = $("#start").val();
		var fin = $("#end").val();

		console.log("el inicio es "+inicio+" el final es "+fin);

		if(inicio===fin){
			//console.log("las fechas son iguales");
			alert("La fecha y/o la hora de inicio y fin del evento son iguales, por favor cambielas.");

		}else{
			//console.log("ok con las fechas");
			//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			/* Act on the event */

			var data_action = $(this).attr("data-action");
			//console.log(data_action);

			if(data_action=="crear"){
				//-----------------------------------------------------
				//----------------------------------------------------
				objt_f_evento = $("#f_evento").valida();

					console.log(objt_f_evento);

					if(objt_f_evento.estado = true){

						$.ajax({
							url: "../Controller/interfaz_ajax.php",
							data: objt_f_evento.srlz+"&tipo=insert_evento",
						})
						.done(function(data) {
							//console.log(data[0].mensaje);
							alert(data[0].mensaje);
							location.reload();

						})
						.fail(function() {
							console.log("error");
						})
						.always(function() {
							console.log("complete");
						});

					}
				//-----------------------------------------------------
			}else if(data_action=="actualizar"){
				//-----------------------------------------------------
				//enviar evento ajax para actualizar
				//----------------------------------------------------
				objt_f_evento = $("#f_evento").valida();

					//console.log(objt_f_evento);

					if(objt_f_evento.estado = true){

						$.ajax({
							url: "../Controller/interfaz_ajax.php",
							data: objt_f_evento.srlz+"&tipo=update_evento",
						})
						.done(function(data) {
							//console.log(data[0].mensaje);
							alert(data[0].mensaje);
							location.reload();
						})
						.fail(function() {
							console.log("error");
						})
						.always(function() {
							console.log("complete");
						});

					}
				//-----------------------------------------------------
				//-----------------------------------------------------
			}
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		}

		//return false;
	});

	$("#btn_editarEvento").click(function() {
		var action_modal = $(this).attr("data-action");

		if(action_modal === "actualizar"){
			//enviar evento ajax para actualizar
			//----------------------------------------------------
			objt_f_evento = $("#f_evento_modal").valida();

				//console.log(objt_f_evento);

				if(objt_f_evento.estado = true){

					$.ajax({
						url: "../Controller/interfaz_ajax.php",
						data: objt_f_evento.srlz+"&tipo=update_evento",
					})
					.done(function(data) {
						//console.log(data[0].mensaje);
						alert(data[0].mensaje);
						location.reload();
					})
					.fail(function() {
						console.log("error");
					})
					.always(function() {
						console.log("complete");
					});
			  //-------------------------------------------------------
			 }else{

			 }

		}else{

		}

	});

	$("#btn_agrega_aliado").click(function() {

		console.log("iniciando la asignacion de aliado evento.");

		var c_inserta_aliado_evento = "id_evento="+$("#id_evento_modal").val()+"&id_aliado="+id_aliado_select;

		$.ajax({
			url: "../Controller/interfaz_ajax.php",
			data: c_inserta_aliado_evento+"&tipo=inserta_evento_aliado",
		})
		.done(function(data) {
			//--------------------------------------------------------------------------
			console.log(data.mensaje);
			//refrescar el div de resultados
			var c_aliado_evento = "SELECT aliados.*, evento.pkID as id_evento, evento.title as nom_evento, localidades.nombre as loc_nombre "+

			" FROM `aliados` "+

			" inner join evento_aliado on aliados.pkID = evento_aliado.id_aliado"+

			" inner join evento on evento.pkID = evento_aliado.id_evento"+

			" inner join localidades on localidades.pkID = aliados.localidad_id"+

			" WHERE evento.pkID = "+$("#id_evento_modal").val()+" order by localidades.nombre asc";

			$.ajax({
				url: "../Controller/interfaz_ajax.php",
				data: "consulta="+c_aliado_evento+"&tipo=mostrar",
			})
			.done(function(data) {
				console.log("success");

				$("#listaAliados").html("");

				$.each(data.mensaje,function(index, valor) {
					//console.log(valor.nombre_1);
					$("#listaAliados").append(
						"<li class='list-group-item'> <span>ID:"+valor.n_identificacion+" "+valor.nombre_1+" "+valor.apellido_1+" Localidad:"+valor.loc_nombre+"</span> <a id='aliado"+valor.pkID+"' data-id-aliado='"+valor.pkID+"' data-id-evento='"+$("#id_evento_modal").val()+"' data-action='elimina_evento_aliado'><span class='glyphicon glyphicon-remove'></span>&nbspQuitar</a> "+"</li>"
					);
				});

				$("#listaAliados").fadeOut(800);

				$("#listaAliados").fadeIn().delay(2000);

				//----------------------------------------
				//--------------------------------------------
				//funcion para quitar el aliado
				$("a[id*='aliado']").click(function(){
					console.log("se ha hecho click a un quitar aliado.");

					//var c_elimina_evento_aliado =

					//"consulta="+c_elimina_evento_aliado+"&tipo=mostrar",

					var id_aliado = $(this).attr("data-id-aliado");
					var id_evento = $(this).attr("data-id-evento");
					var action = $(this).attr("data-action");

					$.ajax({
						url: "../Controller/interfaz_ajax.php",
						data: "id_aliado="+id_aliado+"&id_evento="+id_evento+"&tipo="+action,
					})
					.done(function(data) {
						console.log(data);
						//---------------------------------------
						//consultar y listar
						
						$("#listaAliados").fadeOut(800);

						$("#listaAliados").fadeIn().delay(2000);
						//---------------------------------------
					})
					.fail(function() {
						console.log("error");
					})
					.always(function() {
						console.log("complete");
					});

					//return false;

				});
				//--------------------------------------------

				//----------------------------------------

			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			//--------------------------------------------------------------------------
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});

	});

});
