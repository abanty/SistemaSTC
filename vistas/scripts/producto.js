var tabla;

// TODO:  FUNCION QUE SE EJECUTA AL INICIO
function init(){

	$(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
  });

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

// TODO: FUNCION PARA GENERAR CODIGO ALEATORIAMENTE
function showcode(){
	CodProducto();
}

// TODO: FUNCION PARA REGISTRAR CATEGORIA
function registrar_categoria_modal(){

  $.confirm({
      title: '<i class="fa fa-pencil-square-o"></i> Registra una Categoria',
      content: '' +
      '<form name="formulario_categoria" id="formulario_categoria" method="POST">'+
      '<div class="form-group">' +
      '<label>Nombre Categoria</label>' +
      // '<input type="hidden" name="idcategoria" id="idcategoria"/>' +
      '<input type="text" name="nombre" id="nombre" placeholder="Ingresa nombre de la Categoria" class="name form-control" autofocus required />' +
      '</div>' +
      '</form>',
		  type: 'dark',
      buttons: {
          formSubmit: {
              text: 'Registrar',
              btnClass: 'btn-dark',
              action: function () {

                var nombre = this.$content.find('#nombre').val();
                if(!nombre){
                $.alert('Ingresa campos requeridos');
                return false;
                }else {
                  guardaryeditar_categoria();
									$.post("../ajax/producto.php?op=selectCategoria", function(r){
												$("#idcategoria").html(r);
												$('#idcategoria').selectpicker('refresh');
									});
                }
              }
          },
          cancel: function () {
              //close
          },
      },
      onContentReady: function () {
          // bind to events

          var jc = this;
          this.$content.find('#formulario_categoria').on('submit', function (e) {
              // if the user submits the form by pressing enter in the field.
              // e.preventDefault();
              jc.$$formSubmit.trigger('click'); // reference the button and click it
          });
      }
  });

}

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

	column_no = 2;
	$('#ddlSearch').on('change', function() {
		column_no = Number($(this).val());
	});

	$('#txtSearch').on('input', function() {
		if (tabla.columns([column_no]).search() !== $('#txtSearch').val()) {
			tabla.columns([column_no]).search($('#txtSearch').val()).draw();
		}
	});

	tabla=$('#tbllistado').dataTable(
		{
				"aProcessing": true,
				"aServerSide": true,
				dom: 'Brtip',
				buttons: [
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

	var buttons = new $.fn.dataTable.Buttons(tabla, {
    buttons: [
      {
          extend: 'excelHtml5',
          text: 'Reportes EXCEL'
      },
      {
          extend: 'pdfHtml5',
          text: 'Reportes PDF'
      },
			{
          extend: 'copyHtml5',
          text: 'Copiar Informacion'
      },
   ]
}).container().appendTo($('#buttons'));

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


// TODO: FUNCION PARA GUARDAR Y EDITAR
function guardaryeditar_categoria(e)
{
	// e.preventDefault(); //No se activara la accion predeterminada del evento
	var formData = new FormData($("#formulario_categoria")[0]);

	$.ajax({
		url: "../ajax/categoria.php?op=guardaryeditar",
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

/*---------------------------------------*
| FUNCION PARA GENERAR CODIGO AUTOMATICO |
.---------------------------------------*/
function CodProducto() {
  $.ajax({
    url: "../ajax/producto.php?op=codigoaleatorio",
    type: "get",
    dataType: 'json',
    success: function(data) {
      $("#codigo").val("PR-" + data);
    }
  });
}

init();
