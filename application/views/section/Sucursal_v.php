<?php $controller = strtolower($this->router->class);?>
<table id="datatable" class="table table-sm table-bordered">
    <thead class="label-gris-total text-center">
                    <tr>
                        <th data-priority="1">ID</th>
                        <th data-priority="2">Descripción</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th data-priority="3">RUC</th>
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
					<input type="hidden" value="" name="sucursal_id">
                    <div class="row">
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="sucursal_descripcion" class="control-label">Descripciónl</label>
                                <input type="text" class="form-control" id="sucursal_descripcion" name="sucursal_descripcion" placeholder="razón social" required="">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="sucursal_ruc" class="control-label">RUC</label>
                                <input type="text" class="form-control" id="sucursal_ruc" name="sucursal_ruc" placeholder="ruc" required="">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="sucursal_direccion" class="control-label">Dirección</label>
                                <input type="text" class="form-control" id="sucursal_direccion" name="sucursal_direccion" required="">
                            </div>                           
                        </div>
						<div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="form-group">
                                <label for="sucursal_telefono" class="control-label">Teléfono</label>
                                <input type="text" class="form-control" id="sucursal_telefono" name="sucursal_telefono">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="sucursal_central" class="control-label">Central</label>
                                <select class="form-control" id="sucursal_central" name="sucursal_central" required="">
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
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
                { className : "text-center", targets: [0, -1]},
                { targets:[0, 1], "orderable":false, }                
            ],
            "createdRow": function ( row, data, index ) {
                //$("td", row).eq(5).html((data[5] == 1) ? 'Si':'No');
            }
        });
        datatable_config_botonesABMR();
    });
	
    function agregar() {
        save_method = 'agregar';
        $('#form1')[0].reset(); // resetear datos del campo del formulario
        $('#modal_form1').modal('show'); // mostrar bootstrap modal
        $('.modal-title').text('Agregar'); // Setear Title to Bootstrap modal title
        
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
                $('[name="sucursal_id"]').val(data.sucursal_id);                
                $('[name="sucursal_descripcion"]').val(data.sucursal_descripcion);
                $('[name="sucursal_direccion"]').val(data.sucursal_direccion);
                $('[name="sucursal_telefono"]').val(data.sucursal_telefono);
                $('[name="sucursal_ruc"]').val(data.sucursal_ruc);
                $('[name="sucursal_central"]').val(data.sucursal_central);
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
        return notificacion("error", "Restringido", "toast-top-right");
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