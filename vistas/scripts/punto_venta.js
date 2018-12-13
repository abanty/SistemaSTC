var tabla;

//Función que se ejecuta al inicio
function init(){

	listar_almacen_stock();
  listar_punto_stock();
} //FIN INIT


//Funcion listar
function listar_almacen_stock()
{

	tabla=$('#tbllistadoalm').dataTable(
		{
				"aProcessing": true, //Activamos el procesamiento del datatables
				"aServerSide": true, //Paginacion y filtrado realizados por el servidor
				dom: 'Bfrtip',         //Definimos los elementos del control de tabla
				buttons: [

					'excelHtml5',
					'pdf',


			],
	"ajax":
			{
				url: '../ajax/punto_venta.php?op=listar_pu_ag',
				type : "get",
				dataType : "json",
				error: function(e){
					console.log(e.responseText);
				}
			},
		"bDestroy": true,
		"iDisplayLength": 7, //Paginación
	    "order": [[ 0, "asc" ]] //Ordenar (columna,orden)
	}).DataTable();
}

//Funcion mostrar imagen modal
function mostrarclick(imagen){
		$(".imagepreview").attr("src",imagen);
		$('#imagemodal').modal('show');
	}

//Funcion listar
function listar_punto_stock()
{

	tabla=$('#tbllistadopuntov').dataTable(
		{
				"aProcessing": true, //Activamos el procesamiento del datatables
				"aServerSide": true, //Paginacion y filtrado realizados por el servidor
				dom: 'Bfrtip',         //Definimos los elementos del control de tabla
				buttons: [
					{
		          extend: 'excelHtml5',
		          text: 'Reportes EXCEL'
		      },
		      {
		          extend: 'pdfHtml5',
		          text: 'Reportes PDF'
		      },


			],
	"ajax":
			{
				url: '../ajax/punto_venta.php?op=listar_pu_pv',
				type : "get",
				dataType : "json",
				error: function(e){
					console.log(e.responseText);
				}
			},
		"bDestroy": true,
		"iDisplayLength": 7, //Paginación
	    "order": [[ 0, "asc" ]] //Ordenar (columna,orden)
	}).DataTable();
}


init();
