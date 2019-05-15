<?php 

	include_once 'GenericoDAO.php';

	class hvida extends GenericoDAO{

		/*-----------------------------------------*/
		//variables
		public $q_general;		
		/*-----------------------------*/
		public function __construct(){
			//contruye la clase GenericoDAO
			parent::__construct();
		}
		/*-----------------------------------------*/

		/*-----------------------------------------*/
		
		//funciones generales
		public function getHvida(){

			$this->q_general = "select hoja_vida.*, estado.nombre as nom_estado, usuarios.alias, usuarios.pkID as pkID_usuario,(select b.nombre  from hoja_estudio a join estudio b on a.pkID_estudio=b.pkID where b.fkID_tipoEstudio=1 and a.pkID_hojaVida=hoja_vida.pkID limit 0,1) as pregrados
								FROM `hoja_vida` 
								INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado
								INNER JOIN usuarios ON usuarios.pkID = hoja_vida.fkID_usuario";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getHvidaPersonal(){

			$this->q_general = "select hoja_vida.*, estado.nombre as nom_estado, usuarios.alias, usuarios.pkID as pkID_usuario
								FROM `hoja_vida` 
								INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado
								INNER JOIN usuarios ON usuarios.pkID = hoja_vida.fkID_usuario                                
                                WHERE hoja_vida.fkID_estado = 1 OR hoja_vida.fkID_estado = 3";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		/*
		consulta general de busqueda por estudios

		select hoja_vida.*, estado.nombre as nom_estado, usuarios.alias, usuarios.pkID as pkID_usuario, estudio.nombre as nom_estudio, tipo_estudio.nombre as nom_tipoEstudio

		from hoja_vida

		INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado
										
		INNER JOIN usuarios ON usuarios.pkID = hoja_vida.fkID_usuario


		INNER JOIN hoja_estudio on hoja_vida.pkID = hoja_estudio.pkID_hojaVida

		INNER JOIN estudio ON hoja_estudio.pkID_estudio = estudio.pkID

		INNER JOIN tipo_estudio on estudio.fkID_tipoEstudio = tipo_estudio.pkID


		*/

		public function getHvidaS($param){

			$this->q_general = "select hoja_vida.*, estado.nombre as nom_estado, usuarios.alias, usuarios.pkID as pkID_usuario, estudio.nombre as nom_estudio, tipo_estudio.nombre as nom_tipoEstudio

								from hoja_vida

								INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado
																
								INNER JOIN usuarios ON usuarios.pkID = hoja_vida.fkID_usuario


								INNER JOIN hoja_estudio on hoja_vida.pkID = hoja_estudio.pkID_hojaVida

								INNER JOIN estudio ON hoja_estudio.pkID_estudio = estudio.pkID

								INNER JOIN tipo_estudio on estudio.fkID_tipoEstudio = tipo_estudio.pkID

								WHERE hoja_estudio.pkID_hojaVida ".$param."

								GROUP BY hoja_vida.pkID";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getHojaEstudio(){

			$this->q_general = "select * FROM `hoja_estudio`";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getEstudio(){

			$this->q_general = "select estudio.*, tipo_estudio.nombre as nom_tipo_estudio 
								FROM `estudio`
								INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getPregrado(){

			$this->q_general = "select estudio.*, tipo_estudio.nombre as nom_tipo_estudio 
								FROM `estudio`
								INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio
                                WHERE estudio.fkID_tipoEstudio = 1";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getPosgrado(){

			$this->q_general = "select estudio.*, tipo_estudio.nombre as nom_tipo_estudio 
								FROM `estudio`
								INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio
                                WHERE estudio.fkID_tipoEstudio != 1";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getEstado(){

			$this->q_general = "select * from estado";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getNumHojas(){

			$this->q_general = "select count(*) as numHojas from hoja_vida";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		//---------------------------------------------------------------------------------------------------------
		//Funciones específicas

		public function getHvidaId($id_hvida){

			$this->q_general = "select hoja_vida.*, estado.nombre as nom_estado, usuarios.alias, usuarios.pkID as pkID_usuario
								FROM `hoja_vida` 
								INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado
								INNER JOIN usuarios ON usuarios.pkID = hoja_vida.fkID_usuario
								WHERE hoja_vida.pkID = ".$id_hvida;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getEstudioId($id_hvida){

			$this->q_general = "select hoja_vida.pkID as pkID_hojaVida, estudio.*, tipo_estudio.nombre as nom_tipoEstudio, hoja_estudio.pkID as pkID_regHojaEstudio". 

							" FROM `hoja_vida`".

							" INNER JOIN hoja_estudio ON hoja_estudio.pkID_hojaVida = hoja_vida.pkID".

							" INNER JOIN estudio on estudio.pkID = hoja_estudio.pkID_estudio".

							" INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio".

							" WHERE hoja_vida.pkID =".$id_hvida;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getArchivosId($id_hvida){

			$this->q_general = "select * FROM `archivo` WHERE pkID_hojaVida =".$id_hvida;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		//--------------------------------------------------------------------------------
		//consultas para personal en el modulo proyectos

		public function getPersonalProyecto($pkID_proyecto){

			$this->q_general = "select hv_proyecto.*, hoja_vida.nidentificacion,hoja_vida.nombre, hoja_vida.apellido, hoja_vida.telefono, hoja_vida.email, estado.nombre as nom_estado

								FROM `hv_proyecto` INNER JOIN hoja_vida ON hoja_vida.pkID = hv_proyecto.fkID_hv 

								INNER JOIN proyectos on proyectos.pkID = hv_proyecto.fkID_proyecto 

								INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado

								WHERE proyectos.pkID =".$pkID_proyecto;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
		//--------------------------------------------------------------------------------
	}
/*
	$data = new hvida();

	$datos = $data->getHvida();

	print_r($datos);
*/
 ?>