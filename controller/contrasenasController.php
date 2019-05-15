<?php
	/**/
	include_once '../DAO/contrasenasDAO.php';
	include_once 'class_crypt.php'; 
		
	class contrasenasController extends contrasenasDAO{
			
		public $id_modulo;
		public $contrasena;
		public $Crypt_inst;
		
		public function __construct() {			
			$this->id_modulo = 20; //id de la tabla modulos
			$this->Crypt_inst = new crypt();					
		}
		
		
		//Funciones-------------------------------------------
		//Espacio para las funciones de esta clase.
		public function getTablaContrasenas(){	    		   

			$this->contrasena = $this->getContrasenas();			

			//print_r($this->contrasenaNoEnt);			

	    	//valida si hay formatos

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos($this->id_modulo, $_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];    		
    		//--------------------------------------------------------------------------------- 

	    	if( ($this->contrasena) && ($consulta==1) ){

	    		for($a=0;$a<sizeof($this->contrasena);$a++){

                 $id = $this->contrasena[$a]["pkID"];
                 $nombre = $this->Crypt_inst->desencriptar($this->contrasena[$a]["nombre"]);
                 //$contrasena = $this->Crypt_inst->desencriptar($this->contrasena[$a]["contrasena"]);
                                       

                 echo '
                             <tr>
                             	 
                                 <td>'.$nombre.'</td> 
                                                                
		                         <td>		                         	 
		                             <button id="btn_editar" title="Editar" name="edita_contrasena" type="button" class="btn btn-warning" data-id-contrasena = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_contrasena" type="button" class="btn btn-danger" data-id-contrasena = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>		                             
		                         </td> 
		                     </tr>';
                };                

	    	}elseif( ($this->contrasena) && ($consulta==0) ){

             echo "<tr>
		               
		               <td></td>
		               <td></td>		               	               		               		               		                                       
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		<span class='glyphicon glyphicon-exclamation-sign'></span> En este momento no tiene permiso de <strong>Consulta</strong> para <strong>contraseñas.</strong>  						
				   </div>";
            }else{

             echo "<tr>		               
		               
		               <td></td>
		               <td></td>		               		               		               		                                       
		           </tr>
		           
		           <div class='alert alert-danger' role='alert'>
		           		<span class='glyphicon glyphicon-alert'></span> En este momento no hay contraseñas creadas.
				   </div>";
            };/**/

	    }
	    //---------------------------------------------------------------------------------
	}
?>
