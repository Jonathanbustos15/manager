<?php
  
  /**/
  
  include('../controller/ingresos_gralController.php');
  
  //include('../conexion/datos.php');
  include('../controller/gastos_gralController.php');  
  
  $gastos_gralInst = new gastos_gralController();

  $ingresos_gralInst = new ingresos_gralController();
  
  $arrPermisos = $ingresos_gralInst->permisos($id_modulo,$_COOKIE['log_lunelAdmin_IDtipo']);
  
  $crea = $arrPermisos[0]['crear'];

  $filtro = $_GET["filter"];
  
  $tipoUsuario = $_COOKIE['log_lunelAdmin_IDtipo'];
  //echo $tipoUsuario;
  //print_r($arrPermisos)
?>
<!-- Modal -->
<div class="modal fade" id="form_modal_ingreso_gral" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_ingreso_gral">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_ingreso_gral" method="POST">                
            <br>
                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>

        
              <?php if($tipoUsuario != 13){?>
                <div class="form-group">
                    <label for="fkID_empresa" class="control-label">Empresa</label>                                            
                    <?php
                      $ingresos_gralInst->getSelectEmpresas();
                     ?>                    
                    <button id="btn_nuevoempresa" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_empresa"><span class="glyphicon glyphicon-plus"></span></button>
                </div>
              <?php }else{ ?>
                        <div class="form-group" hidden="true">
                            <input type="text" class="form-control" id="fkID_empresa" name="fkID_empresa" value="2">
                        </div>
                      
              <?php }  ?>


                <div class="form-group">
                    <label for="fkID_externo" class="control-label">Fuente</label>                
                    <?php
                        if($tipoUsuario == 13){
                          $ingresos_gralInst->getSelectProyectosFuntecso();
                        }else{
                          $gastos_gralInst->getSelectProyectos();
                        }
                     ?>
                     <!--<button id="btn_nuevoexterno" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_externo"><span class="glyphicon glyphicon-plus"></span></button>-->
                </div>        
                    
                <div class="form-group">
                    <label for="descripcion" class="control-label">Descripción</label>                        
                    <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción del ingreso" required = "true"></textarea>
                </div>

                <div class="form-group">
                    <label for="fecha_radicacion" class="control-label">Fecha de Radicacion</label>                        
                    <input type="text" class="form-control" id="fecha_radicacion" name="fecha_radicacion" placeholder="Fecha de radicacion" >                        
                </div>
                
                
                <div class="form-group" hidden="true"> <!--  hidden="true"-->
                  <input type="text" class="form-control" id="subtotal" name="subtotal" required="true">
                </div>

                <div class="form-group">
                    
                    <label for="subtotal" class="control-label">Subtotal</label>                
                    
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="subtotal_mask" type="text" class="form-control">                      
                    </div>

                </div>

                <div class="form-group" hidden="true"> <!--  hidden="true"-->
                  <input type="text" class="form-control" id="iva" name="iva" required = "true">
                </div><!---->
                
                <div class="form-group form-inline">

                    <label for="iva" class="control-label tax_label">IVA</label>            
                                        
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="iva_mask" type="text" class="form-control tax_mask" >                      
                    </div>

                    <!--<div class="input-group">
                      <span class="input-group-addon">%</span>
                      <input id="iva_percent" type="number" class="form-control tax_percent">                      
                    </div>-->

                </div>

                <div class="form-group" hidden="true"> <!-- hidden="true" -->
                  <input type="text" class="form-control" id="total" name="total" required="true">
                </div>

                <div class="form-group">
                    
                    <label for="total" class="control-label">Total</label>                
                    
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="total_mask" type="text" class="form-control" readonly="true">                      
                    </div>

                </div>

                <div id="ingreso_hide">

                  <hr>

                  <div class="form-group">
                    <label for="pagado" class="control-label">Pagado</label> 
                    <select name="pagado" id="pagado" class="form-control" value="0">
                      <option id="no" value="0">No</option>
                      <option value="1">Sí</option>
                    </select>
                 </div>
                  

                </div>
                 
                
                <div id="rete_hide">

                    <div class="form-group">
                      <label for="fecha_pago" class="control-label">Fecha de Pago</label>                        
                      <input type="text" class="form-control" id="fecha_pago" name="fecha_pago" placeholder="Fecha de pago" >                        
                    </div>
                    <hr>                    

                    <h3>Retenciones</h3>

                    <div class="form-group form-inline">
                    
                        <label for="rete_iva" class="control-label tax_label">Reteiva</label>
                        <div class="form-group div-hide-control" > <!--  hidden="true"-->
                          <input type="text" class="form-control" id="rete_iva" name="rete_iva">
                        </div>                
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input id="rete_iva_mask" type="text" class="form-control tax_mask" readonly="true">                      
                        </div>
                        <div class="input-group">
                          <span class="input-group-addon">%</span>
                          <input id="rete_iva_percent" type="number" class="form-control tax_percent">                      
                        </div>

                    </div>

                    <div class="form-group">
                    
                        <label for="rete_ica" class="control-label">Reteica</label>                
                        <div class="form-group" hidden="true"> <!--  hidden="true"-->
                          <input type="text" class="form-control rete-val" id="rete_ica" name="rete_ica">
                        </div> 
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input id="rete_ica_mask" type="text" class="form-control rete-mask">                      
                        </div>

                    </div>                    

                    <div class="form-group">
                    
                        <label for="retefuente" class="control-label">Retefuente</label>                
                        <div class="form-group" hidden="true"> <!--  hidden="true"-->
                          <input type="text" class="form-control rete-val" id="rete_fuente" name="rete_fuente">
                        </div>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input id="rete_fuente_mask" type="text" class="form-control rete-mask">                      
                        </div>

                    </div>

                    <div class="form-group">
                    
                        <label for="otra_retencion" class="control-label">Otra Retención</label>                
                        <div class="form-group" hidden="true"> <!--  hidden="true"-->
                          <input type="text" class="form-control rete-val" id="otra_retencion" name="otra_retencion">
                        </div>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input id="otra_retencion_mask" type="text" class="form-control rete-mask">
                        </div>

                    </div>

                    <hr>


                    <div class="form-group">
                    
                        <label for="total_retencion" class="control-label">Total Retenido</label>                
                        <div class="form-group" hidden="true"> <!--  hidden="true"-->
                          <input type="text" class="form-control" id="total_retencion" name="total_retencion" value="0">
                        </div>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input id="total_retencion_mask" type="text" class="form-control">
                        </div>

                    </div>

                    <div class="form-group">
                    
                        <label for="total_recibido" class="control-label">Total Recibido</label>                
                        <div class="form-group" hidden="true"> <!--  hidden="true"-->
                          <input type="text" class="form-control" id="total_recibido" name="total_recibido" value="0">
                        </div>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input id="total_recibido_mask" type="text" class="form-control">
                        </div>

                    </div>

                    <hr>

                </div>


                <div class="form-group">
                  <label for="pagado_impuesto" class="control-label">Declarado</label> 
                  <select name="pagado_impuesto" id="pagado_impuesto" class="form-control">
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="fkID_periodo" class="control-label">Periodo</label> 
                    <?php
                      $ingresos_gralInst->getSelectPeriodo();
                     ?>                  
                </div>

                <div class="form-group" hidden>                     
                   <div class="col-sm-10">
                       <input type="text" class="form-control" id="anio" name="anio">
                   </div>
               </div>

        </form>

                
      </div>
      
      <div class="modal-footer">    
        <button id="btn_actioningreso_gral" type="button" class="btn btn-primary" data-action="-">
            <span id="lbl_btn_actioningreso_gral">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div>

