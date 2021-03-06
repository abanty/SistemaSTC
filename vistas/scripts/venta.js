var tabla;

// TODO:  FUNCION INICIO
function init() {

	$(document).ready(function() {
		$(".dataTables_filter input").focus();
		$('[data-toggle="tooltip"]').tooltip();
	});

	$('#myModal').on('shown.bs.modal', function (e) {
		$($.fn.dataTable.tables( true ) ).css('width', '100%');
		$($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw();
	});

	fechanow();

	mostrarform(false);

	listar();


	$("#formulario").on("submit", function(e) {
		e.preventDefault();
		guardaryeditar(e);
	});

	//Cargamos los items al select cliente
	$.post("../ajax/venta.php?op=selectCliente", function(r) {
		$("#idcliente").html(r);
		$('#idcliente').selectpicker('refresh');

	});

	$.post("../ajax/venta.php?op=selectAlmacenVenta", function(r) {
		$("#idalmacen").html(r);
		$('#idalmacen').selectpicker('refresh');
  });

}


// TODO:  FUNCION LIMPIAR CAMPOS
function limpiar() {
	$("#idcliente").val("");
	$("#idventa").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	$("#total_venta").val("");
	$(".filas").remove();
	$("#total").html("0");
}


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


// TODO: FUNCION EXTRAS
function var_extras() {
	$("#impuesto").val("0");
	$("#tipo_comprobante").val("Otros");
	$("#tipo_comprobante").selectpicker('refresh');
}


// TODO: FUNCION PARA ABRIR MODAL CON LISTA DE PRODUCTO POR Almacen
function openproductofilter() {
	var keytext = $("#idalmacen option:selected").text();
	var key = $("#idalmacen option:selected").val();
	if (key == "") {
		// alert('Selecciona un Almacen');
		$.notify.defaults({ className: "success" });
		$.notify.defaults({ autoHideDelay: 5000 });
		$.notify.defaults({ style: 'bootstrap' });
		$("#idalmacen").notify('Selecciona un Almacen',{ position:"bottom center" });

	} else {
		listarProductos(key);
		$("#myModal .modal-title").html('<i class="fa fa-list-ol" aria-hidden="true"></i> Seleccione un Producto del ' + keytext);
		$('#myModal').modal('show');
		// $("#myModal .modal-header").text('pass your text here');
	}
}


// TODO:   FUNCION PARA MOSTRAR FORMULARIO
function mostrarform(flag) {
	contains = [];
	var_extras();

	if (flag) {
		$('#idcliente').val('Publico General');
		$("#idcliente").selectpicker('refresh');
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnagregar").hide();
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").show();
		detalles = 0;
	} else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}


// TODO:  FUNCION PARA CANCELAR  LAS VENTAS
function cancelarform() {
	clearTimeout(t);
	limpiar();
	mostrarform(false);
	fechanow();
}


// TODO:  FUNCION PARA LISTAR LAS VENTAS
function listar() {
	tabla = $('#tbllistado').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		dom: 'Bfrtip',
		buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf', 'print'],
		"ajax": {
			url: '../ajax/venta.php?op=listar',
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
}



function listarProductos(idalmacen) {

	tabla = $('#tblproductos2').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		dom: 'Bfrtip',
		buttons: ['excelHtml5', 'pdf'],
		columnDefs:[
			{"visible": false, "targets":1}
		],
		"ajax": {
			url: "../ajax/venta.php?op=listarProductosVenta",
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
		scrollY:        300,
    deferRender:    true,
    scroller:       true,
		"scrollCollapse": true,
		"paging":         false,
		// "iDisplayLength": 5,
		"order": [[1, "desc"]],
		rowGroup: {
					startRender: function ( rows, group ) {
							return 'Fecha y Hora de Lote -' + group + ' ('+rows.count()+' productos)';
					},
				 dataSrc: 1
		 }
	}).DataTable();

	$('#myModal').on('shown.bs.modal', function() {
		$('.dataTables_filter input').focus();
		tabla.search('').columns().search('').draw();
	});

}


// TODO:  FUNCION PARA GUARDAR O EDITAR
function guardaryeditar(e) {
	e.preventDefault();
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/venta.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos) {
			swal(
				(datos),
				'Satisfactoriamente!',
				'success'
			);
			mostrarform(false);
			$('#tbllistado').DataTable().ajax.reload();
		}
	});

	limpiar();
}


