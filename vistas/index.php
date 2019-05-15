<?php

include "../controller/muestra_pagina.php";

$muestra_inicial = new mostrar();

//$scripts = array('index_bars.js');

$scripts = array('cont_index.js');

$muestra_inicial->mostrar_pagina("cont_index.php", $scripts);
