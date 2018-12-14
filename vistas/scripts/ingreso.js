var tabla;

//Función que se ejecuta al inicio
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
				if (keycode == '32') {
				$( "#btnAgregarArt" ).click();
				}
			}
	});


	mostrarform(false);


	listar();


	$("#formulario").on("submit",function(e)
	{
		e.preventDefault();
		guardaryeditar(e);
	});


	$.post("../ajax/ingreso.php?op=selectProveedor", function(r){
	            $("#idproveedor").html(r);
	            $('#idproveedor').selectpicker('refresh');
	});


	$.post("../ajax/ingreso.php?op=selectAlmacen", function(r){
							$("#idalmacen").html(r);
							$('#idalmacen').selectpicker('refresh');
	});


}


// TODO: FUNCION PARA LIMPIAR
function limpiar(){
	$("#idproveedor").val("");
	$("#idingreso").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	// $("#impuesto").val("0");
	$("#total_compra").val("");
	$(".filas").remove();
	$("#total").html("0");

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_hora').val(today);

    //Marcamos el primer tipo_documento
    $("#tipo_comprobante").val("Boleta");
	$("#tipo_comprobante").selectpicker('refresh');
}


// TODO: FUNCION PARA MOSTRAR FORMULARIO
function mostrarform(flag){
	limpiar();
	if (flag)
	{
		$(document).ready(function(){
				$('#serie_comprobante').focus();
		});
		$('#idproveedor').val('Publico General');
		$("#idproveedor").selectpicker('refresh');
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		// $("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		listarProductos();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		detalles=0;
		$("#btnAgregarArt").show();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}


// TODO: FUNCION PARA CANCELAR FORMULARIO
function cancelarform(){
	limpiar();
	mostrarform(false);
}


// TODO: FUNCION LISTAR INGRESOS
function listar(){
	tabla=$('#tbllistado').dataTable(
		{
				"aProcessing": true, //Activamos el procesamiento del datatables
				"aServerSide": true, //Paginacion y filtrado realizados por el servidor
				dom: 'Bfrtip',         //Definimos los elementos del control de tabla
				buttons: ['copyHtml5','excelHtml5','csvHtml5','pdf','print'],
	"ajax":
			{
				url: '../ajax/ingreso.php?op=listar',
				type : "get",
				dataType : "json",
				error: function(e){
					console.log(e.responseText);
				}
			},
		"bDestroy": true,
		"iDisplayLength": 5, //Paginación
	    "order": [[ 0, "desc" ]] //Ordenar (columna,orden)
	}).DataTable();
}

// TODO: FUNCION PARA LISTAR PRODUCTOS A SER REPUESTOS  EN UN ALMACEN - INGRESOS
function listarProductos(){
	tabla=$('#tblproductos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	   "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [],
		"ajax":
				{
					url: '../ajax/ingreso.php?op=listarProductos',
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

	$('#myModal').on('shown.bs.modal', function () {
		$('.dataTables_filter input').focus();
		tabla.search('').columns().search('').draw();
	});
}


// TODO: FUNCION PARA GUARDAR Y EDITAR
function guardaryeditar(e){
	e.preventDefault(); //No se activara la accion predeterminada del evento
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/ingreso.php?op=guardaryeditar",
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
			listar();
		}
	});
}


// TODO: FUNCION PARA MOSTRAR INGRESOS
function mostrar(idingreso){
	$.post("../ajax/ingreso.php?op=mostrar",{idingreso : idingreso}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);

		$("#idproveedor").val(data.idproveedor);
		$("#idproveedor").selectpicker('refresh');
		$("#tipo_comprobante").val(data.tipo_comprobante);
		$("#tipo_comprobante").selectpicker('refresh');
		$("#serie_comprobante").val(data.serie_comprobante);
		$("#num_comprobante").val(data.num_comprobante);
		$("#fecha_hora").val(data.fecha);
		$("#impuesto").val(data.impuesto);
		$("#idingreso").val(data.idingreso);

		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
	});

	$.post("../ajax/ingreso.php?op=listarDetalle&id="+idingreso,function(r){
					$("#detalles").html(r);
	});
}


// TODO: FUNCION PARA ANULAR INGRESOS
function anular(idingreso){
	swal({
	  title: '¿Está seguro de anular el ingreso?',
		imageUrl: 'http://img.freepik.com/vector-gratis/trabajador-con-dudas_1012-193.jpg?size=338&ext=jpg',
		imageWidth: 250,
		imageHeight: 250,
		animation: false,
	  showCancelButton: true,
	  confirmButtonColor: '#00c0ef',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Aceptar',
		cancelButtonText: 'Cancelar'
	}).then(function (e) {
		$.post("../ajax/ingreso.php?op=anular", {idingreso : idingreso}, function(e){
			swal(
  		(e),
  		'Satisfactoriamente!',
  		'success'
)
			tabla.ajax.reload(null,false);

		});
	})
}

