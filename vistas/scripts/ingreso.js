var tabla;
var t;
// TODO: FUNCION QUE SE EJECUTA AL INICIO
function init() {

	$(document).ready(function() {
		$(".dataTables_filter input").focus();
		$('[data-toggle="tooltip"]').tooltip();
	});


	$(document).keypress(function(event) {
		// event.preventDefault();
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if ($('#listadoregistros').is(":visible")) {
			if (keycode == '13') {
				mostrarform(true);
			}
		} else if ($('#formulario').is(":visible")) {
			if (keycode == '13') {
				$("#btnAgregarArt").click();
			}
		}
	});


	mostrarform(false);

	fechanow();

	listar();


	$("#formulario").on("submit", function(e) {
		e.preventDefault();
		guardaryeditar(e);
	});


	$.post("../ajax/ingreso.php?op=selectProveedor", function(r) {
		$("#idproveedor").html(r);
		$('#idproveedor').selectpicker('refresh');
	});


	$.post("../ajax/ingreso.php?op=selectAlmacen", function(r) {
		$("#idalmacen").html(r);
		$('#idalmacen').selectpicker('refresh');
	});


}
//FIN FUNCION init


// TODO: FUNCION FECHA Y HORA
function fechanow() {
	//Obtenemos la fecha actual y hora actualvar time = new Date().getTime();
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var hour = ("0" + now.getHours()).slice(-2);
	var minute = ("0" + now.getMinutes()).slice(-2);
	var second = ("0" + now.getSeconds()).slice(-2);
	var today = now.getFullYear() + "-" + (month) + "-" + (day) + 'T' + (hour) + ':' + (minute);
	minute = checkTime(minute);
	// second = checkTime(second);
	t = setTimeout(fechanow, 500)
	// +':'+(second)  + ':' + (second)
	$("#fecha_hora").val(today);
}


// TODO: FUNCION CONTADOR FECHA GET 0
function checkTime(i) {
	if (i < 10) {
		i = "0" + i
	};
	return i;
}


// TODO: FUNCION PARA LIMPIAR
function limpiar() {
	$("#idproveedor").val("");
	$("#idingreso").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	$('#idalmacen').selectpicker('val', "");
	// $("#impuesto").val("0");
	$("#total_importe").val("");
	$("#total_venta_estimada").val("");
	$("#total_beneficio").val("");
	$(".filas").remove();
	$("#total_imp").html("S/. 0.00");
	$("#total_v").html("S/. 0.00");
	$("#total_ben").html("S/. 0.00");
}


// TODO: FUNCION EXTRAS
function var_extras() {
	$("#tipo_comprobante").val("Otros");
	$("#tipo_comprobante").selectpicker('refresh');
}


// TODO: FUNCION PARA ABRIR MODAL CON LISTA DE PRODUCTO POR Almacen
function openproductoalmacen() {
	var key = $("#idalmacen option:selected").val();
	if (key == "") {
		alert('Selecciona un Almacen');
	} else {
		listarProductos_x_almacen(key);
		$('#myModal2').modal('show');
	}
}


// TODO: FUNCION PARA MOSTRAR FORMULARIO
function mostrarform(flag) {
	contains = [];
	var_extras();

	if (flag) {
		$(document).ready(function() {
			$('#serie_comprobante').focus();
		});

		$('#idproveedor').val('Publico General');
		$("#idproveedor").selectpicker('refresh');
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnagregar").hide();
		listarProductos();
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		detalles = 0;
		$("#btnAgregarArt").show();
	} else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}


// TODO: FUNCION PARA CANCELAR FORMULARIO
function cancelarform() {
	clearTimeout(t);
	limpiar();
	mostrarform(false);
	fechanow();
}


// TODO: FUNCION LISTAR INGRESOS
function listar() {
	tabla = $('#tbllistado').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		dom: 'Bfrtip',
		buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf', 'print'],
		columnDefs: [

					 { width: 70, targets: 1 }
			 ],
		fixedColumns: true,
		"ajax": {
			url: '../ajax/ingreso.php?op=listar',
			type: "get",
			dataType: "json",
			error: function(e) {
				console.log(e.responseText);
			}
		},
		"autoWidth": true,
		"bDestroy": true,
		"iDisplayLength": 5,
		"order": [
			[0, "desc"]
		]
	}).DataTable();
}

