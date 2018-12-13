<?php
if (strlen(session_id()) < 1)
  session_start();

require_once "../modelos/Transferencia.php";

$transferencia=new Transferencia();

$idtransferencia=isset($_POST["idtransferencia"])? limpiarCadena($_POST["idtransferencia"]):"";
$almacen_origen=isset($_POST["origen"])? limpiarCadena($_POST["origen"]):"";
$almacen_destino=isset($_POST["destino"])? limpiarCadena($_POST["destino"]):"";
$fecha=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$total_traspaso=isset($_POST["total_traspaso"])? limpiarCadena($_POST["total_traspaso"]):"";
$observaciones=isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";


$idalmacen_origen_select=isset($_GET["origen"])? limpiarCadena($_GET["origen"]):"";

switch ($_GET["op"]){

  # CASE PARA GUARDAR LAS VENTAS Y SU DETALLE
  case 'guardaryeditar':
		if (empty($idtransferencia)){
			$rspta=$transferencia->insertar($almacen_origen,$almacen_destino,$fecha,$total_traspaso,$observaciones,$_POST["codigo"],$_POST["idproducto"],$_POST["idalmacen"],$_POST["cantidad"]);
			echo $rspta ? "Traspaso registrado" : "No se pudieron registrar todos los datos del traspaso";
		}
		else {
		}
	break;

# CASE PARA ANULAR LAS VENTAS
	// case 'anular':
	// 	$rspta=$venta->anular($idtransferencia);
 	// 	echo $rspta ? "Venta anulada" : "Venta no se puede anular";
	// break;

# CASE PARA MOSTRAR LAS VENTAS
	// case 'mostrar':
	// 	$rspta=$venta->mostrar($idtransferencia);
 	// 	//Codificar el resultado utilizando json
 	// 	echo json_encode($rspta);
	// break;

# CASE PARA LISTAR EL DETALLE DE LAS  VENTAS EN UN TABLE
	// case 'listarDetalle':
	// 	//Recibimos el idingreso
	// 	$id=$_GET['id'];
  //
	// 	$rspta = $venta->listarDetalle($id);
	// 	$total=0;
	// 	echo '<thead style="background-color:#222d3287; color: white; ">
  //                                   <th>Opciones</th>
  //                                   <th>Producto</th>
  //                                   <th>Cantidad</th>
  //                                   <th>Precio Venta</th>
  //                                   <th>Descuento</th>
  //                                   <th>Subtotal</th>
  //                               </thead>';
  //
	// 	while ($reg = $rspta->fetch_object())
	// 			{
	// 				echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->precio_venta.'</td><td>'.$reg->descuento.'</td><td>'.$reg->subtotal.'</td></tr>';
	// 				$total=$total+($reg->precio_venta*$reg->cantidad-$reg->descuento);
	// 			}
	// 	echo '<tfoot>
  //                                   <th>TOTAL</th>
  //                                   <th></th>
  //                                   <th></th>
  //                                   <th></th>
  //                                   <th></th>
  //                                   <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_venta" id="total_venta"></th>
  //                               </tfoot>';
	// break;

# CASE PARA LISTAR LAS VENTAS EN UN DATATABLE
	case 'listarTraspaso':
		$rspta=$transferencia->listartransferencias();
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>(($reg->estado=='Aceptado')?'<button class="btn btn-success" onclick="mostrar('.$reg->idtransferencia.')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger" onclick="anular('.$reg->idtransferencia.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idtransferencia.')"><i class="fa fa-eye"></i></button>'),
 				"1"=>$reg->fecha,
 				"2"=>'<span style="font-variant-caps: all-small-caps; letter-spacing: 0.5px; font-weight: bold; color:#222d32; font-size:15px;">'.$reg->origen.'</span>',
    		"3"=>'<span style="font-variant-caps: all-small-caps; letter-spacing: 0.5px; font-weight: bold; color:#dd4b39; font-size:15px;">'.$reg->destino.'</span>',
 				"4"=>$reg->observaciones,
 				"5"=>'<span style="letter-spacing: 0.5px; font-weight: bold; color:#222d32; font-size:17px;">'.$reg->total_traspaso.'</span>'.' Productos',
 				"6"=>($reg->estado=='Aceptado')?'<span class="label bg-olive">Aceptado</span>':
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
	// case 'selectCliente':
	// 	require_once "../modelos/Persona.php";
	// 	$persona = new Persona();
  //
  //
	// 	$rspta = $persona->listarC();
  //
	// 	while ($reg = $rspta->fetch_object())
	// 			{
	// 			echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
	// 			}
	// break;


# CASE PARA LISTAR LOS PRODUCTOS DEL MODAL VENTA
  	case 'listarProductosTraspaso':
  		require_once "../modelos/Producto.php";
  		$producto=new Producto();
  		$rspta=$producto->listarActivosAlmacen($idalmacen_origen_select);
   		$data= Array();
   		while ($reg=$rspta->fetch_object()){
   			$data[]=array(
   		  "0"=>'<button class="btn btn-info" id="adddetalle" onclick="agregarDetalle(\''.$reg->codigo.'\',\''.$reg->idproducto.'\',\''.$reg->producto.'\',\''.$reg->stock.'\',\''.$reg->idalmacen.'\')"><span class="fa fa-plus"></span></button>',
        "1"=>'<span style="color:#bd0000; font-weight:bold;" class="">'.$reg->codigo.'</span>',
        "2"=>$reg->producto,
        "3"=>$reg->descripcion,
        "4"=>$reg->categoria,
        "5"=>'<span style="color:#337ab7; font-size:16px; font-weight:bold;" class="">'.$reg->abreviatura.'</span>',
   	 	  "6"=>($reg->stock=='0')?'<span style="color:#fb1c00; font-size:16px; font-weight:bold;" class="">'.$reg->stock.'</span>':
        '<span style="color:#000000; font-size:16px; font-weight:bold;" class="">'.$reg->stock.'</span>',
   		  "7"=>$reg->precio_venta,
   		  "8"=>"<img src='../files/productos/".$reg->imagen."' height='50px' width='50px' >"
   			);
   		}
   		$results = array(
   			"sEcho"=>1, //Información para el datatables
   			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
   			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
   			"aaData"=>$data);
   		echo json_encode($results);
  	break;


    # CASE PARA LISTAR LOS ALMACENES EN UN SELECTBOX
      case 'selectAlmacen':
        require_once "../modelos/Almacen.php";
        $almacen = new Almacen();
        $rspta = $almacen->select_almacen();

        while ($reg = $rspta->fetch_object())
            {
          	echo '<option data-icon="fa fa-map-marker" value=' . $reg->idalmacen . '> '  . $reg->nombre . '</option>';
            }
      break;
// "

    # CASE PARA LISTAR LOS ALMACENES POR PARAMETRO EN UN SELECTBOX
      case 'selectalmacentraspaso':
        require_once "../modelos/Almacen.php";
        $almacen = new Almacen();
        $rspta = $almacen->select_almacen_condicion($almacen_origen);

        while ($reg = $rspta->fetch_object())
            {
          	echo '<option data-icon="fa fa-map-marker"  value=' . $reg->idalmacen . '>' . $reg->nombre . '</option>';
            }
      break;
}
?>
