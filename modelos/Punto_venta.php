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
		$sql="SELECT pu.idproducto, pu.idalmacen, pu.stock, p.nombre as producto,p.imagen as imagen,p.descripcion, al.nombre as almacen
    FROM producto_ubicacion pu
    INNER JOIN almacen al ON pu.idalmacen = al.idalmacen
    INNER JOIN producto p ON p.idproducto = pu.idproducto
    WHERE al.idalmacen = '1'";
		return ejecutarConsulta($sql);
	}

  //Lista #2
	public function listar_productos_ubicacion_puntov()
	{
		$sql="SELECT pu.idproducto, pu.idalmacen, pu.stock, p.nombre as producto,p.imagen as imagen,p.descripcion, al.nombre as almacen
    FROM producto_ubicacion pu
    INNER JOIN almacen al ON pu.idalmacen = al.idalmacen
    INNER JOIN producto p ON p.idproducto = pu.idproducto
    WHERE al.idalmacen = '2'";
		return ejecutarConsulta($sql);
	}

}

?>
