<?php
require_once "../modelos/Producto.php";

$producto=new Producto();

$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$idmarca=isset($_POST["idmarca"])? limpiarCadena($_POST["idmarca"]):"";
// $idunidadmedida=isset($_POST["idunidadmedida"])? limpiarCadena($_POST["idunidadmedida"]):"";
$idtipoproducto=isset($_POST["idtipoproducto"])? limpiarCadena($_POST["idtipoproducto"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

// 	for($x=0; $x<count($_FILES["imagen"]["name"]); $x++)
//  {
// 		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
// 		{
// 			// $imagen=$_POST["imagenactual"];
// 		}
// 		else
// 		{
// 			$ext = explode(".", $_FILES["imagen"]["name"]);
// 			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
// 			{
// 				$imagen = round(microtime(true)) . '.' . end($ext);
// 				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/productos/" . $imagen);
// 			}
// 		}
// }


		extract($_POST);
		    $error=array();
		    $extension=array("jpeg","jpg","png","gif");
		    foreach($_FILES["imagen"]["tmp_name"] as $key=>$tmp_name)
		            {
		                $file_name=$_FILES["imagen"]["name"][$key];
		                $file_tmp=$_FILES["imagen"]["tmp_name"][$key];
		                $ext=pathinfo($file_name,PATHINFO_EXTENSION);
		                if(in_array($ext,$extension))
		                {
		                    if(!file_exists("../files/productos/".$file_name))
		                    {
													$imagen=$_POST["imagenactual"];
		                        // move_uploaded_file($file_tmp=$_FILES["imagen"]["tmp_name"][$key],"../files/productos/".$file_name);
		                    }
		                    else
		                    {

													// $ext = explode(".", $_FILES["imagen"]["name"]);
																// if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
																// {
																// 	$imagen = round(microtime(true)) . '.' . end($ext);
																// 	move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/productos/" . $imagen);
																// }

													// $imagen = round(microtime(true)) . '.' . end($ext);
													// 		move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/productos/" . $imagen);

		                        $filename=basename($file_name,$ext);
		                        $imagen=$filename.time().".".$ext;
		                        move_uploaded_file($file_tmp=$_FILES["imagen"]["tmp_name"][$key],"../files/productos/".$imagen);
		                    }
		                }
		                else
		                {
		                    array_push($error,"$file_name, ");
		                }
		            }

// 		if (isset($_FILES["imagen"]))
// 		{
// 		   $reporte = null;
// 		     for($x=0; $x<count($_FILES["imagen"]["name"]); $x++)
// 		    {
// 		      $file = $_FILES["imagen"];
// 		      $nombreimagen = $file["name"][$x];
// 		      $tipo = $file["type"][$x];
// 		      $ruta_provisional = $file["tmp_name"][$x];
// 		      $size = $file["size"][$x];
// 		      $dimensiones = getimagesize($ruta_provisional);
// 		      $width = $dimensiones[0];
// 		      $height = $dimensiones[1];
// 		      $carpeta = "../files/productos/";
//
// 		      if ($tipo != 'image/jpeg' && $tipo != 'image/jpg' && $tipo != 'image/png' && $tipo != 'image/gif')
// 		      {
// 		          $reporte .= "<p style='color: red'>Error $nombreimagen, el archivo no es una imagen.</p>";
//
// 		      }
// 		      // else if($size > 1024*1024)
// 		      // {
// 		      //     $reporte .= "<p style='color: red'>Error $nombreimagen, el tamaño máximo permitido es 1mb</p>";
// 		      // }
// 		      // else if($width > 500 || $height > 500)
// 		      // {
// 		      //     $reporte .= "<p style='color: red'>Error $nombreimagen, la anchura y la altura máxima permitida es de 500px</p>";
// 		      // }
// 		      // else if($width < 60 || $height < 60)
// 		      // {
// 		      //     $reporte .= "<p style='color: red'>Error $nombreimagen, la anchura y la altura mínima permitida es de 60px</p>";
// 		      // }
// 		      else
// 		      {
// 						$ext = explode(".", $_FILES["imagen"]["name"]);
// 						$imagen = round(microtime(true)) . '.' . end($ext);
//
// 		          // $src = $carpeta.$nombreimagen;
// move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/productos/" . $imagen);
// 		          //Caragamos imagenes al servidor
// 		          // move_uploaded_file($ruta_provisional, $src);
//
// 		          //Codigo para insertar imagenes a tu Base de datos.
// 		          //Sentencia SQL
//
// 		          // echo "<p style='color: blue'>La imagen $nombreimagen ha sido subida con éxito</p>";
// 		      }
// 		    }
//
// 		    echo $reporte;
// 		}
//









		if (empty($idproducto)){
			$rspta=$producto->insertar($idcategoria,$idmarca,$_POST["idunidadmedida"],$idtipoproducto,$codigo,$nombre,$descripcion,$imagen);
			echo $rspta ? "Producto registrado" : "Producto no se pudo registrar";
		}
		else {
			$rspta=$producto->editar($idproducto,$idcategoria,$idmarca,$idunidadmedida,$idtipoproducto,$codigo,$nombre,$descripcion,$imagen);
			echo $rspta ? "Producto actualizado" : "Producto no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$producto->desactivar($idproducto);
		echo $rspta ? "Producto desactivado" : "Producto no se puede desactivar";
    break;

    case 'activar':
		$rspta=$producto->activar($idproducto);
		echo $rspta ? "Producto activado" : "Producto no se puede activar";
    break;

    case 'mostrar':
		$rspta=$producto->mostrar($idproducto);
		//codificar el resultado utilizando json
		echo json_encode($rspta);
    break;

    case 'listar':
		$rspta=$producto->listar();
		//Vamos a declarar un Array

		$data= Array();
		while ($reg=$rspta->fetch_object()){
			$imagentest=(empty($reg->imagen))?"<img src='../files/productos/defaultpro.png' height='55px' width='65px'>":'<img style="cursor: pointer;" src="../files/productos/'.$reg->imagen.'" height="55px" width="70px" onclick="mostrarclick(this.src)">';
			$data[]=array(
				"0"=>($reg->condicion)?'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
					' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idproducto.')"><i class="fa fa-close"></i></button>' :
					'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
					' <button class="btn btn-success btn-sm" onclick="activar('.$reg->idproducto.')"><i class="fa fa-check"></i></button>',
				"1"=>'<span id="span_cod" class="">'.$reg->codigo.'</span>',
				"2"=>'<span style="letter-spacing: 1px; font-size: 13px; font-weight: 700;" class="">'.$reg->nombre.'</span>',
				"3"=>$reg->marca,
				"4"=>$reg->descripcion,
				"5"=>$reg->categoria,
				"6"=>$reg->abreviatura,
				"7"=>$imagentest,
				"8"=>($reg->condicion)?'<span class="label bg-olive">Activado</span>':'<span class="label bg-red">Desactivado</span>'
				);
		}
		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
		echo json_encode($results);

	break;

	case "selectCategoria":
		require_once "../modelos/Categoria.php";
		$categoria = new Categoria();

		$rspta = $categoria->select();

	while ($reg = $rspta->fetch_object())
		{
			echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';
		}

	break;

	case "selectMarca":
		require_once "../modelos/Marca.php";
		$marca = new Marca();

		$rspta = $marca->selectmarca();

	while ($reg = $rspta->fetch_object())
		{
			echo '<option value=' . $reg->idmarca . '>' . $reg->nombre . '</option>';
		}

	break;

	case "selectUnidad":
		require_once "../modelos/Unidadmedida.php";
		$unidad = new Unidadmedida();

		$rspta = $unidad->selectunidadmedida();

	while ($reg = $rspta->fetch_object())
		{
			echo '<option value=' . $reg->idunidadmedida . '>' . $reg->abreviatura . '</option>';
		}

	break;

	case "selectTipoproducto":
		require_once "../modelos/Tipoproducto.php";
		$tipopro = new Tipoproducto();

		$rspta = $tipopro->selecttipoproducto();

	while ($reg = $rspta->fetch_object())
		{
			echo '<option value=' . $reg->idtipoproducto . '>' . $reg->nombre . '</option>';
		}

	break;
}
?>
