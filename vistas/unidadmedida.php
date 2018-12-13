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
                        <li class="active"><a href="#tab_1" data-toggle="tab" style="font-weight:bold; cursor:pointer;"><i class="fa fa-list "></i> MODULO DE GESTION DE UNIDADES DE MEDIDA</a></li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">

                          <div class="box box-success" id="tablacontenidoformasimplificada">
                            <div class="box-header with-border">
                              <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
                              <button class="btn btn-warning" id="btnagregar" onclick="editreg_form();"><i class="fa fa-plus-circle "></i> Registrar Unidad de Medida</button>

                              </div>

                              <div class="box-tools pull-right">
                                <button id="show_notify_alert" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                              </div>
                            </div>
                              <div class="box-body">

                                <div class="box box-default">
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
                                              <option value="1">NOMBRE</option>
                                              <option value="2">TIPO</option>
                                              <option value="3">ABREVIATURA</option>
                                              <option value="4">DESCRIPCION</option>

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
                                        <th>OPCIONES</th>
                                        <th>NOMBRE</th>
                                        <th>TIPO</th>
                                        <th>ABREVIATURA</th>
                                        <th>DESCRIPCION</th>
                                        <th>ESTADO</th>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                      <tfoot id="thead_entidad">
                                        <th>OPCIONES</th>
                                        <th>NOMBRE</th>
                                        <th>TIPO</th>
                                        <th>ABREVIATURA</th>
                                        <th>DESCRIPCION</th>
                                        <th>ESTADO</th>
                                        </tfoot>
                                  </table>
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
      </div>
      <!-- /.content-wrapper -->
  <?php
  }
  else
  {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/unidadmedida.js"></script>
  <?php
  }
  ob_end_flush();
  ?>
