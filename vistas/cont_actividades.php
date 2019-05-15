<?php
	
	/**/
	
	include('../controller/actividadesController.php');

	include('../controller/gastos_gralController.php');

  include("../controller/proyectosController.php");    

    
	
	$actividadesInst = new actividadesController();
	$gasto_gralInst = new gastos_gralController();
  $proyectoInst = new proyectosController();

  $pkID_proyecto = $_GET["id_proyecto"];

  $proyectoGen = $proyectoInst->getProyectoId($pkID_proyecto);
	
	$arrPermisos = $actividadesInst->permisos($id_modulo,$_COOKIE['log_lunelAdmin_IDtipo']);
	
	$crea = $arrPermisos[0]['crear'];

	//echo "esto es actividades...";
?>


<!-- Modal -->
<div class="modal fade" id="form_modal_actividad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="lbl_form_actividad">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_actividad" method="POST">                
            <br>
                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>
                                                       
                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre</label>                        
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la actividad" required = "true">                        
                </div>

                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="subtotal" name="subtotal" required = "true">
                </div>
                
            
                <div class="form-group">
                    <label for="subtotal" class="control-label">Sub-Total</label>            
                    
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="subtotal_mask" type="text" class="form-control" required="true">                      
                    </div>

                </div>

                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="iva" name="iva" required = "true">
                </div>
                
                <div class="form-group">
                    <label for="iva_mask" class="control-label">IVA</label>            
                    
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="iva_mask" type="text" class="form-control" required="true">                      
                    </div>

                </div>

                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="total" name="total" required = "true">
                </div>

                <div class="form-group">
                    <label for="total_mask" class="control-label">Total</label>            
                    
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="total_mask" type="text" class="form-control" readonly="true" required="true">                      
                    </div>

                </div>                

                <div class="form-group" hidden="true">
                  <input name="fkID_proyecto" type="text" class="form-control" required="true" value=<?php echo $pkID_proyecto ?>>
                </div>  
        </form>
                
      </div>

      <div class="modal-footer">    
        <button id="btn_actionactividad" type="button" class="btn btn-primary" data-action="-">
            <span id="lbl_btn_actionactividad">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div>

<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
        
            <div class="panel panel-default titulo-barra-amarilla">
                <div class="icono_"></div>
                  <div class="panel-body">
                    Actividades
                  </div>
            </div>                
        </div>
        <!-- /.col-lg-12 -->

        <div class="col-lg-12 rowproy-det">
          <ol class="breadcrumb">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="proyectos.php">Proyectos</a></li>
            <li><a href=<?php echo "detail_proyecto.php?id_proyecto=".$pkID_proyecto."&filter_gastos=*&filter_documentos=*" ?>>Detalle de Proyecto: <?php echo $proyectoGen[0]["nombre"] ?></a></li>
            <li class="active">Actividades <?php //echo $proyectoGen[0]["nombre"] ?> </li>
          </ol>
      </div>

    </div>
    <!-- /.row -->

    <div class="row rowform">                
       
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
            <div class="panel-body2">
                
                <div class="panel-heading">

                    

                    <div class="row">
                      <div class="col-md-6">
                          Registro de Actividades para Proyectos Lunel-IE
                      </div>
                      <div class="col-md-6 text-right">
                          <button id="btn_nuevoactividad" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#form_modal_actividad" <?php if ($crea != 1){echo 'disabled="disabled"';} ?> ><span class="glyphicon glyphicon-plus"></span>&nbspCrear Actividad</button> 
                      </div>
                    </div>

                </div>
                <!-- /.panel-heading -->

                <div class="panel-body">
                    <div class="dataTable_wrapper table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tbl_actividades">
                            <thead>
                                <tr>
                                    <th class="tabla-form-ancho">ID</th>
                                    <th class="tabla-form-ancho">Nombre</th>
                                    <th class="tabla-form-ancho">Sub-Total</th>
                                    <th class="tabla-form-ancho">IVA</th>
                                    <th class="tabla-form-ancho">Total</th>
                                    <th class="tabla-form-ancho">Proyecto</th>
                                    <th class="tabla-form-ancho">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                      //print_r($_COOKIE); 
                                      $actividadesInst->getTablaActividadesProyecto($pkID_proyecto);                           
                                   ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                
                </div>
                <!-- /.panel-body -->
                </div>
                <!-- /.panel-body2 -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->


</div>

<!-- /#page-wrapper -->
