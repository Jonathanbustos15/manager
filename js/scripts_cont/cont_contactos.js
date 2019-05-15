$(function(){

  //console.log('hola contactos...')

  $("#btn_nuevocontactos").jquery_controllerV2({
      nom_modulo:'contactos',
      titulo_label:'Nuevo Contacto',
      ejecutarFunction:true,
      functionBefore:function(ajustes){            

          //quita disabled al boton de accion
      $("#btn_actioncontactos").removeAttr('disabled');

      upload.functionReset()
      //--------------------------------------------------
        //--------------------------------------------------
        //evento click del checkbox recurrente
        //si esta check muestra el campo de fecha revision 
        //de lo contrario no y borra el valor.
        $("#chk_tipoacceso").click(function(event) {
          //console.log($(this)[0]["checked"]);
          chk_rec($(this)[0]["checked"]);         
        });       
        //--------------------------------------------------
        
        }
    });

    function chk_rec(tipo){

    if (tipo == true) {
        $("#chk_tipoacceso1").val('1');
      } else{
        $("#chk_tipoacceso2").val('0');
      };
    }

    $("#btn_actioncontactos").jquery_controllerV2({
      tipo:'inserta/edita',
      nom_modulo:'contactos',
      nom_tabla:'contactos',
      recarga:false,
      ejecutarFunction:true,
      functionResEditar:function(){
        //console.log(data)       
        //editar indicadores
        //console.log($("#btn_actionproceso").attr('data-action'))

            //$("#form_docente #pkID").val()

            upload.sendFiles($("#form_contactos #pkID").val())
        
            //--------------------------------------------------
            //location.reload();            
        },
        functionResCrear:function(data){
            //console.log('El ultimo creado fue: '+ajustes.id_resCrear);
            console.log(data[0].last_id);
            //console.log('Ejecutando luego de Insertar!!!');
            //location.reload();

            let id_last_contacto = data[0].last_id;

            $("#btn_actioncontactos").attr('disabled', 'true');

            /**/ 
            upload.sendFiles(id_last_contacto)

        },
        functionBefore:function(ajustes){
          console.log('Ejecutando antes de hacer cualquier cosa');
          
        }           

    });
    

    $("[name*='edita_contacto']").jquery_controllerV2({
      tipo:'carga_editar',
      nom_modulo:'contactos',
      nom_tabla:'contactos',
      titulo_label:'Edita Contacto',
      tipo_load:1,
      ejecutarFunction:true,
      functionBefore:function(ajustes){                
            console.log('Ejecutando antes de cualquier cosa!!!');
            
        },
      functionResCarga:function(id,data){
            //console.log('El eliminar registro: '+ajustes.id_resCrear);
            console.log('Ejecutando luego de Cargar!!!');

          //-----------------------------------------------
          //---------------------------------
  
        $("#btn_actioncontactos").removeAttr('disabled');
        //$("#btn_nuevoobservacion").removeAttr('disabled');
        //---------------------------------------------
    

            //--------------------------------------------------
                  
        //--------------------------------------------------
        if (data.mensaje[0].tipo_acceso == "1") {

          $("#chk_tipoacceso1")[0]["checked"] = true;
          chk_rec(true)
        } else{
          $("#chk_tipoacceso2")[0]["checked"] = true;
          chk_rec(true)
        };

        $("#chk_tipoacceso").click(function(event) {
          //console.log($(this)[0]["checked"]);
          chk_rec($(this)[0]["checked"]);         
        });
        //--------------------------------------------------
        
        var query_docs = "SELECT * FROM `documentos_contactos` WHERE fkID_contacto = "+id;

        upload.functionLoad(query_docs);
        //--------------------------------------------------
        }

    });

    $("[name*='elimina_contacto']").jquery_controllerV2({
      tipo:'eliminar',
      nom_modulo:'contactos',
      nom_tabla:'contactos'
    });

    //---------------------------------------------------
    function validarEmail( email ) {
      expr = /([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})/;
      if ( !expr.test(email) ){
        alert("Error: La dirección de correo " + email + " es incorrecta.");
        $("#email").val('');
        $("#email").focus();
      }else{
        return true;
      }     
    }

    $("#email").change(function(event) {
    /* Act on the event */
      validarEmail( $(this).val() )
    });

  //---------------------------------------------------
  //Valida el archivo
    $("#archivo").validaArchivo('archivo','contactos','url');
  //---------------------------------------------------

  //---------------------------------------------------
  //Validacion de campo nombre y apellidos 1ra en amyuscula  
  //form_tipoContacto
  uppercaseForm("form_contactos");
  uppercaseForm("form_tipoContacto");
  uppercaseForm("form_entidad");
  //---------------------------------------------------

    function encriptar(valor){
      
        $.ajax({
          url: "../controller/crypt.php",
          data: "valor="+valor+"&tipo=encriptar",
        })
        .done(function(data) {            
          //---------------------
          console.log(data);
          $("#nombre").val(data.encriptado)            
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

  function desencriptar(valor){
      
          $.ajax({
            url: "../controller/crypt.php",
            data: "valor="+valor+"&tipo=desencriptar",
          })
          .done(function(data) {            
            //---------------------
            console.log(data);
            $("#nombre").val(data.desencriptado)            
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

  $("#btn_encripta").click(function(event) {
    /* Act on the event */
      encriptar($("#nombre").val());
  });

  $("#btn_desencripta").click(function(event) {
    /* Act on the event */
      desencriptar($("#nombre").val());
  });

  $('#tbl_ingresos_gral').on( 'click', '.detail', function () {
    window.location.href = $(this).attr('href');
  });


  //---------------------------------------------------------
  //File upload
  self.upload = new funcionesUpload("fileupload","btn_actioncontactos","res_form","not_archivos","documentos_contactos","fkID_contacto")
  upload.init()
  //---------------------------------------------------------

  //-------------------------------------------------------------------------
});