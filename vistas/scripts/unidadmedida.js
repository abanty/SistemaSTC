/*-----------------------------------*
| INICIAMOS EL CODE JS PARA EMPRESA  |
.-----------------------------------*/
var tabla;

var column_no;

/*----------------*
| FUNCION INICIO  |
.----------------*/
function init(){


  $(document).ready(function(){

      $("#txtSearch").focus();
  });

  $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
  });

  listarunidadmedidas();

}


/*-------------------------------*
| Funcion para Limpiar refrescar |
.-------------------------------*/
function clearSearch() {
  $("#txtSearch").val('');
  tabla.search('').columns().search('').draw();
  $("#txtSearch").focus();
tabla.ajax.reload();

}

/*---------------------------*
| Funcion mostrar formulario |
.---------------------------*/
function mostrarform(flag) {

  // limpiar();
  if (flag) {
    $("#formularioregistros").show();
    $("#table_container").hide();
    $("#btnGuardar").prop("disabled", false);
    $("#btnagregar").hide();
  } else {
    $("#table_container").show();
    $("#formularioregistros").hide();
    $("#btnagregar").show();
  }
}

/*---------------------------------*
| Funcion listar registros activos |
.---------------------------------*/
function listarunidadmedidas() {

  column_no = 1;
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
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginacion y filtrado realizados por el servidor
        dom: 'rtip',         //Definimos los elementos del control de tabla

  "ajax":
      {
        url: '../ajax/unidadmedida.php?op=listar',
        type : "get",
        dataType : "json",
        error: function(e){
          console.log(e.responseText);
        }
      },
    "bDestroy": true,
    "iDisplayLength": 7, //Paginación
      "order": [[ 3, "desc" ]] //Ordenar (columna,orden)
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
   ]
}).container().appendTo($('#buttons'));

}

/*------------------------------*
| Funcion para guardar o editar |
.------------------------------*/
function guardaryeditar() {
  //No se activara la accion predeterminada del evento

  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "../ajax/unidadmedida.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function(datos) {
      tabla.ajax.reload(null, false);
      $.notify.defaults({ className: "success" });
      $.notify.defaults({ autoHideDelay: 5000 });
      $.notify.defaults({ style: 'bootstrap' });
      $("#show_notify_alert").notify(datos,{ position:"left top" });


    }
  });
}

