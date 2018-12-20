<?php
//Incluimos inicialmente la conexion de la base de datos
require	"../config/Conexion.php";

Class Punto_venta
{
	//Implementando constructor
	public function __construct()
	{

	}

	//Listar #1
	public function listar_productos_ubicacion_almacen()
	{
		$sql="SELECT lower(DATE_FORMAT(pu.fecha_ingreso,'%e/%c/%Y - %h:%i %p')) as fecha_ingreso,pu.fecha_registro ,pu.idproducto, pu.idalmacen, SUM(pu.stock) as stock, p.nombre as producto,p.imagen as imagen,p.descripcion, al.nombre as almacen
    FROM producto_ubicacion pu
    INNER JOIN almacen al ON pu.idalmacen = al.idalmacen
    INNER JOIN producto p ON p.idproducto = pu.idproducto
    WHERE al.idalmacen = '1'
GROUP BY `pu`.`idproducto` ASC";
		return ejecutarConsulta($sql);
	}

	//Listar #1.5
	public function listar_productos_ubicacion_almacen_valorizado()
	{
		$sql="SELECT lower(DATE_FORMAT(pu.fecha_ingreso,'%e/%c/%Y - %h:%i %p')) as fecha_ingreso,pu.fecha_registro ,pu.idproducto, pu.idalmacen, pu.stock, p.nombre as producto,p.imagen as imagen,p.descripcion, al.nombre as almacen
    FROM producto_ubicacion pu
    INNER JOIN almacen al ON pu.idalmacen = al.idalmacen
    INNER JOIN producto p ON p.idproducto = pu.idproducto
    WHERE al.idalmacen = '1'";
		return ejecutarConsulta($sql);
	}

  //Lista #2
	public function listar_productos_ubicacion_puntov()
	{
		$sql="SELECT lower(DATE_FORMAT(pu.fecha_ingreso,'%e/%c/%Y - %h:%i %p')) as fecha_ingreso,pu.fecha_registro ,pu.idproducto, pu.idalmacen, SUM(pu.stock) as stock, p.nombre as producto,p.imagen as imagen,p.descripcion, al.nombre as almacen
    FROM producto_ubicacion pu
    INNER JOIN almacen al ON pu.idalmacen = al.idalmacen
    INNER JOIN producto p ON p.idproducto = pu.idproducto
    WHERE al.idalmacen = '2'
GROUP BY `pu`.`idproducto` ASC";
		return ejecutarConsulta($sql);
	}

	//Lista #2
	public function listar_productos_ubicacion_puntov_valorizado()
	{
		$sql="SELECT lower(DATE_FORMAT(pu.fecha_ingreso,'%e/%c/%Y - %h:%i %p')) as fecha_ingreso,pu.fecha_registro ,pu.idproducto, pu.idalmacen, pu.stock, p.nombre as producto,p.imagen as imagen,p.descripcion, al.nombre as almacen
    FROM producto_ubicacion pu
    INNER JOIN almacen al ON pu.idalmacen = al.idalmacen
    INNER JOIN producto p ON p.idproducto = pu.idproducto
    WHERE al.idalmacen = '2'";
		return ejecutarConsulta($sql);
	}

}

?>
