<?php 
    include("../controller/hvidaController.php");    
    include("../controller/formatosController.php");
    include("../controller/proyectosController.php");
    include("../controller/procesosController.php");    

    $hvidainst = new HvidaController();
    $formatoinst = new FormatoController();
    $proyectosinst = new proyectosController();
    $procesosinst = new procesosController();


    $tipoUsuario = $_COOKIE['log_lunelAdmin_IDtipo'];
 ?>

<div id="page-wrapper">
            
            <div class="row">
                <div class="col-lg-12">
                    <!-- /Barrita amarilla -->
                    <div class="panel panel-default titulo-barra-amarilla">
                    <div class="icono_index"></div>
                      <div class="panel-body">
                        Menú Principal
                      </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
       
            
        <div class="row">            
          
            <div class="menu-principal">
                    
                <div class="col-md-6">

                    <?php if(($tipoUsuario == 1) || ($tipoUsuario == 3) || ($tipoUsuario == 4) || ($tipoUsuario == 8) || ($tipoUsuario == 9) || ($tipoUsuario == 14) ){?>  
                    <div  class="col-md-4 ajuste_index">
                        <a class="" href="procesos.php">
                            <img src="../img/b-procesos.png" alt="Procesos" >                    
                        </a>                
                    </div>
                    <?php } ?>

                    <!-- links nuevos-->
                    <?php if(($tipoUsuario == 1) || ($tipoUsuario == 10) || ($tipoUsuario == 13) ){?> 
                    <div class="col-md-4 ajuste_index">
                        <a class="" href="ingresos_gral.php?filter=*">
                            <img src="../img/b-ingresos.png" alt="Facturas" >                        
                        </a>                
                    </div>
                    <?php } ?>


                    <?php 
                        if(($tipoUsuario == 1) || ($tipoUsuario == 2) || ($tipoUsuario == 10) || ($tipoUsuario == 13) ){
                    ?>
                    <div class="col-md-4 ajuste_index">
                        <a class="" href="gastos_gral.php?filter=gasto_gral.aprobado=0">
                            <img src="../img/b-gastos.png" alt="Gastos" >
                        </a>                
                    </div>
                    <?php } ?>

                    <?php 
                        if(($tipoUsuario == 1) || ($tipoUsuario == 4) || ($tipoUsuario == 8) || ($tipoUsuario == 11) || ($tipoUsuario == 13) ){
                    ?>
                     <div class="col-md-4 ajuste_index">
                        <a class="" href="proyectos.php?filter=*">
                            <img src="../img/b-proyectos.png" alt="Proyectos" >                        
                        </a>
                    </div>
                    <?php } ?>


                     <?php if($tipoUsuario == 1 || $tipoUsuario == 12 || $tipoUsuario == 13){?>
                    <div class="col-md-4 ajuste_index">
                        <a class="" href="repositorio.php">
                            <img src="../img/b-repositorio.png" alt="Repositorio">
                        </a>                
                    </div>     
                    <?php } ?>           
                   

                   <?php 
                        if(($tipoUsuario == 1) || ($tipoUsuario == 4) || ($tipoUsuario == 8) || ($tipoUsuario == 9) || ($tipoUsuario == 10) ){
                    ?>
                    <div class="col-md-4 ajuste_index">
                        <a class="" href="formatos.php">
                            <img src="../img/b-formatos.png" alt="Formatos" >                    
                        </a>
                    </div>
                    <?php } ?>

                    
                    <?php if($tipoUsuario == 1 || $tipoUsuario == 2 || $tipoUsuario == 3 || $tipoUsuario == 4 || $tipoUsuario == 5 || $tipoUsuario == 8 || $tipoUsuario == 9 || $tipoUsuario == 10 || $tipoUsuario == 11 || $tipoUsuario == 13 || $tipoUsuario == 14){?>
                    <div class="col-md-4 ajuste_index">
                        <a class="" href="hvida.php?s=*">
                            <img src="../img/b-hojasdevida.png" alt="Hojas de Vida">                    
                        </a>
                    </div> 
                    <?php } ?>           

                     <?php if($tipoUsuario == 1 || $tipoUsuario == 8 || $tipoUsuario == 9 || $tipoUsuario == 10 || $tipoUsuario == 13){?>
                    <div class="col-md-4 ajuste_index">
                        <a class="" href="contactos.php">
                            <img src="../img/b-contactos.png" alt="Contactos" >
                        </a>                
                    </div>     
                    <?php } ?>              


                    <?php 
                        if(($tipoUsuario == 1) || ($tipoUsuario == 8) || ($tipoUsuario == 9) || ($tipoUsuario == 10) || ($tipoUsuario == 13) || ($tipoUsuario == 14)){
                    ?>
                    <div class="col-md-4 ajuste_index">
                        <a class="" href="empresa.php">
                            <img src="../img/b-empresas.png" alt="Repositorio">
                        </a>                
                    </div>
                    <?php } ?>

                    <?php 
                        if(($tipoUsuario == 1)){
                    ?>
                    <div class="col-md-4 ajuste_index">
                        <a class="" href="contrasenas.php">
                            <img src="../img/b-contrasena.png" alt="Contraseñas" >
                        </a>                
                    </div>
                    <?php } ?>

                     <?php if($tipoUsuario == 1 || $tipoUsuario == 8){?>
                    <div class="col-md-4 ajuste_index">
                        <a class="" href="reuniones.php?filter=*">
                            <img src="../img/icono-reuniones.png" alt="Reuniones" >
                        </a>                
                    </div>
                    <?php } ?> 

                    <?php if($tipoUsuario == 1 || $tipoUsuario == 8){?>
                    <div class="col-md-4 ajuste_index">
                        <a class="" href="recursos.php?filter=*">
                            <img src="../img/icono-recursos.png" alt="Recursos" >
                        </a>                
                    </div>
                    <?php } ?> 
                 <!-- ./.col-md-6 fichas-->   
                </div>

                <div class="col-md-6">

                    <div class="panel panel-default">
                      <div class="panel-heading titulos-panel"><div class="icono_notificaciones"></div>Notificaciones de Procesos</div>
                      <div class="panel-body">
                        <!--Panel content-->
                        <?php  $procesosinst->notIndexProcesos(); ?>
                      </div>
                    </div>

                    <div class="panel panel-default" hidden="true">
                      <div class="panel-heading titulos-panel"><div class="icono_profesionales"></div>Profesionales Disponibles</div>
                      <div class="panel-body">
                        <!--Panel content-->
                        <div id="morris-bar-chart"></div>
                      </div>
                    </div>
    
                <!-- ./.col-md-6 paneles--> 
                </div>


                <!--Notificaciones Proceso Selección Abreviada de Menor Cuantía-->
                <div class="col-md-6">

                    <div class="panel panel-default">
                      <div class="panel-heading titulos-panel"><div class="icono_notificaciones"></div>Notificaciones Procesos : Selección Abreviada de Menor Cuantía</div>
                      <div class="panel-body">
                        <!--Panel content-->
                        <?php  $procesosinst->notIndexProcesoSAdMC(); ?>
                      </div>
                    </div>

                    <div class="panel panel-default" hidden="true">
                      <div class="panel-heading titulos-panel"><div class="icono_profesionales"></div>Profesionales Disponibles</div>
                      <div class="panel-body">
                        <!--Panel content-->
                        <div id="morris-bar-chart"></div>
                      </div>
                    </div>
    
                <!-- ./.col-md-6 paneles--> 
                </div>
             
             <!-- ./menu-principal -->   
            </div>

        <!-- /.row -->      
        </div> 
    
</div>
<!-- /#page-wrapper -->
