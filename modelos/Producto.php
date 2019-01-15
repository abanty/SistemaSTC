<?php
//Incluimos inicialmente la conexion de la base de datos
require	"../config/Conexion.php";

Class Producto
{
	// _ _ _ _ _ _ _ _ _ _ _ _ _ _ _
	// IMPLEMENTACION DE CONSTRUCTOR |
	// ------------------------------
	public function __construct()
	{

	}
  //-------------------------------------------------
	//MÉTODO PARA INSERTAR REGISTROS |
	//-------------------------------------------------
	public function insertar($idcategoria,$idmarca,$idunidadmedida,$idtipoproducto,$codigo,$nombre,$descripcion,$imagen,$abreviatura)
	{


		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idunidadmedida))
		{

			$sql_detalle = "INSERT INTO producto(idcategoria,idmarca,idunidadmedida,idtipoproducto,codigo,nombre,descripcion,imagen,condicion)
			VALUES ('$idcategoria','$idmarca','$idunidadmedida[$num_elementos]','$idtipoproducto','$codigo-$sql_talla[$num_elementos]','$nombre','$descripcion','$imagen','1')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}
		return $sw;

	}
	//-----------------------------
	//MÉTODO PARA EDITAR REGISTROS |
	//-----------------------------
	public function editar($idproducto,$idcategoria,$idmarca,$idunidadmedida,$idtipoproducto,$codigo,$nombre,$descripcion,$imagen)
	{
		$num_elementos=0;
			$sw=true;

			while ($num_elementos < count($idunidadmedida))
			{
				$sql_detalle_edit = "UPDATE producto SET idcategoria='$idcategoria',idmarca='$idmarca',idunidadmedida='$idunidadmedida[$num_elementos]',idtipoproducto='$idtipoproducto',
				codigo ='$codigo',nombre='$nombre',descripcion='$descripcion',imagen ='$imagen'
				WHERE idproducto='$idproducto'";
				ejecutarConsulta($sql_detalle_edit) or $sw = false;
				$num_elementos=$num_elementos + 1;
			}
			return $sw;
	}
	//---------------------------------
	//MÉTODO PARA DESACTIVAR PRODUCTOS |
	//---------------------------------
	public function desactivar($idproducto)
	{
		$sql="UPDATE producto SET condicion='0' WHERE idproducto = '$idproducto'";
		return ejecutarConsulta($sql);
	}
	//------------------------------
	//MÉTODO PARA ACTIVAR PRODUCTOS |
	//------------------------------
	public function activar($idproducto)
	{
		$sql="UPDATE producto SET condicion='1' WHERE idproducto = '$idproducto'";
		return ejecutarConsulta($sql);
	}
	//---------------------------------------------------------
	//MÉTODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR |
	//---------------------------------------------------------
	public function mostrar ($idproducto)
	{
		$sql="SELECT a.idproducto,a.idcategoria,a.idmarca,a.idunidadmedida,a.idtipoproducto, a.codigo,a.nombre,a.descripcion,a.imagen,a.condicion,
					c.nombre as categoria,m.nombre as marca, um.nombre as unidadmedida, um.abreviatura as abreviatura, tp.nombre as tipoproducto
					FROM producto a
					INNER JOIN categoria c ON a.idcategoria = c.idcategoria
					INNER JOIN marca m ON a.idmarca = m.idmarca
					INNER JOIN unidadmedida um ON a.idunidadmedida = um.idunidadmedida
					INNER JOIN tipoproducto tp ON a.idtipoproducto = tp.idtipoproducto WHERE idproducto='$idproducto'";
		return ejecutarConsultaSimpleFila($sql);
	}
	//---------------------------------
	//MÉTODO PARA LISTAR LOS PRODUCTOS |
	//---------------------------------
	public function listar()
	{
		$sql="SELECT a.idproducto,a.idcategoria,a.idmarca,a.idunidadmedida,a.idtipoproducto, a.codigo,a.nombre,a.descripcion,a.imagen,a.condicion,
					c.nombre as categoria,m.nombre as marca, um.nombre as unidadmedida, um.abreviatura as abreviatura, tp.nombre as tipoproducto
					FROM producto a
					INNER JOIN categoria c ON a.idcategoria = c.idcategoria
					INNER JOIN marca m ON a.idmarca = m.idmarca
					INNER JOIN unidadmedida um ON a.idunidadmedida = um.idunidadmedida
					INNER JOIN tipoproducto tp ON a.idtipoproducto = tp.idtipoproducto
					ORDER BY a.idproducto DESC";
		return ejecutarConsulta($sql);
	}
	//---------------------------------
	//MÉTODO PARA LISTAR LOS REGISTROS ACTIVOS |
	//---------------------------------
	public function listarActivos()
	{
		$sql="SELECT a.idproducto,a.idcategoria,a.idmarca,a.idunidadmedida,a.idtipoproducto, a.codigo,a.nombre,a.descripcion,a.imagen,a.condicion,
		c.nombre as categoria,m.nombre as marca, um.nombre as unidadmedida, um.abreviatura as abreviatura, tp.nombre as tipoproducto
		FROM producto a
		INNER JOIN categoria c ON a.idcategoria = c.idcategoria
		INNER JOIN marca m ON a.idmarca = m.idmarca
		INNER JOIN unidadmedida um ON a.idunidadmedida = um.idunidadmedida
		INNER JOIN tipoproducto tp ON a.idtipoproducto = tp.idtipoproducto
		WHERE a.condicion='1'";
		return ejecutarConsulta($sql);
	}

