<?php 

	include('../DAO/CategoriaDAO.php'); 

	class categoriaController extends categoria {

		//-------------------------------------
		//variables
		public $categoria;
		//-------------------------------------

		//---------------------------------------------------------------------------------

		public function getTablaCategorias(){

	    	/* En caso de traer solo registros de x usuario
	    	if($tipo_usuario == "Administrador"){
	    		//get de los categoria  
	    		$this->categoria = $this->getcategoria();
	    	}else{
	    		$this->categoria = $this->getcategoriaUser($id_usuario);
	    	}*/

	    	$this->categoria = $this->getCategorias();	    	

	    	//valida si hay categoria
	    	if($this->categoria){

	    		for($a=0;$a<sizeof($this->categoria);$a++){

                 $id = $this->categoria[$a]["pkID"];
                 $nombre = $this->categoria[$a]["nombre"];
                 $descripcion = $this->categoria[$a]["fkID_padre"];
                   

                 echo '
                             <tr>
                             	 <td>'.$id.'</td>
                                 <td>'.$nombre.'</td>                                            
		                         <td>		                         		                             		                           
		                             <button id="btn_editar" title="Editar" name="edita_categoria" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_categoria" data-id-categoria = "'.$id.'" ><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_categoria" type="button" class="btn btn-danger" data-id-categoria = "'.$id.'" ><span class="glyphicon glyphicon-remove"></span></button>
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
		           <h3>En este momento no hay categorias creadas.</h3>";
            };

	    }

	    public function getTablaSubCategorias(){

	    	/* En caso de traer solo registros de x usuario
	    	if($tipo_usuario == "Administrador"){
	    		//get de los categoria  
	    		$this->categoria = $this->getcategoria();
	    	}else{
	    		$this->categoria = $this->getcategoriaUser($id_usuario);
	    	}*/

	    	$this->categoria = $this->getSubCategorias();	    	

	    	//valida si hay categoria
	    	if($this->categoria){

	    		for($a=0;$a<sizeof($this->categoria);$a++){

                 $id = $this->categoria[$a]["pkID_categoria"];
                 $nombre = $this->categoria[$a]["nom_categoria"];
                 $nom_categoria = $this->categoria[$a]["nombre"];
                   

                 echo '
                             <tr>
                             	 <td>'.$id.'</td>
                             	 <td>'.$nom_categoria.'</td>
                                 <td>'.$nombre.'</td>                                            
		                         <td>		                         		                             		                           
		                             <button id="btn_editar" title="Editar" name="edita_subcategoria" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_subcategoria" data-id-subcategoria = "'.$id.'" ><span class="glyphicon glyphicon-pencil"></span></button>
		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_subcategoria" type="button" class="btn btn-danger" data-id-subcategoria = "'.$id.'" ><span class="glyphicon glyphicon-remove"></span></button>
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
		           <h3>En este momento no hay sub-categorias creadas.</h3>";
            };

	    }
	}

 ?>