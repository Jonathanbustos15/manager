(function(){

	self.saludo_proyectos_detalle = function(){
		console.log('Hola proyectos en detalle...')
	}

	//saludo_proyectos_detalle()

	//----------------------------------------------------------------------------------------------
	//tree de documentos detalle de proyecto
	//variables globales para el tree
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
	//----------------------------------------------------------------------------------------------
	//
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
    	//cambiar ruta...
    	var file = {
    	 	text: "<a href='../server/php/files/"+url+"' target='_blank'> "+nombre+"->"+url+"</a>",			        	 		      
    	 	icon: "glyphicon glyphicon-file",
    	 	selectable: false			        	 	
    	 }

    	 //console.log(sub_folder_array)

    	 //padre.nodes.push(file)

    	 return file;
    }
    //----------------------------------------------------------------------------------------------
    //objeto de vista de arbol -- posible implementación en el helper global
    //esta funcionalidad depende de treeview

    self.vistaArbol = {
        //variables
        consulta : "",//consulta que trae los datos
        names : {
            act:[],//array de nombres actuales
            act_sub:[],//array subnombres actuales
            name_category : "",//categoria o tipo desde la BD
            name_subCategory : "",//subcategoria o subtipo desde la BD
            url : "",//nombre del campo de ruta en la BD
            nombre : "",//nombre del archivo
            url_server : '../server/php/files/',//ruta del servidor
            selector : '',//en donde se va a mostrar
        },
        treeData : [],
        folderArray : [],
        subFolderArray : [],
        getData : function(){

            return $.ajax({
                url: '../controller/ajaxController12.php',
                data: "query="+vistaArbol.consulta+"&tipo=consulta_gen"
            })
            .done(function(data) {                            
                //se instancia en la variable
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                //console.log("complete");
            });

        },
        buscaArray : function(valor,array){        

            var cont = 0;
            
            for (var i = 0; i < array.length; i++) {
                 
                if (valor == array[i]) {
                    cont++;
                 };         
            };

            return cont;                
        },
        createSon : function (nombre){

            var folder_sub = {
                text: nombre,
                icon: "glyphicon glyphicon-folder-open",
                state: {                                
                    expanded: false                             
                  },
                nodes: []           
             }

            this.subFolderArray.push(folder_sub)

            return folder_sub;

        },
        createFather : function (nombre){

            var folder = {
                text: nombre,
                icon: "glyphicon glyphicon-folder-open",
                state: {                                
                    expanded: false                             
                  },
                nodes: []           
             }


            this.folderArray.push(folder)

            return folder;
        },
        createFile : function (url,nombre){
            //cambiar ruta...
            var file = {
                text: "<a href='"+vistaArbol.names.url_server+url+"' target='_blank'> "+nombre+"->"+url+"</a>",                                   
                icon: "glyphicon glyphicon-file",
                selectable: false                           
             }

             return file;
        },
        getTree : function(){

            var dataTree = this.getData();

            dataTree.success(function (data) {
                
                console.log(data)

                if (data.estado != "Error") {
                    //-------------------------------------------------------------------------------------------
                    $.each(data.mensaje, function(index, val) {
                       //----------------------------------------------
                       //asigna los nombres actuales
                       var category = val[vistaArbol.names.name_category]
                       var subCategory = val[vistaArbol.names.name_subCategory]
                       var url = val[vistaArbol.names.url]
                       var nombre = val[vistaArbol.names.nombre]
                       //---------------------------
                       vistaArbol.names.act.push(category);
                       vistaArbol.names.act_sub.push(subCategory);

                       //crea hijo                       
                       //----------------------------------------------
                       /**/
                       if (subCategory != "No Aplica") {
                           var subfolder = vistaArbol.createSon(subCategory)
                       } else {

                       }

                       //----------------------------------------------
                       //busca si ya existe la categoria padre
                       if ( vistaArbol.buscaArray(category,vistaArbol.names.act) > 1) {

                            for (var f = 0; f < vistaArbol.folderArray.length; f++) {

                                //cuando encuentre la categoría
                                if (vistaArbol.folderArray[f].text == category) {

                                    if ( (busca_objt(subCategory,vistaArbol.folderArray[f].nodes) > 0) ){

                                        //-----------------------------------------------------------------------
                                        for (var g = 0; g < vistaArbol.folderArray[f].nodes.length; g++) {

                                            if (vistaArbol.folderArray[f].nodes[g].text == subCategory) {
                                                //crea file
                                                //console.log("Mete file: "+val.nombre+" dentro de: "+folder_array[f].nodes[g].text)
                                                                                
                                                vistaArbol.folderArray[f].nodes[g].nodes.push(vistaArbol.createFile(url,nombre));
                                                //console.log(folder_array[f].nodes[g])
                                            }
                                        }
                                        //-----------------------------------------------------------------------

                                    }else{

                                        if (subCategory != "No Aplica") {

                                            vistaArbol.folderArray[f].nodes.push(subfolder);
                                            subfolder.nodes.push(vistaArbol.createFile(url,nombre));

                                        }else{

                                            vistaArbol.folderArray[f].nodes.push(vistaArbol.createFile(url,nombre));
                                        }

                                    }

                                }
                            }

                       }else{
                            //no existe la categoria padre

                            //crea el folder padre
                            //y lo añade al arreglo de folder padre
                            var folder = vistaArbol.createFather(category)

                            //crea hijo                            
                            //console.log("se añadió subcategoria: "+val.nombre_tsubtipo+" dentro de: "+val.nom_tipoDocumento)

                            //crea file o subfolder si no es 'No Aplica'
                            if (subCategory != "No Aplica") {
                                folder.nodes.push(subfolder);
                                subfolder.nodes.push(vistaArbol.createFile(url,nombre));
                            }else{
                                folder.nodes.push(vistaArbol.createFile(url,nombre));
                                //console.log(creaFile(val.ruta,val.nom_doc))
                            }                               
                            
                        }
                        //----------------------------------------------

                    });      

                    //console.log(vistaArbol.names)
                    //console.log(vistaArbol.folderArray);
                    //crea el treeview
                    $('#'+vistaArbol.names.selector).treeview({data: vistaArbol.folderArray});
                    //-------------------------------------------------------------------------------------------

                }else{
                    console.log('No hay archivos que mostrar.')
                }

            });
        } 


    }
	//----------------------------------------------------------------------------------------------

    //----------------------------------------------------------------
    //funcion que quita los caracteres especiales de las observaciones
    //para que no halla errores al actualizarel campo.
    self.observ = {
        exp : /[#%&!()\/]/g,
        search : [],
        res : '',
        valida : function(str){             
            this.search = str.match(this.exp);
            if (this.search) {
                this.reemplaza(str);                
                return this.res;
            }else{
                return str;
            };
        },      
        reemplaza : function(str){
            this.res = str.replace(this.exp, "");           
        }
    }
    //----------------------------------------------------------------

    //----------------------------------------------------------------
    //sistema de tabs para la vista general
    
    var id_li_activo = sessionStorage.getItem("id_tab_proyecto_gen");    

    //console.log($("[role=presentation]"));

    console.log(id_li_activo);

    //dependiendo de los li en detalles de proyectos?
    /**/
    if( (id_li_activo == "") || (id_li_activo == "null") || (id_li_activo == null) || (id_li_activo == "li_general") || (id_li_activo == "li_presupuesto") || (id_li_activo == "li_documentos") || (id_li_activo == "li_personal") || (id_li_activo == "li_seguimiento") || (id_li_activo == "li_gastos") ){

        $("#li_ejecucion").addClass('active');

        $("#ejecucion").addClass('active');

    }else{

        $("#"+id_li_activo).addClass('active');

        $('ul a[href="#'+id_li_activo.slice(3,20)+'"]').tab('show');

        $("#"+id_li_activo.slice(3,20)).addClass('active');

        //console.log( $('ul a[href="#'+id_li_activo.slice(3,20)+'"]') );
    }   

    
    $("[role=presentation]").click(function(event) {
        
        id_li_activo = $(this)[0].id;

        console.log($(this)[0].id);

        // Store
        sessionStorage.setItem("id_tab_proyecto_gen", $(this)[0].id);
    });
    //----------------------------------------------------------------

})();