// //Declaración de variables necesarias para trabajar con las compras y
// //sus detalles
var impuesto=18;
var cont=0;
var detalles=0;

// $("#guardar").hide();
$("#btnGuardar").hide();
// $("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto()
  {
  	var tipo_comprobante=$("#tipo_comprobante option:selected").text();
  	if (tipo_comprobante=='Factura')
    {
        $("#impuesto").val(impuesto);
    }
    else
    {
        $("#impuesto").val("0");
    }
  }

	function agregarDetalle(idproducto,producto)
	  {
	  	var cantidad=0;
	    var precio_compra=1;
	    var precio_venta=1;
			var importe=0;
			var ganancia=0;
			var ganancianeta=0;

	    if (idproducto!="")
	    {
	    	var subtotal=cantidad*precio_compra;
	    	var fila='<tr class="filas" id="fila'+cont+'">'+
	    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
	    	'<td><input type="hidden" name="idproducto[]" value="'+idproducto+'">'+producto+'</td>'+
	    	'<td><input type="number" style="width:7em;" name="cantidad[]" value="'+cantidad+'"></td>'+
				'<td><input type="number" style="width:7em;" name="importe[]" id="importe" value="'+importe+'"></td>'+
	    	'<td><input type="number" style="width:7em;" name="precio_compra[]" id="precio_compra[]" value="'+precio_compra+'"></td>'+
	    	'<td><input type="number" style="width:7em;" name="precio_venta[]" value="'+precio_venta+'"></td>'+
				'<td><input type="number" style="width:7em;" name="ganancia[]" id="ganancia" value="'+ganancia+'"></td>'+
				'<td><input type="number" style="width:7em;" name="ganancianeta[]" id="ganancianeta" value="'+ganancianeta+'"></td>'+
	    	'<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
	    	'<td><button type="button" onclick="modificarSubototales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
	    	'</tr>';
	    	cont++;
	    	detalles=detalles+1;
	    	$('#detalles').append(fila);
	    	modificarSubototales();
	    }
	    else
	    {
	    	alert("Error al ingresar el detalle, revisar los datos del producto");
	    }
	  }

		//FUNCION PARA MODIFICAR SUBTOTALES

		function divideIfNotZero(numerator, denominator) {
			  if (denominator === 0 || isNaN(denominator)) {
			        return 0;
			  }
			  else {
			        return numerator / denominator;
			  }
			}

		  function modificarSubototales()
		  {
		  	var cant = document.getElementsByName("cantidad[]");
		    var prec = document.getElementsByName("precio_compra[]");
		    var sub = document.getElementsByName("subtotal");

					var impo = document.getElementsByName("importe[]");
				  var prev = document.getElementsByName("precio_venta[]");
					var gan = document.getElementsByName("ganancia[]");
				  var gann = document.getElementsByName("ganancianeta[]");

		    for (var i = 0; i <cant.length; i++) {
		    	var inpC=cant[i];
		    	var inpP=prec[i];
		    	var inpS=sub[i];

					var inpIm=impo[i];
					var inpPv=prev[i];
					var inpG=gan[i];
					var inpGn=gann[i];

			 		var conten = divideIfNotZero(inpPv.value, inpP.value);

		    	inpS.value=inpC.value * inpP.value;

					inpG.value=(conten*100)-100;

					if (inpG.value<0) {
							inpG.value=0;
					}

					inpGn.value=inpPv.value - inpP.value;
					inpIm.value = inpS.value;

					

		    	document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
		    }
		    calcularTotales();

		  }





			function calcularTotales(){
				var sub = document.getElementsByName("subtotal");
				var total = 0.0;

				for (var i = 0; i <sub.length; i++) {
				total += document.getElementsByName("subtotal")[i].value;
			}
			total = parseFloat(Math.round(total * 100) / 100).toFixed(2);
			$("#total").html("S/. " + total);
				$("#total_compra").val(total);
				evaluar();
			}

			function evaluar(){
				if (detalles>0)
				{
					$("#btnGuardar").show();
				}
				else
				{
					$("#btnGuardar").hide();
					cont=0;
				}
			}
			function eliminarDetalle(indice){
				$("#fila" + indice).remove();
				calcularTotales();
				detalles=detalles-1;
				evaluar();
			}


																									//***************************
																									//FUNCION PARA FILTRAR todo |
																									//**************************


function filterGlobal () {
$('#tblproductos').DataTable().search(
$('#global_filter').val(),
$('#global_regex').prop('checked'),
$('#global_smart').prop('checked')
).draw();

}


																									//******************************
																									//FUNCION PARA FILTRAR COLUMNAS|
																									//*****************************


function filterColumn ( i ) {

$('#tblproductos').DataTable().column( i ).search(
$('#col'+i+'_filter').val(),
$('#col'+i+'_regex').prop('checked'),
$('#col'+i+'_smart').prop('checked')
).draw();

}




init();
