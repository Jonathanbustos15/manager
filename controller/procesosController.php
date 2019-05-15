<?php 

	include('../DAO/ProcesosDAO.php'); 

	class procesosController extends procesos {

		//-------------------------------------
		//variables
		public $proceso;
		public $procesoId;
		public $ind_proceso;
		public $usuario_proceso;
		public $paso;
		public $documentos;
		//public $presupuesto;
		//public $documentos;
		//-------------------------------------
		public $id_modulo;
		public $id_modulo_documentos;

		public $ruta_visor;

		//-------------------------------------
		public $arr_reporte;
		//-------------------------------------

		function __construct(){
			$this->id_modulo = 3;
			$this->id_modulo_documentos = 12;
			$this->arr_reporte = array();
		}

		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		public function numProcesos(){

			$numProcesos = $this->getNumProcesos();

			echo $numProcesos[0]["numProcesos"];			
		}

		public function selectEstadoProceso(){

			$estadoSelect = $this->getEstadoProceso();

            for ($i=0; $i < sizeof($estadoSelect); $i++) {
                echo '<option value="'.$estadoSelect[$i]["pkID"].'">'.$estadoSelect[$i]["nombre"].'</option>';
            };
		}

		public function selectTipoProceso(){

			$tipoSelect = $this->getTipoProcesoSelect();

            for ($i=0; $i < sizeof($tipoSelect); $i++) {
                echo '<option value="'.$tipoSelect[$i]["pkID"].'">'.$tipoSelect[$i]["nombre"].'</option>';
            };
		}

		public function selectPasosProceso(){

			$pasosSelect = $this->getPasosProceso();

            for ($i=0; $i < sizeof($pasosSelect); $i++) {
            	            	
            	echo '<option value="'.$pasosSelect[$i]["pkID"].'">'.$pasosSelect[$i]["nombre"].'</option>';          	
                
            };
		}

		public function selectTipoCuantia(){

			$cuantiaSelect = $this->getTipoCuantia();

            for ($i=0; $i < sizeof($cuantiaSelect); $i++) {
            	            	
            	echo '<option value="'.$cuantiaSelect[$i]["pkID"].'">'.$cuantiaSelect[$i]["nombre"].'</option>';                        
            };
		}


		public function getSelectProcesos1(){

			$externoSelect = $this->getProcesoCod();

			echo '<select name="codigo" id="codigo" class="form-control add-selectElement" required = "true">
                        <option>Todo</option>';
                        for ($i=0; $i < sizeof($externoSelect); $i++) {
                                echo '<option value="'.$externoSelect[$i]["pkID"].'" >'.$externoSelect[$i]["codigo"].'</option>';
                            };
            echo '</select>';
		}

		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		public function createTableProcesos($filtro,$id_tabla){

			echo '
			    <div class="dataTable_wrapper table-responsive">

				 <table class="table table-striped table-bordered table-hover" id="tbl_proceso_'.$id_tabla.'">
		              <thead>
		                  <tr>		                      
		                      <th class="tabla-form-ancho">Entidad</th>		                      
		                      <th class="tabla-form-ancho">Fecha/Cierre</th>
		                      <th class="tabla-form-ancho">Código</th>
		                      <th class="tabla-form-ancho">Objeto</th>
		                      <th class="tabla-form-ancho">Paso</th>		                      
		                      <th class="tabla-form-ancho">Cuantía</th>                                  
		                      <th data-orderable="false" class="tabla-form-ancho">Opciones</th>
		                  </tr>
		              </thead>
		              <tbody>';
		                    
		                      $this->getTablaProcesos($filtro);
		                    
		    echo '    </tbody>
		          </table>
		        </div>';
		}

		public function getTablaProcesos($filtro){

	    	/* En caso de traer solo registros de x usuario
	    	if($tipo_usuario == "Administrador"){
	    		//get de los categoria  
	    		$this->categoria = $this->getcategoria();
	    	}else{
	    		$this->categoria = $this->getcategoriaUser($id_usuario);
	    	}*/

	    	//$this->proceso = $this->getProcesos();

	    	$this->proceso = $this->getProcesosFiltro($filtro);	    	

	    	//print_r($this->proceso);

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos($this->id_modulo,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//---------------------------------------------------------------------------------    

	    	//valida si hay proceso
	    	if( ($this->proceso) && ($consulta==1) ){

	    		/**/
	    		for($a=0;$a<sizeof($this->proceso);$a++){
	    		 //variables de los procesos
                 $id = $this->proceso[$a]["pkID"];
                 $fecha_cierre = $this->proceso[$a]["fecha_cierre"];
                 $objeto = $this->proceso[$a]["objeto"];
                 $codigo = $this->proceso[$a]["codigo"];
                 $experiencia = $this->proceso[$a]["experiencia"];
                 $cuantia = $this->proceso[$a]["cuantia"];
                 
                 $personal = $this->proceso[$a]["personal"];
                 $indicadores = $this->proceso[$a]["indicadores"];  
                 $url_propuesta = $this->proceso[$a]["url_propuesta"];

                 $fkID_entidad = $this->proceso[$a]["fkID_entidad"];
                 $fkID_estado = $this->proceso[$a]["fkID_estado"];
                 $fkID_paso_actual = $this->proceso[$a]["fkID_paso_actual"];
                 $fkID_tipo = $this->proceso[$a]["fkID_tipo"];

                 $nom_paso = $this->proceso[$a]["nom_paso"];
                 $nom_entidad = $this->proceso[$a]["nom_entidad"];
                 $nom_estado = $this->proceso[$a]["nom_estado"];
                 $nom_tipo = $this->proceso[$a]["nom_tipo"];

                 //<td title="Click Ver Detalles" href="detail_proceso.php?id_proceso='.$id.'" class="detail">'.$id.'</td>
                 
                 echo '
                             <tr>
                             	 <td title="Click Ver Detalles" href="detail_proceso.php?id_proceso='.$id.'" class="detail">'.$nom_entidad.'</td>
                             	 
                             	 <td title="Click Ver Detalles" href="detail_proceso.php?id_proceso='.$id.'" class="detail">'.$fecha_cierre.'</td>
                             	 <td title="Click Ver Detalles" href="detail_proceso.php?id_proceso='.$id.'" class="detail">'.$codigo.'</td>                             	                              	
                                 <td title="Click Ver Detalles" href="detail_proceso.php?id_proceso='.$id.'" class="detail">';
	                                 //substr($objeto, 0, 60)
	                                 $len_objeto = strlen($objeto);

	                                 if ($len_objeto >= 60) {
	                                 	# code...
	                                 	echo substr($objeto, 0, 60).'...';
	                                 } else {
	                                 	# code...
	                                 	echo $objeto;
	                                 }
                          echo '</td>';
                                 
                          		
                        echo '<td title="Click Ver Detalles" href="detail_proceso.php?id_proceso='.$id.'" class="detail">'.$nom_paso.'</td>';  		

                                 

                          echo ' <td title="Click Ver Detalles" href="detail_proceso.php?id_proceso='.$id.'" class="detail">'.'$'.number_format($cuantia, 0, '', '.').'</td>
		                         <td>		                         		                             		                           
		                             <button id="btn_editar" title="Editar" name="edita_proceso" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_proceso" data-id-proceso = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_proceso" type="button" class="btn btn-danger" data-id-proceso = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                             
		                             <button id="btn_aprovarAsignar" title="Aprobar" name="aprobar_asignar" type="button" class="btn btn-primary" data-id-proceso = "'.$id.'" ';  if ( ($_COOKIE["log_lunelAdmin_IDtipo"] == 3) || ($_COOKIE["log_lunelAdmin_IDtipo"] == 1) && ( $nom_paso == "Creado" ) ){}else{ echo 'style="display: none;'; } echo '><span class="glyphicon glyphicon-ok"></span></button>		                             	                             		           
		                         </td> 
		                     </tr>';
                };


	    	}elseif(($this->proceso) && ($consulta==0)){

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
		           		En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Procesos.</strong>		           				           	
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
		           		En este momento no hay <strong>Procesos</strong> creados.		           		
				   </div>";
            };

	    }

	    public function procesoReporte100(){

	    	$todo = sizeof( $this->proceso = $this->getProcesosFiltro("*") );
	    	   
	    	echo '<strong>Total de procesos:</strong> '.$todo.' --> 100%';

	    	//---------------------------------------------------------------------------------	    	
	    	echo '<div class="progress">
				  <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
				    <span class="sr-only">100%</span>				    	
				  </div>
				</div>';				   	    
	    	//---------------------------------------------------------------------------------
	    }

	    public function procesoReporte($filtro,$nombre){

	    	$todo = sizeof( $this->proceso = $this->getProcesosFiltro("*") );

	    	//echo " Hay ".$todo." Procesos. <br>";

	    	$valor_uni = sizeof( $this->proceso = $this->getProcesosFiltro($filtro) );

	    	//echo $nombre." Hay ".$valor_uni." Procesos. <br>";

	    	//$porcentage = $todo *  

	    	//convierte a cientos el valor
	    	$valor_uni_p = $valor_uni * 100;
	    	//lo multiplica por el total
	    	$porcentage = round($valor_uni_p / $todo);

	    	//echo "El porciento de ".$valor_uni." es ".$valor_uni_p."<br>";

	    	echo '<strong>'.$nombre.':</strong> '.$valor_uni.' --> '.$porcentage.'%';

	    	//---------------------------------------------------------------------------------
	    	//reportes
	    	//array_push($this->arr_reporte, ["nombre"=>$filtro,"cantidad"=>sizeof($this->proceso)]);
	    	/**/
	    	echo '<div class="progress">
				  <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="'.$porcentage.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$porcentage.'%">
				    <span class="sr-only">'.$porcentage.'% '.$nombre.'</span>				    	
				  </div>
				</div>';

	    	//print_r($this->proceso);
	    	//---------------------------------------------------------------------------------
	    }
	    //-----------------------------------------------------------------------------------------------------

	    //-------------------------------------------------------------------------------------------
		//

		public function getDataProcesoGen($pkID){

			$this->procesoId = $this->getProcesoId($pkID);	
			
			/**/
			echo '	<div>

						<strong>Fecha de Cierre: </strong> '.$this->procesoId[0]["fecha_cierre"].' <br> <br>

						<strong>Fecha de Creación: </strong> '.$this->procesoId[0]["fecha_creacion"].' <br> <br>

						<strong>Objeto: </strong> '.$this->procesoId[0]["objeto"].' <br> <br>
					  
					  	<strong>Experiencia:</strong> '.$this->procesoId[0]["experiencia"].' <br> <br>

					  	<strong>Personal:</strong> '.$this->procesoId[0]["personal"].' <br> <br>					  	

					  	<strong>Cuantía:</strong> $'.number_format($this->procesoId[0]["cuantia"], 0, '', '.').' <br> <br>
						
						<strong>Url Propuesta:</strong> <a href="'.$this->procesoId[0]["url_propuesta"].'" target="_blank">'.$this->procesoId[0]["url_propuesta"].' <span class="glyphicon glyphicon-link"></span></a> <br> <br>

						<strong>Paso:</strong> '.$this->procesoId[0]["nom_paso"].' <br> <br>

						<strong>Entidad:</strong> '.$this->procesoId[0]["nom_entidad"].' <br> <br>

						<strong>Estado:</strong> '.$this->procesoId[0]["nom_estado"].' <br> <br>

						<strong>Tipo:</strong> '.$this->procesoId[0]["nom_tipo"].' <br> <br>';						

			echo	'</div>';

			
		}

		//--------------------------------------------------------------------------------------------------------
		//funciones indicadores

		public function getMuestraIndicadoresProceso($pkID){

			$this->ind_proceso = $this->getIndicadoresProceso($pkID);

			//print_r($this->ind_proceso);
			
			if ($this->ind_proceso) {

				echo '<h3 class="text-center">Indicadores del Proceso</h3> <hr>';

				echo '<div> 
						<strong>Liquidez >= </strong> '.$this->ind_proceso[0]["liquidez"].' <br> <br> 
						<strong>Capital de Trabajo >= </strong> $'.number_format($this->ind_proceso[0]["capital_trabajo"], 0, '', '.').' <br> <br> 
						<strong>Rentabilidad del Patrimonio >= </strong> '.$this->ind_proceso[0]["rentabilidad_patrimonio"].'% <br> <br> 
						<strong>Endeudamiento <= </strong> '.$this->ind_proceso[0]["endeudamiento"].'% <br> <br> 
						<strong>Razón de Cobertura de Intereses >= </strong> '.$this->ind_proceso[0]["razon_cobert_int"].' <br> <br> 
						<strong>Rentabilidad del Activo >= </strong> '.$this->ind_proceso[0]["rentabilidad_activo"].'% <br> <br>
						<strong>Patrimonio >= </strong> $'.number_format($this->ind_proceso[0]["patrimonio"], 0, '', '.').' <br> <br>
				      </div>';

				//consultar indicadores de todas las empresas y comparar una por una
				//si cumple con cada una de las condiciones.

				echo '<hr>';

				$this->IndicadoresCompara();

			}else{

				echo '
				<div class="alert alert-danger">
					
					Este proceso no tiene indicadores.
				</div>';
			}			

		}

		public function IndicadoresCompara(){

			$ind_empresas = $this->getIndicadoresEmpresas();

			//print_r($ind_empresas);

			//valida para cada resultado los indicadores del proceso
			foreach ($ind_empresas as $key => $value) {

				echo '<div class="col-md-4">';

				echo '<ul class="list-group">';

				echo '<li class="list-group-item"><strong>Empresa: '.$value["nom_empresa"].'</strong></li>';
				echo '<li class="list-group-item"><strong>Indicadores Año: '.$value["anio"].'</strong></li>';
				
				foreach ($value as $ll => $val) {
					
					/*si la llave es:*/
					switch ($ll) {

						case 'liquidez':
							
							if ($val >= $this->ind_proceso[0][$ll]) {
								echo '<li class="list-group-item list-group-item-success">Liquidez cumple.</li>';
							}else{
								echo '<li class="list-group-item list-group-item-danger">Liquidez no cumple.</li>';
							}

							break;

						case 'capital_trabajo':
							
							if ($val >= $this->ind_proceso[0][$ll]) {
								echo '<li class="list-group-item list-group-item-success">Capital de trabajo cumple.</li>';
							}else{
								echo '<li class="list-group-item list-group-item-danger">Capital de trabajo no cumple.</li>';
							}

							break;

						case 'rentabilidad_patrimonio':
							
							if ($val >= $this->ind_proceso[0][$ll]) {
								echo '<li class="list-group-item list-group-item-success">Rentabilidad del patrimonio cumple.</li>';
							}else{
								echo '<li class="list-group-item list-group-item-danger">Rentabilidad del patrimonio no cumple.</li>';
							}

							break;

						case 'endeudamiento':
							
							if ($val <= $this->ind_proceso[0][$ll]) {
								echo '<li class="list-group-item list-group-item-success">Endeudamiento cumple.</li>';
							}else{
								echo '<li class="list-group-item list-group-item-danger">Endeudamiento no cumple.</li>';
							}

							break;

						case 'razon_cobert_int':
							
							if ($val >= $this->ind_proceso[0][$ll]) {
								echo '<li class="list-group-item list-group-item-success">Razón de Cobertura de Intereses cumple.</li>';
							}else{
								echo '<li class="list-group-item list-group-item-danger">Razón de Cobertura de Intereses no cumple.</li>';
							}

							break;

						case 'rentabilidad_activo':
							
							if ($val >= $this->ind_proceso[0][$ll]) {
								echo '<li class="list-group-item list-group-item-success">Rentabilidad del Activo cumple.</li>';
							}else{
								echo '<li class="list-group-item list-group-item-danger">Rentabilidad del Activo no cumple.</li>';
							}

							break;

						case 'patrimonio':
							
							if ($val >= $this->ind_proceso[0][$ll]) {
								echo '<li class="list-group-item list-group-item-success">Patrimonio cumple.</li>';
							}else{
								echo '<li class="list-group-item list-group-item-danger">Patrimonio no cumple.</li>';
							}

							break;

					}

					//echo 'llave: '.$ll.' valor: '.$val.'<br> <br>';
				}

				echo '</ul>';

				echo '</div>';
			}
		}

		//--------------------------------------------------------------------------------------------------------

		public function getObservacionesProceso(){
			/*
			No es necesario el id porque ya está cargado el proceso
			en el array procesoId
			*/
			$observacionesArray = explode("--", $this->procesoId[0]["observaciones"]);

			//print_r($observacionesArray);

			echo '<strong>Observaciones:</strong> <br> <br>';

			foreach ($observacionesArray as $key => $value) {
				echo $value.' <br>';
			}

		}

		public function getDataProceso($pkID){

			$this->procesoId = $this->getProcesoId($pkID);

			//print_r($this->procesoId);

			return $this->procesoId;
		}

		public function getUserProceso($pkID_proceso){

			$this->usuario_proceso = $this->getUsuarioAsig($pkID_proceso);

			echo '<strong>Usuario Responsable: </strong> '.$this->usuario_proceso[0]["nombre"].' '.$this->usuario_proceso[0]["apellido"].' <br> <br>';

		}

		public function getPasos($pkID_proceso){


			$this->paso = $this->getPasosProcesoW($pkID_proceso);

			//echo "imprime paso";

			//print_r($this->paso);

			//echo "<br> Se contaron ";

			if ( $this->paso == 0 ) {
				
				//echo "No se encontro nada.";

				$this->paso = $this->getPasoProcesoC($pkID_proceso);

				echo '
					<div class="table-responsive table-hover">
					  <table class="table">
					  <tr>
					    <th>Fecha</th>					    
					    <th>Paso actual</th>					    
					  </tr>

					  ';

					    for ($i=0; $i < sizeof($this->paso); $i++) {					    

					    	echo '<tr>
					    			<td>'.$this->paso[$i]["fecha"].'</td>								   
								    <td>'.$this->paso[$i]["nombre"].'</td>								    
								  </tr>';
					    }

				echo '
					</table>
				</div>
				';

			}else{

				//echo sizeof($this->paso);						

				echo '
					<div class="table-responsive">
					  <table class="table table-hover">
					  <tr>
					    <th>Fecha</th>
					    <th>Paso anterior</th> 
					    <th>Paso actual</th>
					    <th>Actual</th>
					  </tr>
					  <tbody>
					  ';

					    for ($i=0; $i < sizeof($this->paso); $i++) { 
					    	# code...

					    	$actual = $this->paso[$i]["actual"];

					    	if ($actual == 1) {
					    		# code...
					    		$actual = "Sí";
					    		$clase = "success";
					    	}else{
					    		$actual = "No";
					    		$clase = "primary";
					    	}

					    	echo '<tr>
					    			<td>'.$this->paso[$i]["fecha"].'</td>
								    <td><ins>'.$this->paso[$i]["nom_paso1"].'</ins></td> 
								    <td><ins>'.$this->paso[$i]["nom_paso2"].'</ins></td>
								    <td><span class="label label-'.$clase.'">'.$actual.'</span></td>
								  </tr>';
					    }

				echo '
					</tbody>
					</table>
				</div>
				';
			}

		}

		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//ruta rara xdebug /usr/lib/php5/20131226/

		public function getSelectTipoDocumentoProceso(){

	    	$tipoSelect = $this->getTipoDocumentoProceso();

	          for ($i=0; $i < sizeof($tipoSelect); $i++) {
	              echo '<option value="'.$tipoSelect[$i]["pkID"].'">'.$tipoSelect[$i]["nombre_tdoc"].'</option>';
	          };
	    }

	    public function getTablaDocumentosProceso($pkID){

	    	/* En caso de traer solo registros de x usuario
	    	if($tipo_usuario == "Administrador"){
	    		//get de los categoria  
	    		$this->categoria = $this->getcategoria();
	    	}else{
	    		$this->categoria = $this->getcategoriaUser($id_usuario);
	    	}*/

	    	include("../Conexion/datos.php");
	    	$this->ruta_visor = $ruta_visor;

	    	$this->documentos = $this->getDocumentosProceso($pkID);

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos($this->id_modulo_documentos,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$editaDocumento = $arrPermisos[0]["editar"];
    		$eliminaDocumento = $arrPermisos[0]["eliminar"];
    		$consultaDocumento = $arrPermisos[0]["consultar"];
    		//--------------------------------------------------------------------------------- 	    	

	    	//valida si hay proyecto
	    	if( ($this->documentos) && ($consultaDocumento==1) ){

	    		for($a=0;$a<sizeof($this->documentos);$a++){

                 $id = $this->documentos[$a]["pkID"];
                 $nombre = $this->documentos[$a]["nom_doc"];
                 $ruta = $this->documentos[$a]["ruta"];                
                 $tipo = $this->documentos[$a]["nom_tipoDocumento"];

                 //<td>'.$id.'</td>
                 //<td>'.$tipo.'</td>                                 

                 echo '
                             <tr>
                             	                              	 
                                 <td>'.$nombre.'</td>                                                                                               
		                         <td>
		                         	 <a id="btn_doc" title="Descargar Archivo" name="download_documento" type="button" class="btn btn-success" href = "subidas/'.$ruta.'" target="_blank" ><span class="glyphicon glyphicon-download-alt"></span></a>
									 <a class="btn btn-info" title="Visualizar Archivo con Google Docs" href="https://docs.google.com/viewer?url='.$this->ruta_visor.''.$ruta.'" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a>
		                             <button id="btn_editar" title="Editar" name="edita_documento" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_documentos" data-id-documento = "'.$id.'" '; if ($editaDocumento != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_documento" type="button" class="btn btn-danger" data-id-documento = "'.$id.'" '; if ($eliminaDocumento != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };


	    	}elseif(($this->documentos) && ($consultaDocumento==0)){

             echo "<tr>
             		   
		               <td></td>		               
		               <td></td>		               		               		               		                                         
		           </tr>
		           <div class='alert alert-danger' role='alert'>		           		
		           		En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Procesos/Documentos.</strong>		           				           	
				   </div>";
            }else{

             echo "<tr>		               		               
		               		              
		               <td></td>
		               <td></td>		               		               		               		                                      
		           </tr>
		           <div class='alert alert-danger' role='alert'>		           		
		           		En este momento no hay registros para este <strong>Proceso.</strong>		           				           				           
				   </div>";
            };

	    }
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//Funcion para el panel de notificaciones del index
		function notIndexProcesos(){

			$resultado = $this->getProcesosAlert();

			$intervalo_num = 0;

			if (sizeof($resultado) > 0) {
				# code...
			

			echo '<ul class="list-group">';

				for ($i=0; $i < sizeof($resultado); $i++) { 
					# code...
					
					
						//fecha actual
						$datetime1 = date_create(date("Y-m-d"));
						//fecha a comparar
						$datetime2 = date_create($resultado[$i]["fecha_cierre"]);
						//intervalo de días
						$interval = date_diff($datetime1, $datetime2);
						//muestra la diferencia
						//echo $interval->format('%R%a días')."<br>";
						
						$intervalo_final = $interval->format('%R%a');

						//echo $intervalo_final."<br>";

						$findme = '+';

						$pos = strpos($intervalo_final, $findme);
					
					

					// Nótese el uso de ===. Puesto que == simple no funcionará como se espera
					// porque la posición de 'a' está en el 1° (primer) caracter.
					if ($pos === false) {
					    //echo "La cadena '$findme' no fue encontrada en la cadena '$intervalo_final'";
					    
					    //el intervalo es negativo, ya se paso
						/*
					    echo '<li class="list-group-item list-group-item-info">';

							echo "<span class='glyphicon glyphicon glyphicon-calendar'></span> Proceso: ".$resultado[$i]["nom_entidad"]."/".$resultado[$i]["fecha_creacion"]." -- Fecha de Cierre: ".$resultado[$i]["fecha_cierre"]."<br>";
							//muestra la diferencia
							echo "<span class='glyphicon glyphicon-time'></span> ".$interval->format('%R%a días')."<br>";
						    echo "<span class='glyphicon glyphicon-info-sign'></span> La fecha para este proceso ya se paso y ya se cerro.";

					    echo '</li>';*/

					} else {
					    //echo "La cadena '$findme' fue encontrada en la cadena '$intervalo_final'";
					    //echo " y existe en la posición $pos";

					    //el intervalo es positivo aun hay posibilidades de enviar correo

					    $intervalo_num = $interval->format('%a');

					    echo '<li class="list-group-item">';

								//echo "<span class='glyphicon glyphicon glyphicon-calendar'></span> Proceso: ".$resultado[$i]["nom_entidad"]."/".$resultado[$i]["fecha_creacion"]." -- Fecha de Cierre: ".$resultado[$i]["fecha_cierre"]."<br>";
							    
								//muestra la diferencia
					    		if(is_null($resultado[$i]["pkID"])){
					    			echo "--";
					    		}else{

					    			if ($intervalo_num <= 5) {
					    				//echo "<= a 5";
					    				echo "<a href='detail_proceso.php?id_proceso=".$resultado[$i]["pkID"]."' style='color: red;'><span class='glyphicon glyphicon-time'></span> Faltan ".$interval->format('%R%a días')." para el cierre del Proceso: ".$resultado[$i]["nom_entidad"]."/".$resultado[$i]["fecha_creacion"]."</a>";
					    			}else{
					    				echo "<a href='detail_proceso.php?id_proceso=".$resultado[$i]["pkID"]."'><span class='glyphicon glyphicon-time'></span> Faltan ".$interval->format('%R%a días')." para el cierre del Proceso: ".$resultado[$i]["nom_entidad"]."/".$resultado[$i]["fecha_creacion"]."</a>";
					    			}

								}

					    echo '</li>';					    
					}	
					
				}
			echo '</ul>';

			}else{

				echo '<div class="alert alert-warning" role="alert">
						  En el momento no hay Procesos creados.
					  </div>';
			}
		}
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++



		function notIndexProcesoSAdMC(){

			$resultado = $this->getProcesoSAdMC();

			$intervalo_num = 0;

			if (sizeof($resultado) > 0) {
				# code...
			

			echo '<ul class="list-group">';

				for ($i=0; $i < sizeof($resultado); $i++) { 
					# code...
					
					
						//fecha actual
						$datetime1 = date_create(date("Y-m-d"));
						//fecha a comparar
						$datetime2 = date_create($resultado[$i]["fecha_apertura"]);
						//intervalo de días
						$interval = date_diff($datetime1, $datetime2);
						//muestra la diferencia
						//echo $interval->format('%R%a días')."<br>";
						
						$intervalo_final = $interval->format('%R%a');

						//echo $intervalo_final."<br>";

						$findme = '+';

						$pos = strpos($intervalo_final, $findme);
					
					

					// Nótese el uso de ===. Puesto que == simple no funcionará como se espera
					// porque la posición de 'a' está en el 1° (primer) caracter.
					if ($pos === false) {
					    //echo "La cadena '$findme' no fue encontrada en la cadena '$intervalo_final'";
					    
					    //el intervalo es negativo, ya se paso
						/*
					    echo '<li class="list-group-item list-group-item-info">';

							echo "<span class='glyphicon glyphicon glyphicon-calendar'></span> Proceso: ".$resultado[$i]["nom_entidad"]."/".$resultado[$i]["fecha_creacion"]." -- Fecha de Cierre: ".$resultado[$i]["fecha_cierre"]."<br>";
							//muestra la diferencia
							echo "<span class='glyphicon glyphicon-time'></span> ".$interval->format('%R%a días')."<br>";
						    echo "<span class='glyphicon glyphicon-info-sign'></span> La fecha para este proceso ya se paso y ya se cerro.";

					    echo '</li>';*/

					} else {
					    //echo "La cadena '$findme' fue encontrada en la cadena '$intervalo_final'";
					    //echo " y existe en la posición $pos";

					    //el intervalo es positivo aun hay posibilidades de enviar correo

					    $intervalo_num = $interval->format('%a');

					    echo '<li class="list-group-item">';

								//echo "<span class='glyphicon glyphicon glyphicon-calendar'></span> Proceso: ".$resultado[$i]["nom_entidad"]."/".$resultado[$i]["fecha_creacion"]." -- Fecha de Cierre: ".$resultado[$i]["fecha_cierre"]."<br>";
							    
								//muestra la diferencia
					    		if(is_null($resultado[$i]["pkID"])){
					    			echo "--";
					    		}else{

					    			if ($intervalo_num <= 5) {
					    				//echo "<= a 5";
					    				echo "<a href='detail_proceso.php?id_proceso=".$resultado[$i]["pkID"]."' style='color: red;'><span class='glyphicon glyphicon-time'></span> Faltan ".$interval->format('%R%a días')." para la Apertura del Proceso: ".$resultado[$i]["nom_entidad"]."/".$resultado[$i]["fecha_creacion"]."</a>";
					    			}else{
					    				echo "<a href='detail_proceso.php?id_proceso=".$resultado[$i]["pkID"]."'><span class='glyphicon glyphicon-time'></span> Faltan ".$interval->format('%R%a días')." para la Apertura del Proceso: ".$resultado[$i]["nom_entidad"]."/".$resultado[$i]["fecha_creacion"]."</a>";
					    			}

								}

					    echo '</li>';					    
					}	
					
				}
			echo '</ul>';

			}else{

				echo '<div class="alert alert-warning" role="alert">
						  En el momento no hay Procesos creados.
					  </div>';
			}
		}


	}

?>