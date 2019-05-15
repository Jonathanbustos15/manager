<?php 

	class crypt {

	 	private $key = 'h3ll_d00m';	 	
	 	
	 	//----------------------------------------------------

	 	function encriptar($cadena){
		    //$key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
		    $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($this->key), $cadena, MCRYPT_MODE_CBC, md5(md5($this->key))));
		    return $encrypted; //Devuelve el string encriptado		 
		}
		//----------------------------------------------------

		function desencriptar($cadena){
		     //$key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
		     $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($this->key), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($this->key))), "\0");
		    return $decrypted;  //Devuelve el string desencriptado
		}
		//----------------------------------------------------

		function encriptasha1($cadena){

			$encripta = sha1($cadena);

			return $encripta;
		}

	 }

 ?>