<?php
	/**/
	include_once '../DAO/EmailDAO.php';
		
	class EmailController {
		
		public $EmailDAO;

		//variable de consulta de usuario
		public $usuario;
		public $usuariosLider;
		public $proceso;

		//variables de correo
		public $destinatario; //un array para que pueda recibir mas de una persona
		public $asunto;
		//
		public $cuerpo;
		//------------------------------------------------------------------------
		//variables correo html

		//------------------------------------------------------------------------
		public $headers;
		public $destinatarios; //para varios destinatarios

		//------------------------------------------------------------------------
		public $ruta_vista;

		//array de resultado
		public $r;
		
		function __construct(){
			$this->EmailDAO = new EmailDAO();
			$this->destinatario = array();
			$this->destinatarios = array();
			$this->r = array();

			//-----------------------------
			include("../Conexion/datos.php");

		    //echo $ruta_visor;

		    $this->ruta_vista = str_replace("/subidas", "", $ruta_visor);

		    //echo $ruta_vista;
		}
		
		//Funciones-------------------------------------------
		//Espacio para las funciones en general de esta clase.		

		public function setHeaders(){
			//para el envío en formato HTML 
			$this->headers = "MIME-Version: 1.0\r\n"; 
			$this->headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

			//dirección del remitente luneliemanagermailpruebas@gmail.com pass:lunelmanageradmin
			$this->headers .= "From: Lunel IE Manager pruebas <luneliemanagermailpruebas@gmail.com>\r\n"; 
		}

		public function setEmailHtml($title,$message,$idProceso){

			$this->cuerpo = '<!doctype html>
					<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
						<head>
							<!-- NAME: 1 COLUMN -->
							<!--[if gte mso 15]>
							<xml>
								<o:OfficeDocumentSettings>
								<o:AllowPNG/>
								<o:PixelsPerInch>96</o:PixelsPerInch>
								</o:OfficeDocumentSettings>
							</xml>
							<![endif]-->
							<meta charset="UTF-8">
					        <meta http-equiv="X-UA-Compatible" content="IE=edge">
					        <meta name="viewport" content="width=device-width, initial-scale=1">
							<title>'.$title.'</title>
					        
					    <style type="text/css">
							p{
								margin:10px 0;
								padding:0;
							}
							table{
								border-collapse:collapse;
							}
							h1,h2,h3,h4,h5,h6{
								display:block;
								margin:0;
								padding:0;
							}
							img,a img{
								border:0;
								height:auto;
								outline:none;
								text-decoration:none;
							}
							body,#bodyTable,#bodyCell{
								height:100%;
								margin:0;
								padding:0;
								width:100%;
							}
							#outlook a{
								padding:0;
							}
							img{
								-ms-interpolation-mode:bicubic;
							}
							table{
								mso-table-lspace:0pt;
								mso-table-rspace:0pt;
							}
							.ReadMsgBody{
								width:100%;
							}
							.ExternalClass{
								width:100%;
							}
							p,a,li,td,blockquote{
								mso-line-height-rule:exactly;
							}
							a[href^=tel],a[href^=sms]{
								color:inherit;
								cursor:default;
								text-decoration:none;
							}
							p,a,li,td,body,table,blockquote{
								-ms-text-size-adjust:100%;
								-webkit-text-size-adjust:100%;
							}
							.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
								line-height:100%;
							}
							a[x-apple-data-detectors]{
								color:inherit !important;
								text-decoration:none !important;
								font-size:inherit !important;
								font-family:inherit !important;
								font-weight:inherit !important;
								line-height:inherit !important;
							}
							#bodyCell{
								padding:10px;
							}
							.templateContainer{
								max-width:600px !important;
							}
							a.mcnButton{
								display:block;
							}
							.mcnImage{
								vertical-align:bottom;
							}
							.mcnTextContent{
								word-break:break-word;
							}
							.mcnTextContent img{
								height:auto !important;
							}
							.mcnDividerBlock{
								table-layout:fixed !important;
							}
						
							body,#bodyTable{
								/*@editable*/background-color:#ffffff;
							}
						/*
						@tab Page
						@section Background Style
						@tip Set the background color and top border for your email. You may want to choose colors that match your companys branding.
						*/
							#bodyCell{
								/*@editable*/border-top:0;
							}
						/*
						@tab Page
						@section Email Border
						@tip Set the border for your email.
						*/
							.templateContainer{
								/*@editable*/border:0;
							}
						/*
						@tab Page
						@section Heading 1
						@tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
						@style heading 1
						*/
							h1{
								/*@editable*/color:#202020;
								/*@editable*/font-family:Helvetica;
								/*@editable*/font-size:26px;
								/*@editable*/font-style:normal;
								/*@editable*/font-weight:bold;
								/*@editable*/line-height:125%;
								/*@editable*/letter-spacing:normal;
								/*@editable*/text-align:left;
							}
						/*
						@tab Page
						@section Heading 2
						@tip Set the styling for all second-level headings in your emails.
						@style heading 2
						*/
							h2{
								/*@editable*/color:#202020;
								/*@editable*/font-family:Helvetica;
								/*@editable*/font-size:22px;
								/*@editable*/font-style:normal;
								/*@editable*/font-weight:bold;
								/*@editable*/line-height:125%;
								/*@editable*/letter-spacing:normal;
								/*@editable*/text-align:left;
							}
						/*
						@tab Page
						@section Heading 3
						@tip Set the styling for all third-level headings in your emails.
						@style heading 3
						*/
							h3{
								/*@editable*/color:#202020;
								/*@editable*/font-family:Helvetica;
								/*@editable*/font-size:20px;
								/*@editable*/font-style:normal;
								/*@editable*/font-weight:bold;
								/*@editable*/line-height:125%;
								/*@editable*/letter-spacing:normal;
								/*@editable*/text-align:left;
							}
						/*
						@tab Page
						@section Heading 4
						@tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
						@style heading 4
						*/
							h4{
								/*@editable*/color:#202020;
								/*@editable*/font-family:Helvetica;
								/*@editable*/font-size:18px;
								/*@editable*/font-style:normal;
								/*@editable*/font-weight:bold;
								/*@editable*/line-height:125%;
								/*@editable*/letter-spacing:normal;
								/*@editable*/text-align:left;
							}
						/*
						@tab Preheader
						@section Preheader Style
						@tip Set the background color and borders for your emails preheader area.
						*/
							#templatePreheader{
								/*@editable*/background-color:#ffffff;
								/*@editable*/border-top:0;
								/*@editable*/border-bottom:0;
								/*@editable*/padding-top:9px;
								/*@editable*/padding-bottom:9px;
							}
						/*
						@tab Preheader
						@section Preheader Text
						@tip Set the styling for your emails preheader text. Choose a size and color that is easy to read.
						*/
							#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
								/*@editable*/color:#656565;
								/*@editable*/font-family:Helvetica;
								/*@editable*/font-size:12px;
								/*@editable*/line-height:150%;
								/*@editable*/text-align:left;
							}
						/*
						@tab Preheader
						@section Preheader Link
						@tip Set the styling for your emails preheader links. Choose a color that helps them stand out from your text.
						*/
							#templatePreheader .mcnTextContent a,#templatePreheader .mcnTextContent p a{
								/*@editable*/color:#656565;
								/*@editable*/font-weight:normal;
								/*@editable*/text-decoration:underline;
							}
						/*
						@tab Header
						@section Header Style
						@tip Set the background color and borders for your emails header area.
						*/
							#templateHeader{
								/*@editable*/background-color:#FFFFFF;
								/*@editable*/border-top:0;
								/*@editable*/border-bottom:0;
								/*@editable*/padding-top:9px;
								/*@editable*/padding-bottom:0;
							}
						/*
						@tab Header
						@section Header Text
						@tip Set the styling for your emails header text. Choose a size and color that is easy to read.
						*/
							#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
								/*@editable*/color:#202020;
								/*@editable*/font-family:Helvetica;
								/*@editable*/font-size:16px;
								/*@editable*/line-height:150%;
								/*@editable*/text-align:left;
							}
						/*
						@tab Header
						@section Header Link
						@tip Set the styling for your emails header links. Choose a color that helps them stand out from your text.
						*/
							#templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{
								/*@editable*/color:#2BAADF;
								/*@editable*/font-weight:normal;
								/*@editable*/text-decoration:underline;
							}
						/*
						@tab Body
						@section Body Style
						@tip Set the background color and borders for your emails body area.
						*/
							#templateBody{
								/*@editable*/background-color:#FFFFFF;
								/*@editable*/border-top:0;
								/*@editable*/border-bottom:2px solid #EAEAEA;
								/*@editable*/padding-top:0;
								/*@editable*/padding-bottom:9px;
							}
						/*
						@tab Body
						@section Body Text
						@tip Set the styling for your emails body text. Choose a size and color that is easy to read.
						*/
							#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
								/*@editable*/color:#202020;
								/*@editable*/font-family:Helvetica;
								/*@editable*/font-size:16px;
								/*@editable*/line-height:150%;
								/*@editable*/text-align:left;
							}
						/*
						@tab Body
						@section Body Link
						@tip Set the styling for your emails body links. Choose a color that helps them stand out from your text.
						*/
							#templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{
								/*@editable*/color:#2BAADF;
								/*@editable*/font-weight:normal;
								/*@editable*/text-decoration:underline;
							}
						/*
						@tab Footer
						@section Footer Style
						@tip Set the background color and borders for your emails footer area.
						*/
							#templateFooter{
								/*@editable*/background-color:#FAFAFA;
								/*@editable*/border-top:0;
								/*@editable*/border-bottom:0;
								/*@editable*/padding-top:9px;
								/*@editable*/padding-bottom:9px;
							}
						/*
						@tab Footer
						@section Footer Text
						@tip Set the styling for your emails footer text. Choose a size and color that is easy to read.
						*/
							#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
								/*@editable*/color:#656565;
								/*@editable*/font-family:Helvetica;
								/*@editable*/font-size:12px;
								/*@editable*/line-height:150%;
								/*@editable*/text-align:center;
							}
						/*
						@tab Footer
						@section Footer Link
						@tip Set the styling for your emails footer links. Choose a color that helps them stand out from your text.
						*/
							#templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{
								/*@editable*/color:#656565;
								/*@editable*/font-weight:normal;
								/*@editable*/text-decoration:underline;
							}
						@media only screen and (min-width:768px){
							.templateContainer{
								width:600px !important;
							}

					}	@media only screen and (max-width: 480px){
							body,table,td,p,a,li,blockquote{
								-webkit-text-size-adjust:none !important;
							}

					}	@media only screen and (max-width: 480px){
							body{
								width:100% !important;
								min-width:100% !important;
							}

					}	@media only screen and (max-width: 480px){
							#bodyCell{
								padding-top:10px !important;
							}

					}	@media only screen and (max-width: 480px){
							.mcnImage{
								width:100% !important;
							}

					}	@media only screen and (max-width: 480px){
							.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer{
								max-width:100% !important;
								width:100% !important;
							}

					}	@media only screen and (max-width: 480px){
							.mcnBoxedTextContentContainer{
								min-width:100% !important;
							}

					}	@media only screen and (max-width: 480px){
							.mcnImageGroupContent{
								padding:9px !important;
							}

					}	@media only screen and (max-width: 480px){
							.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
								padding-top:9px !important;
							}

					}	@media only screen and (max-width: 480px){
							.mcnImageCardTopImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
								padding-top:18px !important;
							}

					}	@media only screen and (max-width: 480px){
							.mcnImageCardBottomImageContent{
								padding-bottom:9px !important;
							}

					}	@media only screen and (max-width: 480px){
							.mcnImageGroupBlockInner{
								padding-top:0 !important;
								padding-bottom:0 !important;
							}

					}	@media only screen and (max-width: 480px){
							.mcnImageGroupBlockOuter{
								padding-top:9px !important;
								padding-bottom:9px !important;
							}

					}	@media only screen and (max-width: 480px){
							.mcnTextContent,.mcnBoxedTextContentColumn{
								padding-right:18px !important;
								padding-left:18px !important;
							}

					}	@media only screen and (max-width: 480px){
							.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
								padding-right:18px !important;
								padding-bottom:0 !important;
								padding-left:18px !important;
							}

					}	@media only screen and (max-width: 480px){
							.mcpreview-image-uploader{
								display:none !important;
								width:100% !important;
							}

					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Heading 1
						@tip Make the first-level headings larger in size for better readability on small screens.
						*/
							h1{
								/*@editable*/font-size:22px !important;
								/*@editable*/line-height:125% !important;
							}

					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Heading 2
						@tip Make the second-level headings larger in size for better readability on small screens.
						*/
							h2{
								/*@editable*/font-size:20px !important;
								/*@editable*/line-height:125% !important;
							}

					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Heading 3
						@tip Make the third-level headings larger in size for better readability on small screens.
						*/
							h3{
								/*@editable*/font-size:18px !important;
								/*@editable*/line-height:125% !important;
							}

					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Heading 4
						@tip Make the fourth-level headings larger in size for better readability on small screens.
						*/
							h4{
								/*@editable*/font-size:16px !important;
								/*@editable*/line-height:150% !important;
							}

					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Boxed Text
						@tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
						*/
							.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
								/*@editable*/font-size:14px !important;
								/*@editable*/line-height:150% !important;
							}

					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Preheader Visibility
						@tip Set the visibility of the emails preheader on small screens. You can hide it to save space.
						*/
							#templatePreheader{
								/*@editable*/display:block !important;
							}

					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Preheader Text
						@tip Make the preheader text larger in size for better readability on small screens.
						*/
							#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
								/*@editable*/font-size:14px !important;
								/*@editable*/line-height:150% !important;
							}

					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Header Text
						@tip Make the header text larger in size for better readability on small screens.
						*/
							#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
								/*@editable*/font-size:16px !important;
								/*@editable*/line-height:150% !important;
							}

					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Body Text
						@tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
						*/
							#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
								/*@editable*/font-size:16px !important;
								/*@editable*/line-height:150% !important;
							}

					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Footer Text
						@tip Make the footer content text larger in size for better readability on small screens.
						*/
							#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
								/*@editable*/font-size:14px !important;
								/*@editable*/line-height:150% !important;
							}

					}</style>
					</head>

					    <body>
					        <center>
					            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
					                <tr>
					                    <td align="center" valign="top" id="bodyCell">
					                        <!-- BEGIN TEMPLATE // -->
											<!--[if gte mso 9]>
											<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
											<tr>
											<td align="center" valign="top" width="600" style="width:600px;">
											<![endif]-->
					                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
					                            <tr>
					                                <td valign="top" id="templatePreheader"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
					    <tbody class="mcnImageBlockOuter">
					            <tr>
					                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
					                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
					                        <tbody><tr>
					                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
					                                
					                                    
					                                        <img align="center" alt="" src="https://gallery.mailchimp.com/26edb59c9e8422ba6b135dbee/images/93fe9128-6e04-49fe-96d7-4b1f12ae7abc.jpg" width="350" style="max-width:350px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
					                                    
					                                
					                            </td>
					                        </tr>
					                    </tbody></table>
					                </td>
					            </tr>
					    </tbody>
					</table></td>
					                            </tr>
					                            <tr>
					                                <td valign="top" id="templateHeader"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
					    <tbody class="mcnTextBlockOuter">
					        <tr>
					            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
					              	<!--[if mso]>
									<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
									<tr>
									<![endif]-->
								    
									<!--[if mso]>
									<td valign="top" width="600" style="width:600px;">
									<![endif]-->
					                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
					                    <tbody><tr>
					                        
					                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
					                        
					                            '.$message.'

					                        </td>
					                    </tr>
					                </tbody></table>
									<!--[if mso]>
									</td>
									<![endif]-->
					                
									<!--[if mso]>
									</tr>
									</table>
									<![endif]-->
					            </td>
					        </tr>
					    </tbody>
					</table></td>
					                            </tr>
					                            <tr>
					                                <td valign="top" id="templateBody"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
					    <tbody class="mcnButtonBlockOuter">
					        <tr>
					            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
					                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 3px;background-color: #2E348E;">
					                    <tbody>
					                        <tr>
					                            <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Arial; font-size: 16px; padding: 15px;">
					                                <a class="mcnButton " title="Ir a la Aplicación" href="http://'.$this->ruta_vista.'detail_proceso.php?id_proceso='.$idProceso.'" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Ir a la Aplicación</a>
					                            </td>
					                        </tr>
					                    </tbody>
					                </table>
					            </td>
					        </tr>
					    </tbody>
					</table></td>
					                            </tr>
					                            <tr>
					                                <td valign="top" id="templateFooter"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
					    <tbody class="mcnTextBlockOuter">
					        <tr>
					            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
					              	<!--[if mso]>
									<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
									<tr>
									<![endif]-->
								    
									<!--[if mso]>
									<td valign="top" width="600" style="width:600px;">
									<![endif]-->
					                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
					                    <tbody><tr>
					                        
					                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
					                        
					                            <p>Este email se ha generado automáticamente. Por favor, no conteste a este email. Si tiene alguna pregunta o necesita ayuda, por favor haga click en <a href="http://'.$this->ruta_vista.'index.php" target="_blank">Ayuda.</a></p>

					                        </td>
					                    </tr>
					                </tbody></table>
									<!--[if mso]>
									</td>
									<![endif]-->
					                
									<!--[if mso]>
									</tr>
									</table>
									<![endif]-->
					            </td>
					        </tr>
					    </tbody>
					</table></td>
					                            </tr>
					                        </table>
											<!--[if gte mso 9]>
											</td>
											</tr>
											</table>
											<![endif]-->
					                        <!-- // END TEMPLATE -->
					                    </td>
					                </tr>
					            </table>
					        </center>
					    </body>
					</html>';
		
		}

		public function setCuerpo($tipo,$pkID_proceso){

			//consulta proceso

			$this->proceso = $this->EmailDAO->getProcesoEmail($pkID_proceso);

			switch ($tipo) {

				case 'prueba':

				$this->cuerpo = ' 
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
								</html> 
								';

				break;

				//-----------------------------------------------------------------------------------------------------------------

				case 'aprobado':				

					$titulo = '<title>Proceso '.$this->proceso[0]["nom_entidad"].'/'.$this->proceso[0]["fecha_creacion"].' Aprobado</title>';
					
					$mensaje = '<h1><span style="font-size:15px">Cordial saludo, '.$this->usuario[0]["nombre"].' '.$this->usuario[0]["apellido"].'</span><br>
								<span style="font-size:19px"><strong>La aplicación Lunel IE Manager,</strong>&nbsp;</span></h1>

								<p>le informa que el proceso '.$this->proceso[0]["nom_entidad"].'/'.$this->proceso[0]["fecha_creacion"].'&nbsp;con fecha de cierre <strong>'.$this->proceso[0]["fecha_cierre"].'&nbsp;</strong><br>
								ha sido&nbsp;<strong>APROBADO</strong>.</p>

								<h3>Detalles del proceso</h3>

								<ul>
									<li><strong>Número de proceso:&nbsp;</strong>'.$this->proceso[0]["pkID"].'&nbsp;</li>
									<li><strong>Fecha de Cierre:&nbsp;</strong>'.$this->proceso[0]["fecha_cierre"].'&nbsp;</li>
									<li><strong>Objeto:&nbsp;</strong>'.$this->proceso[0]["objeto"].'&nbsp;</li>
									<li><strong>Cuantía:&nbsp;</strong>'.'$'.number_format($this->proceso[0]["cuantia"], 0, '', '.').'</li>
								</ul>';

					$this->setEmailHtml($titulo,$mensaje,$this->proceso[0]["pkID"]);				

				break;

				//-----------------------------------------------------------------------------------------------------------------

				case 'solicitud_aprobacion':

					$titulo = '<title>Solicitud de Aprobación Proceso '.$this->proceso[0]["nom_entidad"].'/'.$this->proceso[0]["fecha_creacion"].'</title>';
					
					$mensaje = '<h1><span style="font-size:15px">Cordial saludo;</span><br>
								<span style="font-size:19px"><strong>La aplicación Lunel IE Manager,</strong>&nbsp;</span></h1>

								<p>le informa que el proceso '.$this->proceso[0]["nom_entidad"].'/'.$this->proceso[0]["fecha_creacion"].'&nbsp;con fecha de cierre <strong>'.$this->proceso[0]["fecha_cierre"].'&nbsp;</strong><br>
								fue creado por '.$this->usuario[0]["nombre"].' '.$this->usuario[0]["apellido"].' y solicita la&nbsp;<strong>APROBACIóN</strong> por parte de los usuarios líder.</p>

								<h3>Detalles del proceso</h3>

								<ul>
									<li><strong>Número de proceso:&nbsp;</strong>'.$this->proceso[0]["pkID"].'&nbsp;</li>
									<li><strong>Fecha de Cierre:&nbsp;</strong>'.$this->proceso[0]["fecha_cierre"].'&nbsp;</li>
									<li><strong>Objeto:&nbsp;</strong>'.$this->proceso[0]["objeto"].'&nbsp;</li>
									<li><strong>Cuantía:&nbsp;</strong>'.'$'.number_format($this->proceso[0]["cuantia"], 0, '', '.').'</li>
								</ul>';

					$this->setEmailHtml($titulo,$mensaje,$this->proceso[0]["pkID"]);				

				break;

				//-----------------------------------------------------------------------------------------------------------------

				case 'asignado':

					$titulo = '<title>Asignación a Proceso '.$this->proceso[0]["nom_entidad"].'/'.$this->proceso[0]["fecha_creacion"].'</title>';
						
					$mensaje = '<h1><span style="font-size:15px">Cordial saludo, '.$this->usuario[0]["nombre"].' '.$this->usuario[0]["apellido"].'</span><br>
								<span style="font-size:19px"><strong>La aplicación Lunel IE Manager,</strong>&nbsp;</span></h1>

								<p>le informa que ha sido <b>ASIGNADO</b> al proceso '.$this->proceso[0]["nom_entidad"].'/'.$this->proceso[0]["fecha_creacion"].'&nbsp;con fecha de cierre <strong>'.$this->proceso[0]["fecha_cierre"].'&nbsp;</strong><br>;
								para mayor información consulte a los usuarios líder. 

								<h3>Detalles del proceso</h3>

								<ul>
									<li><strong>Número de proceso:&nbsp;</strong>'.$this->proceso[0]["pkID"].'&nbsp;</li>
									<li><strong>Fecha de Cierre:&nbsp;</strong>'.$this->proceso[0]["fecha_cierre"].'&nbsp;</li>
									<li><strong>Objeto:&nbsp;</strong>'.$this->proceso[0]["objeto"].'&nbsp;</li>
									<li><strong>Cuantía:&nbsp;</strong>'.'$'.number_format($this->proceso[0]["cuantia"], 0, '', '.').'</li>
								</ul>';

					$this->setEmailHtml($titulo,$mensaje,$this->proceso[0]["pkID"]);				

				break;

				//-----------------------------------------------------------------------------------------------------------------

				case 'reasignado':

					$titulo = '<title>Retiro de Proceso '.$this->proceso[0]["nom_entidad"].'/'.$this->proceso[0]["fecha_creacion"].'</title>';
						
					$mensaje = '<h1><span style="font-size:15px">Cordial saludo, '.$this->usuario[0]["nombre"].' '.$this->usuario[0]["apellido"].'</span><br>
								<span style="font-size:19px"><strong>La aplicación Lunel IE Manager,</strong>&nbsp;</span></h1>

								<p>le informa que ha ha sido <b>RETIRADO</b> del proceso '.$this->proceso[0]["nom_entidad"].'/'.$this->proceso[0]["fecha_creacion"].'&nbsp;con fecha de cierre <strong>'.$this->proceso[0]["fecha_cierre"].'&nbsp;</strong><br>;
								lo cual significa que ya no es el responsable de dicho proceso; para mayor información consulte a los usuarios líder. 

								<h3>Detalles del proceso</h3>

								<ul>
									<li><strong>Número de proceso:&nbsp;</strong>'.$this->proceso[0]["pkID"].'&nbsp;</li>
									<li><strong>Fecha de Cierre:&nbsp;</strong>'.$this->proceso[0]["fecha_cierre"].'&nbsp;</li>
									<li><strong>Objeto:&nbsp;</strong>'.$this->proceso[0]["objeto"].'&nbsp;</li>
									<li><strong>Cuantía:&nbsp;</strong>'.'$'.number_format($this->proceso[0]["cuantia"], 0, '', '.').'</li>
								</ul>';

					$this->setEmailHtml($titulo,$mensaje,$this->proceso[0]["pkID"]);				

				break; 

			};
		}

		public function setAsunto($tipo){

			switch ($tipo) {

				case 1:

				$this->asunto = 'Aprobación de Proceso';

				break;

				case 2:

				$this->asunto = 'Solicitud de Aprobación de Proceso';

				break;

				case 3:

				$this->asunto = 'Asignación a Proceso';

				break;

				case 4:

				$this->asunto = 'Retiro de Proceso';

				break;   

			};
		}

		//---------------------------------------------------------------------------------------
		//Funcion para enviar correo de aprobacion de proyecto
		public function sendEmail($pkID_usuario,$tipo_asunto,$tipo_cuerpo,$pkID_proceso){

			if ($tipo_asunto==1) {
				# code...
				$this->usuario = $this->EmailDAO->getUsuarioEmail($pkID_usuario);

				$this->destinatario = $this->usuario[0]["email"];

			} else if ($tipo_asunto==2){
				# code...

				$this->usuario = $this->EmailDAO->getUsuarioEmail($pkID_usuario);

				array_push($this->destinatarios, $this->usuario[0]["email"]);

				//y agregarle los usuarios que son de tipo lider
				//y dejarlos en un string separados por ,

				$this->usuariosLider = $this->EmailDAO->getUsuariosLiderEmail();

				for ($i=0; $i<sizeof($this->usuariosLider); $i++) { 
					# code...
					array_push($this->destinatarios, $this->usuariosLider[$i]["email"]);
				}

				$this->destinatario =  implode(",", $this->destinatarios);

			} else if ($tipo_asunto==3){

				$this->usuario = $this->EmailDAO->getUsuarioEmail($pkID_usuario);

				$this->destinatario = $this->usuario[0]["email"];

			}else if ($tipo_asunto==4){

				$this->usuario = $this->EmailDAO->getUsuarioEmail($pkID_usuario);

				$this->destinatario = $this->usuario[0]["email"];
			}			

			$this->setHeaders();

			$this->setCuerpo($tipo_cuerpo,$pkID_proceso);

			$this->setAsunto($tipo_asunto);

			//-----------------------------------------------------------------------------------

			if (mail($this->destinatario,$this->asunto,$this->cuerpo,$this->headers)) {
				# code...
				$this->r["estado"] = "ok";
	 			$this->r["mensaje"] = "El correo se envio correctamente a ".$this->destinatario;

			}else{
				$this->r["estado"] = "error";
	 			$this->r["mensaje"] = "El correo no se pudo enviar a ".$this->destinatario;
			};

			//-----------------------------------------------------------------------------------

			return $this->r;
		}

		
	}
?>
