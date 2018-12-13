<?php
//Incluimos inicialmente la conexion de la base de datos
require	"../config/Conexion.php";

Class Tipoproducto
{



//IMPLEMENTACION DE CONSTRUCTOR
	public function __construct()
	{

	}

//MÉTODO PARA INSERTAR REGISTROS
	public function insertar($nombre,$descripcion)
	{
		$sql="INSERT INTO tipoproducto (nombre,descripcion,condicion)
		VALUES ('$nombre','$descripcion','1')";
		return ejecutarConsulta($sql);
	}

//MÉTODO PARA EDITAR REGISTROS
	public function editar($idtipoproducto,$nombre,$descripcion)
	{
		$sql = "UPDATE tipoproducto SET idtipoproducto='$idtipoproducto',nombre='$nombre',descripcion='$descripcion'
		WHERE idtipoproducto='$idtipoproducto'";
		return ejecutarConsulta($sql);
	}

//MÉTODO PARA DESACTIVAR TIPO DE PRODUCTOS
	public function desactivar($idtipoproducto)
	{
		$sql="UPDATE tipoproducto SET condicion='0' WHERE idtipoproducto = '$idtipoproducto'";
		return ejecutarConsulta($sql);
	}

//MÉTODO PARA ACTIVAR TIPO DE PRODUCTOS
	public function activar($idtipoproducto)
	{
		$sql="UPDATE tipoproducto SET condicion='1' WHERE idtipoproducto = '$idtipoproducto'";
		return ejecutarConsulta($sql);
	}

//MÉTODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
	public function mostrar ($idtipoproducto)
	{
		$sql="SELECT * FROM tipoproducto WHERE idtipoproducto='$idtipoproducto'";
		return ejecutarConsultaSimpleFila($sql);
	}

//MÉTODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
	public function listar()
	{
		$sql="SELECT * FROM tipoproducto
		WHERE nombre not like '-'
		ORDER BY idtipoproducto DESC";
		return ejecutarConsulta($sql);
	}

//MÉTODO PARA SELECIONAR TIPO DE PRODUCTOS
  public function selecttipoproducto()
  {
    $sql="SELECT * FROM tipoproducto";
    return ejecutarConsulta($sql);
  }


}
 ?>
