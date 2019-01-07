# SistemaSTC
Sistema de Gestion para Almacenes
# PRIMERA VERSION EN DESPLIEGE STCV001

# SEGUNDA VERSION EN DESPLIEGE STCV001



# FRAGMENT CODE:

// }


		// extract($_POST);
		//     $error=array();
		//     $extension=array("jpeg","jpg","png","gif");
		//     foreach($_FILES["imagen"]["tmp_name"] as $key=>$tmp_name)
		//             {
		//                 $file_name=$_FILES["imagen"]["name"][$key];
		//                 $file_tmp=$_FILES["imagen"]["tmp_name"][$key];
		//                 $ext=pathinfo($file_name,PATHINFO_EXTENSION);
		//                 if(in_array($ext,$extension))
		//                 {
		//                     if(!file_exists("../files/productos/".$file_name))
		//                     {
		// 											$imagen=$_POST["imagenactual"];
		//                         // move_uploaded_file($file_tmp=$_FILES["imagen"]["tmp_name"][$key],"../files/productos/".$file_name);
		//                     }
		//                     else
		//                     {

													// $ext = explode(".", $_FILES["imagen"]["name"]);
																// if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
																// {
																// 	$imagen = round(microtime(true)) . '.' . end($ext);
																// 	move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/productos/" . $imagen);
																// }

													// $imagen = round(microtime(true)) . '.' . end($ext);
													// 		move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/productos/" . $imagen);
								//
		            //             $filename=basename($file_name,$ext);
		            //             $imagen=$filename.time().".".$ext;
		            //             move_uploaded_file($file_tmp=$_FILES["imagen"]["tmp_name"][$key],"../files/productos/".$imagen);
		            //         }
		            //     }
		            //     else
		            //     {
		            //         array_push($error,"$file_name, ");
		            //     }
		            // }

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
