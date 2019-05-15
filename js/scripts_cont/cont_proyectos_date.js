$(function(){
	
	console.log('Hola fecha proyectos.');


	var options_format = {
		symbol : "$",
		decimal : ",",
		thousand: ".",
		precision : 0,
		format: "%s%v"
	};

	//---------------------------------------------------------------
	
	//---------------------------------------------------------------
	//inicializacion del plugin de fecha datetimepicker

	//calendario para la fecha de inicio
	$( "#fechaIni" ).datepicker({
		dateFormat: "yy-mm-dd",
		onClose: function( selectedDate ) {
	        $( "#fechaFin" ).datepicker( "option", "minDate", selectedDate );
	      }			
	});
	//calendario para la fecha de inicio
	$( "#fechaFin" ).datepicker({
		dateFormat: "yy-mm-dd"			
	});	
	//---------------------------------------------------------------

	//mascara de dinero para cuantia
	//$('#cuantia').mask('000000000000000', {reverse: true});
	
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
		var por = parseFloat(($("#iva_percent").val())/100);
		var valor_im = parseFloat($('#subtotal').val() );
		var iva_to = por * valor_im;
		console.log(iva_to);
		$("#iva").val(iva_to);
		$("#iva_mask").val(accounting.formatNumber(iva_to,options_format));
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

	/*MM: Agregado para modificar iva y recalcular total 20171222*/
    $('#iva_percent').change(function(event) {
        /* Act on the event */
        //console.log($(this).val());
        var val_cuantia = $(this).val();
        //var val_replace = val_cuantia.replace(".", "");
        $('#iva_percent').val(remplazar (val_cuantia, ".", ""))
        //console.log(remplazar (val_cuantia, ".", ""))

        /*Agregado para calcular valor de iva 20171222*/
        var iva_prueba = parseFloat(($("#iva_percent").val())/100)*$("#subtotal").val();
        console.log("MM2...ivaprueba..."+parseFloat(iva_prueba));
        $("#iva").val(iva_prueba);
        $('#iva_mask').val(accounting.formatNumber(iva_prueba,options_format));
        var aa = $('#iva_mask').val();
        console.log("MM2... ivamask.."+aa)

        var valor_im = parseInt($('#subtotal').val() );
        var iva_im = parseInt( $('#iva').val() );
        var total_im = valor_im + iva_im;

        $("#total").val(total_im);
        //toca parseralo de alguna forma----------------------
        
        $("#total_mask").val(accounting.formatNumber(total_im,options_format));
                             /*Fin agregado*/

    });
    /*MM: Fin Agregado para modificar iva y recalcular total 20171222*/



	//-----------------------------------------


	//click al detalle en cada fila-----------------------------------------------------------------
	$('.table').on( 'click', '.detail', function () {
	  window.location.href = $(this).attr('href');
	} );

	//----------------------------------------------------------------------------------------------

});