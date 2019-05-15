<?php

include "../controller/muestra_pagina.php";

$muestra_recursos = new mostrar();

//---se obtienen los datos de el cuerpo de la pgina y los script de jscript------------------------------------------------------
$pagina  = "cont_recursos.php";
$scripts = array('cont_recursos.js', 'cont_recursos_contratos.js ', 'cont_hvida.js', 'cont_hvida_functions.js', 'cont_hvida_estudiosPos.js', 'cont_hvida_filtro.js');

//---------------------------------------------------------
$id_modulo = 28;
//---------------------------------------------------------

$muestra_recursos->mostrar_pagina_scripts($pagina, $scripts, $id_modulo);
