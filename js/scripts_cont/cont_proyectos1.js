$(function(){

	//---------------------------------------------------------
	//
	uppercaseForm("form_proyecto");
	uppercaseForm("form_entidad");
	//----------------------------------------------------------
	function leerCookie(nombre) {
		 //var micookie = {};
         var lista = document.cookie.split(";");
         for (i in lista) {
             var busca = lista[i].search(nombre);
             if (busca > -1) {micookie=lista[i]}
             }
         var igual = micookie.indexOf("=");
         var valor = micookie.substring(igual+1);
         return valor;
    };

    var tipo_usuario = leerCookie("log_lunelAdmin_IDtipo");

    console.log(tipo_usuario)

    validaUsersSelect(tipo_usuario);



    function validaUsersSelect(tipo){
    	if (tipo!="1") {
    		$("#select_users_proyecto").attr('hidden', 'true');
    		
    	}else{
    		$("#select_users_proyecto").removeAttr('hidden');
    		
    	};
    }
    //----------------------------------------------------------

	var options_format = {
		symbol : "$",
		decimal : ",",
		thousand: ".",
		precision : 0,
		format: "%s%v"
	};

	var idUsuario = 0;
	var nomUsuario = "";	

	var arrUsuarios = [];
	var arrUsuariosProyectos = [];

	var idProyecto_last = '';


	$("#btn_nuevoproyecto").jquery_controllerV2({
  		nom_modulo:'proyecto',
  		titulo_label:'Nuevo Proyecto',
  		ejecutarFunction:true,
  		functionBefore:function(ajustes){
  			//console.log(ajustes)
			$("#btn_actionproyecto").removeAttr('disabled');
			$("#frm_usuarios_proyecto").html("");
		    $("#fkID_usuario").data('accion', 'select');
		    //--------------------------------------------------
		  	$("#div-observaciones").attr('hidden', 'true');
		  	//--------------------------------------------------
  		}
  	}); 	


  	$("#btn_actionproyecto").jquery_controllerV2({
  		tipo:'inserta/edita',
  		nom_modulo:'proyecto',
  		nom_tabla:'proyectos',
  		recarga:false, 
  		ejecutarFunction:true,
  		functionResCrear:function(){
            console.log('El id creado <es></es>: '+this.id_resCrear);
            //console.log('Ejecutando luego de Insertar!!!');
            idProyecto_last = this.id_resCrear;

            serializa_array(crea_array(arrUsuarios,idProyecto_last))            
        },
        functionResEditar:function(){
            console.log('Se editó registro: '+this.id_resCrear);
            console.log('Ejecutando luego de Editar!!!');
            location.reload();                
        },
        functionBefore:function(ajustes){
        	console.log('Ejecutando antes de hacer cualquier cosa');
        	//setea el campo de observaciones
        	if (ajustes.action != "editar") {
        		$("#observaciones").val( date+" : Creado. -- " );
        	};        	
        }  		 		  
  	});
  
  	
  	//-----------------------------------------------------------------------------------

  	function crea_array(array,id_proyecto){

      array.forEach(function(element, index){
      	//statements
      	var obtHE = {"fkID_usuario":element,"fkID_proyecto":id_proyecto};
      	arrUsuariosProyectos.push(obtHE);
      });

      //console.log(arrUsuariosProyectos);

      return arrUsuariosProyectos;
  	}


  	function serializa_array(array){

  		var cadenaSerializa = "";

  		$.each(array, function(index, val) {

  			var dataCadena = "";

  			$.each(val, function(llave, valor) {
		 	          	 
			 	console.log("llave="+llave+" valor="+valor);

			 	dataCadena = dataCadena+llave+"="+valor+"&";	          	 	 	          	 	
			 	//insertaEstudio(cadenaSerializa);
			});

			dataCadena = dataCadena.substring(0,dataCadena.length - 1);

			console.log(dataCadena);
			
			insertaUsuProy(dataCadena)	

  		});

  		console.log('Se terminó de insertar los usuarios!')
  		
  		//alert("Guardado correctamente!");
  		if ($("#fkID_usuario").attr('data-accion')=='load') {
  			// statement
  			alert("Se ha agregado el usuario correctamente.")
  			location.reload();
  		} else {
  			// statement
  			location.reload();	
  		}  		

  	}

  	function insertaUsuProy(data){		

		$.ajax({
	          url: "../controller/ajaxController12.php",
	          data: data+"&tipo=inserta&nom_tabla=proyectos_usuarios",
	        })
	        .done(function(data) {	          
	          //---------------------
	          console.log(data);
	          //alert(data[0].mensaje);
	          //location.reload();          
	        })
	        .fail(function(data) {
	          console.log(data);
	          //alert(data[0].mensaje);          
	        })
	        .always(function() {
	          console.log("complete");
	        });
	}
  	          
  	//-----------------------------------------------------------------------------------

  	$("[name*='edita_proyecto']").jquery_controllerV2({
		tipo:'carga_editar',
  		nom_modulo:'proyecto',
  		nom_tabla:'proyectos',
  		titulo_label:'Editar Proyecto',
  		tipo_load:1,
  		ejecutarFunction:true,
  		functionResCarga:function(id,data){            
  			
            $('#subtotal_mask').val(accounting.formatNumber(data.mensaje[0].subtotal,options_format));
			$('#iva_mask').val(accounting.formatNumber(data.mensaje[0].iva,options_format));
			$('#total_mask').val(accounting.formatNumber(data.mensaje[0].total,options_format));
			

			var aa =  remplazar($('#iva_mask').val(),".","");
            var bb =  remplazar($('#subtotal_mask').val(),".","");
            var porc = aa/bb;
            var p = porc * 100;
            $('#iva_percent').val(p);
            $('#iva_percent').prop("readonly",true);
            
			carga_usuarios(id);

			//------------------------------------------------------------------
			setTimeout(function(){

				console.log($("[name*='btn_actionRmUsuario_']"))

				function validaUsersBtn(tipo){
			    	if (tipo!="1") {
			    		
			    		$("[name*='btn_actionRmUsuario_']").remove();

			    	}else{
			    		//$("[name*='btn_actionRmUsuario_']").removeAttr('hidden');
			    		
			    	};
			    }

			    validaUsersBtn(tipo_usuario)

			}, 1000)			
		    //------------------------------------------------------------------			
        },
        functionBefore:function(ajustes){
        	//--------------------------------------------------
        	//
        	$("#btn_actionproyecto").removeAttr('disabled');
        	//--------------------------------------------------
		  	$("#div-observaciones").removeAttr('hidden');
		  	//--------------------------------------------------        	
        }
	});


	function carga_usuarios(id_proyecto){

		var query_proyecto = "SELECT proyectos_usuarios.pkID as numReg, proyectos.pkID as pkID_proyecto, usuarios.* "+ 

							" FROM `proyectos`"+

							" INNER JOIN proyectos_usuarios ON proyectos_usuarios.fkID_proyecto = proyectos.pkID"+

							" INNER JOIN usuarios ON proyectos_usuarios.fkID_usuario = usuarios.pkID"+							

							" WHERE proyectos.pkID = "+id_proyecto;

		$.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+query_proyecto+"&tipo=consulta_gen",
	    })
	    .done(function(data) {	    	

	    	console.log(data);	    	

	    	$("#frm_usuarios_proyecto").html("");

	    	$("#fkID_usuario").attr('data-accion', 'load');
		    arrUsuarios.length=0;
	    	if(data.estado != "Error"){	    	
		    	/**/
		    	for(var i = 0; i < data.mensaje.length; i++){
		    		//console.log(data.mensaje[0].pkID+'-'+data.mensaje[0].nombre+'-'+data.mensaje[0].nom_tipoEstudio);
		    		//selectEstudioNumReg(data.mensaje[i].pkID,data.mensaje[i].nombre,data.mensaje[i].nom_tipoEstudio,data.mensaje[i].pkID_regHojaEstudio);
		    		selectUsuario(data.mensaje[i].pkID,data.mensaje[i].nombre+" "+data.mensaje[i].apellido,$("#fkID_usuario").data('accion'),data.mensaje[i].numReg);
		    	}

	    	}else{
	    		//$("#selectPosgrado").attr('hidden','');
	    	}
	   
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
	}

	$("[name*='elimina_proyecto']").jquery_controllerV2({
  		tipo:'eliminar',
  		nom_modulo:'proyecto',
  		nom_tabla:'proyectos'
  	});
	//-------------------------------------------------------------------------------------
	

	//-------------------------------------------------------------------------------------
	//Funciones de selector de usuarios


	$("#fkID_usuario").change(function(event) {
		
		idUsuario = $(this).val();
		nomUsuario = $(this).find("option:selected").data('nombre')		

		console.log(nomUsuario);
		
		//insertEstudioSelected(idEstudio);
		
		if(verPkIdProyecto()){

			if(document.getElementById("fkID_usuario_form_"+idUsuario)){
				console.log(document.getElementById("fkID_usuario_form_"+idUsuario))
				alert("Este usuario ya fue seleccionado.")

			}else{
				//esto pasa cuando ya está cargado previamente
				//insertEstudioSelected(idEstudio);
				arrUsuarios.length=0;

				selectUsuario(idUsuario,nomUsuario,'select',$(this).data('accion'));

				serializa_array(crea_array(arrUsuarios,$("#pkID").val()))

			}
			
		}else{
			selectUsuario(idUsuario,nomUsuario,'select',$(this).data('accion'));
		}	

	});

	function verPkIdProyecto(){

		var id_proyecto_form = $("#pkID").val();
		//console.log(id_proyecto_form)
		//---------------------------------------------------------
		if(id_proyecto_form != ""){
			return true;
		}else{
			return false;
		}

	}

	function removeUsuario(id){
		$("#"+id).remove();
	}

	function deleteUsuarioNumReg(numReg){
		
      $.ajax({
            url: '../controller/ajaxController12.php',
            data: "pkID="+numReg+"&tipo=eliminar&nom_tabla=proyectos_usuarios",
        })
        .done(function(data) {            
            //---------------------
            console.log(data);

            alert(data.mensaje.mensaje);
            
            //location.reload();
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });	    
	}

	function selectUsuario(id,nombre,type,numReg){
		//añade control a form
		//console.log();
		/*
		if(document.getElementById("frm_estudios_hvida")){
			console.log('ya existe');
		}else{
			console.log('no existe');
		}*/
		/**/
		if(id!=""){

			if(document.getElementById("fkID_usuario_form_"+id)){

				alert("Este usuario ya fue seleccionado.")

			}else{

				if (type=='select') {
					// statement
					$("#frm_usuarios_proyecto").append(
						'<div class="form-group" id="frm_group'+id+'">'+		                
			                '<input type="text" style="width: 90%;display: inline;" class="form-control" id="fkID_usuario_form_'+id+'" name="fkID_usuario" value="'+nombre+'" readonly="true"> <button name="btn_actionRmUsuario_'+id+'" data-id-usuario="'+id+'" data-id-frm-group="frm_group'+id+'" type="button" class="btn btn-danger"><span class="fa fa-remove"></span></button>'+		                
			            '</div>'
			        );

				} else {
					// statement
					$("#frm_usuarios_proyecto").append(
						'<div class="form-group" id="frm_group'+id+'">'+		                
			                '<input type="text" style="width: 90%;display: inline;" class="form-control" id="fkID_usuario_form_'+id+'" name="fkID_usuario" value="'+nombre+'" readonly="true"> <button name="btn_actionRmUsuario_'+id+'" data-id-usuario="'+id+'" data-id-frm-group="frm_group'+id+'" data-numReg = "'+numReg+'" type="button" class="btn btn-danger"><span class="fa fa-remove"></span></button>'+		                
			            '</div>'
			        );
				}

				

				$("[name*='btn_actionRmUsuario_"+id+"']").click(function(event) {
					
					console.log('click remover usuario '+$(this).data('id-frm-group'));
					removeUsuario($(this).data('id-frm-group'));
					
					//buscar el indice
					var idUsuario = $(this).attr("data-id-usuario");
					console.log('el elemento es:'+idUsuario);
					var indexArr = arrUsuarios.indexOf(idUsuario);
					console.log("El indice encontrado es:"+indexArr);
					//quitar del array
					if(indexArr >= 0){
						arrUsuarios.splice(indexArr,1);
						console.log(arrUsuarios);
					}else{
						console.log('salio menor a 0');
						console.log(arrUsuarios);
					}

					if (type=='load') {
						// statement
						deleteUsuarioNumReg(numReg);
					}
					
				});

				//construye array de estudios
				arrUsuarios.push(id);
				console.log(arrUsuarios);
			}			

		}else{
			alert("No se seleccionó ningún usuario.")
		}
	};
	//-------------------------------------------------------------------------------------
		
		/*$("#subtotal_mask").keyup(function(event){

		var res = parseFloat(($("#iva_percent").val())/100);
		console.log(res);
	  	var iva_prueba = ( $("#subtotal_mask").val());
	  	let ult = parseFloat(iva_prueba) * parseFloat(res);
        //console.log('por aqui va');
	  	//console.log(iva_prueba);
	  	console.log(ult);
	  	$("#iva").val(ult);

	  	$("#iva_mask").val(ult);

	  }); */ 		

	//-------------------------------------------------------------------------------------
	//unsetear el elemento de las tablas
	sessionStorage.setItem("id_tab_proyecto",null);
});