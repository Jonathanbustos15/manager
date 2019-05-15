(function($){

	var progreso = 0;
	var style_progreso = 0;

	$.fn.validaForm = function (min_width,icons,barra,pariente){

		var selector = $(this);

		console.log('ejecutando validaForm en '+this[0].id);

		function crear_progress(){

			if ($("#barra_progreso_div").length > 0) {
				console.log('la barra de progreso ya está');
			} else{				

				console.log(selector)

				$(selector).after('<div id="barra_progreso_div" class="progress">'+
		                            '<div id="barra_progreso" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 0em;">'+
		                                '0%'+
		                            '</div>'+
		                        '</div>');
			};
			
		}

		function contador(val_pro,val_style){
			// body...
			crear_progress();

			progreso = progreso + val_pro;
			style_progreso = style_progreso + val_style;

			$("#barra_progreso").attr('aria-valuenow', progreso);
			$("#barra_progreso").html(progreso+'%');
			$("#barra_progreso").attr('style', 'min-width: '+style_progreso+'em;');

			console.log('el progreso va en '+progreso);
			if (progreso == 100) {
				$("#barra_progreso").attr('class', 'progress-bar progress-bar-success');
			};
		}

		function descontador(val_pro,val_style){
			// body...
			crear_progress();

			progreso = progreso - val_pro;
			style_progreso = style_progreso - val_style;

			$("#barra_progreso").attr('aria-valuenow', progreso);
			$("#barra_progreso").html(progreso+'%');
			$("#barra_progreso").attr('style', 'min-width: '+style_progreso+'em;');

			console.log('el progreso va en '+progreso);
			if (progreso == 100) {
				$("#barra_progreso").attr('class', 'progress-bar progress-bar-warning');
			}else{
				$("#barra_progreso").attr('class', 'progress-bar progress-bar-warning');
			};
		}

		//----------------------------------------------------------------------------

		var min_width_pro = 0;
		var pro_form = 0;	
		var cant_dom_req = 0;

		$.each($(selector)[0], function(index, val) {

			 console.log('index: '+index+' val: '+val)
			 console.log(val.required)

			 if (val.required == true) {
			 	cant_dom_req = cant_dom_req + 1;
			 };	

		});

		console.log(cant_dom_req);		

		function matematica_progress(min_width){

			console.log(min_width);

			min_width_pro = min_width / 100;
			pro_form = 100 / cant_dom_req;

			var val_fin = min_width_pro * pro_form;

			return val_fin;
		}

		//pone todos en 0
		$(".form-control").attr('pasoValida',0);

		//--------------------------------------------------------------------

		$(".form-control").change(function(event) {
			/* Act on the event */
			pro_form_cont = 100 / cant_dom_req;

			var control_ant = '';
			var control_act = '';

			//identificar el control en el que esta
			console.log($(this))
			console.log($(this)[0]["value"])
			console.log($(this)[0]["required"])
			console.log($(this)[0]["type"])

			if(($(this)[0]["value"]=="") && ($(this)[0]["required"] == true)){
	            
	            //pone el estilo rojo	            

	            var padre = $(this).parent();

	            var abuelo = padre.parent();

	            console.log(pariente);

	            if (pariente == 'dad') {
	            	padre.attr('class', 'form-group has-error has-feedback');
	            } else if (pariente == 'grandpa'){
	            	abuelo.attr('class', 'form-group has-error has-feedback');
	            };

	            //abuelo.attr('class', 'form-group has-error has-feedback');
	            //padre.attr('class', 'form-group has-error has-feedback');

	            //----------------------------------------------------------

	            if (icons == true) {

	            	/*
	            	if (pariente == 'dad') {
		            	padre.children('span').remove();
		            } else if (pariente == 'grandpa'){
		            	abuelo.children('span').remove();
		            };*/
		            
	            	padre.children('span').remove();
	            	//console.log(padre.children('span'));

	            	$(this).after('<span class="glyphicon glyphicon-remove form-control-feedback validaRemove" aria-hidden="true"></span>');

	            };
	            
	            if (  ( (progreso > 0) || (progreso == 100) ) && ($(this).val() == "") ) {
					$(this).attr('pasoValida',0);

					if (barra == true) {

						descontador(pro_form_cont,matematica_progress(min_width));
					};
				};
	            
				//-----------------------------------------------------------------------------------------------------


	          }else if ( ($(this)[0]["value"]!="") && ($(this)[0]["required"] == true) ){
	            
	            //pone el estilo verde
	            
	            var padre = $(this).parent();

	            var abuelo = padre.parent();

	            console.log(pariente);

	            if (pariente == 'dad') {
	            	padre.attr('class', 'form-group has-success has-feedback');
	            } else if (pariente == 'grandpa'){
	            	abuelo.attr('class', 'form-group has-success has-feedback');
	            };

	            //abuelo.attr('class', 'form-group has-success has-feedback');
	            //padre.attr('class', 'form-group has-success has-feedback');

	            //------------------------------------------------------------

	            if (icons == true) {

	            	/*if (pariente == 'dad') {
		            	padre.children('span').remove();
		            } else if (pariente == 'grandpa'){
		            	abuelo.children('span').remove();
		            };*/

	            	padre.children('span').remove();
	            	
	            	$(this).after('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>');

	            };	            

	            //-----------------------------------------------------------------------------------------------------	          

				if ( ( (progreso == 0) || (progreso < 100) ) && ($(this).attr('pasoValida') == 0) ) {
					$(this).attr('pasoValida',1);

					if (barra == true) {
						contador(pro_form_cont,matematica_progress(min_width));
					};

				}else if ( ( (progreso == 0) || (progreso < 100) ) && ($(this).attr('pasoValida') == 1) ) {
					
				};

				//contador(pro_form_cont,matematica_progress(min_width));	
				
				//-----------------------------------------------------------------------------------------------------

	          }

		});
	};

})(jQuery);