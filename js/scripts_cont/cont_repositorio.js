$(function(){
	 

  //---------------------------------------------------------
	 
	 $('#btn_nuevorepositorio').jquery_controllerV2({
	 	nom_modulo:'repositorio',
  		titulo_label:'Nuevo Repositorio',
  		ejecutarFunction:true,
      functionBefore:function(ajustes){            

      $("#btn_actionrepositorio").removeAttr('disabled');
      //--------------------------------------------------
        //--------------------------------------------------
        //evento click del checkbox tipo_acceso
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
        $("#chk_tipoacceso").val('1');
      } else{
        $("#chk_tipoacceso").val('0');
      };
    }


    //-----------------------------------------------------
	 
	 $('#btn_actionrepositorio').jquery_controllerV2({
		tipo:'inserta/edita',
  		nom_modulo:'repositorio',
  		nom_tabla:'repositorio',
        //subida : true,
  		recarga:false,
        ejecutarFunction:true,
        functionResEditar:function(){
        //console.log(data)       
        //editar indicadores
        //console.log($("#btn_actionproceso").attr('data-action'))
        //indicadores.indicador_proc($("#form_indicadores_proceso"),id_proceso,$("#btn_actionproceso").attr('data-action'));            
            //--------------------------------------------------
            location.reload();            
        },
        functionResCrear:function(data){
            //console.log('El ultimo creado fue: '+ajustes.id_resCrear);
            console.log(data);
            console.log('Ejecutando luego de Insertar!!!');
            location.reload();

            $("#btn_actionrepositorio").attr('disabled', 'true');

        },
        functionBefore:function(ajustes){
          console.log('Ejecutando antes de hacer cualquier cosa');
          
        } 
    }); 

	 //---------------------------------------------------
	  //Valida el archivo
	  $("#archivo").validaArchivo('archivo','repositorio','url_archivo');
	  //---------------------------------------------------

  //Validacion de campo nombre 1ra en mayuscula
   uppercaseForm("form_repositorio");
	 //-------------------------------------------


	 $("[name*='edita_repositorio']").jquery_controllerV2({
		tipo:'carga_editar',
  		nom_modulo:'repositorio',
  		nom_tabla:'repositorio',
  		titulo_label:'Edita Repositorio',
  		tipo_load:1,
  		ejecutarFunction:true,
        functionBefore:function(ajustes){                
            console.log('Ejecutando antes de cualquier cosa!!!');
        },
        functionResCarga:function(id,data){
            //console.log('El eliminar registro: '+ajustes.id_resCrear);
            console.log('Ejecutando luego de Cargar!!!');

            //setea paso a pasos_objt
            
            //--------------------------------------------------
        //carga el estado segun sea el paso actual
        //console.log($("#fkID_paso_actual").val());
        //--------------------------------------------------

          //-----------------------------------------------
          //---------------------------------
        $("#btn_actionrepositorio").removeAttr('disabled');
        //$("#btn_nuevoobservacion").removeAttr('disabled');
        //-----------------------------------------------
        //luego de cargar validar el paso actual
        //si es 1 creado no muestra paso actual
        //si es 5 revision muestra 6 viable para presentar y 7 Descartar
        //si es 6 viable para presentar muestra 9 Entregado o No entregado
        //si es 9 Entregado o No entregado o 7 Descartar se esconde paso actual
    

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

        }

    });

	$("[name*='elimina_repositorio']").jquery_controllerV2({
  		tipo:'eliminar',
  		nom_modulo:'repositorio',
  		nom_tabla:'repositorio'
  	});

  	//---------------------------------------------------------------
	//Click en la grilla y va al detalle

	$('#tbl_repositorio').on( 'click', '.detail', function () {
	  window.location.href = $(this).attr('href');
	} );
	//---------------------------------------------------------------


});
