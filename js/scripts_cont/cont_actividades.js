$(function(){

	uppercaseForm("form_actividad");
	 
	var options_format = {
		symbol : "$",
		decimal : ",",
		thousand: ".",
		precision : 0,
		format: "%s%v"
	};
	 
	 $('#btn_nuevoactividad').jquery_controllerV2({
	 	nom_modulo:'actividad',
  		titulo_label:'Nuevo Actividad'
	 });	 
	 
	 $('#btn_actionactividad').jquery_controllerV2({
	 	tipo:'inserta/edita',
  		nom_modulo:'actividad',
  		nom_tabla:'actividad',
  		recarga:true
	 });
	 
	 $('[name*="edita_actividad"]').jquery_controllerV2({
	 	tipo:'carga_editar',
  		nom_modulo:'actividad',
  		nom_tabla:'actividad',
  		titulo_label:'Edita Actividad',
  		tipo_load:1,
  		ejecutarFunction:true,
  		functionResCarga:function(id,data){
  			//console.log(data)
  			$('#subtotal_mask').val(accounting.formatNumber(data.mensaje[0].subtotal,options_format));
			$('#iva_mask').val(accounting.formatNumber(data.mensaje[0].iva,options_format));
			$('#total_mask').val(accounting.formatNumber(data.mensaje[0].total,options_format));
  		}
	 });
	 
	 $('[name*="elimina_actividad"]').jquery_controllerV2({
	 	tipo:'eliminar',
  		nom_modulo:'actividad',
  		nom_tabla:'actividad'
	 });
	 
	//---------------------------------------------------------

	$('#subtotal_mask').mask('000.000.000.000.000', {reverse: true});
	$('#iva_mask').mask('000.000.000.000.000', {reverse: true});
	$('#total_mask').mask('000.000.000.000.000', {reverse: true});

	function remplazar (texto, buscar, nuevo){
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

	$('#subtotal_mask').change(function(event) {
		/* Act on the event */
		//console.log($(this).val());
		var val_cuantia = $(this).val();
		//var val_replace = val_cuantia.replace(".", "");
		$('#subtotal').val(remplazar (val_cuantia, ".", ""))
		//console.log(remplazar (val_cuantia, ".", ""))
	});

	$('#iva_mask').keyup(function(event) {
		/* Act on the event */
		//console.log($(this).val());
		var val_cuantia = $(this).val();
		//var val_replace = val_cuantia.replace(".", "");
		$('#iva').val(remplazar (val_cuantia, ".", ""))
		//console.log(remplazar (val_cuantia, ".", ""))
		var valor_im = parseInt($('#subtotal').val() );
		var iva_im = parseInt( $('#iva').val() );
		var total_im = valor_im + iva_im;

		$("#total").val(total_im);
		//toca parseralo de alguna forma----------------------
		
		$("#total_mask").val(accounting.formatNumber(total_im,options_format));
	});
	//-----------------------------------------
});
