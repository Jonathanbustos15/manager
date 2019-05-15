(function ( $ ) {

	//dependencias: jquery.js y valida_p_v1.js
 
    $.fn.jquery_controller = function(nom_modulo,tipo,nom_tabla,upload,tipo_load,reload) {
        
        //this.css( "color", "green" );
        //return this;

        //variables generales------------------------------------------------------------
        var action = '';
        var objt_f = '';
        var id = '';
        var subida = upload;
        var recarga = reload;

        //-------------------------------------------------------------------------------

        //-------------------------------------------------------------------------------
        //Funciones Generales

        function valida_action(action){

	  		if(action==="crear"){
	    		//crea_usuario();
	    		console.log('crear desde la funcion del plugin');
	    		crear();    		
	  		}else if(action==="editar"){
	    		//edita_usuario();
	    		editar();
	  		};
		};

		function crear(){

		      //--------------------------------------
		      //crea el objeto formulario serializado
		      objt_f = $("#form_"+nom_modulo).valida();
		      //email = $("#email").val(); && (validarEmail(email))
		      console.log(objt_f);
		      //console.log(objt_f_adminPublicidad.srlz);
		      //--------------------------------------
		      /**/
		      if( objt_f.estado == true ){

		        $.ajax({
		          url: "../controller/ajaxController12.php",
		          data: objt_f.srlz+"&tipo=inserta&nom_tabla="+nom_tabla,
		        })
		        .done(function(data) {	          
		          //---------------------
		          console.log(data);
		          alert(data[0].mensaje);
		          
		          if (subida == true) {
		          	//si el paramatro upload es true
		          	subida_archivo();
		          	location.reload();
		          }else if (recarga == true) {
		          	location.reload();
		          };
		                    
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

		function editar(){

		    //--------------------------------------
		    //crea el objeto formulario serializado
		    objt_f = $("#form_"+nom_modulo).valida();
		    //email = $("#email").val(); ) && (validarEmail(email)) 
		    //--------------------------------------

		    if( objt_f.estado == true ){

		        console.log(objt_f.srlz);

		        $.ajax({
		            url: '../controller/ajaxController12.php',
		            data: objt_f.srlz+"&tipo=actualizar&nom_tabla="+nom_tabla,
		        })
		        .done(function(data) {	           
		            //---------------------
		            console.log(data.mensaje.mensaje);
		            alert(data.mensaje.mensaje);
		            
		            if (subida == true) {
			          	//si el paramatro upload es true
			          	subida_archivo();
			          	location.reload();
			          }else if (recarga == true) {
			          	location.reload();
			          };
		        })
		        .fail(function() {
		            console.log("error");
		        })
		        .always(function() {
		            console.log("complete");
		        });

		    }else{
		        alert("Faltan "+Object.keys(objt_f.objt).length+" campos por llenar.");
		    }
		    //------------------------------------------------------
		};
	    //cierra editar

		function carga(id,tipo_load){

		    console.log("Carga el id "+id);

		    $.ajax({
		        url: '../controller/ajaxController12.php',
		        data: "pkID="+id+"&tipo=consultar&nom_tabla="+nom_tabla,
		    })
		    .done(function(data) {
		    	/**/
		        $.each(data.mensaje[0], function( key, value ) {
		          console.log(key+"--"+value);
		          //-----------------------------------------------------
		          //Tipo de Carga con el Plugin
		          //1. Carga con solo ids
		          //$("#"+key).val(value);
		          //para cuando los campos del formulario no son iguales
		          //a los de la tabla en la BD.
		          //2. carga dentro del formulario que corresponde el modulo
		          //solo funciona si los campos de la BD son exactamente
		          //iguales a los del formulario.
		          //$("#form_"+nom_modulo)[0][key].value = value;

		          if (tipo_load == 1) {
		          	$("#"+key).val(value);
		          } else if(tipo_load == 2){
		          	$("#form_"+nom_modulo)[0][key].value = value;
		          };

		          //condicional por si tiene mascaras de dinero añadidas
		          if (key == "valor") {
		          	$("#valor_mask").val(value);
		          };
		          //-----------------------------------------------------

		        });		        
		    })
		    .fail(function() {
		        console.log("error");
		    })
		    .always(function() {
		        console.log("complete");
		    });

	    };
	    //cierra carga

	    function eliminar(id){

		    console.log('Eliminar el registro: '+id);

		    var confirma = confirm("En realidad quiere eliminar este registro?");

		    console.log(confirma);
		    /**/
		    if(confirma == true){
		      //si confirma es true ejecuta ajax
		      $.ajax({
		            url: '../controller/ajaxController12.php',
		            data: "pkID="+id+"&tipo=eliminar&nom_tabla="+nom_tabla,
		        })
		        .done(function(data) {            
		            //---------------------
		            console.log(data);

		            alert(data.mensaje.mensaje);
		            
		           	if (recarga == true) {
			         	location.reload();
			         };
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
	    //cierra eliminar
	    

	    function subida_archivo(){

	           //---------------------------------------------------------------------------------------
	           //CREA UNA VARIABLE  DE TIPO FormData que toma el formulario
	           var formData = new FormData($("#form_"+nom_modulo)[0]);
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

        //-------------------------------------------------------------------------------
        //evaluacion de casos en los que actua el boton que se ejecute
        switch(tipo) {
		    
		    //---------------------------------------------------------------------------
		    case 'nuevo':

		        this.click(function(event) {
		        	/* Act on the event */
		        	//console.log('ha dado click por insertar, con parametro:'+nom_modulo);

		        	$("#lbl_form_"+nom_modulo).html("Nuevo Registro "+nom_modulo);
				  	$("#lbl_btn_action"+nom_modulo).html("Guardar<span class='glyphicon glyphicon-chevron-right'></span>");
				  	$("#btn_action"+nom_modulo).attr("data-action","crear");

				  	$("#form_"+nom_modulo)[0].reset();
		        });

		        break;
		    //---------------------------------------------------------------------------

		    //---------------------------------------------------------------------------
		    case 'inserta/edita':

		        this.click(function(event) {
		        	/* Act on the event */
		        	action = $(this).attr("data-action");
		        	console.log(action)
		        	valida_action(action);
		        });

		        break;
		    //---------------------------------------------------------------------------

		    //---------------------------------------------------------------------------
		    case 'carga_editar':

		        this.click(function(event) {
		        	/* Act on the event */
		        	//console.log('ha dado click por carga_editar, con parametro:'+nom_modulo);

		        	$("#lbl_form_"+nom_modulo).html("Editar Registro "+nom_modulo);
				  	$("#lbl_btn_action"+nom_modulo).html("Guardar Cambios<span class='glyphicon glyphicon-chevron-right'></span>");
				  	$("#btn_action"+nom_modulo).attr("data-action","editar");

				  	$("#form_"+nom_modulo)[0].reset();

				  	id = $(this).attr('data-id-'+nom_modulo);

				  	console.log('el id del registro es:'+id);

				  	carga(id,tipo_load);
		        });

		        break;
		    //---------------------------------------------------------------------------

		    //---------------------------------------------------------------------------
		    case 'eliminar':

		        this.click(function(event) {
		        	/* Act on the event */
		        	id = $(this).attr('data-id-'+nom_modulo);
	    			eliminar(id);
		        });

		        break;
		    //---------------------------------------------------------------------------    
		    
		}

		//validando que se este ejecutando el plugin
        console.log('ejecutando jquery_controller con '+this.selector);
        //console.log(this.selector);
        
    };
 
}( jQuery ));