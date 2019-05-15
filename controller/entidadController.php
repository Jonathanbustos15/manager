<?php 

	include('../DAO/EntidadDAO.php'); 

	class entidadController extends entidad {

		//-------------------------------------
		//variables
		public $entidad;
		//-------------------------------------

		//---------------------------------------------------------------------------------

		public function getTablaEntidades(){

	    	/* En caso de traer solo registros de x usuario
	    	if($tipo_usuario == "Administrador"){
	    		//get de los entidad  
	    		$this->entidad = $this->getentidad();
	    	}else{
	    		$this->entidad = $this->getentidadUser($id_usuario);
	    	}*/

	    	$this->entidad = $this->getEntidades();	    	

	    	//valida si hay entidad
	    	if($this->entidad){

	    		for($a=0;$a<sizeof($this->entidad);$a++){

                 $id = $this->entidad[$a]["pkID"];
                 $nombre = $this->entidad[$a]["nombre_entidad"];
                 //$descripcion = $this->entidad[$a]["fkID_padre"];
                   

                 echo '
                             <tr>
                             	 <td>'.$id.'</td>
                                 <td>'.$nombre.'</td>                                            
		                         <td>		                         		                             		                           
		                             <button id="btn_editar" title="Editar" name="edita_entidad" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_entidad" data-id-entidad = "'.$id.'" ><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_entidad" type="button" class="btn btn-danger" data-id-entidad = "'.$id.'" ><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };


	    	}else{

             echo "<tr>
		               
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>		               		                                           
		           </tr>
		           <h3>En este momento no hay entidads creadas.</h3>";
            };

	    }
	    
	}

 ?>