$(function(){
	//console.log('hola hojas');	
	
	//---------------------------------------------------------
	//variable para el objeto del formulario
	var objt_f_formato = {};
	//variable de accion del boton del formulario
	var action = "";
	  //variable para el id del registro
	var id_formato = "";

	var id = ''; 

	//--------------------------------------------------------- 
	function valida_action(action){

  		if(action==="crear"){
    		crea_formato();
    		//subida_foto();
  		}else if(action==="editar"){
    		edita_formato();
  		};
	};
	//---------------------------------------------------------
	//Primeras en mayúscula
	uppercaseForm("form_formato");	
	uppercaseForm("form_categoria");
	//-------------------------------------------------------------------------------------------
   
	function subida_archivo(){

           //---------------------------------------------------------------------------------------
           //CREA UNA VARIABLE  DE TIPO FormData que toma el formulario
           var formData = new FormData($("#form_formato")[0]);
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

	function validaArchivo(){
		//obtenemos un array con los datos del archivo
		var file = $("[name='archivo_sube']")[0].files[0];
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
		$("#url_archivo").val(fileName);
		console.log("Archivo para subir: "+fileName+", peso total: "+fileSize+" de tipo:"+fileType);
	}

    function crea_formato(){

	      //--------------------------------------
	      //crea el objeto formulario serializado
	      objt_f_formato = $("#form_formato").valida();
	      
	      //console.log(objt_f_adminPublicidad.srlz);
	      //--------------------------------------
	      /**/
	      if( objt_f_formato.estado == true ){

	      subida_archivo();	

	        $.ajax({
	          url: "../controller/ajaxController12.php",
	          data: objt_f_formato.srlz+"&tipo=inserta&nom_tabla=formato",
	        })
	        .done(function(data) {	          
	          //---------------------
	          console.log(data);
	          
	          var pkID_formato = data[0].last_id;
	         
	         // insertaArchivo("pkID_hojaVida="+pkID_hojaVida+"&url_archivo="+val[0].name+"&des_archivo="+getValoresDesc(val[0].name);
	                   
	          $("#btn_actionformato").attr('enabled','enabled');

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

	

	function elimina_formato(id_formato){

	    console.log('Eliminar el formato: '+id_formato);

	    var confirma = confirm("En realidad quiere eliminar este formato?");

	    console.log(confirma);
	    /**/
	    if(confirma == true){
	      //si confirma es true ejecuta ajax
	      $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: "pkID="+id_formato+"&tipo=eliminar&nom_tabla=formato",
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
    //cierra funcion eliminar formato

	function edita_formato(){

	    //--------------------------------------
	    //crea el objeto formulario serializado
	    objt_f_formato = $("#form_formato").valida();
	 

	    subida_archivo();
	    //--------------------------------------
	    /**/
	    if( objt_f_formato.estado == true) {

	        console.log(objt_f_formato.srlz);

	        $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: objt_f_formato.srlz+"&tipo=actualizar&nom_tabla=formato",
	        })
	        .done(function(data) {	           
	          //---------------------
	          console.log(data);
	          

	          id_formato = $("#pkID").val();

	         
	          $(".modal-footer").append('<button id="btn_continue" type="button" class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Continuar</button>');

	          $("#btn_continue").click(function(){
	          	location.reload();
	          });
	          
	          //$("#btn_actionformato").attr('disabled','disabled');

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
	        alert("Faltan "+Object.keys(objt_f_formato.objt).length+" campos por llenar.");
	    }
	    //------------------------------------------------------

    };
    //cierra funcion edita_formato

	function carga_formato(id_formato){

	    console.log("Carga el formato "+id_formato);

	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "pkID="+id_formato+"&tipo=consultar&nom_tabla=formato",
	    })
	    .done(function(data) {
	    	/**/
	        $.each(data.mensaje[0], function( key, value ) {
	          console.log(key+"--"+value);
	          //$("#"+key).val(value);
	          $("#form_formato")[0][key]["value"]=value;
	        });

	        id_formato = data.mensaje[0].pkID;

	        //-------------------------------------------
	        //console.log($("#form_formato")[0]["pkID"]["value"])
	        //-------------------------------------------
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });

	};
	//cierra carga_formato

	function validaBtnGuardar(){

		console.log($("[name='archivo[]']")[0].files[0]);

		//var hidden = $("#selectEstudioPos").attr('hidden');

		console.log($('#selectPosgrado').hasAttr('hidden'));

		/**/
		if( ($('#selectPosgrado').hasAttr('hidden') != true) && ($("[name='archivo[]']")[0].files[0] != undefined) ){

			$("#btn_actionformato").removeAttr('disabled');

		}else{
			console.log('falta seleccionar un estudio o cargar archivos!');
			$("#btn_actionformato").attr('disabled','disabled');
		}	

	}

	//-------------------------------------------------------------------------------
	//ejecución
	//------------------------------------------------------------------------------- 
	//validacion numero de identificacion++++++++++++++++++++++++++++++++++++++++++++
	

	
	$("#nidentificacion").change(function(event) {
		/* valida que no tenga menos de 8 caracteres */
		var valores_idCli = $(this).val().length;
		console.log(valores_idCli);
		if(valores_idCli < 8){
			alert("El número de identificación no puede ser menor a 8 valores.");
			$(this).val("");
			$(this).focus();
		}

		validaEqualIdentifica($(this).val());
	});
	
	/*
	Botón que carga el formulario para insertar
	*/
	$("#btn_nuevoformato").click(function(){

	  	$("#lbl_form_formato").html("Nuevo Formato");
	  	$("#lbl_btn_actionformato").html("Guardar <span class='glyphicon glyphicon-save'></span>");
	  	$("#btn_actionformato").attr("data-action","crear");
	  	//$("#btn_actionformato").attr('disabled','disabled');
	     //validaBtnGuardar();

	  	$("#form_formato")[0].reset();
	  	//$("#sub_categoria").removeAttr('hidden');
	  	$("#sub_categoria").attr('hidden', 'true');      	   
	});

	/*
	Botón que carga el formulario para editar
	*/  
	$("[name*='edita_formato']").click(function(event) {

		$("#lbl_form_formato").html("Editar Formato");
		$("#lbl_btn_actionformato").html("Guardar Cambios <span class='glyphicon glyphicon-pencil'></span>");
		$("#btn_actionformato").attr("data-action","editar");

		$("#form_formato")[0].reset();

		id_formato = $(this).attr('data-id-formato');

		$("#btn_actionformato").removeAttr('disabled');
		

		carga_formato(id_formato);
		//carga_propiedades(id_formato);
	});

	/*
	Botón que elimina registro
	*/  
	$("[name*='elimina_formato']").click(function(event) {		
		id_formato = $(this).attr('data-id-formato');		
		elimina_formato(id_formato);
	});

	/*
	Botón de accion de formulario
	*/
	$("#btn_actionformato").click(function(){
		
		action = $(this).attr("data-action");
		valida_action(action);
		console.log("accion a ejecutar: "+action); 
		//subida_archivo();   
	});

	//-------------------------------------------------------------------------------------	

	function verPkIdformato(){

		var id_formato_form = $("#pkID").val();

		//---------------------------------------------------------
		if(id_formato_form != ""){
			return true;
		}else{
			return false;
		}

	}
		

	$('#tbl_formato').on( 'click', '.detail', function () {
	  window.location.href = $(this).attr('href');
	} );

	

	var objt_cond = {
		'fkID_categoria':''
	};

	function crea_consulta(){
		//----------------------------------------------------------
		console.log("construyendo sql")
		console.log(objt_cond)
		
		var arr_cond = [];

		$.each(objt_cond, function(index, val) {
			 
			 console.log('index:'+index+' val:'+val);

			 if (val != '') {
			 	arr_cond.push('formato.'+index+'='+val);
			 };
		});

		console.log(arr_cond)
		//----------------------------------------------------------
		var cons_final = '';

		if (arr_cond.length > 1) {
			cons_final = arr_cond.join(' AND ');
		}else if (arr_cond.length == 0) {
			cons_final = '*';
		} else{
			cons_final = arr_cond.join();
		};

		console.log(cons_final)
		/**/
		location.href="formatos.php?filter="+cons_final;
		//----------------------------------------------------------
	}

	$("#categoria_filtro").change(function(event) {
		
		id = $(this).val();

		if (id == "Todo") {
			objt_cond.fkID_categoria = '';
		} else{
			objt_cond.fkID_categoria = id;
		};		

		console.log(objt_cond)
	});

	$("#btn_filtrar").click(function(event) {		
		crea_consulta();
	});

	//------------------------------------------------------
	//.validaForm(cant. estilo ,mostrar iconos true/false, mostrar barra true/false, que pariente usa dentro de los divs? grandpa,dad);
	//$("#form_formato").validaForm(48,false,false,'dad');
	//------------------------------------------------------

});