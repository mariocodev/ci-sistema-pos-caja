<?php $controller = strtolower($this->router->class);?>
<table id="datatable" class="table table-sm table-bordered">
    <thead class="label-gris-total text-center">
                    <tr>
                        <th data-priority="1">ID</th>
                        <th data-priority="2">Plan</th>
                        <th data-priority="4">Rango edad</th>
                        <th data-priority="3">Costo</th>
                        <th>Vigencia</th>
                        <th>Limites</th>
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
					<input type="hidden" value="" name="plan_id">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="plan_categoria_id" class="control-label">Categoría</label>
                                <select id="plan_categoria_id" class="form-control" name="plan_categoria_id" required></select>
                                <div class="btn-group m-b-10">
                                    <button onclick="categoria_form_abrir()" type="button" class="btn btn-default waves-effect btn-xs m-b-5">Agregar</button>
                                    <button onclick="categoria_editar($('#plan_categoria_id').val())" type="button" class="btn btn-default waves-effect btn-xs m-b-5">Editar</button>
                                    <button onclick="categoria_inactivar($('#plan_categoria_id').val())" type="button" class="btn btn-default waves-effect btn-xs m-b-5">Inactivar</button>
                                </div>                                
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="plan_rango_edad_id" class="control-label">Rango de edad (años)</label>
                                <select id="plan_rango_edad_id" class="form-control" name="plan_rango_edad_id" required>
                                </select>
                                <div class="btn-group m-b-10">
                                    <button onclick="rango_edad_form_abrir()" type="button" class="btn btn-default waves-effect btn-xs m-b-5">Agregar</button>
                                    <button onclick="rango_edad_editar($('#plan_rango_edad_id').val())" type="button" class="btn btn-default waves-effect btn-xs m-b-5">Editar</button>
                                </div>
                            </div>                            
                        </div>
						<div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="planes_costo" class="control-label">Costo</label>
                                <input type="number" class="form-control" id="planes_costo" name="planes_costo" placeholder="Gs." required="" data-parsley-type="number">
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
<!-- /.modal CATEGORIA -->
<div id="modal-planes-categoria" class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="padding-bottom: 0">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title-planes-categoria"></h4>
            </div>
            <form action="#" id="form-planes-categoria" data-parsley-validate novalidate role="form" autocomplete="off">
                <div class="modal-body">                
                    <input type="hidden" value="" name="plan_categoria_id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="plan_categoria_nombre" name="plan_categoria_nombre" placeholder="Nombre categoria" parsley-trigger="change" required="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-guardar" onclick="categoria_guardar()" class="btn btn-info waves-effect waves-light">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modal -->
