(function($) {
    $.fn.validaArchivo = function(name_file, nom_modulo, name_url) {
        this.change(function(event) {
            /* Act on the event */
            var max_file = (1024 * 1024) * 500;
            //obtenemos un array con los datos del archivo
            var file = $("#form_" + nom_modulo + " [name='" + name_file + "']")[0].files[0];
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
            //$("#url_archivo").val(fileName);
            //$("#form_"+nom_modulo)[0][name_url].value = fileName;
            //console.log("Archivo para subir: "+fileName+", peso total: "+fileSize+" de tipo:"+fileType);
            var array_tipos = ["application/vnd.oasis.opendocument.text", "application/msword", "application/pdf", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-excel", "image/jpeg", "image/png", "application/x-rar", ""];

            function validaTipo() {
                for (var i = 0; i < array_tipos.length; i++) {
                    //console.log(array_tipos[i]);
                    var valor = false;
                    if (array_tipos[i] == fileType) {
                        //return true;
                        console.log('coincidio.')
                        valor = true;
                        break;
                    } else {
                        //return false;
                        console.log('no coincidio.')
                        valor = false;
                    };
                };
                return valor;
            };
            //console.log(validaTipo());
            /**/
            if (validaTipo()) {
                //$("#ruta").val(fileName);
                $("#form_" + nom_modulo)[0][name_url].value = fileName;
                console.log("Archivo para subir: " + fileName + ", peso total: " + fileSize + " de tipo:" + fileType);
                $(".alert").html("Archivo para subir: " + fileName + ", peso total: " + fileSize + " de tipo:" + fileType);
            } else {
                alert("El archivo supera el tamaño límite o no es de tipo permitido.");
                //$("[name='archivo']").val("");
                $("#form_" + nom_modulo)[0][name_url].value = "";
                console.log("Archivo para subir: " + fileName + ", peso total: " + fileSize + " de tipo:" + fileType);
                $(".alert").html("Archivo para subir: " + fileName + ", peso total: " + fileSize + " de tipo:" + fileType);
            };
        });
        //validando que se este ejecutando el plugin
        console.log('ejecutando validaArchivo con ' + this.selector);
        //console.log(this.selector);        
    };
}(jQuery));