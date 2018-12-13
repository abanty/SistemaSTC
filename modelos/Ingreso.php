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
	public function insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$idalmacen,$idproducto,$cantidad,$importe,$precio_compra,$precio_venta,$ganancia,$ganancianeta)
	{
		$sql="INSERT INTO ingreso (idproveedor,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_compra,estado)
  VALUES ('$idproveedor','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_compra','Aceptado')";
		// return ejecutarConsulta($sql);
		$idingresonew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idproducto))
		{
			$sqllist= "SELECT * FROM producto_ubicacion WHERE idproducto = '$idproducto[$num_elementos]' AND idalmacen = '$idalmacen'";
			$sqllist_result = ejecutarConsultaSimpleFila($sqllist);

			if (count($sqllist_result)>0) {

			}else {
				$sqlproducto_ubicacacion="INSERT INTO producto_ubicacion (idproducto,idalmacen)
				 VALUES ('$idproducto[$num_elementos]','$idalmacen')";
				 ejecutarConsulta($sqlproducto_ubicacacion);
			}

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
		$sql="SELECT i.idingreso,DATE(i.fecha_hora) as fecha,i.idproveedor,p.nombre as proveedor,
    u.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,
    i.total_compra,i.impuesto,i.estado
    FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u
    ON i.idusuario=u.idusuario WHERE idingreso='$idingreso'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idingreso)
	{
		$sql="SELECT di.idingreso,di.idproducto,a.nombre,di.cantidad,di.precio_compra,di.precio_venta,di.gananciaporcentaje,di.ganancianeta
		FROM detalle_ingreso di INNER JOIN producto a ON di.idproducto=a.idproducto
		WHERE di.idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}


	//Implementar un metodo para listar los registros
	public function listar()
	{
		$sql="SELECT i.idingreso,DATE(i.fecha_hora) as fecha,i.idproveedor,p.nombre as proveedor,
    u.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,
    i.total_compra,i.impuesto,i.estado
    FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u
    ON i.idusuario=u.idusuario
		ORDER BY i.idingreso desc";
		return ejecutarConsulta($sql);
	}

}

?>
