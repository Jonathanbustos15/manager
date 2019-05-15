$(function(){
	//console.log("Esto es el nuevo calendario.");

	//Variables globales
	var id_aliado_select = "";
	//---------------------------------------------------------------------------------------------------------------------
	//Funciones Principales
	//---------------------------------------------------------------------------------------------------------------------
	//Funcion para crear el control para seleccionar fechas
	//-------------------------------------------------------------------
	//viene de http://trentrichardson.com/examples/timepicker/#basic_examples
	$( "[data-type*='datepicker']" ).datetimepicker({
		dateFormat: "yy-mm-dd",
	});
	//---------------------------------------------------------------------------------------------------------------------
	//Funcion para la consulta inicial
	function cons_inicial(){

		//consulta
		var c_agenda = "select * from evento";

		//------------------------------------------------------------------------
		//Ajax consulta_inicial
		$.ajax({
			url: "../Controller/interfaz_ajax.php",
			data: "consulta="+c_agenda+"&tipo=mostrar"
		})
		.done(function(data) {
			console.log("success");
			//-----------------------------------------------------------------------
			//
			console.log(data.mensaje);
			//-----------------------------------------------------------------------
			//---------------------------------------------------------------
			//funcion para cargar los datos dentro del calendario
			$('#calendario').fullCalendar({
			    //weekends: false // will hide Saturdays and Sundays
			    dayClick: function() {
			        console.log($(this));
			    },
			    eventClick: function(calEvent) {
						//esto es lo que se ejecuta al hacer click dentro de un evento
						console.log(calEvent);
		        //Carga los eventos en el formulario de modal con pestañas

						//limpia formulario
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
						//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
						//funcion para cargar los aliados relacionados con este evento
						aliados_evento(calEvent.pkID);
						//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
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

		//------------------------------------------------------------------------

	};//cierra consulta inicial

	//funcion para cargar aliados relacionados a evento
	function aliados_evento(id_evento){

		//consulta+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		var c_aliado_evento = "SELECT aliados.*, evento.pkID as id_evento, evento.title as nom_evento, localidades.nombre as loc_nombre "+

		" FROM `aliados` "+

		" inner join evento_aliado on aliados.pkID = evento_aliado.id_aliado"+

		" inner join evento on evento.pkID = evento_aliado.id_evento"+

		" inner join localidades on localidades.pkID = aliados.localidad_id"+

		" WHERE evento.pkID = "+id_evento+" order by localidades.nombre asc";
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		//AJAX................................................................
		$.ajax({
			url: "../Controller/interfaz_ajax.php",
			data: "consulta="+c_aliado_evento+"&tipo=mostrar",
		})
		.done(function(data) {
			console.log(data.mensaje);
			//..................................................................
			//limpia la lista dentro del dom
			$("#listaAliados").html("");
			//crea la lista de los aliados relacionados
			$.each(data.mensaje,function(index, valor) {
				//console.log(valor.nombre_1);
				$("#listaAliados").append(
					"<li class='list-group-item'> <span>ID-:"+valor.n_identificacion+" "+valor.nombre_1+" "+valor.apellido_1+" Localidad:"+valor.loc_nombre+"</span> <a id='aliado"+valor.pkID+"' data-id-aliado='"+valor.pkID+"' data-id-evento='"+$("#id_evento_modal").val()+"' data-action='elimina_evento_aliado'><span class='glyphicon glyphicon-remove'></span>&nbspQuitar</a> "+"</li>"
				);
			});
			//..................................................................
			//funcion para quitar el aliado
			quita_aliado();
			//..................................................................
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});

		//....................................................................

	};//cierra la funcion aliados evento

	function quita_aliado(){

		$("a[id*='aliado']").click(function(){

			var id_aliado = $(this).attr("data-id-aliado");
			var id_evento = $(this).attr("data-id-evento");
			var action = $(this).attr("data-action");

			$.ajax({
				url: "../Controller/interfaz_ajax.php",
				data: "id_aliado="+id_aliado+"&id_evento="+id_evento+"&tipo="+action,
			})
			.done(function(data) {

				console.log(data);

				aliados_evento($("#id_evento_modal").val());

				$("#listaAliados").fadeOut(800);

				$("#listaAliados").fadeIn().delay(2000);

			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});

			return false;

		});
	};//cierra la funcion quita aliado


	function agrega_aliado(){

		var c_inserta_aliado_evento = "id_evento="+$("#id_evento_modal").val()+"&id_aliado="+id_aliado_select;

		$.ajax({
			url: "../Controller/interfaz_ajax.php",
			data: c_inserta_aliado_evento+"&tipo=inserta_evento_aliado",
		})
		.done(function(data) {
			console.log(data.mensaje);

			aliados_evento($("#id_evento_modal").val());

			$("#listaAliados").fadeOut(800);

			$("#listaAliados").fadeIn().delay(2000);

			//-----------------------------------------------------
			//funcion de quitar aliado
			quita_aliado();
			//-----------------------------------------------------

		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});


	};//cierra la funcion agrega aliado

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function crea_evento(action){

		//+++++++++++++++++++++++++++++
		var inicio = $("#start").val();
		var fin = $("#end").val();
		//+++++++++++++++++++++++++++++

		if(inicio===fin){
			//console.log("las fechas son iguales");
			alert("La fecha y/o la hora de inicio y fin del evento son iguales, por favor cambielas.");

		}else{

			var data_action = action;
			//console.log(data_action);

			if(data_action=="crear"){

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

					}else{

					};//cierra tercer if else

			}else{

			};//cierra segundo if else

		};//cierra primer if else

	};//cierra la funcion crea evento

	function edita_evento(){

		objt_f_evento = $("#f_evento_modal").valida();

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

		};//cierra else

	};//cierra funcion de editar evento

	//---------------------------------------------------------------------------
	//---------------------------------------------------------------------------------------------------------------------
	//ejecucion
	//--------------------------------------------
	//funcion seleccion del aliado a añadir
	$('#select_aliado').on('change',function(){
			id_aliado_select = $(this).val();
			console.log(id_aliado_select);
	});
	//--------------------------------------------
	//ejecuta la consulta inicial
	cons_inicial();
	//--------------------------------------------

	//--------------------------------------------
	//boton que crea el evento
	$("#btn_guardaevento").click(function(event) {
		var action = $(this).attr("data-action");
		crea_evento(action);
	});
	//--------------------------------------------
	//boton que edita el evento
	$("#btn_editarEvento").click(function() {
		edita_evento();
	});
	//--------------------------------------------
	//selector que añade aliados
	$("#btn_agrega_aliado").click(function() {
		agrega_aliado();
	});
	//--------------------------------------------

});