// TODO: FUNCION PARA MOSTRAR LOS REGISTROS
function mostrar(idventa) {
	$.post("../ajax/venta.php?op=mostrar", {
		idventa: idventa
	}, function(data, status) {
		data = JSON.parse(data);
		mostrarform(true);
		clearTimeout(t);
		$("#idcliente").val(data.idcliente);
		$("#idcliente").selectpicker('refresh');
		$("#tipo_comprobante").val(data.tipo_comprobante);
		$("#tipo_comprobante").selectpicker('refresh');
		$("#serie_comprobante").val(data.serie_comprobante);
		$("#num_comprobante").val(data.num_comprobante);
		$("#fecha_hora").val(data.fecha);
		$("#impuesto").val(data.impuesto);
		$("#idventa").val(data.idventa);

		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
	});

	$.post("../ajax/venta.php?op=listarDetalle&id=" + idventa, function(r) {
		$("#detalles").html(r);
	});
}


function listar_detalle_modal(idventa)
{
	tabla=$('#tblproductos_detalle').dataTable(
	{
		"aProcessing": true,
	    "aServerSide": true,
	    dom: 'Brtip',
	    buttons: [

		        ],
		  columnDefs:[
		  	{"visible": false, "targets":1}
		  ],
		"ajax":
				{
					url: "../ajax/venta.php?op=listadetalle_poridventa",
					type : "get",
					data: {
						idventadet: idventa,
					},
					dataType : "json",
					error: function(e){
						console.log(e.responseText);
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 1, "desc" ]],
			rowGroup: {
							startRender: function ( rows, group ) {
									return 'Detalle de Salida 00' + group + ' ('+rows.count()+' productos)';
							},
	            endRender: function ( rows, group ) {
	                var avg = rows
	                    .data()
	                    .pluck(6)
	                    .reduce( function (a, b) {
	                        return a + b *1;
	                    }, 0);

	                return 'TOTAL DE VENTA EN EL DETALLE  00'+group+' : '  +
	                    $.fn.dataTable.render.number(',', '.', 0, '  S/ ').display( avg );
	            },
	            dataSrc: 1
	        }


	}).DataTable();
}


// TODO: FUNCION PARA MOSTRAR LOS REGISTROS
function verdetalle(idventa_d) {
	// alert(idventa);
	listar_detalle_modal(idventa_d)
	$("#myModal_detalles .modal-title").html('<i class="fa fa-list-ol" aria-hidden="true"></i> Detalle de Venta  00'+idventa_d);
	$('#myModal_detalles').modal('show');

}


// TODO: FUNCION PARA ANULAR REGISTROS
function anular(idventa) {
	swal({
		title: '¿Está seguro de anular la venta?',
		//text: "You won't be able to revert this!",
		//type: 'question',
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
		$.post("../ajax/venta.php?op=anular", {
			idventa: idventa
		}, function(e) {
			swal(
				(e),
				'Satisfactoriamente!',
				'success'
			)
			$('#tbllistado').DataTable().ajax.reload();
		});
	}).catch(swal.noop);
}


// TODO: FUNCION PARA ANULAR REGISTROS
function anulardetalle(iddetalle_venta) {

	swal({
		title: '¿Está seguro de anular el detalle_venta?',
		//text: "You won't be able to revert this!",
		//type: 'question',
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
		$.post("../ajax/venta.php?op=anulardetalle_v", {
			iddetalle_venta: iddetalle_venta
		}, function(e) {
			swal(
				(e),
				'Satisfactoriamente!',
				'success'
			)
			$('#tblproductos_detalle').DataTable().ajax.reload();
			$('#tbllistado').DataTable().ajax.reload();
		});
	}).catch(swal.noop);
}


