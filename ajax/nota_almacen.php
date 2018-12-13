<?php
if (strlen(session_id()) < 1)
  session_start();
require_once "../modelos/Nota_almacen.php";

$nota_almacen=new Nota_almacen();

$idnota_almacen=isset($_POST["idnota_almacen"])? limpiarCadena($_POST["idnota_almacen"]):"";
$idalmacen=isset($_POST["idalmacen"])? limpiarCadena($_POST["idalmacen"]):"";
$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$idusuario=$_SESSION["idusuario"];
$nota=isset($_POST["nota"])? limpiarCadena($_POST["nota"]):"";
$fecha_nota=isset($_POST["fecha_nota"])? limpiarCadena($_POST["fecha_nota"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (empty($idnota_almacen)){
			$rspta=$nota_almacen->insertar($idalmacen,$idproducto,$idusuario,$nota,$fecha_nota);
			echo $rspta ? "Nota registrada" : "'Nota no se pudo registrar";
		}
		else {
			$rspta=$nota_almacen->editar($idnota_almacen,$idalmacen,$idproducto,$idusuario,$nota,$fecha_nota);
			echo $rspta ? "Nota actualizada" : "Nota no se pudo actualizar";
		}
	break;

   # CASE PARA ANULAR LAS NOTAS DE ALMACEN
  	case 'anular':
  		$rspta=$nota_almacen->anular($idnota_almacen);
   		echo $rspta ? "Nota anulada" : "Nota no se puede anular";
  	break;

    case 'mostrar':
		$rspta=$nota_almacen->mostrar($idnota_almacen);
		//codificar el resultado utilizando json
		echo json_encode($rspta);
    break;

    case 'mostrar_Imagen':
    $rspta=$nota_almacen->mostrarImagen($idproducto);
    //codificar el resultado utilizando json
    echo json_encode($rspta);
    break;

    case 'listarNotas':
		$rspta=$nota_almacen->listarNotasAlmacen();
		//Vamos a declarar un Array
		$data= Array();
		while ($reg=$rspta->fetch_object()){
			$data[]=array(
        "0"=>(($reg->estado=='Pendiente')?'<button class="btn btn-success" onclick="mostrar('.$reg->idnota_almacen.')"><i class="fa fa-eye"></i></button>'.
          ' <button class="btn btn-danger" onclick="anular('.$reg->idnota_almacen.')"><i class="fa fa-close"></i></button>':
          '<button class="btn btn-warning" onclick="mostrar('.$reg->idnota_almacen.')"><i class="fa fa-eye"></i></button>'),
        "1"=>'<span style="color:#a72929; letter-spacing: 1px; font-size: 16px; font-weight: 700;" class="">'.$reg->almacen.'</span>',
				"2"=>'<span style="letter-spacing: 1px; font-size: 13px; font-weight: 700;" class="">'.$reg->producto.'</span>',
				"3"=>$reg->usuario,
				"4"=>$reg->nota,
				"5"=>$reg->fecha_nota,
        "6"=>($reg->estado=='Pendiente')?'<span class="label bg-olive">Pendiente</span>':
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

  # CASE PARA LISTAR LOS ALMACENES POR PARAMETRO EN UN SELECTBOX
    case 'select_producto_almacen':
      require_once "../modelos/Almacen.php";
      $almacen = new Almacen();
      $rspta = $almacen->select_producto_almacen($idalmacen);

      while ($reg = $rspta->fetch_object())
          {
          echo '<option data-icon="fa fa-product-hunt"  value=' . $reg->idproducto . '>' . $reg->nombre . '</option>';
          }
    break;

}
?>
