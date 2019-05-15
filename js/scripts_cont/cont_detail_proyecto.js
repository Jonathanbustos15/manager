$(function(){
	//console.log('detalle proyecto.');
	//---------------------------------------------------------
	//form_actividad, form_documentos, form_tdocumento, form_personal
	uppercaseForm("form_presupuesto");
	uppercaseForm("form_documentos");
	uppercaseForm("form_tdocumento");
	uppercaseForm("form_personal");	
	//---------------------------------------------------------
	//variable para el objeto del formulario
	var objt_f_presupuesto = {};
	//variable de accion del boton del formulario
	var action = "";
	  //variable para el id del registro
	var id_presupuesto = "";

	var options_format = {
		symbol : "$",
		decimal : ",",
		thousand: ".",
		precision : 0,
		format: "%s%v"
	};
	//--------------------------------------------------------- 
	function valida_action(action){

  		if(action==="crear"){
    		crea_presupuesto();    		
  		}else if(action==="editar"){
    		edita_presupuesto();
  		};
	};
	//---------------------------------------------------------

	//-------------------------------------------------------------------------------------------

	function subida_archivo_presupuesto(){

           //---------------------------------------------------------------------------------------
           //CREA UNA VARIABLE  DE TIPO FormData que toma el formulario
           var formData = new FormData($("#form_presupuesto")[0]);
           //la ruta del php que ejecuta ajax
           var ruta = "../subida_archivo/ctrl_sub_objt.php";

           //hacemos la petición ajax
            $.ajax({
                url: ruta,
                type: 'POST',
                // Form data
                //datos del formulario
                data: formData,
                //necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
                //mientras enviamos el archivo
                beforeSend: function(){
                    console.log("Subiendo archivo, por favor espere...");
                },
                //una vez finalizado correctamente
                success: function(data){
                  console.log(data);
                  //alert(data.estado);
                  //$("#not_img").removeAttr('hidden');
                  //$("#not_img").html(' <br /> <br /> <div class="'+data.clase+'" role="alert">'+data.estado+'</div>');

                },
                //si ha ocurrido un error
                error: function(){
                    console.log("Ha ocurrido un error.");
                }
            });
		//---------------------------------------------------------------------------------------
    };//cierra función subida*/

    function validaArchivoPresupuesto(){

    	var max_file = (1024*1024)*100;    	
    	
    	console.log(max_file);

		//obtenemos un array con los datos del archivo
		var file = $("[name='file']")[0].files[0];
		//obtenemos el nombre del archivo
		var fileName = file.name;
		//obtenemos la extensión del archivo
		var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
		//obtenemos el tamaño del archivo
		var fileSize = file.size;
		//obtenemos el tipo de archivo image/png ejemplo
		var fileType = file.type;
		//mensaje con la información del archivo
		//$("#respuesta").html("<span>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
		if ( (fileSize <= max_file) && ( (fileType == "application/vnd.oasis.opendocument.text") || (fileType == "application/msword") || (fileType == "application/pdf") || (fileType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") || (fileType == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") || (fileType == "application/vnd.ms-excel")) ) {
			$("#nom_archivo").val(fileName);
			console.log("Archivo para subir: "+fileName+", peso total: "+fileSize+" de tipo:"+fileType);
		}else{
			alert("El archivo supera el tamaño permitido de 5MB o no es de tipo permitido.");
			$("[name='nom_archivo']").val("");
			console.log("Archivo para subir: "+fileName+", peso total: "+fileSize+" de tipo:"+fileType);
		};
		
	}

	function crea_presupuesto(){

	      //--------------------------------------
	      //crea el objeto formulario serializado
	      objt_f_presupuesto = $("#form_presupuesto").valida();
	      
	      //console.log(objt_f_adminPublicidad.srlz);
	      //--------------------------------------
	      /**/
	      if( objt_f_presupuesto.estado == true ){

	      	//sube archivo de presupuesto
	      	subida_archivo_presupuesto();	      

	        $.ajax({
	          url: "../controller/ajaxController12.php",
	          data: objt_f_presupuesto.srlz+"&tipo=inserta&nom_tabla=gastos",
	        })
	        .done(function(data) {	          
	          //---------------------
	          console.log(data);
	          
	          //var pkID_presupuesto = data[0].last_id;
	         
	          //insertaArchivo("pkID_hojaVida="+pkID_hojaVida+"&url_archivo="+val[0].name+"&des_archivo="+getValoresDesc(val[0].name);
	                   
	          //$("#btn_actionpresupuesto").attr('enabled','enabled');

	          alert(data[0].mensaje);
	          location.reload();
	          
	        })
	        .fail(function(data) {
	          console.log(data);
	          //alert(data[0].mensaje);          
	        })
	        .always(function() {
	          console.log("complete");
	        });

	      }else{
	        alert("El formulario no está totalmente diligenciado, revíselo e inténtelo de nuevo.");
	      };

	    };
	  //cierra crea

	

	function elimina_presupuesto(id_presupuesto){

	    console.log('Eliminar el presupuesto: '+id_presupuesto);

	    var confirma = confirm("En realidad quiere eliminar este presupuesto?");

	    console.log(confirma);
	    /**/
	    if(confirma == true){
	      //si confirma es true ejecuta ajax
	      $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: "pkID="+id_presupuesto+"&tipo=eliminar&nom_tabla=gastos",
	        })
	        .done(function(data) {            
	            //---------------------
	            console.log(data);

	            alert(data.mensaje.mensaje);
	            
	            location.reload();
	        })
	        .fail(function() {
	            console.log("error");
	        })
	        .always(function() {
	            console.log("complete");
	        });
	    }else{
	      //no hace nada
	    }
    };
    //cierra funcion eliminar presupuesto

	function edita_presupuesto(){

	    //--------------------------------------
	    //crea el objeto formulario serializado
	    objt_f_presupuesto = $("#form_presupuesto").valida();
	 		    
	    //--------------------------------------
	    /**/
	    if( objt_f_presupuesto.estado == true) {

	        console.log(objt_f_presupuesto.srlz);
	        
	        subida_archivo_presupuesto();

	        $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: objt_f_presupuesto.srlz+"&tipo=actualizar&nom_tabla=gastos",
	        })
	        .done(function(data) {	           
	          //---------------------
	          console.log(data);
	          

	          id_presupuesto = $("#pkID").val();	         	        

	          alert(data.mensaje.mensaje);

	          location.reload();
	        })
	        .fail(function() {
	            console.log("error");
	        })
	        .always(function() {
	            console.log("complete");
	        });

	    }else{
	        alert("Faltan "+Object.keys(objt_f_presupuesto.objt).length+" campos por llenar.");
	    }
	    //------------------------------------------------------

    };
    //cierra funcion edita_presupuesto

	function carga_presupuesto(id_presupuesto){

	    console.log("Carga el presupuesto "+id_presupuesto);

	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "pkID="+id_presupuesto+"&tipo=consultar&nom_tabla=gastos",
	    })
	    .done(function(data) {
	    	/**/
	        $.each(data.mensaje[0], function( key, value ) {
	          console.log(key+"--"+value);
	          //$("#"+key).val(value);
	          $("#form_presupuesto")[0][key].value = value;

	          if (key == "valor") {
	          	//$("#total_mask").val(accounting.formatNumber(total_im,options_format));
	          	$("#valor_mask").val(accounting.formatNumber(value,options_format));
	          };

	          if (key == "vc_subtotal") {
	          	//$("#total_mask").val(accounting.formatNumber(total_im,options_format));
	          	$("#vc_subtotal_mask").val(accounting.formatNumber(value,options_format));
	          };

	          if (key == "iva") {
	          	//$("#total_mask").val(accounting.formatNumber(total_im,options_format));
	          	$("#iva_mask").val(accounting.formatNumber(value,options_format));
	          };

	          if (key == "vc_iva") {
	          	//$("#total_mask").val(accounting.formatNumber(total_im,options_format));
	          	$("#vc_iva_mask").val(accounting.formatNumber(value,options_format));
	          };

	          if (key == "total") {
	          	//$("#total_mask").val(accounting.formatNumber(total_im,options_format));
	          	$("#total_mask").val(accounting.formatNumber(value,options_format));
	          };

	          if (key == "vc_total") {
	          	//$("#total_mask").val(accounting.formatNumber(total_im,options_format));
	          	$("#vc_total_mask").val(accounting.formatNumber(value,options_format));
	          };

	        });

	        id_presupuesto = data.mensaje[0].pkID;	       
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });

	};
	//cierra carga_presupuesto

	function totalUtilidad(){

		console.log( $("#total_f") );

		var total_gastos = $("#total_f").val();
		var pres_total = $("#pres_total").val();

		var utilidad = pres_total - total_gastos;

		console.log(utilidad);

		$("#utilidad").val(utilidad);

		//---------------------------------------
		//IVA
		var total_iva = $("#total_iva").val();
		var iva_proyecto = $("#iva_proyecto").val();

		var iva_pagar = total_iva - iva_proyecto;

		$("#iva_pagar").val(iva_pagar);

		//---------------------------------------

		$('#total_f').mask('000.000.000.000.000', {reverse: true});
		$('#total_iva').mask('000.000.000.000.000', {reverse: true});
		$('#total_final').mask('000.000.000.000.000', {reverse: true});
		$('#pres_total').mask('000.000.000.000.000', {reverse: true});
		$('#iva_proyecto').mask('000.000.000.000.000', {reverse: true});
		$('#total_proyecto').mask('000.000.000.000.000', {reverse: true});
		$('#utilidad').mask('000.000.000.000.000', {reverse: true});
		$('#iva_pagar').mask('000.000.000.000.000', {reverse: true});

		if(utilidad > 0){			
			$('#utilidad').css('border-color', 'green');
		}else{
			$('#utilidad').css('border-color', 'red');
		}

		if(iva_pagar > 0){			
			$('#iva_pagar').css('border-color', 'green');
		}else{
			$('#iva_pagar').css('border-color', 'red');
		}
		//
	}

	//-------------------------------------------------------------------------------------------

	//-------------------------------------------------------------------------------
	//ejecución
	//-------------------------------------------------------------------------------
	setTimeout(function(){
		totalUtilidad();
	}, 2000)	

	/*
	$( "#fecha" ).datepicker({
		dateFormat: "yy-mm-dd"			
	});*/

	$('#valor').mask('000000000000000', {reverse: true});	
	
	/*
	Botón que carga el formulario para insertar
	*/
	$("#btn_nuevoPresupuesto").click(function(){

	  	$("#lbl_form_presupuesto").html("Nuevo Gasto");
	  	$("#lbl_btn_actionPresupuesto").html("Guardar <span class='glyphicon glyphicon-save'></span>");
	  	$("#btn_actionPresupuesto").attr("data-action","crear");

	  	$("#btn_actionPresupuesto").removeAttr('disabled');
	     //validaBtnGuardar();

	  	$("#form_presupuesto")[0].reset();	      	   
	});

	/*
	Botón que carga el formulario para editar
	*/  
	$("[name*='edita_presupuesto']").click(function(event) {

		$("#lbl_form_presupuesto").html("Editar Presupuesto");
		$("#lbl_btn_actionPresupuesto").html("Guardar Cambios <span class='glyphicon glyphicon-pencil'></span>");
		$("#btn_actionPresupuesto").attr("data-action","editar");

		$("#form_presupuesto")[0].reset();

		id_presupuesto = $(this).attr('data-id-presupuesto');

		$("#btn_actionPresupuesto").removeAttr('disabled');
		

		carga_presupuesto(id_presupuesto);
		//carga_propiedades(id_presupuesto);
	});

	/*
	Botón que elimina registro
	*/  
	$("[name*='elimina_presupuesto']").click(function(event) {		
		id_presupuesto = $(this).attr('data-id-presupuesto');		
		elimina_presupuesto(id_presupuesto);
	});

	/*
	Botón de accion de formulario
	*/
	$("#btn_actionPresupuesto").click(function(){
		/**/ 
		action = $(this).attr("data-action");
		valida_action(action);
		console.log("accion a ejecutar: "+action);
		//subida_archivo_presupuesto();   
	});

	/*Evento para validar archivo que se va a subir*/
	$("#file").change(function(event) {
		/* Act on the event */
		validaArchivoPresupuesto();
	});

	//--------------------------------------------
	$('#valor_mask').mask('000.000.000.000.000', {reverse: true});
	$('#iva_mask').mask('000.000.000.000.000', {reverse: true});
	$('#total_mask').mask('000.000.000.000.000', {reverse: true});
	//-------------------
	$('#vc_subtotal_mask').mask('000.000.000.000.000', {reverse: true});
	$('#vc_iva_mask').mask('000.000.000.000.000', {reverse: true});
	$('#vc_total_mask').mask('000.000.000.000.000', {reverse: true});
	//-------------------

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

	$('#valor_mask').keyup(function(event) {
		/* Act on the event */
		//console.log($(this).val());
		var val_cuantia = $(this).val();
		//var val_replace = val_cuantia.replace(".", "");
		$('#valor').val(remplazar (val_cuantia, ".", ""))
		//console.log(remplazar (val_cuantia, ".", ""))
	});

	$('#iva_mask').keyup(function(event) {
		/* Act on the event */
		//console.log($(this).val());
		var val_cuantia = $(this).val();
		//var val_replace = val_cuantia.replace(".", "");
		$('#iva').val(remplazar (val_cuantia, ".", ""))
		//console.log(remplazar (val_cuantia, ".", ""))
		var valor_im = parseInt($('#valor').val() );
		var iva_im = parseInt( $('#iva').val() );
		var total_im = valor_im + iva_im;

		$("#total").val(total_im);
		//toca parseralo de alguna forma----------------------
		
		$("#total_mask").val(accounting.formatNumber(total_im,options_format));
	});
	//---------------------------------------------------------------------------------
	//valor contratado

	$('#vc_subtotal_mask').keyup(function(event) {
		/* Act on the event */
		//console.log($(this).val());
		var val_cuantia = $(this).val();
		//var val_replace = val_cuantia.replace(".", "");
		$('#vc_subtotal').val(remplazar (val_cuantia, ".", ""))
		//console.log(remplazar (val_cuantia, ".", ""))
	});

	$('#vc_iva_mask').keyup(function(event) {
		/* Act on the event */
		//console.log($(this).val());
		var val_cuantia = $(this).val();
		//var val_replace = val_cuantia.replace(".", "");
		$('#vc_iva').val(remplazar (val_cuantia, ".", ""))
		//console.log(remplazar (val_cuantia, ".", ""))
		var valor_im = parseInt($('#vc_subtotal').val() );
		var iva_im = parseInt( $('#vc_iva').val() );
		var total_im = valor_im + iva_im;

		$("#vc_total").val(total_im);
		//toca parseralo de alguna forma----------------------
		
		$("#vc_total_mask").val(accounting.formatNumber(total_im,options_format));
	});
	//-----------------------------------------


	//Vista de arbol
	//-----------------------------------------------------------------------------------------------
	//setup complemento / helper_proyecto.js :vistaArbol 
	//consulta a la BD	
	var pkID_proyecto = $("#id_proyecto").val();

	var consulta_docs_proyecto = "select documentos.*, a.nombre_tdoc as nom_tipoDocumento, b.nombre_tdoc as nombre_tsubtipo"+ 

								 " FROM `documentos` "+

							     " INNER JOIN tipo_documento a ON a.pkID = documentos.fkID_tipo"+
	                                
	                             " INNER JOIN tipo_documento b ON b.pkID = CASE"+
	                                	
	                                       " WHEN documentos.fkID_subtipo = 0 THEN 15"+

	                                       " WHEN documentos.fkID_subtipo != 0 THEN documentos.fkID_subtipo"+ 
	                                    
	                                    " END"+

									" where fkID_proyecto = "+pkID_proyecto+

									" ORDER BY nom_tipodocumento,b.orden ASC";				
	
	vistaArbol.consulta = consulta_docs_proyecto;
	//setea los datos de la consulta segun sea
	vistaArbol.names.name_category = "nom_tipoDocumento";
	vistaArbol.names.name_subCategory = "nombre_tsubtipo";
	vistaArbol.names.url = "ruta";
	vistaArbol.names.nombre = "nom_doc";
	//selector de en donde se mostrara
	vistaArbol.names.selector = "tree_objt";

	vistaArbol.getTree();
	//-------------------------------------------------------------------------------------

});