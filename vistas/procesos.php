<?php 

	include("../controller/muestra_pagina.php");

	$muestra_procesos = new mostrar();

	//---------------------------------------------------------
	$pagina = "cont_procesos.php";
	$scripts = array('helper_procesos.js','helper_procesos_mod.js','cont_procesosCod.js','cont_procesos1.js','cont_entidades_insert1.js','cont_entidades_select.js','cont_procesos_btnAsignar3.js','cont_procesos_observaciones.js', 'cont_procesos_estadistica.js');
	//$perfiles_in = array('Administrador','lider');
	$id_modulo = 3;
	//---------------------------------------------------------

	$muestra_procesos->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);

 ?>