// TODO: FUNCION PARA LISTAR PRODUCTOS A SER REPUESTOS  EN UN ALMACEN - INGRESOS
function listarProductos() {
	tabla = $('#tblproductos').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		dom: 'Bfrtip',
		buttons: [],
		"ajax": {
			url: '../ajax/ingreso.php?op=listarProductos',
			type: "get",
			dataType: "json",
			error: function(e) {
				console.log(e.responseText);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 5,
		"order": [
			[0, "desc"]
		]
	}).DataTable();

	$('#myModal').on('shown.bs.modal', function() {
		$('.dataTables_filter input').focus();
		tabla.search('').columns().search('').draw();
	});
}


// TODO: FUNCION PARA LISTAR PRODUCTOS DE UN ALMACEN
function listarProductos_x_almacen(idalmacen) {
	tabla = $('#tblproductos2').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		dom: 'Bfrtip',
		buttons: [{
			extend: 'pdfHtml5',
			text: 'Reportes en archivo PDF',
			download: 'open'
		}, ],
		columnDefs:[
			{"visible": false, "targets":0}
		],
		"ajax": {
			url: '../ajax/ingreso.php?op=listarproductosalmacenes',
			type: "get",
			data: {
				idalmacen: idalmacen,
			},
			dataType: "json",
			error: function(e) {
				console.log(e.responseText);
			}
		},
		"bDestroy": true,
		// "iDisplayLength": 5,
		"order": [[0, "desc"]],
		rowGroup: {
					startRender: function ( rows, group ) {
							return 'Fecha y Hora de Lote -' + group + ' ('+rows.count()+' productos)';
					},
				 dataSrc: 0
		 }
	}).DataTable();

	$('#myModal2').on('shown.bs.modal', function() {
		$('.dataTables_filter input').focus();
		tabla.search('').columns().search('').draw();
	});
}


// TODO: FUNCION PARA GUARDAR Y EDITAR
function guardaryeditar(e) {
	e.preventDefault();
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/ingreso.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos) {
			swal(
				(datos),
				'Satisfactoriamente!',
				'success'
			).catch(swal.noop);
			mostrarform(false);
			$('#tbllistado').DataTable().ajax.reload();
		}
	});
	limpiar();
}


