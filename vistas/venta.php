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
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box box-success">
                    <div class="box-header with-border">
                          <button class="btn btn-warning" id="btnagregar" onclick="mostrarform(true)" autofocus="autofocus"><i class="fa fa-plus"></i> Realizar Venta</button>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Total Venta</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Total Venta</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                              <li style="list-style:none; margin-top:-20px; padding-bottom:15px; font-size: 25px;font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;" class="treeview">

                                      <i class="fa fa-shopping-cart"></i>
                                       &nbsp;
                                      <span>Ventas</span>
                              </li>

                        <form name="formulario" id="formulario" method="POST">

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cliente(*):</label>
                            <input type="hidden" name="idventa" id="idventa">
                            <select id="idcliente" name="idcliente" class="form-control selectpicker" data-live-search="true" required >

                            </select>
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Fecha(*):</label>
                            <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" style="width: 91.4%;"required="">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Tipo Comprobante(*):</label>
                            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required="">
                              <option data-icon="fa fa-file-archive-o" value="Boleta">Boleta</option>
                              <option data-icon="fa fa-clipboard" value="Factura">Factura</option>
                              <option data-icon="fa fa-files-o" value="Ticket">Ticket</option>
                              <option data-icon="fa fa-file-text-o" value="Informacion de Salida">Otros</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <br>
                            <a>
                              <button id="btnAgregarArt" type="button" onclick="openproductofilter()" class="btn btn-warning"> <span class="fa fa-plus"></span> Seleccionar Productos</button>
                              </a>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Serie:</label>
                            <input type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Serie">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Número:</label>
                            <input type="number" class="form-control" name="num_comprobante" id="nfacturas" maxlength="15" placeholder="Número">
                            <!-- <span id="nfacturas"></span> -->
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Impuesto:</label>
                            <input type="text" class="form-control" name="impuesto" id="impuesto" required="">
                          </div>

                          <br>
                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <div class="box-body table-responsive no-padding">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#222d3287; color: white;">
                                    <th >Opciones</th>
                                    <th >Producto</th>
                                    <th >Cantidad</th>
                                    <th >Precio Venta Sugerido</th>
                                    <th >Descuento</th>
                                    <th>SUBTOTAL</th>
                                </thead>
                                <tfoot>

                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th id="TOT">TOTAL:</th>
                                    <th style="width: 90.7px"><h3 class="total_style_venta" id="total">S/. 0.00</h3><input type="hidden" name="total_venta" id="total_venta"></th>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                          </div>
                            </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                      <button class="btn btn-personal" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
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


<!-- PEQUEÑO MODAL PARA SELECCIONAR ALMACENES -->
  <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header" style="background: #00a65a; color: white;">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                  <h4 class="modal-title">Selecciona un Almacen: </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <select id="idalmacen" name="idalmacen" class="form-control selectpicker" title="Selecciona un Almacen de salida" required >
                      </select>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-success pull-right"  data-dismiss="modal">Cerrar</button>

                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
  </div>



  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 1030px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Producto</h4>
        </div>
        <div class="modal-body">
          <!-- FILTROS PARA BUSCAR EN MODAL -->

          <table style="width:99% !important;"id="tblproductos2" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
              <th>Opciones</th>
              <th>Codigo</th>
              <th>Nombre</th>
              <th>Descripcion</th>
              <th>Categoria</th>
              <th>Talla</th>
              <th>Stock</th>
              <th>P.V. Sugerido</th>
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
              <th>P.V. Sugerido</th>
              <th>Imagen</th>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default"  onclick="refresh_selectalm();" data-dismiss="modal">Cerrar</button>
        </div>
        <!-- onclick="refresh_selectalm()" -->
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
<script type="text/javascript" src="scripts/venta.js"></script>
<?php
}
ob_end_flush();
?>
