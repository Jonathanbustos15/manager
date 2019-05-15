<?php 

	include('../DAO/TipoProcesoDAO.php'); 

	class tipoProcesoController extends tipo_proceso {

		//-------------------------------------
		//variables
		public $tipo_proceso;
		//-------------------------------------

		//---------------------------------------------------------------------------------

		public function getTablaTipoProceso(){

	    	/* En caso de traer solo registros de x usuario
	    	if($tipo_usuario == "Administrador"){
	    		//get de los entidad  
	    		$this->entidad = $this->getentidad();
	    	}else{
	    		$this->entidad = $this->getentidadUser($id_usuario);
	    	}*/

	    	$this->tipo_proceso = $this->getTipoProceso();	    	

	    	//valida si hay tipo_proceso
	    	if($this->tipo_proceso){

	    		for($a=0;$a<sizeof($this->tipo_proceso);$a++){

                 $id = $this->tipo_proceso[$a]["pkID"];
                 $nombre = $this->tipo_proceso[$a]["nombre"];
                 //$descripcion = $this->tipo_proceso[$a]["fkID_padre"];
                   

                 echo '
                             <tr>
                             	 <td>'.$id.'</td>
                                 <td>'.$nombre.'</td>                                            
		                         <td>		                         		                             		                           
		                             <button id="btn_editar" title="Editar" name="edita_tipo_proceso" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_tipo_proceso" data-id-tipo_proceso = "'.$id.'" ><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_tipo_proceso" type="button" class="btn btn-danger" data-id-tipo_proceso = "'.$id.'" ><span class="glyphicon glyphicon-remove"></span></button>
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
		           <h3>En este momento no hay tipos de proceso creados.</h3>";
            };

	    }
	    
	}

 ?>