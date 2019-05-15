<?php
	/**/
	include_once '../DAO/actividadesDAO.php';
		
	class actividadesController extends actividadesDAO{
		
		public $actividad;
		public $id_modulo;
		
		
		public function __construct() {
			
			//include('../conexion/datos.php');
			
			$this->id_modulo = 19;
			//$this->NameCookieApp = $NomCookiesApp;
			
		}

		public function selectActividadesFiltro($pkID_proyecto){

			$actividadSelect = $this->getActividadesProyecto($pkID_proyecto);
      	
      		echo '<select name="actividad_filtro" id="actividad_filtro" class="form-control add-selectElement">;
      				<option></option>
      				<option value="No Aplica">No Aplica</option>';

            for ($i=0; $i < sizeof($actividadSelect); $i++) {            	            			
                	echo '<option value="'.$actividadSelect[$i]["pkID"].'">'.$actividadSelect[$i]["nombre"].'</option>'; 
                	  
            };

            echo '</select>';
		}

		public function getTablaActividades(){	    	

	    	$this->actividad = $this->getActividades();	    	

	    	//valida si hay actividad

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos($this->id_modulo,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//---------------------------------------------------------------------------------

	    	if( ($this->actividad) && ($consulta==1) ){

	    		for($a=0;$a<sizeof($this->actividad);$a++){

                 $id = $this->actividad[$a]["pkID"];
                 $nombre = $this->actividad[$a]["nombre"];
                 $subtotal = $this->actividad[$a]["subtotal"];
                 $iva = $this->actividad[$a]["iva"];
                 $total = $this->actividad[$a]["total"];                 
                 $nom_proyecto = $this->actividad[$a]["nom_proyecto"];

                 //<td title="Click Ver Detalles" href="detail_actividad.php?id_actividad='.$id.'" class="detail">'.$id.'</td>

                 echo '
                             <tr>                             	 
                                 <td>'.$nombre.'</td>
                                 <td>'.'$'.number_format($subtotal, 0, '', '.').'</td>
                                 <td>'.'$'.number_format($iva, 0, '', '.').'</td>
                                 <td>'.'$'.number_format($total, 0, '', '.').'</td>
                                 <td>'.$nom_proyecto.'</td>                                 
		                         <td>		                         		                             		                           
		                             <button id="btn_editar" title="Editar" name="edita_actividad" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_actividad" data-id-actividad = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_actividad" type="button" class="btn btn-danger" data-id-actividad = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };


	    	}elseif(($this->actividad) && ($consulta==0)){

             echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>		               
		           </tr>
		           <div class='alert alert-danger' role='alert'>  						 
  						 En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Actividades.</strong>
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
  						 En este momento no hay <strong>Actividades</strong> creados.
				   </div>";
            };

	    }

	    public function getTablaActividadesProyecto($pkID_proyecto){	    	

	    	$this->actividad = $this->getActividadesProyecto($pkID_proyecto);

	    	//valida si hay actividad

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisos($this->id_modulo,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//---------------------------------------------------------------------------------

	    	if( ($this->actividad) && ($consulta==1) ){

	    		for($a=0;$a<sizeof($this->actividad);$a++){

                 $id = $this->actividad[$a]["pkID"];
                 $nombre = $this->actividad[$a]["nombre"];
                 $subtotal = $this->actividad[$a]["subtotal"];
                 $iva = $this->actividad[$a]["iva"];
                 $total = $this->actividad[$a]["total"];                 
                 $nom_proyecto = $this->actividad[$a]["nom_proyecto"];

                 //<td title="Click Ver Detalles" href="detail_actividad.php?id_actividad='.$id.'" class="detail">'.$id.'</td>

                 echo '
                             <tr> 
                             	 <td>'.$id.'</td>                            	 
                                 <td>'.$nombre.'</td>
                                 <td>'.'$'.number_format($subtotal, 0, '', '.').'</td>
                                 <td>'.'$'.number_format($iva, 0, '', '.').'</td>
                                 <td>'.'$'.number_format($total, 0, '', '.').'</td>
                                 <td>'.$nom_proyecto.'</td>                                 
		                         <td>		                         		                             		                           
		                             <button id="btn_editar" title="Editar" name="edita_actividad" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_actividad" data-id-actividad = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_actividad" type="button" class="btn btn-danger" data-id-actividad = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td> 
		                     </tr>';
                };


	    	}elseif(($this->actividad) && ($consulta==0)){

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
  						 En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Actividades.</strong>
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
  						 En este momento no hay <strong>Actividades</strong> creados.
				   </div>";
            };

	    }
		
		
		//Funciones-------------------------------------------
		//Espacio para las funciones de esta clase.
		
	}
?>
