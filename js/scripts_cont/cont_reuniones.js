$(function(){

	$('#btn_nuevoreunion').jquery_controllerV2({
		nom_modulo:'reunion',
		titulo_label:'Nueva Reunión',
		ejecutarFunction: true,
		functionBefore: function(){
			//reinicia el complemento matrixRelation
			rel_reuniones.resetRel();
			
			//-----------------------
			//resetea el div de la agenda
			agenda.resetDivAdd();
			compromiso.resetDivAdd();
		}
	});

	
	$('#btn_actionreunion').jquery_controllerV2({
		tipo:'inserta/edita',
		nom_modulo:'reunion',
		nom_tabla:'reuniones',
		recarga:false,
		ejecutarFunction: true,
		functionResCrear:function(data){
            //console.log('El ultimo creado fue: '+ajustes.id_resCrear);
            console.log('Ejecutando luego de Insertar!!!');
            console.log(data[0].last_id)
            var last_reunion = data[0].last_id;

            //inserta participantes?// el parametro bool es para indicar si recarga o no despues de toda
            //la insercion dentro del array creado.
            rel_reuniones.serializa_array(rel_reuniones.crea_array(rel_reuniones.arrElementos,last_reunion), false);
            //inserta la agenda creada
            agenda.insertAgenda(last_reunion, false);
            compromiso.insertCompromiso(last_reunion, false);
            
        },
        functionResEditar:function(data){
            console.log($("#form_reunion #pkID").val())
            
            agenda.insertAgenda($("#form_reunion #pkID").val(), false);               
            compromiso.insertCompromiso($("#form_reunion #pkID").val(), false);
        }
	});
	
	$('[name*="edita_reunion"]').jquery_controllerV2({
		tipo:'carga_editar',
		nom_modulo:'reunion',
		nom_tabla:'reuniones',
		titulo_label:'Edita Reunión',
		//tipo_load:1,
		ejecutarFunction:true,
		functionResCarga:function(id,data){
			//reinicia el contador de clicks añadir
			compromiso.resetDivAdd();
			//-------------------------------------
			
			console.log(data.mensaje[0].fkID_moderador)

			$("#id_moderador_combo").val($("#fkID_moderador option:selected").text());

			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			//carga elementos
			/**/
			var query = "SELECT  CONCAT(usuarios.nombre,' ',usuarios.apellido) as nombre, usuarios.pkID, participantes.pkID as numReg"+ 

		        " FROM participantes"+	

		        " INNER JOIN usuarios ON participantes.fkID_usuario = usuarios.pkID"+     

		        " INNER JOIN reuniones ON participantes.fkID_reunion = reuniones.pkID"+

		        " WHERE reuniones.pkID = "+data.mensaje[0].pkID;

			rel_reuniones.carga_elementos(query);
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			agenda.loadAgenda(data.mensaje[0].pkID);
			compromiso.loadCompromiso(data.mensaje[0].pkID);
		

		}
	});
	/**/
	$('[name*="elimina_reunion"]').jquery_controllerV2({
		tipo:'eliminar',
		nom_modulo:'reunion',
		nom_tabla:'reuniones'
	});

	//---------------------------------------------------


	$( "#fecha_realizacion" )
	.datepicker({
		dateFormat: "yy-mm-dd",			
	})
	.attr('readonly', 'true');
	


	$("#fkID_moderador").combobox({		
		search: function( event, ui ) {			
			uiAutocompleteOnTop()
		},
		select: function( event, ui ) {
			//console.log("Seleccionó una opción!")
			//console.log(ui.getOption().value)
		},
		change: function(event,ui){
			//console.log(ui.item().option["value"])
		},
		id_input: "id_moderador_combo",
		placeholder: "Por favor seleccione o digite un nombre o apellido."
	});


	$("#tema_filtro").combobox({		
		search: function( event, ui ) {			
			uiAutocompleteOnTop()
		},
		select: function( event, ui ) {
			//console.log("Seleccionó una opción!")
			//console.log(ui.getOption().value)
			$("#tema_filtro").trigger("change");
		},
		change: function(event,ui){
			//console.log(ui.item().option["value"])
		},
		id_input: "id_reunion_combo",
		placeholder: "Por favor seleccione o digite un tema."
	});
	
//-----------------------------------------------------------------------------------
	//intancia matrixRelation
	var obtHE = {
		"fkID_usuario" : 0,
    	"fkID_reunion" : 0    	
    }

    self.rel_reuniones = new matrixRelation("select_participante", "btn_actionreunion", "usuario", "reunion", "frm_usuarios_reuniones", "participantes", obtHE);
	rel_reuniones.setup();
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	//Combobox de seleccion de participantes

	$("#select_participante").combobox({		
		search: function( event, ui ) {			
			uiAutocompleteOnTop()
		},
		select: function( event, ui ) {
			console.log("Seleccionó una opción!")						
			//emite el evento change para accionar el matrixRelation
			$("#select_participante").trigger('change');
		},
		close: function(event,ui){			
			//console.log("Cerro el participantes.")
			$("#id_participante_combo").val("");
		},
		id_input: "id_participante_combo",
		placeholder: "Por favor seleccione o digite un nombre o apellido."
	});
	//-----------------------------------------------------


	



	//-----------------------------------------------------
	//Agenda
	//btn_add_tema frm_temas_agenda
	self.agenda = new temaAgenda($("#btn_add_tema"), $("#div_form_agenda"));
	agenda.setUp();
	//-----------------------------------------------------	
	
	//Compromisos
	self.compromiso = new compromisoReunion($("#btn_add_compromiso"), $("#div_form_compromiso"), $("#btn_actionreunion"));
	compromiso.setUp();


	//----------------------------------------------------------------------
	//---------------------------------------------------------
	
	
	
  	//--------------------------------------------------------------------------------------------
	//click al detalle en cada fila-----------------------------------------------------------------
	$('.table').on( 'click', '.detail', function () {
	  window.location.href = $(this).attr('href');
	} );


	// Seteo de tabs de los detalles
	tabs.nom_tab_default = "li_general";
	tabs.nombre_storage = "id_tab_reunion";
	tabs.arr_no_permit = ["",null,"null"];
	tabs.setTabs()
	//---------------------------------------------------------


	//--------------------------------------------------------------	
	
	//--------------------------------------------------------------
	console.log("detalle_reuniones...")

	$("#btn_actioncompromiso").jquery_controllerV2({
  		tipo:'inserta/edita',
  		nom_modulo:'compromiso',
  		nom_tabla:'compromisos',
  		recarga:false,
  		ejecutarFunction:true,
  		functionBefore: function(ajustes){
  			console.log(ajustes)  			

  			//console.log($("#form_"+ajustes.nom_modulo).valida().estado)

  			if ($("#form_"+ajustes.nom_modulo).valida().estado) {
  				repro.validaAumentoContador()
  			}

  			//throw new Error('This is not an error. This is just to abort javascript');
  		},
  		functionResEditar: function(data){


  			//console.log(data)

  			//console.log(repro.getDataCompromiso())

  			var data_compromiso = repro.getDataCompromiso(),
  				val_estado = $("#fkID_estado").val(),
  				id_moderador = repro.getDataReunion(data_compromiso.fkID_reunion).fkID_moderador;

  			/**/
  			if (val_estado === "2") {  				

				var data_options = "pkID_usuario="+id_moderador+"&tipo_asunto=2&fkID_reunion=0&tipo_cuerpo=cumplido&pkID_compromiso="+data_compromiso.pkID;

				emailCompromiso._send(data_options, true).success(function(data){
					
					console.log(data)
				})

  			}else{
  				location.reload()
  			}	
  			
  			//throw "Parando luego de editar!";
  		} 		 		  
  	});

	$('[name*="edita_compromiso"]').jquery_controllerV2({
		tipo:'carga_editar',
		nom_modulo:'compromiso',
		nom_tabla:'compromisos',
		titulo_label:'Edita Compromiso',
		tipo_load:1,
		ejecutarFunction:true,
		functionResCarga:function(id,data){

			repro.setDataCompromiso(data.mensaje[0]);
		
			var tipo_user = leerCookie("log_lunelAdmin_IDtipo");

			console.log(tipo_user);

			//--------------------------------------------------
			repro.exe()
			//--------------------------------------------------
						
		}
	});

	$('[name*="elimina_compromiso"]').jquery_controllerV2({
		tipo:'eliminar',
		nom_modulo:'compromiso',
		nom_tabla:'compromisos'
	});


	$( "#fecha_cumplimiento" ).datepicker({
		dateFormat: "yy-mm-dd",
		yearRange: "1930:2040",
    	changeYear: true
		//minDate: 0			
	});

	//--------------------------------------------------------------------
	//Define el color de cada registro dependiendo de su estado
	$("#tbl_compromisos tbody tr td").each(function(index, el) {

		var self = $(this);			

		function colorParent(color){				
			self.parent("tr").css("background-color", color);
		}
		
    	switch ($(this).text()) {
    		case 'Asignado y en Curso':
    				colorParent("yellow");
    			break;
    		case 'Cumplido':
    				colorParent("#0AE439");
    			break;
    		case 'Vencido':
    				colorParent("red");
    			break;        		
    	}
	});
	//--------------------------------------------------------------------
	self.repro = new reprogramaCompromiso($("#contador_reprogramacion"), 
										  $("#descripcion_reprogramacion"), 
										  $("#descripcion_repro"), 
										  $("#fecha_cumplimiento"));


	//Compromisos
	self.emailCompromiso = new compromisoReunion($("#btn"), $(".modal-body"), $("#btn_actioncompromiso"));
	

	
	//---------------------------------------------------------
  	self.novedades = new follow("novedades","btn_nuevonovedad","frm_modal_compromiso","frm_novedad","compromisos","btn_actionnovedad");

	$("#btn_nuevonovedad").jquery_controllerV2({
      nom_modulo:'novedad',
      titulo_label:'Nueva Observación'
    });

    $("#btn_nuevonovedad").click(function(){
		console.log("Boton novedad")
        novedades.newFollow()
        novedades.updateFollow() 
	});

	//---------------------------------------------------------

    function fixComboboxUI(){
    	//reorganiza el imput del filtro
    	$("#id_reunion_combo").css('width', '48%');
    	//Se arreglan las clases del boton del combo de afuera
    	//identificandolo por clase
	    $.each($(".custom-combobox-toggle"), function(index, val) {
	    	
	    	console.log($(val).parent().parent()[0]["className"])

	    	if ($(val).parent().parent()[0]["className"] === "col-md-12 text-left form-inline") {
	    		$(val).addClass('custom-combobox-toggle-out')
	    	}
	    });
    }
    
    fixComboboxUI()
    //---------------------------------------------------------

    //---------------------------------------------------------
    /*Se configura modal principal*/
    $("#frm_modal_reunion").modal({
    	backdrop: 'static',
    	show: false
    })
    //---------------------------------------------------------
})