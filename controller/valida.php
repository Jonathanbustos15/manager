<?php 
	
	//-----------------
	//error_reporting(0);
	//-----------------
include("../DAO/PermisosDAO.php");

	class valida extends PermisosDAO {

		//---------------------------------------------------------
	    //variables de sesion
	    public $id;
	    public $nombre;
	    public $tipo;
	    public $id_tipo;
	    //-----------------------------------------
	  
	    //-----------------------------------------
	    //funciones
	    public function asigna_vals(){

	    	//print_r($_COOKIE);

	    	if(sizeof($_COOKIE) <= 2){ 

	    		$this->id = "";
		        $this->nombre = "";
		        $this->tipo = "";
		        $this->id_tipo = "";

	    	}else{
		        $this->id = $_COOKIE["log_lunelAdmin_id"];
		        $this->nombre = $_COOKIE["log_lunelAdmin_nombre"];
		        $this->tipo = $_COOKIE["log_lunelAdmin_tipo"];
		        $this->id_tipo = $_COOKIE["log_lunelAdmin_IDtipo"];
	        }

	    }

	    public function valida_vals(){

	    	$this->asigna_vals();

	        if($this->id == "" || $this->nombre == "" || $this->tipo == "" || $this->id_tipo == ""){
	            //echo '<script language="JavaScript"> alert("Usuario no identificado, por favor identifíquese."); window.location = "index.php"; </script>';
	            return false;
	        }else{
	            
	            //$this->mostrar_pagina($_GET["pagina"]);
	            return true;
	        }
	    }

	    //-------------------------------------------------------------------
	    //funcion para validar el perfil de usuario
	    public function valida_perfil(){

	    	return $this->tipo;
	    }

	    public function getIDtipo(){

	    	return $this->id_tipo;
	    }

	    public function getIdUsuario(){

	    	return $this->id;
	    }

	    public function valida_entrada_perfil($id_modulo,$id_perfil_actual){

	    	//Devuelve TRUE si needle se encuentra en el array, FALSE de lo contrario.

	    	$permisos = $this->getPermisosModulo_Tipo($id_modulo,$id_perfil_actual);
	    	
	    	if (sizeof($permisos[0]) > 0 ) {	    		
	    		return true;
	    	}else{	    		
	    		return false;
	    	}	    		    	
	    }

	    public function valida_usuario_proyecto($id_usuario,$id_tipo_usuario,$id_proyecto){

	    	//primero validar si es administrador
	    	//si es administrador lo deja pasar
	    	//si no es administrador valida si tiene permisos en la tabla proyectos_usuarios
	    	//si teiene permisos dejarlo pasar

	    	//SELECT * FROM `proyectos_usuarios` WHERE `fkID_proyecto` = 24 and `fkID_usuario` = 1

	    	if ($id_tipo_usuario == "1") {
	    		# code...
	    		return true;
	    	} else {
	    		# code...
	    		$permiso = $this->getPermisoUsuarioProyecto($id_usuario,$id_proyecto);

	    		//print_r($permiso);

	    		//echo sizeof($permiso[0]);

	    		/**/
	    		if (sizeof($permiso[0]) > 0) {
	    			# code...
	    			//echo "Si tiene permiso";
	    			return true;
	    		} else {
	    			# code...
	    			//echo "No tiene permiso";
	    			return false;
	    		}
	    		
	    	}
	    	
	    }
	    //-------------------------------------------------------------------

	    public function mensaje_error(){

	    	if($this->valida_vals() == true){
	    		echo '<script language="JavaScript"> alert("No tiene permisos para acceder a este módulo."); history.back(1); //window.location = "login.php"; </script>';
	    	}else{
	    		echo '<script language="JavaScript"> localStorage.removeItem("sesion_time"); alert("Usuario no identificado o su tiempo de sesion termino, por favor identifíquese."); window.location = "login.php"; </script>';
	    	}    	

	    }

	    //-----------------------------------------
	}

 ?>