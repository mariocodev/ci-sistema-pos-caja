<?php $controller = strtolower($this->router->class);?>
<table id="datatable" class="table table-sm table-bordered">
    <thead class="label-gris-total text-center">
                    <tr>
                        <th data-priority="1">ID</th>
                        <th data-priority="2">Nro. Timbrado</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th data-priority="3">Actual</th>
                        <th>Sucursal</th>
                        <th>Estado</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- end col -->
</div>
<!-- end row -->
<style>
	label,
	input {
			display: block;
	}
	input {
			width: 100%;
			padding: 10px;
			outline: 0;
			border: 2px solid #B0BEC5;
	}
	input:invalid {
			border-color: #DD2C00 !important;
	}

	#notify {
		margin-top: 5px;
		padding: 10px;
		font-size: 12px;
		width: 100%;
		color: #fff;
		display: block;
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
	}
	#notify.error {
		background-color: #DD2C00;
	}
</style>
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
					<input type="hidden" value="" name="factura_id">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="nro_timbrado" class="control-label">Timbrado <small id="loadTimbrado"></small></label>
                                <select class="form-control" id="timbrado" name="timbrado_id" required=""></select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="sucursal" class="control-label">Sucursal <small id="loadSucursal"></small></label>
                                <select class="form-control" id="sucursal" name="sucursal_id" required=""></select>
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="nro_desde" class="control-label">Nro. desde</label>
                                <input type="text" class="form-control" id="nro_desde" name="nro_desde" required="true" onkeyup="this.value=formatNroFactura(this.value);" placeholder="000-000-0000000" pattern="\d{3}[\-]\d{3}[\-]\d{7}" parsley-trigger="change" data-parsley-length="[1,15]" >
                            </div>
                        </div>
						<div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="nro_hasta" class="control-label">Nro. hasta</label>
                                <input type="text" class="form-control" id="nro_hasta" name="nro_hasta" required="" onkeyup="this.value=formatNroFactura(this.value);" placeholder="000-000-0000000" pattern="\d{3}[\-]\d{3}[\-]\d{7}">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="nro_actual" class="control-label">Nro. actual</label>
                                <input type="text" class="form-control" id="nro_actual" name="nro_actual" required="" onkeyup="this.value=formatNroFactura(this.value);" placeholder="000-000-0000000" pattern="\d{3}[\-]\d{3}[\-]\d{7}">
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
                { targets:[0, 5], "orderable":false, }                
            ],
            "createdRow": function ( row, data, index ) {
                $("td", row).eq(4).html("<span class='label label-warning'>"+data[4]+'</span>');
                if(data[6] == 1) {
                    $("td", row).eq(6).html("<span class='label label-success'>Activo</span>");
                }else{
                    $("td", row).eq(6).html("<span class='label label-danger'>Inactivo</span>");
                }
            }
        });
        datatable_config_botonesABMR();        
    });

    function agregar() {
        save_method = 'agregar';
        $('#form1')[0].reset(); // resetear datos del campo del formulario
        $('#modal_form1').modal('show'); // mostrar bootstrap modal
        $('.modal-title').text('Agregar Factura'); // Setear Title to Bootstrap modal title
        timbrado(0);
        sucursal(0);
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
                $('[name="factura_id"]').val(data.factura_id);
                timbrado(data.timbrado_id);
                $('[name="nro_desde"]').val(data.nro_desde);
                $('[name="nro_hasta"]').val(data.nro_hasta);
                $('[name="nro_actual"]').val(data.nro_actual);
                sucursal(data.sucursal_id);
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

    function timbrado(timbrado_id){
        $.ajax({
            url: "<?=base_url('timbrado/getAll/'); ?>",
            type:  'GET',
            dataType: 'json',
            beforeSend: function () {
                $("small#loadTimbrado").html("Procesando, espere por favor...");
            },
            success: function (response) {
                $("#timbrado").empty();
                $("small#loadTimbrado").html("");
                $.each(response, function(key, data) {
                    $("#timbrado").append('<option value='+data.timbrado_id+'>'+data.nro_timbrado+'</option>');
                });
                if (timbrado_id > 0)
                    $('#timbrado option[value="'+timbrado_id+'"]').prop('selected', true);
            },
            error: function(data) {
                console.log('error');
            }
        });
    }

    function sucursal(sucursal_id){
        $.ajax({
            url: "<?=base_url('sucursal/getAll/'); ?>",
            type:  'GET',
            dataType: 'json',
            beforeSend: function () {
                $("small#loadSucursal").html("Procesando, espere por favor...");
            },
            success: function (response) {
                $("#sucursal").empty();
                $("small#loadSucursal").html("");
                $.each(response, function(key, data) {
                    $("#sucursal").append('<option value='+data.sucursal_id+'>'+data.sucursal_descripcion+'</option>');
                });
                if (sucursal_id > 0)
                    $('#sucursal option[value="'+sucursal_id+'"]').prop('selected', true);
            },
            error: function(data) {
                console.log('error');
            }
        });
    }

    function formatNroFactura(x) {
        let num = x.replace(/[^\d]/g,'');
        console.log(num);
        console.log(num.length);
        //if (num.length > 13) ;
        //return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return x.toString()//.replace(/\D/g, "")
            .replace(/([0-9]{3})([0-9]{3})([0-9]{7})$/, '$1-$2-$3')
            //.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, "-");
    }


</script>