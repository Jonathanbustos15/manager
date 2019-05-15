(function ( $ ) {
 
    $.fn.jquery_controllerV2 = function( opciones ) {
    
        /*
        // This is the easiest way to have default options.
        var settings = $.extend({
            // These are the defaults.
            color: "#556b2f",
            backgroundColor: "white"
        }, options );
 
        // Greenify the collection based on the settings variable.
        return this.css({
            color: settings.color,
            backgroundColor: settings.backgroundColor
        });*/

        var ajustes = $.extend({
            // These are the defaults.
            tipo:'nuevo', //tipo de instancia
            action:'insertar', //accion a realizar el botón
            tipo_load:1,
            objt_f:'', //objeto del formulario
            id : '', //id del registro de BD
            subida : false, //si sube o no archivos
            recarga : true, //si recarga o no la pagina despues de cada accion
            //------------------------
            //ajustes del form/modulo
            nom_modulo:'', //el nombre del modulo usado
            titulo_label:'', //titulo de la ventana del modal
            nom_tabla:'', //nombre de la tabla en la BD
            //-----------------------------------------------------------------
            //Datos resultado funcion crear
            id_resCrear:'', //resultado de la insercion del registro(last_id)
            functionResCrear:function(){
                console.log('El ultimo creado fue: '+ajustes.id_resCrear);
                console.log('Ejecutando luego de Insertar!!!');                
            },
            //-----------------------------------------------------------------            
            functionResEliminar:function(){
                //console.log('El eliminar registro: '+ajustes.id_resCrear);
                console.log('Ejecutando luego de Eliminar!!!');                
            },
            //-----------------------------------------------------------------
            functionResCarga:function(id,data){
                //console.log('El eliminar registro: '+ajustes.id_resCrear);
                console.log('Ejecutando luego de Cargar!!!');                
            },
            functionResEditar:function(){
                console.log('Se editó registro: '+ajustes.id_resCrear);
                console.log('Ejecutando luego de Editar!!!');                
            },
            //-----------------------------------------------------------------
            //variable que dice si hay que ejecutar una funcion
            //esto depende del tipo
            ejecutarFunction:false,
            //validacion de campo individual-----------------------------------
            validarCampo:false,           
            nom_campo:''
        }, opciones );
        
        var options_format = {
          symbol : "$",
          decimal : ",",
          thousand: ".",
          precision : 0,
          format: "%s%v"
        };
        //------------------------------------------------------------------------------------------------------------------------
        //funcion de validacion
        function valida_action(action){

            if(ajustes.action==="crear"){
                //crea_usuario();
                //console.log('crear desde la funcion del plugin');
                if(ajustes.validarCampo == true){
                  //crear();
                  validaCampo();

                }else{
                  crear();
                };

            }else if(ajustes.action==="editar"){
                //edita_usuario();
                editar();
            };
        };

        function crear(){

              //--------------------------------------
              //crea el objeto formulario serializado
              ajustes.objt_f = $("#form_"+ajustes.nom_modulo).valida();
              //email = $("#email").val(); && (validarEmail(email))
              console.log(ajustes.objt_f);
              //console.log(objt_f_adminPublicidad.srlz);
              //--------------------------------------
              /**/
              if( ajustes.objt_f.estado == true ){

                $.ajax({
                  url: "../controller/ajaxController12.php",
                  data: ajustes.objt_f.srlz+"&tipo=inserta&nom_tabla="+ajustes.nom_tabla,
                })
                .done(function(data) {            
                  //---------------------
                  console.log(data);
                  alert(data[0].mensaje);
                  
                  //valida si sube archivos
                  if (ajustes.subida == true) {
                    //si el paramatro upload es true
                    subida_archivo();
                    //----------------
                    //location.reload();
                    //----------------                    
                  };

                  if ((ajustes.subida == false) && (ajustes.recarga == true)) {
                    
                    //location.reload();

                    setTimeout(function(){
                      location.reload();
                    }, 2000)
                    
                  };                  

                  //valida si debe ejecutar otra funcion dentro--------------------------------
                  //usando el ultimo id de registro
                  if (ajustes.ejecutarFunction == true) {
                    //asigna el last_id en id_resCrear
                    ajustes.id_resCrear = data[0].last_id;
                    //console.log(data[0].last_id)
                    ajustes.functionResCrear();
                  };
                  //---------------------------------------------------------------------------

                  //---------------------------------------------------------------------------
                  
                  //---------------------------------------------------------------------------
                            
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

        function validaCampo(){
          //SELECT nombre FROM `estudio` where nombre LIKE 'Ingeniería de Sistemas'
          
          var val_campo = $("#form_"+ajustes.nom_modulo)[0][ajustes.nom_campo]["value"];
          //console.log(val_campo)
          var cons_validaCampo = 'select '+ajustes.nom_campo+' from '+ajustes.nom_tabla+' where '+ajustes.nom_campo+' LIKE "'+val_campo+'" ';
          console.log(cons_validaCampo)
          
          /**/
          $.ajax({
              url: '../controller/ajaxController12.php',
              data: "query="+cons_validaCampo+"&tipo=consulta_gen",
          })
          .done(function(data) {
            
            console.log(data)            

            //console.log(valResConsulta)

            if (data.estado == "Error") {
                crear();
            } else{
              alert("El campo "+ajustes.nom_campo+" que ha ingresado ya existe y no se puede duplicar. Por favor ingrese un valor diferente.");
            };

          })
          .fail(function() {
              console.log("error");
          })
          .always(function() {
              console.log("complete");
          });
          //---------------------------------------------------------------          
        }

        function editar(){

            //--------------------------------------
            //crea el objeto formulario serializado
            ajustes.objt_f = $("#form_"+ajustes.nom_modulo).valida();
            //email = $("#email").val(); ) && (validarEmail(email)) 
            //--------------------------------------

            if( ajustes.objt_f.estado == true ){

                console.log(ajustes.objt_f.srlz);

                $.ajax({
                    url: '../controller/ajaxController12.php',
                    data: ajustes.objt_f.srlz+"&tipo=actualizar&nom_tabla="+ajustes.nom_tabla,
                })
                .done(function(data) {             
                    //---------------------
                    console.log(data.mensaje.mensaje);
                    alert(data.mensaje.mensaje);
                    
                    //valida si sube archivos
                  if (ajustes.subida == true) {
                    //si el paramatro upload es true
                    subida_archivo();
                    //----------------
                    //location.reload();
                    //----------------                    
                  };

                  if ((ajustes.subida == false) && (ajustes.recarga == true)) {
                    
                    //location.reload();

                    setTimeout(function(){
                      location.reload();
                    }, 2000)
                    
                  };

                    //----------------------------------
                    //valida si debe ejecutar otra funcion dentro--------------------------------
                      //usando el ultimo id de registro
                      if (ajustes.ejecutarFunction == true) {
                        //asigna el last_id en id_resCrear
                        ajustes.id_resCrear = $("#pkID").val();
                        //console.log(data[0].last_id)
                        ajustes.functionResEditar();
                      };
                      //---------------------------------------------------------------------------
                    //----------------------------------
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

        function carga(id){

            console.log("Carga el id "+id);

            $.ajax({
                url: '../controller/ajaxController12.php',
                data: "pkID="+id+"&tipo=consultar&nom_tabla="+ajustes.nom_tabla,
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

                  if (ajustes.tipo_load == 1) {
                    $("#"+key).val(value);
                  } else if(ajustes.tipo_load == 2){
                    $("#form_"+ajustes.nom_modulo)[0][key]["value"] = value;
                  };

                  //condicional por si tiene mascaras de dinero añadidas
                  if (key == "valor") {
                    $("#valor_mask").val(accounting.formatNumber(value,options_format));
                  };
                  //-----------------------------------------------------
                                
                });

                //valida si debe ejecutar otra funcion dentro--------------------------------
                  //usando el ultimo id de registro
                  if (ajustes.ejecutarFunction == true) {
                    //asigna el last_id en id_resCrear
                    //ajustes.id_resCrear = data[0].last_id;
                    //console.log(data[0].last_id)
                    ajustes.functionResCarga(id,data);
                  };
                //---------------------------------------------------------------------------             
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
                    data: "pkID="+id+"&tipo=eliminar&nom_tabla="+ajustes.nom_tabla,
                })
                .done(function(data) {            
                    //---------------------
                    console.log(data);

                    alert(data.mensaje.mensaje);
                    //valida si hay que recargar la pagina
                    if (ajustes.recarga == true) {
                        location.reload();
                     };
                    //------------------------------------
                    if (ajustes.ejecutarFunction == true) {
                                                
                        ajustes.functionResEliminar(id);
                      };
                    //------------------------------------
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
                   var formData = new FormData($("#form_"+ajustes.nom_modulo)[0]);
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

                          if (ajustes.recarga == true) {
                            location.reload();
                          };
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
        //------------------------------------------------------------------------------------------------------------------------

        switch (ajustes.tipo) {
            
            case 'nuevo':
                // statements_1
                this.click(function(event) {
                    /* Act on the event */
                    if (ajustes.titulo_label == '') {

                        $("#lbl_form_"+ajustes.nom_modulo).html("Nuevo Registro "+ajustes.nom_modulo);
                        
                    }else{

                        $("#lbl_form_"+ajustes.nom_modulo).html(ajustes.titulo_label);
                        
                    };

                    $("#lbl_btn_action"+ajustes.nom_modulo).html("Guardar<span class='glyphicon glyphicon-chevron-right'></span>");
                    $("#btn_action"+ajustes.nom_modulo).attr("data-action","crear");

                    $("#form_"+ajustes.nom_modulo)[0].reset();
                    
                });
                break;
            //---------------------------------------------------------------------------
            case 'inserta/edita':

                this.click(function(event) {
                    /* Act on the event */
                    ajustes.action = $(this).attr("data-action");
                    console.log(ajustes.action)
                    valida_action(ajustes.action);
                });

                break;
            //---------------------------------------------------------------------------
             //---------------------------------------------------------------------------
            case 'carga_editar':

                this.click(function(event) {
                    /* Act on the event */
                    //console.log('ha dado click por carga_editar, con parametro:'+nom_modulo);

                    if (ajustes.titulo_label == '') {

                        $("#lbl_form_"+ajustes.nom_modulo).html("Edita Registro "+ajustes.nom_modulo);
                        
                    }else{

                        $("#lbl_form_"+ajustes.nom_modulo).html(ajustes.titulo_label);
                        
                    };

                    $("#lbl_btn_action"+ajustes.nom_modulo).html("Guardar Cambios<span class='glyphicon glyphicon-chevron-right'></span>");
                    $("#btn_action"+ajustes.nom_modulo).attr("data-action","editar");

                    $("#form_"+ajustes.nom_modulo)[0].reset();

                    id = $(this).attr('data-id-'+ajustes.nom_modulo);

                    console.log('el id del registro es:'+id);

                    carga(id);
                });

                break;
            //---------------------------------------------------------------------------

            //---------------------------------------------------------------------------
            case 'eliminar':

                this.click(function(event) {
                    /* Act on the event */
                    id = $(this).attr('data-id-'+ajustes.nom_modulo);
                    eliminar(id);
                });

                break;
            //--------------------------------------------------------------------------- 
        }

        console.log('Ejecutando jquery_controllerV2 en '+this.selector)
 
    };
 
}( jQuery ));