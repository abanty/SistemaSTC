var tabla;

//Función que se ejecuta al inicio
function init(){

	mostrarform(false);


	$("#formulario").on("submit",function(e)
	{
		e.preventDefault();
		guardaryeditar(e);
	});


	//Cargamos los items al select proveedor
	$.post("../ajax/ingresopunto.php?op=selectPunto", function(r){
	            $("#idpuntoventa").html(r);
	            $('#idpuntoventa').selectpicker('refresh');
	});

}


//Función limpiar
function limpiar(){

	$("#total_traspaso").val("");
	$(".filas").remove();
	$("#total").html("0");

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_hora').val(today);
}

//Función mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag)
	{

		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		// $("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		listarProductosAlmacen();

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

//Funcion cancelarform
function cancelarform(){
	limpiar();
	mostrarform(false);
}

//Funcion listar
function listar(){
	tabla=$('#tbllistado').dataTable(
		{
				"aProcessing": true, //Activamos el procesamiento del datatables
				"aServerSide": true, //Paginacion y filtrado realizados por el servidor
				dom: 'Bfrtip',         //Definimos los elementos del control de tabla
				buttons: [
						// 'copyHtml5',
						// 'excelHtml5',
						// 'csvHtml5',
						// 'pdf'
			],
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
	$("#tbllistado_filter input").focus();
}

//Función ListarProductos
function listarProductosAlmacen(){
	tabla=$('#tblproductos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	   "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Brftip',//Definimos los elementos del control de tabla
	    buttons: [
		        ],
			// columnDefs: [
			// 	{ width: "50%", targets: 5 }
			// ],
		"ajax":
				{
					url: '../ajax/ingresopunto.php?op=listarActivosAlm',
					type : "get",
					dataType : "json",
					error: function(e){
						console.log(e.responseText);
					}
				},
		// "scrollCollapse": true,
		"sPaginationType": "full_numbers",
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

//Funcion para guardar o editar

function guardaryeditar(e){
	e.preventDefault(); //No se activara la accion predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/ingresopunto.php?op=guardaryeditar",
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

function mostrar(idingreso){

	//$("#btnagregar").hide();
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

//Funcion para desactivar registros
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


	function agregarDetalle(idproducto,producto,precio_venta)
	{


	  	var cantidad=1;

	    if (idproducto!="")
	    {
	    	var subtotal;

	    	var fila='<tr class="filas" id="fila'+cont+'">'+
	    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
	    	'<td><input class="form-control" type="hidden" name="idproducto[]" value="'+idproducto+'">'+producto+'</td>'+
	    	'<td style="width: 10%;"><input class="form-control" type="number" name="cantidad[]" id="cantidad" onchange="modificarSubototales()" onkeyup="modificarSubototales()" onblur="onBlur(this)" onfocus="onFocus(this)"  oninput="validaLength(this)" maxlength="4" min="1" max="10000" value="'+cantidad+'" required=""></td>'+
		  	'<td><span class="input-symbol-euro"><input class="form-control" type="number" step="0.01" min="0.00" max="10000.00" onchange="modificarSubototales()" onkeyup="modificarSubototales()" onblur="onBlur(this)" onfocus="onFocus(this)" id="precio_venta" name="precio_venta[]" value="'+precio_venta+'"></span></td>'+
      	'<td style="width: 10%;"><center><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></center></td>'+
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

	 /*---------------------------------------------------*
 	|FUNCION PARA LIMPIAR CAMPOS DETALLE VENTA AL INICIAR|
 	.---------------------------------------------------*/
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

	 /*---------------------------------------------------*
	 |FUNCION PARA VALIDAR EL MAXIMO DE IN INPUT MAXLENGTH|
	 .---------------------------------------------------*/
	 function validaLength(id)
	  {
	    if (id.value.length > id.maxLength)
	      id.value = id.value.slice(0, id.maxLength)
	  }

	//FUNCION PARA MODIFICAR SUBTOTALES
		  function modificarSubototales()
		  {

		  	var cant = document.getElementsByName("cantidad[]");
		    var precv = document.getElementsByName("precio_venta[]");
		    var sub = document.getElementsByName("subtotal");


		    for (var i = 0; i <cant.length; i++) {
		    	var inpC=cant[i];
		    	var inpPv=precv[i];
		    	var inpS=sub[i];

		  		inpS.value=inpC.value * inpPv.value;
		    	document.getElementsByName("subtotal")[i].innerHTML = "S/. " + parseFloat(Math.round(inpS.value * 100) / 100).toFixed(2);
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
				$("#total_traspaso").val(total);
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
