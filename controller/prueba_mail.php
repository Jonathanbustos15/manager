<?php
	//configuracion de ssmtp
	//https://reviblog.net/2014/03/04/como-instalar-y-configurar-un-servidor-de-correo-smtp-para-enviar-emails-desde-localhost-con-php-linux/

	$destinatario = "jhellmetal2000@gmail.com"; 
	$asunto = "Mensaje de prueba de Lunel IE Manager"; 
	$cuerpo = ' 
	<html> 
	<head> 
	   <title>Lunel IE Manager</title> 
	</head> 
	<body> 
	<h1>Un cordial saludo,</h1> 
	<p> 
	<b>Bienvenidos al correo electrónico de prueba de Lunel IE Manager</b>, este mensaje va a estar llegando a su correo mientras se hacen pruebas de desarrollo. <br> <h4>Gracias.</h4> 
	</p> 
	</body> 
	</html>'; 

	//para el envío en formato HTML 
	$headers = "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

	//dirección del remitente luneliemanagermailpruebas@gmail.com pass:lunelmanageradmin
	$headers .= "From: Lunel IE Manager pruebas <luneliemanagermailpruebas@gmail.com>\r\n"; 

	//dirección de respuesta, si queremos que sea distinta que la del remitente 
	//$headers .= "Reply-To: luneliemanagermailpruebas@gmail.com\r\n"; 

	//ruta del mensaje desde origen a destino 
	//$headers .= "Return-path: holahola@desarrolloweb.com\r\n"; 

	//direcciones que recibián copia 
	//$headers .= "Cc: maria@desarrolloweb.com\r\n"; 

	//direcciones que recibirán copia oculta 
	//$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 

	//$mensaje = mail($destinatario,$asunto,$cuerpo,$headers);
	/**/
	if (mail($destinatario,$asunto,$cuerpo,$headers)) {
		# code...
		echo "El correo se envió.";
	}else{
		echo "No sirve para una mierda.";
	};

?>