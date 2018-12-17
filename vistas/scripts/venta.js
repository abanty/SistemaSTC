var tabla;

// TODO:  FUNCION INICIO
function init(){

	mostrarform(false);

	listar();

	$("#formulario").on("submit",function(e)
	{
				guardaryeditar(e);
	});

	//Cargamos los items al select cliente
	$.post("../ajax/venta.php?op=selectCliente", function(r){
	            $("#idcliente").html(r);
	            $('#idcliente').selectpicker('refresh');

	});
}


// TODO:  FUNCION LIMPIAR CAMPOS
function limpiar()
{
	$("#idcliente").val("");
	$("#idventa").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	$("#impuesto").val("0");
	$("#total_venta").val("");
	$(".filas").remove();
	$("#total").html("0");
	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_hora').val(today);
    //Marcamos el primer tipo_documento
  $("#tipo_comprobante").val("Ticket");
	$("#tipo_comprobante").selectpicker('refresh');
}


// TODO:   FUNCION PARA ABRIR MODAL DE PRODUCTOS POR ALMACEN
function openproductofilter()
{
	$.post("../ajax/venta.php?op=selectAlmacenVenta", function(r){
	            $("#idalmacen").html(r);
						  $('#idalmacen').selectpicker('refresh');

							$('#modal-default').modal('toggle');
						 $('#idalmacen').on('change', function(){
								 var $this = $(this),
								 $value = $this.val();
								listarProductos($value);
								$('#myModal').modal('show');
						 });
	});
}


// TODO:   FUNCION PARA MOSTRAR FORMULARIO
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
			numFactura();
			numSerieFac();
			$(document).keydown(function(event) {
				var keycode = (event.keyCode ? event.keyCode : event.which);
				if (keycode == '107') {
						$('#myModal').modal('show');
				}
			});
			$(document).keydown(function(event) {
				var keycode = (event.keyCode ? event.keyCode : event.which);
				if (keycode == '46'){
						$('#elim').click();
				}
			});
			$('#idcliente').val('Publico General');
			$("#idcliente").selectpicker('refresh');
			$("#listadoregistros").hide();
			$("#formularioregistros").show();
			//$("#btnGuardar").prop("disabled",false);
			$("#btnagregar").hide();
			listarProductos();
			$("#btnGuardar").hide();
			$("#btnCancelar").show();
			$("#btnAgregarArt").show();
			detalles=0;
	}else{
					$("#listadoregistros").show();
					$("#formularioregistros").hide();
					$("#btnagregar").show();
			}
}


// TODO:  FUNCION PARA REFRESCAR SELECT ALMACEN
function refresh_selectalm(){
	$("#idalmacen").val("");
	$('#idalmacen').selectpicker('refresh');
}


// TODO:  FUNCION PARA CANCELAR  LAS VENTAS
function cancelarform()
{
	limpiar();
	mostrarform(false);
}


