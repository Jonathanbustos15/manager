$(function() {
    //console.log('hola proyecto documentos');
    //---------------------------------------------------------
    //variable para el objeto del formulario
    var objt_f_certificacion = {};
    //variable de accion del boton del formulario
    var action = "";
    //variable para el id del registro
    var id_certificacion = "";
    //--------------------------------------------------------- 
    function valida_action(action) {
        if (action === "crear") {
            //crea_documento();
            subida_archivo("crear");
        } else if (action === "editar") {
            //edita_documento();
            subida_archivo("editar");
        };
    };
    //----------------------------------------------------------
    function subida_archivo(nom_funcion) {
        //---------------------------------------------------------------------------------------
        //CREA UNA VARIABLE  DE TIPO FormData que toma el formulario
        var formData = new FormData($("#form_certificados")[0]);
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
                $("#not_docs_empresa").html("Subiendo archivo, por favor espere...");
            },
            //una vez finalizado correctamente
            success: function(data) {
                console.log(data);
                //if (data.clase == 'alert alert-success') {
                $("#not_docs_empresa").html('Subido el archivo...');
                switch (nom_funcion) {
                    case "crear":
                        crea_certificacion();
                        break;
                    case "editar":
                        edita_certificacion();
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
    }; //cierra función subida*/
    function validaArchivo() {
        var max_file = (1024 * 1024) * 500;
        console.log(max_file);
        //obtenemos un array con los datos del archivo
        var file = $("[name='archivo']")[0].files[0];
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
        if ((fileSize <= max_file) && ((fileType == "application/vnd.oasis.opendocument.text") || (fileType == "application/msword") || (fileType == "application/pdf") || (fileType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") || (fileType == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") || (fileType == "application/vnd.ms-excel") || (fileType == "application/x-rar") || (fileType == ""))) {
            //Reemplaza los caracteres especiales por "_"
            fileName = fileName.replace(/ |%|-/g, "_");
            //Toma el id del indicador financiero
            id = $("#form_certificados [id='pkID']").val();
            //Concatena el nomnbre de archivo con el ID
            fileName = id + '_' + fileName;
            //Asigna al campo ruta el nombre completo a subir
            $(("#form_certificados [id='ruta']")).val(fileName);
            console.log("Archivo para subir: " + fileName + ", peso total: " + fileSize + " de tipo:" + fileType);
            $("#not_docs_empresa").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + 'Archivo para subir: ' + fileName + ', peso total: ' + fileSize + ' de tipo:' + fileType);
        } else {
            alert("El archivo supera el tamaño límite o no es de un tipo permitido.");
            $("[name='archivo']").val("");
            console.log("Archivo para subir: " + fileName + ", peso total: " + fileSize + " de tipo:" + fileType);
            $("#not_docs_empresa").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + 'El archivo supera el tamaño límite o no es de un tipo permitido. Archivo para subir: ' + fileName + ', peso total: ' + fileSize + ' de tipo:' + fileType);
        };
    }

    function crea_certificacion() {
        //--------------------------------------
        //crea el objeto formulario serializado
        objt_f_certificacion = $("#form_certificados").valida();
        //console.log(objt_f_adminPublicidad.srlz);
        //--------------------------------------
        /**/
        if (objt_f_certificacion.estado == true) {
            $.ajax({
                url: "../controller/ajaxController12.php",
                data: objt_f_certificacion.srlz + "&tipo=inserta&nom_tabla=certificacion_experiencia",
            }).done(function(data) {
                //---------------------
                console.log(data);
                //var pkID_documento = data[0].last_id;
                // insertaArchivo("pkID_hojaVida="+pkID_hojaVida+"&url_archivo="+val[0].name+"&des_archivo="+getValoresDesc(val[0].name);
                //$("#btn_actiondocumento").attr('enabled','enabled');
                alert(data[0].mensaje);
                location.reload();
            }).fail(function(data) {
                console.log(data);
                //alert(data[0].mensaje);          
            }).always(function() {
                console.log("complete");
            });
        } else {
            alert("El formulario no está totalmente diligenciado, revíselo e inténtelo de nuevo.");
        };
    };
    //cierra crea
    function elimina_certificacion(id_certificacion) {
        console.log('Eliminar la certificación: ' + id_certificacion);
        var confirma = confirm("En realidad quiere eliminar esta certificación?");
        console.log(confirma);
        /**/
        if (confirma == true) {
            //si confirma es true ejecuta ajax
            $.ajax({
                url: '../controller/ajaxController12.php',
                data: "pkID=" + id_certificacion + "&tipo=eliminar&nom_tabla=certificacion_experiencia",
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
    //cierra funcion eliminar documento
    function edita_certificacion() {
        //--------------------------------------
        //crea el objeto formulario serializado
        objt_f_certificacion = $("#form_certificados").valida();
        //--------------------------------------
        /**/
        if (objt_f_certificacion.estado == true) {
            console.log(objt_f_certificacion.srlz);
            $.ajax({
                url: '../controller/ajaxController12.php',
                data: objt_f_certificacion.srlz + "&tipo=actualizar&nom_tabla=certificacion_experiencia",
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
            alert("Faltan " + Object.keys(objt_f_certificacion.objt).length + " campos por llenar.");
        }
        //------------------------------------------------------
    };
    //cierra funcion edita_documento
    function carga_certificacion(id_certificacion) {
        var options_format = {
            symbol: "$",
            decimal: ",",
            thousand: ".",
            precision: 0,
            format: "%s%v"
        };
        console.log("Carga la certificación " + id_certificacion);
        $.ajax({
            url: '../controller/ajaxController12.php',
            data: "pkID=" + id_certificacion + "&tipo=consultar&nom_tabla=certificacion_experiencia",
        }).done(function(data) {
            /**/
            $.each(data.mensaje[0], function(key, value) {
                console.log(key + "--" + value);
                if (key == "valor") {
                    $("#" + key).val(value);
                    $("#" + key + "_mask").val(accounting.formatNumber(value, options_format));
                } else {
                    $("#" + key).val(value);
                };
            });
            id_certificacion = data.mensaje[0].pkID;
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    };
    //cierra carga_documento
    //-------------------------------------------------------------------------------
    /*
	Botón que carga el formulario para insertar
	*/
    $("#btn_nuevoCertificacion").click(function() {
        $("#lbl_form_certificacion").html("Nueva certificación");
        $("#lbl_btn_actioncertificacion").html("Guardar <span class='glyphicon glyphicon-save'></span>");
        $("#btn_actioncertificacion").attr("data-action", "crear");
        //$("#btn_actiondocumento").attr('disabled','disabled');
        //validaBtnGuardar();
        $("#form_certificados")[0].reset();
    });
    /*
    Botón que carga el formulario para editar
    */
    $("[name*='edita_certificacion']").click(function(event) {
        $("#lbl_form_certificacion").html("Editar Certificación");
        $("#lbl_btn_actioncertificacion").html("Guardar Cambios <span class='glyphicon glyphicon-pencil'></span>");
        $("#btn_actioncertificacion").attr("data-action", "editar");
        $("#form_certificados")[0].reset();
        id_certificacion = $(this).attr('data-id-certificacion');
        $("#btn_actioncertificacion").removeAttr('disabled');
        carga_certificacion(id_certificacion);
        //carga_propiedades(id_documento);
    });
    /*
    Botón que elimina registro
    */
    $("[name*='elimina_certificacion']").click(function(event) {
        id_certificacion = $(this).attr('data-id-certificacion');
        elimina_certificacion(id_certificacion);
    });
    /*
    Botón de accion de formulario
    */
    $("#btn_actioncertificacion").click(function() {
        /**/
        action = $(this).attr("data-action");
        valida_action(action);
        console.log("accion a ejecutar: " + action);
        //subida_archivo();
    });
    //valida el documento -------------------
    $("#archivo").change(function(event) {
        /* Act on the event */
        validaArchivo();
    });
    //---------------------------------------
    //-------------------------------------------------------------------------------
    //mostrar todos los li con attr role=presentation
    /*
    $('#myTabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    })*/
    var id_li_activo = sessionStorage.getItem("id_tab_empresa");
    //console.log($("[role=presentation]"));
    console.log(id_li_activo);
    if ((id_li_activo == "null") || (id_li_activo == null)) {
        $("#li_general").addClass('active');
        $("#general").addClass('active');
    } else {
        $("#" + id_li_activo).addClass('active');
        $('ul a[href="#' + id_li_activo.slice(3, 20) + '"]').tab('show');
        $("#" + id_li_activo.slice(3, 20)).addClass('active');
        //console.log( $('ul a[href="#'+id_li_activo.slice(3,20)+'"]') );
    }
    $("[role=presentation]").click(function(event) {
        /* Act on the event */
        id_li_activo = $(this)[0].id;
        console.log($(this)[0].id);
        // Store
        sessionStorage.setItem("id_tab_empresa", $(this)[0].id);
    });
    //-------------------------------------------------------------------------------
    $('#valor_mask').mask('000.000.000.000.000', {
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
    $('#valor_mask').change(function(event) {
        var val_valor = $(this).val();
        $('#valor').val(remplazar(val_valor, ".", ""))
    });
});