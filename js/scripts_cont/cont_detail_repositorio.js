$(function(){
	 
	//-----------------------------------------
	uppercaseForm("form_detail_repositorio");
	//-----------------------------------------

	 $('#btn_nuevodetail_repositorio').jquery_controllerV2({
	 	nom_modulo:'detail_repositorio',
  		titulo_label:'Nuevo Archivo'
	 });
	 
	 $('#btn_actiondetail_repositorio').jquery_controllerV2({
		tipo:'inserta/edita',
  		nom_modulo:'detail_repositorio',
  		nom_tabla:'archivos_repositorio',
        subida : true,
  		recarga:true,
  		ejecutarFunction:true,
  		functionBefore:function(ajustes){                
            console.log('Ejecutando antes de cualquier cosa!!!');
            //$("#btn_actiondetail_repositorio").attr('disabled', 'true');                
        } 
	 });	 

	 //---------------------------------------------------
	  //Valida el archivo
	  $("#archivo").validaArchivo('archivo','detail_repositorio','url_archivo');
	  //---------------------------------------------------
	 
	 $("[name*='edita_detail_repositorio']").jquery_controllerV2({
		tipo:'carga_editar',
  		nom_modulo:'detail_repositorio',
  		nom_tabla:'archivos_repositorio',
  		titulo_label:'Edita Archivo',
  		tipo_load:1
	 });

	$("[name*='elimina_detail_repositorio']").jquery_controllerV2({
  		tipo:'eliminar',
  		nom_modulo:'detail_repositorio',
  		nom_tabla:'archivos_repositorio'
  	});
	 
	//---------------------------------------------------------
});
