$(function(){

  //---------------------------------------------------------
  //form_contrasena
  uppercaseForm("form_contrasena");
  //variable para el objeto del formulario
  var objt_f_contrasena = {};
  //variable de accion del boton del formulario
  var action = "";
    //variable para el id del registro
  var id_contrasena = "";
  //---------------------------------------------------------
  
  //--------------------------------------------------------- 
  function valida_action(action){

      if(action==="crear"){
        crea_contrasena();
        //subida_foto();
      }else if(action==="editar"){
        edita_contrasena();
      };
  };
  //---------------------------------------------------------

  //-----------------------------------------------------------------------------------------------------
  //funciones hoja de vida

  function crea_contrasena(){

        //--------------------------------------
        //crea el objeto formulario serializado
        objt_f_contrasena = $("#form_contrasena").valida();        
        //console.log(objt_f_adminPublicidad.srlz);
        //--------------------------------------
        /**/
        if(objt_f_contrasena.estado == true){

        //subida_archivo(); 

          $.ajax({
            url: "../controller/ajaxController12.php",
            data: objt_f_contrasena.srlz+"&tipo=inserta&nom_tabla=contrasenas",
          })
          .done(function(data) {            
            //---------------------
            //console.log(data);                      
            alert(data[0].mensaje);
            location.reload();
          })
          .fail(function(data) {
            console.log(data);
            alert(data[0].mensaje);
            //location.reload();
          })
          .always(function() {
            console.log("complete");
          });

        }else{
          alert("El formulario no está totalmente diligenciado, revíselo e inténtelo de nuevo.");
        };

      };
    //cierra crea---------------------------------------------------------------------------------------------------
    function edita_contrasena(){

      //--------------------------------------
      //crea el objeto formulario serializado
      objt_f_contrasena = $("#form_contrasena").valida();     

      //subida_archivo();
      //--------------------------------------
      /**/
      if(objt_f_contrasena.estado == true){          

          $.ajax({
              url: '../controller/ajaxController12.php',
              data: objt_f_contrasena.srlz+"&tipo=actualizar&nom_tabla=contrasenas",
          })
          .done(function(data) {             
            //---------------------
            //console.log(data);

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
          alert("Faltan "+Object.keys(objt_f_hvida.objt).length+" campos por llenar.");
      }
      //------------------------------------------------------

    };
    //cierra funcion edita


   function carga_contrasena(id_contrasena){

        console.log("Carga contrasena "+id_contrasena);

        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "pkID="+id_contrasena+"&tipo=consultar&nom_tabla=contrasenas",
        })
        .done(function(data) {
          /**/
            $.each(data.mensaje[0], function( key, value ) {
              console.log(key+"--"+value);
              
              if (key != "pkID") {
                $("#"+key).val(value);
                $("#"+key+"_crypt").val(value);
                desencriptar(value,key)
              }else{
                $("#"+key).val(value);
              }
              //encriptar(value,key)
            });            

        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

    };
    //cierra

    function elimina_contrasena(id_contrasena){

      console.log('Eliminar contrasena: '+id_contrasena);

      var confirma = confirm("En realidad quiere eliminar este registro?");

      console.log(confirma);
      /**/
      if(confirma == true){
        //si confirma es true ejecuta ajax
        $.ajax({
              url: '../controller/ajaxController12.php',
              data: "pkID="+id_contrasena+"&tipo=eliminar&nom_tabla=contrasenas",
          })
          .done(function(data) {            
              //---------------------
              //console.log(data);

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
    //cierra funcion eliminar


   function encriptar(valor,selector){
      
        $.ajax({
          url: "../controller/crypt.php",
          data: "valor="+valor+"&tipo=encriptar",
        })
        .done(function(data) {            
          //---------------------
          //console.log(data);
          //$("#nombre").val(data.encriptado)            
          //encriptado = data.encriptado;
          $("#"+selector).val(data.encriptado);
          //---------------------------------------------------------------------------                  
        })
        .fail(function(data) {
          console.log(data);
          //alert(data[0].mensaje);          
        })
        .always(function() {
          console.log("complete");
        });              
    };

    function desencriptar(valor,selector){
      
          $.ajax({
            url: "../controller/crypt.php",
            data: "valor="+valor+"&tipo=desencriptar",
          })
          .done(function(data) {            
            //---------------------
            console.log(data);
            $("#"+selector).val(data.desencriptado);                      
            //---------------------------------------------------------------------------
                      
          })
          .fail(function(data) {
            console.log(data);
            //alert(data[0].mensaje);          
          })
          .always(function() {
            console.log("complete");
          });        

    };  


  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  /*
  Botón que carga el formulario para insertar
  */
  $("#btn_nuevocontrasena").click(function(){

      //$("#form_modal_contrasena_confirma").modal("show");
      //muestraModalConf();
      nuevoContrasena();
      $("#btn_actioncontrasena_confirma").attr('data-funcion', 'nuevoContrasena');
  });

  /*
  Botón que carga el formulario para editar
  */  
  $("[name*='edita_contrasena']").click(function(event) {
      //$("#form_modal_contrasena_confirma").modal("show");
      muestraModalConf();
      $("#btn_actioncontrasena_confirma").attr('data-funcion', 'cargaEdita');

      id_contrasena = $(this).attr('data-id-contrasena');     
  });

  /*
  Botón que elimina registro
  */  
  $("[name*='elimina_contrasena']").click(function(event) {
    
    //$("#form_modal_contrasena_confirma").modal("show");
    muestraModalConf();
    $("#btn_actioncontrasena_confirma").attr('data-funcion', 'eliminaReg');    
    id_contrasena = $(this).attr('data-id-contrasena');   
        
  });

  function eliminaReg(){

    elimina_contrasena(id_contrasena);
  }

  function cargaEdita(){

    $("#lbl_form_contrasena").html("Edita Contraseña");
    $("#lbl_btn_actioncontrasena").html("Guardar Cambios <span class='glyphicon glyphicon-pencil'></span>");
    $("#btn_actioncontrasena").attr("data-action","editar");

    $("#form_contrasena")[0].reset();
    
    console.log('Edita contrasena '+id_contrasena)

    $("#form_modal_contrasena").modal("show");

    //define que se reinicie cada vez que consulte
    $("#form_modal_contrasena").on("hide.bs.modal", function(){
      location.reload()
    });

    carga_contrasena(id_contrasena);   
  }

  function nuevoContrasena(){

      $("#lbl_form_contrasena").html("Nueva Contraseña");
      $("#lbl_btn_actioncontrasena").html("Guardar <span class='glyphicon glyphicon-save'></span>");
      $("#btn_actioncontrasena").attr("data-action","crear");
      

      $("#btn_actioncontrasena").removeAttr('disabled');      

      $("#form_contrasena")[0].reset();

      $("#form_modal_contrasena").modal("show");
  }

  /*
  Botón de accion de formulario
  */
  $("#btn_actioncontrasena").click(function(){
    /**/
    action = $(this).attr("data-action");
    valida_action(action);
    console.log("accion a ejecutar: "+action); 
    //subida_archivo();   
  });

   /*
   $("#nombre").change(function(event) {
    
    //$("#nombre_crypt").val(encriptar($(this).val()));
    encriptar($(this).val(),'nombre_crypt');
   });*/

   $(':input').change(function(event) {
    console.log($(this)[0]["id"]);
    var id_input = $(this)[0]["id"];
    var n = id_input.search("_crypt");
    console.log(n);
    if (n == -1) {
      console.log('aca ejecuto la funcion de encriptar!!')
      encriptar($(this).val(),id_input+'_crypt');
    } else{
      
      console.log('este control es un crypt')
    };
   }); 



   /*
   modal de confirmación de acciones para este modulo-----------------------------------------------------------------
   */
   //opciones del modal de confirmacion
   /*$("#form_modal_contrasena_confirma").modal({
    keyboard:false,
    backdrop:'static'
   });*/
   
   /*
   $('#form_modal_contrasena_confirma').on('show.bs.modal', function (e) {
      // do something...
      inicializaModalConf()
    })*/
  
    function muestraModalConf(){


      $("#form_modal_contrasena_confirma").modal({
        keyboard:false,
        backdrop:'static'
       });/**/
     
       /**/
       $('#form_modal_contrasena_confirma').on('show.bs.modal', function (e) {
          // do something...
          inicializaModalConf()
        })

       $("#form_modal_contrasena_confirma").modal("show");
    }

   function inicializaModalConf(){

    $("#lbl_form_contrasena_confirma").html("Confirmar Acción");
    $("#lbl_btn_actioncontrasena_confirma").html("Aceptar<span class='glyphicon glyphicon-chevron-right'></span>");
    //$("#btn_actioncontrasena_confirma").attr("data-action","crear");
    $("#form_contrasena_confirma")[0].reset();
    
   }

   //carga el modal al inicio
   //$("#form_modal_contrasena_confirma").modal("show");

   //----------------------------------------------------------------------------------------------------------------

   function leerCookie(nombre) {
         var lista = document.cookie.split(";");
         for (i in lista) {
             var busca = lista[i].search(nombre);
             if (busca > -1) {micookie=lista[i]}
             }
         var igual = micookie.indexOf("=");
         var valor = micookie.substring(igual+1);
         return valor;
    };

  
    var id_usuario = leerCookie("log_lunelAdmin_id");

    console.log(id_usuario);

   $("#btn_actioncontrasena_confirma").click(function(event) {
     /* Act on the event */
     //console.log($(this).attr('data-funcion'))
     consPass(id_usuario,$("#pass_conf").val(),$(this).attr('data-funcion'))
     
   });

   function mostrar(){
      console.log('mostrando la interfaz!!')
   }

   function consPass(pkID_usuario,pass_conf,funcion){

    var cons_pass = "select * from usuarios where pkID = "+pkID_usuario;

      $.ajax({
          url: '../controller/ajaxController12.php',
          cache : false,
          data: "query="+cons_pass+"&tipo=consulta_gen",
      })
      .done(function(data) {
        /*muestra data actual*/
          //console.log(data);

          validaPassConf(pass_conf,data.mensaje[0].pass_conf,funcion);                    
      })
      .fail(function() {
          console.log("error");
      })
      .always(function() {
          console.log("complete");
      });
     /*---------------------------------------------------*/

   }

   function validaPassConf(valor,valor2,funcion){
      
        $.ajax({
          url: "../controller/crypt.php",
          data: "valor="+valor+"&tipo=sha1",
        })
        .done(function(data) {            
          //---------------------
          //console.log(data.encriptado);
          //console.log(valor2)
          if (data.encriptado === valor2) {
            // statement
            $("#form_modal_contrasena_confirma").modal("hide");
            
            switch (funcion) {
              case 'mostrar':
                // statements_1
                mostrar()
                break;
              case 'nuevoContrasena':
                // statements_1
                nuevoContrasena()
                break;
              case 'cargaEdita':
                // statements_1
                cargaEdita()
                break;
              case 'eliminaReg':
                // statements_1
                eliminaReg()
                break;
              default:
                // statements_def
                console.log(funcion)
                break;
            }

          } else {
            // statement
            alert("La contraseña que ingresó no coincide, inténtelo de nuevo.")
            $("#pass_conf").val("")
            $("#pass_conf").focus();
          }          
          //---------------------------------------------------------------------------                  
        })
        .fail(function(data) {
          console.log(data);
          //alert(data[0].mensaje);          
        })
        .always(function() {
          console.log("complete");
        });              
    };
   
  //----------------------------------------------------------------------------------------------------------------------
  //tecla enter
  /**/
  $("#pass_conf").keydown(function(e) {
    
    var code = e.which; // recommended to use e.which, it's normalized across browsers
    //if(code==13)e.preventDefault();
    if(code==13){
        console.log('Presiono enter!')
        //consPass(id_usuario,$("#pass_conf").val(),$(this).attr('data-funcion'))
        return false;
    }else{
      console.log('Presiono la tecla '+code)
    } // missing closing if brace

  });
  //----------------------------------------------------------------------------------------------------------------------
});