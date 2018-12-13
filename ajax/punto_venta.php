<?php
require_once "../modelos/Punto_venta.php";

$puntov=new Punto_venta();

// $idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";


switch ($_GET["op"]){

    case 'listar_pu_ag':
		$rspta=$puntov->listar_productos_ubicacion_almacen();
		//Vamos a declarar un Array

		$data= Array();
    // $imagentest=(empty($reg->imagen))?"<img src='../files/productos/defaultpro.png' height='55px' width='65px'>":'<img src="../files/productos/'.$reg->imagen.'" height="55px" width="70px" onclick="mostrarclick(this.src)">';
		while ($reg=$rspta->fetch_object()){
			$data[]=array(
        "0"=>"<img src='../files/productos/".$reg->imagen."' height='50px' width='50px' onclick='mostrarclick(this.src)'>",
				"1"=>'<span style="letter-spacing: 0.5px; font-weight: bold;">'.$reg->producto.'</span>',
        "2"=>$reg->descripcion,
				"3"=>$reg->almacen,
        "4"=>'<span style="letter-spacing: 0.5px; font-weight: bold; color:#337ab7; font-size:17px;">'.$reg->stock.'</span>'
				);
		}
		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
		echo json_encode($results);

	break;

  case 'listar_pu_pv':
  $rspta=$puntov->listar_productos_ubicacion_puntov();
  //Vamos a declarar un Array

  $data= Array();
  while ($reg=$rspta->fetch_object()){
    $data[]=array(
      "0"=>"<img src='../files/productos/".$reg->imagen."' height='50px' width='50px' onclick='mostrarclick(this.src)'>",
      "1"=>'<span style="letter-spacing: 0.5px; font-weight: bold;">'.$reg->producto.'</span>',
      "2"=>$reg->descripcion,
      "3"=>$reg->almacen,
      "4"=>'<span style="letter-spacing: 0.5px; font-weight: bold; color:#337ab7; font-size:17px;">'.$reg->stock.'</span>'
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
