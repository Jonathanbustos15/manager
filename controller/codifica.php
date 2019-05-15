<?php 
	
	//----------------------------------------------
 	//clase para codificacion

 	class codifica

	{
		public $password_md5;
		public $password_sha1;
		public $password_salt;
		public $password_strong;
		public $pass_g;

		function __construct($pass_g)
		{
			$this->pass_g = $pass_g;
		}

		function p_md5(){
			$this->password_md5 = md5($this->pass_g);
			return $this->password_md5;
		}

		function p_sha1(){
			$this->password_sha1 = sha1($this->pass_g);
			return $this->password_sha1;
		}

		function p_salt($salt){
			$this->password_salt = md5($salt . $this->pass_g);
			return $this->password_salt;
		}

		function p_strong($salt){
			$this->password_strong = sha1(md5($salt . $this->pass_g));
			return $this->password_strong;
		}

	}
	//----------------------------------------------

 ?>