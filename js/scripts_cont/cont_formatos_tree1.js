$(function(){
	//console.log("Hola desde tree 1")
	//saludaformatos()

	//-----------------------------------------------------------------------------------------------
	//consultas a la BD
	var consulta1_formatos = "select formato.*, a.nombre_cat as nom_categoria, b.nombre_cat as nom_subcategoria"+ 
							" FROM `formato`"+ 
							" INNER JOIN categoria a ON a.pkID = formato.fkID_categoria"+ 
							" INNER JOIN categoria b ON b.pkID = formato.fkID_subcategoria";

	var consulta1_formatos_noSub = "select formato.*, a.nombre_cat as nom_categoria"+ 
								   " FROM `formato`"+ 
								   " INNER JOIN categoria a ON a.pkID = formato.fkID_categoria"+ 
								   " WHERE formato.fkID_subcategoria IS NULL || formato.fkID_subcategoria = 0";							
	//-----------------------------------------------------------------------------------------------
    

	//--------------------------------------------------------------------------------
	function getFormatosTree(){

		
		var dataFormatos = getDataDocumentos(consulta1_formatos);

		//console.log(dataFormatos);
		dataFormatos.success(function (data) {
		  console.log(data);

		  if (data.estado != "Error") {

		  	//-------------------------------------------------------------------------------------------
		  	$.each(data.mensaje, function(index, val) {
		  		//itera el array devuelto por ajax
		  		//console.log(index+"--"+val)
		        //console.log(val)

		        //----------------------------------------------
		        //asigna los nombres actuales
		        nom_temp.nom_act.push(val.nom_categoria);
	        	nom_temp.nom_act_sub.push(val.nom_subcategoria);

	        	//console.log(nom_temp)
	        	//----------------------------------------------

	        	//crea hijo
	        	var subfolder = creaHijo(val.nom_subcategoria)

	        	//----------------------------------------------
	        	//busca si ya existe la categoria padre
	        	if ( busca_array(val.nom_categoria,nom_temp.nom_act) > 1) {
	        		//si existe la categoria padre

	        		
	        		//lo añade a los nodes del padre
	        		//folder_array
	        		
	        		for (var f = 0; f < folder_array.length; f++) {
        	 		 	/**/
        	 		 	//cuando encuentre la categoría
        	 		 	if (folder_array[f].text == val.nom_categoria) {
        	 		 		
        	 		 		//valida si ya existe el subfolder
        	 		 		//dentro del padre
        	 		 		//if ( busca_array(val.nom_subcategoria,nom_temp.nom_act) > 1){}

        	 		 		//folder_array[f].nodes.push(subfolder);

        	 		 		//--------------------------------------------------------------------------
        	 		 		//contar los elementos si hay mas de uno no adicionar mas!
        	 		 		/**/
        	 		 		

    	 		 			 //console.log(busca_objt(valor.text,folder_array[f].nodes));

    	 		 			 if (busca_objt(val.nom_subcategoria,folder_array[f].nodes) > 0){
    	 		 			 	//console.log("Esta subcategoria ya existe")
    	 		 			 	//crea file
    	 		 			 	//console.log("Mete file: "+val.nombre+" dentro de: "+subfolder.text)
	        						        					
	        					//subfolder.nodes.push(creaFile(val.url_archivo,val.nombre));

	        					//-----------------------------------------------------------------------
	        					for (var g = 0; g < folder_array[f].nodes.length; g++) {

	        						if (folder_array[f].nodes[g].text == val.nom_subcategoria) {
	        							//crea file
		    	 		 			 	//console.log("Mete file: "+val.nombre+" dentro de: "+folder_array[f].nodes[g].text)
			        						        					
			        					folder_array[f].nodes[g].nodes.push(creaFile(val.url_archivo,val.nombre));
			        					//console.log(folder_array[f].nodes[g])
	        						}
	        					}
	        					//-----------------------------------------------------------------------

    	 		 			 } else{
    	 		 			 	//console.log("Esta subcategoria no existe.")
    	 		 			 	folder_array[f].nodes.push(subfolder);
    	 		 			 	
    	 		 			 	//crea file
	        					//console.log("Mete file: "+val.nombre+" dentro de: "+subfolder.text)
	        					subfolder.nodes.push(creaFile(val.url_archivo,val.nombre));
    	 		 			 };
        	 		 	        	 		 		
        	 		 		//--------------------------------------------------------------------------
        	 		 		
        	 		 	}
	        	 	}

	        	}else{
	        		//no existe la categoria padre

	        		//crea el folder padre
	        		//y lo añade al arreglo de folder padre
	        		var folder = creaPadre(val.nom_categoria)

	        		//crea hijo
	        		//var subfolder = creaHijo(val.nom_subcategoria)
	        		//añade folder hijo al padre
	        		folder.nodes.push(subfolder);
	        		//console.log("se añadió subcategoria: "+val.nom_subcategoria+" dentro de: "+val.nom_categoria)

	        		//crea file	        			        
	        		subfolder.nodes.push(creaFile(val.url_archivo,val.nombre));
	        	}
	        	//----------------------------------------------


		  	})
			
			//-------------------------------------------------------------------------------------------
			//resultados

			//console.log(folder_array)
			//console.log(sub_folder_array)

			//treeNoSub(folder_array)

			//$('#tree').treeview({data: folder_array});
		  	//-------------------------------------------------------------------------------------------

		  } else {
		  	
		  	console.log('No hay archivos que mostrar.')

		  }

		});

		//-----------------------------------------------------------------------------------------------

	}
	//--------------------------------------------------------------------------------
	function treeNoSub(){
		//console.log(array_tree);

		var dataFormatosNoSub = getDataDocumentos(consulta1_formatos_noSub);

		dataFormatosNoSub.success(function (data) {
		  console.log(data);

		  if (data.estado != "Error") {

		  	//resetea nom_temp.nom_act

		  	//nom_temp.nom_act = [];


		  	
		  	$.each(data.mensaje, function(index, val) {

		  		nom_temp.nom_act.push(val.nom_categoria);

		  		console.log(nom_temp)

		  		//----------------------------------------------
	        	//busca si ya existe la categoria padre
	        	if ( busca_array(val.nom_categoria,nom_temp.nom_act) > 1) {

	        		for (var f = 0; f < folder_array.length; f++) {

	        			if (folder_array[f].text == val.nom_categoria) {

	        				folder_array[f].nodes.push(creaFile(val.url_archivo,val.nombre));

	        			};
	        		};

	        	}else{
	        		//no existe la categoria padre

	        		//crea el folder padre
	        		//y lo añade al arreglo de folder padre
	        		var folder = creaPadre(val.nom_categoria)

	        		//crea file	        			        
	        		folder.nodes.push(creaFile(val.url_archivo,val.nombre));
	        	};

		  	});

		  	$('#tree').treeview({data: folder_array});

		  }else{
		  	console.log('No hay archivos no sub que mostrar.')
		  }

		});
	}
	//--------------------------------------------------------------------------------

	getFormatosTree()
	treeNoSub()
})