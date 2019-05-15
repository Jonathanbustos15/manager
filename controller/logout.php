<?php 
//------------------------
error_reporting(0);
//------------------------

	class salir {

		//------------------------------------------
		//variables
		public $accion;
		//------------------------------------------

		//------------------------------------------
		//funciones
		public function __construct($accion){
			$this->accion = $accion;
		}

		private function destruye_cookies(){

			unset($_COOKIE["log_lunelAdmin_id"]);
			unset($_COOKIE["log_lunelAdmin_nombre"]);
			unset($_COOKIE["log_lunelAdmin_alias"]);
			//unset($_COOKIE["log_lunelAdmin_num_cc"]);
			unset($_COOKIE["log_lunelAdmin_tipo"]);
			unset($_COOKIE["log_lunelAdmin_IDtipo"]);

			setcookie("log_lunelAdmin_id", null, -1, '/');
			setcookie("log_lunelAdmin_nombre", null, -1, '/');
			setcookie("log_lunelAdmin_alias", null, -1, '/');
			//setcookie("log_lunelAdmin_num_cc", null, -1, '/');
			setcookie("log_lunelAdmin_tipo", null, -1, '/');
			setcookie("log_lunelAdmin_IDtipo", null, -1, "/");

		}

		private function valida(){

			$valida = count($_COOKIE);

			if($valida == 0){
				//echo '<script language="JavaScript"> alert("Ha salido  exitosamente"); window.location = "index.php"; </script>';
				return true;	
			}else{
				//echo '<script language="JavaScript"> alert("Ha ocurrido un error, su sesión permanecerá abierta."); window.location = "javascript:history.back(-1)"; </script>';
				return $_COOKIE;
			}
		}

		private function confirma(){

			echo '
			<script language="JavaScript">
				if (!confirm("Esta a punto de cerrar su sesion, esta seguro ?")){
					window.location = "javascript:history.back(-1)";
					}else{
					window.location = "logout.php?conf=s";			
					}
			</script>';

		}

		public function exe_salir(){

			if($this->accion == "s"){

				$this->destruye_cookies();
				$var_validacion=$this->valida();

				if($var_validacion == true){
					echo '<script language="JavaScript"> localStorage.removeItem("sesion_time"); alert("Ha salido  exitosamente"); window.location = "../index.php"; </script>';
				}else{
					
					print_r($var_validacion);

					echo '<script language="JavaScript"> localStorage.removeItem("sesion_time"); alert("Ha ocurrido un error, no se puede cerrar la sesión."); window.location = "javascript:history.back(-1)"; </script>';
					
				}

			}else{
				
				$this->confirma();
			}

		}
		//------------------------------------------
	}

	//--------------------------------------------------------------------------------------------------------
	$salir = new salir($conf=$_GET['conf']);
	$salir->exe_salir();
	//--------------------------------------------------------------------------------------------------------
 ?>