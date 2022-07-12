<?php $controller = strtolower($this->router->class);?>
<table id="datatable" class="table table-sm table-bordered">
    <thead class="label-gris-total text-center">
                    <tr>
                        <th data-priority="1">ID</th>
                        <th data-priority="2">Nro. Timbrado</th>
                        <th data-priority="4">Inicio Vigencia</th>
                        <th data-priority="3">Fin vigencia</th>
                        <th>Estado</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- end col -->
</div>
<!-- end row -->

<!-- /.modal -->
<div id="modal_form1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <form action="#" id="form1" data-parsley-validate novalidate role="form" autocomplete="off">
                <div class="modal-body">
					<input type="hidden" value="" name="timbrado_id">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="nro_timbrado" class="control-label">Nro. Timbrado</label>
                                <input type="text" class="form-control" id="nro_timbrado" name="nro_timbrado" placeholder="nro. timbrado" required="">
                            </div>
                        </div>
                        <div style="clear:both"></div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="fecha_desde" class="control-label">Inicio vigencia</label>
                                <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" required="">
                            </div>                           
                        </div>
						<div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="fecha_hasta" class="control-label">Fin vigencia</label>
                                <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" required="">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="estado" class="control-label">Estado</label>
                                <select class="form-control" id="estado" name="estado" required="">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-guardar" onclick="enviar_datos()" class="btn btn-info waves-effect waves-light">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- AJAX abm -->
<script src="<?=base_url('template/assets/js/jquery.min.js')?>"></script>
<script type="text/javascript">
    var save_method; //for save method string
    var table;
    $(document).ready(function(){  
        var table = $('#datatable').DataTable({
            dom: '<"btn-datatable dt-buttons btn-group">lfrtip',
            //dom: 'Blfrtip',
            "language": {
                "decimal": ",",
                "thousands": "."
            },
            lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
            pageLength: 25,
            pagingType: "full",
            fixedHeader: true,
            //stateSave: true,
            responsive: true,
            searchering:true,
            "processing":true,
            searchHighlight: true,  
            "serverSide":true,  
            "order":[],  
            "ajax":{
                url:"<?=base_url(strtolower($this->router->class.'/datatable_datos')); ?>",
                type:"POST"  
            },
            columnDefs: [
                { className : "text-center", targets: ['_all']},
                { targets:[0, 4], "orderable":false, }                
            ],
            "createdRow": function ( row, data, index ) {
                if(data[4] == 1) {
                    $("td", row).eq(4).html("<span class='label label-success'>Activo</span>");
                }else{
                    $("td", row).eq(4).html("<span class='label label-danger'>Inactivo</span>");
                }
            }
        });
        datatable_config_botonesABMR();        
    });
	
    function agregar() {
        save_method = 'agregar';
        $('#form1')[0].reset(); // resetear datos del campo del formulario
        $('#modal_form1').modal('show'); // mostrar bootstrap modal
        $('.modal-title').text('Agregar Timbrado'); // Setear Title to Bootstrap modal title
        
        $("#form1").parsley().reset();
    }
    function enviar_datos() {
        $("form").submit(function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            guardar();
          });
    }  

    function guardar() {
        var url;
        if (save_method == 'agregar') {
            url = "<?=base_url(strtolower($this->router->class.'/agregar')); ?>";
        } else {
            url = "<?=base_url(strtolower($this->router->class.'/actualizar')); ?>";
        }
        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form1').serialize(),
            dataType: "JSON",
            beforeSend: function () {
                // loading
            },
            success: function(data) {
                //if success close modal and reload ajax table
                $('#modal_form1').modal('hide');
                $('#datatable').dataTable().fnClearTable();
                notificacion(data.tipo, data.message, "toast-top-right");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error agregando / actualizando datos');
            }
        });
    }    

    function editar(id) {
        save_method = 'update';
        $('#form1')[0].reset(); // reset form on modals
        $("#form1").parsley().reset();

        $.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/editar/')); ?>" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('[name="timbrado_id"]').val(data.timbrado_id);                
                $('[name="nro_timbrado"]').val(data.nro_timbrado);
                $('[name="fecha_desde"]').val(data.fecha_desde);
                $('[name="fecha_hasta"]').val(data.fecha_hasta);
                $('#estado option[value="'+data.estado+'"]').prop('selected', true);

                $('#modal_form1').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Editar'); // Set title to Bootstrap modal title				

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
    }

    function eliminar(id) {
        swal({
            title: "¿Estás seguro?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-warning',
            confirmButtonText: "Si, estoy seguro!",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        }, function () {
            swal("Eliminado!", "El registro se ha eliminado.", "success");
            // ajax delete data from database
            $.ajax({
                url: "<?php echo site_url($controller.'/eliminar/')?>" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    $('#datatable').dataTable().fnClearTable();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error eliminando datos');
                }
            });
        });
    }
</script>