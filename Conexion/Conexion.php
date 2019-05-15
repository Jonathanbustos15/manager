<?php
/**
 * Description of Conexion
 * La clase encargada de realizar la conexión a la base de datos
 */

 
class Conexion{
    
    
     /*
     * La base de datos principal
     */
    private $dbconection;
    /*
     * El usuario con el que se conecta a la base de datos
     */
    private $userconection;
    /*
     * La contraseña con la que se conecta el usuario
     */
    private $passconection;
    /*
     * La cadena de conexión  para establecer comunicación con la base de datos
     */
    private $stringconection;
    /*
     * nombre del servidor para establecer la conexión
     */
    private $hostconection;
    
    
    /**
     * El constructor de la clase donde están los datos para la conexión desde los métodos
     */
    public function __construct() {

        include "datos.php";
    
        $this->dbconection=$dbconection;
        $this->userconection=$userconection;
        $this->passconection=$passconection;
        $this->hostconection=$hostconection;
        
    }

     /**
     * Conexión a la base de datos
     * @return Retorna la cadena de conexión, o puede retornar un mensaje de error en caso de que lo haya
     */
    public function connect(){
              
		$this->stringconection= new mysqli($this->hostconection, $this->userconection,  $this->passconection,$this->dbconection);
		/*
        if($db->connect_errno > 0){
			die('Error en la conexion con la base de datos [' . $db->connect_error . ']');
		}*/

        $conn = $this->stringconection;

        $conn->set_charset("utf8");

		return $conn;
              
    }
    
    
}
?>		
		