// TODO: FUNCION PARA MOSTRAR INGRESOS
function mostrar(idingreso) {
	$.post("../ajax/ingreso.php?op=mostrar", {
		idingreso: idingreso
	}, function(data, status) {
		data = JSON.parse(data);
		mostrarform(true);
		clearTimeout(t);
		$("#idalmacen").val(data.idalmacen);
		$("#idalmacen").selectpicker('refresh');
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

	$.post("../ajax/ingreso.php?op=listarDetalle&id=" + idingreso, function(r) {
		$("#detalles").html(r);
	});
}


// TODO: FUNCION PARA ANULAR INGRESOS
function anular(idingreso) {
	swal({
		title: '¿Está seguro de anular el ingreso?',
		imageUrl: '../public/img/swal-duda.jpg',
		imageWidth: 250,
		imageHeight: 250,
		animation: false,
		showCancelButton: true,
		confirmButtonColor: '#f39c12',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Aceptar',
		cancelButtonText: 'Cancelar'
	}).then(function(e) {
		$.post("../ajax/ingreso.php?op=anular", {
			idingreso: idingreso
		}, function(e) {
			swal(
				(e),
				'Satisfactoriamente!',
				'success'
			)
			 $('#tbllistado').DataTable().ajax.reload();
			// tabla.ajax.reload(null, false);

		});
	}).catch(swal.noop);
}


// TODO: DECRALACION DE VARIABLES PARA TRABAJAR MODULO INGRESO Y DETALLE INGRESO
var impuesto = 18;
var cont = 0;
var detalles = 0;
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);


// TODO: FUNCION MARCAR IMPUESTO - OBSOLETA
function marcarImpuesto() {
	var tipo_comprobante = $("#tipo_comprobante option:selected").text();
	if (tipo_comprobante == 'Factura') {
		$("#impuesto").val(impuesto);
	} else {
		$("#impuesto").val("0");
	}
}


// TODO: FUNCION AGREGAR DETALLE DE UN MODAL - LISTA DE PRODUCTOS A REPONER
var contains = [];
function agregarDetalle(idproducto, producto, talla) {


	Array.prototype.contains = function ( needle ) {
		 for (i in this) {
				 if (this[i] == needle) return true;
		 }
		 return false;
	 }

	 if (contains.contains(idproducto)) {

		 		 swal({
						 type: 'warning',
						 title: 'Este Producto ya fue Ingresado',
						 text: 'Para ingresar el producto debe retirar el mismo producto del detalle...',
				 }).catch(swal.noop);

		 }else{
			 		var idproducto_ubicacion = "";
			 		var cantidad = 1;
			 		var valor1 = 100;
			 		var valor2 = 100;
			 		var precio_compra = 0;
			 		var precio_venta = 0;
			 		var ganancia = 0;
			 		var ganancianeta = 0;
			 		var importe = 0;
			 		if (idproducto != "") {
				 		var subtotal;

				 		var fila = '<tr class="filas" id="fila' + cont + '">' +
				 		'<td style="text-align:center;"><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ',' + idproducto + ')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>' +
				 		'<td><input class="form-control" type="hidden" name="idproducto[]" value="' + idproducto + '">' + producto + '</td>' +
						'<td id="codinp"><input class="form-control" type="hidden">' + talla + '</td>' +
				 		'<td style="width: 10%;"><input class="form-control" type="number" name="cantidad[]" id="cantidad" onchange="modificarSubototales()" onkeyup="modificarSubototales()" onblur="onBlur(this)" onfocus="onFocus(this)"  oninput="validaLength(this)" maxlength="4" min="1" max="10000" value="' + cantidad + '" required=""></td>' +
				 		'<td><span class="input-symbol-euro"><input class="form-control" type="number" step=".01" min="1" max="100000" onchange="calculacompraunitaria()" onblur="onBlur(this)" onfocus="onFocus(this)" id="importe" name="importe[]" placeholder="0.00" value="' + importe + '"></span></td>' +
				 		'<td><span class="input-symbol-euro"><input class="form-control" type="number" step=".01" min="1" max="100000" onchange="calculaimporte()" onkeyup="calculaimporte()" onblur="onBlur(this)" onfocus="onFocus(this)" id="precio_compra" name="precio_compra[]" value="' + precio_compra + '"></span></td>' +
				 		'<td><span class="input-symbol-euro"><input class="form-control" type="number" onchange="modificarSubototales()" step=".01" min="0.00" max="10000" onchange="calculaganancia()" onblur="onBlur(this)" onfocus="onFocus(this)" id="precio_venta" name="precio_venta[]" value="' + precio_venta + '"></span></td>' +
				 		'<td><span><input class="form-control" type="number" onblur="onBlur(this)" onfocus="onFocus(this)" step=".01" min="1" max="1000" name="gananciaporcentaje[]" value="' + ganancia + '"  readonly></span></td>' +
				 		'<td style="width: 10%;"><span class="input-symbol-euro"><input class="form-control" type="number" onblur="onBlur(this)" onfocus="onFocus(this)" step=".01" min="0" max="100000" name="ganancianeta[]" value="' + ganancianeta + '"></span></td>' +
				 		'<td><button type="button" onclick="calculaimporte()" class="btn btn-warning"><i class="fa fa-refresh"></i></button></td>' +
				 		'<td id="p_none"><input  type="hidden" name="valor1[]" value="' + valor1 + '"></td>' +
				 		'<td id="p_none"><input  type="hidden" name="valor2[]" value="' + valor2 + '"></td>' +
				 		'</tr>';

						$('#detalles').append(fila);

				 		cont++;
				 		detalles = detalles + 1;


						var pro= [idproducto];
						for (var i = 0; i <pro.length; i++) {
							 valores=pro[i];
						}
						contains.push(valores);

				 		$(function() {
					 		$(document).on('click', 'input[type=number]', function() {
						 		this.select();
					 		});
				 		});

				 		modificarSubototales();

			 		} else {
				 		alert("Error al ingresar el detalle, revisar los datos del producto");
			 	}
 	  }
}


