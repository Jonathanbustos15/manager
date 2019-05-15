<?php 
   
    include("../controller/contactosController.php");    

    $contactoinst = new contactosController(); 

    $id_contacto = $_GET["id_contacto"];    
 ?>

<div id="page-wrapper">

    <div class="row">

        <div class="col-lg-12">
            <h1 class="page-header">Detalles Contacto</h1> 
        </div>
        <!-- /.col-lg-12 -->
        <div class="col-lg-12 rowhv3">
            <ol class="breadcrumb">
              <li><a href="index.php">Inicio</a></li>
              <li><a href="contactos.php?s=*">Contactos</a></li>
              <li class="active">Detalles contacto</li>
            </ol>
        </div>

    </div>
    <!-- /.row -->

    <div class="row">

        <?php 
            $contactoinst->getContactoNombre($id_contacto);
        ?>

        <div class="col-md-12">

            <div class="col-md-6">

                <div class="panel panel-default">   
                                
                    <?php 
                        $contactoinst->getcontactoDatosGen($id_contacto);               
                     ?>
                        
                </div>

            </div>

            <div class="col-md-6 text-center">
                <?php 
                    $contactoinst->getcontactoFiles($id_contacto);               
                 ?>
            </div>

        </div>                
       
    </div>
    <!-- /.row -->

</div>
<!-- /#page-wrapper -->