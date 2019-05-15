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
                <a class="navbar-brand" href="index.php">Lunel-IE Manager</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <?php echo $nombre ?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <!--<li><a href="#"><i class="fa fa-user fa-fw"></i> </a>
                        </li>-->
                        <li class="dropdown-header">Configuración</li>
                        <li><a href="usuarios.php"><i class="fa fa-user fa-fw"></i> <ins>Usuarios</ins></a>
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
    

            <!--
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">                        
                        <li>
                            <a href="index.php"><i class="fa fa-home fa-fw"></i> Inicio</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-file fa-fw"></i> Documentación<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="hvida.php"><i class="fa fa-briefcase fa-fw"></i> Hojas de Vida</a>
                                </li>                                
                            </ul>                            
                        </li>                        
                    </ul>
                </div>                        
            </div>
            -->

            <!-- /.navbar-static-side -->
        </nav>