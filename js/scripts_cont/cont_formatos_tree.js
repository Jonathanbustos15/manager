$(function(){
	console.log("Hola desde tree formatos");

	//--------------------------------------------------------------------------------
	function getFormatosTree(){

		//var pkID_proyecto = $("#id_proyecto").val();

		//-----------------------------------------------------------------------------------------------		

		var consulta_formato = "select formato.*, a.nombre_cat as nom_categoria, b.nombre_cat as nom_subcategoria"+ 
								" FROM `formato`"+ 
								" INNER JOIN categoria a ON a.pkID = formato.fkID_categoria"+ 
								" INNER JOIN categoria b ON b.pkID = formato.fkID_subcategoria";

	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_formato+"&tipo=consulta_gen"
	    })
	    .done(function(data) {	    	
	    	
	        console.log(data)

	        var tree_data = [];

	        var folder_array = [];
	        var sub_folder_array = [];

	        var nom_temp = {
        		nom_act:[],
        		nom_act_sub:[]
        	};

        	var ant = '';
	        var act = '';

	        function busca_array(valor,array){

	        	console.log('buscando='+valor+' en '+array)	        
	
				var cont = 0;

				//console.log('comenzando ciclo for:')
	        	
	        	for (var i = 0; i < array.length; i++) {

	        		//console.log(array[i])
	        		 
	        		if (valor == array[i]) {
	        		 	//console.log('valor='+valor+' es igual a val='+val+"?")
	        		 	cont++;
	        		 };     	
	        	};

	        	return cont;	        	
	        }

	        if (data.estado != "Error") {

		        $.each(data.mensaje, function(index, val) {
		        	 /* iterate through array or object */
		        	 console.log(index+"--"+val)
		        	 console.log(val)

		        	 /*
		        	 -Determinar cuantos tipos de documento hay-si ya existe no lo agregue
		        	 

		        	var act = val.nom_categoria;
		        	console.log('actual ='+act)*/

		        	nom_temp.nom_act.push(val.nom_categoria);
		        	nom_temp.nom_act_sub.push(val.nom_subcategoria);

		        	console.log(nom_temp)
		        	
		        	var searh_array = busca_array(val.nom_categoria,nom_temp.nom_act);

		        	console.log(" el valor se repite "+searh_array+" veces.")
		        		        
		        	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	        	 		 if ( busca_array(val.nom_categoria,nom_temp.nom_act) > 1) {

	        	 		 //ya existe el tipo
	        	 		 console.log('validando = valor:'+val.nom_categoria+"--val.nom:"+val.nom_categoria);
	        	 		 console.log('esta repetido ='+val.nom_categoria);	        	 		 

	        	 		 var file = {
				        	 	text: "<a href='subidas/"+val.url_archivo+"' target='_blank'> "+val.nombre+"->"+val.url_archivo+"</a>",
				        	 	icon: "glyphicon glyphicon-file",
				        	 	selectable: false,			        	 		      
				        	 }

	        	 		 //------------------------------------------------------      	 		 

	        	 		 for (var f = 0; f < folder_array.length; f++) {
	        	 		 	/**/
	        	 		 	if (folder_array[f].text == val.nom_categoria) {

	        	 		 	 	//folder_array[f].nodes.push(file)

	        	 		 	 	//ya existe la subcategoriá?

				        	 	if ( busca_array(val.nom_subcategoria,nom_temp.nom_act_sub) > 1){

				        	 		var file = {
						        	 	text: "<a href='subidas/"+val.url_archivo+"' target='_blank'> "+val.nombre+"->"+val.url_archivo+"</a>",			        	 		      
						        	 	icon: "glyphicon glyphicon-file",
						        	 	selectable: false,			        	 	
						        	 }

						        	 for (var f = 0; f < sub_folder_array.length; f++) {
				        	 		 	/**/
				        	 		 	if (sub_folder_array[f].text == val.nom_subcategoria) {

				        	 		 	 	//folder_array[f].nodes.push(file)
				        	 		 	 	sub_folder_array[f].nodes.push(file)
				        	 		 	 }
				        	 		 	 //console.log(folder_array[f].text)
				        	 		 }

				        	 	}else{


				        	 		var folder_sub = {
						        	 	text: val.nom_subcategoria,
						        	 	icon: "glyphicon glyphicon-folder-open",
						        	 	state: {							    
										    expanded: false							    
										  },
						        	 	nodes: []	        
						        	 }

					        	 	sub_folder_array.push(folder_sub)

					        	 	var file = {
						        	 	text: "<a href='subidas/"+val.url_archivo+"' target='_blank'> "+val.nombre+"->"+val.url_archivo+"</a>",			        	 		      
						        	 	icon: "glyphicon glyphicon-file",
						        	 	selectable: false,			        	 	
						        	 }

						        	 folder_sub.nodes.push(file)

						        	 folder_array[f].nodes.push(folder_sub)

				        	 	}
				        	 	//----------------------------------------------------------------------
	        	 		 	 }
	        	 		 	 //console.log(folder_array[f].text)
	        	 		 }


	        	 		 //------------------------------------------------------

	        	 		 //--------------------------------------------------
			        	 //valida si existe sub-categoría
			        	 /*
			        	 if ( busca_array(val.nom_subcategoria,nom_temp.nom_act_sub) > 1){

			        	 }else{

			        	 	var folder_sub = {
				        	 	text: val.nom_subcategoria,
				        	 	icon: "glyphicon glyphicon-folder-open",
				        	 	state: {							    
								    expanded: false							    
								  },
				        	 	nodes: []	        
				        	 }

			        	 	sub_folder_array.push(folder_sub)

			        	 	//folder.nodes.push(sub_folder_array)
			        	 	//reecorre folder_array para saber donde hay que meterlo
			        	 	
			        	 	//------------------------------------------------------

			        	 }*/
			        	 //--------------------------------------------------

			        	} else{

			        		var folder = {
				        	 	text: val.nom_categoria,
				        	 	icon: "glyphicon glyphicon-folder-open",
				        	 	state: {							    
								    expanded: false							    
								  },
				        	 	nodes: []	        
				        	 }


			        	 	folder_array.push(folder)

			        	 	//ya existe la subcategoriá?

			        	 	if ( busca_array(val.nom_subcategoria,nom_temp.nom_act_sub) > 1){

			        	 		var file = {
					        	 	text: "<a href='subidas/"+val.url_archivo+"' target='_blank'> "+val.nombre+"->"+val.url_archivo+"</a>",			        	 		      
					        	 	icon: "glyphicon glyphicon-file",
					        	 	selectable: false,			        	 	
					        	 }

					        	 for (var f = 0; f < sub_folder_array.length; f++) {
			        	 		 	/**/
			        	 		 	if (sub_folder_array[f].text == val.nom_subcategoria) {

			        	 		 	 	//folder_array[f].nodes.push(file)
			        	 		 	 	sub_folder_array[f].nodes.push(file)
			        	 		 	 }
			        	 		 	 //console.log(folder_array[f].text)
			        	 		 }

			        	 	}else{


			        	 		var folder_sub = {
					        	 	text: val.nom_subcategoria,
					        	 	icon: "glyphicon glyphicon-folder-open",
					        	 	state: {							    
									    expanded: false							    
									  },
					        	 	nodes: []	        
					        	 }

				        	 	sub_folder_array.push(folder_sub)

				        	 	var file = {
					        	 	text: "<a href='subidas/"+val.url_archivo+"' target='_blank'> "+val.nombre+"->"+val.url_archivo+"</a>",			        	 		      
					        	 	icon: "glyphicon glyphicon-file",
					        	 	selectable: false,			        	 	
					        	 }

					        	 folder_sub.nodes.push(file)

					        	 folder.nodes.push(folder_sub)

			        	 	}

			        	 	


			        	 	/*
			        	 	var file = {
				        	 	text: "<a href='subidas/"+val.url_archivo+"' target='_blank'> "+val.nombre+"->"+val.url_archivo+"</a>",			        	 		      
				        	 	icon: "glyphicon glyphicon-file",
				        	 	selectable: false,			        	 	
				        	 }

				        	 folder.nodes.push(file)*/

				        	 
			        	};

	        	 	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++      	 		        		
		        	
		        	 console.log(folder_array)
		        	 console.log(sub_folder_array)

		        	 /*
		        	 var objt_tree = {
		        	 	text: ""+val.nom_categoria,
		        	 	icon: "glyphicon glyphicon-folder-close",
	  					selectedIcon: "glyphicon glyphicon-folder-open",
		        	 	nodes: [
					      {
					        text: "<span class='glyphicon glyphicon-file'></span> Nombre de Documento: "+val.nombre,
					        nodes: [
					          {
					            text: "<span class='glyphicon glyphicon-download-alt'></span> Descarga: <a href='subidas/"+val.url_archivo+"'>"+val.url_archivo+"</a>"
					          }
					        ]
					      }
					  ]

		        	 }*/

		        	 //tree_data.push(folder_array);
		        	 	        	 
		        });
			} else {
				console.log('No hay archivos que mostrar.')
			}
	       			
			$('#tree').treeview({data: folder_array});
			
        	//-----------------------------------------------------------------------------------
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });

	    //-----------------------------------------------------------------------------------------------
	}
	//--------------------------------------------------------------------------------
	getFormatosTree()
});