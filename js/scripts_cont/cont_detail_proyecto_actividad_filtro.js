$(function(){
	//
	console.log('hola filtro de actividades...')

	var id = '';
	var idDocs = '';

	function crea_consulta(){

		console.log('el valor seleccionado es: '+id)
		console.log('el valor seleccionado es: '+idDocs)

		var cons_final = '';
		var cons_finalDocs = '';

		if (id == '') {
			cons_final = '*';
		} else{
			cons_final = 'actividad.pkID = '+id;
		};

		if (idDocs == '') {
			cons_finalDocs = '*';
		} else{
			cons_finalDocs = 'documentos.fkID_tipo = '+idDocs;
		};
		//id_proyecto
		location.href="detail_proyecto.php?id_proyecto="+$("#id_proyecto").val()+"&filter_gastos="+cons_final+"&filter_documentos="+cons_finalDocs;
		//console.log("detail_proyecto.php?id_proyecto="+$("#id_proyecto").val()+"&filter_gastos="+cons_final+"&filter_documentos="+cons_finalDocs);
	} 
	

	$("#actividad_filtro").change(function(event) {
		/* Act on the event */
		id = $(this).val();
	});

	$("#btn_filtrar").click(function(event) {		
		crea_consulta();
	});

	//-----------------------------------------------------------------------------------------------------------
	//filtro documentos

	
	$("#documentos_filtro").change(function(event) {
		/* Act on the event */
		idDocs = $(this).val();
	});

	$("#btn_filtrarDocumentos").click(function(event) {		
		crea_consulta();
	});



});