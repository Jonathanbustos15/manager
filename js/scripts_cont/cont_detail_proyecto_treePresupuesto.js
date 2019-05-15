$(function(){
	
	//console.log('presupuesto proyecto tree!!')

	function getPresupuestoTree(){

		var pkID_proyecto = $("#id_proyecto").val();

		//-----------------------------------------------------------------------------------------------		

		var consulta_presupuesto = "select gastos.*, actividad.nombre as nom_actividad, actividad.subtotal as subtotal_actividad, actividad.iva as iva_actividad, actividad.total as total_actividad"+ 

								" from gastos "+ 

								" INNER JOIN actividad ON actividad.pkID = gastos.fkID_actividad"+ 

								" where gastos.fkID_proyecto = "+pkID_proyecto;

	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_presupuesto+"&tipo=consulta_gen"
	    })
	    .done(function(data) {	    	
	    	
	        //console.log(data)
	        //-----------------------------------------------------------------------------------
	        /**/
	        var tree_data = [];

	        var folder_array = [];

	        var nom_temp = {
        		nom_act:[],
        		nom2_ant:[]
        	};

        	var ant = '';
	        var act = '';
			//---------------------------------------------------------------

	        function busca_array(valor,array){

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

	        if (data.estado != "Error") {

	        	//variable opciones para el formato dinero----------------------
	        	var options_format = {
					symbol : "$",
					decimal : ",",
					thousand: ".",
					precision : 0,
					format: "%s%v"
				};

				var sum_files = [];
				var sum_iva = [];
				var sum_valor = [];				
				//---------------------------------------------------------------

		        $.each(data.mensaje, function(index, val) {
		        	 
		        	 //console.log(index+"--"+val)
		        	 //console.log(val)
		        	 
		        	nom_temp.nom_act.push(val.nom_actividad);

		        	//console.log(nom_temp.nom_act)
		        	
		        	var searh_array = busca_array(val.nom_actividad,nom_temp.nom_act);

		        	//console.log(" el valor se repite "+searh_array+" veces.")

		        	var objt_sum = {
	        			nombre:'',
	        			valor:0
	        		}

	        		var objt_sumIva = {
	        			nombre:'',
	        			valor:0
	        		}  
		        	
		        	var objt_sumValor = {
	        			nombre:'',
	        			valor:0
	        		}	        
		        	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	        	 		 if ( busca_array(val.nom_actividad,nom_temp.nom_act) > 1) {

	        	 		 //ya existe el tipo
	        	 		 //console.log('validando = valor:'+val.nom_actividad+"--val.nom:"+val.nom_actividad);
	        	 		 //console.log('esta repetido ='+val.nom_actividad);

	        	 		 var file = {
				        	 	text: '<strong>'+val.nombre+' : </strong> | <strong> Sub-Total: $</strong>'+accounting.formatNumber(val.valor,options_format)+' | <strong> IVA: $</strong>'+accounting.formatNumber(val.iva,options_format)+' | <strong> Total: $</strong>'+accounting.formatNumber(val.total,options_format)+' | '+' <strong> Sub-Total Valor contratado: $</strong>'+accounting.formatNumber(val.vc_subtotal,options_format)+' | '+' <strong> Rentabilidad Apróximada: $</strong>'+accounting.formatNumber(val.vc_subtotal - val.valor,options_format)+' | ',
				        	 	icon: "glyphicon glyphicon-usd",
				        	 	selectable: false,			        	 		      
				        	 }

	        	 		 //------------------------------------------------------      	 		 

	        	 		 for (var f = 0; f < folder_array.length; f++) {
	        	 		 	
	        	 		 	if (folder_array[f].text == val.nom_actividad) {
	        	 		 	 	folder_array[f].nodes.push(file)
	        	 		 	 }
	        	 		 	 //console.log(folder_array[f].text)
	        	 		 }

	        	 		 //sum_files
	        	 		 for (var g = 0; g < sum_files.length; g++) {
	        	 		 	
	        	 		 	if (sum_files[g].nombre == val.nom_actividad) {
	        	 		 	 	sum_files[g].valor = parseInt(sum_files[g].valor) + parseInt(val.total)
	        	 		 	 }
	        	 		 	 //console.log(folder_array[f].text)
	        	 		 }
	        	 		 //------------------------------------------------------

	        	 		 //sum_iva
	        	 		 for (var i = 0; i < sum_iva.length; i++) {
	        	 		 	
	        	 		 	if (sum_iva[i].nombre == val.nom_actividad) {
	        	 		 	 	sum_iva[i].valor = parseInt(sum_iva[i].valor) + parseInt(val.iva)
	        	 		 	 }
	        	 		 	 //console.log(folder_array[f].text)
	        	 		 }
	        	 		 //------------------------------------------------------

	        	 		 //sum_iva
	        	 		 for (var j = 0; j < sum_valor.length; j++) {
	        	 		 	
	        	 		 	if (sum_valor[j].nombre == val.nom_actividad) {
	        	 		 	 	sum_valor[j].valor = parseInt(sum_valor[j].valor) + parseInt(val.valor)
	        	 		 	 }
	        	 		 	 //console.log(folder_array[f].text)
	        	 		 }
	        	 		 //------------------------------------------------------

			        	} else{
			        		
			        		//---------------------------------------------------

			        		objt_sum.nombre = val.nom_actividad
			        		objt_sum.valor = parseInt(val.total) + parseInt(objt_sum.valor)

			        		sum_files.push(objt_sum)

			        		//----------------------------------------------------
			        		//Sumatoria iva
			        		objt_sumIva.nombre = val.nom_actividad
			        		objt_sumIva.valor = parseInt(val.iva) + parseInt(objt_sumIva.valor)

			        		sum_iva.push(objt_sumIva)

			        		//----------------------------------------------------
			        		//Sumatoria valor
			        		objt_sumValor.nombre = val.nom_actividad
			        		objt_sumValor.valor = parseInt(val.valor) + parseInt(objt_sumValor.valor)

			        		sum_valor.push(objt_sumValor)
			        		//----------------------------------------------------
			        		//'<strong>'+val.nom_actividad+' : </strong> | <strong> Sub-Total: $</strong>'+accounting.formatNumber(val.subtotal_actividad,options_format)+' | <strong> IVA: $</strong>'+accounting.formatNumber(val.iva_actividad,options_format)+' | <strong> Total: $</strong>'+accounting.formatNumber(val.total_actividad,options_format)+' | ',
			        		var text_folder = ' | <strong> Sub-Total Actividad: $</strong>'+accounting.formatNumber(val.subtotal_actividad,options_format)+' | <strong> Rentabilidad Apróximada: $</strong>';

			        		var folder = {
			        			texto_grupo: text_folder,
			        			subtotal_actividad:val.subtotal_actividad,			        			
				        	 	text: val.nom_actividad,
				        	 	icon: "glyphicon glyphicon-list-alt",
				        	 	state: {							    
								    expanded: false							    
								  },
				        	 	nodes: []	        
				        	 }

			        	 	folder_array.push(folder)

			        	 	var file = {
				        	 	text: '<strong>'+val.nombre+' : </strong> | <strong> Sub-Total: $</strong>'+accounting.formatNumber(val.valor,options_format)+' | <strong> IVA: $</strong>'+accounting.formatNumber(val.iva,options_format)+' | <strong> Total: $</strong>'+accounting.formatNumber(val.total,options_format)+' | '+' <strong> Sub-Total Valor contratado: $</strong>'+accounting.formatNumber(val.vc_subtotal,options_format)+' | '+' <strong> Rentabilidad Apróximada: $</strong>'+accounting.formatNumber(val.vc_subtotal - val.valor,options_format)+' | ',
				        	 	icon: "glyphicon glyphicon-usd",
				        	 	selectable: false,			        	 	
				        	 }

				        	 folder.nodes.push(file)
			        	};

	        	 	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++      	 		        		
		        	
		        	 //console.log(folder_array)
		        	 //console.log(sum_files)		        	 		        	 		        	 	      
		        });

				//reasignar nombre al file segun los datos de sum_files
	        	 /**/
	        	 for (var h = 0; h < folder_array.length; h++) {
	    	 		 	
		 		 	if (folder_array[h].text == sum_files[h].nombre) {
		 		 	 	//folder_array[h].text = '<strong>'+sum_files[h].nombre +'</strong> | <strong>Total+IVA: </strong> $'+accounting.formatNumber(sum_files[h].valor,options_format)+' <strong>Total: </strong> $'+accounting.formatNumber(sum_valor[h].valor,options_format)+' <strong>IVA: </strong> $'+accounting.formatNumber(sum_iva[h].valor,options_format)+folder_array[h].texto_grupo
		 		 	 	folder_array[h].text = '<strong>'+sum_files[h].nombre +': </strong> | <strong>Sub-Total: </strong> $'+accounting.formatNumber(sum_valor[h].valor,options_format)+' | <strong>IVA: </strong> $'+accounting.formatNumber(sum_iva[h].valor,options_format)+' | <strong>Total: </strong> $'+accounting.formatNumber(sum_files[h].valor,options_format)+folder_array[h].texto_grupo+
		 		 	 	accounting.formatNumber(folder_array[h].subtotal_actividad - sum_valor[h].valor,options_format)
		 		 	 }
		 		 	 //console.log(folder_array[f].text)
		 		 }

			} else {
				console.log('No hay archivos que mostrar.')
			}
	       			
			$('#tree_presupuesto').treeview({data: folder_array});
			
        	//-----------------------------------------------------------------------------------
	    })
	    .fail(function() {
	        //console.log("error");
	    })
	    .always(function() {
	        //console.log("complete");
	    });

	    //-----------------------------------------------------------------------------------------------
	}

	function getPresupuestoTreeNo(){

		var pkID_proyecto = $("#id_proyecto").val();

		//-----------------------------------------------------------------------------------------------		

		var consulta_presupuesto = "SELECT * FROM `gastos` WHERE `fkID_proyecto` = "+pkID_proyecto+" AND (fkID_actividad = 0 OR fkID_actividad IS null )";

	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_presupuesto+"&tipo=consulta_gen"
	    })
	    .done(function(data) {	    	
	    	
	        //console.log(data)
	        //-----------------------------------------------------------------------------------
	        /**/
	        var tree_data = [];

	        var folder_array = [];

	        var nom_temp = {
        		nom_act:[],
        		nom2_ant:[]
        	};

        	var ant = '';
	        var act = '';

	        function busca_array(valor,array){

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

	        if (data.estado != "Error") {

	        	//variable opciones para el formato dinero----------------------
	        	var options_format = {
					symbol : "$",
					decimal : ",",
					thousand: ".",
					precision : 0,
					format: "%s%v"
				};

				var sum_files = [];
				var sum_iva = [];
				var sum_valor = [];
				//---------------------------------------------------------------

		        $.each(data.mensaje, function(index, val) {
		        	 
		        	 //console.log(index+"--"+val)
		        	 //console.log(val)

		        	 if ( (val.fkID_actividad == 0) || (val.fkID_actividad == null) ) {
		        	 	val.fkID_actividad = 'No Aplica';
		        	 };
		        	 
		        	nom_temp.nom_act.push(val.fkID_actividad);

		        	//console.log(nom_temp.nom_act)
		        	
		        	var searh_array = busca_array(val.fkID_actividad,nom_temp.nom_act);

		        	//console.log(" el valor se repite "+searh_array+" veces.")

		        	var objt_sum = {
	        			nombre:'',
	        			valor:0
	        		}

	        		var objt_sumIva = {
	        			nombre:'',
	        			valor:0
	        		} 
		        	
		        	var objt_sumValor = {
	        			nombre:'',
	        			valor:0
	        		}	        
		        	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	        	 		 if ( busca_array(val.fkID_actividad,nom_temp.nom_act) > 1) {

	        	 		 //ya existe el tipo
	        	 		 //console.log('validando = valor:'+val.fkID_actividad+"--val.nom:"+val.fkID_actividad);
	        	 		 //console.log('esta repetido ='+val.fkID_actividad);

	        	 		 var file = {
				        	 	text: '<strong>'+val.nombre+' : </strong> | <strong> Sub-Total: $</strong>'+accounting.formatNumber(val.valor,options_format)+' | <strong> IVA: $</strong>'+accounting.formatNumber(val.iva,options_format)+' | <strong> Total: $</strong>'+accounting.formatNumber(val.total,options_format)+' | ',
				        	 	icon: "glyphicon glyphicon-usd",
				        	 	selectable: false,			        	 		      
				        	 }

	        	 		 //------------------------------------------------------      	 		 

	        	 		 for (var f = 0; f < folder_array.length; f++) {
	        	 		 	
	        	 		 	if (folder_array[f].text == val.fkID_actividad) {
	        	 		 	 	folder_array[f].nodes.push(file)
	        	 		 	 }
	        	 		 	 //console.log(folder_array[f].text)
	        	 		 }

	        	 		 //sum_files
	        	 		 for (var g = 0; g < sum_files.length; g++) {
	        	 		 	
	        	 		 	if (sum_files[g].nombre == val.fkID_actividad) {
	        	 		 	 	sum_files[g].valor = parseInt(sum_files[g].valor) + parseInt(val.total)
	        	 		 	 }
	        	 		 	 //console.log(folder_array[f].text)
	        	 		 }
	        	 		 //------------------------------------------------------

	        	 		 //sum_iva
	        	 		 for (var i = 0; i < sum_iva.length; i++) {
	        	 		 	
	        	 		 	if (sum_iva[i].nombre == val.nom_actividad) {
	        	 		 	 	sum_iva[i].valor = parseInt(sum_iva[i].valor) + parseInt(val.iva)
	        	 		 	 }
	        	 		 	 //console.log(folder_array[f].text)
	        	 		 }
	        	 		 //------------------------------------------------------

	        	 		 //sum_iva
	        	 		 for (var j = 0; j < sum_valor.length; j++) {
	        	 		 	
	        	 		 	if (sum_valor[j].nombre == val.nom_actividad) {
	        	 		 	 	sum_valor[j].valor = parseInt(sum_valor[j].valor) + parseInt(val.valor)
	        	 		 	 }
	        	 		 	 //console.log(folder_array[f].text)
	        	 		 }
	        	 		 //------------------------------------------------------

			        	} else{

			        		objt_sum.nombre = val.fkID_actividad
			        		objt_sum.valor = parseInt(val.total) + parseInt(objt_sum.valor)

			        		sum_files.push(objt_sum)

			        		//----------------------------------------------------
			        		//Sumatoria iva
			        		objt_sumIva.nombre = val.nom_actividad
			        		objt_sumIva.valor = parseInt(val.iva) + parseInt(objt_sumIva.valor)

			        		sum_iva.push(objt_sumIva)

			        		//----------------------------------------------------
			        		//Sumatoria valor
			        		objt_sumValor.nombre = val.nom_actividad
			        		objt_sumValor.valor = parseInt(val.valor) + parseInt(objt_sumValor.valor)

			        		sum_valor.push(objt_sumValor)
			        		//----------------------------------------------------

			        		var folder = {
				        	 	text: val.fkID_actividad,
				        	 	icon: "glyphicon glyphicon-list-alt",
				        	 	state: {							    
								    expanded: false							    
								  },
				        	 	nodes: []	        
				        	 }

			        	 	folder_array.push(folder)

			        	 	var file = {
				        	 	text: '<strong>'+val.nombre+' : </strong> | <strong> Sub-Total: $</strong>'+accounting.formatNumber(val.valor,options_format)+' | <strong> IVA: $</strong>'+accounting.formatNumber(val.iva,options_format)+' | <strong> Total: $</strong>'+accounting.formatNumber(val.total,options_format)+' | ',
				        	 	icon: "glyphicon glyphicon-usd",
				        	 	selectable: false,			        	 	
				        	 }

				        	 folder.nodes.push(file)
			        	};

	        	 	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++      	 		        		
		        	
		        	 //console.log(folder_array)
		        	 //console.log(sum_files)		        	 		        	 		        	 	      
		        });

				//reasignar nombre al file segun los datos de sum_files
	        	 /**/
	        	 for (var h = 0; h < folder_array.length; h++) {
	    	 		 	
		 		 	if (folder_array[h].text == sum_files[h].nombre) {
		 		 	 	folder_array[h].text = '<strong>'+sum_files[h].nombre +': </strong> | <strong>Sub-Total: </strong> $'+accounting.formatNumber(sum_valor[h].valor,options_format)+' | <strong>IVA: </strong> $'+accounting.formatNumber(sum_iva[h].valor,options_format)+' | <strong>Total: </strong> $'+accounting.formatNumber(sum_files[h].valor,options_format)
		 		 	 }
		 		 	 //console.log(folder_array[f].text)
		 		 }

			} else {
				console.log('No hay archivos que mostrar.')
			}
	       			
			$('#tree_presupuestoNo').treeview({data: folder_array});
			
        	//-----------------------------------------------------------------------------------
	    })
	    .fail(function() {
	        //console.log("error");
	    })
	    .always(function() {
	        //console.log("complete");
	    });

	    //-----------------------------------------------------------------------------------------------
	}

	getPresupuestoTree();

	getPresupuestoTreeNo();
	
});

