<?php 

  
  /*ini_set('error_reporting', E_ALL|E_STRICT);
  ini_set('display_errors', 1);
  */
    include("../controller/reunionesController.php");    

    $inst = new reunionesController();

    $pkID_reunion = $_GET["id_reunion"];

    $fecha = $inst->getReunion($pkID_reunion);

    $f = $fecha[0]["fecha_realizacion"];

    $moderador = $fecha[0]["fkID_moderador"];

    $var = $inst->getCompromisosReuniones($pkID_reunion);

    $fkID_usuario = $var[0]["fkID_usuario"];


    $estado = $inst->getCompromisosReuniones($pkID_reunion);


    $tipo_usuario = $_COOKIE["log_lunelAdmin_IDtipo"];

    $id_user = $_COOKIE["log_lunelAdmin_id"];

    include("modal_compromiso.php");
    include("form_novedades.php");
?>


<div id="page-wrapper">

  <div class="row">

      <div class="col-lg-12">          
          <div class="panel panel-default titulo-barra-amarilla">
          <div class=""></div>
            <div class="panel-body">
              Reunión # : <?php echo $pkID_reunion;?><br>
              Fecha de Realización : <?php echo $f;?> 
            </div>
          </div> 
      </div>        
      <!-- /.col-lg-12 -->

      <div class="col-lg-12 ">
          <ol class="breadcrumb">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="reuniones.php?filter=*">Reuniones</a></li>
            <li class="active">Detalles Reunión # : <?php echo $pkID_reunion;?>  ---  Fecha de Realización : <?php echo $f; ?> </li>
          </ol>
      </div>

  <div class="row">

      <div class="col-lg-12">

      <!-- Nav tabs -->
      <ul class="nav nav-tabs tabs-proc3" role="tablist">
          <li id="li_general"  role="presentation"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a></li>          
          <li id="li_compromisos" role="presentation"><a href="#compromisos" aria-controls="general" role="tab" data-toggle="tab">Compromisos</a></li>          
      </ul>
          <!-- Tab panes -->
        <div class="tab-content">


            <div role="tabpanel" class="tab-pane" id="general">
              <br>
              <!-- contenido general -->
              <div class="panel panel-default proc-pan-def3">
                <div class="panel-body">

                  
                    <?php
                       $inst->getDataReunionGen($pkID_reunion); 
                    ?>
                 

                </div>
              </div>
              <!-- /.contenido general -->
            </div>

        
            <div role="tabpanel" class="tab-pane" id="compromisos">
              <br>
              <!-- contenido general -->
              <div class="panel panel-default detl-proc4 def-proc5">
                <div class="panel-body">
                  <!-- instancia php controller -->               
                  <br>
                  <div class="panel panel-default proc-detl6">

                    <!-- /.panel-heading -->
                    
                    <div class="panel-body">

                    <div class="dataTable_wrapper table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="tbl_compromisos">
                          <thead>
                              <tr>
                                  <th>Participante</th>                                  
                                  <th>Fecha de Cumplimiento</th>
                                  <th>Descripción</th>
                                  <th>Estado</th>
                                                                                       
                                  <th data-orderable="false" class="tabla-form-ancho">Opciones</th> 
                              </tr>
                          </thead>
                          <tbody>
                             <?php 
                                    $inst->getTablaCompromisosReunion($pkID_reunion, $tipo_usuario, $id_user); 
                              ?>
                          </tbody>
                      </table>
                    </div>                      
                    
                    </div>
                    <!-- /.panel-body -->
                  
                  </div>
                  <!-- /.panel -->                     

                </div>

              </div>
              <!-- /.contenido general -->

            </div>

       

       </div>

      </div>

  </div>
  <!-- /.row -->

</div>