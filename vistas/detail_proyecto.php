<?php 

	include("../controller/muestra_pagina.php");

	$muestra_detail_proyecto = new mostrar();

	//---------------------------------------------------------
	$pagina = "cont_detail_proyecto.php";
	$scripts = array('helper_proyecto.js','cont_detail_proyecto.js','cont_documentos_proyecto.js','cont_detail_proyecto_tdocumento.js','cont_detail_proyecto_tdocumento_select.js','cont_personal.js','cont_detail_proyecto_actividad.js','cont_detail_proyecto_treePresupuesto.js','cont_detail_proyecto_treeIngresos.js','cont_detail_proyecto_actividad_filtro.js','cont_detail_proyecto_autocompletaPersonal.js','cont_detail_proyecto_observaciones.js');
	//$perfiles_in = array('Administrador');
	$id_modulo = 7;
	//---------------------------------------------------------

	$muestra_detail_proyecto->mostrar_pagina_scripts_proyecto($pagina,$scripts,$id_modulo,$_GET["id_proyecto"]);

 ?>