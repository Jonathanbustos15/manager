<?php 

    include("../controller/formatosController.php");    

    $formatosinst = new FormatoController();

    $arrPermisos = $formatosinst->permisos(2,$_COOKIE["log_lunelAdmin_IDtipo"]);

    $crea = $arrPermisos[0]["crear"];

    $filtro = $_GET["filter"];

    $tipoUsuario = $_COOKIE['log_lunelAdmin_IDtipo'];

    //print_r(".........MMMMMMM.");
    //print_r($filtro);

?>
<script type="text/javascript">
    function validaArchivo(){
        //obtenemos un array con los datos del archivo
        var file = $("#archivo")[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la información del archivo
        //$("#respuesta").html("<span>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
        $("#url_archivo").val(fileName);
        console.log("Archivo para subir: "+fileName+", peso total: "+fileSize+" de tipo:"+fileType);
    }
</script>

<?php 

    include("modal_categoria.php");
    include("modal_sub_categoria.php");   
 ?>

<!-- Modal -->
<div class="modal fade" id="form_modal_formato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_formato">-</h4>
      </div>
      <div class="modal-body">
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-modal mod-form3" role="tablist">
          <li role="presentation" class="active"><a href="#datosGenerales" aria-controls="datosGenerales" role="tab" data-toggle="tab">Datos Generales</a></li>
                         
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">

          <div role="tabpanel" class="tab-pane active" id="datosGenerales">
          <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
            <form id="form_formato" method="POST">                
                <br>
                    <div class="form-group" hidden>                     
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pkID" name="pkID">
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="" class="control-label">Categoría</label>                        
                        <select name="fkID_categoria" id="fkID_categoria" class="form-control add-selectElement" required = "true">
                            <option></option><!---->
                            <?php 
                                /**/$categoriaSelect = $formatosinst->getCategoria();
                                for ($i=0; $i < sizeof($categoriaSelect); $i++) {
                                    echo '<option value="'.$categoriaSelect[$i]["pkID"].'">'.$categoriaSelect[$i]["nombre_cat"].'</option>';
                                };
                             ?>
                        </select>
                        <!--<a href="categoria.php" target="_blank" title="Añadir Categoría" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a> -->
                        <button id="btn_nuevoCategoria" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_categoria"><span class="glyphicon glyphicon-plus"></span></button>
                    </div>
                    <div id="sub_categoria" class="form-group">
                        <label for="" class="control-label">Sub Categoría</label>                        
                        <select name="fkID_subcategoria" id="fkID_subcategoria" class="form-control add-selectElement">
                            <option></option>
                            <?php 
                                $subcategoriaSelect = $formatosinst->getSubcategoria();
                                for ($i=0; $i < sizeof($subcategoriaSelect); $i++) {
                                    echo '<option value="'.$subcategoriaSelect[$i]["pkID"].'">'.$subcategoriaSelect[$i]["nombre_cat"].'</option>';
                                };
                             ?>
                        </select>
                        <!--<a href="subcategoria.php" target="_blank" title="Añadir Sub-Categoría" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a>-->
                        <button id="btn_nuevosubcategoria" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_subcategoria"><span class="glyphicon glyphicon-plus"></span></button>
                    </div>


                    
                    <div class="form-group">
                        <label for="nombre" class="control-label">Nombre</label>                        
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Formato" required = "true">                        
                    </div>
                    <div class="form-group">
                        <label for="descripcion" class="control-label">Descripción</label>                    
                        <textarea  class="form-control" id="descripcion" name="descripcion" placeholder="Descripción del formato" required = "true"> </textarea>                       
                    </div>
                                               
                    <div class="form-group">
                        <label for="nombre" class="control-label">Archivo</label>                        
                        <input type="file" class="form-control" id="archivo" name="archivo" placeholder="Archivo" onchange="validaArchivo();"> 
                        <input type="hidden" name="url_archivo" id="url_archivo">                       
                    </div>
                 
            </form>            
          <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
          </div>

         

          
          
        </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--> 
        <button id="btn_actionformato" type="button" class="btn btn-primary" data-action="-">
            <span id="lbl_btn_actionformato">-</span>
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
                        <div class="icono_formatos"></div>
                          <div class="panel-body">
                            Formatos
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
                              <div class="col-md-6">
                                  Registro de Formatos
                              </div>
                            
                            <div class="col-md-6 text-right">
                                  <button id="btn_nuevoformato" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#form_modal_formato" <?php if ($crea != 1){echo 'disabled="disabled"';} ?> ><span class="glyphicon glyphicon-plus"></span>&nbspCrear Formato</button> 
                              </div>


<!-- ./FILTRO ingresos-->
                              <div class="col-md-10 text-left form-inline">
                                <br>
                                  <h4 class="text-left"><span class="glyphicon glyphicon-filter"></span><strong>Filtro</strong></h4>
                                  
                                  <?php 
                                  if($tipoUsuario != 13){ 
                                  
                                ?>
                                  <label for="categoria_filtro" class="control-label">Categorías: </label>                                            
                                    <?php
                                        $formatosinst->getSelectCategoriaFiltro();
                                     }?>
                                
                                &nbsp &nbsp &nbsp
                                <button class="btn btn-success" id="btn_filtrar"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
                                
                                <hr>
                              </div>


                              <!-- ./filtro ingresos-->



                              
                            </div>

                        </div>
                        <!-- /.panel-heading -->

                        <div class="panel-body">

                            <div role="tabpanel">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#admin" aria-controls="admin" role="tab" data-toggle="tab">Administración</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#ver" aria-controls="tab" role="tab" data-toggle="tab">Ver</a>
                                    </li>
                                </ul>
                            
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="admin">
                                        <!-- ./contenido pestaña admin -->
                                        <br><br>
                                        <div class="dataTable_wrapper table-responsive">
                                            <table class="table table-striped table-bordered table-hover" id="tbl_formatos">
                                                <thead>
                                                    <tr>
                                                        <!--<th class="tabla-form-ancho">ID</th>-->
                                                        <th class="tabla-form-ancho">Categoria</th>
                                                        <th class="tabla-form-ancho">Subcategoria</th>
                                                        <th class="tabla-form-ancho">Nombre</th>
                                                        <th class="tabla-form-ancho">Descripcion</th>
                                                        <th class="tabla-form-ancho">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                          //print_r($_COOKIE); 
                                                          //$formatosinst->getTablaformatos(); 
                                                          $formatosinst->getTablaformatosFiltro($filtro);                          
                                                       ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->

                                        <!-- ./contenido pestaña admin -->
                                    </div>
                                    
                                    <div role="tabpanel" class="tab-pane" id="ver">
                                        <!-- ./contenido pestaña ver -->
                                        <br><br>
                                        <div id="tree"></div>
                                        <!-- ./contenido pestaña ver -->
                                    </div>

                                </div>
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