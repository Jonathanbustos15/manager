$(function(){
	//console.log('hola gastos')

	//-------------------------------------------------
	//form_externo
	uppercaseForm("form_gasto_gral");
	uppercaseForm("form_empresa");
	uppercaseForm2("form_externo");
	//-------------------------------------------------

	var id_gasto = '';

	$("#btn_nuevogasto_gral").jquery_controllerV2({
  		nom_modulo:'gasto_gral',
  		titulo_label:'Nuevo Gasto',
  		
  	});

  	$("#btn_nuevogasto_gral").click(function(event) {
  		/* Act on the event*/

  		$("#gastos_hide").attr('hidden','true');
  		switchCampos("enable_all")  		
  	});

	$("#btn_actiongasto_gral").jquery_controllerV2({
  		tipo:'inserta/edita',
  		nom_modulo:'gasto_gral',
  		nom_tabla:'gasto_gral',
  		recarga:false,
  		ejecutarFunction:true,
  		functionBefore:function(ajustes){
        novedades.newOwner(ajustes.action);
       		actualizarPago();
            console.log('Llama a funcion actualizarPago');
      	},
  		
  		functionResEditar:function(ajustes){            

            if (objtLogGasto.fkID_gasto != '') {
            	logGasto();
            };

            if (objtLogGastoPago.fkID_gasto != '') {
            	logGastoPago();
            };

            location.reload();
        },
        functionResCrear:function(){
            //console.log('El ultimo creado fue: '+ajustes.id_resCrear);
            console.log('Ejecutando luego de Insertar!!!');
            location.reload(); 
            var accion = $("#btn_actiongasto_gral").attr("data-action")                
        }  		 		  
  	});

  	$("[name*='edita_gasto_gral']").jquery_controllerV2({
		tipo:'carga_editar',
  		nom_modulo:'gasto_gral',
  		nom_tabla:'gasto_gral',
  		titulo_label:'Edita gasto',
  		tipo_load:1,
  		ejecutarFunction:true,
  		functionResCarga:function(id,data){
            //console.log('El eliminar registro: '+ajustes.id_resCrear);
            console.log('Ejecutando luego de Cargar!!!');

            pago_diferencia();
            //----------------------------------------------------------
            novedades.hideParent(false);

            var tipo_user = leerCookie("log_lunelAdmin_tipo");

            console.log(tipo_user);

            
            

            
            /*Validación para que solo apruebe un gasto el administrador*/

            var pagado = $("#pagado").val();
            var aprobado = $("#aprobado").val();
            console.log(aprobado);

            
            if ( (aprobado == 0) && (pagado == 0) ){
            	if (tipo_user == "Administrador") {

            		$("#aprobado").removeAttr('disabled');

            		//switchCampos("enable_a");
            	} else{
            		//$("#aprobado").attr('disabled', 'true');
            		switchCampos("enable_v");
            	}	
            }else if ( (aprobado == 1) && (pagado == 0) ){
            	switchCampos("disable_a")
            }else if ( (pagado == 1) ){
            	switchCampos("disable_all")
            };

            /*-----------------------------------------*/            
            console.log('El fkID_externo es :'+$("#fkID_externo").val())
            nomBeneficiario($("#fkID_externo").val())

            //----------------------------------------------------------              
			carga_Actividad(data.mensaje[0].fkID_proyecto,data.mensaje[0].fkID_actividad);
			//----------------------------------------------------------

			/*

            if (tipo_user == "Administrador") {

            	$("#aprobado").removeAttr('disabled');
            } else{
            	$("#aprobado").attr('disabled', 'true');
            };
			*/
        },
        functionResEditar:function(data){
                
          console.log('Ejecutando luego de Editar!!!');  
          console.log(data);

          id_gasto = data.mensaje[0].pkID              
        }

	});



	
	function switchCampos(atributo){

    	//console.log($("#form_gasto_gral"))

    	$.each($("#form_gasto_gral")[0], function(index, val) {    	    	

    		var id_campo = val["id"];    		

        	switch(atributo) {
			    case "enable_all":
			    		$("#"+id_campo).removeAttr('disabled');
			        	//-----------------------------
			        break;
			   	 case "disable_all":
			    	if ((id_campo != "observaciones") && (id_campo != "pkID") && (id_campo != "btn_nuevoobservacion")) {

			    		$("#"+id_campo).attr('disabled', 'true');
			    	}
			        	//-----------------------------
			        break;
			    case "enable_a":
			    		if ( (id_campo != "pagado") && (id_campo != "fecha_pago") && (id_campo != "pago_mask") ) {
		        			//console.log(" Enable "+id_campo)
		        			$("#"+id_campo).removeAttr('disabled');
		        		}else{
		        			//console.log(id_campo)
		        			$("#"+id_campo).attr('disabled', 'true');
		        		};
			        	//-----------------------------
			        break;
			    case "enable_v":
			    		if ( (id_campo != "aprobado") && (id_campo != "pagado") && (id_campo != "fecha_pago") ) {
		        			//console.log(" Enable "+id_campo)
		        			$("#"+id_campo).removeAttr('disabled');
		        		}else{
		        			//console.log(id_campo)
		        			$("#"+id_campo).attr('disabled', 'true');
		        		};
			        	//-----------------------------
			        break;    
			    case "disable_a":
			    		if ( (id_campo != "pagado") && (id_campo != "fecha_pago") && (id_campo != "observaciones") && (id_campo != "btn_nuevoobservacion") && (id_campo != "pago_mask")) {
		        			//console.log(" Disable "+id_campo)
		        			if ( (id_campo != "pkID") && (id_campo != "fecha_aprobacion") ) {
		        				$("#"+id_campo).attr('disabled', 'true');
		        			}		        			

		        		}else{
		        			//console.log(id_campo)
		        			$("#"+id_campo).removeAttr('disabled');
		        		};
			        	//-----------------------------
			        break;			
			}

    	});
    }

	function nomBeneficiario(id){

		//nom_tabla=log_rt
		var nomBeneficiario = "select * from externo WHERE pkID="+id;

		$.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+nomBeneficiario+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	/*muestra data actual*/
	        console.log(data);
	        $("#beneficiario").val(data.mensaje[0].nombre);	        			      
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/		
	}

	$("[name*='edita_gasto_gral']").click(function(event) {
  		/* Act on the event http://loudwire.com/20-best-metal-songs-2015/*/
  		$("#gastos_hide").removeAttr('hidden');
  	});

  	$("[name*='elimina_gasto_gral']").jquery_controllerV2({
  		tipo:'eliminar',
  		nom_modulo:'gasto_gral',
  		nom_tabla:'gasto_gral'
  	});

  	//------------------------------------------------------------------------------------------------
  	//Función para cargar actividad

  	function carga_Actividad(pkID_proyecto,fkID_actividad){

		var consulta_actividad = "SELECT * FROM `actividad` WHERE fkID_proyecto = "+pkID_proyecto;
		//---------------------------------------------------------------
	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_actividad+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	
	    	
	        console.log(data)
	        /**/

	        $("#fkID_actividad").html('');

	        if (data.mensaje != "No hay registros.") {

	        	$("#fkID_actividad").append('<option></option>')

	        	$.each(data.mensaje, function(index, val) {
		        	 
		        	 console.log(index+"--"+val)
		        	 console.log(val)

		        	 $("#fkID_actividad").append('<option value="'+val.pkID+'">'+val.nombre+'</option>')	        	 
		        });

	        
	        	$("#fkID_actividad").click();
	        	$("#fkID_actividad").val(fkID_actividad);

	        };	        
	    })
	    .fail(function() {
	        console.log("error");
	        $("#fkID_actividad").html('');
	    })
	    .always(function() {
	        console.log("complete");
	    });
	    //---------------------------------------------------------------
	}

	//------------------------------------------------------------------------------------------------
	//funciones de change de los selects aprobado y pagado

	//objeto de log
	console.log(date);
	
	//------------------------------------------------
	//leer cookies con js document.cookie	

	var objtLogGasto = {
		fkID_gasto:'',
		fecha:date,
		usuario:leerCookie('log_lunelAdmin_id'),
		accion:'',
		ip:$("#ip_server").val()
	}

	var objtLogGastoPago = {
		fkID_gasto:'',
		fecha:date,
		usuario:leerCookie('log_lunelAdmin_id'),
		accion:'',
		ip:$("#ip_server").val()
	}

	function logGasto(){

		var log_srlz = $.param( objtLogGasto );	

		console.log(log_srlz)
		
		$.ajax({
            url: '../controller/ajaxController12.php',
            data: log_srlz+"&tipo=inserta&nom_tabla=log_rt",
        })
        .done(function(data) {	           
          //---------------------
          console.log(data);
          console.log('Ingreso a logGasto');  
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
	}

	function aprobarGasto(id,valor){

		
		//nom_tabla=log_rt
		var aprueba_paso = "UPDATE gasto_gral SET aprobado="+valor+", fecha_aprobacion = now()  WHERE pkID="+id;

		$.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+aprueba_paso+"&tipo=consulta_gen&nom_tabla=log_rt",
	    })
	    .done(function(data) {
	    	/*muestra data actual*/
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

	function logGastoPago(){

		var log_srlz = $.param( objtLogGastoPago );	

		console.log(log_srlz)
		
		/**/
		$.ajax({
            url: '../controller/ajaxController12.php',
            data: log_srlz+"&tipo=inserta&nom_tabla=log_rt",
        })
        .done(function(data) {	           
          //---------------------
          console.log(data);                    	         	     
          console.log('Ingreso a logGastoPago');  
          //alert(data.mensaje.mensaje);

          //location.reload();
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
	}

	$("#aprobado").change(function(event) {
		/* Act on the event */
		id_gasto = $("#pkID").val();
		//updateGasto(id_gasto,'aprobado');
		objtLogGasto.fkID_gasto = id_gasto;

		var fullDate = new Date()
		console.log(fullDate);
		//Thu May 19 2011 17:25:38 GMT+1000 {}
 
		//convierte el mes a 2 digitos
		var mes = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
 
		var currentDate = fullDate.getFullYear() + "-" + mes + "-" + fullDate.getDate();
		console.log(currentDate);
		//0000-00-00
			
		if ($(this).val()=='1') {
			objtLogGasto.accion = 'aprobado';
			$("#fecha_aprobacion").val(currentDate); //Asigna la fecha actual al selector fecha_aprobacion


		}else{
			objtLogGasto.accion = 'desaprobado';			
		};		
		
		console.log(objtLogGasto)
		//se ejecuta solo al editar el registro
		//logGasto();
	});

	$("#pagado").change(function(event) {
		/* Act on the event */
		/* Act on the event */
		id_gasto = $("#pkID").val();
		//updateGasto(id_gasto,'aprobado');
		objtLogGastoPago.fkID_gasto = id_gasto;

		if ($(this).val()=='1') {
			objtLogGastoPago.accion = 'Pagado';
		}else{
			objtLogGastoPago.accion = 'Anulado de Pago';
		};

		console.log(objtLogGastoPago)

		$("#fecha_pago").attr('required', 'true');
		$("#fecha_pago").val('');
		//se ejecuta solo al editar el registro
		//logGasto();
	});
	//------------------------------------------------------------------------------------------------
	//aprobar_gasto_gral

	$("[name*='aprobar_gasto_gral']").click(function(event) {
		/* Act on the event */

		var confirmaAprobacion = confirm("Realmente desea aprobar este gasto?");

		if (confirmaAprobacion == true) {

			console.log('aprobando registro ...'+$(this).data('id-gasto_gral'));

			/* Act on the event */
			id_gasto = $(this).data('id-gasto_gral');
			//updateGasto(id_gasto,'aprobado');
			objtLogGasto.fkID_gasto = id_gasto;

			objtLogGasto.accion = 'aprobado';
			
			console.log(objtLogGastoPago)
			//se ejecuta solo al editar el registro

			aprobarGasto(id_gasto,1);

			logGasto();

			alert("Gasto actualizado correctamente.");

			location.reload();

		};
		
	});
	//------------------------------------------------------------------------------------------------

	$( "#fecha_pago_limite" ).datepicker({
		dateFormat: "yy-mm-dd",
		yearRange: "1930:2040",
    	changeYear: true
		//minDate: 0			
	});

	$( "#fecha_pago" ).datepicker({
		dateFormat: "yy-mm-dd",
		yearRange: "1930:2040",
    	changeYear: true
		//minDate: 0			
	});

	$("#fecha_pago_limite").change(function(event){
		var fe_pafo = $("#fecha_pago_limite").val();
		var aux = fe_pafo.substring(0, 4);
		$("#anio").val(aux);
		console.log($("#anio").val());

	});

	$('#pago_mask').mask('000.000.000.000.000', {reverse: true});
	$('#valor_mask').mask('000.000.000.000.000', {reverse: true});
	$('#diferencia_mask').mask('000.000.000.000.000', {reverse: true});

	/*
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
	}*/
	

	$('#valor_mask').keyup(function(event) {		
		var val_cuantia = $(this).val();		
		$('#valor').val(remplazar (val_cuantia, ".", ""))		
	});

	$('#pago_mask').click(function(event) {		
		if($('#pago_mask').val() == 0){
			$('#pago_mask').val('');
		}
	});

	$('#pago_mask').keyup(function(event) {		
		var pago_cuantia = $(this).val();
		var val_cuantia = $('#valor').val();

		$('#pago').val(remplazar (pago_cuantia, ".", ""));

		var pago = $('#pago').val();

		var diferencia = parseInt(val_cuantia) - parseInt(pago);

		//Pasa el numero para formato con puntos--------------------
		/*decimals = 0;
		amount = diferencia;

    	amount += ''; // por si pasan un numero en vez de un string
    	amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    	decimals = decimals || 0; // por si la variable no fue fue pasada

    	// si no es un numero o es igual a cero retorno el mismo cero
   	 	if (isNaN(amount) || amount === 0) 
        	return parseFloat(0).toFixed(decimals);

    	// si es mayor o menor que cero retorno el valor formateado como numero
    	amount = '' + amount.toFixed(decimals);

    	var amount_parts = amount.split('.'),
        	regexp = /(\d+)(\d{3})/;

    	while (regexp.test(amount_parts[0]))
        	amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');

    	valor = amount_parts.join('.');

    	//Pasa el numero para formato con puntos--------------------*/
		valor = (new Intl.NumberFormat().format(diferencia));

		console.log('Pago es = '+pago);
		console.log('Valor es = '+val_cuantia);
		console.log('Diferencia es = '+valor);

		$('#diferencia_mask').val(valor) ;
		$('#diferencia').val(diferencia);
	});

// suma

	$.fn.dataTable.Api.register( 'column().data().sum()', function () {
    return this.reduce( function (a, b) {
        var x = parseFloat( a ) || 0;
        var y = parseFloat( b ) || 0;
        return x + y;
    	} );
	} );
 

	$('#buscador').keyup(function() {
	   
	   ////console.log(table.column(3, {page:'current'}).data().sum())

	   //console.log('La suma es ..**************.' + table.column(2).data().sum());
	   //console.log('La suma filtrada es  es ..**************.' + table.column(4, {page:'current'}).data().sum());

	   //sumatoria de los valores ocultos en la pagina reciente,columna Ficti
	   var sumado=table.column(3, {page:'current'}).data().sum();

	  	sumado=accounting.formatNumber(sumado);
	  	//sumado=accounting.formatMoney(sumado);
	  	// sumado = $.parseNumber(sumado, {format:"#,###.00", locale:"us"});
	    $("#total_gastos").val(sumado);
	});

	//------------------------------------------------------------------------------------------------

	 //---------------------------------------------------------
  	self.novedades = new follow("observaciones","btn_nuevoobservacion","form_modal_gasto_gral","frm_observacion","gasto_gral","btn_actionobservacion");
  
  /**/
  	$("#btn_nuevoobservacion").jquery_controllerV2({
      nom_modulo:'observacion',
      titulo_label:'Nueva Observación',
      ejecutarFunction:true,
      functionBefore:function(ajustes){                
      	novedades.newFollow()
        novedades.updateFollow()             
      }
    });

  	function pago_diferencia(){
  		//Toma el valor del pago
  		pago = $("#pago").val();
  		//Le da formato de valor
  		pago = (new Intl.NumberFormat().format(pago));
  		//Muestra en campo el valor formateado
  		$("#pago_mask").val(pago);

  		//Toma el valor de la diferencia
  		diferencia = $("#diferencia").val();
  		//Le da formato de valor
  		diferencia = (new Intl.NumberFormat().format(diferencia));
  		//Muestra en campo el valor formateado
  		$("#diferencia_mask").val(diferencia);
  	}

  	function actualizarPago(){
		//Actualiza campo pago y diferencia
		console.log('Ingreso a actualizarPago');
		var pago = $("#pago").val();
		var diferencia = $("#diferencia").val();
		var pkID = $("#pkID").val();

		console.log('Pago = '+pago);
		console.log('Diferencia = '+diferencia);

		cadena = 'pkID='+pkID+'&pago='+pago+'&diferencia='+diferencia;

		$.ajax({
            url: '../controller/ajaxController12.php',
            data: cadena+"&tipo=actualizar&nom_tabla=gasto_gral",
        })
        .done(function(data) {	           
          //---------------------
          console.log(data);  
        })
        .fail(function() {
            console.log("error");
            console.log(data); 
        })
        .always(function() {
            console.log("complete");
        });
  	}
});
