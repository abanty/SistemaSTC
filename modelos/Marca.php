<?php
//Incluimos inicialmente la conexion de la base de datos
require	"../config/Conexion.php";

Class Marca
{



//IMPLEMENTACION DE CONSTRUCTOR
	public function __construct()
	{

	}

//MÉTODO PARA INSERTAR REGISTROS
	public function insertar($nombre,$descripcion)
	{
		$sql="INSERT INTO marca (nombre,descripcion,condicion)
		VALUES ('$nombre','$descripcion','1')";
		return ejecutarConsulta($sql);
	}

//MÉTODO PARA EDITAR REGISTROS
	public function editar($idmarca,$nombre,$descripcion)
	{
		$sql = "UPDATE marca SET idmarca='$idmarca',nombre='$nombre',descripcion='$descripcion'
		WHERE idmarca='$idmarca'";
		return ejecutarConsulta($sql);
	}

//MÉTODO PARA DESACTIVAR MARCAS
	public function desactivar($idmarca)
	{
		$sql="UPDATE marca SET condicion='0' WHERE idmarca = '$idmarca'";
		return ejecutarConsulta($sql);
	}

//MÉTODO PARA ACTIVAR MARCAS
	public function activar($idmarca)
	{
		$sql="UPDATE marca SET condicion='1' WHERE idmarca = '$idmarca'";
		return ejecutarConsulta($sql);
	}

//MÉTODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
	public function mostrar ($idmarca)
	{
		$sql="SELECT * FROM marca WHERE idmarca='$idmarca'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//MÉTODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
	public function listar()
	{
		$sql="SELECT * FROM marca";
		return ejecutarConsulta($sql);
	}

//MÉTODO PARA SELECIONAR MARCA
  public function selectmarca()
  {
    $sql="SELECT * FROM marca";
    return ejecutarConsulta($sql);
  }


}
 ?>
