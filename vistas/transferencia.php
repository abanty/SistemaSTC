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

if ($_SESSION['ventas']==1)
{

?>


<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->

      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content" id="listadoregistros">
            <div class="row">
                <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                  <div class="box box-success">
                    <div class="box-header with-border">
                          <button class="btn btn-warning" id="btnagregar" onclick="mostrarform(true)" autofocus="autofocus"><i class="fa fa-plus"></i> Realizar Traspaso de Productos</button>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->

                    <div class="panel-body table-responsive">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
                          <thead>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Almacen Origen</th>
                            <th>Almacen Destino</th>
                            <th>Observaciones</th>
                            <th>Total traspaso</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Almacen Origen</th>
                            <th>Almacen Destino</th>
                            <th>Observaciones</th>
                            <th>Total traspaso</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>

                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->

              <div class="col-md-3">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-yellow">
                <div class="widget-user-image">
                  <img class="img-circle" src="https://cdn.shopify.com/s/files/1/2135/2261/products/Traspaso_de_Registro_de_Signo_Distintivo_nombre_comercial_marca_rotulo_300x300.jpg?v=1513090087" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">Traspaso de Producto</h3>
                <h5 class="widget-user-desc">Detalles</h5>
              </div>
              <div class="" style="text-align:center;">
                <ul class="nav nav-stacked">
                  <h4 class="">Reportes</h4>
                  <div id="buttons" style="display: inline-block;"></div>
                  <br>
                </ul>
              </div>
              <br>
            </div>
            <!-- /.widget-user -->
          </div>
        </div><!-- /.row -->
    </section><!-- /.content -->

      <!-- Main content 2-->
      <section class="content"  id="formularioregistros">
          <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                      <div class="panel-body">
                            <h3><i class="fa fa-book"></i> Transferencia de productos</h3><br>
                      <form name="formulario" id="formulario" method="POST">

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                              <label>Fecha(*):</label>
                              <input type="hidden" class="form-control" name="idtransferencia" id="idtransferencia">
                              <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" style="width: 91.4%;"required="">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                              <label>Origen(*):</label>
                              <select id="origen" name="origen" class="form-control selectpicker show-tick" data-live-search="true" title="Selecciona un Almacen de Origen"  required >
                              </select>
                          </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Destino(*):</label>
                            <select id="destino" name="destino" class="form-control selectpicker show-tick" data-live-search="true"  title="Selecciona un Almacen de Destino" required >
                            </select>
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Observaciones:</label>
                            <input type="text" class="form-control" name="observaciones" id="observaciones" required="">
                        </div>

                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                            <br>
                            <a class="btn btn-app" onclick="openproductofilter()">
                                <span class="badge bg-teal">Click Aqui !</span>
                                <i class="fa fa-inbox"></i> Seleccionar Productos
                            </a>
                        </div>

                        <br>
                        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-8">
                          <div class="box-body table-responsive no-padding">
                          <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                            <thead style="background-color:#222d3287; color: white;">
                                  <th>Opciones</th>
                                  <th>Codigo</th>
                                  <th>Producto</th>
                                  <th>Cantidad</th>
                                  <th>SUBTOTAL</th>
                              </thead>
                              <tbody>
                              </tbody>
                              <tfoot>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th><input type="hidden" name="total_traspaso" id="total_traspaso"></th>
                              </tfoot>
                          </table>
                        </div>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                           <div class="info-box">
                                <span class="info-box-icon bg-yellow"><small style="font-size: 34px; font-weight: bold;">Total</small></span>
                                <div class="info-box-content" style="text-align: center;"><br>
                                    <span class="info-box-number" style="font-size:25px;" id="totalproductos"> 0 </span>
                                    <span class="info-box-text">Productos</span>
                                </div>
                          <!-- /.info-box-content -->
                          </div>
                      <!-- /.info-box -->
                    </div>

                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <button class="btn btn-personal" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                          <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>
           </form>
          </div>
          <!--Fin centro -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 1030px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Producto</h4>
        </div>
        <div class="modal-body">
          <table style="width:99% !important;"id="tblproductos2" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
              <th>Opciones</th>
              <th>Codigo</th>
              <th>Nombre</th>
              <th>Descripcion</th>
              <th>Categoria</th>
              <th>Talla</th>
              <th>Stock</th>
              <th>Precio Venta</th>
              <th>Imagen</th>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <th>Opciones</th>
              <th>Codigo</th>
              <th>Nombre</th>
              <th>Descripcion</th>
              <th>Categoria</th>
              <th>Talla</th>
              <th>Stock</th>
              <th>Precio Venta</th>
              <th>Imagen</th>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default"  data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin modal -->
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/transferencia.js"></script>
<?php
}
ob_end_flush();
?>
