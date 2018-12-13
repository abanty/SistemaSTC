var tabla;

// TODO:  FUNCION INICIO
function init(){
  listarNotas();
	mostrarform(false);

  $('#idalmacen').change(function() {
      mostrar_prod_alm_select();
  	});

    $('#idproducto').change(function() {
          mostrar_img_prod();
    	});

	$("#formulario").on("submit",function(e)
	{
    e.preventDefault();
    guardaryeditar(e);
	});

	//Cargamos los items al select cliente
	$.post("../ajax/nota_almacen.php?op=selectAlmacen", function(r){
	            $("#idalmacen").html(r);
	            $('#idalmacen').selectpicker('refresh');
	});
}


// TODO:  FUNCION LISTAR ALMACEN POR PARAMETRO
function mostrar_prod_alm_select()
{
	almacen_id=$("#idalmacen").val();
	$.post("../ajax/nota_almacen.php?op=select_producto_almacen",{idalmacen: almacen_id}, function(r){
	            $("#idproducto").html(r);
              $('#idproducto').selectpicker('refresh');
	});
}


// TODO:  FUNCION LISTAR ALMACEN POR PARAMETRO
function mostrar_img_prod()
{
	pro_id=$("#idproducto").val();

  $.post("../ajax/nota_almacen.php?op=mostrar_Imagen",{idproducto : pro_id}, function(data, status)
  {
      data = JSON.parse(data);
      $("#imagen_producto").attr("src","../files/productos/"+data.imagen);
  });

}


// TODO:  FUNCION LIMPIAR CAMPOS
function limpiar()
{
  $("#imagen_producto").attr("src","../files/productos/cesta.jpg");
  $("#idnota_almacen").val("");
  $('#idproducto').selectpicker('val', "");
  $('#idalmacen').selectpicker('val', "");
	$("#nota").val("");
	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_nota').val(today);
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
function listarNotas()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/nota_almacen.php?op=listarNotas',
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


// TODO:  FUNCION PARA GUARDAR O EDITAR
function guardaryeditar(e)
{
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/nota_almacen.php?op=guardaryeditar",
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


//FUNCION PARA MOSTRAR
function mostrar(idnota_almacen)

{
	$.post("../ajax/nota_almacen.php?op=mostrar",{idnota_almacen : idnota_almacen}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);

      $.post("../ajax/nota_almacen.php?op=select_producto_almacen",{idalmacen: data.idalmacen}, function(r){
                  $("#idproducto").html(r);
                  $('#idproducto').selectpicker('refresh');
                  $("#idproducto").selectpicker('val',data.idproducto);
      });
      $("#idproducto").selectpicker('refresh');
      $("#idalmacen").val(data.idalmacen);
      $("#idalmacen").selectpicker('refresh');
      $("#nota").val(data.nota);
      $("#fecha_nota").val(data.fecha_nota);
      $("#idnota_almacen").val(data.idnota_almacen);
      $("#imagen_producto").attr("src","../files/productos/"+data.imagen);

 	});
}


//FUNCION PARA ANULAR REGISTROS
function anular(idnota_almacen)
{
	swal({
	  title: '¿Está seguro de anular las Observaciones?',
	  //text: "You won't be able to revert this!",
	  //type: 'question',
		imageUrl: 'http://img.freepik.com/vector-gratis/trabajador-con-dudas_1012-193.jpg?size=338&ext=jpg',
		imageWidth: 250,
		imageHeight: 250,
		animation: false,
	  showCancelButton: true,
	  confirmButtonColor: '#f39c12',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Aceptar',
		cancelButtonText: 'Cancelar'
	}).then(function (e) {
		$.post("../ajax/nota_almacen.php?op=anular", {idnota_almacen : idnota_almacen}, function(e){
    			swal(
      		(e),
      		'Satisfactoriamente!',
      		'success'
        )
    	  $('#tbllistado').DataTable().ajax.reload(null, false);
		});
	})
}

init();
