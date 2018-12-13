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
                  <div class="box box-success">
                    <div class="box-header with-border">
                        <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle "></i>Registrar Producto</button>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
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
                          <tfoot>
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

                      <h2 style="margin-top: -5px; padding-bottom: 20px;"><i class="fa fa-product-hunt"></i> Información del Producto</h2>
                        <form name="formulario" id="formulario" method="POST">

                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Nombre(*):</label>
                            <input type="hidden" name="idproducto" id="idproducto">
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" autocomplete="off" required>
                          </div>

                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Categoria(*):</label>
                             <select id="idcategoria" name="idcategoria" class="form-control selectpicker" data-live-search="true" title="Selecciona Categoria" required></select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Codigo:</label>
                            <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Codigo">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                           <label>Stock(*):</label>
                           <input type="number" class="form-control" name="stock" id="stock" required>
                         </div>

                         <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                           <label>Marca(*):</label>
                            <select id="idmarca" name="idmarca" class="form-control selectpicker" data-live-search="true" title="Selecciona Marca" required></select>
                         </div>

                         <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                           <label>Unidad Medida - Talla(*):</label>
                            <select id="idunidadmedida" name="idunidadmedida" class="form-control selectpicker" data-live-search="true" title="Selecciona Talla" required></select>
                         </div>

                         <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                           <label>Tipo producto(*):</label>
                            <select id="idtipoproducto" name="idtipoproducto" class="form-control selectpicker" data-live-search="true" title="Selecciona Tipo de producto" required></select>
                         </div>

                         <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <label>Descripcion:</label>
                           <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Describe tu producto..." rows="4" cols="50"></textarea>

                         </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Imagen:</label>
                            <input type="file" onchange="readURL(this);" class="form-control" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img class="pop" src="" width="150px" height="120px" id="imagenmuestra" style="margin: 0 auto; margin-top: 20px;">
                          </div>



                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-success" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>

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
