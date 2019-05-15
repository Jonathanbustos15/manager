<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Lunel-IE Manager</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../img/favicon.ico" />
    
    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../dist/css/estilos_lunel-man.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="../bower_components/jquery/dist/jquery.js"></script>
    <script>
        $(function(){
            //console.log('hola login')
            //console.log($(".container"))
            $("body").css('overflow', 'hidden');
        });
    </script>
</head>

<body class="body-login">

    <div class="row">
        <div class="col-sm-6">
            <img src="../img/img-login-limanager.jpg" alt="Formatos" class="img-thumbnail">
        </div>
        <div class="col-sm-6">

            <div class="login-panel panel panel-default login-marg-top">
	                 
                <div class="logologin">
                    <img src="../img/logo-limanager-horizontal.jpg" alt="Formatos" height="100%" width="100%">   
                </div>

	                  
                <div class="panel-body">
                    <form role="form" action="../controller/login_autentica.php" method="POST">
                        <fieldset>
	                       <div class="form-group">
	                           <input id="username" name="username" class="form-control" placeholder="Usuario" type="text" autofocus>
	                       </div>
	                       <div class="form-group">
	                           <input id="password" name="password" class="form-control" placeholder="Contraseña" type="password" value="">
	                       </div>
	                                
	                       <!-- Change this to a button or input when using this as a form --> 
	                       <button id="btn_login" class="btn btn-lg btn-success btn-block">Ingresar</button>                               
                        </fieldset>
	                   <div class="form-group text-center">
	                       <br>
	                   </div>
	               </form>
                </div>
            </div>

        </div>
    </div>

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
