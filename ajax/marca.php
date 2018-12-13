<?php
require_once "../modelos/Marca.php";

$marca=new Marca();

$idmarca=isset($_POST["idmarca"])? limpiarCadena($_POST["idmarca"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idmarca)){
			$rspta=$marca->insertar($nombre,$descripcion);
			echo $rspta ? "Marca registrada" : "Marca no se pudo registrar";
		}
		else {
			$rspta=$marca->editar($idmarca,$nombre,$descripcion);
			echo $rspta ? "Marca actualizada" : "Marca no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$marca->desactivar($idmarca);
		echo $rspta ? "Marca Desactivada" : "Marca no se puede desactivar";
    break;

    case 'activar':
		$rspta=$marca->activar($idmarca);
		echo $rspta ? "Marca activada" : "Marca no se puede activar";
    break;

    case 'mostrar':
		$rspta=$marca->mostrar($idmarca);
		//codificar el resultado utilizando json
		echo json_encode($rspta);
    break;

    case 'listar':
		$rspta=$marca->listar();
		//Vamos a declarar un Array
		$data= Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
				"0"=>($reg->condicion)?'<button class="btn btn-success btn-sm" onclick="mostrar('.$reg->idmarca.')"><i class="fa fa-pencil"></i></button>'.
				' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idmarca.')"><i class="fa fa-close"></i></button>' :  '<button class="btn btn-success btn-sm" onclick="mostrar('.$reg->idmarca.')"><i class="fa fa-pencil"></i></button>'.
				' <button class="btn btn-warning btn-sm" onclick="activar('.$reg->idmarca.')"><i class="fa fa-check"></i></button>',
				"1"=>'<span style="letter-spacing: 0.5px; font-weight: bold;">'.$reg->nombre.'</span>',
				"2"=>$reg->descripcion,
				"3"=>'<span style="letter-spacing: 0.5px; font-weight: bold; color:#c74535; font-size:17px;">MA#0'.$reg->idmarca.'</span>',
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
