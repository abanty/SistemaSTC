<?php
//Incluimos inicialmente la conexion de la base de datos
require	"../config/Conexion.php";

Class Consultas
{

	//Implementando constructor
	public function __construct()
	{

	}

	public function costo_total_almaceng(){
		$sql="SELECT IFNULL(SUM((pu.stock * pu.precio_compra)),0) as total_costo_alm_gen
			FROM producto_ubicacion pu
			inner join producto p on p.idproducto = pu.idproducto
			inner join almacen al on al.idalmacen = pu.idalmacen
			where pu.idalmacen = '1'";
		return ejecutarConsulta($sql);
	}

	public function costo_total_puntov(){
		$sql="SELECT IFNULL(SUM((pu.stock * pu.precio_compra)),0) as total_costo_pun_ven
			FROM producto_ubicacion pu
			inner join producto p on p.idproducto = pu.idproducto
			inner join almacen al on al.idalmacen = pu.idalmacen
			where pu.idalmacen = '2'";
		return ejecutarConsulta($sql);
	}

  public function comprasfecha($fecha_inicio,$fecha_fin)
  {
    $sql="SELECT DATE(i.fecha_hora) as fecha,u.nombre as usuario, p.nombre as proveedor,
    i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,
    i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona
    INNER JOIN usuario u ON i.idusuario=u.idusuario
    WHERE DATE(i.fecha_hora)>='$fecha_inicio' AND DATE(i.fecha_hora)<='$fecha_fin'";
    return ejecutarConsulta($sql);
  }

	public function ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente)
	{
		$sql="SELECT DATE(v.fecha_hora) as fecha,u.nombre as usuario, p.nombre as cliente,
		v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado
		FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario
		WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.idcliente='$idcliente'";
		return ejecutarConsulta($sql);
	}

	public function totalcomprahoy()
	{
		$sql="SELECT IFNULL(SUM(total_compra),0) as total_compra
		FROM ingreso
		WHERE DATE(fecha_hora)=curdate()";
		return ejecutarConsulta($sql);
	}


	public function totalbeneficiohoy()
	{
		$sql="SELECT IFNULL(SUM(dv.cantidad*dv.precio_venta-dv.descuento) - SUM(dv.cantidad * (SELECT precio_compra FROM detalle_ingreso WHERE idlote = dv.idlote and idproducto = dv.idproducto order by iddetalle_ingreso desc limit 0,1)),0) as total_beneficio_hoy
		 FROM detalle_venta dv inner join producto a on dv.idproducto=a.idproducto
		 inner join venta v on v.idventa = dv.idventa
		 where dv.estado = 'valido' AND DATE(v.fecha_hora)=curdate()";
		return ejecutarConsulta($sql);
	}


	public function costo_total_almacenes()
	{
		$sql="SELECT IFNULL(SUM((pu.stock * pu.precio_compra)),0) as total_costo_almacenes
			FROM producto_ubicacion pu
			inner join producto p on p.idproducto = pu.idproducto
			inner join almacen al on al.idalmacen = pu.idalmacen";
		return ejecutarConsulta($sql);
	}

	public function totalventahoy()
	{
		$sql="SELECT IFNULL(SUM(total_venta),0) as total_venta
		FROM venta
		WHERE DATE(fecha_hora)=curdate()";
		return ejecutarConsulta($sql);
	}

	public function comprasultimos_10dias()
	{
		$sql="SELECT CONCAT(DAY(fecha_hora),'-',MONTH(fecha_hora))
		as fecha,SUM(total_compra) as total
		FROM ingreso GROUP by fecha_hora ORDER BY fecha_hora DESC limit 0,10";
		return ejecutarConsulta($sql);
	}

		public function ventasultimos_12meses()
		{
			$sql="SELECT DATE_FORMAT(fecha_hora,'%M') as fecha,SUM(total_venta) as total
			FROM venta GROUP by MONTH(fecha_hora) ORDER BY fecha_hora DESC limit 0,10";
			return ejecutarConsulta($sql);
		}



}








 ?>
