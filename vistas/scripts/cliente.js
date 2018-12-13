var tabla;

// TODO: FUNCION QUE SE EJECUTA AL INICIO
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

				}
		});


	mostrarform(false);


	listar();


	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})


}


// TODO: FUNCION LIMPIAR
function limpiar()
{
	$("#nombre").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#idpersona").val("");
}


// TODO: FUNCION MOSTRAR FORMULARIO
function mostrarform(flag)
{
	limpiar();

	$(function() {
			$("#nombre").focus();
	});
	
	if (flag)
	{
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

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [

		        ],
		"ajax":
				{
					url: '../ajax/persona.php?op=listarc',
					type : "get",
					dataType : "json",
					error: function(e){
						console.log(e.responseText);
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activara la accion predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/persona.php?op=guardaryeditar",
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
			tabla.ajax.reload(null,false);
		}

	});
	$("#btnagregar").show();
	limpiar();
}

function mostrar(idpersona)
{
	$.post("../ajax/persona.php?op=mostrar",{idpersona : idpersona}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);

		$("#nombre").val(data.nombre);
		$("#tipo_documento").val(data.tipo_documento);
		$("#tipo_documento").selectpicker('refresh');
		$("#num_documento").val(data.num_documento);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);
 		$("#idpersona").val(data.idpersona);


 	})
}

//Función para eliminar registros
function eliminar(idpersona)
{
	swal({
	  title: '¿Está seguro de eliminar el cliente?',
	  //text: "You won't be able to revert this!",
	  //type: 'question',
		imageUrl: 'http://img.freepik.com/vector-gratis/trabajador-con-dudas_1012-193.jpg?size=338&ext=jpg',
		imageWidth: 250,
		imageHeight: 250,
		animation: false,
	  showCancelButton: true,
	  confirmButtonColor: '#00c0ef',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Deacuerdo',
		cancelButtonText: 'Cancelar'
	}).then(function (e) {
		$.post("../ajax/persona.php?op=eliminar", {idpersona : idpersona}, function(e){
			swal(
  		(e),
  		'Satisfactoriamente!',
  		'success'
)
			tabla.ajax.reload(null,false);

		});
	})
}

init();
