<?php
	/**/
	include_once '../DAO/repositorioDAO.php';
		
	class repositorioController extends repositorioDAO{
		
		public $NameCookieApp;
		public $id_modulo;
		public $repositorio;
		public $archivos_repositorio;
		
		
		public function __construct() {
			
			include('../conexion/datos.php');
			
			$this->id_modulo = 21; //id de la tabla modulos
			$this->id_modulo_archivos = 22; //id de la tabla modulos
			$this->NameCookieApp = $NomCookiesApp;
			
		}
				
		//Funciones-------------------------------------------
		//Espacio para las funciones de esta clase.

		public function getTablaRepositorio(){	    		   

			$this->repositorio = $this->getRepositorio();			

			//print_r($this->repositorioNoEnt);			

	    	//valida si hay formatos

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos($this->id_modulo, $_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];    		
    		//--------------------------------------------------------------------------------- 

	    	if( ($this->repositorio) && ($consulta==1) ){

	    		for($a=0;$a<sizeof($this->repositorio);$a++){

                 $id = $this->repositorio[$a]["pkID"];
                 $nombre = $this->repositorio[$a]["nombre"];  
                 $nom_tipo = $this->repositorio[$a]["nom_tipo"];               
                 $descripcion = $this->repositorio[$a]["descripcion"];                      
                 $tipo_acceso = $this->repositorio[$a]["tipo_acceso"];
                 $empresa = $this->repositorio[$a]["empresa"];
                 	if(((($tipo_acceso == 0)||($tipo_acceso == 1)) && ($_COOKIE["log_lunelAdmin_IDtipo"] == 1))){
                 		echo '
                             <tr>                             	 
                                 <td title="Click Ver Detalles" href="detail_repositorio.php?id_repositorio='.$id.'" class="detail">'.$nombre.'</td>                                 
                                 <td title="Click Ver Detalles" href="detail_repositorio.php?id_repositorio='.$id.'" class="detail">';

                                 		$len_objeto = strlen($descripcion);

		                                 if ($len_objeto >= 60) {
		                                 	# code...
		                                 	echo substr($descripcion, 0, 60).'...';
		                                 }else {
		                                 	# code...
		                                 	echo $descripcion;
		                                 }

		                         echo '</td>

                                 <td title="Click Ver Detalles" href="detail_repositorio.php?id_repositorio='.$id.'" class="detail">'.$nom_tipo.'</td>  
                                 <td title="Click Ver Detalles" href="detail_repositorio.php?id_repositorio='.$id.'" class="detail">'.$empresa.'</td>                                
		                         <td>		                         	 
		                             <button id="btn_editar" title="Editar" name="edita_repositorio" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_repositorio" data-id-repositorio = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_repositorio" type="button" class="btn btn-danger" data-id-repositorio = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>		                             
		                         </td> 
		                     </tr>';
		            }elseif ((($tipo_acceso == 0) && ($_COOKIE["log_lunelAdmin_IDtipo"] != 1))) {
		            	echo '
                             <tr>                             	 
                                 <td title="Click Ver Detalles" href="detail_repositorio.php?id_repositorio='.$id.'" class="detail">'.$nombre.'</td>                                 
                                 <td title="Click Ver Detalles" href="detail_repositorio.php?id_repositorio='.$id.'" class="detail">'.$descripcion.'</td>
                                 <td title="Click Ver Detalles" href="detail_repositorio.php?id_repositorio='.$id.'" class="detail">'.$nom_tipo.'</td>

                                 <td title="Click Ver Detalles" href="detail_repositorio.php?id_repositorio='.$id.'" class="detail">'.$empresa.'</td>                                   
		                         <td>		                         	 
		                             <button id="btn_editar" title="Editar" name="edita_repositorio" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_repositorio" data-id-repositorio = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_repositorio" type="button" class="btn btn-danger" data-id-repositorio = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>		                             
		                         </td> 
		                     </tr>';
		            }         
                };
                             	   
	    	}elseif( ($this->repositorio)  && ($consulta==0)){

             echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>		               
		               <td></td>		               		               		               		               		                                        
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		<span class='glyphicon glyphicon-exclamation-sign'></span> En este momento no tiene permiso de <strong>Consulta</strong> para <strong>repositorio.</strong>  						
				   </div>";
            }else{

             echo "<tr>		               		               
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>		               		               		               		                                        
		           </tr>
		           
		           <div class='alert alert-danger' role='alert'>
		           		<span class='glyphicon glyphicon-alert'></span> En este momento no hay repositorios creados.
				   </div>";
            };

	    }

		public function getTablaArchivosRepositorio($pkID_repositorio){	    		   

			$this->archivos_repositorio = $this->getArchivosRepositorio($pkID_repositorio);			

			//print_r($this->repositorioNoEnt);			

	    	//valida si hay formatos

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos($this->id_modulo_archivos, $_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];    		
    		//--------------------------------------------------------------------------------- 

	    	if( ($this->archivos_repositorio) && ($consulta==1) ){

	    		for($a=0;$a<sizeof($this->archivos_repositorio);$a++){

                 $id = $this->archivos_repositorio[$a]["pkID"];
                 $nombre = $this->archivos_repositorio[$a]["nombre"];
                 $nom_tipo = $this->archivos_repositorio[$a]["nom_tipo"];
                 $descripcion = $this->archivos_repositorio[$a]["descripcion"];                 
                 $url = $this->archivos_repositorio[$a]["url_archivo"];             

                 echo '
                             <tr>                             	 
                                 <td>'.$nombre.'</td>
                                 <td>'.$nom_tipo.'</td>
                                 <td>';

                                 		$len_objeto = strlen($descripcion);

		                                 if ($len_objeto >= 60) {
		                                 	# code...
		                                 	echo substr($descripcion, 0, 60).'...';
		                                 }else {
		                                 	# code...
		                                 	echo $descripcion;
		                                 }

		                  echo '</td>                                 
		                         <td>
		                         	 <a class="btn btn-success" title="Descargar Archivo" '; if( is_null($url) || $url == '' ){ echo 'href="#" disabled="true"'; }else{ echo 'href="subidas/'.$url.'" target="_blank"'; } echo '><span class="glyphicon glyphicon-download-alt"></span></a>		                         	
		                             <button id="btn_editar" title="Editar" name="edita_detail_repositorio" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_detail_repositorio" data-id-detail_repositorio = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_detail_repositorio" type="button" class="btn btn-danger" data-id-detail_repositorio = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>		                             
		                         </td> 
		                     </tr>';
                };
                             	   
	    	}elseif( ($this->archivos_repositorio)  && ($consulta==0)){

             echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>		               		               		               		               		               		                                       
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		<span class='glyphicon glyphicon-exclamation-sign'></span> En este momento no tiene permiso de <strong>Consulta</strong> para <strong>archivos repositorio.</strong>  						
				   </div>";
            }else{

             echo "<tr>		               
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>		                              		               		               		                                       
		           </tr>
		           
		           <div class='alert alert-danger' role='alert'>
		           		<span class='glyphicon glyphicon-alert'></span> En este momento no hay archivos para este repositorio.
				   </div>";
            };

	    }
	    //---------------------------------------------------------------------------------

	    public function getSelectTipoRepositorio(){

			$repoSelect = $this->getTipoRepositorio();

			echo '<select name="fkID_tipo" id="fkID_tipo" class="form-control" required = "true">
                        <option value=""></option>';
                        for ($i=0; $i < sizeof($repoSelect); $i++) {
                                echo '<option value="'.$repoSelect[$i]["pkID"].'" >'.$repoSelect[$i]["nombre"].'</option>';
                            };
            echo '</select>';
		}


		public function getSelectTipoRepositorioGeneral(){

			$repoSelect = $this->getTipoRepositorioGeneral();

			echo '<select name="fkID_tipo_repositorio_general" id="fkID_tipo_repositorio_general" class="form-control" required = "true">
                        <option value=""></option>';
                        for ($i=0; $i < sizeof($repoSelect); $i++) {
                                echo '<option value="'.$repoSelect[$i]["pkID"].'" >'.$repoSelect[$i]["nombre"].'</option>';
                            };
            echo '</select>';
		}


		public function getSelectEmpresa(){

			$repoSelect = $this->getEmpresa();

			echo '<select name="fkID_empresa" id="fkID_empresa" class="form-control" required = "true">
                        <option value=""></option>';
                        for ($i=0; $i < sizeof($repoSelect); $i++) {
                                echo '<option value="'.$repoSelect[$i]["pkID"].'" >'.$repoSelect[$i]["nombre"].'</option>';
                            };
            echo '</select>';
		}

		//---------------------------------------------------------------------------------

		public function getTablaRepositorioFuntecso(){	    		   

			$this->repositorio = $this->getRepositorioFuntecso();			

			//print_r($this->repositorioNoEnt);			

	    	//valida si hay formatos

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos($this->id_modulo, $_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];    		
    		//--------------------------------------------------------------------------------- 

	    	if( ($this->repositorio) && ($consulta==1) ){

	    		for($a=0;$a<sizeof($this->repositorio);$a++){

                 $id = $this->repositorio[$a]["pkID"];
                 $nombre = $this->repositorio[$a]["nombre"];  
                 $nom_tipo = $this->repositorio[$a]["nom_tipo"];               
                 $descripcion = $this->repositorio[$a]["descripcion"];                      
                 $tipo_acceso = $this->repositorio[$a]["tipo_acceso"];
                 $empresa = $this->repositorio[$a]["empresa"];
                 	if(((($tipo_acceso == 0)||($tipo_acceso == 1)) && ($_COOKIE["log_lunelAdmin_IDtipo"] == 1))){
                 		echo '
                             <tr>                             	 
                                 <td title="Click Ver Detalles" href="detail_repositorio.php?id_repositorio='.$id.'" class="detail">'.$nombre.'</td>                                 
                                 <td title="Click Ver Detalles" href="detail_repositorio.php?id_repositorio='.$id.'" class="detail">';

                                 		$len_objeto = strlen($descripcion);

		                                 if ($len_objeto >= 60) {
		                                 	# code...
		                                 	echo substr($descripcion, 0, 60).'...';
		                                 }else {
		                                 	# code...
		                                 	echo $descripcion;
		                                 }

		                         echo '</td>

                                 <td title="Click Ver Detalles" href="detail_repositorio.php?id_repositorio='.$id.'" class="detail">'.$nom_tipo.'</td> 
                                 <td title="Click Ver Detalles" href="detail_repositorio.php?id_repositorio='.$id.'" class="detail">'.$empresa.'</td>                                     
		                         <td>		                         	 
		                             <button id="btn_editar" title="Editar" name="edita_repositorio" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_repositorio" data-id-repositorio = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_repositorio" type="button" class="btn btn-danger" data-id-repositorio = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>		                             
		                         </td> 
		                     </tr>';
		            }elseif ((($tipo_acceso == 0) && ($_COOKIE["log_lunelAdmin_IDtipo"] != 1))) {
		            	echo '
                             <tr>                             	 
                                 <td title="Click Ver Detalles" href="detail_repositorio.php?id_repositorio='.$id.'" class="detail">'.$nombre.'</td>                                 
                                 <td title="Click Ver Detalles" href="detail_repositorio.php?id_repositorio='.$id.'" class="detail">'.$descripcion.'</td>
                                 <td title="Click Ver Detalles" href="detail_repositorio.php?id_repositorio='.$id.'" class="detail">'.$nom_tipo.'</td>

                                 <td title="Click Ver Detalles" href="detail_repositorio.php?id_repositorio='.$id.'" class="detail">'.$empresa.'</td>                                   
		                         <td>		                         	 
		                             <button id="btn_editar" title="Editar" name="edita_repositorio" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_repositorio" data-id-repositorio = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_repositorio" type="button" class="btn btn-danger" data-id-repositorio = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>		                             
		                         </td> 
		                     </tr>';
		            }         
                };
                             	   
	    	}elseif( ($this->repositorio)  && ($consulta==0)){

             echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>		               
		               <td></td>		               		               		               		               		                                        
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		<span class='glyphicon glyphicon-exclamation-sign'></span> En este momento no tiene permiso de <strong>Consulta</strong> para <strong>repositorio.</strong>  						
				   </div>";
            }else{

             echo "<tr>		               		               
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>		               		               		               		                                        
		           </tr>
		           
		           <div class='alert alert-danger' role='alert'>
		           		<span class='glyphicon glyphicon-alert'></span> En este momento no hay repositorios creados.
				   </div>";
            };

	    }
		
	}
?>
