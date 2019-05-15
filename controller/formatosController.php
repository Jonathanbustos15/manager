<?php 

	include('../DAO/FormatosDAO.php'); 

	class FormatoController extends Formatos {

		//-------------------------------------
		//variables
		public $formatos;
		public $ruta_visor;
		//-------------------------------------

		//---------------------------------------------------------------------------------

		public function numFormatos(){

			$numFormatos = $this->getNumFormatos();

			echo $numFormatos[0]["numFormatos"];			
		}

		public function getSelectPregrado(){

			$pregradoSelect = $this->getPregrado();

			echo '<select name="selectEstudio" id="selectEstudio" class="form-control" required = "true">
                        <option></option>';
                        for ($i=0; $i < sizeof($pregradoSelect); $i++) {
                                echo '<option value="'.$pregradoSelect[$i]["pkID"].'" data-nom-estudio="'.$pregradoSelect[$i]["nombre_cat"].'" data-nom-tipoestudio="'.$pregradoSelect[$i]["nom_tipo_estudio"].'">'.$pregradoSelect[$i]["nombre"].'</option>';
                            };
            echo '</select>';
		}

		public function getSelectPosgrado(){

			$posgradoSelect = $this->getPosgrado();

			echo '<select name="selectEstudioPos" id="selectEstudioPos" class="form-control">
                        <option></option>';
                        for ($i=0; $i < sizeof($posgradoSelect); $i++) {
                                echo '<option value="'.$posgradoSelect[$i]["pkID"].'" data-nom-estudio="'.$posgradoSelect[$i]["nombre_cat"].'" data-nom-tipoestudio="'.$posgradoSelect[$i]["nom_tipo_estudio"].'">'.$posgradoSelect[$i]["nombre"].'</option>';
                            };
            echo '</select>';
		}

	    public function getTablaFormatos(){

	    	/* En caso de traer solo registros de x usuario
	    	if($tipo_usuario == "Administrador"){
	    		//get de los Formatos  
	    		$this->Formatos = $this->getFormatos();
	    	}else{
	    		$this->Formatos = $this->getFormatosUser($id_usuario);
	    	}*/

	    	//instancia la variable de la ruta del visor
	    	include("../Conexion/datos.php");
	    	$this->ruta_visor = $ruta_visor;
	    	//------------------------------------------

	    	$this->Formatos = $this->getFormato();

	    	$formatosNoSub = $this->getFormatoNoSub();
	    	//print_r($formatosNoSub);
	    	//mete los formatos sin subcategoria
	    	//array_merge($this->Formatos, $formatosNoSub);

	    	//print_r($this->Formatos);	    	

	    	//valida si hay formatos

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos(2,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//--------------------------------------------------------------------------------- 

	    	if( ($this->Formatos) && ($consulta==1) ){

	    		for($a=0;$a<sizeof($this->Formatos);$a++){

                 $id = $this->Formatos[$a]["pkID"];
                 $nombre = $this->Formatos[$a]["nombre"];
                 $descripcion = $this->Formatos[$a]["descripcion"];
                 $url_archivo = $this->Formatos[$a]["url_archivo"];
                 $nom_categoria = $this->Formatos[$a]["nom_categoria"];
                 $nom_subcategoria = $this->Formatos[$a]["nom_subcategoria"];    

                 echo '
                             <tr>                             	 
                                 <td>'.$nom_categoria.'</td>
                                 <td>'.$nom_subcategoria.'</td>                                                    
                                 <td>'.$nombre.'</td>
                                 <td>'.$descripcion.'</td>
                                                                                        
		                         <td>	
		                         	<a class="btn btn-success" title="Descargar Archivo" href="subidas/'.$url_archivo.'" target="_blank"><span class="glyphicon glyphicon-file"></span></a>
		                         	<a class="btn btn-info" title="Visualizar Archivo con Google Docs" href="https://docs.google.com/viewer?url='.$this->ruta_visor.''.$url_archivo.'" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a>	                             		                            
		                             <button id="btn_editar" title="Editar" name="edita_formato" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_formato" data-id-formato = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_formato" type="button" class="btn btn-danger" data-id-formato = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };

                for($a=0;$a<sizeof($formatosNoSub);$a++){

                 $id = $formatosNoSub[$a]["pkID"];
                 $nombre = $formatosNoSub[$a]["nombre"];
                 $descripcion = $formatosNoSub[$a]["descripcion"];
                 $url_archivo = $formatosNoSub[$a]["url_archivo"];
                 $nom_categoria = $formatosNoSub[$a]["nom_categoria"];
                 //$nom_subcategoria = $formatosNoSub[$a]["nom_subcategoria"];    

                 echo '
                             <tr>                             	 
                                 <td>'.$nom_categoria.'</td>
                                 <td> -- </td>                                                    
                                 <td>'.$nombre.'</td>
                                 <td>'.$descripcion.'</td>
                                                                                        
		                         <td>	
		                         	<a class="btn btn-success" title="Descargar Archivo" href="subidas/'.$url_archivo.'" target="_blank"><span class="glyphicon glyphicon-file"></span></a>	                             		                            
		                         	<a class="btn btn-info" title="Visualizar Archivo con Google Docs" href="https://docs.google.com/viewer?url='.$this->ruta_visor.''.$url_archivo.'" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a>
		                             <button id="btn_editar" title="Editar" name="edita_formato" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_formato" data-id-formato = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_formato" type="button" class="btn btn-danger" data-id-formato = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };


	    	}elseif(($formatosNoSub) && ($consulta==1)){

	    		for($a=0;$a<sizeof($formatosNoSub);$a++){

                 $id = $formatosNoSub[$a]["pkID"];
                 $nombre = $formatosNoSub[$a]["nombre"];
                 $descripcion = $formatosNoSub[$a]["descripcion"];
                 $url_archivo = $formatosNoSub[$a]["url_archivo"];
                 $nom_categoria = $formatosNoSub[$a]["nom_categoria"];
                 //$nom_subcategoria = $formatosNoSub[$a]["nom_subcategoria"];    

                 echo '
                             <tr>                             	 
                                 <td>'.$nom_categoria.'</td>
                                 <td> -- </td>                                                    
                                 <td>'.$nombre.'</td>
                                 <td>'.$descripcion.'</td>
                                                                                        
		                         <td>	
		                         	<a class="btn btn-success" title="Descargar Archivo" href="subidas/'.$url_archivo.'" target="_blank"><span class="glyphicon glyphicon-file"></span></a>	                             		                            
		                         	<a class="btn btn-info" title="Visualizar Archivo con Google Docs" href="https://docs.google.com/viewer?url='.$this->ruta_visor.''.$url_archivo.'" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a>
		                             <button id="btn_editar" title="Editar" name="edita_formato" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_formato" data-id-formato = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_formato" type="button" class="btn btn-danger" data-id-formato = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };

	    	}elseif(($this->Formatos) && ($consulta==0)){

             echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>		               		               		                                          
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Formatos.</strong>  						
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
		           		En este momento no hay Formatos creados.
				   </div>";
            };

	    }
	    //---------------------------------------------------------------------------------
	    //Funciones detalles hoja de vida

	    public function getFormatosDatosGen($id_hoja){

	    	$hojaDeVida = $this->getFormatosId($id_hoja);

    		//print_r($hojaDeVida);

    		echo "<h3>Datos Generales</h3>";

    		echo '<ul class="list-group">
    			      <li class="list-group-item"><strong>Número de Identificación</strong>: '.$hojaDeVida[0]["nidentificacion"].'</li>
                      <li class="list-group-item"><strong>Nombre</strong>: '.$hojaDeVida[0]["nombre"].' </li>
                      <li class="list-group-item"><strong>Apellido</strong>: '.$hojaDeVida[0]["apellido"].'</li>                      
                      <li class="list-group-item"><strong>Teléfono</strong>: '.$hojaDeVida[0]["telefono"].'</li>
                      <li class="list-group-item"><strong>Email</strong>: '.$hojaDeVida[0]["email"].'</li>
                      <li class="list-group-item"><strong>Estado</strong>: '.$hojaDeVida[0]["nom_estado"].'</li>
                    </ul>
            ';
	    }

	    public function getEstudiosFormatosId($id_hoja){

	    	$estudiosFormatos = $this->getEstudioId($id_hoja);

	    	//print_r($estudiosFormatos);

	    	echo "<h3>Estudios</h3>";

	    	if($estudiosFormatos > 0){

	    		for ($i=0; $i < sizeof($estudiosFormatos); $i++) {

		    		echo '<ul class="list-group">    			      
		                      <li class="list-group-item"><strong>Nombre</strong>: '.$estudiosFormatos[$i]["nombre"].' </li>
		                      <li class="list-group-item"><strong>Tipo</strong>: '.$estudiosFormatos[$i]["nom_tipoEstudio"].'</li>                      
		                    </ul>
		            ';
		    	}

	    	}else{
	    		echo "<div class='alert alert-warning' role='alert'>
	    				Esta persona no tiene estudios relacionados.		           		
				   	  </div>";
	    	}	    	
	    	
	    }

	    public function getArchivosFormatosId($id_hoja){

	    	$archivosFormatos = $this->getArchivosId($id_hoja);

	    	//print_r($archivosFormatos);

	    	echo "<h3>Archivos</h3>";

	    	if($archivosFormatos > 0){

	    		echo '<div class="list-group">';

		    	for ($i=0; $i < sizeof($archivosFormatos); $i++) {

		    		echo '<a href="subidas/'.$archivosFormatos[$i]["url_archivo"].'" target="_blank" class="list-group-item"><span class="glyphicon glyphicon-file"></span> '.$archivosFormatos[$i]["url_archivo"].'</a>';
		    	}

		    	echo '</div>';

	    	}else{

	    		echo "<div class='alert alert-warning' role='alert'>	    					           	
	    				Esta hoja de vida no tiene archivos.
				   	  </div>";

	    	}	    	
	    	
	    }


	    public function getSelectCategoriaFiltro(){

			$categoriaSelect = $this->getCategoria();

			echo '<select name="categoria_filtro" id="categoria_filtro" class="form-control select-filtro">
                        <option value="">Todo</option>';
                        for ($i=0; $i < sizeof($categoriaSelect); $i++) {
                                echo '<option value="'.$categoriaSelect[$i]["pkID"].'" >'.$categoriaSelect[$i]["nombre_cat"].'</option>';
                            };
            echo '</select>';
		}


		public function getTablaformatosFiltro($filtro){

			//------------------------------------------------------------------------------------------------
			//print_r("filtro........."+$filtro);
			if ($filtro == '*' || $filtro == '') {
				# code...
				//print_r("MMMMMMMMMMMMMMMM...*");
				$this->getTablaformatos();

			} else {
				//print_r("MMMMMMMMMMMMMMMM...2");
				# code...
				$cambio = array("AND", "formato.");			

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
					if ($arr_campos1[0] == "fkID_categoria") {
						$categoriaId = $this->getCategoriaId($arr_campos1[1]);
						echo "<span class='badge'>Categoría: ".$categoriaId[0]["nombre_cat"]."</span>";
					}

					

				}
				/*echo "<br><br>";
				print_r($filtro);	*/
				echo "<br> <br>";

				$this->Formatos = $this->getFormatoFiltro($filtro);
				//print_r($this->gasto);
				

			}	    	
	    	if($filtro != '' && $filtro != '*'){
	    		//print_r("Es aquí......MM......");
	    		$formatosNoSub = $this->getFormatoNoSubFiltro($filtro);
	    	}
	    	//print_r($formatosNoSub);
	    	//mete los formatos sin subcategoria
	    	//array_merge($this->Formatos, $formatosNoSub);

	    	//print_r($this->Formatos);	    	

	    	//valida si hay formatos

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos(2,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//--------------------------------------------------------------------------------- 

	    	if( ($this->Formatos) && ($consulta==1) ){

	    		for($a=0;$a<sizeof($this->Formatos);$a++){

                 $id = $this->Formatos[$a]["pkID"];
                 $nombre = $this->Formatos[$a]["nombre"];
                 $descripcion = $this->Formatos[$a]["descripcion"];
                 $url_archivo = $this->Formatos[$a]["url_archivo"];
                 $nom_categoria = $this->Formatos[$a]["nom_categoria"];
                 $nom_subcategoria = $this->Formatos[$a]["nom_subcategoria"];    

                 echo '
                             <tr>                             	 
                                 <td>'.$nom_categoria.'</td>
                                 <td>'.$nom_subcategoria.'</td>                                                    
                                 <td>'.$nombre.'</td>
                                 <td>'.$descripcion.'</td>
                                                                                        
		                         <td>	
		                         	<a class="btn btn-success" title="Descargar Archivo" href="subidas/'.$url_archivo.'" target="_blank"><span class="glyphicon glyphicon-file"></span></a>
		                         	<a class="btn btn-info" title="Visualizar Archivo con Google Docs" href="https://docs.google.com/viewer?url='.$this->ruta_visor.''.$url_archivo.'" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a>	                             		                            
		                             <button id="btn_editar" title="Editar" name="edita_formato" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_formato" data-id-formato = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_formato" type="button" class="btn btn-danger" data-id-formato = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };

                for($a=0;$a<sizeof($formatosNoSub);$a++){

                 $id = $formatosNoSub[$a]["pkID"];
                 $nombre = $formatosNoSub[$a]["nombre"];
                 $descripcion = $formatosNoSub[$a]["descripcion"];
                 $url_archivo = $formatosNoSub[$a]["url_archivo"];
                 $nom_categoria = $formatosNoSub[$a]["nom_categoria"];
                 //$nom_subcategoria = $formatosNoSub[$a]["nom_subcategoria"];    

                 echo '
                             <tr>                             	 
                                 <td>'.$nom_categoria.'</td>
                                 <td> -- </td>                                                    
                                 <td>'.$nombre.'</td>
                                 <td>'.$descripcion.'</td>
                                                                                        
		                         <td>	
		                         	<a class="btn btn-success" title="Descargar Archivo" href="subidas/'.$url_archivo.'" target="_blank"><span class="glyphicon glyphicon-file"></span></a>	                             		                            
		                         	<a class="btn btn-info" title="Visualizar Archivo con Google Docs" href="https://docs.google.com/viewer?url='.$this->ruta_visor.''.$url_archivo.'" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a>
		                             <button id="btn_editar" title="Editar" name="edita_formato" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_formato" data-id-formato = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_formato" type="button" class="btn btn-danger" data-id-formato = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };


	    	}elseif(($formatosNoSub) && ($consulta==1)){

	    		for($a=0;$a<sizeof($formatosNoSub);$a++){

                 $id = $formatosNoSub[$a]["pkID"];
                 $nombre = $formatosNoSub[$a]["nombre"];
                 $descripcion = $formatosNoSub[$a]["descripcion"];
                 $url_archivo = $formatosNoSub[$a]["url_archivo"];
                 $nom_categoria = $formatosNoSub[$a]["nom_categoria"];
                 //$nom_subcategoria = $formatosNoSub[$a]["nom_subcategoria"];    

                 echo '
                             <tr>                             	 
                                 <td>'.$nom_categoria.'</td>
                                 <td> -- </td>                                                    
                                 <td>'.$nombre.'</td>
                                 <td>'.$descripcion.'</td>
                                                                                        
		                         <td>	
		                         	<a class="btn btn-success" title="Descargar Archivo" href="subidas/'.$url_archivo.'" target="_blank"><span class="glyphicon glyphicon-file"></span></a>	                             		                            
		                         	<a class="btn btn-info" title="Visualizar Archivo con Google Docs" href="https://docs.google.com/viewer?url='.$this->ruta_visor.''.$url_archivo.'" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a>
		                             <button id="btn_editar" title="Editar" name="edita_formato" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_formato" data-id-formato = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_formato" type="button" class="btn btn-danger" data-id-formato = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };

	    	}elseif(($this->Formatos) && ($consulta==0)){

             echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>		               		               		                                          
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Formatos.</strong>  						
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
		           		En este momento no hay Formatos creados.
				   </div>";
            };

	    }


	}

 ?>