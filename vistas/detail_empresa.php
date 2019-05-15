<?php 

	include("../controller/muestra_pagina.php");

	$muestra_detail_empresa = new mostrar();

	//---------------------------------------------------------
	$pagina = "cont_detail_empresa.php";

	$scripts = array('cont_detail_empresa.js','cont_certificacion_empresa.js' ,'cont_entidades_select.js', 'cont_empresas_date.js','cont_indicadores_financieros.js', 'cont_documentolegal_empresa.js', 'cont_entidades_insert1.js','cont_hvida_estudios.js');
	//$perfiles_in = array('Administrador');
	$id_modulo = 24;
	//---------------------------------------------------------

	$muestra_detail_empresa->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);

 ?>