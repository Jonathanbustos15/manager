(function(){
	//helper para ingresos general

	self.id_empresa = 0;
	self.selector_filtro = '';

	self.options_format = {
		symbol : "$",
		decimal : ",",
		thousand: ".",
		precision : 0,
		format: "%s%v"
	};


	self.remplazar = function (texto, buscar, nuevo){
	    var temp = '';
	    var long = texto.length;
	    for (j=0; j<long; j++) {
	        if (texto[j] == buscar) 
	        {
	            temp += nuevo;
	        } else
	            temp += texto[j];
	    }
	    return temp;
	}

	//---------------------------------------------------------------------------------------------------
	self.cons_fuente_empresa=function(){

		var consulta_fuente = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado "+

								" FROM `proyectos`"+

								" INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad"+

								" INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado"+
				                
				                " WHERE proyectos.fkID_empresa = "+id_empresa+" AND proyectos.fkID_estado = 2"+

								" ORDER BY entidades.nombre_entidad";

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_fuente+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	//------------------------------------------
	        //this.paso_reciente = data.mensaje[0].idPaso2;		        
	    })
	    .fail(function() {
	        console.log("error");
	        //quita todo? o pone todo?
	        //location.reload();
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/
	}

	self.cons_fuente_empresa_todo=function(){

		var consulta_fuente = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado "+

								" FROM `proyectos`"+

								" INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad"+

								" INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado"+

								" WHERE proyectos.fkID_estado != 1"+				               				               

								" ORDER BY entidades.nombre_entidad";

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_fuente+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	//------------------------------------------
	        //this.paso_reciente = data.mensaje[0].idPaso2;		        
	    })
	    .fail(function() {
	        console.log("error");
	        //quita todo? o pone todo?
	        //location.reload();
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/
	}

	self.fill_fuente=function(){

		if (id_empresa=='Todo' || id_empresa=='') {
			
			var fuente_todo = cons_fuente_empresa_todo();

			fuente_todo.success(function(data){
				console.log(data);
				itera_fuente(data);
			});

		} else{

			var data_fuente = cons_fuente_empresa();

			data_fuente.success(function(data){
				console.log(data);
				itera_fuente(data);			
			});

		};
		
	}

	self.itera_fuente=function(data){

		$("#"+selector_filtro).html('');
					
		$("#"+selector_filtro).append('<option>No Aplica</option>');

		if (data.estado == "ok") {

			$("#"+selector_filtro).removeAttr('disabled');

			$.each(data.mensaje, function(index, val) {							
				 $("#"+selector_filtro).append('<option value="'+val.pkID+'">'+val.nom_entidad+' : '+val.nombre+'</option>');			 
			});

		} else{

			$("#"+selector_filtro).html('');
			$("#"+selector_filtro).attr('disabled', 'true');
		};
	}
	//---------------------------------------------------------------------------------------------------
	//clase para la suma de impuestos
	self.keyupTax = function(){		
		this.rete_ica = $('#rete_ica_mask');
		this.rete_iva = $('#rete_iva_mask');
		this.rete_fuente = $('#rete_fuente_mask');
		this.otra_retencion = $('#otra_retencion_mask');
		this.total = $("#total_retencion");
		this.total_r = $("#total_recibido");
		//-----------------------------------------
		this.inputs = [];
		//this.inResults = {};
	}

	self.keyupTax.prototype = {

		init: function(){

			var self = this;

			//setea los inputs en un array global
			this.setArrInputs()

			//console.log(this.inputs)			
			this.setKeyUpInputs()
		},
		getValTax: function(input){
			return parseFloat((input.val())/100);
		},
		setKeyUpInputs: function(){

			var self = this;

			$.each(this.inputs, function(index, val) {
				//define evento keyup para todos los impuestos
				console.log($(val).val())

				$(val).keyup(function(event) {					
					console.log(event)
					self.sumDataProd()
				});
			});
		},
		sumDataProd: function(){

			var self = this;

			let sumVals = 0;

			var it = $.each(this.inputs, function(index, val) {
				let prod = parseFloat( $("#"+$(this)[0]["id"].replace("_mask", "")).val() );
				console.log(prod)
				sumVals = prod !== undefined ? sumVals + parseFloat(prod) : sumVals + 0;
			});

			$.when(it).then(function(){				
				console.log(sumVals)				
				self.total.val(sumVals)
				$("#total_retencion_mask").val(accounting.formatNumber(sumVals,options_format));
				//total recibido = total - total retencion
				self.total_r.val( parseFloat($("#total").val()) - sumVals)
				$("#total_recibido_mask").val(accounting.formatNumber(self.total_r.val(),options_format));
			});
			
		},
		setArrInputs: function(){

			this.inputs = [				
				this.rete_ica,
				this.rete_iva,
				this.rete_fuente,
				this.otra_retencion				
			]
		}
	}
	//---------------------------------------------------------------------------------------------------


	self.keyUpAccount = function(id){

		$("#"+id+"_mask").mask('000.000.000.000.000', {reverse: true});

  		$("#"+id+"_mask").keyup(function(event) {

  			let rem = remplazar ($(this).val(), ".", "")  		  		
			
			$('#'+id).val( rem )					
			
  		});
  	}

  	//---------------------------------------------------------------------------------------------------
  	//funcion para deshabilitar campos que se pasen por un array
  	self.disableDOMF = function(arr_id_dom){
  		this.arr_id_dom = arr_id_dom;//array con los id de los elementos
  	}

  	self.disableDOMF.prototype = {

  		disableArr: function(){
  			//console.log(this.arr_id_dom)

  			$.each(this.arr_id_dom, function(index, val) {
  				
  				$("#"+val).attr('disabled', 'true');
  			});
  		},
  		enableArr: function(){

  			$.each(this.arr_id_dom, function(index, val) {
  				
  				$("#"+val).removeAttr('disabled');
  			});
  		}
  	}

  	self.fill_periodo=function(){

		if (id_empresa=='Todo' || id_empresa=='') {
			
			var periodo_todo = cons_periodo_empresa_todo();

			periodo_todo.success(function(data){
				console.log(data);
				itera_periodo(data);
			});

		} else{

			var data_periodo = cons_periodo_empresa();
			data_periodo.success(function(data){
				console.log(data);
				itera_periodo(data);			
			});

		};
		
	}

	self.cons_periodo_empresa=function(){

		var consulta_periodo = "select periodo.* FROM `periodo`	 INNER JOIN "+

								" tipo_periodo ON tipo_periodo.pkID = periodo.fkID_tipo_periodo INNER JOIN " +

								" empresa ON tipo_periodo.pkID = empresa.fkID_tipo_periodo WHERE empresa.pkID = "+id_empresa+" " +

								" ORDER BY periodo.nombre";

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_periodo+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	//------------------------------------------
	        //this.paso_reciente = data.mensaje[0].idPaso2;		        
	    })
	    .fail(function() {
	        console.log("error");
	        //quita todo? o pone todo?
	        //location.reload();
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/
	}

	self.cons_periodo_empresa_todo=function(){

		var consulta_periodo = "select periodo.* FROM `periodo`	 INNER JOIN " +

								"tipo_periodo ON tipo_periodo.pkID = periodo.fkID_tipo_periodo INNER JOIN " +
		
								"empresa ON tipo_periodo.pkID = empresa.fkID_tipo_periodo  " +
		
								"ORDER BY periodo.nombre";

		return $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_periodo+"&tipo=consulta_gen",
	    })
	    .done(function(data) {
	    	//------------------------------------------
	        //this.paso_reciente = data.mensaje[0].idPaso2;		        
	    })
	    .fail(function() {
	        console.log("error");
	        //quita todo? o pone todo?
	        //location.reload();
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/
	}

	self.itera_periodo=function(data){

		$("#"+selector_filtroP).html('');
					
		$("#"+selector_filtroP).append('<option>No Aplica</option>');

		if (data.estado == "ok") {

			$("#"+selector_filtroP).removeAttr('disabled');

			$.each(data.mensaje, function(index, val) {							
				 $("#"+selector_filtroP).append('<option value="'+val.pkID+'">'+val.nombre+'</option>');			 
			});

		} else{

			$("#"+selector_filtroP).html('');
			$("#"+selector_filtroP).attr('disabled', 'true');
		};
	}
  	//---------------------------------------------------------------------------------------------------

})();