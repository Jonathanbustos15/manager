$(function(){

	
	//-----------------------------------------
	uppercaseForm("form_certificados");
	//-----------------------------------------
	//prueba de treeview
	var tree = [
	  {
	    text: "Parent 1",
	    nodes: [
	      {
	        text: "Child 1",
	        nodes: [
	          {
	            text: "Grandchild 1"
	          },
	          {
	            text: "Grandchild 2"
	          }
	        ]
	      },
	      {
	        text: "Child 2"
	      }
	    ]
	  },
	  {
	    text: "Parent 2"
	  },
	  {
	    text: "Parent 3"
	  },
	  {
	    text: "Parent 4"
	  },
	  {
	    text: "Parent 5"
	  }
	];

	function getTree() {
	  // Some logic to retrieve, or generate tree structure
	  return tree;
	}

	function getCertificadosTree(){

		var pkID_empresa = $("#id_empresa").val();

		//-----------------------------------------------------------------------------------------------

		var consulta_certificados = "select certificacion_experiencia.*, empresa.nombre as nom_empresa"+ 

								" FROM `certificacion_experiencia`"+ 

								" INNER JOIN empresa ON empresa.pkID = certificacion_experiencia.fkID_empresa"+

								" INNER JOIN entidades ON entidades.pkID = certificacion_experiencia.fkID_entidad"+ 

								" where fkID_proceso = "+pkID_empresa;

		$.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_certificados+"&tipo=consulta_gen"
	    })
	    .done(function(data) {	    	
	    	
	        console.log(data)

	        var tree_data = [];

	        var folder_array = [];
	        var nom_temp = {
        		nom_act:[],
        		nom2_ant:[]
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
		        	 

		        	var act = val.nom_tipoDocumento;
		        	console.log('actual ='+act)*/

		        	nom_temp.nom_act.push(val.nom_tipoDocumento);

		        	console.log(nom_temp.nom_act)
		        	
		        	var searh_array = busca_array(val.nom_tipoDocumento,nom_temp.nom_act);

		        	console.log(" el valor se repite "+searh_array+" veces.")
		        		        
		        	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	        	 		 if ( busca_array(val.nom_tipoDocumento,nom_temp.nom_act) > 1) {

	        	 		 //ya existe el tipo
	        	 		 console.log('validando = valor:'+val.nom_tipoDocumento+"--val.nom:"+val.nom_tipoDocumento);
	        	 		 console.log('esta repetido ='+val.nom_tipoDocumento);

	        	 		 var file = {
				        	 	text: "<a href='subidas/"+val.ruta+"' target='_blank'> "+val.nom_doc+"->"+val.ruta+"</a>",
				        	 	icon: "glyphicon glyphicon-file",
				        	 	selectable: false,			        	 		      
				        	 }

	        	 		 //------------------------------------------------------      	 		 

	        	 		 for (var f = 0; f < folder_array.length; f++) {
	        	 		 	/**/
	        	 		 	if (folder_array[f].text == val.nom_tipoDocumento) {
	        	 		 	 	folder_array[f].nodes.push(file)
	        	 		 	 }
	        	 		 	 //console.log(folder_array[f].text)
	        	 		 }
	        	 		 //------------------------------------------------------

			        	} else{

			        		var folder = {
				        	 	text: val.nom_tipoDocumento,
				        	 	icon: "glyphicon glyphicon-folder-open",
				        	 	state: {							    
								    expanded: false							    
								  },
				        	 	nodes: []	        
				        	 }

			        	 	folder_array.push(folder)

			        	 	var file = {
				        	 	text: "<a href='subidas/"+val.ruta+"' target='_blank'> "+val.nom_doc+"->"+val.ruta+"</a>",			        	 		      
				        	 	icon: "glyphicon glyphicon-file",
				        	 	selectable: false,			        	 	
				        	 }

				        	 folder.nodes.push(file)
			        	};

	        	 	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++      	 		        		
		        	
		        	 console.log(folder_array)

		        	 /*
		        	 var objt_tree = {
		        	 	text: ""+val.nom_tipoDocumento,
		        	 	icon: "glyphicon glyphicon-folder-close",
	  					selectedIcon: "glyphicon glyphicon-folder-open",
		        	 	nodes: [
					      {
					        text: "<span class='glyphicon glyphicon-file'></span> Nombre de Documento: "+val.nom_doc,
					        nodes: [
					          {
					            text: "<span class='glyphicon glyphicon-download-alt'></span> Descarga: <a href='subidas/"+val.ruta+"'>"+val.ruta+"</a>"
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
        	
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });

	    //-----------------------------------------------------------------------------------------------
	}

	//$('#tree').treeview({data: getTree()});

	getCertificadosTree();

});