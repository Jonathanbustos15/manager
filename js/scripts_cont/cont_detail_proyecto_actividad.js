$(function(){
	//-----------------------------------------------------------------------
	//
	var options_format = {
		symbol : "$",
		decimal : ",",
		thousand: ".",
		precision : 0,
		format: "%s%v"
	};



	//console.log('hola actividads de ingresos')
	$("#btn_nuevoactividad").jquery_controllerV2({
  		nom_modulo:'actividad',
  		titulo_label:'Nueva actividad'
  	});

  	$("#btn_nuevoactividad").click(function(event) {
  		//cierra modal ingreso_gral
	  	$('#form_modal_presupuesto').modal('hide');

	  	$('#form_modal_actividad').on('hidden.bs.modal', function (e) {		  
		  $('#form_modal_presupuesto').modal('show');
		});

		$("#btn_actionactividad").removeAttr('disabled');	
  	});

  	$("#btn_actionactividad").jquery_controllerV2({
  		tipo:'inserta/edita',
  		nom_modulo:'actividad',
  		nom_tabla:'actividad',
  		recarga:false,
  		//validacion del campo nombre-------------
  		validarCampo:true,
        nom_campo:'nombre',
        ejecutarFunction:true,
        functionResCrear:function(){
            //console.log('El ultimo creado fue: '+ajustes.id_resCrear);
            console.log('Ejecutando luego de Insertar!!!');
            $('#form_modal_actividad').modal('hide');                
        }  		 		  
        //----------------------------------------  		 		  
  	});
	//-----------------------------------------------------------------------

	function carga_actividad(){

		var consulta_actividad = "select * from actividad WHERE fkID_proyecto = "+$("#fkID_proyecto").val()+" order by nombre ";
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_actividad+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	/**/
	    	$("#fkID_actividad").html('')
	        console.log(data)

	        if (data.mensaje != "No hay registros.") {

	        	$("#fkID_actividad").append('<option></option>')

	        	$.each(data.mensaje, function(index, val) {
		        	 /* iterate through array or object */
		        	 console.log(index+"--"+val)
		        	 console.log(val)

		        	 $("#fkID_actividad").append('<option value="'+val.pkID+'">'+val.nombre+'</option>')	        	 
		        });

	        
	        	$("#fkID_actividad").click();

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

	$("#fkID_actividad").focus(function(event) {
		/* Act on the event */
		console.log('cargando datos...')
		carga_actividad()
	});

	//-------------------------------------------------------------------
	//mascaras y sumas actividad	

	//seleccion jquery por formulario

	$("#form_actividad [id='subtotal_mask']").mask('000.000.000.000.000', {reverse: true});	
	$("#form_actividad [id='iva_mask']").mask('000.000.000.000.000', {reverse: true});	
	$("#form_actividad [id='total_mask']").mask('000.000.000.000.000', {reverse: true});

	/**/
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

	$("#form_actividad [id='subtotal_mask']").keyup(function(event) {
		
		//console.log($(this).val());
		var val_cuantia = $(this).val();
		//var val_replace = val_cuantia.replace(".", "");
		$("#form_actividad [id='subtotal']").val(remplazar (val_cuantia, ".", ""))
		//console.log(remplazar (val_cuantia, ".", ""))
	});

	$("#form_actividad [id='iva_mask']").keyup(function(event) {
		
		//console.log($(this).val());
		var val_cuantia = $(this).val();
		//var val_replace = val_cuantia.replace(".", "");
		$("#form_actividad [id='iva']").val(remplazar (val_cuantia, ".", ""))
		//console.log(remplazar (val_cuantia, ".", ""))
		var valor_im = parseInt($("#form_actividad [id='subtotal']").val() );
		var iva_im = parseInt( $("#form_actividad [id='iva']").val() );
		var total_im = valor_im + iva_im;

		$("#form_actividad [id='total']").val(total_im);
		//toca parseralo de alguna forma----------------------
		
		$("#form_actividad [id='total_mask']").val(accounting.formatNumber(total_im,options_format));
	});
	//-------------------------------------------------------------------
	uppercaseForm("form_actividad");	
	//-------------------------------------------------------------------
});