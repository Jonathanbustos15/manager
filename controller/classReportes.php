<?php 
	
	class reportes {

 		//variables--------------------------------------------------------------
 		public $pdf;
 		//instancia de clase cotizacion
 		public $cotizaInst;
 		//guarda datos de cotizacion
 		public $data_gen;
 		//guarda registros de cotizacion
 		public $registrosCotizacion;
 		//------------------------------------------------------
 		//variables generales cotizacion
 		public $id_cotiza;
 		public $fecha;
 		//variables cliente
 		public $razon;
 		public $num_cc;
 		public $nom_cliente;
 		public $ap_cliente;
 		//variables de usuario
 		public $alias_user;
 		//variables cotizacion
 		public $total_cotiza;

 		//++++++++++++++++++++
 		public $header_cotizacion;
 		public $data_regCotizacion;
 		//-----------------------------------------------------------------------

 		public function __construct(){

 			$this->cotizaInst = new cotizacion();
 			$this->pdf =  new FPDF();
 		}

 		//funciones--------------------------------------------------------------
 		function loadDataPdfCotizacion(){

 			//carga datos de cotizacion en data_gen
 			$this->data_gen = $this->cotizaInst->getCotizacionId($_GET['pkID']);

 			//asigna variables del pdf cotizacion
 			
 			$this->id_cotiza = $this->data_gen[0]["pkID"];
			$this->fecha = $this->data_gen[0]["fecha"];
			$this->num_cc = $this->data_gen[0]["num_cc"];
			$this->razon = $this->data_gen[0]["razon_social"];
			$this->nom_cliente = $this->data_gen[0]["nom_cliente"];
			$this->ap_cliente = $this->data_gen[0]["ap_cliente"];
			$this->alias_user = $this->data_gen[0]["alias"];
			$this->total_cotiza = $this->data_gen[0]["valor_total"];
 		}

 		function loadRegistrosCotPdf(){

 			$this->registrosCotizacion = $this->cotizaInst->getRegistrosCotizaPDF($_GET['pkID']);

	 		$this->header_cotizacion = array("Nombre","Cantidad/Un","$/Costo","Clase");
	 		$this->data_regCotizacion = array_values($this->registrosCotizacion);
 		}

 		function logoCotizacion(){

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
			//------------------------------------------------------
 		}

 		function bodyCotizacion(){

 			$this->pdf->SetFont('Times','',14);
			$this->pdf->Cell(150,10,'Fecha creacion:'.$this->fecha);
			$this->pdf->Cell(20,10,'Usuario:'.$this->alias_user);
			$this->pdf->Ln();		
			$this->pdf->Cell(40,10,'Numero de cedula: '.$this->num_cc);
			$this->pdf->Ln();
			$this->pdf->Cell(40,10,'Razon Social: '.$this->razon);
			$this->pdf->Ln();
			$this->pdf->Cell(40,10,'Nombre: '.$this->nom_cliente." ".$this->ap_cliente);
			$this->pdf->Ln();
 		}

 		function tablaCotizacion(){

 			$this->pdf->Cell(40,10,'Materiales');
			$this->pdf->Ln();	
			
			// Cabecera
			    foreach($this->header_cotizacion as $col)
			        $this->pdf->Cell(49,7,$col,1);
			    	$this->pdf->Ln();
			    // Datos
			    foreach($this->data_regCotizacion as $row)
			    {
			        foreach($row as $col)
			            $this->pdf->Cell(49,6,$col,1);
			        	$this->pdf->Ln();
			    }

 		}

 		function createPdfCotizacion(){

 			$this->pdf->AddPage();

 			$this->loadDataPdfCotizacion();

 			$this->loadRegistrosCotPdf();

 			$this->logoCotizacion();

 			$this->bodyCotizacion();

 			$this->tablaCotizacion();

 			$this->pdf->Ln();
			$this->pdf->Cell(40,10,'Total IVA Incluido: $'.$this->total_cotiza);

			$this->pdf->Output();
 		}
 		//-----------------------------------------------------------------------
 	}

 ?>