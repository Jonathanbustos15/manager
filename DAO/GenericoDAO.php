<?php

include_once '../Conexion/Conexion.php';

class GenericoDAO {
    
   /**
     * El conector de la base de datos
     * @var Conexion
     */
   protected $Conector;
   private $r;
   
     
   public function __construct() {
        $this->Conector = new Conexion();
        $this->r = array();
    }
     
    /**
     *Retorna un Array a partir  de la consulta 
     * @param type String $query 
     * @return Array -> Un array con los datos de la consulta
     */
    public static function EjecutarConsulta($query){
      
		  // $db=$Conector->connect();
		$Conector = new Conexion();
		$db=$Conector->connect();
        
        if(!$result = $db->query($query)){
			die('There was an error running the query [' . $db->error . ']');
		}
		//-----------------------------------------
		if ($result->num_rows >0){
			while ($fila = $result->fetch_assoc()){
				$retorno[] = $fila;
			}
			return $retorno;
		} else {
			return $result->num_rows;
		}
		
		$result->free();
		//------------------------------------------
	}
	//------------------------------------------------------------------------
		public function EjecutaInsertar($query){

			 // $db=$Conector->connect();
			$Conector = new Conexion();
			$db=$Conector->connect();

		       if(!$result = $db->query($query)){
					die('There was an error running the query [' . $db->error . ']');
				}

				else{
					$this->r["last_id"] = $db->insert_id;
					$this->r["estado"] = "ok";
					$this->r["mensaje"] = "Guardado correctamente.";

					return $this->r;
				}
		}
	//------------------------------------------------------------------------	
		public function EjecutaActualizar($query){

			 // $db=$Conector->connect();
			$Conector = new Conexion();
			$db=$Conector->connect();

		       if(!$result = $db->query($query)){
					die('There was an error running the query [' . $db->error . ']');
				}

				else{
					$this->r["estado"] = "ok";
					$this->r["mensaje"] = "Actualizado correctamente.";

					return $this->r;
				}
		}
	//------------------------------------------------------------------------
	//------------------------------------------------------------------------

		public function EjecutaEliminar($query){

			 // $db=$Conector->connect();
			$Conector = new Conexion();
			$db=$Conector->connect();

		       if(!$result = $db->query($query)){
					die('There was an error running the query [' . $db->error . ']');
				}

				else{
					$this->r["estado"] = "ok";
					$this->r["mensaje"] = "Eliminado correctamente.";

					return $this->r;
				}
		}
	//------------------------------------------------------------------------

	//------------------------------------------------------------------------
		//permisos de usuario
		public function getPermisos(){

			$this->q_general = "select permisos.*, tipo_usuario.nombre as nom_tipo, modulos.Nombre as nom_modulo 

								FROM `permisos`

								INNER JOIN tipo_usuario ON tipo_usuario.pkID = permisos.fkID_tipo_usuario

								INNER JOIN modulos ON modulos.pkID = permisos.fkID_modulo";		
			
			return $this->EjecutarConsulta($this->q_general);
		}

		public function getPermisosModulo_Tipo($fkID_modulo,$fkID_tipo_usuario){

			$this->q_general = "select permisos.*, tipo_usuario.nombre as nom_tipo, modulos.Nombre as nom_modulo 

								FROM `permisos`

								INNER JOIN tipo_usuario ON tipo_usuario.pkID = permisos.fkID_tipo_usuario

								INNER JOIN modulos ON modulos.pkID = permisos.fkID_modulo

								WHERE permisos.fkID_modulo = ".$fkID_modulo." AND permisos.fkID_tipo_usuario = ".$fkID_tipo_usuario;		
			
			return $this->EjecutarConsulta($this->q_general);
		}
	//------------------------------------------------------------------------
   
}

?>
