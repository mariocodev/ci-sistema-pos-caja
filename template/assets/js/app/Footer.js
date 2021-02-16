$(document).ready(function() {        
    $(".select2").select2();

    $('[data-toggle="tooltip"]').tooltip();
    $('.btn-agregar').tooltip({title: 'Agregar', content: 'Hello', placement: 'top'}).addClass("btn btn-default waves-effect waves-light");
    $('.btn-editar').tooltip({title: 'Editar', content: 'Hello', placement: 'top'}).addClass("btn btn-default waves-effect waves-light");
    $('.btn-eliminar').tooltip({title: 'Eliminar', content: 'Hello', placement: 'top'}).addClass("btn btn-default waves-effect waves-light");
    $('#refresh').tooltip({title: 'Recargar', content: 'Hello', placement: 'top'});
    $(".modal").draggable({handle: ".modal-header"});
    
    //setInterval( function () {ejecutar_backup();}, 900000 ); // 1000 milisegundos = 1 seg; 900000ms = 15min
    //ejecutar_backup();
} );    
$( window ).on( "load", function() {
    console.log( "system loaded" );        
});
// Validación de formulario
$('form input').keydown(function(){
    //$('.parsley-errors-list').css('display','block');
    //console.log('funca');
});

// Configuraciones comunes de datatable
function datatable_config_botonesABMR(){
    var table = $('#datatable').DataTable();
    $('#datatable tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('info') ) {
            $(this).removeClass('info');
        }
        else {
            table.$('tr.info').removeClass('info');
            $(this).addClass('info');
        }
    });
    $("div.btn-datatable").html('<a id="agregarRegistro" class="btn-agregar"> <i class="fa fa-plus"></i><a id="editarRegistro" class="btn-editar"><i class="zmdi zmdi-edit"></i></a><a id="eliminarRegistro" class="btn-eliminar"><i class="zmdi zmdi-delete"></i></a><a id="refresh" class="btn btn-default waves-effect waves-light"><i class="fa fa-refresh"></i></a>');        

    $('#agregarRegistro').click( function () {agregar();} );
    $('#editarRegistro').click( function (){
        var data = table.row('.info').data();
        if (data == undefined){notificacion("warning", "Selecciona un registro", "toast-top-right");}else{editar(data[0]);}
    });
    $('#eliminarRegistro').click( function (){
        var data = table.row('.info').data();
        if (data == undefined){notificacion("warning", "Selecciona un registro", "toast-top-right");}else{eliminar(data[0]);}
    });        
    $('#refresh').click( function (){$('#datatable').dataTable().fnClearTable();});
}
// Postion: "toast-top-right", "toast-bottom-right", "toast-bottom-left"," toast-bottom-full-width",
function notificacion(type, txt, position){
    Command: toastr[type](txt)
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": true,
      "progressBar": true,
      "positionClass": position,
      "preventDuplicates": true,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "2000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
}