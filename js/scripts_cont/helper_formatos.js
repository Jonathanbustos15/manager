(function(){
	//
	self.saludaformatos = function(){
		console.log("Hola helper")	
	}

	//array final
	self.tree_data = [];

	//array para los folder padre
    self.folder_array = [];
    //array para los folder hijos
    self.sub_folder_array = [];
    

    //objeto para guardar los nombres
    //de las categorias y subcategorias
    self.nom_temp = {
		nom_act:[],
		nom_act_sub:[]
	};

	//--------------------------------------------------------------------------------
	//retorna solo la data de la consulta dada
	self.getDataDocumentos = function(consulta){

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta+"&tipo=consulta_gen"
	    })
	    .done(function(data) {	    		    	      
	        //se instancia en la variable
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });

	}
	//--------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------
	//funcion cuenta valores array

	self.busca_array = function(valor,array){

    	//console.log('buscando='+valor+' en '+array)	        

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
	//--------------------------------------------------------------------------------
	//busca valores  objeto
	self.busca_objt = function(valor,objt){

    	//console.log('buscando='+valor+' en ')
    	//console.log(objt)	        

		var cont = 0;

    	$.each(objt, function(index, val) {
    		 /* iterate through array or object */
    		 //console.log("validando: "+val.text+ " es igual a: "+valor)
    		 if (valor == val.text) {
    		 	//console.log('valor='+valor+' es igual a val='+val+"?")
    		 	cont++;
    		 };
    	});

    	return cont;	        	
    }
    //---------------------------------------------------------------------------------

    self.creaPadre = function (nombre){

    	var folder = {
    	 	text: nombre,
    	 	icon: "glyphicon glyphicon-folder-open",
    	 	state: {							    
			    expanded: false							    
			  },
    	 	nodes: []	        
    	 }


	 	folder_array.push(folder)

	 	return folder;
    }

    self.creaHijo = function (nombre){

    	var folder_sub = {
    	 	text: nombre,
    	 	icon: "glyphicon glyphicon-folder-open",
    	 	state: {							    
			    expanded: false							    
			  },
    	 	nodes: []	        
    	 }

	 	sub_folder_array.push(folder_sub)

	 	return folder_sub;

    }

    self.creaFile = function (url,nombre){

    	var file = {
    	 	text: "<a href='subidas/"+url+"' target='_blank'> "+nombre+"->"+url+"</a>",			        	 		      
    	 	icon: "glyphicon glyphicon-file",
    	 	selectable: false			        	 	
    	 }

    	 //console.log(sub_folder_array)

    	 //padre.nodes.push(file)

    	 return file;
    }
    //---------------------------------------------------------------------------------

})();