// TODO: DECLARACION DE VARIABLES PARA EL DETALLE VENTA
var impuesto = 18;
var cont = 0;
var detalles = 0;
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);


function marcarImpuesto() {
	var tipo_comprobante = $("#tipo_comprobante option:selected").text();
	if (tipo_comprobante == 'Factura') {
		$("#impuesto").val(impuesto);
	} else {
		$("#impuesto").val("0");
	}
}

function concatenate(a, b, base) {
        return a * Math.pow(base, Math.floor(Math.log(b) / Math.log(base)) + 1) + b;
    }


// TODO: FUNCION PARA AGREGAR DETALLE DE PRODUCTOS
var contains = [];
function agregarDetalle(codigo, idproducto, producto, precio_venta, stock, idalmacen, idlote) {


	Array.prototype.contains = function(needle) {
		for (i in this) {
			if (this[i] == needle) return true;
		}
		return false;
	}
	var datadetalle = concatenate(idproducto, idlote, 10);
	if (contains.contains(datadetalle)) {

		swal({
			type: 'warning',
			title: 'Este Producto ya fue Ingresado',
			text: 'Para ingresar el producto debe retirar el mismo producto del detalle...',
		}).catch(swal.noop);

	} else {
		if (stock != 0) {
			swal({
				title: 'Ingresa Cantidad:',
				input: 'number',
				inputPlaceholder: ''
			}).then(function(number) {

				var cantidad = number;
				var descuento = 0;
				if ((Number(cantidad) > 0) && (Number(cantidad) != "")) {
					if ((idproducto != "") && (Number(stock) >= Number(cantidad))) {
						var subtotal = cantidad * precio_venta;
						var fila = '<tr class="filas" id="fila' + cont + '">' +
							'<td style="text-align:center;"><button type="button" id="elim" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ',' + idproducto + ',' + idlote + ')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>' +
							'<td><input type="hidden" value="' + codigo + '" required>' + codigo + '</td>' +
							'<td><input type="hidden" value="' + idlote + '" required>' + idlote + '</td>' +
							'<td><input type="hidden" name="idproducto[]" value="' + idproducto + '" required="">' + producto + '</td>' +
							'<td style><input type="number" class="form-control"  onchange="modificarSubototales()" onkeyup="modificarSubototales()" name="cantidad[]" id="cantidad[]" min="1" max="10000" value="' + cantidad + '" required=""></td>' +
							'<td><input type="number" class="form-control" name="precio_venta[]"  onchange="modificarSubototales()" onkeyup="modificarSubototales()" id="precio_venta[]" value="' + precio_venta + '" required=""></td>' +
							'<td><input type="number" class="form-control" name="descuento[]" onchange="modificarSubototales()" onkeyup="modificarSubototales()" value="' + descuento + '" required=""></td>' +
							'<td><span name="subtotal" id="subtotal' + cont + '">' + subtotal + '</span></td>' +
							'<td><button type="button" onclick="modificarSubototales()" class="btn btn-warning"><i class="fa fa-refresh"></i></button></td>' +
							'<td><input type="hidden" name="idalmacen[]" value="' + idalmacen + '" required=""></td>' +
							'<td><input type="hidden" name="idlote[]" value="' + idlote + '" required=""></td>' +
							'</tr>';
						cont++;
						detalles = detalles + 1;
						$('#detalles').append(fila);

						var pro = [idproducto];
						var lote = [idlote];
						for (var i = 0; i < pro.length; i++) {
							valores = pro[i];
							valoreslote = lote[i]
						}
						var concatenatedNumber = concatenate(valores, valoreslote, 10);
						contains.push(concatenatedNumber);

						$(function() {
							$(document).on('click', 'input[type=number]', function() {
								this.select();
							});
						});

						modificarSubototales();

					} else {
						swal({
							type: 'error',
							title: 'Oops...',
							text: 'Stock Superado',
						}).catch(swal.noop);
					}
				} else {
					swal({
						type: 'error',
						title: 'Oops...',
						text: 'Ingresa una cantidad correcta! ',
					}).catch(swal.noop);
				}
			}).catch(swal.noop);
		} else {
			swal({
				type: 'error',
				title: 'Oops...',
				text: 'Insuficiente Stock disponible',
			}).catch(swal.noop);
		}
	}
}


