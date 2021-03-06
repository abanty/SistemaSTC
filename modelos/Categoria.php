<?php
//Incluimos inicialmente la conexion de la base de datos
require	"../config/Conexion.php";

Class Categoria
{

	//Implementando constructor
	public function __construct()
	{

	}

	//Implementamos un metodo para inserta registros
	public function insertar($abreviatura,$nombre,$descripcion)
	{
		$sql="INSERT INTO categoria (abreviatura,nombre,descripcion,condicion)
		VALUES ('$abreviatura','$nombre','$descripcion','1')";
		return ejecutarConsulta($sql);
	}

	//Implementar un metodo para editar registros
	public function editar($idcategoria,$abreviatura,$nombre,$descripcion)
	{
		$sql = "UPDATE categoria SET abreviatura='$abreviatura',nombre='$nombre',descripcion='$descripcion'
		WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un metodo para desactivar categorias
	public function desactivar($idcategoria)
	{
		$sql="UPDATE categoria SET condicion='0' WHERE idcategoria = '$idcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un metodo para activar categorias
	public function activar($idcategoria)
	{
		$sql="UPDATE categoria SET condicion='1' WHERE idcategoria = '$idcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementar un metodo para mostrar los datos de un registro a modificar
	public function mostrar ($idcategoria)
	{
		$sql="SELECT * FROM categoria WHERE idcategoria='$idcategoria'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un metodo para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM categoria
		WHERE nombre not like '-'
		ORDER BY idcategoria DESC";
		return ejecutarConsulta($sql);
	}

	//Implementar un metodo para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM categoria WHERE condicion=1";
		return ejecutarConsulta($sql);
	}

}








 ?>
