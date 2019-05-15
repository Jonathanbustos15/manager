$(function(){
	
	console.log('Hola fecha empresas.');


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


	//-----------------------------------------

	//click al detalle en cada fila-----------------------------------------------------------------
	$('.table').on( 'click', '.detail', function () {
	  window.location.href = $(this).attr('href');
	} );

	//----------------------------------------------------------------------------------------------

});