<?php

	/*
	crear los reportes de los modulos
	-usuarios
	-clientes
	-materiales

	*Debe tener
	--tabla de datos
	--cuantos hay?(total)
	--fecha actual
	--el usuario que lo hace

	*/ 
	
	include '../DAO/UsuariosDAO.php';	
	include '../DAO/ClientesDAO.php';
	include '../DAO/MaterialesDAO.php';

	//require '../DAO/CotizacionDAO.php';
	
	
	class repAdminPdf {

		public $pdf;
		//----------------------------
		public $time;
		public $fecha;
		//----------------------------
		//variables usuarios
		//instancia dao usuarios
		public $usuariosInst;
		//datos de la instancia
		public $dataUsuarios;
		//tabla usuarios
		public $header_usuarios;
		public $bobyTabla_usuarios;
		public $total_usuarios;
		public $total_admin = 0;
		public $total_empleados = 0;
		public $total_clientes = 0;
		//----------------------------
		//variables clientes
		//instancia dao clientes
		public $clientesInst;
		//datos de la instancia
		public $dataClientes;
		//tabla clientes
		public $header_clientes;
		public $bobyTabla_clientes;
		public $total_cli;
		//----------------------------
		//variables materiales
		//instancia dao materiales
		public $materialesInst;
		//datos de la instancia
		public $dataMateriales;
		public $dataMaterialesReg;
		//tabla materiales
		public $header_materiales;
		public $bobyTabla_materiales;
		public $id_material;
		public $header_materialesReg;
		public $bobyTabla_materialesReg;
		public $total_materiales;
		//----------------------------
		//variables cotizaciones
		//instancia dao cotizaciones
		public $cotizacionesInst;
		//datos de la instancia
		public $dataCotizaciones;
		//tabla cotizaciones
		public $header_cotizaciones;
		public $bobyTabla_cotizaciones;
		public $total_cotizaciones;
		//----------------------------
		
		public function __construct(){

			$this->pdf =  new FPDF();
			$this->usuariosInst = new UsuariosDAO();
			$this->clientesInst = new clientes();
			$this->materialesInst = new materiales();
			$this->cotizacionesInst = new cotizacion();
			$this->time = time();
		}

		//----------------------------------------------------------

		function logoReporte(){

 			//------------------------------------------------------
			// Logo
		    //$this->Image('logo_pb.png',10,8,33);
		    // Arial bold 15  
		    $this->pdf->SetFont('Arial','B',15);
		    // Movernos a la derecha
		    $this->pdf->Cell(55);
		    // Título
		    $this->pdf->Cell(90,10,'Deposito y Ferreteria La Super 7',1,0,'C');
		    // Salto de línea
		    $this->pdf->Ln(20);

		    $this->pdf->Cell(30,10,'Fecha: '.$this->fecha = date("d-m-Y H:i:s", $this->time));

		    $this->pdf->Ln();
			//------------------------------------------------------
 		}

 		// Pie de página
		function Footer()
		{
		    // Posición: a 1,5 cm del final
		    $this->pdf->SetY(1);
		    // Arial italic 8
		    $this->pdf->SetFont('Arial','I',8);
		    // Número de página
		    $this->pdf->Cell(0,10,'Pagina '.$this->pdf->PageNo().'/{nb}',0,0,'C');
		}

 		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		function loadUsuarios(){

			$this->dataUsuarios = $this->usuariosInst->getUsuariosReporte();

			$this->header_usuarios = array("Id","Alias","Nombres","Apellidos","Num.cc","Tipo");
			$this->bobyTabla_usuarios = array_values($this->dataUsuarios);
			$this->total_usuarios = count($this->dataUsuarios);

			 

			for ($i=0; $i < count($this->dataUsuarios); $i++) { 
				# code...
				if($this->dataUsuarios[$i]["nom_tipo"] == "Administrador"){
					$this->total_admin++;
				}

				if($this->dataUsuarios[$i]["nom_tipo"] == "Empleado"){
					$this->total_empleados++;
				}

				if($this->dataUsuarios[$i]["nom_tipo"] == "Cliente"){
					$this->total_clientes++;
				}				
			}
		}

		function tablaUsuarios(){

 			$this->pdf->Cell(40,10,'Reporte de Usuarios:');
			$this->pdf->Ln();
			$this->pdf->Ln();	
			
			$this->pdf->SetFont('Times','B',12);
			// Cabecera
			    foreach($this->header_usuarios as $col)
			        $this->pdf->Cell(30,7,$col,1);
			    	$this->pdf->Ln();
			    // Datos
			$this->pdf->SetFont('Times','',10);
			    foreach($this->bobyTabla_usuarios as $row)
			    {
			        foreach($row as $col)		        	

			            $this->pdf->Cell(30,6,$col,1);
			        	$this->pdf->Ln();
			    }

			$this->pdf->Ln();			
			$this->pdf->Cell(40,10,'Total de Administradores: '.$this->total_admin);
			$this->pdf->Ln();
			$this->pdf->Cell(40,10,'Total de Empleados: '.$this->total_empleados);
			$this->pdf->Ln();
			$this->pdf->Cell(40,10,'Total de Clientes: '.$this->total_clientes);


			$this->pdf->SetFont('Times','B',12);
			$this->pdf->Ln();
			$this->pdf->Cell(40,10,'Total de Usuarios: '.$this->total_usuarios);
			
 		}
		//----------------------------------------------------------		

 		function createReporteUsuarios(){
 			$this->pdf->AliasNbPages();
 			$this->pdf->AddPage();
 			$this->logoReporte();

 			$this->loadUsuarios();

 			$this->tablaUsuarios();
			$this->Footer();
 			$this->pdf->Output();
 		}

 		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

 		function loadClientes(){

			$this->dataClientes = $this->clientesInst->getClientes();

			$this->header_clientes = array("Id","Num.cc","R.Social","Nombres","Apellidos","tel.","direccion","email");
			$this->bobyTabla_clientes = array_values($this->dataClientes);
			$this->total_cli = count($this->dataClientes);
	
		}

		function tablaClientes(){

 			$this->pdf->Cell(40,10,'Reporte de Clientes:');
			$this->pdf->Ln();
			$this->pdf->Ln();	
			
			$this->pdf->SetFont('Times','B',10);
			// Cabecera
			    foreach($this->header_clientes as $col)
			        $this->pdf->Cell(24,7,$col,1);
			    	$this->pdf->Ln();
			    // Datos
			$this->pdf->SetFont('Times','',7);
			    foreach($this->bobyTabla_clientes as $row)
			    {
			        foreach($row as $col)		        	

			            $this->pdf->Cell(24,6,$col,1);
			        	$this->pdf->Ln();
			    }

			$this->pdf->SetFont('Times','B',12);
			$this->pdf->Ln();
			$this->pdf->Cell(40,10,'Total de Clientes: '.$this->total_cli);
			
 		}


 		function createReporteClientes(){
 			$this->pdf->AliasNbPages();
 			$this->pdf->AddPage();
 			$this->logoReporte();

 			$this->loadClientes();

 			$this->tablaClientes();
			$this->Footer();
 			$this->pdf->Output();
 		}
 		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 		/**/
 		function loadCotizaciones(){

			$this->dataCotizaciones = $this->cotizacionesInst->getCotizacionReporte();

			$this->header_cotizaciones = array("Id","Fecha","Total","num.cc","Nombre","Apellido","Usuario");
			$this->bobyTabla_cotizaciones = array_values($this->dataCotizaciones);
			$this->total_cotizaciones = count($this->dataCotizaciones);
	
		}

		function tablaCotizaciones(){

 			$this->pdf->Cell(40,10,'Reporte de General Cotizaciones:');
			$this->pdf->Ln();
			$this->pdf->Ln();	
			
			$this->pdf->SetFont('Times','B',12);
			// Cabecera
			    foreach($this->header_cotizaciones as $col)
			        $this->pdf->Cell(28,7,$col,1);
			    	$this->pdf->Ln();
			    // Datos
			$this->pdf->SetFont('Times','',8);
			    foreach($this->bobyTabla_cotizaciones as $row)
			    {
			        foreach($row as $col)		        	

			            $this->pdf->Cell(28,6,$col,1);
			        	$this->pdf->Ln();
			    }

			$this->pdf->SetFont('Times','B',12);
			$this->pdf->Ln();
			$this->pdf->Cell(40,10,'Total de Cotizaciones: '.$this->total_cotizaciones);
			
 		}

 		function createReporteCotizaciones(){

 			$this->pdf->AliasNbPages();
 			$this->pdf->AddPage();
 			$this->logoReporte();

 			$this->loadCotizaciones();

 			$this->tablaCotizaciones();

 			$this->Footer();

 			$this->pdf->Output(); 			
 		}

 		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

 		function loadMateriales(){

			$this->dataMateriales = $this->materialesInst->getMaterialesReporte();			

			$this->header_materiales = array("Id","Nombre","Precio","Marca","Clase");
			$this->bobyTabla_materiales = array_values($this->dataMateriales);
			$this->total_materiales = count($this->dataMateriales);
	
		}


		function tablaMateriales(){

 			$this->pdf->Cell(40,10,'Reporte de Materiales:');
			$this->pdf->Ln();
						
			$this->pdf->SetFont('Times','B',12);
			// Cabecera
			    foreach($this->header_materiales as $col)
			        $this->pdf->Cell(28,7,$col,1);
			    	$this->pdf->Ln();

			    // Datos
			$this->pdf->SetFont('Times','',8);
			    foreach($this->bobyTabla_materiales as $row)
			    {	
			    	
			    	$this->id_material = $row["pkID"];
			    	//$this->pdf->Cell(28,6,$this->id_material,1);


			        foreach($row as $col)	

			            $this->pdf->Cell(28,6,$col,1);			        	
			        	$this->pdf->Ln();
			        
			        $this->loadMaterialesReg();

			    	$this->loadTblMteReg();	
			    }

			$this->pdf->SetFont('Times','B',12);
			//$this->pdf->Ln();
			$this->pdf->Cell(40,10,'Total de Materiales: '.$this->total_materiales);
			
 		}

 		function loadMaterialesReg(){

 			$this->header_materialesReg = array("Propiedades");

			$this->dataMaterialesReg = $this->materialesInst->getMaterialPropiedadesR($this->id_material);

			$this->bobyTabla_materialesReg = array_values($this->dataMaterialesReg);
				
		}


		function loadTblMteReg(){

				$this->pdf->SetFont('Times','B',10);
			// Cabecera
			    foreach($this->header_materialesReg as $col)
			        $this->pdf->Cell(28,7,$col,1);
			    	$this->pdf->Ln();

			$this->pdf->SetFont('Times','',8);

			foreach($this->bobyTabla_materialesReg as $row)
			    {
			        foreach($row as $col)		        	

			            $this->pdf->Cell(28,6,$col,1);
			        	$this->pdf->Ln();
			    }

			$this->pdf->Ln();
		}

 		function createReporteMateriales(){
			$this->pdf->AliasNbPages();
 			$this->pdf->AddPage();
 			$this->logoReporte();

 			$this->loadMateriales();

 			$this->tablaMateriales();
			//$this->Footer();
 			$this->pdf->Output();
 		}


	}
 ?>