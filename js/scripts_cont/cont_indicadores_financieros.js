$(function(){

	console.log("Hola indicadores financieros.")

  //Valida que action tiene el boton
  function valida_action(action){

      if(action==="crear"){
        //crea_documento();
        subida_archivo("crear");

      }else if(action==="editar"){
        //edita_documento();
        subida_archivo("editar");
      };
  };

    //Envia peticion AJAX para subir archivo
    function subida_archivo(nom_funcion){

           //---------------------------------------------------------------------------------------
           //CREA UNA VARIABLE  DE TIPO FormData que toma el formulario
           var formData = new FormData($("#form_info_financiera")[0]);
           //la ruta del php que ejecuta ajax
           var ruta = "../subida_archivo/url.php";

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
                    $("#not_info_financiera").html("Subiendo archivo, por favor espere...");
                },
                //una vez finalizado correctamente
                success: function(data){
                  console.log(data);

                    $("#not_info_financiera").html('Subido el archivo...');

                },
                //si ha ocurrido un error
                error: function(){
                    console.log("Ha ocurrido un error.");
                }
            });
    //---------------------------------------------------------------------------------------
    };//cierra función subida*/

    //Valida archivo
    function validaArchivo(){
     
      var max_file = (1024*1024)*500;     
      
      console.log(max_file);

    //obtenemos un array con los datos del archivo
    var file = $("#form_info_financiera [id='archivo']")[0].files[0];
    console.log(file)
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
    //application/x-rar
    if ( (fileSize <= max_file) && ( (fileType == "application/vnd.oasis.opendocument.text") || (fileType == "application/msword") || (fileType == "application/pdf") || (fileType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") || (fileType == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") || (fileType == "application/vnd.ms-excel") || (fileType == "application/x-rar") || (fileType == "") ) ) {
      //Reemplaza los caracteres especiales por "_"
      fileName = fileName.replace(/ |%|-/g, "_");
      //Toma el id del indicador financiero
      id = $("#form_info_financiera [id='pkID']").val();
      //Concatena el nomnbre de archivo con el ID
      fileName = id+'_'+fileName;   
      //Asigna al campo ruta el nombre completo a subir
      $(("#form_info_financiera [id='ruta']")).val(fileName);
      console.log("Archivo para subir: "+fileName+", peso total: "+fileSize+" de tipo:"+fileType);
      $("#not_info_financiera").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
                                'Archivo para subir: '+fileName+', peso total: '+fileSize+' de tipo:'+fileType);
    }else{
      alert("El archivo supera el tamaño límite o no es de un tipo permitido.");
      $("#form_info_financiera [id='archivo']").val("");
      console.log("Archivo para subir: "+fileName+", peso total: "+fileSize+" de tipo:"+fileType);
      $("#not_info_financiera").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
                                'El archivo supera el tamaño límite o no es de un tipo permitido. Archivo para subir: '+fileName+', peso total: '+fileSize+' de tipo:'+fileType);
    };
    
  }

	var options_format = {
		symbol : "$",
		decimal : ",",
		thousand: ".",
		precision : 0,
		format: "%s%v"
	};

	$("#btn_nuevoinfo_financiera").jquery_controllerV2({
  		nom_modulo:'info_financiera',
  		titulo_label:'Nueva Información Financiera',
  		ejecutarFunction:true,
  		functionBefore:function(ajustes){            

  			$("#btn_actioninfo_financiera").removeAttr('disabled');
        }
  	});

  	$("#btn_actioninfo_financiera").jquery_controllerV2({
  		tipo:'inserta/edita',
  		nom_modulo:'info_financiera',
  		nom_tabla:'info_financiera',
  		subida : false,
  		//recarga:false,
  		ejecutarFunction:true,
  		functionResEditar:function(){
  			//console.log(data)  			          
        },
        functionResCrear:function(data){
            //console.log('El ultimo creado fue: '+ajustes.id_resCrear);
            console.log(data);
            console.log('Ejecutando luego de Insertar!!!');
            //location.reload();
        },
        functionBefore:function(ajustes){
        	console.log('Ejecutando antes de hacer cualquier cosa');        	
        }  		 		  
  	});  

    $("#btn_actioninfo_financiera").click(function(){
      action = $(this).attr("data-action");
      valida_action(action);
      console.log("accion a ejecutar: "+action);        
    });  

	//---------------------------------------------------------------

	//---------------------------------------------------------------
	$("[name*='edita_info_financiera']").jquery_controllerV2({
		tipo:'carga_editar',
  		nom_modulo:'info_financiera',
  		nom_tabla:'info_financiera',
  		titulo_label:'Edita Información Financiera',
  		tipo_load:2,
  		ejecutarFunction:true,
  		functionBefore:function(ajustes){                
            console.log('Ejecutando antes de cualquier cosa!!!');
            $("#btn_actioninfo_financiera").removeAttr('disabled');                
        },
  		functionResCarga:function(id,data){
            //console.log('El eliminar registro: '+ajustes.id_resCrear);
            console.log('Ejecutando luego de Cargar!!!');
            
            $.each(data.mensaje[0], function( key, value ) {	          	        	            
	          
	          if ( (key == "capital_trabajo") || (key == "patrimonio") ) {
	          	//$("#"+key).val(value);
	          	$("#"+key+"_mask").val(accounting.formatNumber(value,options_format));
	          };	          	               	        

	        });	        
        }
	});

	$("[name*='elimina_info_financiera']").jquery_controllerV2({
  		tipo:'eliminar',
  		nom_modulo:'info_financiera',
  		nom_tabla:'info_financiera'
  	});
  	//-------------------------------------------------------------
  	$('#capital_trabajo_mask').mask('000.000.000.000.000', {reverse: true});	

	$('#capital_trabajo_mask').change(function(event) {		
		var val_capital = $(this).val();		
		$('#capital_trabajo').val(remplazar(val_capital, ".", ""))		
	});

	$('#patrimonio_mask').mask('000.000.000.000.000', {reverse: true});	

	$('#patrimonio_mask').change(function(event) {		
		var val_patrimonio = $(this).val();		
		$('#patrimonio').val(remplazar(val_patrimonio, ".", ""))		
	});
	//---------------------------------------------------------------
	$( "#anio" ).datepicker({
      changeYear: true,
      showButtonPanel: true,
      dateFormat: 'yy',
      maxDate: '-1Y',
      onClose: function(dateText, inst) { 
          var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
          $(this).datepicker('setDate', new Date(year, 1));
      }
  });
  
  $("#anio").focus(function () {
      $(".ui-datepicker-month").hide();
      $(".ui-datepicker-calendar").hide();
  });

  //valida el documento -------------------
  $("#form_info_financiera [id='archivo']").change(function(event) {
    /* Act on the event */
    validaArchivo();
  });
  //---------------------------------------
});