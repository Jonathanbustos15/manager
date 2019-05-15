$(function(){
	/*functions here*/
	console.log('Hola desde filtro proyecto.');

	var id = '';

	function crea_consulta(){

		console.log('el valor seleccionado es: '+id)
		
		var cons_final = '';		

		if (id == '') {
			cons_final = '*';
		} else{
			cons_final = 'estado_proyecto.pkID = '+id;
		};
		
		//id_proyecto
		location.href="proyectos.php?filter="+cons_final;		
	}


	$("#estado_filtro").change(function(event) {
		/* Act on the event */
		id = $(this).val();
	});

	$("#btn_filtrar").click(function(event) {		
		crea_consulta();
	});

});