//  MÉTODO PARA LISTAR ACTIVOS DE VENTA
	public function listarActivosAlmacen($idalmacen)
	{
		$sql="SELECT lower(DATE_FORMAT(pu.fecha_ingreso,'%e/%c/%Y - %h:%i %p')) as fecha_ingreso,pu.idlote, pu.idproducto, pu.idalmacen as idalmacen, pu.stock, p.nombre as producto,p.imagen as imagen,
		p.descripcion as descripcion,ca.nombre as categoria, u.abreviatura as abreviatura, p.codigo as codigo,p.idcategoria,p.idmarca,p.idunidadmedida,al.nombre as almacen,
		(SELECT precio_venta FROM detalle_ingreso
		WHERE idproducto=pu.idproducto
		order by iddetalle_ingreso desc limit 0,1) as precio_venta,
		(SELECT precio_compra FROM detalle_ingreso
		WHERE idproducto=pu.idproducto
		order by iddetalle_ingreso desc limit 0,1) as precio_compra
		FROM producto_ubicacion pu
		INNER JOIN almacen al ON pu.idalmacen = al.idalmacen
		INNER JOIN producto p ON p.idproducto = pu.idproducto
		INNER JOIN categoria ca ON ca.idcategoria = p.idcategoria
		INNER JOIN marca ma ON ma.idmarca = p.idmarca
		INNER JOIN unidadmedida u ON u.idunidadmedida = p.idunidadmedida
		WHERE  p.condicion = '1' AND pu.idalmacen = '$idalmacen'";
		return ejecutarConsulta($sql);
	}



		//---------------------------------
		//MÉTODO PARA LISTAR ACTIVOS DE VENTA |
		//---------------------------------
		// public function listarActivosVenta2()
		// {
		// 	$sql="SELECT a.idproducto,a.idcategoria,c.nombre as categoria,
		// 	a.codigo as codigo,a.descripcion as descripcion,a.nombre as producto,(SELECT precio_venta FROM detalle_ingreso
		// 	WHERE idproducto=a.idproducto
		// 	order by iddetalle_ingreso desc limit 0,1) as precio_venta,
		// 	a.imagen as imagen,a.condicion
		// 	FROM producto a INNER JOIN categoria c ON a.idcategoria=c.idcategoria
		// 	WHERE a.condicion='1'";
		// 	return ejecutarConsulta($sql);
		// }


	//---------------------------------
	//MÉTODO PARA LISTAR LOS PRODUCTOS AUTOCOMPLETE |
	//---------------------------------
	public function listarautocomplete($nombre)
	{
		$sql="SELECT idproducto,nombre,stock FROM producto WHERE nombre like '%$nombre%' ORDER BY nombre desc limit 10";
		return ejecutarConsulta($sql);
	}

	/*-------------------------------------------------------*
	|FUNCION PARA GENERAR CODIGOS DE PRODUCTOS ALEATORIAMENTE|
	.-------------------------------------------------------*/
	public function generarCodigo($longitud, $tipo=0)
	{
		$codigo = "";
		$caracteres="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$max=strlen($caracteres)-1;
		for($i=0;$i < $longitud;$i++)
			{
				$codigo.=$caracteres[rand(0,$max)];
			}
		return $codigo;
	}

}
 ?>
