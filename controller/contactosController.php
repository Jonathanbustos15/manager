<?php
	/**/
	include_once '../DAO/contactosDAO.php';
		
	class contactosController extends contactosDAO{
		
		public $NameCookieApp;
		public $id_modulo;
		public $contacto;
		public $contactoNoEnt;
		
		
		public function __construct() {
			
			include('../conexion/datos.php');
			
			//$this->id_modulo = --; id de la tabla modulos
			$this->NameCookieApp = $NomCookiesApp;
			$this->id_modulo = 17;
		}
				
		//Funciones-------------------------------------------
		//Espacio para las funciones de esta clase.
		public function getTablacontactos(){	    		   

			$this->contacto = $this->getContactos();

			$this->contactoNoEnt = $this->getContactosNoEnt();

			//print_r($this->contactoNoEnt);			

	    	//valida si hay formatos

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos($this->id_modulo, $_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];    		
    		//--------------------------------------------------------------------------------- 

	    	if( ($this->contacto) && ($consulta==1) ){

	    		for($a=0;$a<sizeof($this->contacto);$a++){

                 $id = $this->contacto[$a]["pkID"];

                 $nombre = $this->contacto[$a]["nombre"];
                 $apellido = $this->contacto[$a]["apellido"];

                 $num_tel = $this->contacto[$a]["num_tel"];
                 $direccion = $this->contacto[$a]["direccion"];
                 $email = $this->contacto[$a]["email"];
                 $descripcion = $this->contacto[$a]["descripcion"];
                 $tipo_acceso = $this->contacto[$a]["tipo_acceso"];
                 //---------------------------------------------------------
                 $nom_tipo = $this->contacto[$a]["nom_tipo"];
                 $nombre_entidad = $this->contacto[$a]["nombre_entidad"];                 
                 //$fecha_pago = $this->contacto[$a]["fecha_pago"];
                 $url = $this->contacto[$a]["url"];             
                 	
	         		echo '
	                     <tr>
	                     	 
	                         <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$nombre.'</td>
	                         <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$apellido.'</td>                                                    
	                         <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$num_tel.'</td>
	                         <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$email.'</td>
	                         <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$descripcion.'</td>
	                         <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$nom_tipo.'</td>
	                         <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$nombre_entidad.'</td>
	                         <td>	                         	 
	                             <button id="btn_editar" title="Editar" name="edita_contacto" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_contactos" data-id-contactos = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
	                             <button id="btn_eliminar" title="Eliminar" name="elimina_contacto" type="button" class="btn btn-danger" data-id-contactos = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>		                             
	                         </td> 
	                     </tr>';

		                          
                };

            if ($this->contactoNoEnt) {
                	# code...
                	for($a=0;$a<sizeof($this->contactoNoEnt);$a++){

	                 $id = $this->contactoNoEnt[$a]["pkID"];

	                 $nombre = $this->contactoNoEnt[$a]["nombre"];
	                 $apellido = $this->contactoNoEnt[$a]["apellido"];

	                 $num_tel = $this->contactoNoEnt[$a]["num_tel"];
	                 $direccion = $this->contactoNoEnt[$a]["direccion"];
	                 $email = $this->contactoNoEnt[$a]["email"];
	                 $descripcion = $this->contactoNoEnt[$a]["descripcion"];
	                 $tipo_acceso = $this->contacto[$a]["tipo_acceso"];
	                 //---------------------------------------------------------
	                 $nom_tipo = $this->contactoNoEnt[$a]["nom_tipo"];                 
	                 //$fecha_pago = $this->contacto[$a]["fecha_pago"];
	                 $url = $this->contactoNoEnt[$a]["url"];                   

	                 echo '
	                             <tr>
	                                 
	                                 <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$nombre.'</td>
	                                 <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$apellido.'</td>                                                    
	                                 <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$num_tel.'</td>
	                                 <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$email.'</td>
	                                 <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$descripcion.'</td>
	                                 <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$nom_tipo.'</td>
	                                 <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">No Aplica</td>
			                         <td>			                         	 
			                             <button id="btn_editar" title="Editar" name="edita_contacto" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_contactos" data-id-contactos = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
			                             <button id="btn_eliminar" title="Eliminar" name="elimina_contacto" type="button" class="btn btn-danger" data-id-contactos = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>		                             
			                         </td> 
			                     </tr>';
	                }; 
                };                               


	    	}elseif(($this->contactoNoEnt) && ($consulta==1)){

	    		if ($this->contactoNoEnt) {
                	# code...
                	for($a=0;$a<sizeof($this->contactoNoEnt);$a++){

	                 $id = $this->contactoNoEnt[$a]["pkID"];

	                 $nombre = $this->contactoNoEnt[$a]["nombre"];
	                 $apellido = $this->contactoNoEnt[$a]["apellido"];

	                 $num_tel = $this->contactoNoEnt[$a]["num_tel"];
	                 $direccion = $this->contactoNoEnt[$a]["direccion"];
	                 $email = $this->contactoNoEnt[$a]["email"];
	                 $descripcion = $this->contactoNoEnt[$a]["descripcion"];
	                 $tipo_acceso = $this->contacto[$a]["tipo_acceso"];
	                 //---------------------------------------------------------
	                 $nom_tipo = $this->contactoNoEnt[$a]["nom_tipo"];                 
	                 //$fecha_pago = $this->contacto[$a]["fecha_pago"];
	                 $url = $this->contactoNoEnt[$a]["url"];                   

	                 echo '
	                             <tr>
	                             	 
	                                 <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$nombre.'</td>
	                                 <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$apellido.'</td>                                                    
	                                 <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$num_tel.'</td>
	                                 <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$email.'</td>
	                                 <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$descripcion.'</td>
	                                 <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">'.$nom_tipo.'</td>
	                                 <td title="Click Ver Detalles" href="contactoDetalles.php?id_contacto='.$id.'" class="detail">No Aplica</td>
			                         <td>			                         	 
			                             <button id="btn_editar" title="Editar" name="edita_contacto" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_contactos" data-id-contactos = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
			                             <button id="btn_eliminar" title="Eliminar" name="elimina_contacto" type="button" class="btn btn-danger" data-id-contactos = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>		                             
			                         </td> 
			                     </tr>';
	                }; 
                };

	    	}elseif( (($this->contacto) || ($this->contactoNoEnt))  && ($consulta==0)){

             echo "<tr>
		               
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
		           		<span class='glyphicon glyphicon-exclamation-sign'></span> En este momento no tiene permiso de <strong>Consulta</strong> para <strong>contactos.</strong>  						
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
		           </tr>
		           
		           <div class='alert alert-danger' role='alert'>
		           		<span class='glyphicon glyphicon-alert'></span> En este momento no hay contactos creados.
				   </div>";
            };

	    }
	    //---------------------------------------------------------------------------------

	    public function selectEntidad(){

			$entidadSelect = $this->getSelectEntidad();

			echo '<select name="fkID_entidad" id="fkID_entidad" class="form-control add-selectElement">
                        <option></option>';

			            for ($i=0; $i < sizeof($entidadSelect); $i++) {
			                echo '<option value="'.$entidadSelect[$i]["pkID"].'">'.$entidadSelect[$i]["nombre_entidad"].'</option>';
			            };
			echo '</select>';
		}

		public function selectTipoContacto(){

			$tipoSelect = $this->getSelectTipoContacto();

			echo '<select name="fkID_tipo_contacto" id="fkID_tipo_contacto" class="form-control add-selectElement" required = "true">
                        <option></option>';

			            for ($i=0; $i < sizeof($tipoSelect); $i++) {
			                echo '<option value="'.$tipoSelect[$i]["pkID"].'">'.$tipoSelect[$i]["nombre"].'</option>';
			            };
			echo '</select>';
		}

		 public function getContactoNombre($id_contacto){

	    	$contacto = $this->getContactoId($id_contacto);
    		//print_r($hojaDeVida);
    		echo '<div class="panel panel-default titulo-barra-amarilla">
                    <div class="icono_hvs-foto"></div>
                      <div class="panel-body titulo-hvs-det-fot">
                        '.$contacto[0]['nombre'].' '.$contacto[0]['apellido'].'<br>
                      </div>
                    </div>					
    			</div>';
    	}



	    public function getContactoDatosGen($id_contacto){

	    	$contacto = $this->getContactoId($id_contacto);

    		//print_r($hojaDeVida);    		

    		echo "<div class='icono_dgenerales'></div><h3>Datos Generales</h3>";

    		if($contacto > 0){	    		

	    		echo '<ul class="list-group">
	    			     
	                      <li class="list-group-item"><strong>Nombre</strong>: '.$contacto[0]["nombre"].' </li>
	                      <li class="list-group-item"><strong>Apellido</strong>: '.$contacto[0]["apellido"].'</li>                      
	                      <li class="list-group-item"><strong>descripcion</strong>: '.$contacto[0]["descripcion"].'</li>                      
	                      <li class="list-group-item"><strong>Teléfono</strong>: '.$contacto[0]["num_tel"].'</li>
	                      <li class="list-group-item"><strong>Direccion</strong>: '.$contacto[0]["direccion"].'</li>
	                      <li class="list-group-item"><strong>Email</strong>: '.$contacto[0]["email"].'</li>
	                      <li class="list-group-item"><strong>Entidad</strong>: '.$contacto[0]["nombre_entidad"].'</li>
	                    </ul>
	            ';

        	}else{

        		echo "<div class='alert alert-warning' role='alert'>
  						Esta persona no tiene Datos generales.
				   	  </div>";
        	}
	    }

	    public function getcontactoFiles($id_contacto){

	    	$contacto = $this->getFilesContactoData($id_contacto);

	    	//print_r($contacto);

	    	if ($contacto === 0) {
	    		
    	   		echo '<div class="alert alert-warning">
		    			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		    			<strong>No hay archivos!</strong> Puede agregar archivos para este contacto desde la vista de administración.
		    		</div>';
    	   	} else {
    	   		//echo "Hay ".sizeof($contacto)." archivos.";

    	   		foreach ($contacto as $key => $value) {
					echo '<a href="../server/php/files/'.$value["url"].'" title="click para ampliar" target="_blank"><img src="../server/php/files/'.$value["url"].'" width="400" class="img-thumbnail"></a><br><br>';
				}
    	   	}
	    	   	   	

			
	    }




		//---------------------------------------------------------------------------------

	}
?>
