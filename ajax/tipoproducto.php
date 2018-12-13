<?php
require_once "../modelos/Tipoproducto.php";

$tipoproducto=new Tipoproducto();

$idtipoproducto=isset($_POST["idtipoproducto"])? limpiarCadena($_POST["idtipoproducto"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idtipoproducto)){
			$rspta=$tipoproducto->insertar($nombre,$descripcion);
			echo $rspta ? "Tipo de Producto registrado" : "Tipo de Producto no se pudo registrar";
		}
		else {
			$rspta=$tipoproducto->editar($idtipoproducto,$nombre,$descripcion);
			echo $rspta ? "Tipo de Producto actualizado" : "Tipo de Producto no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$tipoproducto->desactivar($idtipoproducto);
		echo $rspta ? "Tipo de Producto Desactivado" : "Tipo de Producto no se puede desactivar";
    break;

    case 'activar':
		$rspta=$tipoproducto->activar($idtipoproducto);
		echo $rspta ? "Tipo de Producto activado" : "Tipo de Producto no se puede activar";
    break;

    case 'mostrar':
		$rspta=$tipoproducto->mostrar($idtipoproducto);
		//codificar el resultado utilizando json
		echo json_encode($rspta);
    break;

    case 'listar':
		$rspta=$tipoproducto->listar();
		//Vamos a declarar un Array
		$data= Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
				"0"=>($reg->condicion)?'<button class="btn btn-success btn-sm" onclick="mostrar('.$reg->idtipoproducto.')"><i class="fa fa-pencil"></i></button>'.
				' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idtipoproducto.')"><i class="fa fa-close"></i></button>' :  '<button class="btn btn-success btn-sm" onclick="mostrar('.$reg->idtipoproducto.')"><i class="fa fa-pencil"></i></button>'.
				' <button class="btn btn-warning btn-sm" onclick="activar('.$reg->idtipoproducto.')"><i class="fa fa-check"></i></button>',
				"1"=>'<span style="letter-spacing: 0.5px; font-weight: bold;">'.$reg->nombre.'</span>',
				"2"=>$reg->descripcion,
				"3"=>'<span style="letter-spacing: 0.5px; font-weight: bold; color:#c74535; font-size:17px;">MA#0'.$reg->idtipoproducto.'</span>',
				"4"=>($reg->condicion)?'<span class="label bg-olive">Activado</span>' :  '<span class="label bg-red">Desactivado</span>'
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
