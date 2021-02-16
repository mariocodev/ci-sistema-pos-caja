</div>
<!-- Footer -->
<footer class="footer text-center" style="color: ghostwhite;" >
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
<script src="<?=base_url('template/assets/plugins/datatables/jszip.min.js')?>"></script>
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
<!-- Se cargan las funciones JS -->
<script src="<?= base_url('template/assets/js/app/'.$archivoJS.'.js') ?>"></script>
<script src="<?= base_url('template/assets/js/app/Footer.js') ?>"></script>
</body>
</html>