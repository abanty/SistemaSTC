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
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title"> Salidas a Punto de Venta </br> </br>  <button class="btn btn-warning" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Reponer Stock Punto de Venta</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Punto de Vente</th>
                            <th>Usuario</th>
                            <th>Total Salida</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Punto de Vente</th>
                            <th>Usuario</th>
                            <th>Total Salida</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                      <!-- <h1 style="margin-top:-20px; padding-bottom:15px; font-size: 30px;font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;">Ingreso</h1> -->


                        <form name="formulario" id="formulario" method="POST" action="#">

                          <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <label>Punto de Venta(*):</label>
                            <input type="hidden" name="idingreso" id="idingreso">
                            <select id="idpuntoventa" name="idpuntoventa" class="form-control selectpicker" data-live-search="true" required>

                            </select>
                          </div>

                           <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha(*):</label>
                            <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" required>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <a data-toggle="modal" href="#myModal">
                              <button id="btnAgregarArt" type="button" class="btn btn-warning"> <span class="fa fa-plus"></span> Seleccionar Producto</button>
                            </a>
                          </div>

                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                              <div class="box-body table-responsive no-padding">
                                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                  <thead style="background-color:hsl(199, 8%, 65%);">
                                        <th>Opciones</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Venta (u)</th>
                                        <th>Subtotal</th>
                                    </thead>
                                    <tfoot>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th id="total_estilo">TOTAL</th>
                                        <th><h4 id="total">S/. 0.00</h4><input type="hidden" name="total_traspaso" id="total_traspaso"></th>
                                    </tfoot>
                                    <tbody>
                                  <!-- AQUI IRA EL CUERPO DE DATATABLE -->
                                    </tbody>
                                </table>
                              </div>
                          </div>


                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-info" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i>Cancelar</button>
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
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width:60%;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Seleccione un Producto</h4>
          </div>
          <div class="modal-body">
          <div class="table-responsive">
            <table id="tblproductos" class="table table-striped table-hover responsive">
              <thead>
                <th>Opciones</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Categoria</th>
                <th>Precio(v)</th>
                <th>Talla</th>
                <th>Stock</th>
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
                <th>Precio(v)</th>
                <th>Talla</th>
                <th>Stock</th>
                <th>Imagen</th>
              <tfoot>
            </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
  <script type="text/javascript" src="scripts/ingresopunto.js"></script>

  <?php
  }
  ob_end_flush();
  ?>
