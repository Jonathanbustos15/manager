<?php 

	include_once 'GenericoDAO.php';

	class categoria extends GenericoDAO{

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

		public function getCategorias(){

			//SELECT categoria.*, a.nombre as nom_categoria FROM `categoria` a INNER JOIN categoria ON categoria.pkID = a.fkID_padre

			$this->q_general = "select * FROM `categoria` WHERE fkID_padre IS NULL order by nombre_cat";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getSubCategorias(){

			//select categoria.*, a.nombre as nom_categoria FROM `categoria` a INNER JOIN categoria ON categoria.pkID = a.fkID_padre

			$this->q_general = "select categoria.*, a.nombre as nom_categoria, a.pkID as pkID_categoria FROM `categoria` a INNER JOIN categoria ON categoria.pkID = a.fkID_padre";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
		
	}
/*
	$data = new hvida();

	$datos = $data->getHvida();

	print_r($datos);
*/
 ?>