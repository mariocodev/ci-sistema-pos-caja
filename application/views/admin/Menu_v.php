<?php $controller = strtolower($this->router->class);?>
<table id="datatable" class="table table-sm table-bordered">
    <thead class="label-gris-total text-center">
        <tr>
            <th data-priority="1">ID</th>
            <th data-priority="2">Nombre</th>
            <th>Nivel</th>
            <th style="width: 20px !important">Icono</th>
            <th>Controlador</th>
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
            <div class="modal-body">
                <form id="form1" data-parsley-validate novalidate role="form" autocomplete="off">
					<input type="hidden" value="" name="menu_id">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="field-1" class="control-label">Descripción</label>
                                <input type="text" class="form-control" id="menu_nombre" name="menu_nombre" placeholder="Nombre del menú" required="">
                            </div>
                        </div>
                        <style>select#menu_icono{font-family: fontAwesome, "Helvetica Neue",Helvetica,Arial,sans-serif}</style>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-2" class="control-label">Nivel</label>
                                <select class="form-control" id="menu_nivel" name="menu_nivel">
									<option value="1">Nivel 1</option>
									<option value="2">Nivel 2</option>
								</select>
                            </div>
                        </div>
						<div class="col-md-4">
                            <div class="form-group">
                                <label for="field-2" class="control-label">Icono</label>
                                <select class="form-control" id="menu_icono" name="menu_icono">
									<option value="fa fa-cogs">&#xf085; fa-cogs</option>
									<option value="fa fa-database">&#xf1c0; fa-database</option>
									<option value='fa fa-money'>&#xf0d6; fa-money</option>
                                    <!-- https://codepen.io/Nagibaba/pen/bagEgx -->
								</select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-3" class="control-label">Menú Padre</label>
                                <select class="form-control" id="menu_id_padre" name="menu_id_padre">
								</select>
							</div>
                        </div>
						<div class="col-md-6">
                            <div class="form-group">
                                <label for="field-3" class="control-label">Controlador</label>
                                <input type="text" class="form-control" id="menu_controlador" name="menu_controlador" placeholder="Nombre del controlador">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="select_grupo" class="control-label">Habilitar menú para el grupo:</label>
                                <select id="select_grupo" class="select2 select2-multiple" multiple="multiple" multiple
                                        data-placeholder="Seleccionar ..." name="my_multi_select1[]">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn-guardar" onclick="enviar_datos()" 
                        class="btn btn-info waves-effect waves-light">Guardar</button>
                    </div>
                </form>
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
            pagingType: "full",
            fixedHeader: true,
            //"stateSave": true,
            responsive: true,
            "processing":true, 
            searchHighlight: true, 
            "serverSide":true,  
            "order":[],  
            "ajax":{
                url:"<?=base_url().'menu/datatable_datos'; ?>",  
                type:"POST"  
            },
            columnDefs: [
                { className : "text-center", targets: [0, 2, 3, 4]},
                { targets:['_all'], "orderable":false, }                
            ],
            "createdRow": function ( row, data, index ) {
                $("td", row).eq(3).html("<i class='"+data[3]+"'></i>");
                if(data[2] == 1) {
                    $("td", row).eq(2).html("<span class='label label-primary'>"+data[2]+'</span>');
                    $("td", row).eq(1).html("<b>"+data[1]+'</b>');
                    $("td", row).addClass('label-gris-claro font-weight-bold');
                }else if ( data[2] == 2){
                    $("td", row).eq(2).html("<span class='label label-gris-claro'>"+data[2]+'</span>');
                }
            }
        });
        datatable_config_botonesABMR();
        $('#menu_id_padre').attr('disabled', true);
		$('#menu_controlador').attr('disabled', true);

        //setInterval( function () {table.ajax.reload();}, 3000 );
        //$('#datatable').dataTable().fnClearTable();
    });
	
	// Accciones de campos de formulario
	$('#menu_nivel').change(function(){ 
		var value = $(this).val();
		if (value == 1){
			$('#menu_icono').attr('disabled', false);
			$('#menu_id_padre').attr('disabled', true);
            $('#menu_controlador').attr('disabled', true).attr('required', false);
            $('#select_grupo').attr('disabled', true).attr('required', false); 
		}else{
			$('#menu_icono').attr('disabled', true);
			$('#menu_id_padre').attr('disabled', false);
            $('#menu_controlador').attr('disabled', false).attr('required', true);
            $('#select_grupo').attr('disabled', false).attr('required', true);
		}
	});
	
    function agregar() {
        save_method = 'agregar';
        $('#form1')[0].reset(); // resetear datos del campo del formulario
        $('#modal_form1').modal('show'); // mostrar bootstrap modal
        $('.modal-title').text('Agregar'); // Setear Title to Bootstrap modal title
		
		$('#menu_icono').attr('disabled', false);
		$('#menu_id_padre').attr('disabled', true);
		$('#menu_controlador').attr('disabled', true).attr('required', false);
        $('#select_grupo').attr('disabled', true).attr('required', false);
        $("form").parsley().reset();

        menu_id_padre(0);
        listar_grupo(0);
    }

    function enviar_datos() {
        $("form").submit(function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            console.log("enviado correctamente");            
            guardar();
          });
    }

    function guardar() {        
        var url;
        if (save_method == 'agregar') {
            url = "<?php echo site_url($controller.'/agregar')?>";
        } else {
            url = "<?php echo site_url($controller.'/actualizar')?>";
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
        $("form").parsley().reset();

        $.ajax({
            url: "<?php echo site_url($controller.'/editar/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="menu_id"]').val(data.menu_id);                
                $('[name="menu_nombre"]').val(data.menu_nombre);
                $('[name="menu_nivel"]').val(data.menu_nivel);
                $('[name="menu_icono"]').val(data.menu_icono);
                $('[name="menu_id_padre"]').val(data.menu_id_padre);
                $('[name="menu_controlador"]').val(data.menu_controlador);
                $('#modal_form1').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Editar'); // Set title to Bootstrap modal title
				menu_id_padre(data.menu_id);
				if (data.menu_nivel == 1){
					$('#menu_icono').attr('disabled', false);
					$('#menu_id_padre').attr('disabled', true);
					$('#menu_controlador').attr('disabled', true);
                    $('#select_grupo').attr('disabled', true).attr('required', false);
				}else if (data.menu_nivel == 2){
					$('#menu_icono').attr('disabled', true);
					$('#menu_id_padre').attr('disabled', false);
					$('#menu_controlador').attr('disabled', false);
                    $('#select_grupo').attr('disabled', false).attr('required', true);
				}

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
        listar_grupo(id);
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
    function menu_id_padre(menu_id){
        $.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/menu_id_padre/')); ?>" + menu_id,
            type:  'POST',
            beforeSend: function () {
                $("#menu_id_padre").html("Procesando, espere por favor...");
            },
            success:  function (response) {
                $("#menu_id_padre").html(response);
                //$("#plan_id").select2();
            }
        });
    }
    /***
    *
    *   Grupo menu
    */
    function listar_grupo(menu_id) {  
        $.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/obtener_grupo_menu/')); ?>" + menu_id,
            type:  'POST',
            beforeSend: function () {
                $("#select_grupo").html("Procesando, espere por favor...");
            },
            success:  function (response) {
                $("#select_grupo").html(response);
                $("#select_grupo").select2();
            }
        });
    }
</script>