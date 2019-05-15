<?php
	
	/**/
	
	include('../controller/repositorioController.php');	
	
	$detail_repositorioInst = new repositorioController();
	
	$arrPermisos = $detail_repositorioInst->permisos($id_modulo,$_COOKIE['log_lunelAdmin_IDtipo']);
	
	$crea = $arrPermisos[0]['crear'];
	
	//echo "Hola por aca...";
  $pkID_repositorio = $_GET["id_repositorio"];
  //echo $pkID_repositorio;
  $data_repositorio = $detail_repositorioInst->getRepositorioId($pkID_repositorio);
  //print_r($data_repositorio);
?>

<!-- Modal -->
<div class="modal fade" id="form_modal_detail_repositorio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_detail_repositorio">-</h4>
      </div>
      <div class="modal-body">
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
        <!-- Nav tabs -->            

          <div role="tabpanel" class="tab-pane active" id="datosGenerales">
          <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
            <form id="form_detail_repositorio" method="POST">                
                <br>
                    <div class="form-group" hidden>                     
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pkID" name="pkID">
                        </div>
                    </div>                                       
                    <div class="form-group" hidden>                     
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fkID_repositorio" name="fkID_repositorio" value=<?php echo $data_repositorio[0]["pkID"]?> >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="control-label">Nombre</label>                        
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Archivo" required = "true">                        
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label">Tipo</label>                    
                        <?php
                          $detail_repositorioInst->getSelectTipoRepositorio();
                         ?>
                    </div>

                    <div class="form-group">
                        <label for="descripcion" class="control-label">Descripción</label>                    
                        <textarea  class="form-control" id="descripcion" name="descripcion" placeholder="Descripción del Archivo" required = "true"></textarea>                       
                    </div>
                                                                
                    <div class="form-group">
                        <label class="control-label">Archivo</label>                        
                        <input type="file" class="form-control" id="archivo" name="archivo"> 
                        <input type="hidden" name="url_archivo" id="url_archivo" required="true">                       
                    </div>
                 
            </form>
			
			<!---->
            <div id="not_subida" class="alert alert-info">
        
      		</div>
          <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
          </div>               
               
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--> 
        <button id="btn_actiondetail_repositorio" type="button" class="btn btn-primary" data-action="-">
            <span id="lbl_btn_actiondetail_repositorio">-</span>
        </button>
      </div>
    </div>
  </div>
</div>
<!-- /form modal 2-->

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->

<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
        
            <div class="panel panel-default titulo-barra-amarilla">
                <div class="icono_"></div>
                  <div class="panel-body">
                    Archivos de Repositorio <?php echo "'".$data_repositorio[0]["nombre"]."'" ?>
                  </div>
            </div>

            <div class="col-lg-12">
                <ol class="breadcrumb">
                  <li><a href="index.php">Inicio</a></li>
                  <li><a href="repositorio.php">Repositorio</a></li>
                  <li class="active">Detalles Repositorio</li>
                </ol>
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
                      <div class="col-md-6">
                          Archivos Repositorio
                      </div>
                      <div class="col-md-6 text-right">
                          <button id="btn_nuevodetail_repositorio" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#form_modal_detail_repositorio" <?php if ($crea != 1){echo 'disabled="disabled"';} ?> ><span class="glyphicon glyphicon-plus"></span>&nbspCrear Archivo</button> 
                      </div>
                    </div>

                </div>
                <!-- /.panel-heading -->

                <div class="panel-body">
                    <div class="dataTable_wrapper table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tbl_detail_repositorio">
                            <thead>
                                <tr>                                                                        
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Descripcion</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                      //print_r($_COOKIE); 
                                      $detail_repositorioInst->getTablaArchivosRepositorio($pkID_repositorio);                           
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


