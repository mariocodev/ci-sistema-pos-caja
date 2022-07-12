</div>
<!-- Footer -->
<footer class="footer text-center">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 copyright text-center">
                <?=date("Y")?>©. |
                r<strong>{elapsed_time}</strong>s. &bull; versión: 
                <?php echo (ENVIRONMENT==='development') ? 'CI <strong>' . CI_VERSION . '</strong>': '' ?> &bull; System <strong>1.20.03</strong> | <span>{•_•} CodeGO!</span>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->
</div>

<!-- jQuery  -->
<script src="<?=base_url('template/assets/js/jquery.min.js')?>"></script>
<script src="<?=base_url('template/assets/js/')?>jquery-ui.min.js" type="text/javascript"></script>
<script src="<?=base_url('template/assets/js/bootstrap.min.js')?>"></script>
<script src="<?=base_url('template/assets/js/detect.js')?>"></script>
<script src="<?=base_url('template/assets/js/fastclick.js')?>"></script>
<script src="<?=base_url('template/assets/js/jquery.slimscroll.js')?>"></script>
<script src="<?=base_url('template/assets/js/jquery.blockUI.js')?>"></script>
<script src="<?=base_url('template/assets/js/waves.js')?>"></script>
<script src="<?=base_url('template/assets/js/wow.min.js')?>"></script>
<script src="<?=base_url('template/assets/js/jquery.nicescroll.js')?>"></script>
<script src="<?=base_url('template/assets/js/jquery.scrollTo.min.js')?>"></script>

<!-- Plugins Js -->
<script src="<?=base_url('template/assets/plugins/multiselect/js/jquery.multi-select.js')?>"></script>
<script src="<?=base_url('template/assets/plugins/jquery-quicksearch/jquery.quicksearch.js')?>"></script>
<script src="<?=base_url('template/assets/plugins/select2/dist/js/select2.min.js')?>"></script>

<!-- Datatables-->
<script src="<?=base_url('template/assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('template/assets/plugins/datatables/dataTables.bootstrap.js')?>"></script>
<script src="<?=base_url('template/assets/plugins/datatables/dataTables.buttons.min.js')?>"></script>
<script src="<?=base_url('template/assets/plugins/datatables/buttons.bootstrap.min.js')?>"></script>
<!--script src="<?=base_url('template/assets/plugins/datatables/jszip.min.js')?>"></script-->
<script src="<?=base_url('template/assets/plugins/datatables/pdfmake.min.js')?>"></script>
<script src="<?=base_url('template/assets/plugins/datatables/vfs_fonts.js')?>"></script>
<script src="<?=base_url('template/assets/plugins/datatables/buttons.html5.min.js')?>"></script>
<script src="<?=base_url('template/assets/plugins/datatables/buttons.print.min.js')?>"></script>
<script src="<?=base_url('template/assets/plugins/datatables/dataTables.fixedHeader.min.js')?>"></script>
<script src="<?=base_url('template/assets/plugins/datatables/dataTables.keyTable.min.js')?>"></script>
<script src="<?=base_url('template/assets/plugins/datatables/dataTables.responsive.min.js')?>"></script>
<script src="<?=base_url('template/assets/plugins/datatables/responsive.bootstrap.min.js')?>"></script>
<script src="<?=base_url('template/assets/plugins/datatables/dataTables.scroller.min.js')?>"></script>
<!-- Datatables highlight -->
<script src="<?=base_url('template/assets/plugins/datatables/dataTables.searchHighlight.min.js')?>"></script>
<script src="<?=base_url('template/assets/plugins/datatables/jquery.highlight.js')?>"></script>
<!-- Datatable init js -->
<script src="<?=base_url('template/assets/pages/jquery.datatables.init.js')?>"></script>

<!-- Sweet Alert js -->
<script src="<?=base_url('template/assets/plugins/bootstrap-sweetalert/')?>sweet-alert.min.js"></script>
<script src="<?=base_url('template/assets/pages/')?>jquery.sweet-alert.init.js"></script>
<!-- Toastr js -->
<script src="<?=base_url('template')?>/assets/plugins/toastr/toastr.min.js"></script>
<!-- Validation js (Parsleyjs) -->
<script type="text/javascript" src="<?=base_url('template/assets/plugins/')?>parsleyjs/dist/parsley.min.js"></script>

<!-- App js -->
<script src="<?=base_url('template/assets/js/jquery.core.js')?>"></script>
<script src="<?=base_url('template/assets/js/jquery.app.js')?>"></script>

<script type="text/javascript">
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
</script>
</body>
</html>