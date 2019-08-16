<?php
	/**/
	include_once '../DAO/ingresos_gralDAO.php';
		
	class ingresos_gralController extends ingresos_gralDAO{
		
		//public $NameCookieApp;
		public $id_modulo;
		public $ingreso;
		public $empresaSelect;
		public $externoSelect;
		
		public function __construct() {
			
			//include('../conexion/datos.php');
			
			$this->id_modulo = 15;
			//$this->NameCookieApp = $NomCookiesApp;
			
		}
		
		
		//Funciones-------------------------------------------
		//Espacio para las funciones de esta clase.

		public function getSelectEmpresas(){

			$empresaSelect = $this->getEmpresas();

			echo '<select name="fkID_empresa" id="fkID_empresa" class="form-control add-selectElement" required = "true">
                        <option value=""></option>';
                        for ($i=0; $i < sizeof($empresaSelect); $i++) {
                                echo '<option value="'.$empresaSelect[$i]["pkID"].'" >'.$empresaSelect[$i]["nombre"].'</option>';
                            };
            echo '</select>';
		}
		

		public function getSelectExternos(){

			$externoSelect = $this->getExternos();

			echo '<select name="fkID_externo" id="fkID_externo" class="form-control add-selectElement" required = "true">
                        <option></option>';
                        for ($i=0; $i < sizeof($externoSelect); $i++) {
                                echo '<option value="'.$externoSelect[$i]["pkID"].'" >'.$externoSelect[$i]["nombre"].'</option>';
                            };
            echo '</select>';
		}

		public function getSelectPeriodo(){

			$empresaSelect = $this->getPeriodo();

			echo '<select name="fkID_periodo" id="fkID_periodo" class="form-control">
                        <option value=""></option>';
                        for ($i=0; $i < sizeof($empresaSelect); $i++) {
                                echo '<option value="'.$empresaSelect[$i]["pkID"].'" >'.$empresaSelect[$i]["nombre"].'</option>';
                            };
            echo '</select>';
		}
		//-----------------------------------------------------


		public function getTablaingresos_gral($filtro){

	    	if ($filtro == '*') {
				# code...
				echo "<span class='badge'>Empresa: Todas</span>";
				echo "<br> <br>";
				$this->ingreso = $this->getIngresos();

			} else {

				# code...
				$cambio = array("AND", "ingreso_gral.");			

				$campos_str = str_replace($cambio, "", $filtro);

				$arr_campos = explode(" ",$campos_str);

				$arr_completo = array();
				//print_r ($arr_campos);

				echo "<p>Filtrando por:</p>";

				for ($i=0; $i < sizeof($arr_campos) ; $i++) { 
					# code...
					

					$arr_campos1 = explode("=",$arr_campos[$i]);				

					//print_r($arr_campos1);

					if ($arr_campos1[0] == "fkID_empresa") {
						# code...
						$empresaId = $this->getEmpresasId($arr_campos1[1]);

						//print_r($empresaId);

						echo "<span class='badge'>Empresa:".$empresaId[0]["nombre"]."</span>";
					}

					if ($arr_campos1[0] == "fkID_proyecto") {
						# code...
						$proyectoId = $this->getProyectosId($arr_campos1[1]);

						//print_r($proyectoId);

						echo "<span class='badge'>Fuente:".$proyectoId[0]["nom_entidad"].": ".$proyectoId[0]["nombre"]."</span>";
					}

					if ($arr_campos1[0] == "pagado") {

						if ($arr_campos1[1] == "0") {
							# code...

							echo "<span class='badge'>Pagado:No</span>";
						}else{
							echo "<span class='badge'>Pagado:Sí</span>";
						}
					}

					if ($arr_campos1[0] == "pagado_impuesto") {

						if ($arr_campos1[1] == "0") {
							# code...

							echo "<span class='badge'>Declarado:No</span>";
						}else{
							echo "<span class='badge'>Declarado:Sí</span>";
						}
					}

					if ($arr_campos1[0] == "anio") {

						echo "<span class='badge'>Año: ".$arr_campos1[1]."</span>";

					}

					if ($arr_campos1[0] == "fkID_periodo") {

						$periodoId = $this->getPeriodoId($arr_campos1[1]);

						echo "<span class='badge'>Periodo:".$periodoId[0]["nombre"]."</span>";

					}

				}

				echo "<br> <br>";

				$this->ingreso = $this->getIngresosFiltro($filtro);
			}	    	
	    	
	    	//print_r($formatosNoSub);
	    	//mete los formatos sin subcategoria
	    	//array_merge($this->Formatos, $formatosNoSub);

	    	//print_r($this->Formatos);	    	

	    	//valida si hay formatos

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos($this->id_modulo, $_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//--------------------------------------------------------------------------------- 

	    	if( ($this->ingreso) && ($consulta==1) ){

	    		for($a=0;$a<sizeof($this->ingreso);$a++){

                 $id = $this->ingreso[$a]["pkID"];                 
                 $empresa = $this->ingreso[$a]["nom_empresa"];
                 $nom_proyecto = $this->ingreso[$a]["nom_proyecto"];
                 $descripcion = $this->ingreso[$a]["descripcion"];
                 $fecha_ingreso = $this->ingreso[$a]["fecha_ingreso"];
                 $fecha_pago = $this->ingreso[$a]["fecha_pago"];
                 $fecha_radicacion = $this->ingreso[$a]["fecha_radicacion"];
                 $subtotal = $this->ingreso[$a]["subtotal"];
                 $iva = $this->ingreso[$a]["iva"];
                 $total = $this->ingreso[$a]["total"];
                 $total_recibido = $this->ingreso[$a]["total_recibido"];                 
                 $pagado = $this->ingreso[$a]["pagado"];                 

                 echo '<tr';  if (is_null($pagado) || $pagado == '' || $pagado == 0) {
                             	# code...
                             	echo ' style="background-color: red;" ';
                             }
                             echo'>
                             	 
                                 <td>'.$empresa.'</td>
                                 <td>'.$nom_proyecto.'</td>                                                    
                                 <td>'.$descripcion.'</td>
                                 <td>';
                                 if ($pagado==1){
                                 	echo "SI";

                                 }else{
                                 	echo "NO";

                                 }

                                 echo '</td>
                                 <td hidden="true">'.$total_recibido.'</td> 
                                 <td>'.$fecha_radicacion.'</td>
                                 <td>'.$fecha_pago.'</td>
                                 <td>'.'$'.number_format($subtotal, 0, '', '.').'</td>
                                 <td>'.'$'.number_format($total_recibido, 0, '', '.').'</td>
                                 <td>		                         	
		                             <button id="btn_editar" title="Editar" name="edita_ingreso_gral" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_ingreso_gral" data-id-ingreso_gral = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_ingreso_gral" type="button" class="btn btn-danger" data-id-ingreso_gral = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };                


	    	}elseif(($this->ingreso) && ($consulta==0)){

             echo "<tr>
		               
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               		               		               		                                          
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Ingresos General.</strong>  						
				   </div>";
            }else{

             echo "<tr>		               
		               
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               		               		                                           
		           </tr>
		           
		           <div class='alert alert-danger' role='alert'>
		           		En este momento no hay <strong>Ingresos</strong> creados o no coincide con este <strong>Filtro</strong>.
				   </div>";
            };

	    }
	    //---------------------------------------------------------------------------------
	    /**/
	    public function getSumaIngresosVal($filtro){			

			if ($filtro == '*') {
				# code...
				$suma = $this->getSumaIngresos();
			} else {
				# code...
				$suma = $this->getSumaIngresosFiltro($filtro);
			}

			echo number_format($suma[0]['total_ingresos'], 0, '', '.');
		}

		public function getSumaIvaVal($filtro){

			//$suma = $this->getSumaIva();

			if ($filtro == '*') {
				# code...
				$suma = $this->getSumaIva();
			} else {
				# code...
				$suma = $this->getSumaIvaFiltro($filtro);
			}

			echo number_format($suma[0]['total_iva'], 0, '', '.');
		}

		public function getSumaTotalVal($filtro){

			//$suma = $this->getSumaTotal();
/*
			if ($filtro == '*') {
				# code...
				$suma = $this->getSumaTotal();
			} else {
				# code...
				$suma = $this->getSumaTotalFiltro($filtro);
			}

			echo number_format($suma[0]['total_total'], 0, '', '.');
			*/


			if ($filtro == '*') {
				# code...
				$suma = $this->getSumaIngresos();
			} else {
				# code...
				$suma = $this->getSumaIngresosFiltro($filtro);
			}

			echo number_format($suma[0]['total_ingresos'], 0, '', '.');

		}


		/*20180104: Agregado Funtecso*/
		public function getTablaingresos_gralFuntecso($filtro){

	    	if ($filtro == '*') {
				# code...
				$this->ingreso = $this->getIngresosFuntecso();

			} else {

				# code...
				$cambio = array("AND", "ingreso_gral.");			

				$campos_str = str_replace($cambio, "", $filtro);

				$arr_campos = explode(" ",$campos_str);

				$arr_completo = array();
				//print_r ($arr_campos);

				echo "<p>Filtrando por:</p>";

				for ($i=0; $i < sizeof($arr_campos) ; $i++) { 
					# code...
					

					$arr_campos1 = explode("=",$arr_campos[$i]);				

					//print_r($arr_campos1);

					/*if ($arr_campos1[0] == "fkID_empresa") {
						# code...
						$empresaId = $this->getEmpresasId($arr_campos1[1]);

						//print_r($empresaId);

						echo "<span class='badge'>Empresa:".$empresaId[0]["nombre"]."</span>";
					}*/

					if ($arr_campos1[0] == "fkID_proyecto") {
						# code...
						$proyectoId = $this->getProyectosId($arr_campos1[1]);

						//print_r($proyectoId);

						echo "<span class='badge'>Fuente:".$proyectoId[0]["nom_entidad"].": ".$proyectoId[0]["nombre"]."</span>";
					}

					if ($arr_campos1[0] == "pagado") {

						if ($arr_campos1[1] == "0") {
							# code...

							echo "<span class='badge'>Pagado:No</span>";
						}else{
							echo "<span class='badge'>Pagado:Sí</span>";
						}
					}

					if ($arr_campos1[0] == "pagado_impuesto") {

						if ($arr_campos1[1] == "0") {
							# code...

							echo "<span class='badge'>Declarado:No</span>";
						}else{
							echo "<span class='badge'>Declarado:Sí</span>";
						}
					}

				}

				echo "<br> <br>";

				$this->ingreso = $this->getIngresosFiltroFuntecso($filtro);
			}	    	
	    	
	    	//print_r($formatosNoSub);
	    	//mete los formatos sin subcategoria
	    	//array_merge($this->Formatos, $formatosNoSub);

	    	//print_r($this->Formatos);	    	

	    	//valida si hay formatos

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos($this->id_modulo, $_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//--------------------------------------------------------------------------------- 

	    	if( ($this->ingreso) && ($consulta==1) ){

	    		for($a=0;$a<sizeof($this->ingreso);$a++){

                 $id = $this->ingreso[$a]["pkID"];                 
                 $empresa = $this->ingreso[$a]["nom_empresa"];
                 $nom_proyecto = $this->ingreso[$a]["nom_proyecto"];
                 $descripcion = $this->ingreso[$a]["descripcion"];
                 $fecha_ingreso = $this->ingreso[$a]["fecha_ingreso"];
                 $fecha_pago = $this->ingreso[$a]["fecha_pago"];
                 $fecha_radicacion = $this->ingreso[$a]["fecha_radicacion"];
                 $subtotal = $this->ingreso[$a]["subtotal"];
                 $iva = $this->ingreso[$a]["iva"];
                 $total = $this->ingreso[$a]["total"];
                 $total_recibido = $this->ingreso[$a]["total_recibido"];                 
                 $pagado = $this->ingreso[$a]["pagado"];                 

                 echo '
                             <tr>
                             	 
                                 <td>'.$empresa.'</td>
                                 <td>'.$nom_proyecto.'</td>                                                    
                                 <td>'.$descripcion.'</td>
                                 <td>';
                                 if ($pagado==1){
                                 	echo "SI";

                                 }else{
                                 	echo "NO";

                                 }

                                 echo '</td>
                                 <td hidden="true">'.$total_recibido.'</td> 
                                 <td>'.$fecha_radicacion.'</td>
                                 <td>'.$fecha_pago.'</td>
                                 <td>'.'$'.number_format($subtotal, 0, '', '.').'</td>
                                 <td>'.'$'.number_format($total_recibido, 0, '', '.').'</td>
                                 <td>		                         	
		                             <button id="btn_editar" title="Editar" name="edita_ingreso_gral" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_ingreso_gral" data-id-ingreso_gral = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_ingreso_gral" type="button" class="btn btn-danger" data-id-ingreso_gral = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };                


	    	}elseif(($this->ingreso) && ($consulta==0)){

             echo "<tr>
		               
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               		               		               		                                          
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Ingresos General.</strong>  						
				   </div>";
            }else{

             echo "<tr>		               
		               
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               		               		                                           
		           </tr>
		           
		           <div class='alert alert-danger' role='alert'>
		           		En este momento no hay <strong>Ingresos</strong> creados o no coincide con este <strong>Filtro</strong>.
				   </div>";
            };

	    }

	    public function getTablaingresos_gralProco($filtro){

	    	if ($filtro == '*') {
				# code...
				$this->ingreso = $this->getIngresosProco();

			} else {

				# code...
				$cambio = array("AND", "ingreso_gral.");			

				$campos_str = str_replace($cambio, "", $filtro);

				$arr_campos = explode(" ",$campos_str);

				$arr_completo = array();
				//print_r ($arr_campos);

				echo "<p>Filtrando por:</p>";

				for ($i=0; $i < sizeof($arr_campos) ; $i++) { 
					# code...
					

					$arr_campos1 = explode("=",$arr_campos[$i]);				

					//print_r($arr_campos1);

					/*if ($arr_campos1[0] == "fkID_empresa") {
						# code...
						$empresaId = $this->getEmpresasId($arr_campos1[1]);

						//print_r($empresaId);

						echo "<span class='badge'>Empresa:".$empresaId[0]["nombre"]."</span>";
					}*/

					if ($arr_campos1[0] == "fkID_proyecto") {
						# code...
						$proyectoId = $this->getProyectosId($arr_campos1[1]);

						//print_r($proyectoId);

						echo "<span class='badge'>Fuente:".$proyectoId[0]["nom_entidad"].": ".$proyectoId[0]["nombre"]."</span>";
					}

					if ($arr_campos1[0] == "pagado") {

						if ($arr_campos1[1] == "0") {
							# code...

							echo "<span class='badge'>Pagado:No</span>";
						}else{
							echo "<span class='badge'>Pagado:Sí</span>";
						}
					}

					if ($arr_campos1[0] == "pagado_impuesto") {

						if ($arr_campos1[1] == "0") {
							# code...

							echo "<span class='badge'>Declarado:No</span>";
						}else{
							echo "<span class='badge'>Declarado:Sí</span>";
						}
					}

				}

				echo "<br> <br>";

				$this->ingreso = $this->getIngresosFiltroProco($filtro);
			}	    	
	    	
	    	//print_r($formatosNoSub);
	    	//mete los formatos sin subcategoria
	    	//array_merge($this->Formatos, $formatosNoSub);

	    	//print_r($this->Formatos);	    	

	    	//valida si hay formatos

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos($this->id_modulo, $_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//--------------------------------------------------------------------------------- 

	    	if( ($this->ingreso) && ($consulta==1) ){

	    		for($a=0;$a<sizeof($this->ingreso);$a++){

                 $id = $this->ingreso[$a]["pkID"];                 
                 $empresa = $this->ingreso[$a]["nom_empresa"];
                 $nom_proyecto = $this->ingreso[$a]["nom_proyecto"];
                 $descripcion = $this->ingreso[$a]["descripcion"];
                 $fecha_ingreso = $this->ingreso[$a]["fecha_ingreso"];
                 $fecha_pago = $this->ingreso[$a]["fecha_pago"];
                 $fecha_radicacion = $this->ingreso[$a]["fecha_radicacion"];
                 $subtotal = $this->ingreso[$a]["subtotal"];
                 $iva = $this->ingreso[$a]["iva"];
                 $total = $this->ingreso[$a]["total"];
                 $total_recibido = $this->ingreso[$a]["total_recibido"];                 
                 $pagado = $this->ingreso[$a]["pagado"];                 

                 echo '
                             <tr>
                             	 
                                 <td>'.$empresa.'</td>
                                 <td>'.$nom_proyecto.'</td>                                                    
                                 <td>'.$descripcion.'</td>
                                 <td>';
                                 if ($pagado==1){
                                 	echo "SI";

                                 }else{
                                 	echo "NO";

                                 }

                                 echo '</td>
                                 <td hidden="true">'.$total_recibido.'</td> 
                                 <td>'.$fecha_radicacion.'</td>
                                 <td>'.$fecha_pago.'</td>
                                 <td>'.'$'.number_format($subtotal, 0, '', '.').'</td>
                                 <td>'.'$'.number_format($total_recibido, 0, '', '.').'</td>
                                 <td>		                         	
		                             <button id="btn_editar" title="Editar" name="edita_ingreso_gral" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_ingreso_gral" data-id-ingreso_gral = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_ingreso_gral" type="button" class="btn btn-danger" data-id-ingreso_gral = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };                


	    	}elseif(($this->ingreso) && ($consulta==0)){

             echo "<tr>
		               
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               		               		               		                                          
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Ingresos General.</strong>  						
				   </div>";
            }else{

             echo "<tr>		               
		               
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               		               		                                           
		           </tr>
		           
		           <div class='alert alert-danger' role='alert'>
		           		En este momento no hay <strong>Ingresos</strong> creados o no coincide con este <strong>Filtro</strong>.
				   </div>";
            };

	    }

	    public function getSelectProyectosFuntecso(){

			$proyectoSelect = $this->getProyectosFuntecso();

			echo '<select name="fkID_proyecto" id="fkID_proyecto" class="form-control">
                        <option></option>';
                        for ($i=0; $i < sizeof($proyectoSelect); $i++) {
                                echo '<option value="'.$proyectoSelect[$i]["pkID"].'" >'.$proyectoSelect[$i]["nom_entidad"].' : '.$proyectoSelect[$i]["nombre"].'</option>';
                            };
            echo '</select>';
		}

		public function getSelectProyectosProco(){

			$proyectoSelect = $this->getProyectosProco();

			echo '<select name="fkID_proyecto" id="fkID_proyecto" class="form-control">
                        <option></option>';
                        for ($i=0; $i < sizeof($proyectoSelect); $i++) {
                                echo '<option value="'.$proyectoSelect[$i]["pkID"].'" >'.$proyectoSelect[$i]["nom_entidad"].' : '.$proyectoSelect[$i]["nombre"].'</option>';
                            };
            echo '</select>';
		}
		/*20180104: Fin Agregado Funtecso*/

		public function getSelectAnio(){

			$fechasSelect = $this->getAnio();

			echo '<select name="anio_filtro" id="anio_filtro" class="form-control">
                        <option value="">Todo</option>';
                        for ($i=0; $i < sizeof($fechasSelect); $i++) {
                                echo '<option value="\''.$fechasSelect[$i]["anio"].'\'" >'.$fechasSelect[$i]["anio"].'</option>';
                            };
            echo '</select>';
		}

		public function getSelectPeriodoFiltro(){

			$empresaSelect = $this->getPeriodo();

			echo '<select name="periodo_filtro" id="periodo_filtro" class="form-control">
                        <option value=""></option>';
                        for ($i=0; $i < sizeof($empresaSelect); $i++) {
                                echo '<option value="'.$empresaSelect[$i]["pkID"].'" >'.$empresaSelect[$i]["nombre"].'</option>';
                            };
            echo '</select>';
		}
		
	}
?>
