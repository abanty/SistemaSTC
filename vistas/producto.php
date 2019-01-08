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

if ($_SESSION['inventarios']==1)
{
?>

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                <div class="nav-tabs-custom" id="table_container">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" style="font-weight:bold; cursor:pointer;"><i class="fa fa-list "></i> MODULO DE GESTION DEL PRODUCTO (Prendas)</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">

                      <div class="box box-success">
                        <div class="box-header with-border">
                          <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
                          <button class="btn btn-warning" id="btnagregar" onclick="mostrarform(true);"><i class="fa fa-plus-circle "></i> Registrar Productos o Prendas</button>

                          </div>

                          <div class="box-tools pull-right">
                            <button id="show_notify_alert" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                          </div>
                        </div>
                          <div class="box-body">

                            <div class="box box-default" id="serchfilter">
                              <div class="box-header with-border">
                                <!-- <h3 class="box-title"></h3> -->

                                <div class="box-tools pull-right" style="margin-top:-7px;">
                                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>

                              </div>
                                <!-- /.box-header -->
                                <div class="box-body" style="">
                                    <div class="form-inline">
                                      <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <label for="text">Buscar en : </label>
                                        <select class="form-control" id="ddlSearch">
                                          <option value="1">CODIGO</option>
                                          <option value="2" selected>NOMBRE</option>
                                          <option value="3">MARCA</option>
                                          <option value="4">DESCRIPCION</option>
                                          <option value="5">CATEGORIA</option>
                                          <option value="6">TALLA</option>

                                        </select>
                                          <input type="text" class="form-control filter" id="txtSearch">
                                          <button style="border-radius: 100%;" class="btn btn-default" onclick="clearSearch()"><i class="fa fa-refresh"></i></button>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12" style="text-align: right;">
                                            <div id="buttons"></div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="panel-body table-responsive" id="listadoregistros" style="padding-top: 0px;">
                              <table id="tbllistado" class="cell-border hover" style="width:100%;">
                                  <thead id="thead_entidad">
                                    <th style="width: 85px;">Opciones</th>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Marca</th>
                                    <th>Descripcion</th>
                                    <th>Categoria</th>
                                    <th>Talla</th>
                                    <th>Imagen</th>
                                    <th>Estado</th>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                  <tfoot id="thead_entidad">
                                    <th style="width: 85px;">Opciones</th>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Marca</th>
                                    <th>Descripcion</th>
                                    <th>Categoria</th>
                                    <th>Talla</th>
                                    <th>Imagen</th>
                                    <th>Estado</th>
                                    </tfoot>
                              </table>
                            </div>

                            <div class="panel-body" id="formularioregistros">

                              <h2><i class="fab fa-product-hunt"></i> Información del Producto</h2>
                                <form name="formulario" id="formulario" method="POST" enctype="multipart/form-data">

                                  <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <label>Nombre(*):</label>
                                    <input type="hidden" name="idproducto" id="idproducto">
                                    <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" autocomplete="on" required>
                                  </div>

                                  <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <label>Categoria(*):</label>
                                    <div id="container_date">
                                      <button type="button" onclick="registrar_categoria_modal();" class="btn btn-default"><span class="fa fa-plus"></span></button>
                                      <select id="idcategoria" name="idcategoria" class="form-control selectpicker" data-live-search="true" title="Selecciona Categoria" required></select>
                                    </div>
                                  </div>

                                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <label>Codigo:</label>
                                    <div id="container_date">
                                      <button id="btnrefreshtime" type="button" onclick="showcode()" class="btn btn-personal"><span class="fa fa-refresh"></span></button>
                                      <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Codigo">
                                    </div>
                                  </div>

                                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                   <label>Stock(*):</label>
                                   <input type="number" class="form-control" name="stock" id="stock" required>
                                 </div>

                                 <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                   <label>Marca(*):</label>
                                   <div id="container_date">
                                      <button type="button" onclick="registrar_marca_modal();" class="btn btn-default"><span class="fa fa-plus"></span></button>
                                      <select id="idmarca" name="idmarca" class="form-control selectpicker" data-live-search="true" title="Selecciona Marca" required></select>
                                    </div>
                                 </div>

                                 <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                   <label>Unidad Medida - Talla(*):</label>
                                   <div id="container_date">
                                      <button type="button" onclick="registrar_talla_modal();" class="btn btn-default"><span class="fa fa-plus"></span></button>
                                      <select id="idunidadmedida" name="idunidadmedida[]" class="form-control selectpicker" data-live-search="true" title="Selecciona Talla" multiple required></select>
                                    </div>
                                 </div>

                                 <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                   <label>Tipo producto(*):</label>
                                    <div id="container_date">
                                        <button type="button" onclick="registrar_tipopro_modal();" class="btn btn-default"><span class="fa fa-plus"></span></button>
                                        <select id="idtipoproducto" name="idtipoproducto" class="form-control selectpicker" data-live-search="true" title="Selecciona Tipo de producto" required></select>
                                    </div>
                                 </div>

                                 <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                   <label>Descripcion:</label>
                                   <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Describe tu producto..." rows="4" cols="50"></textarea>

                                 </div>

                                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Imagen:</label>
                                    <input type="file" onchange="readURL(this);" class="form-control" name="imagen" id="imagen" multiple>
                                    <input type="hidden" name="imagenactual" id="imagenactual">
                                    <img class="pop" src="" width="150px" height="120px" id="imagenmuestra" style="margin: 0 auto; margin-top: 20px;">

                                    <div id="gallery"></div>


                                  </div>




                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <button class="btn btn-success" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                                    <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>

                                  </div>

                                </form>
                            </div>
                        </div>
                    </div>
                 </div>
                    <!-- /.tab-pane -->
                     <!-- /.tab-pane -->
                </div>
                   <!-- /.tab-content -->
                </div>
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
  <script type="text/javascript" src="scripts/producto.js"></script>
  <?php
  }
  ob_end_flush();
  ?>
