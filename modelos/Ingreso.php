<?php
//Incluimos inicialmente la conexion de la base de datos
require	"../config/Conexion.php";

Class Ingreso
{
	//Implementando constructor
	public function __construct()
	{

	}

	//Implementamos un metodo para inserta registros
	public function insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$total_venta_sugerido,$total_beneficio,$idalmacen,$idproducto,$cantidad,$importe,$precio_compra,$precio_venta,$ganancia,$ganancianeta)
	{
		$sql="INSERT INTO ingreso (idproveedor,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_compra,total_venta_sugerido,total_beneficio,estado)
  VALUES ('$idproveedor','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_compra','$total_venta_sugerido','$total_beneficio','Aceptado')";
		// return ejecutarConsulta($sql);
		$idingresonew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idproducto))
		{

				$sqlproducto_ubicacacion="INSERT INTO producto_ubicacion (idlote,idproducto,idalmacen,precio_compra,precio_venta_sugerido,fecha_ingreso,fecha_registro)
				 VALUES ('$idingresonew','$idproducto[$num_elementos]','$idalmacen','$precio_compra[$num_elementos]','$precio_venta[$num_elementos]','$fecha_hora',CURRENT_TIMESTAMP)";
				 ejecutarConsulta($sqlproducto_ubicacacion);

			$sql_detalle = "INSERT INTO detalle_ingreso(idingreso,idproducto,idalmacen,cantidad,importe,precio_compra,precio_venta,gananciaporcentaje,ganancianeta)
			VALUES ('$idingresonew', '$idproducto[$num_elementos]','$idalmacen','$cantidad[$num_elementos]','$importe[$num_elementos]','$precio_compra[$num_elementos]','$precio_venta[$num_elementos]','$ganancia[$num_elementos]','$ganancianeta[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}
		return $sw;
	}

	//Implementamos un metodo para desactivar categorias
	public function anular($idingreso)
	{
		$sql="UPDATE ingreso SET estado='Anulado' WHERE idingreso= '$idingreso'";
		return ejecutarConsulta($sql);
	}

	//Implementar un metodo para mostrar los datos de un registro a modificar
	public function mostrar ($idingreso)
	{
		$sql="SELECT i.idingreso,DATE_FORMAT(i.fecha_hora,'%Y-%m-%dT%h:%i') as fecha,i.idproveedor,p.nombre as proveedor,di.idalmacen,al.nombre as almacen,
		u.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,
		i.total_compra,i.impuesto,i.estado
		FROM ingreso i INNER JOIN detalle_ingreso di ON i.idingreso = di.idingreso INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u
		ON i.idusuario=u.idusuario INNER JOIN almacen al ON al.idalmacen = di.idalmacen
		WHERE i.idingreso='$idingreso'
		GROUP BY i.idingreso desc";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idingreso)
	{
		$sql="SELECT un.nombre as abreviatura, a.idunidadmedida, di.idingreso,di.idproducto,a.nombre,a.codigo,di.cantidad,di.importe,di.precio_compra,di.precio_venta,di.gananciaporcentaje,di.ganancianeta,i.total_compra,i.total_venta_sugerido,i.total_beneficio
		FROM detalle_ingreso di INNER JOIN producto a ON di.idproducto=a.idproducto
		INNER JOIN ingreso i ON di.idingreso = i.idingreso INNER JOIN unidadmedida un ON un.idunidadmedida = a.idunidadmedida
		WHERE di.idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}


	//Implementar un metodo para listar los registros
	public function listar()
	{
		$sql="SELECT i.idingreso,lower(DATE_FORMAT(i.fecha_hora,'%e/%c/%Y - %h:%i %p')) as fecha,i.idproveedor,p.nombre as proveedor,di.idalmacen,al.nombre as almacen,
    u.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,
    i.total_compra,i.impuesto,i.estado
    FROM ingreso i INNER JOIN detalle_ingreso di ON i.idingreso = di.idingreso INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u
    ON i.idusuario=u.idusuario INNER JOIN almacen al ON al.idalmacen = di.idalmacen
    GROUP BY i.idingreso desc";
		return ejecutarConsulta($sql);
	}

}

?>
