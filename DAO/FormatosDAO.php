<?php 

	include_once 'GenericoDAO.php';
	include_once 'PermisosDAO.php';

	class formatos extends GenericoDAO{

		/*-----------------------------------------*/
		//variables
		public $q_general;
		public $permisos;		
		/*-----------------------------*/
		public function __construct(){
			//contruye la clase GenericoDAO
			parent::__construct();
		}
		/*-----------------------------------------*/

		/*-----------------------------------------*/

		public function permisos($fkID_modulo,$fkID_tipo_usuario){

			$this->permisos = new PermisosDAO();

			$arrayPermisos = $this->permisos->getPermisosModulo_Tipo($fkID_modulo,$fkID_tipo_usuario);

			return $arrayPermisos;

		}
		
		//funciones generales
		public function getFormato(){

			$this->q_general = "select formato.*, a.nombre_cat as nom_categoria, b.nombre_cat as nom_subcategoria 
								FROM `formato` 
								INNER JOIN categoria a ON a.pkID = formato.fkID_categoria 
								INNER JOIN categoria b ON b.pkID = formato.fkID_subcategoria order by a.nombre_cat
								, b.nombre_cat";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getFormatoNoSub(){

			$this->q_general = "select formato.*, a.nombre_cat as nom_categoria 
								FROM `formato` 
								INNER JOIN categoria a ON a.pkID = formato.fkID_categoria                                
                                WHERE formato.fkID_subcategoria IS NULL || formato.fkID_subcategoria = 0  
                                 order by a.nombre_cat ";		
			
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

		public function getCategoria(){

			$this->q_general = "select * from categoria where fkID_padre is null order by nombre_cat";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getSubcategoria(){

			$this->q_general = "select * from categoria where fkID_padre is not null";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getNumFormatos(){

			$this->q_general = "select count(*) as numFormatos from formato";				
			
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

		public function getFormatoCategoria(){

			$this->q_general = "select formato.*, a.nombre_cat as nom_categoria, b.nombre_cat as nom_subcategoria 
								FROM `formato` 
								INNER JOIN categoria a ON a.pkID = formato.fkID_categoria 
								INNER JOIN categoria b ON b.pkID = formato.fkID_subcategoria where 2 >1 ";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getCategoriaId($pkID){
			
			$this->q_general = "select * from categoria where fkID_padre is null AND pkID=".$pkID."";		
			//print_r($this->q_general);
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getFormatoFiltro($filtro){

			$this->q_general = "select formato.*, a.nombre_cat as nom_categoria, b.nombre_cat as nom_subcategoria 
								FROM `formato` 
								INNER JOIN categoria a ON a.pkID = formato.fkID_categoria 
								INNER JOIN categoria b ON b.pkID = formato.fkID_subcategoria
								WHERE  2>1 and ".$filtro." order by a.nombre_cat , b.nombre_cat";		
			//print_r($this->q_general);
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getFormatoNoSubFiltro($filtro){

			$this->q_general = "select formato.*, a.nombre_cat as nom_categoria 
								FROM `formato` 
								INNER JOIN categoria a ON a.pkID = formato.fkID_categoria                                
                                WHERE 2>1 and ".$filtro." order by a.nombre_cat";		
			//print_r($this->q_general);
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


	}
/*
	$data = new hvida();

	$datos = $data->getHvida();

	print_r($datos);
*/
 ?>