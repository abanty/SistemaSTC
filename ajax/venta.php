<?php
if (strlen(session_id()) < 1)
  session_start();

require_once "../modelos/Venta.php";

$venta=new Venta();

$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";


$idalmacen=isset($_GET["idalmacen"])? limpiarCadena($_GET["idalmacen"]):"";

$idventa_det=isset($_GET["idventadet"])? limpiarCadena($_GET["idventadet"]):"";

$iddetalle_venta=isset($_POST["iddetalle_venta"])? limpiarCadena($_POST["iddetalle_venta"]):"";

switch ($_GET["op"]){

  # CASE PARA GUARDAR LAS VENTAS Y SU DETALLE
  case 'guardaryeditar':
		if (empty($idventa)){
			$rspta=$venta->insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$_POST["idproducto"],$_POST["idalmacen"],$_POST["idlote"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["descuento"]);
			echo $rspta ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";
		}
		else {
		}
	break;

# CASE PARA ANULAR LAS VENTAS
	case 'anular':
		$rspta=$venta->anular($idventa);
 		echo $rspta ? "Venta anulada" : "Venta no se puede anular";
	break;


  # CASE PARA ANULAR LOS DETALLE DE VENTA EN CASO EMERGENCIA
  	case 'anulardetalle_v':

  		$rspta=$venta->anulardetalle($iddetalle_venta);
   		echo $rspta ? "Detalle anulado" : "Detalle no se puede anular";
  	break;

# CASE PARA MOSTRAR LAS VENTAS
	case 'mostrar':
		$rspta=$venta->mostrar($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

# CASE PARA LISTAR EL DETALLE DE LAS  VENTAS EN UN TABLE
	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $venta->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#222d3287; color: white; ">
                                    <th>Opciones</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td style="text-align:center;"><button type="button" class="btn btn-danger btn-sm" onclick="anulardetalle('.$reg->iddetalle_venta.')"><i class="fa fa-close"></i></button></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->precio_venta.'</td><td>'.$reg->descuento.'</td><td>'.$reg->subtotal.'</td></tr>';
					$total=$total+($reg->precio_venta*$reg->cantidad-$reg->descuento);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_venta" id="total_venta"></th>
                                </tfoot>';
	break;

# CASE PARA LISTAR LAS VENTAS EN UN DATATABLE
	case 'listar':
		$rspta=$venta->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetch_object()){
 			if($reg->tipo_comprobante=='Ticket'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			else{
 				$url='../reportes/exFactura.php?id=';
 			}
 			$data[]=array(
 				"0"=>(($reg->estado=='Aceptado')?'<button class="btn btn-success btn-sm" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger btn-sm" onclick="anular('.$reg->idventa.')"><i class="fa fa-close"></i></button>'.' <button class="btn btn-warning btn-sm" onclick="verdetalle('.$reg->idventa.')"><i class="fa fa-list"></i></button>':
 					'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>').
 					'<a target="_blank" href="'.$url.$reg->idventa.'"> <button class="btn btn-personal btn-sm"><i class="fa fa-file"></i></button></a>',
 				"1"=>$reg->fecha,
 				"2"=>$reg->cliente,
 				"3"=>$reg->usuario,
 				"4"=>$reg->tipo_comprobante,
 				"5"=>$reg->serie_comprobante.'-'.$reg->num_comprobante,
 				"6"=>$reg->total_venta,
 				"7"=>($reg->estado=='Aceptado')?'<span class="label bg-olive">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

# CASE PARA LISTAR LOS CLIENTES EN UN SELECTBOX
	case 'selectCliente':
		require_once "../modelos/Persona.php";
		$persona = new Persona();


		$rspta = $persona->listarC();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
				}
	break;

# CASE PARA LISTAR LOS ALMACENES EN UN SELECTBOX
  case 'selectAlmacenVenta':
    require_once "../modelos/Almacen.php";
    $almacen = new Almacen();
    $rspta = $almacen->select_almacen();

    while ($reg = $rspta->fetch_object())
        {
      	echo '<option data-icon="fa fa-map-marker" value=' . $reg->idalmacen . '>' . $reg->nombre . '</option>';
        }
  break;

# CASE PARA LISTAR LOS PRODUCTOS DEL MODAL VENTA
  	case 'listarProductosVenta':
  		require_once "../modelos/Producto.php";
  		$producto=new Producto();
  		$rspta=$producto->listarActivosAlmacen($idalmacen);
   		$data= Array();
   		while ($reg=$rspta->fetch_object()){
   			$data[]=array(
   		  "0"=>'<button class="btn btn-personal" id="adddetalle" onclick="agregarDetalle(\''.$reg->codigo.'\','.$reg->idproducto.',\''.$reg->producto.'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\',\''.$reg->idalmacen.'\','.$reg->idlote.')"><span class="fa fa-plus"></span></button>',
        "1"=>$reg->fecha_ingreso,
        "2"=>'<span style="color:#bd0000; font-weight:bold;" class="">'.$reg->codigo.'</span>',
        "3"=>'<span style="color:#000000; font-weight:bold;" class="">'.$reg->producto.'</span>',
        "4"=>$reg->descripcion,
        "5"=>$reg->categoria,
        "6"=>'<span style="color:#337ab7; font-size:16px; font-weight:bold;" class="">'.$reg->abreviatura.'</span>',
   	 	  "7"=>($reg->stock=='0')?'<span style="color:#f10808; font-family: monospace; font-size:19px; font-weight:bold;" class="">'.$reg->stock.'</span>':
        '<span style="color:#02bb66; font-family: monospace; font-size:19px; font-weight:bold;" class="">'.$reg->stock.'</span>',
   		  "8"=>$reg->precio_venta,
   		  "9"=>"<img src='../files/productos/".$reg->imagen."' height='50px' width='50px' >"
   			);
   		}
   		$results = array(
   			"sEcho"=>1, //Información para el datatables
   			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
   			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
   			"aaData"=>$data);
   		echo json_encode($results);
  	break;


    # CASE PARA LISTAR LOS PRODUCTOS DEL MODAL VENTA
      	case 'listadetalle_poridventa':

      		$rspta=$venta->listarDetalle($idventa_det);
       		$data= Array();
       		while ($reg=$rspta->fetch_object()){

       			$data[]=array(
       		  "0"=>'<button class="btn btn-danger btn-sm" onclick="anulardetalle('.$reg->iddetalle_venta.')"><span class="fa fa-close"></span> Anular</button>',
            "1"=>$reg->idventa,
            "2"=>'<span style="color:#122450; font-weight:bold;" class="">'.$reg->nombre.'</span>',
            "3"=>'<span style="color:#000000; font-weight:bold;" class="">'.$reg->cantidad.'</span>',
            "4"=>$reg->precio_venta,
            "5"=>$reg->descuento,
            "6"=>$reg->subtotal
       			);
       		}
       		$results = array(
       			"sEcho"=>1, //Información para el datatables
       			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
       			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
       			"aaData"=>$data);
       		echo json_encode($results);
      	break;
}
?>
