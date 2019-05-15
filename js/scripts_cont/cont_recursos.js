$(function() {
    //console.log('Hola desde recursos')
    //-----------------------------------------
    //form_entidad
    uppercaseForm("form_proceso");
    uppercaseForm("form_entidad");
    //-----------------------------------------
    //---------------------------------------------------------------
    //variable para el objeto del formulario
    var objt_f_proceso = {};
    //variable de accion del boton del formulario
    var action = "";
    //variable para el id del registro
    var id_proceso = "";
    var options_format = {
        symbol: "$",
        decimal: ",",
        thousand: ".",
        precision: 0,
        format: "%s%v"
    };
    //---------------------------------------------------------------
    //funciones principales
    //calendario para las fechas
    for (i = 0; i <= 9; i++) {
        $("#fecha" + i).datepicker({
            dateFormat: "yy-mm-dd"
        });
    }

    function valida_action(action) {
        if (action === "crear") {
            crea_contrato();
            //subida_foto();
        } else if (action === "editar") {
            edita_contrato();
        } else if (action === "crea_empleado") {
            crea_empleado();
        } else if (action === "crea_cargo") {
            crea_cargo();
        };
    };
    //Crea empleado 
    function crea_empleado() {
        //Valida el formulario
        objt_f_empleado = $("#form_empleados").valida();
        console.log(objt_f_empleado);
        if (objt_f_empleado.estado == true) {
            $.ajax({
                url: "../controller/ajaxController12.php",
                data: objt_f_empleado.srlz + "&tipo=inserta&nom_tabla=hoja_vida",
            }).done(function(data) {
                alert(data[0].mensaje);
                console.log(data);
                $("#form_empleados")[0].reset();
                $("#form_modal_empleados").modal('hide');
            }).fail(function(data) {
                console.log(data);
                //alert(data[0].mensaje);          
            }).always(function() {
                console.log("complete");
            });
        } else {
            alert("El formulario no está totalmente diligenciado, revíselo e inténtelo de nuevo.");
        };
    }
    //Crea cargo 
    function crea_cargo() {
        //Valida el formulario
        objt_f_cargo = $("#form_cargos").valida();
        console.log(objt_f_cargo);
        if (objt_f_cargo.estado == true) {
            $.ajax({
                url: "../controller/ajaxController12.php",
                data: objt_f_cargo.srlz + "&tipo=inserta&nom_tabla=cargo",
            }).done(function(data) {
                alert(data[0].mensaje);
                console.log(data);
                $("#form_cargos")[0].reset();
                $("#form_modal_cargos").modal('hide');
            }).fail(function(data) {
                console.log(data);
                //alert(data[0].mensaje);          
            }).always(function() {
                console.log("complete");
            });
        } else {
            alert("El formulario no está totalmente diligenciado, revíselo e inténtelo de nuevo.");
        };
    }
    //Recarga el select cuando se cambia
    $("#fkID_empleado").focus(function(event) {
        carga_empleado();
    });
    //Recarga el select cuando se cambia
    $("#fkID_cargo").focus(function(event) {
        carga_cargo();
    });
    //Carga el select de empleados
    function carga_empleado() {
        var consulta_empleados = "select *,CONCAT(nombre,' ',apellido) AS nombres FROM `hoja_vida` ORDER BY nombres";
        //---------------------------------------------------------------
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + consulta_empleados + "&tipo=consulta_gen",
        }).done(function(data) {
            /**/
            $("#fkID_empleado").html('')
            console.log(data)
            if (data.mensaje != "No hay registros.") {
                $("#fkID_empleado").append('<option></option>')
                $.each(data.mensaje, function(index, val) {
                    /* iterate through array or object */
                    console.log(index + "--" + val)
                    console.log(val)
                    $("#fkID_empleado").append('<option value="' + val.pkID + '" data-fkID-empleado="' + val.nombres + '"">' + val.nombres + '</option>')
                });
                $("#fkID_empleado").click();
            };
            //$( "#fkID_categoria" ).load( "formatos.php option");
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    }
    //Carga el select de cargos
    function carga_cargo() {
        var consulta_cargos = "SELECT * FROM cargo ORDER BY nombre";
        //---------------------------------------------------------------
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + consulta_cargos + "&tipo=consulta_gen",
        }).done(function(data) {
            /**/
            $("#fkID_cargo").html('')
            console.log(data)
            if (data.mensaje != "No hay registros.") {
                $("#fkID_cargo").append('<option></option>')
                $.each(data.mensaje, function(index, val) {
                    /* iterate through array or object */
                    console.log(index + "--" + val)
                    console.log(val)
                    $("#fkID_cargo").append('<option value="' + val.pkID + '" data-fkID-cargo="' + val.nombre + '"">' + val.nombre + '</option>')
                });
                $("#fkID_cargo").click();
            };
            //$( "#fkID_categoria" ).load( "formatos.php option");
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    }
    //-------------------------------------------------------------------------------------------
    function subida_archivo() {
        //---------------------------------------------------------------------------------------
        //CREA UNA VARIABLE  DE TIPO FormData que toma el formulario
        var formData = new FormData($("#form_proceso")[0]);
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
            beforeSend: function() {
                console.log("Subiendo archivo, por favor espere...");
            },
            //una vez finalizado correctamente
            success: function(data) {
                console.log(data);
            },
            //si ha ocurrido un error
            error: function() {
                console.log("Ha ocurrido un error.");
            }
        });
        //---------------------------------------------------------------------------------------
    }; //cierra función subida*/
    function validaArchivo() {
        //obtenemos un array con los datos del archivo
        var file = $("[name='archivo']")[0].files[0];
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
        $("#url_propuesta").val(fileName);
        console.log("Archivo para subir: " + fileName + ", peso total: " + fileSize + " de tipo:" + fileType);
        var sizeMax = (1024 * 1024) * 5;
        if (fileSize > sizeMax) {
            alert("El archivo que trata de cargar supera los " + sizeMax + " bits, por favor cargue un archivo más pequeño.");
            $("#url_propuesta").val("");
            $("#archivo").val("");
        } else {};
    }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //objeto que definira que se va ingresar dentro de la tabla pasos
    var date;
    date = new Date();
    date = date.getFullYear() + '-' + ('00' + (date.getMonth() + 1)).slice(-2) + '-' + ('00' + date.getDate()).slice(-2);
    console.log(date);
    //------------------------------------------------
    //leer cookies con js document.cookie
    //poner en el helper global
    function leerCookie(nombre) {
        var lista = document.cookie.split(";");
        for (i in lista) {
            var busca = lista[i].search(nombre);
            if (busca > -1) {
                micookie = lista[i]
            }
        }
        var igual = micookie.indexOf("=");
        var valor = micookie.substring(igual + 1);
        return valor;
    };
    console.log(leerCookie("log_lunelAdmin_id"));
    var paso = {
        "fecha": date,
        "actual": 1,
        "pkID_proceso": "-",
        "idPaso1": "0",
        "idPaso2": $("#fkID_paso_actual").val(),
        "pkID_usuario": leerCookie("log_lunelAdmin_id"),
        "pkID_usuario_asignado": leerCookie("log_lunelAdmin_id")
    };
    var email = {
        "pkID_usuario": '',
        "tipo_asunto": '',
        "tipo_cuerpo": '',
        "pkID_proceso": '',
        "enviar": false
    };
    //crear otro objeto email para el correo al reasignado
    var email_reasigna = {
        "pkID_usuario": '',
        "tipo_asunto": '',
        "tipo_cuerpo": '',
        "pkID_proceso": '',
        "enviar": false
    };
    //funcion para crear paso segun el last_id al crear el proceso
    //depende del cambio del paso la insersion de este registro
    $("#fkID_paso_actual").change(function(event) {
        /* Act on the event */
        /*los valores del paso actual hacen variar el objeto paso
        si el paso es de valor 1 creado
        ->queda como esta definido
        si es de valor 2 aprobado
        ->consultar los pasos que existan para el proceso con el
        ID que corresponda, encontrar el mas reciente y actualizar
        el campo actual a 0, el resto de datos es para reemplazar 
        en el objeto paso.
        */
        //como quitar el actual del registro anterior???
        id_proceso = $("#pkID").val();
        //console.log($(this).val());
        /**/
        if ($(this).val() == "4") {
            //validar si este paso ha sido aprobado previamente
            valida_last_paso(id_proceso);
            //console.log('asignar a quien?')
            //cons_users(id_proceso);			
            //MOSTRAR EL SELECT CON LOS USUARIOS
            //AL SELECCIONAR UN USUARIO CAMBIAR EL VALOR DEL paso
            //pkID_usuario_asignado al que se seleccionó aca
            //enviar de la misma forma
            //enviar correo a persona asignada informado que ha
            //sido asignado como responsable de este proceso.		
        } else if ($(this).val() == "0") {} else {
            cons_last_paso(id_proceso);
            //pregunta si el paso es aprobado 2
            //ejecuta el envio de correo a usuario asignado que aparezaca
            //en la tabla de paso y que sea el paso actual informando
            //informando que el proceso ha sido aprobado
            if ($(this).val() == "2") {
                email.enviar = true;
                email.tipo_asunto = 1;
                email.tipo_cuerpo = 'aprobado';
                email.pkID_proceso = id_proceso;
            } else {
                email.enviar = false;
            };
        };
        //----------------------------------------------------------------
        //valida si existe div_asigna_usuario para desaparecerlo
        if ($("#div_asigna_usuario").length > 0) {
            $("#div_asigna_usuario").hide('slow');
        }
    });
    //enviar por ajax a la funcion de insertar, dependiendo del valor del
    //campo fkID_paso_actual cambia los valores del objeto
    console.log(paso);

    function valida_last_paso(id_proceso) {
        var consulta_paso = "select * from pasos where pkID_proceso = " + id_proceso + " ORDER BY pkID DESC LIMIT 1";
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + consulta_paso + "&tipo=consulta_gen&nom_tabla=pasos",
        }).done(function(data) {
            /*muestra data actual*/
            console.log(data);
            var paso_reciente = data.mensaje[0].idPaso2;
            //cons_users(id_proceso);
            if (paso_reciente != 1) {
                console.log('asignar a quien?');
                cons_users(id_proceso);
            } else {
                alert("No es posible asignar un usuario cuando el estado del proceso es 'creado'.");
                $("#fkID_paso_actual").val('1');
            };
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
        /*---------------------------------------------------*/
    }

    function crea_paso(paso_param) {
        //--------------------------------------
        $.ajax({
            url: "../controller/ajaxController12.php",
            data: paso_param + "&tipo=inserta&nom_tabla=pasos",
        }).done(function(data) {
            //---------------------
            console.log(data);
            console.log('Data de la creacion del paso.');
            //alert(data[0].mensaje);
            //location.reload();
        }).fail(function(data) {
            console.log(data);
        }).always(function() {
            console.log("complete crea_paso");
        });
    };
    //cierra crea_paso
    function cons_last_paso(id_proceso) {
        /*---------------------------------------------------*/
        var consulta_paso = "select * from pasos where pkID_proceso = " + id_proceso + " ORDER BY pkID DESC LIMIT 1";
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + consulta_paso + "&tipo=consulta_gen&nom_tabla=pasos",
        }).done(function(data) {
            /*muestra data actual*/
            console.log(data);
            /*actualiza el registro actual----------------------------*/
            update_last_paso(data.mensaje[0].pkID);
            update_last_paso_proceso(id_proceso, $("#fkID_paso_actual").val());
            /*asigna los valores al paso nuevo*/
            paso.idPaso1 = data.mensaje[0].idPaso2;
            paso.idPaso2 = $("#fkID_paso_actual").val();
            paso.pkID_proceso = data.mensaje[0].pkID_proceso;
            console.log("Usuario asignado: " + data.mensaje[0].pkID_usuario_asignado);
            //el usuario asignado segun la consulta a el paso actual
            //paso.pkID_usuario_asignado = data.mensaje[0].pkID_usuario_asignado;
            if ($("#fkID_paso_actual").val() != 4) {
                //si es diferente de asignado el usuario asignado es el de
                //la consulta del ultimo paso
                paso.pkID_usuario_asignado = data.mensaje[0].pkID_usuario_asignado;
                //-----------------------------------------------------------------
                email_reasigna.enviar = false;
            } else {
                //crear la variable de asignacion de correo
                //con los valores de last paso
                email_reasigna.pkID_usuario = data.mensaje[0].pkID_usuario_asignado;
                email_reasigna.enviar = true;
                email_reasigna.tipo_asunto = 4;
                email_reasigna.tipo_cuerpo = 'reasignado';
                email_reasigna.pkID_proceso = id_proceso;
                console.log(email_reasigna);
            };
            var paso_srlz = $.param(paso);
            console.log(paso_srlz);
            crea_paso(paso_srlz);
            //enviar correo a persona que aparece en este paso
            if ((email.enviar == true) && (email.tipo_asunto == 1)) {
                enviaCorreoResponsable(data.mensaje[0].pkID_usuario_asignado, email.tipo_asunto, email.tipo_cuerpo, email.pkID_proceso);
            };
            if ((email_reasigna.enviar == true) && (email_reasigna.tipo_asunto == 4)) {
                enviaCorreoResponsable(email_reasigna.pkID_usuario, email_reasigna.tipo_asunto, email_reasigna.tipo_cuerpo, email_reasigna.pkID_proceso);
            };
            console.log('paso creado y actualizado.');
            //----------------------------------------------------------
            //alert("El paso ha sido actualizado.");
            $("#not_proceso_email").append('<br> El paso ha sido actualizado.');
            //location.reload();
            if (email.enviar != true) {
                //location.reload();
            };
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
        /*---------------------------------------------------*/
    }

    function enviaCorreoResponsable(pkID_usuario, asunto, tipo_cuerpo, pkID_proceso) {
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "pkID_usuario=" + pkID_usuario + "&tipo_asunto=" + asunto + "&tipo_cuerpo=" + tipo_cuerpo + "&pkID_proceso=" + pkID_proceso + "&tipo=email",
            beforeSend: function() {
                //$("#pkID_usuario_asignado").attr('disabled', 'true');
                //$("#not_apruebaAsigna").append("<br> Enviando correo "+tipo_cuerpo+", por favor espere...");
                $("#btn_actionproceso").attr('disabled', 'true');
                $("#not_proceso_email").html('<strong>Atención! por favor espere un momento</strong>, creando proceso y enviando correos correspondientes.');
            }
        }).done(function(data) {
            console.log(data);
            //alert(data.mensaje.mensaje);
            $("#not_proceso_email").append('<br>' + data.mensaje.mensaje);
            //location.reload();
            setTimeout(function() {
                location.reload();
            }, 2000)
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
        /*---------------------------------------------------*/
    }

    function update_last_paso(id_paso) {
        /*---------------------------------------------------*/
        var update_paso = "UPDATE `pasos` SET `actual` = '0' WHERE `pasos`.`pkID` =" + id_paso;
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + update_paso + "&tipo=consulta_gen&nom_tabla=pasos",
        }).done(function(data) {
            console.log(data);
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
        /*---------------------------------------------------*/
    }

    function update_last_paso_proceso(id_proceso, id_paso) {
        /*---------------------------------------------------*/
        var update_paso_proceso = "UPDATE `recursos` SET `fkID_paso_actual` = '" + id_paso + "' WHERE `recursos`.`pkID` = " + id_proceso;
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + update_paso_proceso + "&tipo=consulta_gen&nom_tabla=recursos",
        }).done(function(data) {
            console.log(data);
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
        /*---------------------------------------------------*/
    }

    function cons_users(id_proceso) {
        /*---------------------------------------------------*/
        var query_users = "SELECT * FROM `usuarios` where (email != '') AND (email IS NOT NULL) ";
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + query_users + "&tipo=consulta_gen&nom_tabla=usuarios",
        }).done(function(data) {
            //console.log(data);
            if ($("#div_asigna_usuario").length > 0) {
                // Siempre será validado, incluso si #undiv no existe
                console.log('el asigna usuario ya existe!');
                $("#div_asigna_usuario").show('slow');
            } else {
                $("#div_paso_actual").after('<div id="div_asigna_usuario" class="form-group">' + '<label for="pkID_usuario_asignado" class="control-label">Asignar Usuario</label>' + '<select name="pkID_usuario_asignado" id="pkID_usuario_asignado" class="form-control add-selectElement">' + '<option></option>' + '</select>' + '</div>');
                crea_select_users(data, id_proceso);
            }
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
        /*---------------------------------------------------*/
    }

    function crea_select_users(data, id_proceso) {
        /*
		$.each(data.mensaje[0], function( key, value ) {
          console.log(key+"--"+value);
          //$("#"+key).val(value);
        });*/
        for (var i = 0; i < data.mensaje.length; i++) {
            //console.log('metiendo usuarios...')
            //filtrar que no se pueda seleccionar el 
            //mismo usuario logueado
            if (leerCookie("log_lunelAdmin_id") == data.mensaje[i].pkID) {} else {
                $("#pkID_usuario_asignado").append('<option value="' + data.mensaje[i].pkID + '">' + data.mensaje[i].alias + ' -- ' + data.mensaje[i].nombre + ' ' + data.mensaje[i].apellido + '</option>');
            }
        };
        $("#pkID_usuario_asignado").change(function(event) {
            /* Act on the event */
            paso.pkID_usuario_asignado = $(this).val();
            console.log(paso);
            cons_last_paso(id_proceso);
            //envia correo de que ha sido asignado
            email.enviar = true;
            email.tipo_asunto = 3;
            email.tipo_cuerpo = 'asignado';
            email.pkID_proceso = id_proceso;
            email.pkID_usuario = $(this).val();
            if (email.enviar == true) {
                enviaCorreoResponsable(email.pkID_usuario, email.tipo_asunto, email.tipo_cuerpo, email.pkID_proceso);
            };
        });
        //definir el on change del select de usuario	
    }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    function crea_contrato() {
        //--------------------------------------	      
        //crea el objeto formulario serializado
        objt_f_contrato = $("#form_contrato").valida();
        console.log(objt_f_contrato);
        //--------------------------------------
        /**/
        //subida_archivo();
        if (objt_f_contrato.estado == true) {
            $.ajax({
                url: "../controller/ajaxController12.php",
                data: objt_f_contrato.srlz + "&tipo=inserta&nom_tabla=contratos",
            }).done(function(data) {
                //Guarda los documentos del empleado
                subida_archivo2(data[0].last_id);
                alert(data[0].mensaje);
                console.log(data);
                $("#form_contrato")[0].reset();
                location.reload();
            }).fail(function(data) {
                console.log(data);
            }).always(function() {
                console.log("complete");
            });
        } else {
            alert("El formulario no está totalmente diligenciado, revíselo e inténtelo de nuevo.");
        };
    };
    //cierra crea	
    function carga_contrato(id_contrato) {
        console.log("Carga el contrato " + id_contrato);
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "pkID=" + id_contrato + "&tipo=consultar&nom_tabla=contratos",
        }).done(function(data) {
            $.each(data.mensaje[0], function(key, value) {
                console.log(key + "--" + value);
                $("#" + key).val(value);
                if (key == 'salario') {
                    $("#salario_mask").val(value);
                }
            });
            id_contrato = data.mensaje[0].pkID;
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    };
    //cierra carga_proceso
    function edita_contrato() {
        //--------------------------------------
        //crea el objeto formulario serializado
        objt_f_contrato = $("#form_contrato").valida();
        //--------------------------------------
        /**/
        //subida_archivo();
        if (objt_f_contrato.estado == true) {
            console.log(objt_f_contrato.srlz);
            $.ajax({
                url: '../controller/ajaxController12.php',
                data: objt_f_contrato.srlz + "&tipo=actualizar&nom_tabla=contratos",
            }).done(function(data) {
                //---------------------
                console.log(data);
                id_contrato = $("#pkID").val();
                subida_archivo2(id_contrato);
                alert(data.mensaje.mensaje);
                location.reload();
            }).fail(function() {
                console.log("error");
            }).always(function() {
                console.log("complete");
            });
        } else {
            alert("Faltan " + Object.keys(objt_f_contrato.objt).length + " campos por llenar.");
        }
        //------------------------------------------------------
    };
    //cierra funcion edita_contrato
    function elimina_contrato(id_contrato) {
        console.log('Eliminar el contrato: ' + id_contrato);
        var confirma = confirm("En realidad quiere eliminar este contrato?");
        console.log(confirma);
        /**/
        if (confirma == true) {
            //si confirma es true ejecuta ajax
            $.ajax({
                url: '../controller/ajaxController12.php',
                data: "pkID=" + id_contrato + "&tipo=eliminar&nom_tabla=contratos",
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
    //cierra funcion eliminar proceso
    //-------------------------------------------------------------------------------
    //ejecución
    //-------------------------------------------------------------------------------	
    /*
    Botón que carga el formulario para insertar
    */
    $("#btn_nuevoRecurso").click(function() {
        $("#lbl_form_proceso").html("Nuevo Contrato");
        $("#lbl_btn_actionproceso").html("Guardar <span class='glyphicon glyphicon-save'></span>");
        $("#btn_actionproceso").attr("data-action", "crear");
        $("#div_paso_actual").attr('hidden', 'true');
        $("#btn_actionproceso").removeAttr('disabled');
        $("#form_contrato")[0].reset();
        $("#form_documentos_empleado")[0].reset();
    });
    /*
    Botón que carga el formulario para editar
    */
    $("[name*='edita_proceso']").click(function(event) {
        $("#lbl_form_proceso").html("Edita Contrato");
        $("#lbl_btn_actionproceso").html("Actualizar <span class='glyphicon glyphicon-floppy-save'></span>");
        $("#btn_actionproceso").attr("data-action", "editar");
        $("#div_paso_actual").removeAttr('hidden');
        $("#btn_actionproceso").removeAttr('disabled');
        $("#form_contrato")[0].reset();
        $("#form_documentos_empleado")[0].reset();
        id_contrato = $(this).attr('data-id-contrato');
        carga_contrato(id_contrato);
        for (i = 1; i <= 7; i++) {
            cargaDoc(id_contrato, i);
        }
    });
    /*
    Botón que elimina registro
    */
    $("[name*='elimina_contrato']").click(function(event) {
        id_contrato = $(this).attr('data-id-contrato');
        elimina_contrato(id_contrato);
    });
    /*
    Botón de accion de formulario
    */
    $("#btn_actionproceso").click(function() {
        action = $(this).attr("data-action");
        valida_action(action);
        console.log("accion a ejecutar: " + action);
    });
    //Boton de accion para crear empleado
    $("#btn_actionempleados").click(function() {
        action = $(this).attr("data-action");
        valida_action(action);
        console.log("accion a ejecutar: " + action);
    });
    //Boton de accion para crear cargo
    $("#btn_actioncargos").click(function() {
        action = $(this).attr("data-action");
        valida_action(action);
        console.log("accion a ejecutar: " + action);
    });
    //---------------------------------------------------------------	
    //calendario para la fecha de cierre
    $("#fecha_cierre").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: 1
    });
    //---------------------------------------------------------------
    //mascara de dinero para salario	
    $('#salario_mask').mask('000.000.000.000.000', {
        reverse: true
    });

    function remplazar(texto, buscar, nuevo) {
        var temp = '';
        var long = texto.length;
        for (j = 0; j < long; j++) {
            if (texto[j] == buscar) {
                temp += nuevo;
            } else temp += texto[j];
        }
        return temp;
    }
    $('#salario_mask').change(function(event) {
        var val_salario = $(this).val();
        $('#salario').val(remplazar(val_salario, ".", ""))
    });
    //---------------------------------------------------------------
    $('#tbl_proceso').on('click', '.detail', function() {
        window.location.href = $(this).attr('href');
    });
    //---------------------------------------------------------------
    //Codigo para ver la url
    $("#url_propuesta").change(function(event) {
        /* Act on the event */
        var nom_link = $(this).val();
        nom_link = nom_link.replace(/https?:\/\//, '');
        console.log(nom_link)
        if (validaUrl($(this).val())) {
            $("#url_codigo").html('<a href="' + $(this).val() + '" target="_blank"> ir a ' + nom_link + ' </a>')
        } else {
            $("#url_codigo").html('Esto no es un link válido.')
            $("#url_propuesta").val('')
        };
    });
    //---------------------------------------------------------------
    //Expresiones regulares
    //http://chuwiki.chuidiang.org/index.php?title=Expresiones_regulares_en_javascript
    //http://notasjs.blogspot.com.co/2013/06/tutorial-de-expresiones-regulares-en.html
    //pagina de chuleta de expresiones regulares
    //http://www.regexr.com/
    /*
	var reg = /http:\/\/\w{2,}[.]\w{2,}/;
	var busca = "http://getbootstrap.com/css/#code".match(reg);
 	console.log(busca);*/
    function validaUrl(valor) {
        var reg = /https?:\/\/\w{2,}[.?]\w{2,}/g
        var busca = valor.match(reg);
        console.log(busca);
        if (busca) {
            return true;
        } else {
            return false;
        };
    }
    /*
    var pruebaurl = validaUrl("http://getbootstrap.com/css/#code");
    console.log(pruebaurl);*/
    //---------------------------------------------------------------
    //unsetear el elemento de las tablas
    sessionStorage.setItem("id_tab_proceso", null);
    //---------------------------------------------------------------
    //nombre en mayusculas de la entidad
    $("#nombre_entidad").keyup(function(event) {
        /* Act on the event */
        //console.log('escribiendo nombre entidad!')
        var nomEntidad = $(this).val();
        $(this).val(nomEntidad.toUpperCase());
    });
    //---------------------------------------------------------------
    //Nuevo empleado
    $("#btn_nuevoempleado").click(function(event) {
        //Pone el nombre en el label
        $("#lbl_form_empleados").html("Crea empleado");
        //Pone nombre al boton accion
        $("#lbl_btn_actionempleados").html("Crear <span class='glyphicon glyphicon-floppy-save'></span>");
        //Pone accion al boton
        $("#btn_actionempleados").attr("data-action", "crea_empleado");
        //cierra modal ingreso_gral
        $('#form_modal_recursos').modal('hide');
        $('#form_modal_empleados').modal('show');
        $('#form_modal_empleados').on('hidden.bs.modal', function(e) {
            $('#form_modal_recursos').modal('show');
        });
        $("#btn_actionempleados").removeAttr('disabled');
    });
    //Nuevo cargo
    $("#btn_nuevocargo").click(function(event) {
        //Pone el nombre en el label
        $("#lbl_form_cargos").html("Crea cargo");
        //Pone nombre al boton accion
        $("#lbl_btn_actioncargos").html("Crear <span class='glyphicon glyphicon-floppy-save'></span>");
        //Pone accion al boton
        $("#btn_actioncargos").attr("data-action", "crea_cargo");
        //cierra modal ingreso_gral
        $('#form_modal_recursos').modal('hide');
        $('#form_modal_cargos').on('hidden.bs.modal', function(e) {
            $('#form_modal_recursos').modal('show');
        });
        $("#btn_actioncargos").removeAttr('disabled');
    });
    //Envia peticion AJAX para subir archivo
    function subida_archivo2(idContrato) {
        //---------------------------------------------------------------------------------------
        //CREA UNA VARIABLE  DE TIPO FormData que toma el formulario
        var formData = new FormData($("#form_documentos_empleado")[0]);
        //la ruta del php que ejecuta ajax
        var ruta = "../subida_archivo/url_recursos.php";
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
                objeto = JSON.parse(data);
                j = 1;
                for (i = 0; i < 7; i++) {
                    fecha = $("#fecha" + j).val();
                    console.log(empleado);
                    console.log(objeto[i]["contador"]);
                    console.log(fecha);
                    console.log(objeto[i]["nombre"]);
                    if (objeto[i]["nombre"] != '') {
                        cadena = "fkID_contrato=" + idContrato + "&fkID_documento=" + objeto[i]["contador"] + "&fechaDocumento=" + fecha + "&ruta=" + objeto[i]["nombre"];
                        registraArchivo(cadena);
                    }
                    j++;
                }
                /*$.ajax({
                    url: "../controller/ajaxController12.php",
                    data: "fkID_empleado=" + empleado + "&fkID_documento=" + i + "&fecha=" + fecha + "&tipo=inserta&nom_tabla=documentos_empleado",
                }).done(function(data) {});*/
            },
            //si ha ocurrido un error
            error: function() {
                console.log("Ha ocurrido un error.");
            }
        });
        //---------------------------------------------------------------------------------------
    }; //cierra función subida*/
    function registraArchivo(cadena) {
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: cadena + "&tipo=inserta&nom_tabla=documentos_empleado",
        }).done(function(data) {
            console.log(data);
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    };
    //cierra funcion eliminar proceso
    function cargaDoc(idContrato, tipo) {
        var query_archivos = "select *,documentos_empleado.pkID as ID FROM `lista_documentos` LEFT JOIN documentos_empleado ON documentos_empleado.fkID_documento = lista_documentos.pkID WHERE fkID_contrato=" + idContrato + " and fkID_documento=" + tipo;
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "query=" + query_archivos + "&tipo=consulta_gen",
        }).done(function(data) {
            console.log(data);
            $("#archivos_res" + tipo).html("");
            if (data.estado != "Error") {
                //arrEstudios.length=0;
                for (var i = 0; i < data.mensaje.length; i++) {
                    if (data.mensaje[i].ruta) {
                        $("#archivos_res" + tipo).append('<div class="form-group" id="frm_group' + data.mensaje[i].ID + '">' + '<input type="text" style="width: 90%;display: inline;" class="form-control" id="pkID_archivo_' + data.mensaje[i].ID + '" name="btn_RmArchivo[]" value="' + data.mensaje[i].ruta + '" readonly="true"> <a id="btn_doc" title="Descargar Archivo" name="download_documento" type="button" class="btn btn-success" href = "../server/php/files/' + data.mensaje[i].ruta + '" target="_blank" ><span class="glyphicon glyphicon-download-alt"></span></a><button name="btn_actionRmArchivo" data-id-documento="' + data.mensaje[i].ID + '" data-id-tipo="' + data.mensaje[i].fkID_documento + '" type="button" class="btn btn-danger"><span class="fa fa-remove"></span></button>' + '</div>' + '<div class="form-group">' + '<label class="control-label">Fecha:</label>' + '<p style="width: 90%;display: inline;" > ' + data.mensaje[i].fecha + '</p> <br>' + '</div>');
                        $("[name*='btn_actionRmArchivo']").click(function(event) {
                            // Act on the event 
                            var id_documento = $(this).attr('data-id-documento');
                            var tipo = $(this).attr('data-id-tipo');
                            elimina_documento(id_documento, tipo);
                        });
                    }
                }
            }
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    }

    function elimina_documento(id_documento, tipo) {
        console.log('Eliminar el documento: ' + id_documento);
        var confirma = confirm("En realidad quiere eliminar este documento?");
        console.log(confirma);
        /**/
        if (confirma == true) {
            //si confirma es true ejecuta ajax
            $.ajax({
                url: '../controller/ajaxController12.php',
                data: "pkID=" + id_documento + "&tipo=eliminar&nom_tabla=documentos_empleado",
            }).done(function(data) {
                //---------------------
                console.log(data);
                $("#archivos_res" + tipo).html("");
            }).fail(function() {
                console.log("error");
            }).always(function() {
                console.log("complete");
            });
        }
    };
});