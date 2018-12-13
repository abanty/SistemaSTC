var tabla;

// TODO:  FUNCION INICIO
function init(){

	mostrarform(false);

  $('#origen').change(function() {
      mostraralmacenparam();
      	$(".filas").remove();
  	});

	listarTraspasoProducto();

	$("#formulario").on("submit",function(e)
	{
    e.preventDefault();
    var tbody = $("#detalles tbody");
    if (tbody.children().length == 0) {
          alert('Por favor ingrese detalles ');
    }else {
        				guardaryeditar(e);
      }
	});

	//Cargamos los items al select cliente
	$.post("../ajax/transferencia.php?op=selectAlmacen", function(r){
	            $("#origen").html(r);
	            $('#origen').selectpicker('refresh');
	});
}


// TODO:  FUNCION LISTAR ALMACEN POR PARAMETRO
function mostraralmacenparam()
{
	origen=$("#origen").val();
	$.post("../ajax/transferencia.php?op=selectalmacentraspaso",{origen: origen}, function(r){
	            $("#destino").html(r);
              $('#destino').selectpicker('refresh');
	});
}


// TODO:  FUNCION LIMPIAR CAMPOS
function limpiar()
{
  $('#origen').selectpicker('val', "");
  $('#destino').selectpicker('val', "");
	$("#idtransferencia").val("");
	$("#observaciones").val("");
	$("#total_traspaso").val("");
  	$("#totalproductos").text("0");

	$(".filas").remove();
	$("#total").html("0");
	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_hora').val(today);
}


// TODO:   FUNCION PARA ABRIR MODAL DE PRODUCTOS POR ALMACEN
function openproductofilter()
{
    var key =   $( "#origen option:selected").val();
    if (key == "") {
      alert('Selecciona un Almacen de Origen');
    }else {
      listarProductos(key);
      $('#myModal').modal('show');
    }
}


// TODO:   FUNCION PARA MOSTRAR FORMULARIO
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
			$("#listadoregistros").hide();
			$("#formularioregistros").show();
			$("#btnagregar").hide();
			listarTraspasoProducto();
			// $("#btnGuardar").hide();
			$("#btnCancelar").show();
			detalles=0;
	}else{
					$("#listadoregistros").show();
					$("#formularioregistros").hide();
					$("#btnagregar").show();
			}
}


// TODO:  FUNCION PARA CANCELAR  LAS VENTAS
function cancelarform()
{
	limpiar();
	mostrarform(false);
}


// TODO:  FUNCION PARA LISTAR LAS VENTAS
function listarTraspasoProducto()
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
					url: '../ajax/transferencia.php?op=listarTraspaso',
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
					url: "../ajax/transferencia.php?op=listarProductosTraspaso",
					type : "get",
					data: {
				    origen: idalmacen,
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
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/transferencia.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,
	    success: function(datos)
			{
      $('#tbllistado').DataTable().ajax.reload(null, false);
				swal(
			(datos),
			'Satisfactoriamente!',
			'success'
			);
				mostrarform(false);
			}
	});

	limpiar();
}

																		//**********************
																		//FUNCION PARA MOSTRAR |
																		//*********************
//
// function mostrar(idtransferencia)
// {
// 	$.post("../ajax/venta.php?op=mostrar",{idtransferencia : idtransferencia}, function(data, status)
// 	{
// 		data = JSON.parse(data);
// 		mostrarform(true);
//
// 		$("#idcliente").val(data.idcliente);
// 		$("#idcliente").selectpicker('refresh');
// 		$("#tipo_comprobante").val(data.tipo_comprobante);
// 		$("#tipo_comprobante").selectpicker('refresh');
// 		$("#serie_comprobante").val(data.serie_comprobante);
// 		$("#num_comprobante").val(data.num_comprobante);
// 		$("#fecha_hora").val(data.fecha);
// 		$("#impuesto").val(data.impuesto);
// 		$("#idtransferencia").val(data.idtransferencia);
//
// 		//Ocultar y mostrar los botones
// 		$("#btnGuardar").hide();
// 		$("#btnCancelar").show();
// 		$("#btnAgregarArt").hide();
//  	});
//
//  	$.post("../ajax/venta.php?op=listarDetalle&id="+idtransferencia,function(r){
// 	        $("#detalles").html(r);
// 	});
// }

																	//******************************
																	//FUNCION PARA ANULAR REGISTROS|
																	//*****************************

