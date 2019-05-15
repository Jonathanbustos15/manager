$(function(){
	/*functions here*/
	console.log('Hola autocompletado en personal');

	/**/
	//-------------------------------------------------------------------
	//autocomplete beneficiario
	$( "#personal_autocompleta" ).autocomplete({
      source: "../DAO/cpc_personal.php",
      select: function( event, ui ) {
        console.log(ui)
        $("#fkID_hv").val(ui.item.id);
      },
      change: function( event, ui ) {
      	//console.log('Ha cambiado el valor!')
      	console.log(ui)
      	if (ui.item == null) {
      		//console.log('No selecciono nada viejo...')
      		alert("El personal que selecciono no es válido.")
      		$("#fkID_hv").val("")      		
      		$(this).val("")
      		$(this).focus();
      	};
      },
      focus: function( event, ui ) {
      	//console.log(ui);
      }
    });
    //--------------------------------------------------------------------    
	//estilo z index para hacer visible el autocompletado
    $("#ui-id-1").attr('style', 'display: none; top: 365px; left: 407px; z-index: 2147483647; width: 443px;');
    //-------------------------------------------------------------------
	
});