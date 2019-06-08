$(function() {
    //console.log('hola hojas');
    uppercaseForm("form_hvida");
    //---------------------------------------------------------
    //variable para el objeto del formulario
    var objt_f_hvida = {};
    //variable de accion del boton del formulario
    var action = "";
    //variable para el id del registro
    var id_hvida = "";
    var idEstudio = 0;
    var nomEstudio = "";
    var tipoEstudio = "";
    var arrEstudios = [];
    var arrEstudiosBusqueda = [];
    var arrHojaEstudios = [];
    //console.log('saludando desde las funciones hvida');
    var valoresArchivos = [];
    var arregloDeArchivos = [];
    var contDetailName = 0;
    var archCoincide = "";
    //--------------------------------------------------------- 
    function valida_action(action){

        if(action==="crear"){
            crea_hvida();
            //subida_foto();
        }else if(action==="editar"){
            edita_hvida();
        }
        ;
    };
    //valida la acción para contrato
    function valida_actioncon(action){
        if(action==="crearc"){
            crea_contrato();
        }else if(action==="editarc"){
           editar_contrato();
        }
        ;
    };
    //consulta de datos hoja de vida


function autocomple(dat){
    var form = $("#fkID_cedula option:selected").val();
    var ruta = "../controller/actualizar.php";
    console.log(form);
    $.ajax({
        url: ruta,
        type: 'POST',
        data: {nombre:form},
        success: function(respuesta){
            console.log(respuesta);
            var tipos = JSON.parse(respuesta);
            console.log(tipos);
            console.log(tipos[0].nombre);
            $("#nombrec").val(tipos[0].nombre);
            $("#apellidoc").val(tipos[0].apellido);
            $("#telefonoc").val(tipos[0].telefono);
            $("#emailc").val(tipos[0].email);
            $("#fkID_estadoc").val(respuesta[0].empresa);
            console.log("aqui toy yoo");
        }
    })
};



function subid_archiv(nom_funcion) {
        //---------------------------------------------------------------------------------------
        //CREA UNA VARIABLE  DE TIPO FormData que toma el formulario
        id_hvida = $(this).attr('data-id-hvida');
        var formData = new FormData($("#form1")[0]);
        var data = formData + "&pkID="+id_hvida;  
        //la ruta del php que ejecuta ajax
        var ruta = "../subida_archivo/url2.php";
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
            beforeSend: function() {
                //var datoarch = json_encode($filename);
                console.log("Subiendo archivo, por favor espere...");
                //$("#not_docs_empresa").html("Subiendo archivo, por favor espere...");
            },
            //una vez finalizado correctamente
            success: function(data) {
                //var data= eval(dato);
                var arreglos = JSON.parse(data);
                console.log("mireme aquiii");
                console.log("esta es la data"+ arreglos);
                
                //if (data.clase == 'alert alert-success') {
                $("#not_docs_empresa").html('Subido el archivo...');
                switch (nom_funcion) {
                    case "crear":
                        crea_hvida(nombrelimpio);
                        break;
                    case "editar":
                        edita_hvida(nombrelimpio);
                        break;
                }
                // } else{
                //$("#not_docs_empresa").html(data.estado);
                //};
                //alert(data.estado);
                //$("#not_img").removeAttr('hidden');
                //$("#not_img").html(' <br /> <br /> <div class="'+data.clase+'" role="alert">'+data.estado+'</div>');
                /*
                switch(nom_funcion){
                    case:"crear"
                        crea_documento();
                    break;
                    case:"editar"
                        edita_documento();
                    break;
                }*/
            },
            //si ha ocurrido un error
            error: function() {
                console.log("Ha ocurrido un error.");
            }
        });
        //---------------------------------------------------------------------------------------
    };

    //---------------------------------------------------------
    function crea_consulta() {
        if (arrEstudiosBusqueda.length == 0) {
            alert('No hay estudios seleccionados para la busqueda.')
        } else {
            $.ajax({
                url: '../controller/hvidaController.php',
                data: "arrEstudiosBusqueda=" + arrEstudiosBusqueda + "",
            }).done(function(data) {
                //Esconde el formulario de busqueda
                $("#form_modal_busqueda_hvida").modal('hide');
                //Dibuja los registros de la tabla que trare con el data
                $("#tbl_hvida").html(data);
                //Crea funcion para el click de eliminar
                $("[name*='elimina_hvida']").click(function(event) {
                    id_hvida = $(this).attr('data-id-hvida');
                    elimina_hvida(id_hvida);
                    EliminaHvidaEstudio(id_hvida);
                });
                //Crea funcion con el click de editar
                $("[c_hvida']").click(function(event) {
                    $("#lbl_form_Hvida").html("Editar Registro Hoja de Vida");
                    $("#lbl_btn_actionHvida").html("Guardar Cambios <span class='glyphicon glyphicon-pencil'></span>");
                    $("#btn_actionHvida").attr("data-action", "editar");
                    $("#form_hvida")[0].reset();
                    input=document.getElementById("archivo");
                    input.value = '';
                    id_hvida = $(this).attr('data-id-hvida');
                    $("#btn_actionHvida").removeAttr('disabled');
                    //$("#selectPosgrado").removeAttr('hidden');
                    carga_hvida(id_hvida);
                    //carga_propiedades(id_hvida);
                });
                //Limpia el frm donde se dibujan los estudios de busqueda
                //$("#frm_estudios_busquedaHvida").html('');
            })
        }
    }

    function validarEmail(email) {
        expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!expr.test(email)) {
            alert("Error: La dirección de correo " + email + " es incorrecta.");
            $("#email").val("");
        } else {
            return true;
        }
    }
    $.fn.hasAttr = function(name) {
        return this.attr(name) !== undefined;
    };

    function validarcontrato(){
        var empleado = $("#fkID_cedula option:selected").val();
        var t_contrato = $("#selectC option:selected").val();
        var empresa = $("#fkID_estadoc option:selected").val();
        var cargo = $("#selectCar option:selected").val();
        var arl = $("#selectarl option:selected").val();
        var eps = $("#selecteps option:selected").val();
        var caja = $("#selectcaja option:selected").val();
        var cesantias = $("#selectcesan option:selected").val();
        var pensiones = $("#selectpensi option:selected").val();
        var departamento = $("#fkID_departamento option:selected").val();
        var ciudad = $("#ciudades option:selected").val();
        var salario = $("#salarioc").val(); 
        var fecha = $("#fechain").val();
        console.log ("la fecha es"+fecha);
        var respuesta;
        if (empleado === "" || t_contrato === "" || empresa === "" || cargo === "" || arl === "" || eps === "" || caja === "" || cesantias === "" || pensiones === "" || departamento === "" || ciudad === "" || salario === "" || fecha === "") {
            respuesta = "no"
            return respuesta
        }else{
            respuesta = "ok"
            return respuesta
        }
    }

    function validaBtnGuardar(){

        if(verPkIdHoja()){
            $("#btn_actionHvida").removeAttr('disabled');
        } else {
            console.log($("#fileupload")[0].files[0]);

            //var hidden = $("#selectEstudioPos").attr('hidden');

            /**/
            if(  ($("#fileupload")[0].files[0] != undefined)) {

                $("#btn_actionHvida").removeAttr('disabled');

            }else{
                console.log('falta seleccionar un estudio o cargar archivos!');
                $("#btn_actionHvida").attr('disabled','disabled');
            }   
        }
    
    }


    function validaEqualIdentifica(num_id) {
        console.log("busca valor " + encodeURI(num_id));
        var consEqual = "SELECT COUNT(*) as res_equal FROM `hoja_vida` WHERE `nidentificacion` = '" + num_id + "'";
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + consEqual + "&tipo=consulta_gen",
        }).done(function(data) {
            /**/
            //console.log(data.mensaje[0].res_equal);
            if (data.mensaje[0].res_equal > 0) {
                alert("El Número de indetificación ya existe, por favor ingrese un número diferente.");
                $("#nidentificacion").val("");
            } else {
                //return false;
            }
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //valida email++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    function validaEqualEmail(email) {
        console.log("busca valor " + encodeURI(email));
        var consEqual = "SELECT COUNT(*) as res_equal FROM `hoja_vida` WHERE `email` = '" + encodeURI(email) + "'";
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + consEqual + "&tipo=consulta_gen",
        }).done(function(data) {
            /**/
            //console.log(data.mensaje[0].res_equal);
            if (data.mensaje[0].res_equal > 0) {
                alert("El correo ya existe, por favor ingrese un correo diferente.")
                $("#email").val("");
            } else {
                //return false;
            }
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    }
    //-----------------------------------------------------------------------------------------------------
    
    function crea_contrato(){
        console.log("hola voy a crear contrato");
        var idhv = $("#fkID_cedula option:selected").val();
         var idticontra = $("#selectC option:selected").val();
         var fechain = $("#fechain").val();
         var fechater = $("#fechater").val();
         var salario = $("#salarioc").val();
         var idcargo = $("#selectCar option:selected").val();
         var idarl = $("#selectarl option:selected").val();
         var ideps = $("#selecteps option:selected").val();
         var idcaja = $("#selectcaja option:selected").val();
         var idcesan = $("#selectcesan option:selected").val();
         var idpensio = $("#selectpensi option:selected").val();
         var idciudad = $("#ciudades option:selected").val();
         var funcion = "Insertar_Con"
         var cadena = "idhv=" + idhv + "&idticontra=" + idticontra + "&fechain=" + fechain + "&fechater=" + fechater +
                "&salario=" + salario + "&idcargo=" + idcargo + "&idarl=" + idarl + "&ideps=" + ideps +
                "&idcaja=" + idcaja + "&idcesan=" + idcesan + "&idpensio=" + idpensio + "&idciudad=" +idciudad+ "&tipoaccion=" +funcion; 
         console.log(cadena);       
         $.ajax({  
              type: "POST",
              url: "../controller/ajaxContrato.php",
              data: cadena,
              success:function(r){
                if (r==1) {
                    editar_empresa();
                } else {
                    console.log("fallo servidor");
                }
              }
            })
    }




    function editar_contrato(){
        console.log("hola voy a crear contrato");
        var idhv = $("#fkID_cedula option:selected").val();
         var idticontra = $("#selectC option:selected").val();
         var idempresa = $("#fkID_estadoc option:selected").val();
         var fechain = $("#fechain").val();
         var fechater = $("#fechater").val();
         var salario = $("#salarioc").val();
         var idcargo = $("#selectCar option:selected").val();
         var idarl = $("#selectarl option:selected").val();
         var ideps = $("#selecteps option:selected").val();
         var idcaja = $("#selectcaja option:selected").val();
         var idcesan = $("#selectcesan option:selected").val();
         var idpensio = $("#selectpensi option:selected").val();
         var idciudad = $("#ciudades option:selected").val();
         var funcion = "actualizar";
         var ntabla = "contrato";
         console.log("el contrato es"+id_contrato);
         var cadena = "pkID=" +id_contrato+ "&fkID_hvida=" + idhv + "&fkID_tipo_contrato=" + idticontra + "&fecha_inicio=" + fechain + "&fecha_terminacion=" + fechater +
                "&salario_base=" + salario + "&fkID_cargo=" + idcargo + "&fkID_arl=" + idarl + "&fkID_eps=" + ideps +
                "&fkID_caja_compensacion=" + idcaja + "&fkID_cesantias=" + idcesan + "&fkID_pensiones=" + idpensio + "&fkID_ciudad=" +idciudad+ "&tipo=" +funcion+ "&nom_tabla="+ntabla; 
         console.log(cadena);       
         $.ajax({  
              type: "GET",
              url: "../controller/ajaxController12.php",
              data: cadena,
              success:function(r){
                    editar_empresa();
                    cargar_documentos_contratos();
              }
            })
    }
    //editar empresa
    function editar_empresa(){
        console.log("hola voy a crear contrato");
        var id = $("#fkID_cedula option:selected").val();
        var idempres = $("#fkID_estadoc option:selected").val();

        var funcio = "actualizar";
        var ntabl = "hoja_vida";
        var caden = "pkID="+id + "&fkID_estado=" +idempres+ "&tipo=" +funcio+ "&nom_tabla="+ntabl; 
        $.ajax({  
              type: "GET",
              url: "../controller/ajaxController12.php",
              data: caden,
              success:function(p){
                    window.alert("Guardado correctamente.");
                    //location.reload();
              }
            }) 
    }

    //editar empresa
    function cargar_documentos_contratos(){
        var caden = "tipo=consultarA&nom_tabla=tipo_archivo_contrato"; 
        console.log(caden);
        $.ajax({  
              type: "POST",
              url: "../controller/document_contrato.php",
              data: caden,
              success:function(a){
                    var tipos = JSON.parse(a);
                    console.log(tipos[0].id_input);
                    var num= tipos.length;
                    //console.log(tipos[0].nombre);
                    for(x=0; x < tipos.length; x++) {
                        var valo = document.getElementById (tipos[x].id_input);
                        if (valo.value==="") {} 
                            else {
                                var ruta = valo.value
                                var filename = ruta.replace(/^.*[\\\/]/, '');
                                console.log(filename)
                                console.log(valo)
                                subir_documentos_contratos(filename,tipos[x].id_input,ruta)
                        }
                    }   
              }
            }) 
    }

    function subir_documentos_contratos(nombre,clave,ruta){
        console.log(id_contrato);
        var parametros = new FormData($("#formadjuntos")[0]);
        parametros.append =('valor', clave);
        //parametros.append = "nombre="+nombre+"&pkID="+id_contrato+"&valor="+clave+"&ruta="+ruta;
        //console.log(caden);
        $.ajax({  
              type: "POST",
              url: "../subida_archivo/documentos.php",
              data: parametros,
              contentType: false,
              processData: false,
              success:function(a){
                      console.log(a);
              }
            }) 
    }
    
    //crea hoja de vida
    function crea_hvida(){

          //--------------------------------------
          //crea el objeto formulario serializado
          objt_f_hvida = $("#form_hvida").valida();
          email = $("#email").val();
          console.log(objt_f_hvida);
          //console.log(objt_f_adminPublicidad.srlz);
          //--------------------------------------
          /**/
          if( (objt_f_hvida.estado == true) && (validarEmail(email)) ){

          //subida_archivo();   

            $.ajax({
              url: "../controller/ajaxController12.php",
              data: objt_f_hvida.srlz+"&tipo=inserta&nom_tabla=hoja_vida",
            })
            .done(function(data) {            
              //---------------------
              console.log(data);
              
              var pkID_hojaVida = data[0].last_id;
             
              //-----------------------------------------------------------------------------------
              //subida_archivo_id(pkID_hojaVida);

              $("#btn_actionHvida").attr('disabled','disabled');

              var iteracion = $.each(arregloDeArchivos, function(index, val) {
                 
                 console.log('Subiendo archivo: '+val);

                 $('#fileupload').fileupload('send', {files:val})
                    .success(function (result, textStatus, jqXHR) {                 
                        console.log(result);
                        console.log(textStatus);
                        console.log(jqXHR);

                        getValoresDesc(val[0].name);
                        insertaArchivo("pkID_hojaVida="+pkID_hojaVida+"&url_archivo="+val[0].name+"&des_archivo="+archCoincide );                       

                    })
                    .error(function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    })
                    .complete(function (result, textStatus, jqXHR) {
                        console.log(textStatus);
                    });

              });

              //-----------------------------------------------------------------------------------     
              $.when(iteracion).then( subidaOK, subidaFail );

                function subidaOK(){

                    //-----------------------------------------------------------------------------------
                      arrEstudios.forEach(function(element, index){
                        //statements
                        var obtHE = {"pkID_hojaVida":pkID_hojaVida,"pkID_estudio":element};
                        arrHojaEstudios.push(obtHE);
                      });

                      console.log(arrHojaEstudios);

                      var cadenaSerializa = "";           

                      var iteraInsert = $.each(arrHojaEstudios, function(index, val) {               

                        var dataCadena = "";

                         $.each(val, function(llave, valor) {
                                         
                             console.log("llave="+llave+" valor="+valor);

                             dataCadena = dataCadena+llave+"="+valor+"&";                                       
                             //insertaEstudio(cadenaSerializa);
                         });

                         dataCadena = dataCadena.substring(0,dataCadena.length - 1);

                         console.log(dataCadena);
                         //---------------------------------------------------------
                         insertaEstudio(dataCadena);                
                         //---------------------------------------------------------
                      });

                      $.when(iteraInsert).then(insertaOK, insertaFail);


                    function insertaOK() {
                        alert(data[0].mensaje);
                        location.reload();
                    }

                    function insertaFail() {
                        alert("Hubo un error en la inserción de estudios.");
                    }
                    //-----------------------------------------------------------------------------------					        				       		          					       
                }

                function subidaFail() {
                    alert('Hubo un error en la subida de archivos.');
                }
                //-----------------------------------------------------------------------------------	             	       
            }).fail(function(data) {
                console.log(data);
                // alert(data[0].mensaje);          
            }).always(function() {
                console.log("complete");
            });
        } else {
            alert("El formulario no está totalmente diligenciado, revíselo e inténtelo de nuevo.");
        };
    };
    //cierra crea
    function elimina_hvida(id_hvida) {
        console.log('Eliminar el hvida: ' + id_hvida);
        var confirma = confirm("En realidad quiere eliminar esta hoja de vida?");
        console.log(confirma);
        /**/
        if (confirma == true) {
            //si confirma es true ejecuta ajax
            $.ajax({
                url: '../controller/ajaxController12.php',
                data: "pkID=" + id_hvida + "&tipo=eliminarlogico&nom_tabla=hoja_vida",
            }).done(function(data) {
                //---------------------
                console.log(data);
                alert(data.mensaje.mensaje);
                location.reload();
            }).fail(function() {
                console.log("error");
            }).always(function() {
                console.log("complete");
            });
        } else {
            //no hace nada
        }
    };

    function elimina_contrato(id_contrato) {
        console.log('Eliminar el hvida: ' + id_contrato);
        var confirma = confirm("En realidad quiere eliminar este contrato?");
        console.log(confirma);
        /**/
        if (confirma == true) {
            //si confirma es true ejecuta ajax
            $.ajax({
                url: '../controller/ajaxController12.php',
                data: "pkID=" + id_contrato + "&tipo=eliminarlogico&nom_tabla=contrato",
            }).done(function(data) {
                //---------------------
                console.log(data);
                alert(data.mensaje.mensaje);
                location.reload();
            }).fail(function() {
                console.log("error");
            }).always(function() {
                console.log("complete");
            });
        } else {
            //no hace nada
        }
    };
    //cierra funcion eliminar hvida
    function edita_hvida(){

        //--------------------------------------
        //crea el objeto formulario serializado
        objt_f_hvida = $("#form_hvida").valida();
        email = $("#email").val();

        //subida_archivo();
        //--------------------------------------
        /**/
        if( (objt_f_hvida.estado == true) && (validarEmail(email)) ){

            console.log(objt_f_hvida.srlz);

            $.ajax({
                url: '../controller/ajaxController12.php',
                data: objt_f_hvida.srlz+"&tipo=actualizar&nom_tabla=hoja_vida",
            })
            .done(function(data) {

              var iteracionEdita = $.each(arregloDeArchivos, function(index, val) {
                 
                 console.log('Subiendo archivo: ');
                 console.log(val);

                 $('#fileupload').fileupload('send', {files:val})
                    .success(function (result, textStatus, jqXHR) {                 
                        /**/console.log(result);
                        console.log(textStatus);
                        console.log(jqXHR);

                        getValoresDesc(val[0].name);
                        insertaArchivo("pkID_hojaVida="+id_hvida+"&url_archivo="+val[0].name+"&des_archivo="+archCoincide );                        
                    })
                    .error(function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    })
                    .complete(function (result, textStatus, jqXHR) {
                        console.log(textStatus);
                    });

              });
       
                        //-----------------------------------------------------------------------------------
                      //Elimina los estudios de la hvida
                      EliminaHvidaEstudio(id_hvida);

                      arrEstudios.forEach(function(element, index){
                        //statements
                        var obtHE = {"pkID_hojaVida":id_hvida,"pkID_estudio":element};
                        arrHojaEstudios.push(obtHE);
                      });

                      console.log(arrHojaEstudios);

                      var cadenaSerializa = "";           

                      var iteraInsert = $.each(arrHojaEstudios, function(index, val) {               

                        var dataCadena = "";

                         $.each(val, function(llave, valor) {
                                         
                             console.log("llave="+llave+" valor="+valor);

                             dataCadena = dataCadena+llave+"="+valor+"&";                                       
                             //insertaEstudio(cadenaSerializa);
                         });

                         dataCadena = dataCadena.substring(0,dataCadena.length - 1);

                         console.log(dataCadena);
                         //---------------------------------------------------------
    
                         insertaEstudio(dataCadena);                
                         //---------------------------------------------------------
                      });

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
    //cierra funcion edita_hvida};
    //cierra funcion edita_hvida
    function verPkIdHoja() {
        var id_hvida_form = $("#pkID").val();
        //---------------------------------------------------------
        if (id_hvida_form != "") {
            return true;
        } else {
            return false;
        }
    }

    function carga_hvida(id_hvida) {
        console.log("Carga el hvida " + id_hvida);
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "pkID=" + id_hvida + "&tipo=consultar&nom_tabla=hoja_vida",
        }).done(function(data) {
            /**/
            $.each(data.mensaje[0], function(key, value) {  
                console.log(key + "--" + value);
                $("#" + key).val(value);
            });
            id_hvida = data.mensaje[0].pkID;
            carga_estudios(id_hvida);
            carga_archivos(id_hvida);
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    };
    //cierra carga_hvida
    //carga la primer ventada de contrato
    function carga_contrato(id_hvida) {
        console.log("Carga el hvida " + id_hvida);
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "pkID=" + id_hvida + "&tipo=consultarcon",
        }).done(function(data) {
            /**/idc = 0;
            $.each(data.mensaje[0], function(key, valu) {
                var valor = valu;
                console.log(key + "--" + valor);
                if (key == "pkID") { 
                    idc = valor
                    console.log(idc);
                }
                if (key == "fkID_estado") { 
                    $("#"+ key +" option[value="+ valor +"]").attr("selected", true);
                }
                if (key == "fkID_cedula" ) {
                     $("#"+ key +" option[value="+ idc +"]").attr("selected", true);
                     console.log("aquie es")
                } else {
                $("#" + key).val(valor);  
                }
                
            });
            id_hvida = data.mensaje[0].pkID;
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    };
    //-----------------------------------------------------------------------------------------------------
    //carga la segunda ventada de contrato
    function carga_contratos2(id_contrato) {
        console.log("Carga el contrato " + id_contrato);
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "pkID=" + id_contrato + "&tipo=consultarcontrato",
        }).done(function(data) {
            idc = 0;
            $.each(data.mensaje[0], function(key, valu) {
                var valor = valu;
                console.log(key + "--" + valor);
                if (key == "pkciudad") {
                    llave = valor;
                }
                if (key == "ciudades") {
                     $('#ciudades').append('<option value='+llave+' selected="selected">'+valor+'</option>');
                }
                if (key == "fechain" || key == "fechater" || key == "salarioc" ) { 
                    $("#" + key).val(valor); 
                }
                else{
                     $("#"+ key +" option[value="+ valor +"]").attr("selected", true);
                     console.log("aquie es")
                }
                
            });
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    };
    //-----------------------------------------------------------------------------------------------------
    //funciones enviar formato a url2.php
    function subida_archivos() {
        //---------------------------------------------------------------------------------------
        //CREA UNA VARIABLE  DE TIPO FormData que toma el formulario
        console.log("Ingresando al mundo malo");
        var formData = new FormData($("#form_hvida")[0]);
        //la ruta del php que ejecuta ajax
        var ruta = "../subida_archivo/url2.php";
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
            beforeSend: function() {
                console.log("Subiendo archivo, por favor espere...");
                $("#not_docs_empresa").html("Subiendo archivo, por favor espere...");
            },
            //una vez finalizado correctamente
            
            //si ha ocurrido un error
            error: function() {
                console.log("Ha ocurrido un error.");
            }
        });
        //---------------------------------------------------------------------------------------
    };


    //funciones estudios
    function insertaEstudio(data) {
        $.ajax({
            url: "../controller/ajaxController12.php",
            data: data + "&tipo=inserta&nom_tabla=hoja_estudio",
        }).done(function(data) {
            //---------------------
            console.log(data);
            //alert(data[0].mensaje);
            //location.reload();          
        }).fail(function(data) {
            console.log(data);
            //alert(data[0].mensaje);          
        }).always(function() {
            console.log("complete");
        });
    }

    function insertEstudioSelected(idEstudio) {
        var id_hvida_form = $("#pkID").val();
        if (idEstudio != '') {
            //---------------------------------------------------------
            if (id_hvida_form != "") {
                console.log('la hoja ' + id_hvida_form + ' esta cargada.');
                //asociar a la hoja de vida
                var dataHojaEstudio = "pkID_hojaVida=" + id_hvida_form + "&pkID_estudio=" + idEstudio;
                insertaEstudio(dataHojaEstudio);
                alert('Estudio guardado con éxito.');
                location.reload();
            } else {
                console.log('No hay nada en el form.');
            }
            //---------------------------------------------------------	
        } else {
            alert('No se ha seleccinado estudio');
        }
    }

    function editaEstudio(data) {
        //crear un array con cada uno de los registros
        //de pkID_estudio y pkID_hojaVida
        //en un foreach hacer una insercion
        $.ajax({
            url: "../controller/ajaxController12.php",
            data: data + "&tipo=actualizar&nom_tabla=hoja_estudio",
        }).done(function(data) {
            //---------------------
            console.log(data);
            //alert(data[0].mensaje);
            //location.reload();          
        }).fail(function(data) {
            console.log(data);
            //alert(data[0].mensaje);          
        }).always(function() {
            console.log("complete");
        });
    }

    function carga_estudios(id) {
        var query_estudios = "SELECT hoja_vida.pkID as pkID_hojaVida, estudio.*, tipo_estudio.nombre as nom_tipoEstudio, hoja_estudio.pkID as pkID_regHojaEstudio" + " FROM `hoja_vida`" + " INNER JOIN hoja_estudio ON hoja_estudio.pkID_hojaVida = hoja_vida.pkID" + " INNER JOIN estudio on estudio.pkID = hoja_estudio.pkID_estudio" + " INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio" + " WHERE hoja_vida.pkID =" + id;
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + query_estudios + "&tipo=consulta_gen",
        }).done(function(data) {
            /*
	        $.each(data.mensaje[0], function( key, value ) {
	          console.log(key+"--"+value);
	          $("#"+key).val(value);
	        });*/
            console.log(data);
            /*
            $.each(data.mensaje[0], function(index, val) {
            	 console.log('llave: '+index+' valor:'+val);
            });*/
            $("#frm_estudios_hvida").html("");
            arrEstudios.length = 0;
            if (data.estado != "Error") {
                /**/
                for (var i = 0; i < data.mensaje.length; i++) {
                    //console.log(data.mensaje[0].pkID+'-'+data.mensaje[0].nombre+'-'+data.mensaje[0].nom_tipoEstudio);
                    selectEstudioNumReg(data.mensaje[i].pkID, data.mensaje[i].nombre, data.mensaje[i].nom_tipoEstudio, data.mensaje[i].pkID_regHojaEstudio);
                }
            } else {
                //$("#selectPosgrado").attr('hidden','');
            }
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    }

    function EliminaHvidaEstudio(id) {
        var consHvidaEstudio = "DELETE FROM hoja_estudio WHERE pkID_hojaVida = " + id;
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + consHvidaEstudio + "&tipo=consulta_gen&nom_tabla=hoja_estudio",
        }).done(function(data) {
            /*muestra data actual*/
            console.log(data);
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
        /*---------------------------------------------------*/
    }

    function selectEstudio(id, nombre, tipo) {
        //añade control a form
        //console.log();
        /*
        if(document.getElementById("frm_estudios_hvida")){
        	console.log('ya existe');
        }else{
        	console.log('no existe');
        }*/
        /**/
        if (id != "") {
            if (document.getElementById("pkID_estudio_" + id)) {
                alert("Este estudio ya fue seleccionado.")
            } else {
                $("#frm_estudios_hvida").append('<div class="form-group" id="frm_group' + id + '">' + '<label for="pkID_estudio_' + id + '" class="control-label" style="margin-right: 20px;">' + tipo + '</label>' + '<input type="text" style="width: 90%;display: inline;" class="form-control" id="pkID_estudio_' + id + '" name="pkID_estudio" value="' + nombre + '" readonly="true"> <button name="btn_actionRmEstudio" data-id-estudio="' + id + '" data-id-frm-group="frm_group' + id + '" type="button" class="btn btn-danger"><span class="fa fa-remove"></span></button>' + '</div>');
                $("[name*='btn_actionRmEstudio']").click(function(event) {
                    console.log('click remover estudio ' + $(this).data('id-frm-group'));
                    removeEstudio($(this).data('id-frm-group'));
                    //buscar el indice
                    var idEstudio = $(this).attr("data-id-estudio");
                    console.log('el elemento es:' + idEstudio);
                    var indexArr = arrEstudios.indexOf(idEstudio);
                    console.log("El indice encontrado es:" + indexArr);
                    //quitar del array
                    if (indexArr >= 0) {
                        arrEstudios.splice(indexArr, 1);
                        console.log(arrEstudios);
                    } else {
                        console.log('salio menor a 0');
                        console.log(arrEstudios);
                    }
                });
                //construye array de estudios
                arrEstudios.push(id);
                console.log(arrEstudios);
            }
        } else {
            alert("No se seleccionó ningún estudio.")
        }
    };

    function selectEstudioBusqueda(id, nombre, tipo) {
        if (id != "") {
            if (document.getElementById("pkID_estudio_busqueda_" + id)) {
                alert("Este estudio ya fue seleccionado.")
            } else {
                $("#frm_estudios_busquedaHvida").append('<div class="form-group" id="frm_group' + id + '">' + '<label for="pkID_estudio_busqueda_' + id + '" class="control-label" style="margin-right: 20px;">' + tipo + '</label>' + '<input type="text" style="width: 90%;display: inline;" class="form-control" id="pkID_estudio_busqueda_' + id + '" name="pkID_estudio" value="' + nombre + '" readonly="true"> <button name="btn_actionRmEstudioBusqueda" data-id-estudio="' + id + '" data-id-frm-group="frm_group' + id + '" type="button" class="btn btn-danger"><span class="fa fa-remove"></span></button>' + '</div>');
                $("[name*='btn_actionRmEstudioBusqueda']").click(function(event) {
                    console.log('click remover estudio ' + $(this).data('id-frm-group'));
                    removeEstudio($(this).data('id-frm-group'));
                    //buscar el indice
                    var idEstudio = $(this).attr("data-id-estudio");
                    console.log('el elemento es:' + idEstudio);
                    var indexArr = arrEstudiosBusqueda.indexOf(idEstudio);
                    console.log("El indice encontrado es:" + indexArr);
                    //quitar del array
                    if (indexArr >= 0) {
                        arrEstudiosBusqueda.splice(indexArr, 1);
                        console.log(arrEstudiosBusqueda);
                    } else {
                        console.log('salio menor a 0');
                        console.log(arrEstudiosBusqueda);
                    }
                });
                //construye array de estudios
                arrEstudiosBusqueda.push(id);
                console.log(arrEstudiosBusqueda);
            }
        } else {
            alert("No se seleccionó ningún estudio.")
        }
    };

    function selectEstudioNumReg(id, nombre, tipo, numReg) {
        //añade control a form
        //console.log();
        /*
        if(document.getElementById("frm_estudios_hvida")){
        	console.log('ya existe');
        }else{
        	console.log('no existe');
        }*/
        /**/
        if (id != "") {
            if (document.getElementById("pkID_estudio_" + id)) {} else {
                $("#frm_estudios_hvida").append('<div class="form-group" id="frm_group' + id + '">' + '<label for="pkID_estudio_' + id + '" class="control-label" style="margin-right: 20px;">' + tipo + '</label>' + '<input type="text" style="width: 90%;display: inline;" class="form-control" id="pkID_estudio_' + id + '" name="pkID_estudio" value="' + nombre + '" readonly="true"> <button name="btn_eliminaEstudio" data-id-estudio="' + id + '" data-num-reg="' + numReg + '" data-id-frm-group="frm_group' + id + '" type="button" class="btn btn-danger"><span class="fa fa-remove"></span></button>' + '</div>');
                $("[name*='btn_eliminaEstudio']").click(function(event) {
                    console.log('click remover estudio ' + $(this).data('id-frm-group'));
                    removeEstudio($(this).data('id-frm-group'));
                    //buscar el indice
                    var idEstudio = $(this).attr("data-id-estudio");
                    console.log('el elemento es:' + idEstudio);
                    var indexArr = arrEstudios.indexOf(idEstudio);
                    console.log("El indice encontrado es:" + indexArr);
                    //quitar del array
                    if (indexArr >= 0) {
                        arrEstudios.splice(indexArr, 1);
                        console.log(arrEstudios);
                    } else {
                        console.log('salio menor a 0');
                        console.log(arrEstudios);
                    }
                });
                //construye array de estudios
                arrEstudios.push(id);
                console.log(arrEstudios);
            }
        } else {
            alert("No se seleccionó ningún estudio.")
        }
    };

    function deleteEstudioNumReg(numReg) {
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "pkID=" + numReg + "&tipo=eliminar&nom_tabla=hoja_estudio",
        }).done(function(data) {
            //---------------------
            console.log(data);
            alert(data.mensaje.mensaje);
            //location.reload();
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    }

    function removeEstudio(id) {
        $("#" + id).remove();
    }

    function removeArchivo(id) {
        $("#" + id).remove();
    }
    //-----------------------------------------------------------------------------------------------------
    //funciones validar archivos que existen en el servidor
    function validaArchivo() {
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
        console.log("Archivo para subir: " + fileName + ", peso total: " + fileSize + " de tipo:" + fileType);
    }
    var numero = 0; //Esta es una variable de control para mantener nombres
            //diferentes de cada campo creado dinamicamente.
var numero = 0; //Esta es una variable de control para mantener nombres
            //diferentes de cada campo creado dinamicamente.
evento = function (evt) { //esta funcion nos devuelve el tipo de evento disparado
   return (!evt) ? event : evt;
}

//Aqui se hace lamagia... jejeje, esta funcion crea dinamicamente los nuevos campos file
addCampo = function () { 
//Creamos un nuevo div para que contenga el nuevo campo
   nDiv = document.createElement('div');
//con esto se establece la clase de la div
   nDiv.className = 'archivo';
//este es el id de la div, aqui la utilidad de la variable numero
//nos permite darle un id unico
   nDiv.id = 'file' + (++numero);
//creamos el input para el formulario:
   nCampo = document.createElement('input');
//le damos un nombre, es importante que lo nombren como vector, pues todos los campos
//compartiran el nombre en un arreglo, asi es mas facil procesar posteriormente con php
   nCampo.name = 'files[]';
//Establecemos el tipo de campo
   nCampo.type = 'file';
//Ahora creamos un link para poder eliminar un campo que ya no deseemos
   a = document.createElement('a');
   nCampo.style = 'width: 90%;display: inline';
//El link debe tener el mismo nombre de la div padre, para efectos de localizarla y eliminarla
   a.name = nDiv.id;
//Este link no debe ir a ningun lado
   a.href = '#';
//Establecemos que dispare esta funcion en click
   a.onclick = elimCamp;
//Con esto ponemos el texto del link
   a.innerHTML = 'Eliminar';
//Bien es el momento de integrar lo que hemos creado al documento,
//primero usamos la función appendChild para adicionar el campo file nuevo
   nDiv.appendChild(nCampo);
//Adicionamos el Link
   nDiv.appendChild(a);
//Ahora si recuerdan, en el html hay una div cuyo id es 'adjuntos', bien
//con esta función obtenemos una referencia a ella para usar de nuevo appendChild
//y adicionar la div que hemos creado, la cual contiene el campo file con su link de eliminación:
   container = document.getElementById('adjuntos');
   container.appendChild(nDiv);
}
//con esta función eliminamos el campo cuyo link de eliminación sea presionado
elimCamp = function (evt){
   evt = evento(evt);
   nCampo = rObj(evt);
   div = document.getElementById(nCampo.name);
   div.parentNode.removeChild(div);
}
//con esta función recuperamos una instancia del objeto que disparo el evento
rObj = function (evt) { 
   return evt.srcElement ?  evt.srcElement : evt.target;
}
//con esta función eliminamos el campo cuyo link de eliminación sea presionado
elimCamp = function (evt){
   evt = evento(evt);
   nCampo = rObj(evt);
   div = document.getElementById(nCampo.name);
   div.parentNode.removeChild(div);
}
//con esta función recuperamos una instancia del objeto que disparo el evento
rObj = function (evt) { 
   return evt.srcElement ?  evt.srcElement : evt.target;
}
    function subida_archivo_id(id_hoja_vida) {
        //---------------------------------------------------------------------------------------
        //CREA UNA VARIABLE  DE TIPO FormData que toma el formulario
        var formData = new FormData($("#form_archivo")[0]);
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
            beforeSend: function() {
                console.log("Subiendo archivo, por favor espere...");
            },
            //una vez finalizado correctamente
            success: function(data) {
                console.log(data);
                //alert(data.estado);
                $("#not_img").removeAttr('hidden');
                $("#not_img").html("");
                //$("#not_img").html(' <br /> <br /> <div class="'+data.clase+'" role="alert">'+data.estado+'</div>');
                for (var i = 0; i < data.length; i++) {
                    //Things[i]
                    console.log(data[i]);
                    if (data[i].estado != "error") {
                        insertaArchivo("pkID_hojaVida=" + id_hoja_vida + "&url_archivo=" + data[i].nombre);
                        $("#not_img").append('<div class="' + data[i].clase + '" role="alert">' + data[i].estado + '</div>');
                    } else {
                        $("#not_img").append('<div class="' + data[i].clase + '" role="alert">No se pudo subir el archivo!. ' + data[i].mensaje + '</div>');
                    }
                };
            },
            //si ha ocurrido un error
            error: function() {
                console.log("Ha ocurrido un error.");
            }
        });
        //---------------------------------------------------------------------------------------
    }; //cierra función subida
    function insertaArchivo(data) {
        console.log("Esta es la data")
        console.log(data)
        //crear un array con cada uno de los registros
        //de pkID_hojaVida y url_archivo 
        //en un foreach hacer una insercion
        $.ajax({
            url: "../controller/ajaxController12.php",
            data: data + "&tipo=inserta&nom_tabla=archivo",
        }).done(function(data) {
            //---------------------
            console.log(data);
            //alert(data[0].mensaje);
            //location.reload();          
        }).fail(function(data) {
            console.log(data);
            //alert(data[0].mensaje);          
        }).always(function() {
            console.log("complete");
        });
    }

    function carga_archivos(id) {
        var query_archivos = "select * FROM `archivo` WHERE pkID_hojaVida =" + id;
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + query_archivos + "&tipo=consulta_gen",
        }).done(function(data) {
            console.log(data);
            $("#archivos_res").html("");
            if (data.estado != "Error") {
                /**/
                //arrEstudios.length=0;
                for (var i = 0; i < data.mensaje.length; i++) {
                    $("#archivos_res").append('<div class="form-group" id="frm_group' + data.mensaje[i].pkID + '">' + '<input type="text" style="width: 90%;display: inline;" class="form-control" id="pkID_archivo_' + data.mensaje[i].pkID + '" name="btn_RmArchivo[]" value="' + data.mensaje[i].url_archivo + '" readonly="true"> <a id="btn_doc" title="Descargar Archivo" name="download_documento" type="button" class="btn btn-success" href = "../server/php/files/' + data.mensaje[i].url_archivo + '" target="_blank" ><span class="glyphicon glyphicon-download-alt"></span></a><button name="btn_actionRmArchivo" data-id-archivo="' + data.mensaje[i].pkID + '" type="button" class="btn btn-danger"><span class="fa fa-remove"></span></button>' + '</div>' + '<div class="form-group">' + '<label class="control-label">Descripción:</label>' + '<p style="width: 90%;display: inline;" > ' + data.mensaje[i].des_archivo + '</p> <br>' + '</div>');
                }
                $("[name*='btn_actionRmArchivo']").click(function(event) {
                    /* Act on the event */
                    var id_archivo = $(this).attr('data-id-archivo');
                    elimina_archivo(id_archivo);
                });
            }
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    }

    function elimina_archivo(id_archivo) {
        console.log('Eliminar el archivo: ' + id_archivo);
        var confirma = confirm("En realidad quiere eliminar este archivo de la hoja de vida?");
        console.log(confirma);
        /**/
        if (confirma == true) {
            //si confirma es true ejecuta ajax
            $.ajax({
                url: '../controller/ajaxController12.php',
                data: "pkID=" + id_archivo + "&tipo=eliminar&nom_tabla=archivo",
            }).done(function(data) {
                //---------------------
                console.log(data);
                alert(data.mensaje.mensaje);
                location.reload();
            }).fail(function() {
                console.log("error");
            }).always(function() {
                console.log("complete");
            });
        } else {
            //no hace nada
        }
    };
    //----------------------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------
    function subida_archivo() {
        //---------------------------------------------------------------------------------------
        //CREA UNA VARIABLE  DE TIPO FormData que toma el formulario
        var formData = new FormData($("#form_archivo")[0]);
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
            beforeSend: function() {
                console.log("Subiendo archivo, por favor espere...");
            },
            //una vez finalizado correctamente
            success: function(data) {
                console.log(data);
                //alert(data.estado);
                //$("#not_img").removeAttr('hidden');
                //$("#not_img").html(' <br /> <br /> <div class="'+data.clase+'" role="alert">'+data.estado+'</div>');
            },
            //si ha ocurrido un error
            error: function() {
                console.log("Ha ocurrido un error.");
            }
        });
        //---------------------------------------------------------------------------------------
    }; //cierra función subida*/
    //-------------------------------------------------------------------------------
    //ejecución
    //-------------------------------------------------------------------------------
   
    //validacion campos hv++++++++++++++++++++++++++++++++++++++++++++
    $("#nidentificacion").keyup(function(event) {
        /* Act on the event*/
        if (((event.keyCode < 48) && (event.keyCode != 8)) || (event.keyCode > 57)) {
            console.log(String.fromCharCode(event.which));
            alert("El número de identificación NO puede llevar valores alfanuméricos.");
            $(this).val("");
        }
    });
    $('#salarioc').mask('000.000.000.000.000', {reverse: true});
    $("#telefono").keyup(function(event) {
        /* Act on the event */
        if (((event.keyCode > 32) && (event.keyCode < 48)) || (event.keyCode > 57)) {
            console.log(String.fromCharCode(event.which));
            alert("El número de Telefono NO puede llevar valores alfanuméricos.");
            $(this).val("");
        }
    });
    $("#nombre").keyup(function(event) {
        /* Act on the event */
        if (((event.keyCode > 32) && (event.keyCode < 65)) || (event.keyCode > 200)) {
            console.log(String.fromCharCode(event.which));
            alert("El Nombre NO puede llevar valores numericos.");
            $(this).val("");
        }
    });
    $("#apellido").keyup(function(event) {
        /* Act on the event */
        if (((event.keyCode > 32) && (event.keyCode < 65)) || (event.keyCode > 200)) {
            console.log(String.fromCharCode(event.which));
            alert("El Apellido NO puede llevar valores numericos.");
            $(this).val("");
        }
    });
    $("#nidentificacion").change(function(event) {
        /* valida que no tenga menos de 8 caracteres*/
        var valores_idCli = $(this).val().length;
        console.log(valores_idCli);
        if ((valores_idCli < 5) || (valores_idCli > 12)) {
            alert("El número de identificación no puede ser menor a 5 valores.");
            $(this).val("");
            $(this).focus();
        }
        validaEqualIdentifica($(this).val());
    });
    $("#telefono").change(function(event) {
        /* valida que no tenga menos de 8 caracteres*/
        var valores_idCli = $(this).val().length;
        console.log(valores_idCli);
        if (valores_idCli < 7) {
            alert("El número de Telefono no puede ser menor a 7 valores.");
            $(this).val("");
            $(this).focus();
        }
        validaEqualIdentifica($(this).val());
    });
    /*
    /*
    $("#email").change(function(event) {
        /* Act on the event */
    /*validarEmail($(this).val());
    validaEqualEmail($(this).val());*/
    /*
    if( validaEqualEmail($(this).val()) == true ){
    	alert("El correo ya existe, por favor ingrese un correo diferente.")
    	$(this).val("");
    }else{
    	alert("El correo no existe.")
    }*/
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    /*
    Botón que carga el formulario para insertar
    */
    $("#btn_nuevoHvida").click(function(){

        $("#lbl_form_Hvida").html("Nueva Hoja de Vida");
        $("#lbl_btn_actionHvida").html("Guardar <span class='glyphicon glyphicon-save'></span>");
        $("#btn_actionHvida").attr("data-action","crear");

        //$("#selectPosgrado").attr('hidden','');

        $("#btn_actionHvida").attr('disabled','disabled');
        $("#frm_estudios_hvida").html("");
        $("#archivos_res").html("");
        $("#res_form").html("");
        arrEstudios.length=0;
        validaBtnGuardar();
        $("#form_hvida")[0].reset();
        $("#form_hvida_estudios")[0].reset();
        $("#form_archivo")[0].reset();              
    });

    $(document).ready(function(){
    $("#btn_nuevocontrato").click(function() {
       console.log("mire aqui");
       $("#lbl_form_contrato").html("Nuevo Contrato");
        $("#lbl_btn_actioncontrato").html("Guardar <span class='glyphicon glyphicon-save'></span>");
        $("#btn_actioncontrato").attr("data-action", "crearc");
        $("#btn_actioncontrato").removeAttr('disabled', 'disabled');
        $("#form_contratos")[0].reset();
        $("#form_contrato_datos")[0].reset();
        $("#formadjuntos")[0].reset();
        $("#fkID_cedula").val("");
        $("#selectC").val("");
        $("#fkID_estadoc").val("");
        $("#selectCar").val("");
        $("#selectarl").val("");
        $("#selecteps").val("");
        $("#selectcaja").val("");
        $("#selectcesan").val("");
        $("#selectpensi").val("");
        $("#fkID_departamento").val("");
        document.getElementById ("ciudades") .options.length = 0;
    });
    });

    $("[name='archivo_sube']").change(function() {
        validaArchivo();
    });
    /*
    Botón que carga el formulario para editar
    */  
    $("[name*='edita_hvida']").click(function(event) {
        $("#lbl_form_Hvida").html("Editar Registro Hoja de Vida");
        $("#lbl_btn_actionHvida").html("Guardar Cambios <span class='glyphicon glyphicon-pencil'></span>");
        $("#btn_actionHvida").attr("data-action","editar");

        $("#form_hvida")[0].reset();
        $("#form_hvida_estudios")[0].reset();
        $("#form_archivo")[0].reset();
        id_hvida = $(this).attr('data-id-hvida');

        $("#btn_actionHvida").removeAttr('disabled');
        //$("#selectPosgrado").removeAttr('hidden');

        carga_hvida(id_hvida);
        //carga_propiedades(id_hvida);
    });
    /*
    Botón que carga el formulario para editar contrato
    */
    $("[name*='edita_contrato']").click(function(event) {
        $("#lbl_form_contrato").html("Editar Registro de Contrato");
        $("#lbl_btn_actioncontrato").html("Guardar Cambios <span class='glyphicon glyphicon-pencil'></span>");
        $("#btn_actioncontrato").attr("data-action", "editarc");
        $("#form_contratos")[0].reset();
        $("#form_contrato_datos")[0].reset();
        $("#formadjuntos")[0].reset();
        id_hvidac = $(this).attr('data-id-contratoh');
        id_contrato = $(this).attr('data-id-contrato');
        console.log(id_contrato);
        carga_contrato(id_hvidac);
        carga_contratos2(id_contrato);
        $("#btn_actioncontrato").removeAttr('disabled');
        
        //carga_propiedades(id_hvida);
    });


    $("[name*='edita_hvida_busqueda']").click(function(event) {
        alert('Entro');
        /*$("#lbl_form_Hvida").html("Editar Registro Hoja de Vida");
        $("#lbl_btn_actionHvida").html("Guardar Cambios <span class='glyphicon glyphicon-pencil'></span>");
        $("#btn_actionHvida").attr("data-action","editar");

        $("#form_hvida")[0].reset();

        id_hvida = $(this).attr('data-id-hvida');

        $("#btn_actionHvida").removeAttr('disabled');
        //$("#selectPosgrado").removeAttr('hidden');

        carga_hvida(id_hvida);
        //carga_propiedades(id_hvida);*/
    });
    /*
    Botón que elimina registro
    */
    $("[name*='elimina_hvida']").click(function(event) {
        id_hvida = $(this).attr('data-id-hvida');
        elimina_hvida(id_hvida);
        EliminaHvidaEstudio(id_hvida);
    });
    $("[name*='elimina_contrato']").click(function(event) {
        id_contrato = $(this).attr('data-id-contrato');
        elimina_contrato(id_contrato);
    });
    //autocompleta el formulario de datos empleado
    function autocomple(){
    var form = $("#fkID_cedula option:selected").val();
    var ruta = "../controller/cargar_empleado.php";
    console.log(form);
    $.ajax({
        url: ruta,
        type: 'POST',
        data: {nombre:form},
        success: function(respuesta){
            console.log(respuesta);
            var tipos = JSON.parse(respuesta);
            console.log(tipos);
            console.log(tipos[0].nombre);
            $("#nombrec").val(tipos[0].nombre);
            $("#apellidoc").val(tipos[0].apellido);
            $("#telefonoc").val(tipos[0].telefono);
            $("#emailc").val(tipos[0].email);
            $("#fkID_estadoc").val(respuesta[0].empresa);
            console.log("aqui toy yoo");
        }
    })
};
//autocompleta los datos del select ciudad
function autocompleciudad(){
    var form = $("#fkID_departamento option:selected").val();
    console.log(form);
    var ruta = "../controller/actualizar_ciudad.php";
    console.log(form);
    $.ajax({
        url: ruta,
        type: 'POST',  
        data: {ciudad:form},
        success: function(respuesta){
            console.log(respuesta);
            //convierte la cadena que se resive json
            var tipos = JSON.parse(respuesta);
            console.log(tipos);
            console.log("aqui toy yoo");
            $('#ciudades').append('<option value="" selected="selected">Elije la Ciudad</option>');
            for(x=0; x<tipos.length; x++) {
                $('#ciudades').append('<option value='+tipos[x].codigo+'>'+tipos[x].nombre+'</option>');
                console.log(tipos[x].nombre);
            }
        }
    })
};

 $(document).ready(function(){
        $("#fkID_cedula").change(function(){
            ;
            console.log("hola tuu");  
            var op = $("#fkID_cedula option:selected").val();
            console.log(op);
            $('input[type="text"]').val('');
            $('input[type="tel"]').val('');
            $('input[type="email"]').val('');
            autocomple();
        });
        }); 
