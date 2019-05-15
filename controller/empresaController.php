<?php
	include('../DAO/EmpresaDAO.php');
	include('render_table.php');

	class empresaController extends empresa {

		//-------------------------------------
		//variables
		public $empresa;
		public $empresaId;
		public $certificados;

		public $InfoFinanciera;
		public $docslegal;

		public $ruta_visor;

		public $id_modulo;
		public $id_modulo_certificacion;
		public $id_modulo_docslegal;
		//-------------------------------------
		//instancia de render table
		public $table_inst;

		function __construct(){
			$this->id_modulo = 23;
			$this->id_modulo_certificacion = 25;
			$this->id_modulo_docslegal = 27;

		}

		public function numEmpresas(){

			$numEmpresas = $this->getNumEmpresas();

			echo $numEmpresas[0]["numEmpresas"];			
		}


		public function selectEntidades(){

			$entidadSelect = $this->getEntidadEmpresaSelect();

            for ($i=0; $i < sizeof($entidadSelect); $i++) {
                echo '<option value="'.$entidadSelect[$i]["pkID"].'">'.$entidadSelect[$i]["nombre_entidad"].'</option>';
            };
		}



		//---------------------------------------------------------------------------------

		public function getTablaEmpresas(){

	    	/* En caso de traer solo registros de x usuario
	    	if($tipo_usuario == "Administrador"){
	    		//get de los categoria  
	    		$this->categoria = $this->getcategoria();
	    	}else{
	    		$this->categoria = $this->getcategoriaUser($id_usuario);
	    	}*/

	    	$this->empresa = $this->getEmpresas();

	    	//print_r($this->proceso);

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos($this->id_modulo,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//---------------------------------------------------------------------------------    

	    	//valida si hay proceso
	    	if( ($this->empresa) && ($consulta==1) ){

	    		for($a=0;$a<sizeof($this->empresa);$a++){
	    		 //variables de los procesos
                 $id = $this->empresa[$a]["pkID"];
                 $nit = $this->empresa[$a]["nit"];
                 $nombre = $this->empresa[$a]["nombre"];
                 $telefono = $this->empresa[$a]["telefono"];
                 $direccion = $this->empresa[$a]["direccion"]; 
                 $representante_legal = $this->empresa[$a]["representante_legal"];
                 


                 //<td title="Click Ver Detalles" href="detail_proceso.php?id_proceso='.$id.'" class="detail">'.$id.'</td>
                 
                 echo '
                             <tr>
                             	 <td title="Click Ver Detalles" href="detail_empresa.php?id_empresa='.$id.'" class="detail">'.$nombre.'</td>
                             	 <td title="Click Ver Detalles" href="detail_empresa.php?id_empresa='.$id.'" class="detail">'.$telefono.'</td>
                             	 <td title="Click Ver Detalles" href="detail_empresa.php?id_empresa='.$id.'" class="detail">'.$direccion.'</td>';                             	                              	
                                 
                                 
                          		//if ($_COOKIE["log_lunelAdmin_IDtipo"] == 1) {
                          			# code...
                          			//echo '<td title="Click Ver Detalles" href="detail_empresa.php?id_empresa='.$id.'" class="detail">'.$representante_legal.'</td>';
                          		//}
                          		

                                 

                          echo ' 
		                         <td>		                         		                             		                           
		                             <button id="btn_editar" title="Editar" name="edita_empresa" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_empresa" data-id-empresa = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_empresa" type="button" class="btn btn-danger" data-id-empresa = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                             
		                            
		                         </td> 
		                     </tr>';
                };


	    	}elseif(($this->empresa) && ($consulta==0)){

             echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>		               		                                           
		           </tr>
		           <div class='alert alert-danger' role='alert'>		           		
		           		En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Empresas.</strong>		           				           	
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
		               <td></td>
		               <td></td>		               		                                           
		           </tr>
		           <div class='alert alert-danger' role='alert'>		           		
		           		En este momento no hay <strong>Empresas</strong> creados.		           		
				   </div>";
            };

	    }

	    /*x
		public function getDataEmpresa($pkID){

			$this->empresaId = $this->getEmpresaId($pkID);

			//print_r($this->empresaId);

			return $this->empresaId;
		}*/

		public function getDataEmpresaGen($pkID){
			//print_r($pkID);
			$this->empresaId = $this->getEmpresaId($pkID);

			//return $this->procesoId;
			
			/**/
			echo '	<div>

						<strong>NIT: </strong> '.$this->empresaId[0]["nit"].' <br> <br>

						<strong>Nombre: </strong> '.$this->empresaId[0]["nombre"].' <br> <br>

						<strong>Teléfono: </strong> '.$this->empresaId[0]["telefono"].' <br> <br>
					  
					  	<strong>Dirección:</strong> '.$this->empresaId[0]["direccion"].' <br> <br>

					  	<strong>Representante Legal:</strong> '.$this->empresaId[0]["representante_legal"].' <br> <br>';


			echo	'</div>';

			//return $this->procesoId;
		}

		
		public function getTablaCertificacionEmpresa($pkID){

	    	/* En caso de traer solo registros de x usuario
	    	if($tipo_usuario == "Administrador"){
	    		//get de los categoria  
	    		$this->categoria = $this->getcategoria();
	    	}else{
	    		$this->categoria = $this->getcategoriaUser($id_usuario);
	    	}*/

	    	include("../Conexion/datos.php");
	    	$this->ruta_visor = $ruta_visor;

	    	$this->certificados = $this->getCertificadosEmpresa($pkID);

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos($this->id_modulo_certificacion,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$editaCertificacion = $arrPermisos[0]["editar"];
    		$eliminaCertificacion = $arrPermisos[0]["eliminar"];
    		$consultaCertificacion = $arrPermisos[0]["consultar"];
    		//--------------------------------------------------------------------------------- 	    	

	    	//valida si hay certificado
	    	if( ($this->certificados) && ($consultaCertificacion==1) ){

	    		for($a=0;$a<sizeof($this->certificados);$a++){

                 $id = $this->certificados[$a]["pkID"];
                 $entidad = $this->certificados[$a]["fkID_entidad"];
                 $nombreEntidad = $this->certificados[$a]["nombre_entidad"];
                 $rup = $this->certificados[$a]["rup"];
                 $objeto = $this->certificados[$a]["objeto"];                
                 $valor = $this->certificados[$a]["valor"];
                 $fecha_ini = $this->certificados[$a]["fechaIni"];                
                 $fecha_fin = $this->certificados[$a]["fechaFin"];
                 $nom_certi = $this->certificados[$a]["nom_certi"];                
                 $ruta = $this->certificados[$a]["ruta"];
                 $anio_fin = $this->certificados[$a]["anio"];


                 //<td>'.$id.'</td>
                 //<td>'.$tipo.'</td>                                 

                 echo '
                             <tr>
                             	                              	 
                                 <td>'.$anio_fin.'</td>
                                 <td>'.$rup.'</td>
                                 <td>'.$nombreEntidad.'</td>
                                 <td>'.$objeto.'</td>
                                 <td>'.number_format($valor, 0, '', '.').'</td>

		                         <td>
		                         	 <a id="btn_doc" title="Descargar Archivo" name="download_documento" type="button" class="btn btn-success" href = "../vistas/subidas/'.$ruta.'" target="_blank" ><span class="glyphicon glyphicon-download-alt"></span></a>
									 <a class="btn btn-info" title="Visualizar Archivo con Google Docs" href="https://docs.google.com/viewer?url='.$this->ruta_visor.''.$ruta.'" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a>
		                             <button id="btn_editar" title="Editar" name="edita_certificacion" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_certificaciones" data-id-certificacion = "'.$id.'" '; if ($editaCertificacion!= 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_certificacion" type="button" class="btn btn-danger" data-id-certificacion = "'.$id.'" '; if ($eliminaCertificacion != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };


	    	}elseif(($this->certificados) && ($consultaCertificacion==0)){

             echo "<tr>
             		   
		               <td></td>		               
		               <td></td>		               		               		               		                                         
		           </tr>
		           <div class='alert alert-danger' role='alert'>		           		
		           		En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Empresas/certificados.</strong>		           				           	
				   </div>";
            }else{

             echo "<tr>		               		               
		               		              
		               <td></td>
		               <td></td>		               		               		               		                                      
		           </tr>
		           <div class='alert alert-danger' role='alert'>		           		
		           		En este momento no hay registros para esta <strong>Empresa.</strong>		           				           				           
				   </div>";
            };

	    }

	    public function getTablaInfoFinanciera($pkID_empresa){

	    	$this->InfoFinanciera = $this->getInfoFinanciera($pkID_empresa);

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos(26,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//---------------------------------------------------------------------------------

    		//Define las variables de la tabla a renderizar------------------------------------    		

    		$InfoFinanciera_campos = [
    									[
    										"nombre"=>"anio",
    										"tipo"=>""
    									],
										[
											"nombre"=>"liquidez",
    										"tipo"=>""
										],
										[
											"nombre"=>"capital_trabajo",
											"tipo"=>"number_format"
										],
										[
											"nombre"=>"rentabilidad_patrimonio",
											"tipo"=>"percent"
										],
										[
											"nombre"=>"endeudamiento",
											"tipo"=>"percent"
										],
										[
											"nombre"=>"razon_cobert_int",
    										"tipo"=>""
										],
										[
											"nombre"=>"rentabilidad_activo",
											"tipo"=>"percent"
										],
										[
											"nombre"=>"patrimonio",
											"tipo"=>"number_format"
										],										
									];

			//la configuracion de los botones de opciones
    		$InfoFinanciera_btn =[

	    		 [
	    			"tipo"=>"editar",
	    			"nombre"=>"info_financiera",
	    			"permiso"=>$edita,
	    		 ],
	    		 [
	    			"tipo"=>"eliminar",
	    			"nombre"=>"info_financiera",
	    			"permiso"=>$elimina,
	    		 ],
	    		 [
	    			"tipo"=>"descargar_1",//hace referencia a la carpeta subidas/
	    			"nombre"=>"ruta",//nombre del campo que tiene el archivo.
	    			"permiso"=>$consulta,	    			
	    		 ],
	    		 [
	    			"tipo"=>"ver_docs",//hace referencia a google docs
	    			"nombre"=>"ruta",//nombre del campo que tiene el archivo.
	    			"permiso"=>$consulta,	    			
	    		 ]

	    	];
	    	/**/
	    	//Instancia el render
	    	$this->table_inst = new RenderTable($this->InfoFinanciera,$InfoFinanciera_campos,$InfoFinanciera_btn,[]);
	    	//---------------------------------------------------------------------------------
	    	if( (isset($this->InfoFinanciera)) && ($consulta==1) ){

	    		$this->table_inst->render();	    		


	    	}elseif(isset($this->InfoFinanciera) && ($consulta==0)){


	    	 $this->table_inst->render_blank();

             echo "<div class='alert alert-danger' role='alert'>  						 
  						 En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Información Financiera.</strong>
				   </div>";
            }else{

             $this->table_inst->render_blank();

             echo "<div class='alert alert-danger' role='alert'>
  						 En este momento no hay <strong>Información Financiera</strong>.
				   </div>";
            };
	    	//---------------------------------------------------------------------------------

	    }		


	    public function getTablaDocsLegalesEmpresa($pkID){

	    	/* En caso de traer solo registros de x usuario
	    	if($tipo_usuario == "Administrador"){
	    		//get de los categoria  
	    		$this->categoria = $this->getcategoria();
	    	}else{
	    		$this->categoria = $this->getcategoriaUser($id_usuario);
	    	}*/

	    	include("../Conexion/datos.php");
	    	$this->ruta_visor = $ruta_visor;

	    	$this->docslegal = $this->getDocLegalEmpresa($pkID);

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos($this->id_modulo_docslegal,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$editaDocLegal = $arrPermisos[0]["editar"];
    		$eliminaDocLegal = $arrPermisos[0]["eliminar"];
    		$consultaDocLegal = $arrPermisos[0]["consultar"];
    		//--------------------------------------DocLega------------------------------ 	DocLega//valida si hay proyecto
	    	if( ($this->docslegal) && ($consultaDocLegal==1) ){

	    		for($a=0;$a<sizeof($this->docslegal);$a++){

                 $id = $this->docslegal[$a]["pkID"];
                 $nom_docl = $this->docslegal[$a]["nom_docl"];           
                 $ruta = $this->docslegal[$a]["ruta"];
                 $empresa = $this->docslegal[$a]["fkID_empresa"];
                 $anio = $this->docslegal[$a]["anio_expedicion"];  


                 //<td>'.$id.'</td>
                 //<td>'.$tipo.'</td>                                 

                 echo '
                             <tr>
                             	                              	 
                                 <td>'.$anio.'</td> 

                                  <td>'.$nom_docl.'</td>                                                                                              
		                         <td>
		                         	 <a id="btn_doc" title="Descargar Archivo" name="download_documento" type="button" class="btn btn-success" href = "subidas/'.$ruta.'" target="_blank" ><span class="glyphicon glyphicon-download-alt"></span></a>
									 <a class="btn btn-info" title="Visualizar Archivo con Google Docs" href="https://docs.google.com/viewer?url='.$this->ruta_visor.''.$ruta.'" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a>
		                             <button id="btn_editar" title="Editar" name="edita_doclegal" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_docslegales" data-id-docslegal = "'.$id.'" '; if ($editaDocLegal!= 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_doclegal" type="button" class="btn btn-danger" data-id-docslegal = "'.$id.'" '; if ($eliminaDocLegal != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };


	    	}elseif(($this->docslegal) && ($consultaDocLegal==0)){

             echo "<tr>
             		   
		               <td></td>		               
		               <td></td>		               		               		               		                                         
		           </tr>
		           <div class='alert alert-danger' role='alert'>		           		
		           		En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Empresas/docslegal.</strong>		           				           	
				   </div>";
            }else{

             echo "<tr>		               		               
		               		              
		               <td></td>
		               <td></td>		               		               		               		                                      
		           </tr>
		           <div class='alert alert-danger' role='alert'>		           		
		           		En este momento no hay registros para esta <strong>Empresa.</strong>		           				           				           
				   </div>";
            };

	    }


	    public function getSelectFechasFiltro(){

			$fechasSelect = $this->getFechas();

			echo '<select name="fechas_filtro" id="fechas_filtro" class="form-control">
                        <option value="">Todo</option>';
                        for ($i=0; $i < sizeof($fechasSelect); $i++) {
                                echo '<option value="\''.$fechasSelect[$i]["fechaFin"].'\'" >'.$fechasSelect[$i]["fechaFin"].'</option>';
                            };
            echo '</select>';
		}


		public function getTablaEmpresasFiltro($filtro){

			//------------------------------------------------------------------------------------------------

			if ($filtro == '*' || $filtro == '') {

				$this->getTablaEmpresas();

			} else {

				# code...
				$cambio = array("AND", "empresa.");			

				$campos_str = str_replace($cambio, "", $filtro);

				$arr_campos = explode(" ",$campos_str);

				$arr_completo = array();
				//print_r ($arr_campos);

				echo "<p>Filtrando por:</p>";

				for ($i=0; $i < sizeof($arr_campos) ; $i++) { 
					# code...
					//echo $arr_campos[$i].'<br>';

					$arr_campos1 = explode("=",$arr_campos[$i]);				

					if ($arr_campos1[0] == "fechaFin") {
						echo "<span class='badge'>Fecha Fin: ".$arr_campos1[1]."</span>";
					}


				}
				/*echo "<br><br>";
				print_r($filtro);	*/
				echo "<br> <br>";

				$this->empresa = $this->getEmpresasFiltro($filtro);
				//print_r($this->gasto);
				

			}	    	
	    	
	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos($this->id_modulo,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//---------------------------------------------------------------------------------    

	    	//valida si hay proceso
	    	if( ($this->empresa) && ($consulta==1) ){

	    		for($a=0;$a<sizeof($this->empresa);$a++){
	    		 //variables de los procesos
                 $id = $this->empresa[$a]["idEmpresa"];
                 $nit = $this->empresa[$a]["nit"];
                 $anio = $this->empresa[$a]["anio"];
                 $nombre = $this->empresa[$a]["entidad"];
                 $objeto = $this->empresa[$a]["objeto"];
                 $telefono = $this->empresa[$a]["telefono"];
                 $total = $this->empresa[$a]["total"];
                 $direccion = $this->empresa[$a]["direccion"]; 
                 $representante_legal = $this->empresa[$a]["representante_legal"];
                 


                 echo '
                             <tr>
                             	 <td title="Click Ver Detalles" href="detail_empresa.php?id_empresa='.$id.'" class="detail">'.$anio.'</td>
                             	 <td title="Click Ver Detalles" href="detail_empresa.php?id_empresa='.$id.'" class="detail">'.$nombre.'</td>
                             	 <td title="Click Ver Detalles" href="detail_empresa.php?id_empresa='.$id.'" class="detail">'.$objeto.'</td>
                             	 <td title="Click Ver Detalles" href="detail_empresa.php?id_empresa='.$id.'" class="detail">'.$total.'</td>';                             	                              	
                                 
                                 
                         echo ' 
		                         <td>		                         		                             		                           
		                             <button id="btn_editar" title="Editar" name="edita_empresa" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_empresa" data-id-empresa = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_empresa" type="button" class="btn btn-danger" data-id-empresa = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                             
		                            
		                         </td> 
		                     </tr>';
                };


	    	}elseif(($this->empresa) && ($consulta==0)){

             echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>		               		                                           
		           </tr>
		           <div class='alert alert-danger' role='alert'>		           		
		           		En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Empresas.</strong>		           				           	
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
		               <td></td>
		               <td></td>		               		                                           
		           </tr>
		           <div class='alert alert-danger' role='alert'>		           		
		           		En este momento no hay <strong>Empresas</strong> creados.		           		
				   </div>";
            };

	    }


	    public function getSelectAnio(){

			$fechasSelect = $this->getAnio();

			echo '<select name="anio_filtro" id="anio_filtro" class="form-control">
                        <option value="">Todo</option>';
                        for ($i=0; $i < sizeof($fechasSelect); $i++) {
                                echo '<option value="\''.$fechasSelect[$i]["anio_expedicion"].'\'" >'.$fechasSelect[$i]["anio_expedicion"].'</option>';
                            };
            echo '</select>';
		}


		

}
	
?>

