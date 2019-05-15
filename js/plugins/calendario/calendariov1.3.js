$(function(){


  	//console.log("Esto es el nuevo calendario.");

  	//Variables globales
    var action = "";
    var objt_f_evento = "";
    var id_aliado_select = "";
  	//---------------------------------------------------------------------------------------------------------------------
  	//Funciones Principales
  	//---------------------------------------------------------------------------------------------------------------------
  	//Funcion para crear el control para seleccionar fechas
  	//-------------------------------------------------------------------
  	//viene de http://trentrichardson.com/examples/timepicker/#basic_examples
  	$( "[data-type*='datepicker']" ).datetimepicker({
  		dateFormat: "yy-mm-dd",
      timeFormat: "HH:mm:ss"
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
              $("#estado_modal").val(calEvent.estado);
              $("#fkID_aliado").val(calEvent.fkID_aliado);
  		        //----------------------------------------
  		        //muestra el modal con los datos cargados
  		        //$('#form_calendario').modal('show');
  						$("#eventosModal").modal("show");
  						//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  						//funcion para cargar los aliados relacionados con este evento
              console.log(calEvent.pkID);
              aliado_evento(calEvent.pkID);
  						aliados_evento(calEvent.pkID);              
  						//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
              $("#lbl_form_ingreso").html("Edita Registro Evento");
              $("#btn_actionEvento").attr("data-action","editar");
              $("#lbl_btn_actionEvento").html("Guardar Cambios");      
      
              $("#buscaAliado").val("");

              $("#div_btn_aliado").removeAttr("hidden");
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
  			//$("#listaAliados").html("");
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

    function aliado_evento(id_evento){

      //consulta+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
      var c_aliado_evento = "SELECT aliados.*, evento.pkID as id_evento, evento.title as nom_evento, localidades.nombre as loc_nombre "+

      " FROM `aliados` "+

      " inner join evento on evento.fkID_aliado = aliados.pkID"+

      " inner join localidades on localidades.pkID = aliados.localidad_id"+

      " WHERE evento.pkID = '"+id_evento+"' order by localidades.nombre asc";
      //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

      //AJAX................................................................
      $.ajax({
        url: "../Controller/interfaz_ajax.php",
        data: "consulta="+c_aliado_evento+"&tipo=mostrar",
      })
      .done(function(data) {
        
        console.log(data);
        //..................................................................
        //limpia la lista dentro del dom
        $("#listaAliados").html("");
        //crea la lista de los aliados relacionados
        $.each(data.mensaje,function(index, valor) {
          console.log(valor);
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
    };

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

          aliado_evento($("#id_evento_modal").val());

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

      id_aliado_select = $("#fkID_aliado").val();

  		var c_inserta_aliado_evento = "id_evento="+$("#id_evento_modal").val()+"&id_aliado="+id_aliado_select;

  		$.ajax({
  			url: "../Controller/interfaz_ajax.php",
  			data: c_inserta_aliado_evento+"&tipo=inserta_evento_aliado",
  		})
  		.done(function(data) {
  			console.log(data.mensaje);

        aliado_evento($("#id_evento_modal").val());
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

    function valida_action(action){

      if(action==="crear"){
        crea_evento();
      }else if(action==="editar"){
        edita_evento();
      };

    };

  	function crea_evento(){

  		//+++++++++++++++++++++++++++++
  		var inicio = $("#start_modal").val();
  		var fin = $("#end_modal").val();
  		//+++++++++++++++++++++++++++++

  		if(inicio===fin){
  			//console.log("las fechas son iguales");
  			alert("La fecha y/o la hora de inicio y fin del evento son iguales, por favor cambielas.");

  		}else{

            //--------------------------------------
            //crea el objeto formulario serializado
            objt_f_evento = $("#f_evento_modal").valida();
            console.log(objt_f_evento.srlz);
            //--------------------------------------
            /**/

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
              alert("El formulario no está totalmente diligenciado, por favor revíselo e inténtelo de nuevo.");
  					};//cierra tercer if else

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
  	//ejecuta la consulta inicial
  	cons_inicial();
  	//--------------------------------------------

    //Boton que limpia y muestra form para evento nuevo
    $("#btn_crea_e").click(function(){

      

      $("#lbl_form_ingreso").html("Nuevo Registro Evento");
      $("#btn_actionEvento").attr("data-action","crear");
      $("#lbl_btn_actionEvento").html("Guardar Nuevo");      
      
      $("#buscaAliado").val("");

      $("#div_btn_aliado").attr("hidden","true");
      $("#listaAliados").html("");

      $("#f_evento_modal")[0].reset();
              //limpia form
              $("#id_evento_modal").attr("value","");
              $("#titulo_modal").attr("value","");
              $("#start_modal").attr("value","");
              $("#end_modal").attr("value","");
              $("#descripcion_modal").html("");
              $("#direccion_modal").attr("value","");
              $("#estado_modal").val("");
              $("#estado_modal").val("");
              $("#fkID_aliado").val("");

    });

  	//--------------------------------------------
  	//boton de accion
  	$("#btn_actionEvento").click(function(event) {
  		action = $(this).attr("data-action");
      valida_action(action);
      console.log("accion a ejecutar: "+action);
  	});
  	//--------------------------------------------
  	
  	//--------------------------------------------
  	//selector que añade aliados
  	$("#btn_agrega_aliado").click(function() {
  		agrega_aliado();
  	});
    //--------------------------------------------


  	//--------------------------------------------
    //Buscador autocomplete del aliado
    $( "#buscaAliado" ).catcomplete({
      delay: 0,
      source: 'cpc.php',
      select: function(event,ui) {  
        $("#fkID_aliado").val(ui.item.id);
      }
    });
    //--------------------------------------------
});
