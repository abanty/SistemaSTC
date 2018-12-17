<?php
if (strlen(session_id()) < 1)
  session_start();
require_once "../modelos/Ingreso.php";


$ingreso=new Ingreso();

$idingreso=isset($_POST["idingreso"])? limpiarCadena($_POST["idingreso"]):"";
$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_compra=isset($_POST["total_importe"])? limpiarCadena($_POST["total_importe"]):"";
$total_venta_sugerido=isset($_POST["total_venta_estimada"])? limpiarCadena($_POST["total_venta_estimada"]):"";
$total_beneficio=isset($_POST["total_beneficio"])? limpiarCadena($_POST["total_beneficio"]):"";

$idalmacen=isset($_GET["idalmacen"])? limpiarCadena($_GET["idalmacen"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idingreso)){
			$rspta=$ingreso->insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,
      $num_comprobante,$fecha_hora,$impuesto,$total_compra,$total_venta_sugerido,$total_beneficio,$_POST["idalmacen"],
      $_POST["idproducto"],$_POST["cantidad"],$_POST["importe"],$_POST["precio_compra"],$_POST["precio_venta"],
      $_POST["gananciaporcentaje"],$_POST["ganancianeta"]);
			echo $rspta ? "Ingreso registrado" : "No se pudieron registrar todos los datos del ingreso";
		}
		else {
		}
	break;

	case 'anular':
		$rspta=$ingreso->anular($idingreso);
		echo $rspta ? "Ingreso anulado" : "Ingreso no se puede anular";
    break;

  case 'mostrar':
		$rspta=$ingreso->mostrar($idingreso);
		//codificar el resultado utilizando json
		echo json_encode($rspta);
    break;

    case 'listarDetalle':
      //Recibimos el idingreso
      $id=$_GET['id'];

      $rspta = $ingreso->listarDetalle($id);
      $total=0;
      echo '<thead style="background-color:#222d3287; color:white;">
                                      <th>Opciones</th>
                                      <th>Codigo</th>
                                      <th>Producto</th>
                                      <th>Cantidad</th>
                                      <th>Importe Total</th>
                                      <th>Precio Compra (u)</th>
                                      <th>Precio Venta (u)</th>
                                      <th>Ganancia %</th>
                                      <th>Ganancia Neta</th>

                                  </thead>';



