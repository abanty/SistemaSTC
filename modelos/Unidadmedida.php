<?php
//Incluimos inicialmente la conexion de la base de datos
require	"../config/Conexion.php";

Class Unidadmedida
{



//IMPLEMENTACION DE CONSTRUCTOR
	public function __construct()
	{

	}

//MÉTODO PARA INSERTAR REGISTROS
	public function insertar($nombre,$tipo,$abreviatura,$descripcion)
	{
		$sql="INSERT INTO unidadmedida (nombre,tipo,abreviatura,descripcion,condicion)
		VALUES ('$nombre','$tipo','$abreviatura','$descripcion','1')";
		return ejecutarConsulta($sql);
	}

//MÉTODO PARA EDITAR REGISTROS
	public function editar($idunidadmedida,$nombre,$tipo,$abreviatura,$descripcion)
	{
		$sql = "UPDATE unidadmedida SET idunidadmedida='$idunidadmedida',nombre='$nombre',
    tipo='$tipo',abreviatura='$abreviatura',descripcion='$descripcion'
		WHERE idunidadmedida='$idunidadmedida'";
		return ejecutarConsulta($sql);
	}

//MÉTODO PARA DESACTIVAR UNIDAD DE MEDIDA
	public function desactivar($idunidadmedida)
	{
		$sql="UPDATE unidadmedida SET condicion='0' WHERE idunidadmedida = '$idunidadmedida'";
		return ejecutarConsulta($sql);
	}

//MÉTODO PARA ACTIVAR UNIDAD DE MEDIDA
	public function activar($idunidadmedida)
	{
		$sql="UPDATE unidadmedida SET condicion='1' WHERE idunidadmedida = '$idunidadmedida'";
		return ejecutarConsulta($sql);
	}

//MÉTODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
	public function mostrar ($idunidadmedida)
	{
		$sql="SELECT * FROM unidadmedida WHERE idunidadmedida='$idunidadmedida'";
		return ejecutarConsultaSimpleFila($sql);
	}

//MÉTODO PARA LISTAR LAS UNIDAD DE MEDIDA
	public function listar()
	{
		$sql="SELECT * FROM unidadmedida";
		return ejecutarConsulta($sql);
	}

//MÉTODO PARA SELECIONAR UNIDAD DE MEDIDA
  public function selectunidadmedida()
  {
    $sql="SELECT * FROM unidadmedida";
    return ejecutarConsulta($sql);
  }


}
 ?>
