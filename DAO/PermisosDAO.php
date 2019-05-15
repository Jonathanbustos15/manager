<?php
	/**/
	include_once 'GenericoDAO.php';
		
	class PermisosDAO extends GenericoDAO {
		
		public $generico;
		public $q_general;
		
		function __construct(){
			$this->generico = new GenericoDAO();
		}
		

		//Funciones------------------------------------------
		//Espacio para las funciones en general de esta clase.

		/*
		SELECT permisos.*, tipo_usuario.nombre as nom_tipo, modulos.Nombre as nom_modulo 

		FROM `permisos`

		INNER JOIN tipo_usuario ON tipo_usuario.pkID = permisos.fkID_tipo_usuario

		INNER JOIN modulos ON modulos.pkID = permisos.fkID_modulo
		*/

		public function getPermisos(){

			$this->q_general = "select permisos.*, tipo_usuario.nombre as nom_tipo, modulos.Nombre as nom_modulo 

								FROM `permisos`

								INNER JOIN tipo_usuario ON tipo_usuario.pkID = permisos.fkID_tipo_usuario

								INNER JOIN modulos ON modulos.pkID = permisos.fkID_modulo";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getPermisosModulo_Tipo($fkID_modulo,$fkID_tipo_usuario){

			$this->q_general = "select permisos.*, tipo_usuario.nombre as nom_tipo, modulos.Nombre as nom_modulo 

								FROM `permisos`

								INNER JOIN tipo_usuario ON tipo_usuario.pkID = permisos.fkID_tipo_usuario

								INNER JOIN modulos ON modulos.pkID = permisos.fkID_modulo

								WHERE permisos.fkID_modulo = ".$fkID_modulo." AND permisos.fkID_tipo_usuario = ".$fkID_tipo_usuario;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getPermisoUsuarioProyecto($id_usuario,$id_proyecto){

			$this->q_general = "select * FROM `proyectos_usuarios` WHERE `fkID_proyecto` = ".$id_proyecto." and `fkID_usuario` = ".$id_usuario;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
	}
?>
