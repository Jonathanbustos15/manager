(function(){

	self.helper_procesos = function(){
		console.log('Hola desde helper procesos.')
	}

	
	//Funcines estadistica en vista general
	//----------------------------------------------------------------
 	self.cons_proceso_filtro=function(filtro,rango_fechas){

		var consulta_proceso = "select procesos.*, pasos_proceso.nombre as nom_paso, entidades.nombre_entidad as nom_entidad, estado_proceso.nombre as nom_estado, tipo_proceso.nombre as nom_tipo"+

								" FROM procesos"+ 

								" INNER JOIN pasos_proceso ON pasos_proceso.pkID = procesos.fkID_paso_actual"+

								" INNER JOIN entidades on entidades.pkID = procesos.fkID_entidad"+

								" INNER JOIN estado_proceso on estado_proceso.pkID = procesos.fkID_estado"+

								" INNER JOIN tipo_proceso on tipo_proceso.pkID = procesos.fkID_tipo ";

		//-------------------------------------------------------------------------------------------------
		//define el tipo de consulta según el parámetro
		if (filtro != "*") {
			consulta_proceso += " WHERE ("+filtro+") AND ("+rango_fechas+") order by procesos.pkID desc ";
		} else {
			consulta_proceso += " WHERE "+rango_fechas+" ORDER BY fecha_cierre ";
		};
		/*
		console.log(consulta_proceso);*/
		//-------------------------------------------------------------------------------------------------
		
		return $.ajax({
			async: false,
			cache:false,
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_proceso+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	//------------------------------------------
	        //this.paso_reciente = data.mensaje[0].idPaso2;		        
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        //console.log("complete");
	    });
		/*---------------------------------------------------*/

	}

	/**/
	self.estadistica = {

		todo : 0,
		valor_uni : 0,
		nombre : "",
		filtro : "",
		rango_fechas : "",
		set_todo : function(){

			var todo_exe = cons_proceso_filtro("*",this.rango_fechas);

			todo_exe.success(function(data){

				if (data.estado == "ok") {
					//asigna la global todo

					if (data.mensaje.length > 0) {

						estadistica.todo = data.mensaje.length;
						//estadistica.set_valor_uni();

					} else {
						estadistica.todo = 0;
						//estadistica.set_valor_uni();						
					}				

				} else {
					//alert("No se logró ejecutar la consulta de estadística.")
					estadistica.todo = 0;
					//estadistica.set_valor_uni();
				}

			}).complete(function(){
				//ejecuta solo cuando hace complete
				estadistica.set_valor_uni();
				//console.log(estadistica);
			});

		},
		set_valor_uni : function(){

			var procesos = cons_proceso_filtro(this.filtro,this.rango_fechas);

				procesos.success(function(data){
					
					//console.log(data);

					if (data.estado == "ok") {

						if (data.mensaje.length > 0) {

							estadistica.valor_uni = data.mensaje.length;
							
							//console.log(data.mensaje.length);
							
							//estadistica.calcular();

						} else {
							estadistica.valor_uni = 0;
							//estadistica.calcular();						
						}

					} else {
					//alert("No se logró ejecutar la consulta de estadística.")
						estadistica.valor_uni = 0;
						//estadistica.calcular();
					}

				}).complete(function(){
					//ejecuta solo cuando hace complete
					estadistica.calcular();
				});

		},
		set_estadistica : function(){

			console.log(this.nombre);
			console.log(this.filtro);
			console.log(this.rango_fechas);
			
			//setea valores
			this.set_todo();
						
		},
		calcular : function(){

			console.log("todo: "+this.todo);

			var valor_uni_p = estadistica.valor_uni * 100;

			console.log("valor_uni_p: "+valor_uni_p);

			var porcentage = Math.round(valor_uni_p / estadistica.todo);

			console.log("porcentage: "+porcentage);

			//
			//$("#div-estadistica-procesos").html("");			

			$("#div-estadistica-procesos").append('<strong>'+estadistica.nombre+':</strong> '+estadistica.valor_uni+' --> '+porcentage+'%'+
				'<div class="progress">'+
				  '<div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="'+porcentage+'" aria-valuemin="0" aria-valuemax="100" style="width: '+porcentage+'%">'+
				    '<span class="sr-only">'+porcentage+'% '+estadistica.nombre+'</span>'+				    	
				  '</div>'+
				'</div>');

			//this.calcular_100();			

		},
		calcular_100 : function(){
			console.log("calculando 100")
			$("#div-estadistica-procesos").append('<strong>Total de procesos:</strong> '+this.todo+' --> 100%'+	    	
	    		'<div id="estadistica_total" class="progress">'+
				  '<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">'+
				    '<span class="sr-only">100%</span>'+				  
				  '</div>'+
				'</div>');
		}

	};

	//----------------------------------------------------------------


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
 	//sistema de tabs para la vista general
 	//sessionStorage.setItem("id_tab_proceso_gen",null);

 	var id_li_activo = sessionStorage.getItem("id_tab_proceso_gen");	

	//console.log($("[role=presentation]"));

	console.log(id_li_activo);

	//dependiendo de los li en detalles de procesos

	if( (id_li_activo == "") || (id_li_activo == "null") || (id_li_activo == null) || (id_li_activo == "li_general") || (id_li_activo == "li_seguimiento") || (id_li_activo == "li_documentos") ){

		$("#li_p_oferta").addClass('active');

		$("#p_oferta").addClass('active');

	}else{

		$("#"+id_li_activo).addClass('active');

		$('ul a[href="#'+id_li_activo.slice(3,20)+'"]').tab('show');

		$("#"+id_li_activo.slice(3,20)).addClass('active');

		//console.log( $('ul a[href="#'+id_li_activo.slice(3,20)+'"]') );
	}	

	
	$("[role=presentation]").click(function(event) {
		/* Act on the event */
		id_li_activo = $(this)[0].id;

		console.log($(this)[0].id);

		// Store
		sessionStorage.setItem("id_tab_proceso_gen", $(this)[0].id);
	});
	//----------------------------------------------------------------

})();