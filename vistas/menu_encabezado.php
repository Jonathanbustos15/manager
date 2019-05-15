<?php

    $nombre = $_COOKIE["log_lunelAdmin_nombre"];
    $alias = $_COOKIE["log_lunelAdmin_alias"];
    $tipo = $_COOKIE["log_lunelAdmin_tipo"];
 ?>
      <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="index.php"><img class="logo_header" src="../img/logo-limanager1.png" alt="Proyectos" height="100%" width="80%"></a>
                Versión 1.0
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right usuario-top">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <!--<i class="fa fa-user fa-fw"></i>--> <?php echo "Hola, ".$nombre ?> <img src="../img/user-icon.png" height="35" width="35">  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <!--<li><a href="#"><i class="fa fa-user fa-fw"></i> </a>
                        </li>-->
                        <li class="dropdown-header">Configuración</li>

                        <?php 

                            if ( $tipo == "Administrador" ) {
                                # code...
                                echo '<li><a href="usuarios.php"><i class="fa fa-user fa-fw"></i> <ins>Usuarios</ins></a>';
                                echo '<li><a href="roles.php"><i class="fa fa-wrench fa-fw"></i> <ins>Roles</ins></a>';
                            }else{
                                echo '<li><a href="usuarios.php"><i class="fa fa-user fa-fw"></i> <ins>Editar Perfil</ins></a>';
                            }
                         ?>                        

                        <li class="dropdown-header">Tipo de Usuario</li>
                        <li><a href="#"><i class="fa fa-tag fa-fw"></i> <?php echo $tipo ?></a></li>                        
                        <li class="divider"></li>
                        <li><a href="../controller/logout.php"><i class="fa fa-sign-out fa-fw"></i> <ins>Salir</ins></a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

        </nav>