function anular(idtransferencia)
{
	swal({
	  title: '¿Está seguro de anular el ingreso?',
	  //text: "You won't be able to revert this!",
	  //type: 'question',
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
		$.post("../ajax/venta.php?op=anular", {idtransferencia : idtransferencia}, function(e){
			swal(
  		(e),
  		'Satisfactoriamente!',
  		'success'

)    			//tabla.ajax.reload(null,false);

		});
	})
}

//FUNCION  O METODOS PARA ARREGLAR EL TABINDEX DEL MODAL|
	function fixBootstrapModal() {
  var modalNode = document.querySelector('.modal[tabindex="-1"]');
  if (!modalNode) return;

  modalNode.removeAttribute('tabindex');
  modalNode.classList.add('js-swal-fixed');
}

function restoreBootstrapModal() {
  var modalNode = document.querySelector('.modal.js-swal-fixed');
  if (!modalNode) return;

  modalNode.setAttribute('tabindex', '-1');
  modalNode.classList.remove('js-swal-fixed');
}


//Declaración de variables necesarias para trabajar con las compras y sus detalles|
var impuesto=18;
var cont=0;
var detalles=0;

//FUNCION PARA AGREGAR DETALLE DE PRODUCTOS|
function agregarDetalle(codigo,idproducto,producto,stock,idalmacen)
  {
		fixBootstrapModal();
    	if (stock!=0){
				swal({
				  title: 'Ingresa Cantidad:',
				  input: 'number',
				  inputPlaceholder: ''
				}).then(function (number) {
					var cantidad=number;
              if ((Number(cantidad)>0)&&(Number(cantidad)!="")) {
                if ((idproducto!="")&&(Number(stock)>=Number(cantidad)))
               {
               //  if (idproducto!="")
               // {
                 var subtotal=cantidad;
                 var fila='<tr class="filas" id="fila'+cont+'">'+
                 '<td><button type="button" id="elim" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
                 '<td><input type="text" name="codigo[]"  value="'+codigo+'" required=""></td>'+
                 '<td><input type="hidden" name="idproducto[]" value="'+idproducto+'" required="">'+producto+'</td>'+
                 '<td><input type="number" name="cantidad[]"  value="'+cantidad+'" required=""></td>'+
                 '<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
                 '<td><input type="hidden" name="idalmacen[]"  value="'+idalmacen+'" required=""></td>'+
                  '<td><input type="hidden" name="stock[]"  value="'+stock+'" required=""></td>'+
                 '<td><button type="button" onclick="modificarSubototales()" class="btn btn-warning"><i class="fa fa-refresh"></i></button></td>'+
                 '</tr>';
                 cont++;
                 detalles=detalles+1;
                 $('#detalles').append(fila);
                 modificarSubototales();

                } else {
                  swal({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Stock Superado',
                      }).catch(swal.noop);
               }
              }else {
                  swal({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Ingresa una cantidad correcta! ',
                      }).catch(swal.noop);
              }
				}).catch(swal.noop);
      }else {
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'Insuficiente Stock disponible',
            }).catch(swal.noop);
      }
  }


//FUNCION PARA MODIFICAR SUBTOTALES
  function modificarSubototales()
  {
  	var cant = document.getElementsByName("cantidad[]");
    var sub = document.getElementsByName("subtotal");

    for (var i = 0; i <cant.length; i++) {
    	var inpC=cant[i];
    	var inpS=sub[i];

    	inpS.value = parseInt(inpC.value);
    	document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
    }
    calcularTotales();
  }


	//FUNCION PARA CALCULAR TOTALES
  function calcularTotales(){
  	var sub = document.getElementsByName("subtotal");
  	var total = 0.0
  	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
	}
	$("#totalproductos").html(total);
    $("#total_traspaso").val(total);
    // evaluar();
  }


//FUNCION PARA EVALUAR REGISTRO DE DETALLES
  // function evaluar(){
  // 	if (detalles>0)
  //   {
  //     $("#btnGuardar").show();
  //   }
  //   else
  //   {
  //     $("#btnGuardar").hide();
  //     cont=0;
  //   }
  // }


	//FUNCION PARA ELIMINAR DETALLE
  function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar()
  }


init();