/*------------------------------*
| Funcion para mostas registros |
.------------------------------*/
function mostrar(idunidadmedida) {

  $.post("../ajax/unidadmedida.php?op=mostrar", {
    idunidadmedida: idunidadmedida
  }, function(data, status) {
    data = JSON.parse(data);

        var nom_u = data.nombre;
        var idu = data.idunidadmedida;
        var tipouni = data.tipo;
        var abrev = data.abreviatura;
        var desc = data.descripcion;

    $.confirm({
        backgroundDismiss: true,
        title: 'Actualiza una unidadmedida',
        type: 'personal',
        content: '' +
        '<form name="formulario" id="formulario" method="POST">'+
        '<div class="form-group">' +
        '<label>Nombre</label>' +
        '<input type="hidden" name="idunidadmedida" id="idunidadmedida" value="'+idu+'"/>' +
        '<input type="text" name="nombre" id="nombre" value="'+nom_u+'" placeholder="Ingresa unidad de medida" class="name form-control" autofocus required />' +
        '</div>' +
        '<div class="form-group">' +
        '<label>Tipo de Unidad</label>' +
        '<select name="tipou" id="tipou" class="estado form-control"  required>'+
             '<option value="'+tipouni+'" selected style="display:none">'+tipouni+'</option>'+
             '<option value="Unidad Base">Unidad Base</option>'+
          '</select>'+
        '</div>' +
        '<div class="form-group">' +
        '<label>Abreviatura</label>' +
        '<input type="text" name="abreviatura" id="abreviatura" value="'+abrev+'" placeholder="Ingresa tipo de unidad" class="name form-control" autofocus required />' +
        '</div>' +
        '<div class="form-group">' +
        '<label>Descripcion</label>' +
        '<textarea style="resize: none;" rows="3" cols="50" id="descripcion" placeholder="Ingresa una descripcion breve" name="descripcion" class="form-control col-md-7 col-xs-12" required="required">'+desc+'</textarea>' +
        '</div>' +
        '</form>',
        buttons: {
            formSubmit: {
                text: 'Actualizar',
                btnClass: 'btn-success',
                action: function () {

                    var nombre = this.$content.find('#nombre').val();
                    var tipoun = this.$content.find('#tipou').val();
                    var abrev = this.$content.find('#abreviatura').val();

                    if(!nombre||!tipoun||!abrev){
                    $.alert('<span style="color:red; font-style:italic; font-weight:bold;"> - Por favor Ingresa Campos Requeridos (*)</span>');
                    return false;
                    }else {
                      guardaryeditar();
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
            this.$content.find('#formulario').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });

  })
}

function editreg_form(){

  $.confirm({
      icon: 'fa fa-pencil-square-o',
      title: ' REGISTRAR:'+' <span style="font-size:16px;"> Unidad de Medida (*)</span>',
      content: '' +
      '<form name="formulario" id="formulario" method="POST">'+
      '<div class="form-group">' +
      '<label>Nombre</label>' +
      '<input type="hidden" name="idunidadmedida" id="idunidadmedida"/>' +
      '<input type="text" name="nombre" id="nombre" placeholder="Ingresa unidad de medida" class="name form-control" autofocus required />' +
      '</div>' +
      '<div class="form-group">' +
      '<label>Tipo de Unidad</label>' +
      '<select name="tipou" id="tipou" class="estado form-control"  required>'+
           '<option value="" selected style="display:none">Selecciona tipo de unidad</option>'+
           '<option value="Unidad Base">Unidad Base</option>'+
        '</select>'+
      '</div>' +
      '<div class="form-group">' +
      '<label>Abreviatura</label>' +
      '<input type="text" name="abreviatura" id="abreviatura" placeholder="Ingresa tipo de unidad" class="name form-control" autofocus required />' +
      '</div>' +
      '<div class="form-group">' +
      '<label>Descripcion</label>' +
      '<textarea style="resize: none;" rows="3" cols="50" id="descripcion" placeholder="Ingresa una descripcion breve" name="descripcion" class="form-control col-md-7 col-xs-12" required="required"></textarea>' +
      '</div>' +
      '</form>',
      type: 'personal',
      buttons: {
          formSubmit: {
              text: 'Registrar',
              btnClass: 'btn-success',
              action: function () {

                var nombre = this.$content.find('#nombre').val();
                var tipoun = this.$content.find('#tipou').val();
                var abrev = this.$content.find('#abreviatura').val();

                if(!nombre||!tipoun||!abrev){
                $.alert('<span style="color:red; font-style:italic; font-weight:bold;"> - Por favor Ingresa Campos Requeridos (*)</span>');
                return false;
                }else {
                  guardaryeditar();
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
          this.$content.find('#formulario').on('submit', function (e) {
              // if the user submits the form by pressing enter in the field.
              e.preventDefault();
              jc.$$formSubmit.trigger('click'); // reference the button and click it
          });
      }
  });

}

/*----------------------------------*
| Funcion para desactivar registros |
.----------------------------------*/
function desactivar(idunidadmedida) {

  $.confirm({

    icon: 'fa fa-warning',
    title: 'Advertencia!',
    content: '¿Está seguro de desactivar la unidad de medida Actual?',
    type: 'red',
   typeAnimated: true,
    buttons: {
        somethingElse: {
            icon: 'fa fa-danger',
            text: 'Confirmar',
            btnClass: 'btn-danger',
            keys: ['enter', 'shift'],
            action: function(){
                $.post("../ajax/unidadmedida.php?op=desactivar", {
                  idunidadmedida: idunidadmedida
                }, function(e) {
                  $('#tbllistado').DataTable().ajax.reload(null, false);
                  $('#tbllistado').DataTable().ajax.reload(null, false);
                  $.notify.defaults({ className: "error" });
                  $.notify.defaults({ autoHideDelay: 5000 });
                  $.notify.defaults({ style: 'bootstrap' });
                  $("#show_notify_alert").notify(e,{ position:"left top" });
                });

            }
        },
        heyThere: {
            text: 'Cancelar',
            btnClass: 'btn-default',
            keys: ['enter', 'a'],
            isHidden: false, //
            isDisabled: false, //
            // action: function(){
            //       $.alert('Cancelado!');
            // }
        },
      }
  });
}

/*-------------------------------*
| Funcion para activar registros |
.-------------------------------*/
function activar(idunidadmedida) {
  $.confirm({
    icon: 'fa fa-question-circle',
    title: 'Advertencia!',
    content: '¿Está seguro de activar la unidad de medida Actual?',
    type: 'yellow',
   typeAnimated: true,
    buttons: {
        somethingElse: {
            icon: 'fa fa-warning',
            text: 'Confirmar',
            btnClass: 'btn-warning',
            keys: ['enter', 'shift'],
            action: function(){
                $.post("../ajax/unidadmedida.php?op=activar", {
                  idunidadmedida: idunidadmedida
                }, function(e) {

                    $('#tbllistado').DataTable().ajax.reload(null, false);
                    $.notify.defaults({ className: "success" });
                    $.notify.defaults({ autoHideDelay: 5000 });
                    $.notify.defaults({ style: 'bootstrap' });
                    $("#show_notify_alert").notify(e,{ position:"left top" });

                });

            }
        },
        heyThere: {
            text: 'Cancelar',
            btnClass: 'btn-default',
            keys: ['enter', 'a'],
            isHidden: false, //
            isDisabled: false, //
            // action: function(){
            //       $.alert('Cancelado!');
            // }
        },
      }
  });
}

/*--------------------------------*
| Funcion para eliminar registros |
.--------------------------------*/
function eliminar(idunidadmedida) {
  $.confirm({
    icon: 'fa fa-times',
    title: 'Peligro!',
    content: '¿Está seguro de eliminar la unidad de medida Actual?',
    type: 'red',
   typeAnimated: true,
    buttons: {
        somethingElse: {
            icon: 'fa fa-warning',
            text: 'Confirmar',
            btnClass: 'btn-red',
            keys: ['enter', 'shift'],
            action: function(){
                $.post("../ajax/unidadmedida.php?op=eliminar", {
                  idunidadmedida: idunidadmedida
                }, function(e) {

                  $('#tbllistado').DataTable().ajax.reload(null, false);

                    $.alert('<strong><i style="font-size:20px;" class="fa fa-thumb-tack"></i> '+e+ ' <i style="color:green; font-size:20px;" class="fa fa-check"></i></strong>');
                });

            }
        },
        heyThere: {
            text: 'Cancelar',
            btnClass: 'btn-default',
            keys: ['enter', 'a'],
            isHidden: false, //
            isDisabled: false, //
            // action: function(){
            //       $.alert('Cancelado!');
            // }
        },
      }
  });
}


init();
