<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';

if ($_SESSION['compras']==1)
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div id="contenedor_principal" class="content-wrapper">
        <!-- Main content -->

        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box box-warning">
                    <div class="box-header with-border">
                          <h1 class="box-title"><i class="fa fa-product-hunt"></i> STOCK DE PRODUCTOS POR PUNTO DE VENTA </h1>
                      
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistadopuntov" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Descripcion</th>
                            <th>Almacen</th>
                            <th>Stock</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Descripcion</th>
                            <th>Almacen</th>
                            <th>Stock</th>
                          </tfoot>
                        </table>
                    </div>

                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
  <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <img src="" class="imagepreview" style="width: 100%;" >
            </div>
        </div>
    </div>
</div>

  <?php
  }
  else
  {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/punto_venta.js"></script>

  <?php
  }
  ob_end_flush();
  ?>
