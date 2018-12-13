<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";


Class Transferencia
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//METODO PARA INSERTAR REGISTROS DE LA TRANSFERENCIA
	public function insertar($almacen_origen,$almacen_destino,$fecha,$total_traspaso,$observaciones,$codigo,$idproducto,$idalmacen,$cantidad)
	{
		$sqlw="INSERT INTO transferencia(almacen_origen,almacen_destino,fecha,total_traspaso,observaciones,estado)
		VALUES ('$almacen_origen','$almacen_destino','$fecha','$total_traspaso','$observaciones','Aceptado')";

		$idtransferencianew=ejecutarConsulta_retornarID($sqlw);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idproducto))
		{
      $sqllist= "SELECT * FROM producto_ubicacion WHERE idproducto = '$idproducto[$num_elementos]' AND idalmacen = '$almacen_destino'";
      $sqllist_result = ejecutarConsultaSimpleFila($sqllist);

      if (count($sqllist_result)>0) {

      }else {
        $sqlproducto_ubicacacion="INSERT INTO producto_ubicacion (idproducto,idalmacen)
         VALUES ('$idproducto[$num_elementos]','$almacen_destino')";
         ejecutarConsulta($sqlproducto_ubicacacion);
      }


			$sql_detallex = "INSERT INTO detalle_transferencia(idtransferencia,codigo,idproducto,idalmacen,cantidad)
      VALUES ('$idtransferencianew','$codigo[$num_elementos]','$idproducto[$num_elementos]','$idalmacen[$num_elementos]','$cantidad[$num_elementos]')";
			ejecutarConsulta($sql_detallex) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}
		return $sw;
	}


//METODO PARA VERIFICAR REGISTROS DE LA TRANSFERENCIA
// public function verificar_campos_producto_ubicaicon($almacen_destino)
// {
//   $sqllist="SELECT idproducto FROM producto_ubicacion where idalmacen = '$almacen_destino' ";
//   return ejecutarConsulta($sql);
// }


//METODO PARA INSERTAR REGISTROS DE LA TRANSFERENCIA
// public function insertar_campos_productos_ubicacion($idproducto,$almacen_destino)
// {
//   $sqllist="INSERT INTO producto_ubicacion(idproducto,idalmacen,stock)
//   VALUES('$idproducto','$almacen_destino','0') ";
//   return ejecutarConsulta($sql);
// }




	//Implementamos un método para anular la venta
	// public function anular($idtransferencia)
	// {
	// 	$sql="UPDATE transferencia SET estado='Anulado' WHERE idtransferencia='$idtransferencia'";
	// 	return ejecutarConsulta($sql);
	// }


	//Implementar un método para mostrar los datos de un registro a modificar
	// public function mostrar($idventa)
	// {
	// 	$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
	// 	return ejecutarConsultaSimpleFila($sql);
	// }


//LISTAR EL DETALLE DE PRODUCTOS TRANSFERIDOS O TRASPASADOS
	// public function listarDetalleTraspaso($idventa)
	// {
	// 	$sql="SELECT dv.idventa,dv.idproducto,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,
  //   (dv.cantidad*dv.precio_venta-dv.descuento) as subtotal
  //   FROM detalle_venta dv inner join producto a on dv.idproducto=a.idproducto
  //   where dv.idventa='$idventa'";
	// 	return ejecutarConsulta($sql);
	// }

	//FUNCION PARA LISTAR TRASPASOS - REGISTROS
	public function listartransferencias()
	{
		$sql="SELECT tr.idtransferencia,tr.almacen_origen,al.nombre as origen,tr.almacen_destino,al1.nombre as destino,
     DATE(tr.fecha) as fecha,tr.total_traspaso as total_traspaso,tr.observaciones as observaciones,tr.estado as estado
     FROM transferencia tr
     INNER JOIN almacen al ON tr.almacen_origen = al.idalmacen
     INNER JOIN almacen al1 ON tr.almacen_destino = al1.idalmacen";
		return ejecutarConsulta($sql);
	}

	// public function ventacabecera($idventa){
	// 	$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,
	// 	p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,
	// 	v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,
	// 	v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta
	// 	FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona
	// 	INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
	// 	return ejecutarConsulta($sql);
	// }

	// public function ventadetalle($idventa){
	// 	$sql="SELECT a.nombre as producto,a.codigo,d.cantidad,d.precio_venta,
	// 	d.descuento,(d.cantidad*d.precio_venta-d.descuento) as subtotal
	// 	FROM detalle_venta d INNER JOIN producto a ON d.idproducto=a.idproducto
	// 	WHERE d.idventa='$idventa'";
	// 	return ejecutarConsulta($sql);
	// }


}
?>
