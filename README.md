# SistemaSTC
Sistema de Gestion para Almacenes
# PRIMERA VERSION EN DESPLIEGE STCV001

# SEGUNDA VERSION EN DESPLIEGE STCV001

#ALGUNAS NOTAS


//Funcion para generar el codigo de producto


// function CodProducto(){
//
// 	$.ajax({
// 		url:'../modelos/CodProducto.php',
// 		type:'get',
// 		dataType:'json',
// 		success:function(res){
// 			if (res.respuesta3==true){
// 				if(parseInt(res.mensaje3)<10){
// 					$("#codigo").val("PR-00"+res.mensaje3);
// 				}else if(parseInt(res.mensaje3)<1000){
// 					$("#codigo").val("PR-0"+res.mensaje3);
// 				}
// 			}
// 		}
// 	});
// }

//Funcion para generar el codigo de barras
// function generarbarcode()
// {
// 	codigo=$("#codigo").val();
// 	JsBarcode("#barcode", codigo);
// 	$("#print").show();
// }

//Funcion para imrpimir el codigo de barras
// function imprimir()
// {
// 	$("#print").printArea();
// }
