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

if ($_SESSION['escritorio']==1)
{
  require_once "../modelos/Consultas.php";
  $consulta = new Consultas();

// ACTUALES

  $rspta_costo_alm_g = $consulta->costo_total_almaceng();
  $reg_costo_alm_g=$rspta_costo_alm_g->fetch_object();
  $total_costo_alm_gen=$reg_costo_alm_g->total_costo_alm_gen;

  $rspta_costo_pun_v = $consulta->costo_total_puntov();
  $reg_costo_pun_v=$rspta_costo_pun_v->fetch_object();
  $total_costo_pun_v=$reg_costo_pun_v->total_costo_pun_ven;

// DESACTUALIZADAS

  $rsptac = $consulta->totalcomprahoy();
  $regc=$rsptac->fetch_object();
  $totalc=$regc->total_compra;

  $rsptav = $consulta->totalventahoy();
  $regv=$rsptav->fetch_object();
  $totalv=$regv->total_venta;

  //Datos para mostrar el gráfico de barras de las compras
  $compras10 = $consulta->comprasultimos_10dias();
  $fechasc='';
  $totalesc='';
  while ($regfechac= $compras10->fetch_object()) {
    $fechasc=$fechasc.'"'.$regfechac->fecha .'",';
    $totalesc=$totalesc.$regfechac->total .',';
  }
  //Quitamos la última coma
  $fechasc=substr($fechasc, 0, -1);
  $totalesc=substr($totalesc, 0, -1);

  //Datos para mostrar el gráfico de barras de las ventas
  $ventas12 = $consulta->ventasultimos_12meses();
  $fechasv='';
  $totalesv='';
  while ($regfechav= $ventas12->fetch_object()) {
   $fechasv=$fechasv.'"'.$regfechav->fecha .'",';
   $totalesv=$totalesv.$regfechav->total .',';
  }

  //Quitamos la última coma
  $fechasv=substr($fechasv, 0, -1);
  $totalesv=substr($totalesv, 0, -1);


?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Escritorio</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="small-box bg-red">
                            <div class="inner">
                              <h4 style="font-size:17px;">
                                <strong>S/ <?php echo $totalc; ?></strong>
                              </h4>
                              <p>Historial de Ingresos</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                            <a href="ingreso.php" class="small-box-footer">Ingresos <i class="fa fa-arrow-circle-right"></i></a>
                          </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="small-box bg-yellow">
                            <div class="inner">
                              <h4 style="font-size:17px;">
                                <strong>S/ <?php echo $totalv; ?></strong>
                              </h4>
                              <p>Historial de Ventas</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                            <a href="venta.php" class="small-box-footer">Ventas <i class="fa fa-arrow-circle-right"></i></a>
                          </div>
                      </div>

                    </div>

                    <div class="panel-body">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="small-box bg-olive">
                            <div class="inner">
                              <h4 style="font-size:17px;">
                                <strong>S/ <?php echo $total_costo_alm_gen; ?></strong>
                              </h4>
                              <p>Total Costo actual Almacen General</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                            <a href="almacen_general.php" class="small-box-footer">Almacen General <i class="fa fa-arrow-circle-right"></i></a>
                          </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="small-box bg-orange">
                            <div class="inner">
                              <h4 style="font-size:17px;">
                                <strong>S/ <?php echo $total_costo_pun_v; ?></strong>
                              </h4>
                              <p>Total Costo actual Punto venta</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                            <a href="punto_venta.php" class="small-box-footer">Punto de Venta <i class="fa fa-arrow-circle-right"></i></a>
                          </div>
                      </div>

                    </div>

                    <div class="panel-body">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="small-box bg-green">
                            <div class="inner">
                              <h4 style="font-size:17px;">
                                <strong>S/</strong>
                              </h4>
                              <p>Total Beneficio</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                            <a href="ingreso.php" class="small-box-footer">Ingresos <i class="fa fa-arrow-circle-right"></i></a>
                          </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="small-box bg-navy">
                            <div class="inner">
                              <h4 style="font-size:17px;">
                                <strong>S/</strong>
                              </h4>
                              <p>Crecimiento economico en porcentaje</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                            <a href="venta.php" class="small-box-footer">Ventas <i class="fa fa-arrow-circle-right"></i></a>
                          </div>
                      </div>

                    </div>
                    <div class="panel-body" style="height: 400px;">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                              Ingresos de los últimos 10 días
                            </div>
                            <div class="box-body">
                              <canvas id="compras" width="400" height="300"></canvas>
                            </div>
                        </div>
                      </div>

                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                              Ventas de los últimos 12 meses
                            </div>
                            <div class="box-body">
                              <canvas id="ventas" width="400" height="300"></canvas>
                            </div>
                        </div>
                      </div>

                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
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
<script src="../public/js/Chart.min.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script>
<script type="text/javascript">
var ctx = document.getElementById("compras").getContext('2d');
var compras = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasc; ?>],
        datasets: [{
            label: 'Ingresos en S/ de los últimos 10 días',
            data: [<?php echo $totalesc; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
var ctx = document.getElementById("ventas").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasv; ?>],
        datasets: [{
            label: 'Ventas en S/ de los últimos 12 Meses',
            data: [<?php echo $totalesv; ?>],
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255,99,132,1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>

<?php
}
ob_end_flush();
?>
