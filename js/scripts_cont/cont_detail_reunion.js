$(function(){

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
	// Seteo de tabs de los detalles
	tabs.nom_tab_default = "li_general";
	tabs.nombre_storage = "id_tab_detail_reunion";
	tabs.arr_no_permit = ["",null,"null"];
	tabs.setTabs()
	//---------------------------------------------------------

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


    //sessionStorage.setItem("id_tab_reunion",null);


});