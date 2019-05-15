<?php 

    class scripts_pag {        

        public function standar(){

            echo '  <!-- jQuery -->
                    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
                    <script src="../js/plugins/autocompleta/jquery-ui.min.js"></script>

                    <!-- Bootstrap Core JavaScript -->
                    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

                    <!-- Metis Menu Plugin JavaScript -->
                    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

                    <!-- DataTables JavaScript -->
                    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
                    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
                    <script src="../bower_components/datatables/data_tabla.js"></script>
                    
                    <!-- plugin para validar -->
                    <script src="../js/plugins/validav1/valida_p_v1.js"></script>

                    <!-- jquery ui widget-->
                    <script src="../js/jquery.ui.widget.js"></script>

                    <!-- jquery iframe-transport-->
                    <script src="../js/jquery.iframe-transport.js"></script>

                    <!-- jquery fileupload plugin-->
                    <script src="../js/jquery.fileupload.js"></script>

                    <!-- plugin para calendario -->
                    <script src="../js/plugins/calendario/moment.min.js"></script>                
                    <script src="../js/plugins/calendario/jquery-ui-timepicker-addon.js"></script>
                    <script src="../js/plugins/calendario/calendarCotizacion.js"></script>
                    <!-- plugin para lenguaje datepicker -->
                    <script src="../js/datepicker-es.js"></script>

                    <script src="../js/plugins/mask/jquery.mask.js"></script>                    
                    <script src="../js/plugins/mask/jquery.formatCurrency.js"></script>                    
                    <script src="../js/plugins/mask/accounting.min.js"></script>
                    
                    <script src="../js/plugins/sesion_plugin/timer.jquery.js"></script>
                    <script src="../js/plugins/sesion_plugin/sesion_plugin.js"></script>
                        
                    <!-- js treeview -->
                    <script src="../bower_components/bootstrap-treeview/public/js/bootstrap-treeview.js"></script>

                    <!-- Plugins creados valida_p_v1,jquery_controller.js,validaArchivoPlugin.js -->
                    <script src="../bower_components/valida_p.js/js/valida_p_v1.js"></script>
                    <script src="../bower_components/jquery_controller.js/jquery_controller.js"></script>
                    <script src="../bower_components/jquery_controllerV2.js/jquery_controllerV2.js"></script>
                    <script src="../bower_components/validaArchivoPlugin.js/validaArchivoPlugin.js"></script>
                    <script src="../bower_components/validaFormPlugin2.js/validaFormPlugin2.1.js"></script>
                    
                    <!-- script con funciones superglobales -->
                    <script src="../js/scripts_cont/helper_global.js"></script>
                    
                    <!-- Morris Charts JavaScript -->
                    <script src="../bower_components/raphael/raphael-min.js"></script>
                    <script src="../bower_components/morrisjs/morris.min.js"></script>

                    <!-- Custom Theme JavaScript -->
                    <script src="../dist/js/sb-admin-2.js"></script>';            
        }

        /*
                    <!-- Morris Charts JavaScript -->
                    <script src="../bower_components/raphael/raphael-min.js"></script>
                    <script src="../bower_components/morrisjs/morris.min.js"></script>
                    <script src="../js/morris-data.js"></script>
        */

        public function special($arr_script){

            $this->standar();

            for ($i=0; $i < sizeof($arr_script); $i++) { 
                # code...
                echo '<script src="../js/scripts_cont/'.$arr_script[$i].'"></script>';
            }
        }
    }

 ?>
