<?php
//Incluimos inicialmente la conexion de la base de datos
require	"../config/Conexion.php";

Class Almacen
{
	//Implementando constructor
	public function __construct()
	{

	}

  //Implementar un metodo para listar los registros y mostrar en el select
  public function select_almacen()
  {
    $sql="SELECT * FROM almacen WHERE estado=1";
    return ejecutarConsulta($sql);
  }

	//FUNCION PARA LISTAR ALMACENES DONDE NO EXISTA ALMACEN COMO CONDICION
	public function select_almacen_condicion($idalmacen)
	{
		$sql="SELECT * FROM almacen WHERE estado=1 AND NOT(idalmacen = '$idalmacen') ";
		return ejecutarConsulta($sql);
	}


	//FUNCION PARA LISTAR ALMACENES DONDE NO EXISTA ALMACEN COMO CONDICION
	public function select_producto_almacen($idalmacen)
	{
		$sql="SELECT p.idproducto,p.nombre,p.imagen,p.codigo FROM producto_ubicacion pu
		INNER JOIN producto p ON pu.idproducto = p.idproducto
		INNER JOIN almacen al ON pu.idalmacen = al.idalmacen
		WHERE al.idalmacen = '$idalmacen'";
		return ejecutarConsulta($sql);
	}

}

?>
