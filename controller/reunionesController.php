<?php

/**/
	include_once '../DAO/reunionesDAO.php';
	include_once 'render_table.php';
		
	class reunionesController extends reunionesDAO{
		
	public $NameCookieApp;
	public $id_modulo;
	public $table_inst;
    public $reuniones;
    public $reunionId;
    public $temasReunion;
    public $participantesReunion;
		
		
		public function __construct() {
			
			include('../Conexion/datos.php');
			
			$this->id_modulo = 36; //id de la tabla modulos
			$this->NameCookieApp = $NomCookiesApp;
			
		}
		
		
		//Funciones-------------------------------------------
		//Espacio para las funciones de esta clase.



      public function getDataReunionGen($pkID){

            $this->reunionId = $this->getReunion($pkID);

            $this->temasReunion = $this->getTemasIdReunion($pkID);

            $this->participantesReunion = $this->getParticipantesIdReunion($pkID);

            //print_r($this->participantesReunion);



            //return $this->procesoId;
            
            /**/
            echo '  <div>
                        <h4>Reunion</h4>

                        <strong>Fecha de Relización: </strong> '.$this->reunionId[0]["fecha_realizacion"].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        <strong>Moderador: </strong> '.$this->reunionId[0]["moderador"].' <br> <br>';

                        

            echo    '</div>';


           if ($this->temasReunion) {

                    echo '<div>
                            <h4>Agenda</h4>
                          </div>';

                $cont = 0;

                for ($i=0; $i<sizeof($this->temasReunion); $i++) {

                    $cont = $cont +1;

                    echo ' <div>

                            <strong>Tema '.$cont.'. : </strong> '.$this->temasReunion[$i]["tema"].' <br>';

                    echo    '</div>';

                }   

            }else{
                echo '
                <div class="alert alert-danger">
                    
                    Est reunión no tiene temas.

                </div>';
            } 


            echo '<br><br>';


            echo '<div>
                    <strong>Desarrolo: </strong> '.$this->reunionId[0]["desarrollo"].' <br> <br>';
            echo '</div>';   



            if ($this->participantesReunion) {

                    echo '<div>
                            <h4>Participantes</h4>
                          </div>';

                   echo '<div >
                          <table class="display table-striped table-bordered table-hover" style="width:50%" >
                              <thead>
                                  <tr>
                                      <!--<th>ID</th>-->
                                      <th>Participante</th>
                                      <th>Email</th>
                                                                                                                
                                  </tr>
                              </thead>

                              <tbody>';
                                
                                    $cont = 0;

                                    for ($i=0; $i<sizeof($this->participantesReunion); $i++) {

                                    $cont = $cont +1;

                                
                   echo '                
                                      <tr>
                                        <td >'.$this->participantesReunion[$i]["participante"].'</td>
                                        <td>'.$this->participantesReunion[$i]["email"].'</td>
    
                                      </tr>';
                                   
                                   }
                    echo '   </tbody>
                          </table>';
                   echo '</div>';

                   

            }else{
                echo '
                <div class="alert alert-danger">
                    
                    Esta reunión no tiene participantes.

                </div>';
            }    

        
        }


	    public function getSelectModeradorReunion(){

	    	$m_u_Select = $this->getModerador();

	    	//$m_u_SelectInv = $this->getInvitados();

	    	//$m_u_Select = array_merge($m_u_Select, $m_u_SelectInv);

	    	echo '<select id="fkID_moderador" name="fkID_moderador" class="form-control" data-accion="select" required="true">
                      <option></option>';
                      for ($i=0; $i < sizeof($m_u_Select); $i++) {
                              echo '<option value="'.$m_u_Select[$i]["pkID"].'" data-nombre = "'.$m_u_Select[$i]["nombre"]." ".$m_u_Select[$i]["apellido"].'" >'.$m_u_Select[$i]["nombre"]." ".$m_u_Select[$i]["apellido"].'</option>';
                          };
            echo '</select>';
            
	    }


       public function getSelectParticipantesF(){

        $m_u_Select = $this->getParticipantesF();

        echo '<select id="usuario_filtro" name="usuario_filtro" class="form-control sel-filter" data-accion="select" required="true">
                      <option value="">Todo</option>';
                      for ($i=0; $i < sizeof($m_u_Select); $i++) {
                              echo '<option value="'.$m_u_Select[$i]["fkID_usuario"].'">'.$m_u_Select[$i]["participante"].'</option>';
                          };
            echo '</select>';
            
      }

       public function getSelectTemasF(){

        $m_u_Select = $this->getTemasF();

        echo '<select id="tema_filtro" name="tema_filtro" class="form-control sel-filter" data-accion="select" required="true" >
                      <option value=""></option>';
                      for ($i=0; $i < sizeof($m_u_Select); $i++) {
                              echo '<option value="'.$m_u_Select[$i]["fkID_reunion"].'">'.$m_u_Select[$i]["tema"].'</option>';
                          };
            echo '</select>';
            
      }


      

       public function getSelectEstadoCompromiso(){

        $m_u_Select = $this->getEstadosCompromiso();
        
        echo '<select id="fkID_estado" name="fkID_estado" class="form-control" data-accion="select" required="true">
                      <option></option>';
                      for ($i=0; $i < sizeof($m_u_Select); $i++) {
                              echo '<option value="'.$m_u_Select[$i]["pkID"].'">'.$m_u_Select[$i]["nombre"].'</option>';
                          };
        echo '</select>';
            
      }

	    public function getSelectUsuariosReuniones(){

	    	$m_u_Select = $this->getParticipantes();
        	    
	    	echo '<select id="select_participante" class="form-control" data-accion="select">
                      <option value="">Todo</option>';
                      for ($i=0; $i < sizeof($m_u_Select); $i++) {
                              echo '<option value="'.$m_u_Select[$i]["pkID"].'" data-nombre = "'.$m_u_Select[$i]["nombre"]." ".$m_u_Select[$i]["apellido"].'" >'.$m_u_Select[$i]["nombre"]." ".$m_u_Select[$i]["apellido"].'</option>';
                          };
            echo '</select>';
	    }


        public function validateDate($date){

            $str_date = str_replace("'", "", $date);           

            $d = DateTime::createFromFormat('Y-m-d', $str_date);            

            return $d && $d->format('Y-m-d') === $str_date;
        }


	    public function getTablaReuniones($filtro, $tipo_user , $id_user){


            if ($filtro == '*') {

                if($tipo_user == 1){
                    $this->reuniones = $this->getReuniones();
                  }elseif (($tipo_user == 3) || ($tipo_user == 8)){
                    $this->reuniones = $this->getReunionesUsuario($id_user);
                  }else{
                    $this->reuniones = $this->getReunionesUsuarioParticipante($id_user);
                  }  
                //$this->reuniones = $this->getReuniones();
                 //print_r($this->reuniones);

            } else {
                                
                //-------------------------------------------------
                $cambio = array("AND", "participantes.", "reuniones.");          

                $campos_str = str_replace($cambio, "", $filtro);

                $arr_campos = explode(" ",$campos_str);

                $arr_completo = array();                    
                //-------------------------------------------------
                
                
                echo "<p>Filtrando por:</p>";

                for ($i=0; $i < sizeof($arr_campos) ; $i++) { 
                    
                    $arr_campos1 = explode("=",$arr_campos[$i]);


                    /*if ($arr_campos1[0] == "fkID_usuario") {
                       
                        $participante = $this->getParticipanteId($arr_campos1[1]);

                        echo "<span class='badge'>Participante:".$participante[0]["participante"]."</span>";


                    }


                    }*/

                    if ($arr_campos1[0] == "fkID_reunion") {
    
                        $tema = $this->getTemasIdReunion($arr_campos1[1]);

                      echo "<span class='badge'>Tema:".$tema[0]["tema"]."</span>";
                    }

                    if ($arr_campos1[0] == "fecha_realizacion") {
    
                      $fechas = "";

                      foreach ($arr_campos as $key => $value) {
                       
                        //echo "El valor es fecha? : ".var_dump($this->validateDate($value))."<br>";
                        if ($this->validateDate($value)) {

                            $fechas .= $value." - ";
                        }

                      }

                      echo "<span class='badge'>Fechas Realización entre : ".$fechas."</span>";
                                            
                    }
                    

                }


                echo "<br><br>";
                
                $this->reuniones = $this->getReunionesFiltro($filtro);                

                //print_r($filtro);  
                //echo "<br> <br>";



            }           

	    	//permisos-------------------------------------------------------------------------
            $arrPermisos = $this->getPermisosModulo_Tipo($this->id_modulo,$_COOKIE[$this->NameCookieApp."_IDtipo"]);
            $edita = $arrPermisos[0]["editar"];
            $elimina = $arrPermisos[0]["eliminar"];
            $consulta = $arrPermisos[0]["consultar"];
            //---------------------------------------------------------------------------------

            //Define las variables de la tabla a renderizar

            //Los campos que se van a ver
            $array_campos = [
               // ["nombre"=>"pkID"],
                ["nombre"=>"fecha_realizacion"],
                ["nombre"=>"moderador"],
                ["nombre"=>"desarrollo"],                          
            ];

            $array_opciones = [
              "modulo"=>"reunion",//nombre del modulo definido para jquerycontrollerV2
              "title"=>"Click Ver Detalles",//etiqueta html title
              "href"=>"detail_reunion.php?id_reunion=",
              "class"=>"detail"//clase que permite que añadir el evento jquery click
            ];  

            //la configuracion de los botones de opciones
            $array_btn =[

                /*[
                    "tipo"=>"editar",
                    "nombre"=>"reunion",
                    "permiso"=>$edita,
                 ],*/
                 [
                    "tipo"=>"eliminar",
                    "nombre"=>"reunion",
                    "permiso"=>$elimina,
                 ]
            ];

                
            /**/
            //Instancia el render
            $this->table_inst = new RenderTable($this->reuniones,$array_campos,$array_btn,$array_opciones);

            //valida si hay usuarios y permiso de consulta
            if( ($this->reuniones) && ($consulta==1) ){

                //ejecuta el render de la tabla
                $this->table_inst->render();                

            }elseif(($this->reuniones) && ($consulta==0)){

             $this->table_inst->render_blank();

             echo "<h3>En este momento no tiene permiso de consulta.</h3>";

            }else{

             $this->table_inst->render_blank();

             echo "<h3>En este momento no hay registros.</h3>";
            };
	    }



      


      public function getTablaCompromisosReunion($fkID_reunion, $tipo_user, $id_user){

        //permisos-------------------------------------------------------------------------
            $arrPermisos = $this->getPermisosModulo_Tipo(37,$_COOKIE[$this->NameCookieApp."_IDtipo"]);
            $edita = $arrPermisos[0]["editar"];
            $elimina = $arrPermisos[0]["eliminar"];
            $consulta = $arrPermisos[0]["consultar"];
            //---------------------------------------------------------------------------------

            //Define las variables de la tabla a renderizar

            //Los campos que se van a ver
            $array_campos = [
               // ["nombre"=>"pkID"],
                ["nombre"=>"participante"],
                ["nombre"=>"fecha_cumplimiento"],
                ["nombre"=>"descripcion"],                          
                ["nombre"=>"estado"],
                //["nombre"=>"descripcion_reprogramacion"],
            ];

            //la configuracion de los botones de opciones
            $array_btn =[

                 [
                    "tipo"=>"editar",
                    "nombre"=>"compromiso",
                    "permiso"=>$edita,
                 ],
                 [
                    "tipo"=>"eliminar",
                    "nombre"=>"compromiso",
                    "permiso"=>$elimina,
                 ]
            ];

            if(($tipo_user == 1) || ($tipo_user == 3) || ($tipo_user == 8)){
                $compromisos = $this->getCompromisosReuniones($fkID_reunion);    
            }else{
                $compromisos = $this->getCompromisosReunionesParticipante($fkID_reunion, $id_user);                
            }

            

            //print_r($compromisos);
            /**/
            //Instancia el render
            $this->table_inst = new RenderTable($compromisos,$array_campos,$array_btn,[]);

            //valida si hay usuarios y permiso de consulta
            if( ($compromisos) && ($consulta==1) ){

                //ejecuta el render de la tabla
                $this->table_inst->render();                

            }elseif(($compromisos) && ($consulta==0)){

             $this->table_inst->render_blank();

             echo "<h3>En este momento no tiene permiso de consulta.</h3>";

            }else{

             $this->table_inst->render_blank();

             echo "<h3>En este momento no hay registros.</h3>";
            };
            
      }


      public function getTablaCompromisosReuniones(){

        //permisos-------------------------------------------------------------------------
            $arrPermisos = $this->getPermisosModulo_Tipo(37,$_COOKIE[$this->NameCookieApp."_IDtipo"]);
            $edita = $arrPermisos[0]["editar"];
            $elimina = $arrPermisos[0]["eliminar"];
            $consulta = $arrPermisos[0]["consultar"];
            //---------------------------------------------------------------------------------

            //Define las variables de la tabla a renderizar

            //Los campos que se van a ver
            $array_campos = [
               // ["nombre"=>"pkID"],
                ["nombre"=>"participante"],
                ["nombre"=>"fecha_cumplimiento"],
                ["nombre"=>"descripcion"],                          
                ["nombre"=>"estado"],
                //["nombre"=>"descripcion_reprogramacion"],
            ];

            //la configuracion de los botones de opciones
            $array_btn =[

                 [
                    "tipo"=>"editar",
                    "nombre"=>"compromiso",
                    "permiso"=>$edita,
                 ],
                 [
                    "tipo"=>"eliminar",
                    "nombre"=>"compromiso",
                    "permiso"=>$elimina,
                 ]
            ];

            
            $compromisos = $this->getCompromisos();    
            
            

            //print_r($compromisos);
            /**/
            //Instancia el render
            $this->table_inst = new RenderTable($compromisos,$array_campos,$array_btn,[]);

            //valida si hay usuarios y permiso de consulta
            if( ($compromisos) && ($consulta==1) ){

                //ejecuta el render de la tabla
                $this->table_inst->render();                

            }elseif(($compromisos) && ($consulta==0)){

             $this->table_inst->render_blank();

             echo "<h3>En este momento no tiene permiso de consulta.</h3>";

            }else{

             $this->table_inst->render_blank();

             echo "<h3>En este momento no hay registros.</h3>";
            };
            
      }

		
	}
?>
