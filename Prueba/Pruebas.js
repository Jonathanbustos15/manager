<script type="text/javascript">
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
   nCampo.name = 'archivos[]';
//Establecemos el tipo de campo
   nCampo.type = 'file';
//Ahora creamos un link para poder eliminar un campo que ya no deseemos
   a = document.createElement('a');
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


function crea_hvida(nombre){

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



          //--------------------------------------
          //crea el objeto formulario serializado


          objt_f_hvida = $("#form_hvida").val();
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
              var nomb=nombre
              insertaArchivo("pkID_hojaVida="+pkID_hojaVida+"&url_archivo="+nomb+"&des_archivo="+archCoincide );
              var iteracion = $.each(arregloDeArchivos, function(index, val) {
                 
                 console.log('Subiendo archivo: '+val);

                 $('#form1').fileupload('send', {files:val})
                    .success(function (result, textStatus, jqXHR) {                 
                        console.log(result);
                        console.log(textStatus);
                        console.log(jqXHR);
                        getValoresDesc(val[0].name);
                        //insertaArchivo("pkID_hojaVida="+pkID_hojaVida+"&url_archivo="+nombre+"&des_archivo="+archCoincide );                       

                    })
                    .error(function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    })
                    .complete(function (result, textStatus, jqXHR) {
                        console.log(textStatus);
                    });

              });















</script>