<?php 
  include("modal_empresas.php");
  //include("modal_externo.php");
 ?>  
<!-- /form modal 2-->

<div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                
                    <div class="panel panel-default titulo-barra-amarilla">
                        <div class="icono_"></div>
                          <div class="panel-body">
                            Facturas
                          </div>
                    </div>
                    

                </div>
                <!-- /.col-lg-12 -->
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
                              
                              <div class="col-md-10">
                                   
                              </div>

                              <div class="col-md-2 text-right">
                                                                           
                                  
                                  <button id="btn_nuevoingreso_gral" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#form_modal_ingreso_gral" <?php if ($crea != 1){echo 'disabled="disabled"';} ?> ><span class="glyphicon glyphicon-plus"></span>&nbspCrear Factura</button> 
                              </div>
                              
                              <!-- ./FILTRO ingresos-->
                              <div class="col-md-12 text-left form-inline">
                                <br>
                                  <h4 class="text-left"><span class="glyphicon glyphicon-filter"></span><strong>Filtro</strong></h4>
                                  
                                  <?php 
                                  if($tipoUsuario != 13){ 
                                  
                                ?>
                                  <label for="empresa_filtro" class="control-label">Empresas</label>                                            
                                    <?php
                                        $gastos_gralInst->getSelectEmpresasFiltro();
                                     }?>

                                  <label for="fuente_filtro" class="control-label">Fuente</label>      
                                   <?php
                                      if($tipoUsuario == 13){
                                       $gastos_gralInst->getSelectProyectosFuntecso();
                                      }else{
                                        $gastos_gralInst->getSelectProyectosFiltro();
                                      }
                                   ?>                                
                                     
                                           
                               

                                <label for="pagado_filtro" class="control-label">Pagado</label> 
                                
                                <select name="pagado_filtro" id="pagado_filtro" class="form-control">
                                  <option></option>
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>


                                <label for="pagado_impuesto_filtro" class="control-label">Declarado</label> 
                                <select name="pagado_impuesto_filtro" id="pagado_impuesto_filtro" class="form-control">
                                  <option></option>
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>

                                
                                <?php
                                    if($tipoUsuario != 13){ ?>
                                <label for="fechas_filtro" class="control-label">Año</label>                                            
                                <?php
                                    $ingresos_gralInst->getSelectAnio();
                                  }
                                ?>
                                <br><br>
                                 <?php
                                    if($tipoUsuario != 13){ ?>
                                <label for="periodo_filtro" class="control-label">Periodo</label>                                            
                                <?php
                                    $ingresos_gralInst->getSelectPeriodoFiltro();
                                  }
                                ?>

                                &nbsp &nbsp &nbsp
                                <button class="btn btn-success" id="btn_filtrar"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
                                
                                <hr>

                              </div>
                              <!-- ./filtro ingresos-->

                              

                            </div>

                        </div>
                        <!-- /.panel-heading -->

                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="tbl_ingresos_gral">
                                    <thead>
                                        <tr>
                                            <!--<th class="tabla-form-ancho">ID</th>-->
                                            <th class="tabla-form-ancho">Empresa</th>
                                            <th class="tabla-form-ancho">Fuente</th>                                            
                                            <th class="tabla-form-ancho">Descripción</th>
                                            <th class="tabla-form-ancho2">Pagado</th>
                                            <th class="tabla-form-ancho2" hidden="true">Ficti</th>
                                            <th class="tabla-form-ancho">Fecha Radicacion</th>
                                            <th class="tabla-form-ancho">Fecha Pago</th>
                                            <th class="tabla-form-ancho">Valor Facturado</th>
                                            <th class="tabla-form-ancho">Valor Recibido</th>
                                            <th data-orderable="false">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                              //print_r($_COOKIE); 
                                              if($tipoUsuario == 13){
                                                $ingresos_gralInst->getTablaingresos_gralFuntecso($filtro); 
                                              }else{  
                                                $ingresos_gralInst->getTablaingresos_gral($filtro); 
                                              }                          
                                           ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            
                            <div class="col-md-12 text-right">
                            <br>
                              <form class="form-inline">
                                
                                <label for="total_ingresos" class="control-label">Valor Pagado</label>                                
                                <div class="input-group">
                                  <span class="input-group-addon">$</span>
                                  <input type="text" class="form-control" id="total_ingresos" name="total_ingresos" readonly="true" value=<?php $ingresos_gralInst->getSumaIngresosVal($filtro); ?>>
                                </div>
                                
                              </form>
                            </div>
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