//actualiza las ciudades
     $(document).ready(function(){
        $("#fkID_departamento").change(function(){
            ;
            console.log("hola tuu ciudad");  
            var ope = $("#fkID_departamento option:selected").val();
            console.log(ope);
            document.getElementById ("ciudades") .options.length = 0;
            autocompleciudad(); 
        });
        }); 
    /*
    Botón de accion de formulario
    */
    $("#btn_actionHvida").click(function() {
        action = $(this).attr("data-action");
        valida_action(action);
        //enviarf();
        console.log("accion a ejecutar: " + action);
        //subida_archivo();   
    });
    /*
    Botón de accion de formulario contrato
    */
    $("#btn_actioncontrato").click(function() {
        var validacioncon = validarcontrato();
        if (validacioncon === "no") {
            window.alert("Faltan Campos por diligenciar.");
        } else {
        action = $(this).attr("data-action");
        valida_actioncon(action);
        console.log("accion a ejecutar: " + action); 
        }
        
    });
    /*
    Botón de accion de busqueda de estudios
    */
    $("#btn_busquedahvida").click(function() {
        crea_consulta();
    });
    $("#selectEstudioTecnico").change(function(event) {
        idEstudio = $(this).val();
        nomEstudio = $(this).find("option:selected").data('nom-estudio')
        tipoEstudio = $(this).find("option:selected").data('nom-tipoestudio')
        validaBtnGuardar();
        console.log(nomEstudio + "-" + tipoEstudio);
        if (idEstudio != '') {
            //insertEstudioSelected(idEstudio);
            if (verPkIdHoja()) {
                if (document.getElementById("pkID_estudio_" + idEstudio)) {
                    alert("Este estudio ya fue seleccionado.")
                } else {
                    selectEstudio(idEstudio, nomEstudio, tipoEstudio);
                }
            } else {
                selectEstudio(idEstudio, nomEstudio, tipoEstudio);
            }
        } else {
            alert("No se ha seleccionado estudio.")
        }
    });
    $("#selectEstudioTecnicoBusqueda").change(function(event) {
        idEstudio = $(this).val();
        nomEstudio = $(this).find("option:selected").data('nom-estudio')
        tipoEstudio = $(this).find("option:selected").data('nom-tipoestudio')
        console.log(nomEstudio + "-" + tipoEstudio);
        //insertEstudioSelected(idEstudio);
        if (document.getElementById("pkID_estudio_busqueda_" + idEstudio)) {
            alert("Este estudio ya fue seleccionado.")
        } else {
            selectEstudioBusqueda(idEstudio, nomEstudio, tipoEstudio);
        }
    });
    $("#selectEstudioTecnologo").change(function(event) {
        idEstudio = $(this).val();
        nomEstudio = $(this).find("option:selected").data('nom-estudio')
        tipoEstudio = $(this).find("option:selected").data('nom-tipoestudio')
        validaBtnGuardar();
        console.log(nomEstudio + "-" + tipoEstudio);
        if (idEstudio != '') {
            //insertEstudioSelected(idEstudio);
            if (verPkIdHoja()) {
                if (document.getElementById("pkID_estudio_" + idEstudio)) {
                    alert("Este estudio ya fue seleccionado.")
                } else {
                    selectEstudio(idEstudio, nomEstudio, tipoEstudio);
                }
            } else {
                selectEstudio(idEstudio, nomEstudio, tipoEstudio);
            }
        } else {
            alert("No se ha seleccionado estudio.")
        }
    });
    $("#selectEstudioTecnologoBusqueda").change(function(event) {
        idEstudio = $(this).val();
        nomEstudio = $(this).find("option:selected").data('nom-estudio')
        tipoEstudio = $(this).find("option:selected").data('nom-tipoestudio')
        console.log(nomEstudio + "-" + tipoEstudio);
        if (document.getElementById("pkID_estudio_busqueda_" + idEstudio)) {
            alert("Este estudio ya fue seleccionado.")
        } else {
            selectEstudioBusqueda(idEstudio, nomEstudio, tipoEstudio);
        }
    });
    $("#selectEstudio").change(function(event) {
        idEstudio = $(this).val();
        nomEstudio = $(this).find("option:selected").data('nom-estudio')
        tipoEstudio = $(this).find("option:selected").data('nom-tipoestudio')
        //$("#selectPosgrado").removeAttr('hidden');
        validaBtnGuardar();
        console.log(nomEstudio + "-" + tipoEstudio);
        if (idEstudio != '') {
            //insertEstudioSelected(idEstudio);
            if (verPkIdHoja()) {
                if (document.getElementById("pkID_estudio_" + idEstudio)) {
                    alert("Este estudio ya fue seleccionado.")
                } else {
                    selectEstudio(idEstudio, nomEstudio, tipoEstudio);
                }
            } else {
                selectEstudio(idEstudio, nomEstudio, tipoEstudio);
            }
        } else {
            alert("No se ha seleccionado estudio.")
        }
    });
    $("#selectEstudioPregradoBusqueda").change(function(event) {
        idEstudio = $(this).val();
        nomEstudio = $(this).find("option:selected").data('nom-estudio')
        tipoEstudio = $(this).find("option:selected").data('nom-tipoestudio')
        console.log(nomEstudio + "-" + tipoEstudio);
        //insertEstudioSelected(idEstudio);
        if (document.getElementById("pkID_estudio_busqueda_" + idEstudio)) {
            alert("Este estudio ya fue seleccionado.")
        } else {
            selectEstudioBusqueda(idEstudio, nomEstudio, tipoEstudio);
        }
    });
    $("#selectEstudioPos").change(function(event) {
        idEstudio = $(this).val();
        nomEstudio = $(this).find("option:selected").data('nom-estudio')
        tipoEstudio = $(this).find("option:selected").data('nom-tipoestudio')
        console.log(nomEstudio + "-" + tipoEstudio);
        if (idEstudio != '') {
            if (verPkIdHoja()) {
                selectEstudio(idEstudio, nomEstudio, tipoEstudio);
            } else {
                selectEstudio(idEstudio, nomEstudio, tipoEstudio);
            }
        } else {
            alert("No se ha seleccionado estudio.")
        }
    });
    $("#selectEstudioPosgradoBusqueda").change(function(event) {
        idEstudio = $(this).val();
        nomEstudio = $(this).find("option:selected").data('nom-estudio')
        tipoEstudio = $(this).find("option:selected").data('nom-tipoestudio')
        console.log(nomEstudio + "-" + tipoEstudio);
        //insertEstudioSelected(idEstudio);
        if (document.getElementById("pkID_estudio_busqueda_" + idEstudio)) {
            alert("Este estudio ya fue seleccionado.")
        } else {
            selectEstudioBusqueda(idEstudio, nomEstudio, tipoEstudio);
        }
    });
    $("#selectEstudioCertificacion").change(function(event) {
        $("#div_fecha_certificacion").removeAttr('hidden');
        idEstudio = $(this).val();
        nomEstudio = $(this).find("option:selected").data('nom-estudio')
        tipoEstudio = $(this).find("option:selected").data('nom-tipoestudio')
        validaBtnGuardar();
        console.log(nomEstudio + "-" + tipoEstudio);
        if (idEstudio != '') {
            //insertEstudioSelected(idEstudio);
            if (verPkIdHoja()) {
                if (document.getElementById("pkID_estudio_" + idEstudio)) {
                    alert("Este estudio ya fue seleccionado.")
                } else {
                    selectEstudio(idEstudio, nomEstudio, tipoEstudio);
                }
            } else {
                selectEstudio(idEstudio, nomEstudio, tipoEstudio);
            }
        } else {
            alert("No se ha seleccionado estudio.")
        }
    });
    $("#selectEstudioCertificacionBusqueda").change(function(event) {
        idEstudio = $(this).val();
        nomEstudio = $(this).find("option:selected").data('nom-estudio')
        tipoEstudio = $(this).find("option:selected").data('nom-tipoestudio')
        console.log(nomEstudio + "-" + tipoEstudio);
        //insertEstudioSelected(idEstudio);
        if (document.getElementById("pkID_estudio_busqueda_" + idEstudio)) {
            alert("Este estudio ya fue seleccionado.")
        } else {
            selectEstudioBusqueda(idEstudio, nomEstudio, tipoEstudio);
        }
    });
    //--------------------------------------------------------------------------------------------------
    $('#fileupload').change(function() {
        validaBtnGuardar();
    });

    function validaTypeFile(tipo) {
        if ((tipo == "application/octet-stream") || (tipo == "application/msword") || (tipo == "image/pjpeg") || (tipo == "image/jpeg") || (tipo == "image/png") || (tipo == "image/gif") || (tipo == "application/pdf") || (tipo == "application/pdf") || (tipo == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")) {
            /*
            if(size <= 2000000){
            	return true;
            }
            else{
            	return false;
            }*/
            return true;
        } else {
            return false;
        }
    }
    $('#fileupload').fileupload({
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        //maxFileSize: 999999999,
        add: function (e, data) {


            //console.log(e);

            //console.log(data.files);                      

            //console.log("validando tipo: "+data.files[0].type+" es valido? -->"+validaTypeFile(data.files[0].type));

            console.log(data.files[0].size);
            
            if(validaTypeFile(data.files[0].type)){             

                data.context = $("#res_form").append(

                    '<div class="frm_group" id="frm_group'+contDetailName+'">'+

                    '<label class="control-label">Descripción para el archivo: '+data.files[0].name+'</label>'+

                    '<button name="btn_eliminaArchivo" data-id-archivo="'+contDetailName+'" data-id-frm-group="frm_group'+contDetailName+'" type="button" class="btn btn-danger"><span class="fa fa-remove"></span></button><br>'+

                    '<input type="text" class="form-control" name="detail['+contDetailName+']" data-name-file="'+data.files[0].name+'" />'+

                    '</div>'

                    );

                contDetailName++;
                
                valoresArchivos = [];

                arregloDeArchivos.push(data.files);

                console.log(arregloDeArchivos);

                var iteracion = $.each(arregloDeArchivos, function(index, val) {
                     /* iterate through array or object */
                     console.log("llave: "+index+" valor: "+val);
                     console.log(val)
                });
                $.when(iteracion).then(myFunc, myFailure);

                function myFunc() {
                    console.log('Termino. Muy Bien.')
                }

                function myFailure() {
                    console.log('Algo salio mal!')
                }
                //prueba
                //$("#btn_subir").attr('data-nombre-archivo', data.files[0].name);			
                //-----------------------------------------------------------------
                $("[name*='btn_eliminaArchivo']").click(function(event) {
                    console.log('click remover archivo ' + $(this).data('id-frm-group'));
                    removeArchivo($(this).data('id-frm-group'));
                    //buscar el indice
                    var idArchivo = $(this).attr("data-id-archivo");
                    console.log('el elemento es:' + idArchivo);
                    delete arregloDeArchivos[idArchivo];
                    console.log(arregloDeArchivos);
                });
            } else {
                //alert("El tipo de archivo "+data.files[0].type+" no está permitido o el archivo de tamaño "+data.files[0].size+" es demasiado grande, recuerde que el límite es de 2M.");
                alert("El tipo de archivo " + data.files[0].type + " no está permitido.");
            }
        },
        done: function(e, data) {
            //data.context.text('Upload finished.');
            console.log('Upload finished.');
        }
    });

    function getValoresDesc(nomArch) {
        console.log(nomArch);
        console.log($("[name*='detail']"));
        var nombreControl = "";
        $.each($("[name*='detail']"), function(index, val) {
            /* iterate through array or object */
            //console.log('llave:'+index+' valor:'+val.value);
            //id_hoja_vida = 2;
            //var elementoArchivos = {"nombre":$(this).attr("data-name-file"),"des_archivo":val.value};
            //valoresArchivos.push(elementoArchivos);
            nombreControl = $(this).attr("data-name-file");
            console.log(nombreControl);
            if (nomArch == nombreControl) {
                archCoincide = val.value;
                //console.log(val.value);
            }
        });
    }
    //console.log(valoresArchivos);
    //--------------------------------------------------------------------------------------------------
    $("#btn_sube_archivos").click(function(event) {
        /* Act on the event */
        subida_archivo_id(2);
    });
    $("#btn_subir").click(function(event) {
        getValoresDesc($(this).attr('data-nombre-archivo'));
        console.log(archCoincide);
    });
    $('#tbl_hvida').on('click', '.detail', function() {
        window.location.href = $(this).attr('href');
    });
    //Boton para consultar por estudios
    $("#btn_buscar").click(function() {
        $('#form_modal_busqueda_hvida').modal('show');
        $("#lbl_form_busquedaHvida").html("Buscar por estudios");
        $("#lbl_btn_busquedaHvida").html("Buscar <span class='glyphicon glyphicon-save'></span>");
        $("#btn_busquedahvida").attr("data-action", "busqueda");
        $("#frm_estudios_busquedaHvida").html("");
        arrEstudiosBusqueda.length = 0;
        $("#form_busqueda")[0].reset();
    });
    //Recarga la pagina
    $("#btn_inicial").click(function() {
        location.reload();
    });
    //--------------------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------
    //Uppercase en form
    /*
      function firstUppercase(valor){
        var valorIni = valor;
        var letraMay = valorIni[0].toUpperCase();
        var letra = valorIni[0];

        valorFinal = valorIni.replace(letra, letraMay);

        return valorFinal;
      }*/
    //--------------------------------------------------------------------------------------------------
    //BLOQUE DE FUNCIONES PARA ESTUDIOS
    uppercaseForm("form_estudios");
    $("#btn_nuevoestudio").jquery_controllerV2({
        nom_modulo: 'estudios',
        titulo_label: 'Nuevo Estudio'  
    });
    $("#btn_nuevoestudio").click(function(event) {
        //cierra modal ingreso_gral
        $('#form_modal_hvida').modal('hide');
        $('#form_modal_estudios').on('hidden.bs.modal', function(e) {
            $('#form_modal_hvida').modal('show');
        });
        $("#btn_actionestudios").removeAttr('disabled');
        carga_tecnico();
        carga_tecnologo();
        carga_pregrado();
        carga_posgrado();
        carga_certificacion();
    });
    $("#btn_actionestudios").jquery_controllerV2({
        tipo: 'inserta/edita',
        nom_modulo: 'estudios',
        nom_tabla: 'estudio',
        recarga: false,
        //validacion del campo nombre-------------
        validarCampo: true,
        nom_campo: 'nombre',
        ejecutarFunction: true,
        functionResCrear: function() {
            $('#form_modal_estudios').modal('hide');
            var query = "SELECT * FROM `estudio` ORDER BY pkID DESC limit 1";
            $.ajax({
                url: '../controller/ajaxController12.php',
                data: "query=" + query + "&tipo=consulta_gen",
            }).done(function(data) {
                /**/
                //console.log(data.mensaje[0].res_equal);
                idEstudio = data.mensaje[0]["pkID"]; //Consultar ultimo ID
                nomEstudio = $("#nombre_estudio").val();
                tipoEstudio = $("#fkID_tipoEstudio option:selected").text();
                console.log(nomEstudio + "-" + tipoEstudio);
                selectEstudio(idEstudio, nomEstudio, tipoEstudio);
            }).fail(function() {
                console.log("error");
            }).always(function() {
                console.log("complete");
            });
        }
        //----------------------------------------
    });
    //-----------------------------------------------------------------------
    function carga_tecnico() {
        var consulta_empresa = "select estudio.*, tipo_estudio.nombre as nom_tipo_estudio" + " FROM `estudio`" + " INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio" + " WHERE estudio.fkID_tipoEstudio = 8 " + " ORDER BY nombre";
        //---------------------------------------------------------------
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + consulta_empresa + "&tipo=consulta_gen",
        }).done(function(data) {
            /**/
            $("#selectEstudioTecnico").html('')
            console.log(data)
            if (data.mensaje != "No hay registros.") {
                $("#selectEstudioTecnico").append('<option></option>')
                $.each(data.mensaje, function(index, val) {
                    /* iterate through array or object */
                    console.log(index + "--" + val)
                    console.log(val)
                    $("#selectEstudioTecnico").append('<option value="' + val.pkID + '" data-nom-estudio="' + val.nombre + '" data-nom-tipoestudio="' + val.nom_tipo_estudio + '">' + val.nombre + '</option>')
                });
                $("#selectEstudioTecnico").click();
            };
            //$( "#fkID_categoria" ).load( "formatos.php option");
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
        //---------------------------------------------------------------
    }

    function carga_tecnologo() {
        var consulta_empresa = "select estudio.*, tipo_estudio.nombre as nom_tipo_estudio" + " FROM `estudio`" + " INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio" + " WHERE estudio.fkID_tipoEstudio = 9 " + " ORDER BY nombre";
        //---------------------------------------------------------------
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + consulta_empresa + "&tipo=consulta_gen",
        }).done(function(data) {
            /**/
            $("#selectEstudioTecnologo").html('')
            console.log(data)
            if (data.mensaje != "No hay registros.") {
                $("#selectEstudioTecnologo").append('<option></option>')
                $.each(data.mensaje, function(index, val) {
                    /* iterate through array or object */
                    console.log(index + "--" + val)
                    console.log(val)
                    $("#selectEstudioTecnologo").append('<option value="' + val.pkID + '" data-nom-estudio="' + val.nombre + '" data-nom-tipoestudio="' + val.nom_tipo_estudio + '">' + val.nombre + '</option>')
                });
                $("#selectEstudioTecnologo").click();
            };
            //$( "#fkID_categoria" ).load( "formatos.php option");
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
        //---------------------------------------------------------------
    }

    function carga_pregrado() {
        var consulta_empresa = "select estudio.*, tipo_estudio.nombre as nom_tipo_estudio" + " FROM `estudio`" + " INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio" + " WHERE estudio.fkID_tipoEstudio = 1 " + " ORDER BY nombre";
        //---------------------------------------------------------------
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + consulta_empresa + "&tipo=consulta_gen",
        }).done(function(data) {
            /**/
            $("#selectEstudio").html('')
            console.log(data)
            if (data.mensaje != "No hay registros.") {
                $("#selectEstudio").append('<option></option>')
                $.each(data.mensaje, function(index, val) {
                    /* iterate through array or object */
                    console.log(index + "--" + val)
                    console.log(val)
                    $("#selectEstudio").append('<option value="' + val.pkID + '" data-nom-estudio="' + val.nombre + '" data-nom-tipoestudio="' + val.nom_tipo_estudio + '">' + val.nombre + '</option>')
                });
                $("#selectEstudio").click();
            };
            //$( "#fkID_categoria" ).load( "formatos.php option");
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
        //---------------------------------------------------------------
    }

    function carga_posgrado() {
        var consulta_empresa = "select estudio.*, tipo_estudio.nombre as nom_tipo_estudio" + " FROM `estudio`" + " INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio" + " WHERE estudio.fkID_tipoEstudio >=3 AND estudio.fkID_tipoEstudio <=6" + " ORDER BY nombre";
        //---------------------------------------------------------------
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + consulta_empresa + "&tipo=consulta_gen",
        }).done(function(data) {
            /**/
            $("#selectEstudioPos").html('')
            console.log(data)
            if (data.mensaje != "No hay registros.") {
                $("#selectEstudioPos").append('<option></option>')
                $.each(data.mensaje, function(index, val) {
                    /* iterate through array or object */
                    console.log(index + "--" + val)
                    console.log(val)
                    $("#selectEstudioPos").append('<option value="' + val.pkID + '" data-nom-estudio="' + val.nombre + '" data-nom-tipoestudio="' + val.nom_tipo_estudio + '">' + val.nombre + '</option>')
                });
                $("#selectEstudioPos").click();
            };
            //$( "#fkID_categoria" ).load( "formatos.php option");
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
        //---------------------------------------------------------------
    }

    function carga_certificacion() {
        var consulta_empresa = "select estudio.*, tipo_estudio.nombre as nom_tipo_estudio" + " FROM `estudio`" + " INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio" + " WHERE estudio.fkID_tipoEstudio = 7" + " ORDER BY nombre";
        //---------------------------------------------------------------
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + consulta_empresa + "&tipo=consulta_gen",
        }).done(function(data) {
            /**/
            $("#selectEstudioCertificacion").html('')
            console.log(data)
            if (data.mensaje != "No hay registros.") {
                $("#selectEstudioCertificacion").append('<option></option>')
                $.each(data.mensaje, function(index, val) {
                    /* iterate through array or object */
                    console.log(index + "--" + val)
                    console.log(val)
                    $("#selectEstudioCertificacion").append('<option value="' + val.pkID + '" data-nom-estudio="' + val.nombre + '" data-nom-tipoestudio="' + val.nom_tipo_estudio + '">' + val.nombre + '</option>')
                });
                $("#selectEstudioCertificacion").click();
            };
            //$( "#fkID_categoria" ).load( "formatos.php option");
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
        //---------------------------------------------------------------
    }
    /* LLAMA LA FUNCION DE CARGAR AL TENER EL FOCO EN EL SELECT */
    $("#selectEstudio").focus(function(event) {
        carga_pregrado()
    });
    $("#selectEstudioTecnico").focus(function(event) {
        carga_tecnico()
    });
    $("#selectEstudioTecnologo").focus(function(event) {
        carga_tecnologo()
    });
    $("#selectEstudioPos").focus(function(event) {
        carga_posgrado()
    });
    $("#selectEstudioCertificacion").focus(function(event) {
        carga_certificacion()
    });

    function selectEstudio(id, nombre, tipo) {
        $("#frm_estudios_hvida").append('<div class="form-group" id="frm_group' + id + '">' + '<label for="pkID_estudio_' + id + '" class="control-label" style="margin-right: 20px;">' + tipo + '</label>' + '<input type="text" style="width: 90%;display: inline;" class="form-control" id="pkID_estudio_' + id + '" name="pkID_estudio" value="' + nombre + '" readonly="true"> <button name="btn_actionRmEstudio" data-id-estudio="' + id + '" data-id-frm-group="frm_group' + id + '" type="button" class="btn btn-danger"><span class="fa fa-remove"></span></button>' + '</div>');
        $("[name*='btn_actionRmEstudio']").click(function(event) {
            console.log('click remover estudio ' + $(this).data('id-frm-group'));
            removeEstudio($(this).data('id-frm-group'));
            //buscar el indice
            var idEstudio = $(this).attr("data-id-estudio");
            console.log('el elemento es:' + idEstudio);
            var indexArr = arrEstudios.indexOf(idEstudio);
            console.log("El indice encontrado es:" + indexArr);
            //quitar del array
            if (indexArr >= 0) {
                arrEstudios.splice(indexArr, 1);
                console.log(arrEstudios);
            } else {
                console.log('salio menor a 0');
                console.log(arrEstudios);
            }
        });
        //construye array de estudios
        arrEstudios.push(id);
        console.log(arrEstudios);
    };
    //FINALIZACION DE BLOQUE DE FUNCIONES DE ESTUDIO
});