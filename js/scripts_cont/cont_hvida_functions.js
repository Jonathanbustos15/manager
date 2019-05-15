$(function(){

	console.log('hola desde functions');

	var idEstudioS = 0;
	var nomEstudioS = "";
	var tipoEstudioS = "";

	var arrEstudiosS = [];

	function removeEstudio(id){
		$("#"+id).remove();
	}

	function selectEstudioS(id,nombre,tipo){
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

			if(document.getElementById("pkID_estudioS_"+id)){

				alert("Este estudio ya fue seleccionado.")

			}else{

				$("#frm_estudios_hvidaS").append(
					'<div class="form-group" id="frm_group'+id+'_search">'+
		                '<label for="pkID_estudioS_'+id+'" class="control-label">'+tipo+'</label>'+		                
		                '<input type="text" style="width: 90%;display: inline;" class="form-control" id="pkID_estudioS_'+id+'" name="pkID_estudioS" value="'+nombre+'" readonly="true"> <button name="btn_actionRmEstudioS" data-id-estudio="'+id+'" data-id-frm-group="frm_group'+id+'_search" type="button" class="btn btn-danger"><span class="fa fa-remove"></span></button>'+		                
		            '</div>'
		            );

				

				$("[name*='btn_actionRmEstudioS']").click(function(event) {
					
					console.log('click remover estudio '+$(this).data('id-frm-group'));
					removeEstudio($(this).data('id-frm-group'));
					
					//buscar el indice
					var idEstudio = $(this).attr("data-id-estudio");
					console.log('el elemento es:'+idEstudio);
					var indexArr = arrEstudiosS.indexOf(idEstudio);
					console.log("El indice encontrado es:"+indexArr);
					//quitar del array
					if(indexArr >= 0){
						arrEstudiosS.splice(indexArr,1);
						console.log(arrEstudiosS);
						creaConsulta(arrEstudiosS);
					}else{
						console.log('salio menor a 0');
						console.log(arrEstudiosS);
						creaConsulta(arrEstudiosS);
					}
					
				});

				//construye array de estudios
				arrEstudiosS.push(id);
				console.log(arrEstudiosS);

				creaConsulta(arrEstudiosS);
			}			

		}else{
			alert("No se seleccionó ningún estudio.")
		}
	};

	function creaConsulta(array){

		if(array.length > 0){

			var stringCons = array.toString();

			var consFin = stringCons;

			$("#btn_search_hvida").attr("href","hvida.php?s="+consFin);

			$("#btn_search_hvida").removeAttr('disabled');

		}else{
			$("#btn_search_hvida").attr('disabled','disabled');
			$("#btn_search_hvida").removeAttr('href');
		}		

		console.log(consFin);
	}

	//-----------------------------------------------------------------------------

	$("#searchEstudio").change(function(event) {
		
		idEstudioS = $(this).val();		
		nomEstudioS = $(this).find("option:selected").data('nom-estudio')
		tipoEstudioS = $(this).find("option:selected").data('nom-tipoestudio')
		
		selectEstudioS(idEstudioS,nomEstudioS,tipoEstudioS);		
	});

	$("#searchEstudioPos").change(function(event) {
		
		idEstudioS = $(this).val();		
		nomEstudioS = $(this).find("option:selected").data('nom-estudio')
		tipoEstudioS = $(this).find("option:selected").data('nom-tipoestudio')
		
		selectEstudioS(idEstudioS,nomEstudioS,tipoEstudioS);
			
	});

	//$('#form_modal_hvida a[href="#estudios"]').hide();
	//-----------------------------------------------------------------------------
	//practica clase en js
	function persona (nombre){
		this.nombre = nombre;
		this.saludar = function(){
			console.log('Hola me llamo '+this.nombre);
			this.saludo2();
		}
	}

	var johan = new persona("johan");

	/*Se puede añadir metodos y llamarlos antes de ser declarados
	solo si se hace sobre una instancia, se le añade a esa instancia 
	en este caso el objeto johan
	*/

	johan.saludo2 = function(){
		console.log('saludando nuevamente...');
	};

	johan.saludar();

	/*para añadir metodos o elementos globales se hace
	asi:
	*/

	persona.prototype.saludo3 = function(){
		console.log('Este es el tercer saludo...*');
	}

	var angela = new persona("angela");

	/*funciona en los dos casos porque es una funcion añadida
	globalmente.
	*/

	angela.saludo3();

	johan.saludo3();

	//console.log(johan.__proto__);

	/*como leer y definir propiedades getters y setters
	*/
	//se tiene el objeto curso

	var curso = {
		titulo: "Curso 1",
		videos: 19,
		tutor_valor: "Johan",
		get tutor(){
			//controla como se muestra el valor de tutor
			return this.tutor_valor;
		},
		set tutor(tutor){
			//controla como definir el valor tutor
			if( tutor === "" || ( typeof tutor === "undefined")){
				return;
			}
			this.tutor_valor = tutor;
		}
	}

	//antes:
	//curso.setTutor("Angela");
	//despues:
	curso.tutor = "Angela";
	//se comporta como si se hubiese definido una funcion especial
	//para este propósito.

	//se esta invocando al setter de tutor que realmente está manipulado el atributo tutor_valor
	console.log(curso.tutor);
	//-----------------------------------------------------------------------------
});