<!-- /.modal RANGO EDAD -->
<div id="modal-rango-edad" class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="padding-bottom: 0">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title-rango-edad"></h4>
            </div>
            <div class="modal-body">
                <form action="#" id="form-rango-edad" data-parsley-validate novalidate role="form" autocomplete="off">
                    <input type="hidden" value="" name="plan_rango_edad_id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-2" class="control-label">Rango de edad (años)</label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="number" class="form-control text-center" id="planes_rango_limite_inferior" min="0" max="100" value="0" name="planes_rango_limite_inferior" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="number" class="form-control text-center" id="planes_rango_limite_superior" min="0" max="100" value="100" name="planes_rango_limite_superior" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="plan_rango_edad_id" class="control-label">Vigencia
                                            </label>
                                            <select id="plan_vigencia_id" class="form-control" name="plan_vigencia_id" required>
                                            </select>
                                            <!--div class="btn-group m-b-10">
                                                    <button onclick="rango_edad_form_abrir()" type="button" class="btn btn-default waves-effect btn-xs m-b-5">Agregar</button>
                                                    <button onclick="rango_edad_editar($('#plan_rango_edad_id').val())" type="button" class="btn btn-default waves-effect btn-xs m-b-5">Editar</button>
                                                </div-->
                                        </div>                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-guardar" onclick="rango_edad_guardar()" 
                class="btn btn-info waves-effect waves-light">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
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
                { targets:[0, 1, 5], "orderable":false, }                
            ],
            "createdRow": function ( row, data, index ) {
                if(data[1] == 'Oro') {
                    $("td", row).eq(1).html("<span class='label label-warning'>"+data[1]+'</span>');
                }else if ( data[1] == 'Plata'){
                    $("td", row).eq(1).html("<span class='label label-primary'>"+data[1]+'</span>');
                }else if ( data[1] == 'Platino'){
                    $("td", row).eq(1).html("<span class='label label-purple'>"+data[1]+'</span>');
                }else{
                    $("td", row).eq(1).html("<span class='label label-gris-claro'>"+data[1]+'</span>');
                }
            }
        });
        datatable_config_botonesABMR();        
    });
	
    function agregar() {
        save_method = 'agregar';
        $('#form1')[0].reset(); // resetear datos del campo del formulario
        $('#modal_form1').modal('show'); // mostrar bootstrap modal
        $('.modal-title').text('Agregar un Plan'); // Setear Title to Bootstrap modal title
        
        planes_categorias(0);
        planes_rango_edad(0);
        $("#form1").parsley().reset();
    }
    function enviar_datos() {
        $("form").submit(function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            console.log("ingreso al evento");            
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
            success: function(data) {
                //if success close modal and reload ajax table
                $('#modal_form1').modal('hide');
                $('#datatable').dataTable().fnClearTable();
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
                $('[name="plan_id"]').val(data.plan_id);                
                $('[name="plan_categoria_id"]').val(data.plan_categoria_id);
                $('[name="plan_rango_edad_id"]').val(data.plan_rango_edad_id);
                $('[name="planes_costo"]').val(data.planes_costo);
                planes_categorias(data.plan_id);
                planes_rango_edad(data.plan_id);

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

    // Call AJAX Select
    function planes_categorias(plan_id){
        $.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/planes_categorias/')); ?>" + plan_id,
            type:  'POST',
            beforeSend: function () {
                $("#plan_categoria_id").html("Procesando, espere por favor...");
            },
            success:  function (response) {
                $("#plan_categoria_id").html(response);
                //$("#plan_id").select2();
            }
        });
    }

    function planes_rango_edad(plan_id){
        $.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/planes_rango_edad/')); ?>" + plan_id,
            type:  'POST',
            beforeSend: function () {
                $("#plan_rango_edad_id").html("Procesando, espere por favor...");
            },
            success:  function (response) {
                $("#plan_rango_edad_id").html(response);
                //$("#plan_id").select2();
            }
        });
    }

    function planes_vigencia(plan_rango_edad_id){
        $.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/planes_vigencia/')); ?>" + plan_rango_edad_id,
            type:  'POST',
            beforeSend: function () {
                $("#plan_vigencia_id").html("Procesando, espere por favor...");
            },
            success:  function (response) {
                $("#plan_vigencia_id").html(response);
                //$("#plan_id").select2();
            }
        });
    }

    /*******************
    *
    *   PLANES CATEGORIAS
    */

    function categoria_form_abrir() {
        save_method_1 = 'agregar_categoria';
        $('#form-planes-categoria')[0].reset(); // resetear datos del campo del formulario
        $('#modal-planes-categoria').modal('show'); // mostrar bootstrap modal
        $('.modal-title-planes-categoria').text('Agregar categoria');
        $("#form-planes-categoria").parsley().reset();
    }

    function categoria_guardar() {
        $("#form-planes-categoria").submit(function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            console.log("ingreso al evento");            
            categoria_guardar_enviar();
          });
    } 

    function categoria_guardar_enviar() {
        var url;        
        if (save_method_1 == 'agregar_categoria') {
            url = "<?=base_url(strtolower($this->router->class.'/agregar_categoria')); ?>";
        } else {
            url = "<?=base_url(strtolower($this->router->class.'/categoria_actualizar')); ?>";
        }
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form-planes-categoria').serialize(),
            dataType: "JSON",
            success: function(data) {
                $('#modal-planes-categoria').modal('hide');
                planes_categorias(0);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error agregando / actualizando datos');
            }
        });
    }

    function categoria_editar(id) {
        $("#form-planes-categoria").parsley().reset();
        save_method_1 = 'actualiza_categoria';
        $('#form-planes-categoria')[0].reset();
        $.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/categoria_editar')); ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('[name="plan_categoria_id"]').val(data.plan_categoria_id);                
                $('[name="plan_categoria_nombre"]').val(data.plan_categoria_nombre);
                $('#modal-planes-categoria').modal('show');
                $('.modal-title-planes-categoria').text('Editar categoría');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
    }
    /*******************
    *
    *   PLANES RANGO EDAD
    */

    function rango_edad_form_abrir() {
        save_method_2 = 'rango_edad_agregar';
        $('#form-rango-edad')[0].reset(); // resetear datos del campo del formulario
        $('#modal-rango-edad').modal('show'); // mostrar bootstrap modal
        $('.modal-title-rango-edad').text('Agregar rango edad');
        planes_vigencia(0);
    }

    function rango_edad_guardar() {
        var url;        
        if (save_method_2 == 'rango_edad_agregar') {
            url = "<?=base_url(strtolower($this->router->class.'/rango_edad_agregar')); ?>";
        } else {
            url = "<?=base_url(strtolower($this->router->class.'/rango_edad_actualizar')); ?>";
        }
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form-rango-edad').serialize(),
            dataType: "JSON",
            success: function(data) {
                $('#modal-rango-edad').modal('hide');
                planes_rango_edad(0);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error agregando / actualizando datos');
            }
        });
    }

    function rango_edad_editar(id) {
        save_method_2 = 'rango_edad_actualizar';
        $('#form-rango-edad')[0].reset();
        $.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/rango_edad_editar')); ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('[name="plan_rango_edad_id"]').val(data.plan_rango_edad_id);                
                $('[name="planes_rango_limite_inferior"]').val(data.planes_rango_limite_inferior);
                $('[name="planes_rango_limite_superior"]').val(data.planes_rango_limite_superior);
                $('#modal-rango-edad').modal('show');
                $('.modal-title-rango-edad').text('Editar rango edad');
                planes_vigencia(data.plan_rango_edad_id);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
    }
</script>