// <td>'.$reg->precio_compra*$reg->cantidad.'</td> $total+($reg->precio_compra*$reg->cantidad);

      while ($reg = $rspta->fetch_object())
          {
            echo '<tr class="filas"><td><i class="fa fa-check" aria-hidden="true"></i></td><td id="codinp">'.$reg->codigo.'</td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.' und</td><td>S/.'.$reg->importe.'</td><td>S/.'.$reg->precio_compra.'</td><td>S/.'.$reg->precio_venta.'</td><td>'.$reg->gananciaporcentaje.'%</td><td>S/.'.$reg->ganancianeta.'</td></tr>';
            $total= $reg->total_compra;
            $total_pv = $reg->total_venta_sugerido;
            $total_ben = $reg->total_beneficio;

          }
      echo '<tfoot>
                <th>TOTAL</th>
                <th></th>
                <th></th>
                <th></th>
                <th><h4 class="total_style" id="total_imp">S/.'.$total.'</h4><input type="hidden" name="total_importe" id="total_importe"></th>
                <th></th>
                <th><h4 class="total_style" id="total_v">S/.'.$total_pv.'</h4><input type="hidden" name="total_venta_estimada" id="total_venta_estimada"></th>
                <th></th>
                <th><h4 class="total_style" id="total_ben">S/.'.$total_ben.'</h4><input type="hidden" name="total_beneficio" id="total_beneficio"></th>
                <th></th>
            </tfoot>';
    break;

    case 'listar':
		$rspta=$ingreso->listar();
		//Vamos a declarar un Array
		$data= Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
				"0"=>($reg->estado=='Aceptado')?'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-eye"></i></button>'.
				' <button class="btn btn-danger btn-sm" onclick="anular('.$reg->idingreso.')"><i class="fa fa-close"></i></button>' :
        '<button class="btn btn-info btn-sm" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-eye"></i></button>',
				"1"=>$reg->fecha,
        "2"=>$reg->proveedor,
        "3"=>$reg->usuario,
				"4"=>$reg->tipo_comprobante,
        "5"=>$reg->serie_comprobante.'-'.$reg->num_comprobante,
        "6"=>$reg->total_compra,
        "7"=>$reg->almacen,
				"8"=>($reg->estado=='Aceptado')?'<span class="label bg-olive">Activado</span>' :  '<span class="label bg-red">Desactivado</span>'
				);
		}
		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
		echo json_encode($results);

	break;

  case 'select_producto_autocomplete':
  require_once "../modelos/Producto.php";

    $html = '';
    $key = $_POST['key'];
    $producto = new Producto();
    $result = $producto->listarautocomplete($key);


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $html .= '<div><a class="suggest-element" data="'.utf8_encode($row['nombre']).'" id="' .$row['idproducto'].'">'.utf8_encode($row['nombre']). '</a></div>';
        }
    }
    echo $html;

  break;

  case 'select_producto_autocompletev2':
  require_once "../modelos/Producto.php";

  $producto = new Producto();

  if(isset($_POST['search'])){

      $search = $_POST['search'];
      $result = $producto->listarautocomplete($search);

      while($row = mysqli_fetch_array($result) ){
          $response[] = array("value"=>$row['nombre'].', Stock: '.$row['stock'],"nombreproductojson"=>$row['nombre'],"idproductojson"=>$row['idproducto']);
      }

      echo json_encode($response);
  }

  break;

  case 'selectProveedor':
		require_once "../modelos/Persona.php";
		$persona = new Persona();

		$rspta = $persona->listarP();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option data-icon="fa fa-bank" value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
				}
	break;

  case 'selectAlmacen':
    require_once "../modelos/Almacen.php";
    $almacen = new Almacen();

    $rspta = $almacen->select_almacen();

    while ($reg = $rspta->fetch_object())
        {
        echo '<option data-icon="fa fa-map-marker" value=' . $reg->idalmacen . '>' . $reg->nombre . '</option>';
        }
  break;

  case 'listarProductos':
        require_once "../modelos/Producto.php";
        $producto=new Producto();
        $rspta=$producto->listarActivos();
        //Vamos a declarar un array
        $data= Array();
        while ($reg=$rspta->fetch_object()){
          	// $imagentest=(empty($reg->imagen))?"<img src='../files/productos/defaultpro.png' height='55px' width='65px'>":'<img src="../files/productos/'.$reg->imagen.'" height="55px" width="70px" onclick="mostrarclick(this.src)">';
          $data[]=array(
            "0"=>'<button class="btn btn-personal" onclick="agregarDetalle('.$reg->idproducto.',\''.limpiarCadena($reg->nombre).'\',\''.$reg->codigo.'\')"><span class="fa fa-plus"></span></button>',
            "1"=>'<span style="color:#bd0000; font-weight:bold;" class="">'.$reg->codigo.'</span>',
            "2"=>$reg->nombre,
            "3"=>$reg->descripcion,
            "4"=>$reg->categoria,
            "5"=>'<span style="color:#337ab7; font-size:16px; font-weight:bold;" class="">'.$reg->abreviatura.'</span>',
            "6"=>"<img src='../files/productos/".$reg->imagen."' height='50px' width='50px' >"
            );
        }
        $results = array(
          "sEcho"=>1, //Información para el datatables
          "iTotalRecords"=>count($data), //enviamos el total registros al datatable
          "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
          "aaData"=>$data);
        echo json_encode($results);
    break;


    # CASE PARA LISTAR LOS PRODUCTOS EN LOS DIVERSOS ALMACENES
      	case 'listarproductosalmacenes':
      		require_once "../modelos/Producto.php";
      		$producto=new Producto();
      		$rspta=$producto->listarActivosAlmacen($idalmacen);
       		$data= Array();
       		while ($reg=$rspta->fetch_object()){
       			$data[]=array(
            "0"=>'<span style="color:#bd0000; font-weight:bold;" class="">'.$reg->codigo.'</span>',
            "1"=>$reg->producto,
            "2"=>$reg->descripcion,
            "3"=>'<span class="label bg-olive">'.$reg->categoria.'</span>',
            "4"=>'<span style="color:#f39c12; font-size:16px; font-weight:bold;" class="">'.$reg->abreviatura.'</span>',
       	 	  "5"=>($reg->stock=='0')?'<span style="color:#fb1c00; font-size:16px; font-weight:bold;" class="">'.$reg->stock.'</span>':
            '<span style="color:#000000; font-size:16px; font-weight:bold;" class="">'.$reg->stock.'</span>',
       		  "6"=>'<span style="color:#17609e; font-size:14.5px; font-weight:bold; font-family: fantasy;" class="">S/.'.$reg->precio_venta.'</span>',
            "7"=>'<span style="color:#bd0000; font-size:14.5px; font-weight:bold; font-family: fantasy;" class="">S/.'.$reg->precio_compra.'</span>',
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

}
?>
