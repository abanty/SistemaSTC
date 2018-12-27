var tabla;

// TODO:  FUNCION QUE SE EJECUTA AL INICIO
function init(){


	$(document).ready(function(){
		$(".dataTables_filter input").focus();
	});

	$(document).keypress(function(event) {
			// event.preventDefault();
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if ($('#listadoregistros').is(":visible")) {
				if (keycode == '13') {
					mostrarform(true);
				}
			}else if($('#formulario').is(":visible")){
				// if (keycode == '13') {
				// 	$( "#btnGuardar" ).click();
				// }
			}
	});

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

// TODO: FUNCION CARGAR IMAGENES
function readURL(input) {
	// if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
	// 	 return alert(file.name + " is not an image");
	//  }

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



// TODO: FUNCION LIMPIAR
function limpiar()
{
	$("#nombre").val("");
	$("#codigo").val("");
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


// TODO: FUNCION PARA MOSTRAR IMAGEN EN MODAL CON CLICK
function mostrarclick(imagen){
		$(".imagepreview").attr("src",imagen);
		$('#imagemodal').modal('show');
	}


// TODO: FUNCION MOSTRAR EL FORMULARIO DE REGISTRO
function mostrarform(flag)
{
	$(function() {
      $("#nombre").focus();
  });

	limpiar();
	if (flag){

		$('#idcategoria').selectpicker('val', "");
		$("#listadoregistros").hide();
		$("#serchfilter").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#serchfilter").show()
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}


// TODO: FUNCION CANCELAR FORMULARIO
function cancelarform()
{
	limpiar();
	mostrarform(false);
}


// TODO: FUNCION LISTAR
function listar()
{
	tabla=$('#tbllistado').dataTable(
		{
				"aProcessing": true, //Activamos el procesamiento del datatables
				"aServerSide": true, //Paginacion y filtrado realizados por el servidor
				dom: 'Brtip',         //Definimos los elementos del control de tabla
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
	    "order": [[ 8, "asc" ]] //Ordenar (columna,orden)
	}).DataTable();
}


// TODO: FUNCION PARA GUARDAR Y EDITAR
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
			// tabla.ajax.reload();
			$('#tbllistado').DataTable().ajax.reload(null, false);
		}
	});
}


// TODO: FUNCION MOSTRAR PRODUCTOS
function mostrar(idproducto)
{
	$.post("../ajax/producto.php?op=mostrar",{idproducto : idproducto}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);
		$("#idcategoria").val(data.idcategoria);
		$('#idcategoria').selectpicker('refresh');
		$("#idmarca").val(data.idmarca);
		$('#idmarca').selectpicker('refresh');
		$("#idunidadmedida").val(data.idunidadmedida);
		$('#idunidadmedida').selectpicker('refresh');
		$("#idtipoproducto").val(data.idtipoproducto);
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


// TODO: FUNCION PARA DESACTIVAR PRODUCTOS
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


// TODO: FUNCION PARA ACTIVAR LOS PRODUCTOS
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

init();
