<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";


Class Venta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$idproducto,$idalmacen,$idlote,$cantidad,$precio_venta,$descuento)
	{
		$sql="INSERT INTO venta (idcliente,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_venta,estado)
		VALUES ('$idcliente','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_venta','Aceptado')";
		//return ejecutarConsulta($sql);
		$idventanew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idproducto))
		{
			$sql_detalle = "INSERT INTO detalle_venta(idventa,idproducto,idalmacen,idlote,cantidad,precio_venta,descuento) VALUES ('$idventanew','$idproducto[$num_elementos]','$idalmacen[$num_elementos]','$idlote[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}
		return $sw;
	}


	//Implementamos un método para anular la venta
	public function anular($idventa)
	{
		$sql="UPDATE venta SET estado='Anulado' WHERE idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para anular el detalle de venta
	public function anulardetalle($iddetalle_venta)
	{
		$sql="UPDATE detalle_venta SET estado=0 WHERE iddetalle_venta='$iddetalle_venta'";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventa)
	{
		$sql="SELECT v.idventa,DATE_FORMAT(v.fecha_hora,'%Y-%m-%dT%h:%i') as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v
		INNER JOIN persona p ON v.idcliente=p.idpersona
		INNER JOIN usuario u ON v.idusuario=u.idusuario
		WHERE v.idventa='$idventa'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idventa)
	{
		$sql="SELECT dv.iddetalle_venta,dv.idventa,dv.idproducto,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,
    (dv.cantidad*dv.precio_venta-dv.descuento) as subtotal,dv.estado
    FROM detalle_venta dv inner join producto a on dv.idproducto=a.idproducto
    where dv.idventa='$idventa' AND dv.estado = '1'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT v.idventa, lower(DATE_FORMAT(v.fecha_hora,'%e/%c/%Y - %h:%i %p')) as fecha ,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre
    as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado
    FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u
    ON v.idusuario=u.idusuario ORDER by v.idventa desc";
		return ejecutarConsulta($sql);
	}

	public function ventacabecera($idventa){
		$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,
		p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,
		v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,
		v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta
		FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona
		INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	public function ventadetalle($idventa){
		$sql="SELECT a.nombre as producto,a.codigo,d.cantidad,d.precio_venta,
		d.descuento,(d.cantidad*d.precio_venta-d.descuento) as subtotal
		FROM detalle_venta d INNER JOIN producto a ON d.idproducto=a.idproducto
		WHERE d.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}


}
?>
