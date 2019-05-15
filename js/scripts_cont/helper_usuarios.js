(function(){

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++    
    //funciones para añadir empresas a un usuario
    self.matrixRelation = {
    	id : 0,
	    nombre : "",
	    nombre_modulo : "",
	    nombre_modulo2 : "",
	    nombre_tabla : "",
	    seleccionador : "",
	    btn_accion : "",
	    formulario_add : "",
	    arrElementos : [],
	    arrElementosRelation : [],
	    obtHE : {
	    	"fkID_empresa" : 0,
	    	"fkID_usuario" : 0
	    },
	    setup : function(){

	    	$("#"+this.seleccionador).change(function(event){

	    		matrixRelation.id = $(this).val()
				matrixRelation.nombre = $(this).find("option:selected").data('nombre')
				/**/
				var accion = matrixRelation.valida_accion()
				
				if ( accion == "crear" ) {

					matrixRelation.select_elemento(matrixRelation.id,matrixRelation.nombre,'select',$(this).data('accion'))

				} else if ( accion == "editar" ) {

					matrixRelation.arrElementos.length = 0;

					//selectUsuario(idUsuario,nomUsuario,'select',$(this).data('accion'));
					matrixRelation.select_elemento(matrixRelation.id,matrixRelation.nombre,'select',$(this).data('accion'))

					//serializa_array(crea_array(arrUsuarios,$("#pkID").val()))
					matrixRelation.serializa_array(matrixRelation.crea_array(matrixRelation.arrElementos,$("#pkID").val()));
				}				
				
	    	});

	    },
	    valida_accion : function(){
	    	return $("#"+this.btn_accion).attr("data-action")	    	
	    },
	    valida_elemento : function(){
	    	
	    	if(document.getElementById("fkID_"+this.nombre_modulo+"_"+this.id)){
	    		return true;
	    	}else{
	    		return false;
	    	}

	    },
	    select_elemento : function(id,nombre,type,numReg){

	    	if(id!=""){

	    		if (matrixRelation.valida_elemento()) {
	    			alert("Este elemento ya fue seleccionado.")
	    		} else {

	    			if (type=='select') {

	    				$("#"+matrixRelation.formulario_add).append(
	    					'<div class="form-group" id="frm_group'+id+'">'+		                
				                '<input type="text" style="width: 90%;display: inline;" class="form-control" id="fkID_'+matrixRelation.nombre_modulo+'_'+id+'" name="fkID_'+matrixRelation.nombre_modulo+'" value="'+nombre+'" readonly="true"> <button name="btn_actionRm_'+id+'" data-id-'+matrixRelation.nombre_modulo+'="'+id+'" data-id-frm-group="frm_group'+id+'" type="button" class="btn btn-danger"><span class="fa fa-remove"></span></button>'+		                
				            '</div>'
	    				);

	    			}else {

	    				$("#"+matrixRelation.formulario_add).append(
							'<div class="form-group" id="frm_group'+id+'">'+		                
				                '<input type="text" style="width: 90%;display: inline;" class="form-control" id="fkID_'+matrixRelation.nombre_modulo+'_'+id+'" name="fkID_'+matrixRelation.nombre_modulo+'" value="'+nombre+'" readonly="true"> <button name="btn_actionRm_'+id+'" data-id-'+matrixRelation.nombre_modulo+'="'+id+'" data-id-frm-group="frm_group'+id+'" data-numReg = "'+numReg+'" type="button" class="btn btn-danger"><span class="fa fa-remove"></span></button>'+		                
				            '</div>'
				        );
	    			}

	    			$("[name*='btn_actionRm_"+id+"']").click(function(event) {
					
						console.log('click remover usuario '+$(this).data('id-frm-group'));
						matrixRelation.remove_elemento($(this).data('id-frm-group'));
						/**/
						//buscar el indice
						var id_elemento = $(this).attr("data-id-"+matrixRelation.nombre_modulo);
						console.log('el elemento es:'+id_elemento);
						var indexArr = matrixRelation.arrElementos.indexOf(id_elemento);
						console.log("El indice encontrado es:"+indexArr);
						//quitar del array
						if(indexArr >= 0){
							matrixRelation.arrElementos.splice(indexArr,1);
							console.log(matrixRelation.arrElementos);
						}else{
							console.log('salio menor a 0');
							console.log(matrixRelation.arrElementos);
						}

						if (type=='load') {
							// statement
							matrixRelation.deleteElementoNumReg(numReg);
						}
						
					});

	    			matrixRelation.arrElementos.push(id);
					console.log(matrixRelation.arrElementos);

					//---------------------------------------
					//matrixRelation.serializa_array(matrixRelation.crea_array(matrixRelation.arrElementos,4));
	    		}


	    	}else{
	    		alert("No se seleccionó ningún elemento.")
	    	}
	    },
	    remove_elemento : function(id){
	    	$("#"+id).remove();
	    },
	    crea_array : function(array,id){
	    	/**/
			//arrElementosRelation
			matrixRelation.arrElementosRelation = [];

			array.forEach(function(element, index){
			
			matrixRelation.obtHE = {"fkID_empresa":element,"fkID_usuario":id};			

			matrixRelation.arrElementosRelation.push(matrixRelation.obtHE);

			});

			//console.log(matrixRelation.arrElementosRelation);

			return matrixRelation.arrElementosRelation;
	    },
	    serializa_array : function(array){

	    	var cadenaSerializa = "";

	  		var ciclo_array = $.each(array, function(index, val) {

	  			var dataCadena = "";

	  			$.each(val, function(llave, valor) {
			 	          	 
				 	console.log("llave="+llave+" valor="+valor);

				 	dataCadena = dataCadena+llave+"="+valor+"&";	          	 	 	          	 	
				 	//insertaEstudio(cadenaSerializa);
				});

				dataCadena = dataCadena.substring(0,dataCadena.length - 1);

				console.log(dataCadena);
								
				matrixRelation.inserta_serializa(dataCadena)	

	  		});

	  		$.when(ciclo_array).then(function(){
	  			console.log(" Terminó la inserción de empresas.")
	  		});
	  		
	    },
	    inserta_serializa : function(data){

	    	$.ajax({
	    	  async: false,
	          url: "../controller/ajaxController12.php",
	          data: data+"&tipo=inserta&nom_tabla="+matrixRelation.nombre_tabla,
	        })
	        .done(function(data) {	          
	          //---------------------
	          console.log(data);
	          //alert(data[0].mensaje);
	          //location.reload();
	          if (matrixRelation.valida_accion() == "editar") {
	          	alert(data[0].mensaje);
	          	location.reload();
	          }          
	        })
	        .fail(function(data) {
	          console.log(data);	          
	          //alert(data[0].mensaje);          
	        })
	        .always(function() {
	          console.log("complete");
	        });
	    },
	    carga_elementos : function(id_usuario){

	    	var query = "select empresa.*, usuarios.alias, usuarios_empresas.pkID as numReg "+ 

                " FROM empresa"+

                " INNER JOIN usuarios_empresas ON usuarios_empresas.fkID_empresa = empresa.pkID"+

                " INNER JOIN usuarios ON usuarios_empresas.fkID_usuario = usuarios.pkID"+

                " WHERE usuarios.pkID = "+id_usuario;

            $.ajax({
		        url: '../controller/ajaxController12.php',
		        data: "query="+query+"&tipo=consulta_gen",
		    })
		    .done(function(data) {	    	

		    	console.log(data);	    	

		    	$("#"+matrixRelation.formulario_add).html("");

		    	$("#"+matrixRelation.seleccionador).attr('data-accion', 'load');

		    	matrixRelation.arrElementos.length = 0;
			    matrixRelation.arrElementosRelation.length=0;

		    	if(data.estado != "Error"){	    	
			    	/**/
			    	for(var i = 0; i < data.mensaje.length; i++){
			    		
			    		matrixRelation.select_elemento(data.mensaje[i].pkID,data.mensaje[i].nombre,$("#"+matrixRelation.seleccionador).data('accion'),data.mensaje[i].numReg);
			    	}

		    	}
		   
		    })
		    .fail(function() {
		        console.log("error");
		    })
		    .always(function() {
		        console.log("complete");
		    });
	    },
	    deleteElementoNumReg : function(numReg){

	    	$.ajax({
	            url: '../controller/ajaxController12.php',
	            data: "pkID="+numReg+"&tipo=eliminar&nom_tabla="+matrixRelation.nombre_tabla,
	        })
	        .done(function(data) {            
	            //---------------------
	            console.log(data);

	            alert(data.mensaje.mensaje);
	            
	            location.reload();
	        })
	        .fail(function() {
	            console.log("error");
	        })
	        .always(function() {
	            console.log("complete");
	        });	   
	    }

    }
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
})()