// TODO: FUNCION PARA LIMPIAR CAMPOS DETALLE VENTA AL INICIAR
function onBlur(el) {
	if (el.value == '') {
		el.value = el.defaultValue;
	}
}
function onFocus(el) {
	if (el.value == el.defaultValue) {
		el.value = '';
	}
}


// TODO: FUNCION PARA VALIDAR EL MAXIMO DE IN INPUT MAXLENGTH
function validaLength(id) {
	if (id.value.length > id.maxLength)
		id.value = id.value.slice(0, id.maxLength)
}


function decimalAdjust(type, value, exp) {
	// Si el exp no está definido o es cero...
	if (typeof exp === 'undefined' || +exp === 0) {
		return Math[type](value);
	}
	value = +value;
	exp = +exp;
	// Si el valor no es un número o el exp no es un entero...
	if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
		return NaN;
	}
	// Shift
	value = value.toString().split('e');
	value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
	// Shift back
	value = value.toString().split('e');
	return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
}


// TODO: FUNCION PARA CALCULAR IMPORTE
function calculaimporte() {

	calculaganancia();

	var cantx = document.getElementsByName("cantidad[]");
	var precx = document.getElementsByName("precio_compra[]");
	var impox = document.getElementsByName("importe[]");

	for (var i = 0; i < cantx.length; i++) {
		var inpCx = cantx[i];
		var inpPx = precx[i];
		var inpIx = impox[i];

		// Decimal round
			if (!Math.round10) {
				Math.round10 = function(value, exp) {
					return decimalAdjust('round', value, exp);
				};
			}
		//Calculo de operacion para SUBTOTAL
		inpIx.value=Math.round10((inpCx.value * inpPx.value), -1);
		// parseFloat(Math.round((inpCx.value * inpPx.value) * 100) / 100).toFixed(2);
	}

	calcularTotalesImporte();
	calcularTotalesPVenta();
	calcularTotalesBeneficio();
}


// TODO: FUNCION PARA CALCULAR COMPRA UNITARIA
function calculacompraunitaria() {

	calculaganancia();

	var cantxy = document.getElementsByName("cantidad[]");
	var precxy = document.getElementsByName("precio_compra[]");
	var impoxy = document.getElementsByName("importe[]");
	for (var i = 0; i < cantxy.length; i++) {

		var inpCxy = cantxy[i];
		var inpPxy = precxy[i];
		var inpIxy = impoxy[i];

		inpPxy.value = parseFloat(Math.round((inpIxy.value / inpCxy.value) * 100) / 100).toFixed(2);

	}

	calcularTotalesImporte();
	calcularTotalesPVenta();
	calcularTotalesBeneficio();
}


// TODO: FUNCION PARA CALCULAR GANANCIA
function calculaganancia() {
	var g_cant = document.getElementsByName("cantidad[]");
	var g_prec = document.getElementsByName("precio_compra[]");
	var g_prev = document.getElementsByName("precio_venta[]");
	var g_gan = document.getElementsByName("gananciaporcentaje[]");
	var g_gann = document.getElementsByName("ganancianeta[]");
	// var g_sub = document.getElementsByName("subtotal");
	var g_val1 = document.getElementsByName("valor1[]");
	var g_val2 = document.getElementsByName("valor2[]");

	for (var i = 0; i < g_prev.length; i++) {
		var inpCant = g_cant[i];
		var inpPrec = g_prec[i];
		var inpPrev = g_prev[i];
		var inpGan = g_gan[i];
		var inpGann = g_gann[i];
		var inpVal1 = g_val1[i];
		var inpVal2 = g_val2[i];

		if (parseFloat(inpPrev.value) < parseFloat(inpPrec.value)) {
			inpPrev.value = 0;
			inpGann.value = 0;
			inpGan.value = 0;
		} else {
			inpGann.value = parseFloat(Math.round((inpPrev.value - inpPrec.value) * 100) / 100).toFixed(2);
		}

		if (inpPrev.value > 0 && inpPrec.value > 0) {
			inpGan.value = parseFloat(Math.round(((inpPrev.value * inpVal1.value / inpPrec.value) - inpVal2.value) * 100) / 100).toFixed(2);
		}else if(inpPrec.value == 0 && inpPrev.value != 0) {
			inpGan.value = 100;
		}
	}

}


