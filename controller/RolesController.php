<?php
	/**/
	include_once '../DAO/RolesDAO.php';
		
	class RolesController extends RolesDAO{
		
		public $roles;
		
		
		//Funciones-------------------------------------------
		//Espacio para las funciones en general de esta clase.

		public function getTablaRoles(){

	    	/* En caso de traer solo registros de x usuario
	    	if($tipo_usuario == "Administrador"){
	    		//get de los roles  
	    		$this->roles = $this->getroles();
	    	}else{
	    		$this->roles = $this->getrolesUser($id_usuario);
	    	}*/

	    	$this->roles = $this->getRoles();

	    	
	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos(14,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//--------------------------------------------------------------------------------- 

	    	if( ($this->roles) && ($consulta==1) ){

	    		for($a=0;$a<sizeof($this->roles);$a++){

                 $id = $this->roles[$a]["pkID"];
                 $nom_tipo = $this->roles[$a]["nom_tUsuario"];
                 $nom_modulo = $this->roles[$a]["nom_modulo"];
                 $crear = $this->roles[$a]["crear"];
                 $editar = $this->roles[$a]["editar"];
                 $eliminar = $this->roles[$a]["eliminar"];
                 $consultar = $this->roles[$a]["consultar"];     

                 echo '
                             <tr>
                             	 
                                 <td>'.$nom_tipo.'</td>
                                 <td>'.$nom_modulo.'</td>                                                    
                                 <td>'.$crear.'</td>
                                 <td>'.$editar.'</td>
                                 <td>'.$eliminar.'</td>
                                 <td>'.$consultar.'</td>                                                                                       
		                         <td>		                         		                             		                           
		                             <button id="btn_editar" title="Editar" name="edita_rol" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_rol" data-id-rol = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_rol" type="button" class="btn btn-danger" data-id-rol = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };               


	    	}elseif(($this->roles) && ($consulta==0)){

             echo "<tr>
		               
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>		               		               		                                          
		           </tr>
		           <h3>En este momento no tiene permiso de consulta para Roles.</h3>";
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
		           <h3>En este momento no hay Roles creados.</h3>";
            };

	    }

	    public function getSelectTipoUsuario(){

			$TipoUsuarioSelect = $this->getTipoUsuario();

			echo '<select name="fkID_tipo_usuario" id="fkID_tipo_usuario" class="form-control add-selectElement" required = "true">
                        <option></option>';
                        for ($i=0; $i < sizeof($TipoUsuarioSelect); $i++) {
                                echo '<option value="'.$TipoUsuarioSelect[$i]["pkID"].'" >'.$TipoUsuarioSelect[$i]["nombre"].'</option>';
                            };
            echo '</select>';
		}

		public function getSelectModulos(){

			$ModulosSelect = $this->getModulos();

			echo '<select name="fkID_modulo" id="fkID_modulo" class="form-control add-selectElement" required = "true">
                        <option></option>';
                        for ($i=0; $i < sizeof($ModulosSelect); $i++) {
                                echo '<option value="'.$ModulosSelect[$i]["pkID"].'" >'.$ModulosSelect[$i]["Nombre"].'</option>';
                            };
            echo '</select>';
		}
	}
?>
