<?php 

    include("../controller/procesosController.php");    

    $inst = new procesosController();

    $pkID = $_GET["id_proceso"];

    //hacer el metodo que llame todos los datos del
    //proceso para mostrarlos en la vista individual
    $procesoGen = $inst->getDataProceso($pkID);

    //print_r($procesoGen);
?>

<!-- Modal documentos -->
<div class="modal fade" id="form_modal_documentos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_documentos">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_documentos" method="POST">                
            <br>
                <div class="form-group" hidden="true">                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>
                                                       
                <div class="form-group">
                    <label for="nom_doc" class="control-label">Nombre</label>                        
                    <input type="text" class="form-control" id="nom_doc" name="nom_doc" placeholder="Nombre de documento." required = "true">                        
                </div>

                <div class="form-group">
                    <label for="archivo" class="control-label">Archivo</label>                        
                    <input type="file" class="form-control" id="archivo" name="archivo" placeholder="Archivo"> 
                    <input type="hidden" name="ruta" id="ruta">                       
                </div>

                <div class="form-group" hidden="true">
                  <label for="fkID_tipo" class="control-label">Tipo de Documento</label>                        
                  <select name="fkID_tipo" id="fkID_tipo" class="form-control add-selectElement">
                      <option value="1">tipo</option>                    
                  </select>
                  <!--<a href="#" target="_blank" title="Añadir Tipo de Documento" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a>-->
                  <button id="btn_nuevotdocumento" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_tdocumento"><span class="glyphicon glyphicon-plus"></span></button>
              </div>

                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="fkID_proceso" name="fkID_proceso" value= <?php echo $procesoGen[0]["pkID"]; ?> >
                    </div>
                </div> 
        </form>

        <div id="not_docs_proceso" class="alert alert-info">
          
        </div>
                
      </div>

      <div class="modal-footer">    
        <button id="btn_actiondocumentos" type="button" class="btn btn-primary" data-action="-">
            <span id="lbl_btn_actiondocumentos">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div>
  
<!-- ./form modal documentos-->

<?php  
  include("modal_observaciones_proceso.php");
?>

