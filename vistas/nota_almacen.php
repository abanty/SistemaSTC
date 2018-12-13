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
                <div class="col-lg-10 col-sm-12 col-md-12 col-xs-12">
                  <div class="box box-success">
                    <div class="box-header with-border">
                          <button class="btn btn-warning" id="btnagregar" onclick="mostrarform(true)" autofocus="autofocus"><i class="fa fa-plus"></i> Registrar Nota de almacen</button>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
                          <thead>
                            <th>Opciones</th>
                            <th>Almacen</th>
                            <th>Producto</th>
                            <th>Usuario</th>
                            <th>Notas u Observaciones</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Almacen</th>
                            <th>Producto</th>
                            <th>Usuario</th>
                            <th>Notas u Observaciones</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->

        </div><!-- /.row -->
    </section><!-- /.content -->

      <!-- Main content 2-->
      <section class="content"  id="formularioregistros">
          <div class="row">
            <div class="col-md-8">
                <div class="box box-warning">
                      <div class="panel-body">
                            <h3><i class="fa fa-envelope-o"></i> Notas de Almacen </h3><br>
                      <form name="formulario" id="formulario" method="POST">

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 has-success">
                            <label>Notas u Observaciones:</label>
                            <input type="hidden" class="form-control" name="idnota_almacen" id="idnota_almacen">
                            <textarea style="resize: none;" rows="7" cols="50" id="nota" required="required" name="nota" class="form-control col-md-7 col-xs-12"></textarea>
                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha(*):</label>
                            <input type="date" class="form-control" name="fecha_nota" id="fecha_nota" required="">
                        </div>

                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <label>Selecciona un Almacen(*):</label>
                              <select id="idalmacen" name="idalmacen" class="form-control selectpicker show-tick" data-live-search="true" title="Selecciona un Almacen de Origen"  required >
                              </select>
                          </div>

                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Selecciona un Producto(*):</label>
                            <select id="idproducto" name="idproducto" class="form-control selectpicker show-tick" data-live-search="true"  title="Selecciona un Almacen de Destino" required >
                            </select>
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


      <div class="col-md-4">
                <!-- Box Comment -->
                <div class="box box-widget">
                  <div class="box-header with-border">
                    <div class="user-block">
                      <span class="username"><a href="#">Imagen del Producto</a></span>
                    </div>
                    <!-- /.user-block -->
                    <div class="box-tools">
                      <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Mark as read">
                        <i class="fa fa-circle-o"></i></button>
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                      <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                    </div>
                    <!-- /.box-tools -->
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body" style="">
                    <img class="img-responsive pad" id="imagen_producto" src="" alt="Photo">

                  <center> <p>Imagen Producto</p></center>
                    <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Imprime</button>
                    <!-- <button type="button" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</button> -->
                    <!-- <span class="pull-right text-muted">127 likes - 3 comments</span> -->
                  </div>

                </div>
                <!-- /.box -->
              </div>



    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/nota_almacen.js"></script>
<?php
}
ob_end_flush();
?>