// TODO: FUNCION PARA MODIFICAR SUBTOTALES|
function modificarSubototales() {
	var cant = document.getElementsByName("cantidad[]");
	var prec = document.getElementsByName("precio_venta[]");
	var desc = document.getElementsByName("descuento[]");
	var sub = document.getElementsByName("subtotal");

	for (var i = 0; i < cant.length; i++) {
		var inpC = cant[i];
		var inpP = prec[i];
		var inpD = desc[i];
		var inpS = sub[i];

		inpS.value = (inpC.value * inpP.value) - inpD.value;
		document.getElementsByName("subtotal")[i].innerHTML = "S/. " + parseFloat(Math.round(inpS.value * 100) / 100).toFixed(2);
	}
	calcularTotales();

}


// TODO: FUNCION PARA CALCULAR TOTALES
function calcularTotales() {
	var sub = document.getElementsByName("subtotal");
	var total = 0.0;

	for (var i = 0; i < sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
	}
	total = parseFloat(Math.round(total * 100) / 100).toFixed(2);
	$("#total").html("S/. " + total);
	$("#total_venta").val(total);
	evaluar();
}


// TODO: 	FUNCION PARA EVALUAR REGISTRO DE DETALLES
function evaluar() {

	if (detalles > 0) {
		$("#btnGuardar").show();
	} else {
		$("#btnGuardar").hide();
		cont = 0;
	}
}


// TODO: FUNCION PARA ELIMINAR DETALLE
function eliminarDetalle(indice, idproducto, idlote) {

	var datadetalledelete = concatenate(idproducto, idlote, 10);

	$("#fila" + indice).remove();

	Array.prototype.compacta = function(){
		for(var i = 0; i < this.length; i++){
			if(this[i] === datadetalledelete){
					this.splice(i , 1);
			}
		}
	}
	contains.compacta();

	calcularTotales();
	detalles = detalles - 1;
	evaluar()
}


// TODO: FUNCION PARA FACTURACION NUMERACION
function numFactura() {
	$.ajax({
		url: '../modelos/NumFactura.php',
		type: 'get',
		dataType: 'json',
		success: function(res) {
			if (res.respuesta == true) {
				if (parseInt(res.mensaje) < 10) {
					$("#nfacturas").val("0000" + res.mensaje);
				} else if (parseInt(res.mensaje) < 100) {
					$("#nfacturas").val("000" + res.mensaje);
				}
			}
		}
	});
}


// TODO: FUNCION PARA FACTURACION NUMERACION SERIE
function numSerieFac() {
	$.ajax({
		url: '../modelos/NumSerie.php',
		type: 'get',
		dataType: 'json',
		success: function(res) {
			if (res.respuesta2 == true) {
				if (parseInt(res.mensaje2) < 10) {
					$("#serie_comprobante").val("00" + res.mensaje2);
				} else if (parseInt(res.mensaje2) < 100) {
					$("#serie_comprobante").val("0" + res.mensaje2);
				}
			}
		}
	});
}

//FUNCION SIN USO TEMPORALMENTE

// TODO: FUNCION  O METODOS PARA ARREGLAR EL TABINDEX DEL MODAL
function fixBootstrapModal() {
	var modalNode = document.querySelector('.modal[tabindex="-1"]');
	if (!modalNode) return;

	modalNode.removeAttribute('tabindex');
	modalNode.classList.add('js-swal-fixed');
}


// TODO: FUNCION  O METODOS PARA ARREGLAR EL TABINDEX DEL MODAL
function restoreBootstrapModal() {
	var modalNode = document.querySelector('.modal.js-swal-fixed');
	if (!modalNode) return;

	modalNode.setAttribute('tabindex', '-1');
	modalNode.classList.remove('js-swal-fixed');
}


init();
