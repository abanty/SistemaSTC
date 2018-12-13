<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";


Class Nota_almacen
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idalmacen,$idproducto,$idusuario,$nota,$fecha_nota)
	{
		$sql="INSERT INTO nota_almacen(idalmacen,idproducto,idusuario,nota,fecha_nota,estado,fecha_interna)
		VALUES ('$idalmacen','$idproducto','$idusuario','$nota','$fecha_nota','Pendiente',CURRENT_TIMESTAMP())";
	return ejecutarConsulta($sql);
	}

  public function editar($idnota_almacen,$idalmacen,$idproducto,$idusuario,$nota,$fecha_nota)
  {
    $sql = "UPDATE nota_almacen SET idalmacen='$idalmacen',idproducto='$idproducto',idusuario='$idusuario',nota='$nota',
    fecha_nota ='$fecha_nota' WHERE idnota_almacen='$idnota_almacen'";
    return ejecutarConsulta($sql);
  }

  //Método para anular nota de almacen
  public function anular($idnota_almacen)
  {
    $sql="UPDATE nota_almacen SET estado='Anulado' WHERE idnota_almacen='$idnota_almacen'";
    return ejecutarConsulta($sql);
  }

  public function mostrar ($idnota_almacen)
  {
    $sql="SELECT p.imagen,na.idnota_almacen,na.idalmacen,na.idproducto,na.idusuario,na.nota,na.fecha_nota,na.estado,p.nombre as producto, al.nombre as almacen,
    u.nombre as usuario FROM nota_almacen na
    INNER JOIN producto p ON na.idproducto = p.idproducto
    INNER JOIN almacen al ON na.idalmacen = al.idalmacen
    INNER JOIN usuario u ON na.idusuario = u.idusuario
    WHERE idnota_almacen='$idnota_almacen'";
    return ejecutarConsultaSimpleFila($sql);
  }

	public function mostrarImagen ($idproducto)
	{
		$sql="SELECT * FROM producto
		WHERE idproducto='$idproducto'";
		return ejecutarConsultaSimpleFila($sql);
	}

  public function listarNotasAlmacen()
  {
    $sql="SELECT na.idnota_almacen,na.idalmacen,na.idproducto,na.idusuario,na.nota,na.fecha_nota,na.estado,p.nombre as producto, al.nombre as almacen,
    u.nombre as usuario FROM nota_almacen na
    INNER JOIN producto p ON na.idproducto = p.idproducto
    INNER JOIN almacen al ON na.idalmacen = al.idalmacen
    INNER JOIN usuario u ON na.idusuario = u.idusuario";
    return ejecutarConsulta($sql);
  }

}
?>