// TODO:  FUNCION PARA LISTAR LAS VENTAS
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [
		            // 'copyHtml5',
		            // 'excelHtml5',
		            // 'csvHtml5',
		            // 'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/venta.php?op=listar',
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


// TODO: FUNCION LISTAR PRODUCTOS
function listarProductos(idalmacen)
{
tabla=$('#tblproductos2').dataTable(
	{
			"aProcessing": true,
	    "aServerSide": true,
	    dom: 'Brtip',
	    buttons: [
	        ],
		"ajax":
				{
					url: "../ajax/venta.php?op=listarProductosVenta",
					type : "get",
					data: {
				    idalmacen: idalmacen,
				  },
					dataType : "json",
					error: function(e){
						console.log(e.responseText);
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,
	  "order": [[ 0, "desc" ]]
	}).DataTable();
}


// TODO:  FUNCION PARA GUARDAR O EDITAR
function guardaryeditar(e)
{
	e.preventDefault();
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/venta.php?op=guardaryeditar",
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

	limpiar();
}

																		//**********************
																		//FUNCION PARA MOSTRAR |
																		//*********************

function mostrar(idventa)
{
	$.post("../ajax/venta.php?op=mostrar",{idventa : idventa}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);

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

 	$.post("../ajax/venta.php?op=listarDetalle&id="+idventa,function(r){
	        $("#detalles").html(r);
	});
}

																	//******************************
																	//FUNCION PARA ANULAR REGISTROS|
																	//*****************************

function anular(idventa)
{
	swal({
	  title: '¿Está seguro de anular el ingreso?',
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
	}).then(function (e) {
		$.post("../ajax/venta.php?op=anular", {idventa : idventa}, function(e){
			swal(
  		(e),
  		'Satisfactoriamente!',
  		'success'

)    			//tabla.ajax.reload(null,false);

listar();
		});
	})
}



																		//*********************************************************************************
																		//Declaración de variables necesarias para trabajar con las compras y sus detalles|
																		//*********************************************************************************

var impuesto=18;
var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();
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

																				//******************************************
																				//FUNCION PARA AGREGAR DETALLE DE PRODUCTOS|
																				//*****************************************

function agregarDetalle(idproducto,producto,precio_venta,idalmacen)
  {
				swal({
				  title: 'Ingresa Cantidad:',
				  input: 'number',
				  inputPlaceholder: ''
				}).then(function (number) {

					var cantidad=number;
					var descuento=0;

		 if (idproducto!="")
		 {
			 var subtotal=cantidad*precio_venta;
			 var fila='<tr class="filas" id="fila'+cont+'">'+
			 '<td><button type="button" id="elim" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
			 '<td><input type="hidden" name="idproducto[]" value="'+idproducto+'" required="">'+producto+'</td>'+
			 '<td style><input type="number" name="cantidad[]" id="cantidad[]" value="'+cantidad+'" required=""></td>'+
			 '<td><input type="number" name="precio_venta[]" id="precio_venta[]" value="'+precio_venta+'" required=""></td>'+
			 '<td><input type="number" name="descuento[]" value="'+descuento+'" required=""></td>'+
			 '<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
			 '<td><button type="button" onclick="modificarSubototales()" class="btn btn-warning"><i class="fa fa-refresh"></i></button></td>'+
			  '<td><input type="hidden" name="idalmacen[]" value="'+idalmacen+'" required=""></td>'+
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

				})
  }

																//**********************************
																//FUNCION PARA MODIFICAR SUBTOTALES|
																//*********************************

  function modificarSubototales()
  {
  	var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_venta[]");
    var desc = document.getElementsByName("descuento[]");
    var sub = document.getElementsByName("subtotal");

    for (var i = 0; i <cant.length; i++) {
    	var inpC=cant[i];
    	var inpP=prec[i];
    	var inpD=desc[i];
    	var inpS=sub[i];

    	inpS.value=(inpC.value * inpP.value)-inpD.value;
    	document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
    }
    calcularTotales();

  }

																//******************************
																//FUNCION PARA CALCULAR TOTALES|
																//*****************************

  function calcularTotales(){
  	var sub = document.getElementsByName("subtotal");
  	var total = 0.0;

  	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
	}
	$("#total").html("S/. " + total);
    $("#total_venta").val(total);
    evaluar();
  }


													//******************************************
													//FUNCION PARA EVALUAR REGISTRO DE DETALLES|
													//*****************************************

function tecla(){
$(document).keyup(function(event) {
var keycode = (event.keyCode ? event.keyCode : event.which);
	if (keycode == '32'){
		if (detalles>0) {
$('#btnGuardar').click();
    }

   }
 });
}

	// TODO: 	FUNCION PARA EVALUAR REGISTRO DE DETALLES
function evaluar(){
  	if (detalles>0)
    {
      $("#btnGuardar").show();
			tecla();
    }
    else
    {
      $("#btnGuardar").hide();
      cont=0;
    }
}


// TODO: FUNCION PARA ELIMINAR DETALLE
function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar()
}


// TODO: FUNCION PARA FACTURACION NUMERACION
function numFactura(){
	$.ajax({
		url:'../modelos/NumFactura.php',
		type:'get',
		dataType:'json',
			success:function(res){
				if (res.respuesta==true){
				if(parseInt(res.mensaje)<10){
				$("#nfacturas").val("0000"+res.mensaje);
					}else if(parseInt(res.mensaje)<100){
					$("#nfacturas").val("000"+res.mensaje);
				}
			}
		}
	});
}


// TODO: FUNCION PARA FACTURACION NUMERACION SERIE
function numSerieFac(){
	$.ajax({
		url:'../modelos/NumSerie.php',
		type:'get',
		dataType:'json',
		success:function(res){
			if (res.respuesta2==true){
				if(parseInt(res.mensaje2)<10){
					$("#serie_comprobante").val("00"+res.mensaje2);
				}else if(parseInt(res.mensaje2)<100){
					$("#serie_comprobante").val("0"+res.mensaje2);
				}
			}
		}
	});
}


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
