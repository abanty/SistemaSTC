var tabla;

//Función que se ejecuta al inicio
function init(){

	$("#stock").prop("disabled",true);

	mostrarform(false);

	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	});

	//Cargamos los items al select categoria
	$.post("../ajax/producto.php?op=selectCategoria", function(r){
				$("#idcategoria").html(r);
			  $('#idcategoria').selectpicker('refresh');
  });

	//Cargamos los items al select Marca
	$.post("../ajax/producto.php?op=selectMarca", function(r){
				$("#idmarca").html(r);
			  $('#idmarca').selectpicker('refresh');
  });

	//Cargamos los items al select Unidad de Medida
	$.post("../ajax/producto.php?op=selectUnidad", function(r){
				$("#idunidadmedida").html(r);
				$('#idunidadmedida').selectpicker('refresh');
	});

	//Cargamos los items al select Tipo de producto
	$.post("../ajax/producto.php?op=selectTipoproducto", function(r){
				$("#idtipoproducto").html(r);
				$('#idtipoproducto').selectpicker('refresh');
	});



  $("#imagenmuestra").hide();

} //FIN INIT

//Función cargar img
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imagenmuestra')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(120);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

//Función limpiar
function limpiar()
{
	// $("#codigo").val("");
	$("#nombre").val("");
	$("#stock").val("0");
	$("#descripcion").val("");
	$("#imagenmuestra").attr("src","../files/productos/defaultpro.png");
	$("#imagenactual").val("");
	$("#print").hide();
	$("#idproducto").val("");
	$("#idcategoria").val("");
	$('#idcategoria').selectpicker('refresh');
	$("#idmarca").val("");
	$('#idmarca').selectpicker('refresh');
	$("#idunidadmedida").val("");
	$('#idunidadmedida').selectpicker('refresh');
	$("#idtipoproducto").val("");
	$('#idtipoproducto').selectpicker('refresh');

}

function mostrarclick(imagen){
		$(".imagepreview").attr("src",imagen);
		$('#imagemodal').modal('show');
	}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag){
		$('#idcategoria').selectpicker('val', "");
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Funcion cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
	$("#btnagregar").prop("disabled",false);
	$("#btnagregar").show();
	CodProducto();
}

//Funcion listar
function listar()
{
	CodProducto();
	tabla=$('#tbllistado').dataTable(
		{
				"aProcessing": true, //Activamos el procesamiento del datatables
				"aServerSide": true, //Paginacion y filtrado realizados por el servidor
				dom: 'Bfrtip',         //Definimos los elementos del control de tabla
				buttons: [
					'copyHtml5',
					'excelHtml5',
					'pdf',


			],
	"ajax":
			{
				url: '../ajax/producto.php?op=listar',
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

//Funcion para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activara la accion predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/producto.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function(datos)
		{
			swal(
		(datos),
		'Satisfactoriamente!',
		'success'
		);
			mostrarform(false);
			// listar();
			tabla.ajax.reload();
		}

	});
	$("#btnagregar").show();
	limpiar();
}

function mostrar(idproducto)
{

	//$("#btnagregar").hide();
	$.post("../ajax/producto.php?op=mostrar",{idproducto : idproducto}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);
		$("#idcategoria").val(data.idcategoria);
		$('#idcategoria').selectpicker('refresh');
		$("#idmarca").val(data.idcategoria);
		$('#idmarca').selectpicker('refresh');
		$("#idunidadmedida").val(data.idcategoria);
		$('#idunidadmedida').selectpicker('refresh');
		$("#idtipoproducto").val(data.idcategoria);
		$('#idtipoproducto').selectpicker('refresh');
		$("#codigo").val(data.codigo);
		$("#nombre").val(data.nombre);
		$("#stock").val(data.stock);

		$("#descripcion").val(data.descripcion);
		$("#imagenmuestra").show();

		$("#idproducto").val(data.idproducto);

		if(data.imagen==""){
			$("#imagenmuestra").attr("src","../files/productos/defaultpro.png");
		}else {
			$("#imagenmuestra").attr("src","../files/productos/"+data.imagen);
			$("#imagenactual").val(data.imagen);
		}




	})
}

//Funcion para desactivar registros
function desactivar(idproducto)
{
	swal({
	  title: '¿Está seguro de desactivar el Producto?',
	  //text: "You won't be able to revert this!",
	  //type: 'question',
		imageUrl: '../public/img/swal-duda.jpg',
		imageWidth: 250,
		imageHeight: 250,
		animation: false,
	  showCancelButton: true,
	  confirmButtonColor: '#008d4c',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Aceptar',
		cancelButtonText: 'Cancelar'
	}).then(function (e) {
		$.post("../ajax/producto.php?op=desactivar", {idproducto : idproducto}, function(e){
			swal(
  		(e),
  		'Satisfactoriamente!',
  		'success'
		)
			tabla.ajax.reload();

		})
	}).catch(swal.noop)
}

//Funcion para activar registros
function activar(idproducto)
{
	swal({
	  title: '¿Está seguro de activar el Producto?',
	  //text: "You won't be able to revert this!",
	  //type: 'question',
		imageUrl: '../public/img/swal-duda.jpg',
  imageWidth: 250,
  imageHeight: 250,
  animation: false,
	  showCancelButton: true,
	  confirmButtonColor: '#008d4c',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Aceptar',
		cancelButtonText: 'Cancelar'
	}).then(function (e) {
		$.post("../ajax/producto.php?op=activar", {idproducto : idproducto}, function(e){
			swal(
  		(e),
  		'Satisfactoriamente!',
				'success'
			)
			tabla.ajax.reload();
		});
	}).catch(swal.noop)
}

//Funcion para generar el codigo de producto


function CodProducto(){

	$.ajax({
		url:'../modelos/CodProducto.php',
		type:'get',
		dataType:'json',
		success:function(res){
			if (res.respuesta3==true){
				if(parseInt(res.mensaje3)<10){
					$("#codigo").val("PR-00"+res.mensaje3);
				}else if(parseInt(res.mensaje3)<1000){
					$("#codigo").val("PR-0"+res.mensaje3);
				}
			}
		}
	});
}




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

init();
