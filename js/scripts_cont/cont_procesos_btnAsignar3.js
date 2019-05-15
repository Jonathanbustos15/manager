$(function(){
	/*functions here*/
	//console.log('Hola desde btn asignar 3');

	//--------------------------------------------------------------------------------------------------
	$("[name*='aprobar_asignar']").click(function(event) {
		//
		console.log('aprobar o asignar proceso '+$(this).attr('data-id-proceso'));
		
		//abre el modal
		//$("#form_modal_aprobar_asignar").modal("show");

		//define el id del proceso en el objeto
		id_proceso = $(this).attr('data-id-proceso');
		//ejecuta la accion para crear el select
		console.log(id_proceso);
		action_asig.crea_asig();

	});

});		