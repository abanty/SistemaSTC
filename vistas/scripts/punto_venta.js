var tabla;

//Función que se ejecuta al inicio
function init(){


	listar_punto_stock_valorizado();


	listar_almacen_stock();


  listar_punto_stock();


	listar_almacen_stock_valorizado();


} //FIN INIT


// TODO: FUNCION LISTAR PRODUCTOS ALMACEN
function listar_almacen_stock()
{

	tabla=$('#tbllistadoalm').dataTable(
		{
				"aProcessing": true, //Activamos el procesamiento del datatables
				"aServerSide": true, //Paginacion y filtrado realizados por el servidor
				dom: 'Bfrtip',         //Definimos los elementos del control de tabla
		  	buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf', 'print'],
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


// TODO: FUNCION LISTAR PRODUCTOS ALMACEN - VALORIZADO
function listar_almacen_stock_valorizado()
{

	tabla=$('#tbllistadoalm2').dataTable(
		{
				"aProcessing": true,
				"aServerSide": true,
				dom: 'Bfrtip',
				buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf', 'print'],
				columnDefs:[
					{"visible": false, "targets":1}
				],
	"ajax":
			{
				url: '../ajax/punto_venta.php?op=listar_pu_ag_val',
				type : "get",
				dataType : "json",
				error: function(e){
					console.log(e.responseText);
				}
			},
		"bDestroy": true,
		"iDisplayLength": 7,
	   "order": [[ 1, "asc" ]],
		 rowGroup: {
					 startRender: function ( rows, group ) {
							 return 'Fecha y Hora de Lote -' + group + ' ('+rows.count()+' productos)';
					 },
					dataSrc: 1
			}
	}).DataTable();
}


// TODO: FUNCION PARA MOSTRAR IMAGEN MODAL
function mostrarclick(imagen){
		$(".imagepreview").attr("src",imagen);
		$('#imagemodal').modal('show');
	}


// TODO: FUNCION LISTAR PRORDUCTOS - PUNTO DE VENTA
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

// TODO: FUNCION LISTAR PRODUCTOS ALMACEN - VALORIZADO
function listar_punto_stock_valorizado()
{

	tabla=$('#tbllistadopuntov2').dataTable(
		{
				"aProcessing": true,
				"aServerSide": true,
				dom: 'Bfrtip',
				buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf', 'print'],
				columnDefs:[
					{"visible": false, "targets":1}
				],
	"ajax":
			{
				url: '../ajax/punto_venta.php?op=listar_pu_pv_val',
				type : "get",
				dataType : "json",
				error: function(e){
					console.log(e.responseText);
				}
			},
		"bDestroy": true,
		"iDisplayLength": 7,
	   "order": [[ 1, "asc" ]],
		 rowGroup: {
					 startRender: function ( rows, group ) {
							 return 'Fecha y Hora de Lote -' + group + ' ('+rows.count()+' productos)';
					 },
					dataSrc: 1
			}
	}).DataTable();
}


init();
