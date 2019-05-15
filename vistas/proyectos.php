<?php 

	include("../controller/muestra_pagina.php");

	$muestra_proyectos = new mostrar();

	//---------------------------------------------------------
	$pagina = "cont_proyectos.php";
	$scripts = array('helper_proyecto.js','cont_proyectos1.js','cont_proyectos_date.js','cont_entidades_insert1.js','cont_entidades_select.js', 'cont_proyectos_usuarios.js','cont_proyectos_observaciones.js', 'helper_proyectos_filtro.js', 'cont_proyectos_filtro_empresa.js');
	//$perfiles_in = array('Administrador');
	$id_modulo = 4;
	//---------------------------------------------------------

	$muestra_proyectos->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);

 ?>