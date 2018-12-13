<?php
require_once "../modelos/Unidadmedida.php";

$unidad=new Unidadmedida();

$idunidadmedida=isset($_POST["idunidadmedida"])? limpiarCadena($_POST["idunidadmedida"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$tipo=isset($_POST["tipou"])? limpiarCadena($_POST["tipou"]):"";
$abreviatura=isset($_POST["abreviatura"])? limpiarCadena($_POST["abreviatura"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idunidadmedida)){
			$rspta=$unidad->insertar($nombre,$tipo,$abreviatura,$descripcion);
			echo $rspta ? "Unidad de Medida registrada" : "Unidad de Medida no se pudo registrar";
		}
		else {
			$rspta=$unidad->editar($idunidadmedida,$nombre,$tipo,$abreviatura,$descripcion);
			echo $rspta ? "Unidad de Medida actualizada" : "Unidad de Medida no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$unidad->desactivar($idunidadmedida);
		echo $rspta ? "Unidad de Medida Desactivada" : "Unidad de Medida no se puede desactivar";
    break;

    case 'activar':
		$rspta=$unidad->activar($idunidadmedida);
		echo $rspta ? "Unidad de Medida activada" : "Unidad de Medida no se puede activar";
    break;

    case 'mostrar':
		$rspta=$unidad->mostrar($idunidadmedida);
		//codificar el resultado utilizando json
		echo json_encode($rspta);
    break;

    case 'listar':
		$rspta=$unidad->listar();
		//Vamos a declarar un Array
		$data= Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
				"0"=>($reg->condicion)?'<button class="btn btn-success btn-sm" onclick="mostrar('.$reg->idunidadmedida.')"><i class="fa fa-pencil"></i></button>'.
				' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idunidadmedida.')"><i class="fa fa-close"></i></button>' :  '<button class="btn btn-success btn-sm" onclick="mostrar('.$reg->idunidadmedida.')"><i class="fa fa-pencil"></i></button>'.
				' <button class="btn btn-warning btn-sm" onclick="activar('.$reg->idunidadmedida.')"><i class="fa fa-check"></i></button>',
				"1"=>'<span style="letter-spacing: 0.5px; font-weight: bold;">'.$reg->nombre.'</span>',
				"2"=>$reg->tipo,
        "3"=>'<span style="letter-spacing: 0.5px; font-weight: bold; color:black; font-size:13px;">Talla : </span>'.'&nbsp&nbsp&nbsp'.'<span style="letter-spacing: 0.5px; font-weight: bold; color:#c74535; font-size:17px;"> "'.$reg->abreviatura.'"</span>',
        "4"=>$reg->descripcion,
				"5"=>($reg->condicion)?'<span class="label bg-olive">Activado</span>' :  '<span class="label bg-red">Desactivado</span>'
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