// TODO: FUNCION PARA MODIFICAR SUBTOTALES
function modificarSubototales() {
	calculacompraunitaria();
	calculaimporte();
	calculaganancia();
	calcularTotalesImporte();
	calcularTotalesPVenta();
	calcularTotalesBeneficio();
}


// TODO: FUNCION CALCULAR TOTALES DE COMPRA o IMPORTE LOTE
function calcularTotalesImporte() {
	var imp = document.getElementsByName("importe[]");
	var total_importe = 0.0;

	for (var i = 0; i < imp.length; i++) {
		var inpIm = imp[i];
		if (inpIm.value == "") {
			inpIm.value = 0;
		}
		total_importe += parseFloat(inpIm.value);
	}
	total_importe = (Math.round(total_importe * 100) / 100).toFixed(2);
	$("#total_imp").html("S/. " + total_importe);
	$("#total_importe").val(total_importe);
	evaluar();
}


// TODO: FUNCION CALCULAR TOTALES DE COMPRA o IMPORTE LOTE
function calcularTotalesPVenta() {
	var pvent = document.getElementsByName("precio_venta[]");
	var cant_totalesv = document.getElementsByName("cantidad[]");
	var total_venta_estimada = 0.0;

	for (var i = 0; i < pvent.length; i++) {
		var inpV = pvent[i];
		var inpCa = cant_totalesv[i];

		if (inpV.value == "") {
			inpV.value = 0;
		}

		total_venta_estimada += parseFloat(inpV.value)*inpCa.value;
	}
	total_venta_estimada = (Math.round(total_venta_estimada*100)/100).toFixed(2);
	$("#total_v").html("S/. " + total_venta_estimada);
	$("#total_venta_estimada").val(total_venta_estimada);
	evaluar();
}


// TODO: FUNCION CALCULAR TOTALES DE GANANCIA O BENEFICIO NETO
function calcularTotalesBeneficio() {
	var gann = document.getElementsByName("ganancianeta[]");
	var total_beneficio = 0.0;

	for (var i = 0; i < gann.length; i++) {
		var inpGn = gann[i];
		if (inpGn.value == "") {
			inpGn.value = 0;
		}
		total_beneficio += parseFloat(inpGn.value);
	}
	total_beneficio = (Math.round(total_beneficio * 100) / 100).toFixed(2);
	$("#total_ben").html("S/. " + total_beneficio);
	$("#total_beneficio").val(total_beneficio);
	evaluar();
}


// TODO: FUNCION PARA EVALUAR EL DETALLE DE LA TABLA
function evaluar() {
	if (detalles > 0) {
		$("#btnGuardar").show();
	} else {
		$("#btnGuardar").hide();
		cont = 0;
	}
}


// TODO: FUNCION PARA ELIMINAR EL DETALLE DE LA TABLA
function eliminarDetalle(indice,idproducto) {

	$("#fila" + indice).remove();

	Array.prototype.compacta = function(){
		for(var i = 0; i < this.length; i++){
			if(this[i] === idproducto){
					this.splice(i , 1);
			}
		}
	}
	contains.compacta();



	calcularTotalesImporte();
	calcularTotalesPVenta();
	calcularTotalesBeneficio();
	detalles = detalles - 1;
	evaluar();

}


init();