<div id="page-wrapper">

	<div class="row">

      <div class="col-lg-12">          
          <div class="panel panel-default titulo-barra-amarilla">
          <div class="icono_procesos"></div>
            <div class="panel-body">
              Proceso <?php echo $procesoGen[0]["nom_entidad"]." / ".$procesoGen[0]["fecha_creacion"] ?>
            </div>
          </div> 
      </div>        
      <!-- /.col-lg-12 -->

      <div class="col-lg-12">
          <ol class="breadcrumb">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="procesos.php">Procesos</a></li>
            <li class="active">Detalles proceso <?php echo $procesoGen[0]["pkID"] ?> </li>
          </ol>
      </div>

	<div class="row">

    	<div class="col-lg-12">

		  <!-- Nav tabs -->
	      <ul class="nav nav-tabs tabs-proc3" role="tablist">
	        <li id="li_general" role="presentation"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a></li>
          <li id="li_documentos" role="presentation"><a href="#documentos" aria-controls="general" role="tab" data-toggle="tab">Documentos</a></li>
          <li id="li_seguimiento" role="presentation"><a href="#seguimiento" aria-controls="general" role="tab" data-toggle="tab">Seguimiento</a></li>
	        <!--<li id="li_presupuesto" role="presentation"><a href="#presupuesto" aria-controls="presupuesto" role="tab" data-toggle="tab">Presupuesto</a></li>
	        <li id="li_documentos" role="presentation"><a href="#documentos" aria-controls="documentos" role="tab" data-toggle="tab">Documentos</a></li> -->       
	      </ul>

	      	<!-- Tab panes -->
      		<div class="tab-content">
				
				    <div role="tabpanel" class="tab-pane" id="general">
		          <br>
		          <!-- contenido general -->
		          <div class="panel panel-default proc-pan-def3">
		            <div class="panel-body">
		              
                  <div class="col-md-12">
                    <!-- instancia php controller -->
                    <?php $inst->getDataProcesoGen($pkID); ?>
                    <?php $inst->getUserProceso($pkID); ?>
                  </div>

                  <div class="col-md-12">
                    <!-- mostrar indicadores de proceso -->
                    <?php $inst->getMuestraIndicadoresProceso($pkID); ?>
                  </div>

		            </div>
		          </div>
		          <!-- /.contenido general -->

		        </div>

            <div role="tabpanel" class="tab-pane" id="seguimiento">
              <br>
              <!-- contenido general -->
              <div class="panel panel-default detl-proc4 def-proc5">
                <div class="panel-body">

                <div class="row">
                  
                  <div class="col-md-8">
                    <!-- instancia php controller -->
                    <?php $inst->getObservacionesProceso(); ?> 
                  </div>

                  <div class="col-md-4 text-right">
                    <button id="btn_nuevoobservacion" class="btn btn-success" data-toggle="modal" data-target="#form_modal_observacion"><span class="glyphicon glyphicon-plus"></span> Nueva Observación</button>
                  </div>

                </div>
                  
                                               
                </div>
              </div>
              <!-- /.contenido general -->

            </div>

        <div role="tabpanel" class="tab-pane" id="documentos">
        <br>

          <div>

          <!-- Nav tabs -->
          <ul class="nav nav-tabs nav-tabs-doc4" role="tablist">
            <li id="li_admin" class="active"><a href="#admin" aria-controls="admin" role="tab" data-toggle="tab">Administrar</a></li>
            <!--<li id="li_ver"><a href="#ver" aria-controls="ver" role="tab" data-toggle="tab">Ver</a></li>-->
          </ul>
          

          <?php
          //id del modulo=12 
            $arrPermisosDocumentos = $inst->permisos(12,$_COOKIE["log_lunelAdmin_IDtipo"]);
            $creaDocumentos = $arrPermisosDocumentos[0]["crear"];
            //echo "crea documentos=".$creaDocumentos;          
           ?>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="admin">
                <br>
                <!-- contenido general -->
                  <div class="panel panel-default">
                    
                    <div class="panel-body">
                      <!-- instancia php controller -->               
                      <br>
                      <div class="panel panel-default proc-detl6">

                        <div class="panel-heading">
                          <div class="row">
                            <div class="col-md-6">
                                Registro de Procesos Lunel-IE
                            </div>
                            <div class="col-md-6 text-right">
                              <button id="btn_nuevoDocumento" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#form_modal_documentos" <?php if ($creaDocumentos != 1){echo 'disabled="disabled"';} ?> ><span class="glyphicon glyphicon-plus"></span>&nbspAñadir Documento</button>
                            </div>
                          </div>
                        </div>
                        <!-- /.panel-heading -->
                        
                        <div class="panel-body">

                        <div class="dataTable_wrapper table-responsive">
                          <table class="table table-striped table-bordered table-hover" id="tbl_documentos">
                              <thead>
                                  <tr>
                                      <!--<th>Id</th>-->
                                      <!--<th>Tipo</th>
                                      <th class="tabla-form-ancho">ID</th>-->
                                      <th class="tabla-form-ancho">Nombre</th>                                                                
                                      <th data-orderable="false"  class="tabla-form-ancho">Opciones</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php $inst->getTablaDocumentosProceso($pkID); ?>
                              </tbody>
                          </table>
                        </div>

                          <div  hidden="true">
                            <input type="text" id="id_proceso" value=<?php echo $pkID; ?> >
                          </div>
                        
                        </div>
                        <!-- /.panel-body -->
                      
                      </div>
                      <!-- /.panel -->                     

                    </div>

                  </div>
                  <!-- /.contenido general -->        
            </div>
            <div role="tabpanel" class="tab-pane" id="ver">
              
              <br>                                      
              <div id="tree"></div>
                
            </div>            
          </div>

        </div>        


      	</div>

    	</div>

    </div>

      
  </div>
  <!-- /.row -->

</div>
<!-- /#page-wrapper -->