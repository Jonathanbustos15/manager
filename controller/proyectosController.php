<?php 

	include('../DAO/ProyectosDAO.php');
	include('render_table.php');

	class proyectosController extends proyectos {

		//-------------------------------------
		//variables
		public $table_inst;
		public $proyecto;
		public $presupuesto;
		public $documentos;
		public $presupuestoAct;
		public $id_modulo;
		//
		public $ruta_visor;
		public $ruta_multiple;
	    public $ruta_visor_multiple;
		//-------------------------------------
		public function __construct() {
			
			//include('../conexion/datos.php');
			
			//$this->id_modulo = --; id de la tabla modulos
			//$this->NameCookieApp = $NomCookiesApp;
			$this->id_modulo = 4;
		}

		//---------------------------------------------------------------------------------

		public function numProyectos(){

			$numProyectos = $this->getNumProyectos();

			echo $numProyectos[0]["numProyectos"];			
		}

		public function creaTablaProyectos($filtro,$id_tabla){

			echo '<div class="dataTable_wrapper table-responsive">
	                <table class="table table-striped table-bordered table-hover" id="tbl_proyectos_'.$id_tabla.'">
	                    <thead>
	                        <tr>                        
	                            <th>Nombre</th>
	                            <th>Fecha Inicial</th>
	                            <th>Fecha Final</th>
	                            <th>Objeto</th>
	                            
	                            
	                            <th>Total</th>
	                            <th>Empresa</th>
	                            
	                                                              
	                            <th data-orderable="false"  class="tabla-form-ancho">Opciones</th>
	                        </tr>
	                    </thead>
	                    <tbody>';
	                          
	                        $this->getTablaProyectos($filtro);
	                         
	        echo '      </tbody>
	                </table>
	            </div>';
		}
		
		public function getTablaProyectos($filtro){

			//echo $filtro;
			//añadir la condicion del usuario al filtro
			$filter_user = "";
			

			if ($filtro == '*') {

				$this->proyecto = 0;
				# code...
				//valida que tipo de usuario es y de acuerdo a eso
				//se hace la consulta
				if ($_COOKIE["log_lunelAdmin_IDtipo"] != 13) {
					# code...
					$this->proyecto = $this->getProyectos();

				}else {
					
					$this->proyecto = $this->getProyectosFuntecso();
					
				} 

	    		
			}else{

				$this->proyecto = 0;


				$cambio = array("AND", "proyectos.");			

				$campos_str = str_replace($cambio, "", $filtro);

				$arr_campos = explode(" ",$campos_str);

				$arr_completo = array();
				//print_r ($arr_campos);

				echo "<p>Filtrando por:</p>";

				for ($i=0; $i < sizeof($arr_campos) ; $i++) { 
					# code...
					//echo $arr_campos[$i].'<br>';

					$arr_campos1 = explode("=",$arr_campos[$i]);				

					/*print_r($arr_campos1);
					echo "<br><br>";
					echo "<br><br>";
					*/
					if ($arr_campos1[0] == "fkID_empresa") {
						# code...
						$empresaId = $this->getEmpresaId($arr_campos1[1]);

						//print_r($empresaId);

						echo "<span class='badge'>Empresa:".$empresaId[0]["nombre"]."</span>";
						echo "<br>";
					}

				}
				echo "</br>";
				/*
				echo "<p>Filtrando por:</p>";

				$cambio = array("=", "estado_proyecto.pkID");			

				$campos_str = str_replace($cambio, "", $filtro);
				
				$estadoId = $this->getEstadoId($campos_str);

				echo "<span class='badge'>Estado: ".$estadoId[0]["nombre"]."</span>";*/

				if ($_COOKIE["log_lunelAdmin_IDtipo"] != 13) {
					# code...

					$this->proyecto = $this->getProyectosFiltro($filtro);
				}else{ 
					$this->proyecto = $this->getProyectosFiltroFuntecso($filtro);
				}	
		    		    		
	    		//echo "<br> <br>";
			}	    	

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos(4,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//---------------------------------------------------------------------------------

    		//Define las variables de la tabla a renderizar------------------------------------    		

    		$proyectos_campos = [
									["nombre"=>"nombre"],
									["nombre"=>"fechaIni"],
									["nombre"=>"fechaFin"],
									[
										"nombre"=>"objeto",
										"tipo"=>"strlen",
										"len"=>60
									],
									
									[
										"nombre"=>"total",
										"tipo"=>"number_format"
									],
									["nombre"=>"empresa"]
								];
    		
    		//las opciones de la tabla en cada td
    		$proyectos_opciones = [
    			"modulo"=>"proyecto",
				"title"=>"Click Ver Detalles",
				"href"=>"detail_proyecto.php?id_proyecto=&filter_gastos=*&filter_documentos=*",
				"class"=>"detail"
    		];
    		//la configuracion de los botones de opciones
    		$proyectos_btn =[

	    		 [
	    			"tipo"=>"editar",
	    			"nombre"=>"proyecto",
	    			"permiso"=>$edita,
	    		 ],
	    		 [
	    			"tipo"=>"eliminar",
	    			"nombre"=>"proyecto",
	    			"permiso"=>$elimina,
	    		 ]

	    	];

	    	//Instancia el render
	    	$this->table_inst = new RenderTable($this->proyecto,$proyectos_campos,$proyectos_btn,$proyectos_opciones);
	    	//---------------------------------------------------------------------------------

	    	if( ($this->proyecto) && ($consulta==1) ){

	    		$this->table_inst->render();	    		


	    	}elseif(($this->proyecto) && ($consulta==0)){


	    	 $this->table_inst->render_blank();

             echo "<div class='alert alert-danger' role='alert'>  						 
  						 En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Proyectos.</strong>
				   </div>";
            }else{

             $this->table_inst->render_blank();

             echo "<div class='alert alert-danger' role='alert'>
  						 En este momento no hay <strong>Proyectos</strong> creados.
				   </div>";
            };

	    }


		
		//-------------------------------------------------------------------------------------------
		//

		public function getTotalGastosF($pkID,$filtro){

			if ($filtro == '*') {
				# code...
				$suma = $this->getTotalGastos($pkID);
				//print_r($suma);
			} else if ($filtro == 'actividad.pkID = No Aplica') {
				$suma = $this->getTotalGastosNoAct($pkID);				
			}else {
				# code...
				$suma = $this->getTotalGastosFiltro($pkID,$filtro);
			}

			echo $suma[0]['total_gastos'];

		}

		public function getTotalIvaF($pkID,$filtro){

			if ($filtro == '*') {
				# code...
				$suma = $this->getTotalIva($pkID);
				//print_r($suma);
			} else if ($filtro == 'actividad.pkID = No Aplica') {
				$suma = $this->getTotalIvaNoAct($pkID);
			}else {
				# code...
				$suma = $this->getTotalIvaFiltro($pkID,$filtro);
			}

			echo $suma[0]['total_iva'];

		}

		public function getTotalFinalF($pkID,$filtro){

			if ($filtro == '*') {
				# code...
				$suma = $this->getTotalFinal($pkID);
				//print_r($suma);
			} else if ($filtro == 'actividad.pkID = No Aplica') {
				$suma = $this->getTotalFinalNoAct($pkID);
			}else {
				# code...
				$suma = $this->getTotalFinalFiltro($pkID,$filtro);
			}

			echo $suma[0]['total_final'];

		}

		public function getDataGenProyecto($pkID){

			$this->proyecto = $this->getProyectoId($pkID);

			//print_r($this->proyecto);

			//--------------------------------------------
			//$file = fopen("/var/www/html/lunel_ie_manager/controller/archivo.txt", "w");
			//fwrite($file, "el dato es: ".$this->proyecto[0]["nombre"]);
			//fwrite($file, print_r($this->proyecto));			
			//fclose($file);
			//--------------------------------------------

			if(sizeof($this->proyecto) > 0){

			echo '	<div>

						<strong>Empresa: </strong> '.$this->proyecto[0]["nom_empresa"].' <br> <br>

						<strong>Nombre: </strong> '.$this->proyecto[0]["nombre"].' <br> <br>

						<strong>Entidad Contratante: </strong> '.$this->proyecto[0]["nom_entidad"].' <br> <br>';
						
						if ( ($this->proyecto[0]["nom_contacto"] == "" ) or ( is_null($this->proyecto[0]["nom_contacto"])) ) {							
							echo "No hay información de contacto. <br> <br>";
						} else {
							echo '<strong>Nombre de Contacto: </strong> '.$this->proyecto[0]["nom_contacto"].' <br> <br>';
							echo '<strong>Teléfono de Contacto: </strong> '.$this->proyecto[0]["tel_contacto"].' <br> <br>';
							echo '<strong>Observaciones: </strong> '.$this->proyecto[0]["observacion_entidad"].' <br> <br>';
						}						
					  
				echo '	<strong>Fecha de Inicio:</strong> '.$this->proyecto[0]["fechaIni"].' /

					  	<strong>Fecha de Fin:</strong> '.$this->proyecto[0]["fechaFin"].' <br> <br>

					  	<strong>Objeto:</strong> '.$this->proyecto[0]["objeto"].' <br> <br>

					  	<strong>Sub-Total:</strong> $'.number_format($this->proyecto[0]["subtotal"], 0, '', '.').'  |

					  	<strong>IVA:</strong> $'.number_format($this->proyecto[0]["iva"], 0, '', '.').'  |

					  	<strong>Total:</strong> $'.number_format($this->proyecto[0]["total"], 0, '', '.').' <br> <br>
						
						<strong>Estado:</strong> '.$this->proyecto[0]["nom_estado"].' <br> <br>

					</div>';

			}else{
				
				echo "<div class='alert alert-warning' role='alert'>
  						 Este <strong>Proyecto</strong> no tiene datos generales.
				   </div>";
			}

			
		}

		public function getObservacionesProyecto(){
			/*
			No es necesario el id porque ya está cargado el proceso
			en el array procesoId
			*/
			$observacionesArray = explode("--", $this->proyecto[0]["observaciones"]);

			//print_r($observacionesArray);

			echo '<strong>Observaciones:</strong> <br> <br>';

			foreach ($observacionesArray as $key => $value) {
				echo $value.' <br>';
			}

		}

		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//presupuesto controller

		public function getTablaPresupuesto($pkID,$filtro){

	    	/* En caso de traer solo registros de x usuario
	    	if($tipo_usuario == "Administrador"){
	    		//get de los categoria  
	    		$this->categoria = $this->getcategoria();
	    	}else{
	    		$this->categoria = $this->getcategoriaUser($id_usuario);
	    	}*/
	    	//echo "buscando por id: ".$pkID;

	    	if ($filtro == '*') {
				# code...
				
	    		$this->presupuesto = $this->getPresupuesto($pkID);
		    	$this->presupuestoAct = $this->getPresupuestoAct($pkID);

			} else if($filtro == 'actividad.pkID = No Aplica'){				

				echo "<p>Filtrando por:</p>";				
				
				$this->presupuesto = $this->getPresupuesto($pkID);

				echo "<span class='badge'>Actividad: No Aplica</span>";

				echo "<br> <br>";

			}else {

				echo "<p>Filtrando por:</p>";

				$cambio = array("=", "actividad.pkID");			

				$campos_str = str_replace($cambio, "", $filtro);
				
				$actividadId = $this->getActividadId($campos_str);

				echo "<span class='badge'>Actividad: ".$actividadId[0]["nombre"]."</span>";				
		    	
	    		$this->presupuestoAct = $this->getPresupuestoActFiltro($pkID,$filtro);

	    		echo "<br> <br>";
		    }
	    	/*
	    	print_r($this->presupuesto);
	    	echo "<br>";
	    	print_r($this->presupuestoAct);*/	    	

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos(9,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$editaPresupuesto = $arrPermisos[0]["editar"];
    		$eliminaPresupuesto = $arrPermisos[0]["eliminar"];
    		$consultaPresupuesto = $arrPermisos[0]["consultar"];
    		//---------------------------------------------------------------------------------  

	    	//valida si hay proyecto
	    	if( ($this->presupuesto) && ($consultaPresupuesto==1) ){

	    		for($a=0;$a<sizeof($this->presupuesto);$a++){

                 $id = $this->presupuesto[$a]["pkID"];
                 $nombre = $this->presupuesto[$a]["nombre"];                 
                 $valor = $this->presupuesto[$a]["valor"];

                 $iva = $this->presupuesto[$a]["iva"];
                 $total = $this->presupuesto[$a]["total"];                 

                 $archivo = $this->presupuesto[$a]["nom_archivo"];

                 //<td>'.$id.'</td>

                 echo '
                             <tr>
                             	                              	 
                                 <td>'.$nombre.'</td>                                 
                                 <td>';                                
                                 	echo "No aplica";
                           echo '</td>
                                 <td>'.'$'.number_format($valor, 0, '', '.').'</td>
                                 <td>'.'$'.number_format($iva, 0, '', '.').'</td>
                                 <td>'.'$'.number_format($total, 0, '', '.').'</td>                                 
		                         <td>';

		                         if( ($archivo != null) || ($archivo != "") ){
                 					echo '<a title="Descargar Adjunto" class="btn btn-success" href="subidas/'.$archivo.'" target="_blank"><span class="glyphicon glyphicon-file"></span></a>';
                 				  }  		                         		                             		                           
		         echo'               <button id="btn_editar" title="Editar" name="edita_presupuesto" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_presupuesto" data-id-presupuesto = "'.$id.'" '; if ($editaPresupuesto != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_presupuesto" type="button" class="btn btn-danger" data-id-presupuesto = "'.$id.'" '; if ($eliminaPresupuesto != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };

                /**/
                if ($this->presupuestoAct) {
                	# code...
                	for($a=0;$a<sizeof($this->presupuestoAct);$a++){

	                 $id = $this->presupuestoAct[$a]["pkID"];
	                 $nombre = $this->presupuestoAct[$a]["nombre"];	                 
	                 $valor = $this->presupuestoAct[$a]["valor"];
	                 $iva = $this->presupuestoAct[$a]["iva"];
                 	 $total = $this->presupuestoAct[$a]["total"];                 
	                 //nom_actividad
	                 $nom_actividad = $this->presupuestoAct[$a]["nom_actividad"];	
	                 $archivo = $this->presupuestoAct[$a]["nom_archivo"];

	                 //<td>'.$id.'</td>

	                 echo '
	                             <tr>
	                             	                              	 
	                                 <td>'.$nombre.'</td>	                                 
	                                 <td>'.$nom_actividad.'</td>
	                                 <td>'.'$'.number_format($valor, 0, '', '.').'</td>
	                                 <td>'.'$'.number_format($iva, 0, '', '.').'</td>
                                 	 <td>'.'$'.number_format($total, 0, '', '.').'</td>                                 
			                         <td>';

			                         if( ($archivo != null) || ($archivo != "") ){
	                 					echo '<a title="Descargar Adjunto" class="btn btn-success" href="subidas/'.$archivo.'" target="_blank"><span class="glyphicon glyphicon-file"></span></a>';
	                 				  }  		                         		                             		                           
			         echo'               <button id="btn_editar" title="Editar" name="edita_presupuesto" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_presupuesto" data-id-presupuesto = "'.$id.'" '; if ($editaPresupuesto != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>
			                             
			                             <button id="btn_eliminar" title="Eliminar" name="elimina_presupuesto" type="button" class="btn btn-danger" data-id-presupuesto = "'.$id.'" '; if ($eliminaPresupuesto != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
			                         </td> 
			                     </tr>';
	                };

                };


	    	}elseif(($this->presupuestoAct) && ($consultaPresupuesto==1)){

	    		# code...
            	for($a=0;$a<sizeof($this->presupuestoAct);$a++){

                 $id = $this->presupuestoAct[$a]["pkID"];                 
                 $nombre = $this->presupuestoAct[$a]["nombre"];
                 $valor = $this->presupuestoAct[$a]["valor"];
                 $iva = $this->presupuestoAct[$a]["iva"];
             	 $total = $this->presupuestoAct[$a]["total"];                 
                 //nom_actividad
                 $nom_actividad = $this->presupuestoAct[$a]["nom_actividad"];	
                 $archivo = $this->presupuestoAct[$a]["nom_archivo"];

                 //<td>'.$id.'</td>

                 echo '
                             <tr> 
                             	                             	 
                                 <td>'.$nombre.'</td>                                 
                                 <td>'.$nom_actividad.'</td>
                                 <td>'.'$'.number_format($valor, 0, '', '.').'</td>
                                 <td>'.'$'.number_format($iva, 0, '', '.').'</td>
                             	 <td>'.'$'.number_format($total, 0, '', '.').'</td>                                 
		                         <td>';

		                         if( ($archivo != null) || ($archivo != "") ){
                 					echo '<a title="Descargar Adjunto" class="btn btn-success" href="subidas/'.$archivo.'" target="_blank"><span class="glyphicon glyphicon-file"></span></a>';
                 				  }  		                         		                             		                           
		         echo'               <button id="btn_editar" title="Editar" name="edita_presupuesto" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_presupuesto" data-id-presupuesto = "'.$id.'" '; if ($editaPresupuesto != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_presupuesto" type="button" class="btn btn-danger" data-id-presupuesto = "'.$id.'" '; if ($eliminaPresupuesto != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };

	    	}elseif(($this->presupuesto) && ($consultaPresupuesto==0)){

             echo "<tr>		               
		               
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>		               		               		                                          
		           </tr>
		           <div class='alert alert-danger' role='alert'>  						
  						En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Proyectos/Presupuesto.</strong>
				   </div>";
            }else{

             echo "<tr>		               
		               
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>		               		               		                                         
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		En este momento no hay <strong>Registros</strong> para este <strong>Proyecto</strong> o no coincide con el filtro.  						
				   </div>";
            };

	    }
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	    public function getSelectTipoDocumento(){

	    	$tipoSelect = $this->getTipoDocumento();

	          for ($i=0; $i < sizeof($tipoSelect); $i++) {
	              echo '<option value="'.$tipoSelect[$i]["pkID"].'">'.$tipoSelect[$i]["nombre_tdoc"].'</option>';
	          };
	    }

	    public function getTablaDocumentos($pkID,$filtro){

	    	/* En caso de traer solo registros de x usuario
	    	if($tipo_usuario == "Administrador"){
	    		//get de los categoria  
	    		$this->categoria = $this->getcategoria();
	    	}else{
	    		$this->categoria = $this->getcategoriaUser($id_usuario);
	    	}*/

	    	include("../Conexion/datos.php");
	    	$this->ruta_visor = $ruta_visor;
	    	$this->ruta_multiple = $ruta_server_multiple;
	    	$this->ruta_visor_multiple = $ruta_visor_multiple;

	    	if ($filtro == '*') {
				# code...
				
	    		$this->documentos = $this->getDocumentos($pkID);

	    		//print_r($this->documentos);

			}else {
				/**/	
				echo "<p>Filtrando por:</p>";

				$cambio = array("=", "documentos.fkID_tipo");			

				$campos_str = str_replace($cambio, "", $filtro);
				
				$tipoDocumentoId = $this->getTipoDocumentoId($campos_str);

				echo "<span class='badge'>Tipo de Documento: ".$tipoDocumentoId[0]["nombre_tdoc"]."</span>";			
		    	
	    		$this->documentos = $this->getDocumentosFiltro($pkID,$filtro);

	    		echo "<br> <br>";
		    }

	    	

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos(10,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$editaDocumentos = $arrPermisos[0]["editar"];
    		$eliminaDocumentos = $arrPermisos[0]["eliminar"];
    		$consultaDocumentos = $arrPermisos[0]["consultar"];
    		//--------------------------------------------------------------------------------- 	    	

	    	//valida si hay proyecto
	    	if( ($this->documentos) && ($consultaDocumentos==1) ){

	    		for($a=0;$a<sizeof($this->documentos);$a++){

                 $id = $this->documentos[$a]["pkID"];
                 $nombre = $this->documentos[$a]["nom_doc"];
                 $ruta = $this->documentos[$a]["ruta"];                
                 $tipo = $this->documentos[$a]["nom_tipoDocumento"];
                 $nombre_tsubtipo = $this->documentos[$a]["nombre_tsubtipo"];

                 //<td>'.$id.'</td>                               

                 echo '
                             <tr>
                             	 
                             	 <td>'.$tipo.'</td>
                             	 <td>'.$nombre_tsubtipo.'</td>                             	 
                                 <td>'.$nombre.'</td>                                                                                                  
		                         <td>
		                         	 <a id="btn_doc" title="Descargar Archivo" name="download_documento" type="button" class="btn btn-success" href = "../server/php/files/'.$ruta.'" target="_blank" ><span class="glyphicon glyphicon-download-alt"></span></a>
									 <a class="btn btn-info" title="Visualizar Archivo con Google Docs" href="https://docs.google.com/viewer?url='.$this->ruta_visor_multiple.''.$ruta.'" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a>
		                             <button id="btn_editar" title="Editar" name="edita_documento" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_documentos" data-id-documento = "'.$id.'" '; if ($editaDocumentos != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_documento" type="button" class="btn btn-danger" data-id-documento = "'.$id.'" '; if ($eliminaDocumentos != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };


	    	}elseif(($this->documentos) && ($consultaDocumentos==0)){

             echo "<tr>
		              
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>		               		               		               		                                         
		           </tr>
		           <div class='alert alert-danger' role='alert'>		           		
		           		En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Proyectos/Documentos.</strong>  						
				   </div>";
            }else{

             echo "<tr>		               		               
		               
		               <td></td>
		               <td></td>
		               <td></td>		               		               		               		                                      
		               <td></td>
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		En este momento no hay <strong>Registros</strong> para este <strong>Proyecto</strong> o el filtro no coincide.		           		
				   </div>";
            };

	    }
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		public function selectEntidad(){

			$entidadSelect = $this->getSelectEntidad();

            for ($i=0; $i < sizeof($entidadSelect); $i++) {
                echo '<option value="'.$entidadSelect[$i]["pkID"].'">'.$entidadSelect[$i]["nombre_entidad"].'</option>';
            };
		}

		public function selectActividades($pkID){

			$actividadSelect = $this->getActividades($pkID);
      	
      		echo '<select name="fkID_actividad" id="fkID_actividad" class="form-control add-selectElement">;
      				<option></option>';

            for ($i=0; $i < sizeof($actividadSelect); $i++) {            	            			
                	echo '<option value="'.$actividadSelect[$i]["pkID"].'">'.$actividadSelect[$i]["nombre"].'</option>'; 
                	  
            };

            echo '</select>';
		}

		public function selectActividadesFiltro($pkID){

			$actividadSelect = $this->getActividades($pkID);
      	
      		echo '<select name="actividad_filtro" id="actividad_filtro" class="form-control add-selectElement">;
      				<option></option>
      				<option value="No Aplica">No Aplica</option>';

            for ($i=0; $i < sizeof($actividadSelect); $i++) {            	            			
                	echo '<option value="'.$actividadSelect[$i]["pkID"].'">'.$actividadSelect[$i]["nombre"].'</option>'; 
                	  
            };

            echo '</select>';
		}

		public function selectEstadosFiltro(){

			$EstadoSelect = $this->getSelectEstadoProyecto();
      	
      		echo '<select name="estado_filtro" id="estado_filtro" class="form-control add-selectElement">;      				
      				<option value="">Todos</option>';

            for ($i=0; $i < sizeof($EstadoSelect); $i++) {            	            			
                	echo '<option value="'.$EstadoSelect[$i]["pkID"].'">'.$EstadoSelect[$i]["nombre"].'</option>'; 
                	  
            };

            echo '</select>';
		}

		public function selectTipoDocumentosFiltro(){

			$documentosSelect = $this->getTipoDocumento();
      	
      		echo '<select id="documentos_filtro" class="form-control add-selectElement">;
      				<option></option>';      				

            for ($i=0; $i < sizeof($documentosSelect); $i++) {            	            			
                	echo '<option value="'.$documentosSelect[$i]["pkID"].'">'.$documentosSelect[$i]["nombre_tdoc"].'</option>'; 
                	  
            };

            echo '</select>';
		}


		public function getSelectEmpresasFiltro(){

			$empresaSelect = $this->getEmpresas();

			echo '<select name="empresa_filtrop" id="empresa_filtrop" class="form-control select-filtro">
                        <option value="">Todo</option>';
                        for ($i=0; $i < sizeof($empresaSelect); $i++) {
                                echo '<option value="'.$empresaSelect[$i]["pkID"].'" >'.$empresaSelect[$i]["nombre"].'</option>';
                            };
            echo '</select>';
		}


//-----------------Desarrollo pruebas---------------------------------------------------------


		public function creaTablaProyectosE($filtro,$id_tabla){

			echo '<div class="dataTable_wrapper table-responsive">
	                <table class="table table-striped table-bordered table-hover" id="tbl_proyectos_'.$id_tabla.'">
	                    <thead>
	                        <tr>                        
	                            <th>Nombre</th>
	                            <th>Fecha Inicial</th>
	                            <th>Fecha Final</th>
	                            <th>Objeto</th>
	                            
	                            
	                            <th>Total</th>
	                            <th>Empresa</th>
	                            
	                                                              
	                            <th data-orderable="false"  class="tabla-form-ancho">Opciones</th>
	                        </tr>
	                    </thead>
	                    <tbody>';
	                          
	                        $this->getTablaProyectosEjecucion($filtro);
	                         
	        echo '      </tbody>
	                </table>
	            </div>';
		}

        /*Tabla para los proyectos en ejecuión*/
		public function getTablaProyectosEjecucion($filtro){

			if ($filtro == '*') {
				
				$tipoUsuario = $_COOKIE['log_lunelAdmin_IDtipo'];

				if($tipoUsuario == 1){
					$this->proyecto = $this->getProyectosEjecucionT();
				}else{
					if($tipoUsuario == 13) {
						$this->proyecto = $this->getProyectosFuntecsoEjecucion();
					}else{
						$usuarioL = $_COOKIE['log_lunelAdmin_id'];
						$this->proyecto = $this->getProyectosLiderEjecucion($usuarioL);				
					}
				}
	

			} else {

				# code...
				$cambio = array("AND", "proyectos.");			

				$campos_str = str_replace($cambio, "", $filtro);

				$arr_campos = explode(" ",$campos_str);

				$arr_completo = array();
				//print_r ($arr_campos);

				echo "<p>Filtrando por:</p>";

				for ($i=0; $i < sizeof($arr_campos) ; $i++) { 
					# code...
					//echo $arr_campos[$i].'<br>';

					$arr_campos1 = explode("=",$arr_campos[$i]);				

					/*print_r($arr_campos1);
					echo "<br><br>";
					echo "<br><br>";
					*/
					if ($arr_campos1[0] == "fkID_empresa") {
						# code...
						$empresaId = $this->getEmpresaId($arr_campos1[1]);

						//print_r($empresaId);

						echo "<span class='badge'>Empresa:".$empresaId[0]["nombre"]."</span>";
					}

				


				}
				/*echo "<br><br>";
				print_r($filtro);	*/
				echo "<br> <br>";
				if($tipoUsuario == 8){
					
				}else{
					$this->proyecto = $this->getProyectosEjecucion($filtro);	
				}
				//print_r($this->gasto);
				

			}	    	
	    	
	    	//print_r($formatosNoSub);
	    	//mete los formatos sin subcategoria
	    	//array_merge($this->Formatos, $formatosNoSub);

	    	//print_r($this->Formatos);	    	

	    	//valida si hay formatos

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos(4,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//---------------------------------------------------------------------------------

    		//Define las variables de la tabla a renderizar------------------------------------    		

    		$proyectos_campos = [
									["nombre"=>"nombre"],
									["nombre"=>"fechaIni"],
									["nombre"=>"fechaFin"],
									[
										"nombre"=>"objeto",
										"tipo"=>"strlen",
										"len"=>60
									],
									
									[
										"nombre"=>"total",
										"tipo"=>"number_format"
									],
									["nombre"=>"empresa"]
								];
    		
    		//las opciones de la tabla en cada td
    		$proyectos_opciones = [
    			"modulo"=>"proyecto",
				"title"=>"Click Ver Detalles",
				"href"=>"detail_proyecto.php?id_proyecto=&filter_gastos=*&filter_documentos=*",
				"class"=>"detail"
    		];
    		//la configuracion de los botones de opciones
    		$proyectos_btn =[

	    		 [
	    			"tipo"=>"editar",
	    			"nombre"=>"proyecto",
	    			"permiso"=>$edita,
	    		 ],
	    		 [
	    			"tipo"=>"eliminar",
	    			"nombre"=>"proyecto",
	    			"permiso"=>$elimina,
	    		 ]

	    	];

	    	//Instancia el render
	    	$this->table_inst = new RenderTable($this->proyecto,$proyectos_campos,$proyectos_btn,$proyectos_opciones);
	    	//---------------------------------------------------------------------------------

	    	if( ($this->proyecto) && ($consulta==1) ){

	    		$this->table_inst->render();	    		


	    	}elseif(($this->proyecto) && ($consulta==0)){


	    	 $this->table_inst->render_blank();

             echo "<div class='alert alert-danger' role='alert'>  						 
  						 En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Proyectos.</strong>
				   </div>";
            }else{

             $this->table_inst->render_blank();

             echo "<div class='alert alert-danger' role='alert'>
  						 En este momento no hay <strong>Proyectos</strong> creados.
				   </div>";
            };
         }   


/*------------------------------------------*/


         public function creaTablaProyectosT($filtro,$id_tabla){

			echo '<div class="dataTable_wrapper table-responsive">
	                <table class="table table-striped table-bordered table-hover" id="tbl_proyectos_'.$id_tabla.'">
	                    <thead>
	                        <tr>                        
	                            <th>Nombre</th>
	                            <th>Fecha Inicial</th>
	                            <th>Fecha Final</th>
	                            <th>Objeto</th>
	                            
	                            
	                            <th>Total</th>
	                            <th>Empresa</th>
	                            
	                                                              
	                            <th data-orderable="false"  class="tabla-form-ancho">Opciones</th>
	                        </tr>
	                    </thead>
	                    <tbody>';
	                          
	                        $this->getTablaProyectosTerminados($filtro);
	                         
	        echo '      </tbody>
	                </table>
	            </div>';
		}

         /*Tabla para los proyectos en terminados*/

         public function getTablaProyectosTerminados($filtro){

			if ($filtro == '*') {
				$tipoUsuario = $_COOKIE['log_lunelAdmin_IDtipo'];


				if($tipoUsuario == 1){
					$this->proyecto = $this->getProyectosTerminadoT();					
				}elseif ($tipoUsuario == 13) {
					$this->proyecto = $this->getProyectosFuntecsoTerminado();
				}else{
					$usuarioL = $_COOKIE['log_lunelAdmin_id'];
					$this->proyecto = $this->getProyectosLiderTerminado($usuarioL);
				}

  				/*if($tipoUsuario != 13){
					$this->proyecto = $this->getProyectosTerminadoT();
				}else{	
				    $this->proyecto = $this->getProyectosFuntecsoTerminado();
				}*/

			} else {

				# code...
				$cambio = array("AND", "proyectos.");			

				$campos_str = str_replace($cambio, "", $filtro);

				$arr_campos = explode(" ",$campos_str);

				$arr_completo = array();
				//print_r ($arr_campos);

				echo "<p>Filtrando por:</p>";

				for ($i=0; $i < sizeof($arr_campos) ; $i++) { 
					# code...
					//echo $arr_campos[$i].'<br>';

					$arr_campos1 = explode("=",$arr_campos[$i]);				

					/*print_r($arr_campos1);
					echo "<br><br>";
					echo "<br><br>";
					*/
					if ($arr_campos1[0] == "fkID_empresa") {
						# code...
						$empresaId = $this->getEmpresaId($arr_campos1[1]);

						//print_r($empresaId);

						echo "<span class='badge'>Empresa:".$empresaId[0]["nombre"]."</span>";
					}

				


				}
				/*echo "<br><br>";
				print_r($filtro);	*/
				echo "<br> <br>";

				$this->proyecto = $this->getProyectosTerminado($filtro);
				//print_r($this->gasto);
				

			}	    	
	    	
	    	//print_r($formatosNoSub);
	    	//mete los formatos sin subcategoria
	    	//array_merge($this->Formatos, $formatosNoSub);

	    	//print_r($this->Formatos);	    	

	    	//valida si hay formatos

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos(4,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//---------------------------------------------------------------------------------

    		//Define las variables de la tabla a renderizar------------------------------------    		

    		$proyectos_campos = [
									["nombre"=>"nombre"],
									["nombre"=>"fechaIni"],
									["nombre"=>"fechaFin"],
									[
										"nombre"=>"objeto",
										"tipo"=>"strlen",
										"len"=>60
									],
									
									[
										"nombre"=>"total",
										"tipo"=>"number_format"
									],
									["nombre"=>"empresa"]
								];
    		
    		//las opciones de la tabla en cada td
    		$proyectos_opciones = [
    			"modulo"=>"proyecto",
				"title"=>"Click Ver Detalles",
				"href"=>"detail_proyecto.php?id_proyecto=&filter_gastos=*&filter_documentos=*",
				"class"=>"detail"
    		];
    		//la configuracion de los botones de opciones
    		$proyectos_btn =[

	    		 [
	    			"tipo"=>"editar",
	    			"nombre"=>"proyecto",
	    			"permiso"=>$edita,
	    		 ],
	    		 [
	    			"tipo"=>"eliminar",
	    			"nombre"=>"proyecto",
	    			"permiso"=>$elimina,
	    		 ]

	    	];

	    	//Instancia el render
	    	$this->table_inst = new RenderTable($this->proyecto,$proyectos_campos,$proyectos_btn,$proyectos_opciones);
	    	//---------------------------------------------------------------------------------

	    	if( ($this->proyecto) && ($consulta==1) ){

	    		$this->table_inst->render();	    		


	    	}elseif(($this->proyecto) && ($consulta==0)){


	    	 $this->table_inst->render_blank();

             echo "<div class='alert alert-danger' role='alert'>  						 
  						 En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Proyectos.</strong>
				   </div>";
            }else{

             $this->table_inst->render_blank();

             echo "<div class='alert alert-danger' role='alert'>
  						 En este momento no hay <strong>Proyectos</strong> creados.
				   </div>";
            };
         }   




         /*------------------------------------------*/


         public function creaTablaProyectosL($filtro,$id_tabla){

			echo '<div class="dataTable_wrapper table-responsive">
	                <table class="table table-striped table-bordered table-hover" id="tbl_proyectos_'.$id_tabla.'">
	                    <thead>
	                        <tr>                        
	                            <th>Nombre</th>
	                            <th>Fecha Inicial</th>
	                            <th>Fecha Final</th>
	                            <th>Objeto</th>
	                            
	                            
	                            <th>Total</th>
	                            <th>Empresa</th>
	                            
	                                                              
	                            <th data-orderable="false"  class="tabla-form-ancho">Opciones</th>
	                        </tr>
	                    </thead>
	                    <tbody>';
	                          
	                        $this->getTablaProyectosLiquidados($filtro);
	                         
	        echo '      </tbody>
	                </table>
	            </div>';
		}

         /*Tabla para los proyectos en terminados*/

         public function getTablaProyectosLiquidados($filtro){

			if ($filtro == '*') {
				$tipoUsuario = $_COOKIE['log_lunelAdmin_IDtipo'];

  				

				if($tipoUsuario == 1){
					$this->proyecto = $this->getProyectosLiquidadoT();
				}elseif ($tipoUsuario == 13) {
					$this->proyecto = $this->getProyectosFuntecsoLiquidado();
				}else{
					$usuarioL = $_COOKIE['log_lunelAdmin_id'];
					$this->proyecto = $this->getProyectosLiderLiquidado($usuarioL);				
				}
  				/*if($tipoUsuario != 13){
					$this->proyecto = $this->getProyectosLiquidadoT();
				}else{
					$this->proyecto = $this->getProyectosFuntecsoLiquidado();
				}*/	

			} else {

				# code...
				$cambio = array("AND", "proyectos.");			

				$campos_str = str_replace($cambio, "", $filtro);

				$arr_campos = explode(" ",$campos_str);

				$arr_completo = array();
				//print_r ($arr_campos);

				echo "<p>Filtrando por:</p>";

				for ($i=0; $i < sizeof($arr_campos) ; $i++) { 
					# code...
					//echo $arr_campos[$i].'<br>';

					$arr_campos1 = explode("=",$arr_campos[$i]);				

					/*print_r($arr_campos1);
					echo "<br><br>";
					echo "<br><br>";
					*/
					if ($arr_campos1[0] == "fkID_empresa") {
						# code...
						$empresaId = $this->getEmpresaId($arr_campos1[1]);

						//print_r($empresaId);

						echo "<span class='badge'>Empresa:".$empresaId[0]["nombre"]."</span>";
					}

				


				}
				/*echo "<br><br>";
				print_r($filtro);	*/
				echo "<br> <br>";

				$this->proyecto = $this->getProyectosLiquidado($filtro);
				//print_r($this->gasto);
				

			}	    	
	    	
	    	//print_r($formatosNoSub);
	    	//mete los formatos sin subcategoria
	    	//array_merge($this->Formatos, $formatosNoSub);

	    	//print_r($this->Formatos);	    	

	    	//valida si hay formatos

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos(4,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//---------------------------------------------------------------------------------

    		//Define las variables de la tabla a renderizar------------------------------------    		

    		$proyectos_campos = [
									["nombre"=>"nombre"],
									["nombre"=>"fechaIni"],
									["nombre"=>"fechaFin"],
									[
										"nombre"=>"objeto",
										"tipo"=>"strlen",
										"len"=>60
									],
									
									[
										"nombre"=>"total",
										"tipo"=>"number_format"
									],
									["nombre"=>"empresa"]
								];
    		
    		//las opciones de la tabla en cada td
    		$proyectos_opciones = [
    			"modulo"=>"proyecto",
				"title"=>"Click Ver Detalles",
				"href"=>"detail_proyecto.php?id_proyecto=&filter_gastos=*&filter_documentos=*",
				"class"=>"detail"
    		];
    		//la configuracion de los botones de opciones
    		$proyectos_btn =[

	    		 [
	    			"tipo"=>"editar",
	    			"nombre"=>"proyecto",
	    			"permiso"=>$edita,
	    		 ],
	    		 [
	    			"tipo"=>"eliminar",
	    			"nombre"=>"proyecto",
	    			"permiso"=>$elimina,
	    		 ]

	    	];

	    	//Instancia el render
	    	$this->table_inst = new RenderTable($this->proyecto,$proyectos_campos,$proyectos_btn,$proyectos_opciones);
	    	//---------------------------------------------------------------------------------

	    	if( ($this->proyecto) && ($consulta==1) ){

	    		$this->table_inst->render();	    		


	    	}elseif(($this->proyecto) && ($consulta==0)){


	    	 $this->table_inst->render_blank();

             echo "<div class='alert alert-danger' role='alert'>  						 
  						 En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Proyectos.</strong>
				   </div>";
            }else{

             $this->table_inst->render_blank();

             echo "<div class='alert alert-danger' role='alert'>
  						 En este momento no hay <strong>Proyectos</strong> creados.
				   </div>";
            };
         }   



         /*------------------------------------------*/


         public function creaTablaProyectosTodos($filtro,$id_tabla){

			echo '<div class="dataTable_wrapper table-responsive">
	                <table class="table table-striped table-bordered table-hover" id="tbl_proyectos_'.$id_tabla.'">
	                    <thead>
	                        <tr>                        
	                            <th>Nombre</th>
	                            <th>Fecha Inicial</th>
	                            <th>Fecha Final</th>
	                            <th>Objeto</th>
	                            
	                            
	                            <th>Total</th>
	                            <th>Empresa</th>
	                            
	                                                              
	                            <th data-orderable="false"  class="tabla-form-ancho">Opciones</th>
	                        </tr>
	                    </thead>
	                    <tbody>';
	                          
	                        $this->getTablaProyectosTodos($filtro);
	                         
	        echo '      </tbody>
	                </table>
	            </div>';
		}

         /*Tabla para los proyectos en terminados*/

         public function getTablaProyectosTodos($filtro){

			if ($filtro == '*') {
				# code...
				$tipoUsuario = $_COOKIE['log_lunelAdmin_IDtipo'];


				if($tipoUsuario == 1){
					$this->proyecto = $this->getProyectos();
				}elseif ($tipoUsuario == 13) {
					$this->proyecto = $this->getProyectosFuntecso();
				}else{
					$usuarioL = $_COOKIE['log_lunelAdmin_id'];
					$this->proyecto = $this->getProyectosLiderTodos($usuarioL);				
				}
  				/*if($tipoUsuario != 13){
					$this->proyecto = $this->getProyectos();
				}else{
					$this->proyecto = $this->getProyectosFiltroFuntecso($filtro);
				}*/	

			} else {

				# code...
				$cambio = array("AND", "proyectos.");			

				$campos_str = str_replace($cambio, "", $filtro);

				$arr_campos = explode(" ",$campos_str);

				$arr_completo = array();
				//print_r ($arr_campos);

				echo "<p>Filtrando por:</p>";

				for ($i=0; $i < sizeof($arr_campos) ; $i++) { 
					# code...
					//echo $arr_campos[$i].'<br>';

					$arr_campos1 = explode("=",$arr_campos[$i]);				

					/*print_r($arr_campos1);
					echo "<br><br>";
					echo "<br><br>";
					*/
					if ($arr_campos1[0] == "fkID_empresa") {
						# code...
						$empresaId = $this->getEmpresaId($arr_campos1[1]);

						//print_r($empresaId);

						echo "<span class='badge'>Empresa:".$empresaId[0]["nombre"]."</span>";
					}

				


				}
				/*echo "<br><br>";
				print_r($filtro);	*/
				echo "<br> <br>";
				//if($tipoUsuario == 8){
				  //$usuarioL = $_COOKIE['log_lunelAdmin_id'];
					//$this->proyecto = $this->getProyectosLiderTodos($usuarioL);		
				//}else{	
					$this->proyecto = $this->getProyectosFiltro($filtro);
				//}
				//print_r($this->gasto);
				

			}	    	
	    	
	    	//print_r($formatosNoSub);
	    	//mete los formatos sin subcategoria
	    	//array_merge($this->Formatos, $formatosNoSub);

	    	//print_r($this->Formatos);	    	

	    	//valida si hay formatos

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos(4,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//---------------------------------------------------------------------------------

    		//Define las variables de la tabla a renderizar------------------------------------    		

    		$proyectos_campos = [
									["nombre"=>"nombre"],
									["nombre"=>"fechaIni"],
									["nombre"=>"fechaFin"],
									[
										"nombre"=>"objeto",
										"tipo"=>"strlen",
										"len"=>60
									],
									
									[
										"nombre"=>"total",
										"tipo"=>"number_format"
									],
									["nombre"=>"empresa"]
								];
    		
    		//las opciones de la tabla en cada td
    		$proyectos_opciones = [
    			"modulo"=>"proyecto",
				"title"=>"Click Ver Detalles",
				"href"=>"detail_proyecto.php?id_proyecto=&filter_gastos=*&filter_documentos=*",
				"class"=>"detail"
    		];
    		//la configuracion de los botones de opciones
    		$proyectos_btn =[

	    		 [
	    			"tipo"=>"editar",
	    			"nombre"=>"proyecto",
	    			"permiso"=>$edita,
	    		 ],
	    		 [
	    			"tipo"=>"eliminar",
	    			"nombre"=>"proyecto",
	    			"permiso"=>$elimina,
	    		 ]

	    	];

	    	//Instancia el render
	    	$this->table_inst = new RenderTable($this->proyecto,$proyectos_campos,$proyectos_btn,$proyectos_opciones);
	    	//---------------------------------------------------------------------------------

	    	if( ($this->proyecto) && ($consulta==1) ){

	    		$this->table_inst->render();	    		


	    	}elseif(($this->proyecto) && ($consulta==0)){


	    	 $this->table_inst->render_blank();

             echo "<div class='alert alert-danger' role='alert'>  						 
  						 En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Proyectos.</strong>
				   </div>";
            }else{

             $this->table_inst->render_blank();

             echo "<div class='alert alert-danger' role='alert'>
  						 En este momento no hay <strong>Proyectos</strong> creados.
				   </div>";
            };
         } 
	    
	}

 ?>