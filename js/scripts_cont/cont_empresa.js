$(function(){
	

	$("#btn_nuevoEmpresa").jquery_controllerV2({
  		nom_modulo:'empresa',
  		titulo_label:'Nueva Empresa',
  		ejecutarFunction:true,
  		functionBefore:function(ajustes){            

  			//setea fecha de creacion
            //$("#fecha_creacion").val(date);
            //quita disabled al boton de accion
			$("#btn_actionempresa").removeAttr('disabled');
			//--------------------------------------------------
			/*$("#observaciones").removeAttr('readonly');
		  	$("#btn_nuevoobservacion").attr('disabled', 'true');		  	                       
		  	//--------------------------------------------------
		  	$("#div_tipo_proceso").removeAttr('hidden');

		  	//--------------------------------------------------
		  	$("#fkID_tipo").change(function(event) {
		  		tipo_proceso($(this).val())
		  	});*/
		  	//--------------------------------------------------
		  	//evento click del checkbox recurrente
		  	//si esta check muestra el campo de fecha revision 
		  	//de lo contrario no y borra el valor.
		  	$("#chk_recurrente").click(function(event) {
		  		//console.log($(this)[0]["checked"]);
		  		chk_rec($(this)[0]["checked"]);		  		
		  	});		  	
		  	//--------------------------------------------------
		  
		  	//--------------------------------------------------
        }
  	});

	function chk_rec(tipo){

		if (tipo == true) {
  			$("#div_fecha_revision").removeAttr('hidden');
  			$("#chk_recurrente").val('1');
  		} else{
  			$("#div_fecha_revision").attr('hidden','true');
  			$("#chk_recurrente").val('0');
  			$("#fecha_revision").val('');
  		};
	}

 

  	//---------------------------------------------------------------	
	
	//---------------------------------------------------------------

	//---------------------------------------------------------------
	//Click en la grilla y va al detalle

	$('#tbl_empresa').on( 'click', '.detail', function () {
	  window.location.href = $(this).attr('href');
	} );
	//---------------------------------------------------------------

	//---------------------------------------------------------------
	
	//---------------------------------------------------------------

	//---------------------------------------------------------------
	
	//---------------------------------------------------------------
	$("#btn_actionempresa").jquery_controllerV2({
  		tipo:'inserta/edita',
  		nom_modulo:'empresa',
  		nom_tabla:'empresa',
  		//recarga:true,
  		ejecutarFunction:true,
  		functionResEditar:function(){            
            //--------------------------------------------------
             console.log('Se editó registro: '+this.id_resCrear);
             console.log('Ejecutando luego de Editar!!!');
             location.reload();            
        },
        functionResCrear:function(data){
            //console.log('El ultimo creado fue: '+ajustes.id_resCrear);
            console.log(data);
            console.log('Ejecutando luego de Insertar!!!');
            //location.reload();

            $("#btn_actionempresa").attr('disabled', 'true');

            location.reload();

        },
         		 		  
  	});  	
	//---------------------------------------------------------------

	//---------------------------------------------------------------
	$("[name*='edita_empresa']").jquery_controllerV2({
		tipo:'carga_editar',
  		nom_modulo:'empresa',
  		nom_tabla:'empresa',
  		titulo_label:'Edita Empresa',
  		tipo_load:1,
  		ejecutarFunction:true,
  		functionResCarga:function(id,data){
            //console.log('El eliminar registro: '+ajustes.id_resCrear);
            console.log('Ejecutando luego de Cargar!!!');

            

	        //-----------------------------------------------
	        //---------------------------------
	  		//$("#observaciones").attr('readonly', 'true');
	  		$("#btn_actionempresa").removeAttr('disabled');
	  		//$("#btn_nuevoobservacion").removeAttr('disabled');
	  		//-----------------------------------------------
	  		//luego de cargar validar el paso actual
	  		//si es 1 creado no muestra paso actual
	  		//si es 5 revision muestra 6 viable para presentar y 7 Descartar
	  		//si es 6 viable para presentar muestra 9 Entregado o No entregado
	  		//si es 9 Entregado o No entregado o 7 Descartar se esconde paso actual

          	//pasos_objt.carga_paso();

          	//manifestacion de interes? fkID_tipo == 6??
          	/*if (data.mensaje[0].fkID_tipo == "6") {
          		//div_tipo_proceso
          		//div_fecha_apertura
          		$("#div_tipo_proceso").removeAttr('hidden')
          		$("#div_fecha_apertura").removeAttr('hidden')
          	}else{
          		$("#div_tipo_proceso").removeAttr('hidden')
          		$("#div_fecha_apertura").attr('hidden','true')
          	};
*/
          	//--------------------------------------------------
		  	/*$("#fkID_tipo").change(function(event) {
		  		tipo_proceso($(this).val())
		  	});*/	        	  	
	  		//--------------------------------------------------
	  		if (data.mensaje[0].recurrente == "1") {
	  			$("#chk_recurrente")[0]["checked"] = true;
	  			chk_rec(true)
	  		} else{
	  			$("#chk_recurrente")[0]["checked"] = false;
	  			chk_rec(false)
	  		};

	  		$("#chk_recurrente").click(function(event) {
		  		//console.log($(this)[0]["checked"]);
		  		chk_rec($(this)[0]["checked"]);		  		
		  	});
		  	//--------------------------------------------------

		  	
        }
	});



	$("[name*='elimina_empresa']").jquery_controllerV2({
  		tipo:'eliminar',
  		nom_modulo:'empresa',
  		nom_tabla:'empresa'
  	});
	//---------------------------------------------------------------

	//modal recarga, evita error de varias instanciaciones
	$("#form_modal_empresa").on('hidden.bs.modal', function (e) {	  
	  //resetea el change de paso actual para que al 
	  //cargar lo defina de nuevo
	  //$("#fkID_paso_actual").unbind("change");
	})

	//---------------------------------------------------------------
	//console.log(leerCookie("log_lunelAdmin_id"));
	//resetear el elemento de las tablas, esto se ejecuta al inicio
	sessionStorage.setItem("id_tab_empresa",null);
	//---------------------------------------------------------------


	//Arreglo que contiene ands
	var objt_cond = {
		'fechaFin':''
	};

	var fecha = '';

	function crea_consulta(){
		//----------------------------------------------------------
		console.log(objt_cond)
		
		var arr_cond = [];

		$.each(objt_cond, function(index, val) {
			 
			 console.log('index:'+index+' val:'+val);

			 if (val != '') {
			 	arr_cond.push('proyectos.'+index+'='+val);
			 };
		});

		console.log(arr_cond)
		//----------------------------------------------------------
		var cons_final = '';

		if (arr_cond.length > 1) {
			cons_final = arr_cond.join(' AND ');
		}else if (arr_cond.length == 0) {
			cons_final = '*';
		} else{
			cons_final = arr_cond.join();
		};

		console.log(cons_final)
		/**/
		location.href="empresa.php?filter="+cons_final;
		//----------------------------------------------------------
	}

	$("#fechas_filtro").change(function(event) {		
		fecha = $(this).val();
		console.log(fecha);
		//objt_cond.fecha_aprobacion = "'"+fecha+"'";
		objt_cond.fechaFin = fecha;

	});

	$("#btn_filtrar").click(function(event) {		
		crea_consulta();
	});

});