<?php
	/**/
	include_once 'genericoDAO.php';
	include_once 'PermisosDAO.php';
		
	class contactosDAO extends GenericoDAO {
		
		public $permisos;
		public $q_general;
		
		function __construct(){
			parent::__construct();
		}
		
		//Funciones------------------------------------------
		//Espacio para las funciones en general de esta clase.
   		public function permisos($fkID_modulo,$fkID_tipo_usuario){
		
			$this->permisos = new PermisosDAO();
			$arrayPermisos = $this->permisos->getPermisosModulo_Tipo($fkID_modulo,$fkID_tipo_usuario);
			return $arrayPermisos;
		}

		public function getContactos(){
			
			$this->q_general = "select contactos.*, tipo_contacto.nombre as nom_tipo, entidades.nombre_entidad

								FROM `contactos`

								INNER JOIN tipo_contacto ON tipo_contacto.pkID = contactos.fkID_tipo_contacto

								INNER JOIN entidades ON entidades.pkID = contactos.fkID_entidad";
					//validacion de administrador para tipo de acceso
					if ($_COOKIE["log_lunelAdmin_IDtipo"]!=1) {
						$this->q_general .= " WHERE contactos.tipo_acceso != 1 order by contactos.pkID desc ";
					}else{
						$this->q_general .= " order by contactos.pkID desc ";
					}
							
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getContactosNoEnt(){
			
			$this->q_general = "select contactos.*, tipo_contacto.nombre as nom_tipo

								FROM `contactos`

								INNER JOIN tipo_contacto ON tipo_contacto.pkID = contactos.fkID_tipo_contacto";
					
					//validacion de administrador para tipo de acceso
					if ($_COOKIE["log_lunelAdmin_IDtipo"]!=1) {
						$this->q_general .= " WHERE contactos.fkID_entidad = 0 AND contactos.tipo_acceso != 1 order by contactos.pkID desc ";
					}else{
						$this->q_general .= " WHERE contactos.fkID_entidad = 0 order by contactos.pkID desc ";
					}		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getSelectEntidad(){			

			$this->q_general = "select * FROM `entidades` order by nombre_entidad";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getSelectTipoContacto(){			

			$this->q_general = "select * FROM `tipo_contacto`";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getContactoId($id_contacto){

			$this->q_general = "select contactos.*, tipo_contacto.nombre as nom_tipo, entidades.nombre_entidad as nombre_entidad
								FROM `contactos` 
								INNER JOIN tipo_contacto ON tipo_contacto.pkID = contactos.fkID_tipo_contacto
								LEFT OUTER JOIN entidades ON entidades.pkID = contactos.fkID_entidad
								WHERE contactos.pkID = ".$id_contacto;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getFilesContactoData($id_contacto){			

			$this->q_general = "select * FROM `documentos_contactos` where fkID_contacto = ".$id_contacto;	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
		
	}
?>
