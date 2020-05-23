<?php $controller = strtolower($this->router->class);?>
<table id="datatable" class="table table-sm table-bordered">
    <thead class="label-gris-claro text-center">
        <tr>
            <th data-priority="1">ID</th>
            <th>Nombre / Apellido</th>
            <th data-priority="2">Usuario</th>
            <th>Estado</th>
            <th>Grupo</th>
            <th>Registrado</th>
            <th>Actualizado</th>
            <th data-priority="3">Acciones</th>
        </tr>
    </thead>
</table>
</div>
</div>
</div>
<!-- end row -->

<!-- /.modal AGREGAR -->
<div id="modal_form1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form id="form1" data-parsley-validate novalidate role="form" autocomplete="off">
                    <input type="hidden" value="" name="usuario_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usuario_nombre" class="control-label">Nombre</label>
                                <input type="text" class="form-control" id="usuario_nombre" name="usuario_nombre"
                                       placeholder="Nombre" parsley-trigger="change" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usuario_apellido" class="control-label">Apellido</label>
                                <input type="text" class="form-control" id="usuario_apellido" name="usuario_apellido"
                                       placeholder="Apellido" required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="usuario_user" class="control-label">Usuario</label>
                                <input type="text" class="form-control" id="usuario_user" name="usuario_user"
                                       placeholder="Nombre de usuario" required="" data-parsley-length="[3, 40]">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="usuario_pass" class="control-label">Contraseña</label>
                                <input type="password" class="form-control" id="usuario_pass" name="usuario_pass"
                                           placeholder="Pass">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="usuario_estado" class="control-label">Estado</label>
                                <select class="form-control" id="usuario_estado" name="usuario_estado">
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="usuario_estado" class="control-label">Grupo</label>
                                <select id="select_grupo" class="select2 select2-multiple" multiple="multiple" multiple
                                        data-placeholder="Seleccionar ..." name="my_multi_select1[]" required="">
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
<!-- /.modal grupo -->
<div id="modal_form2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <style>
                    .select2-chosen{line-height: 23px}
                    .ms-container{width: 100% !important;}
                    ul.ms-list{height: 125px !important}
                </style>                
                <form action="#" id="form2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="grupo_id" class="control-label">Grupo de usuarios</label>
                                <select id="select_grupo2" class="form-control select2x" name="grupo_id">
                                </select>
                                <div class="btn-group m-b-10">
                                    <a onclick="grupo_form()" class="btn-agregar btn btn-default waves-effect btn-xs m-b-5">Agregar <i class="fa fa-plus"></i></a>
                                    <a onclick="grupo_editar($('#select_grupo2').val())" class="btn-editar btn btn-default waves-effect btn-xs m-b-5">Editar <i class="fa fa-edit"></i></a>
                                    <a onclick="grupo_eliminar($('#select_grupo2').val())" class="btn-eliminar btn btn-default waves-effect btn-xs m-b-5">Eliminar <i class="zmdi zmdi-delete"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="menu_id" class="control-label">Módulos</label>
                                <select class="form-control" id="menu_id" name="menu_id">
                                    <?php foreach ($listar_modulos as $menu) { ?>
                                    <optgroup label="<?= $menu->menu_nombre ?>">
                                        <?php if (isset($menu->children)) { ?>                            
                                        <?php foreach ($menu->children as $child) {?>
                                        <option value="<?= $child->menu_id ?>"><?= $child->menu_nombre ?></option>
                                        <?php }} ?>
                                    </optgroup>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="grupo_acciones_id" class="control-label">Acciones</label>
                                <div id="grupo_acciones_id">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
<!-- /.modal grupo ALTA -->
<div id="modal_grupo_form" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <form action="#" id="grupo_form1">
                    <input type="hidden" value="" name="grupo_id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="grupo_nombre" class="control-label">Nombre del grupo de usuario</label>
                                <input type="text" class="form-control" id="grupo_nombre" name="grupo_nombre"
                                       placeholder="Descripción grupo">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-guardar" onclick="grupo_guardar()"
                        class="btn btn-info waves-effect waves-light">Guardar</button>                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- AJAX -->
<script src="<?=base_url('template/assets/js/jquery.min.js')?>"></script>
<style type="text/css">
    th.dt-center, td.dt-center { text-align: center; }
</style>       
<script type="text/javascript">
    var save_method; //for save method string
    var table;

    /**
    *
    *   Configuración Datatable
    */

    $(document).ready(function(){  
        var table = $('#datatable').DataTable({
            dom: '<"btn-datatable dt-buttons btn-group">Blfrtip',
            //dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'print',
                    text: 'Imprimir',
                    autoPrint: true,
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                    },
                    customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '10pt' )
                            .prepend(
                            '<img src="<?=base_url('template/assets/images/logo-1.png'); ?>" style="position:absolute; top:0; left:0;opacity: 0.01" />'
                        );

                        $(win.document.body).find( 'table' )
                            .addClass( 'table table-sm' )
                            .css( 'font-size', 'inherit' );
                    }
                }
            ],
            lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
            pagingType: "full",
            fixedHeader: true,
            "stateSave": true,
            responsive: true,
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 },
                { responsivePriority: 3, targets: 2 },                
                { className : "dt-center", targets: [0, 2, 3, 4, 5, 6, -1]},
                { targets:[0, 4, 5, 6, -1], "orderable":false, }
            ],
            "processing":true,
            searchHighlight: true, 
            "serverSide":true,  
            "order":[],  
            "ajax":{
                url:"<?=strtolower($this->router->class).'/datatable_datos'; ?>",  
                type:"POST"  
            },
            "createdRow": function ( row, data, index ) {
                if(data[3] == 'activo') {
                    $("td", row).eq(3).html("<span class='btn-success btn-trans btn-sm m-b-5'>"+data[3]+'</span>');
                }else if ( data[3] == 'inactivo'){
                    $("td", row).eq(3).html("<span class='btn-danger btn-trans btn-sm m-b-5'>"+data[3]+'</span>');
                }else{$("td", row).eq(3).html("<span class='btn-info btn-trans btn-sm m-b-5'>"+data[3]+'</span>');}
                //  Botones
                $("td", row).eq(-1).append('<div class="btn-group"><a class="btn btn-default waves-effect waves-light btn-sm m-b-5 btn-editar" onclick="editar('+data[0]+')"><i class="zmdi zmdi-edit"></i></a><a class="btn btn-default waves-effect waves-light btn-sm m-b-5 btn-eliminar" onclick="eliminar('+data[0]+')"><i class="zmdi zmdi-delete"></i></a></div>');
            }
        });
        $('#datatable tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('info') ) {
                $(this).removeClass('info');
            }
            else {
                table.$('tr.info').removeClass('info');
                $(this).addClass('info btn-trans');
            }
        } );

        $("div.btn-datatable").html('<a id="agregarRegistro" class="btn-agregar"> <i class="fa fa-plus"></i><a id="editarRegistro" class="btn-editar"><i class="zmdi zmdi-edit"></i></a><a id="eliminarRegistro" class="btn-eliminar"><i class="zmdi zmdi-delete"></i></a><a id="refresh" class="btn btn-default waves-effect waves-light"><i class="fa fa-refresh"></i></a><a id="formGrupo" class="btn btn-default waves-effect" >Grupo de usuarios <i class="zmdi zmdi-accounts-alt"></i></a>');        

        $('#agregarRegistro').click( function () {agregarUsuario();} );
        $('#eliminarRegistro').click(function(){var data = table.row('.info').data();eliminar(data[0]);});
        $('#editarRegistro').click( function (){var data = table.row('.info').data();editar(data[0]);});
        $('#refresh').click( function (){$('#datatable').dataTable().fnClearTable();});
        $('#formGrupo').click( function () {formGrupo();} );

        //setInterval( function () {table.ajax.reload();}, 3000 );
        //$('#datatable').dataTable().fnClearTable();
    });

    /**
    *   
    *   Agregar, editar, actualizar, eliminar
    */
    function agregarUsuario() {
        save_method = 'agregar';
        $('#form1')[0].reset(); // resetear datos del campo del formulario
        $('#modal_form1').modal('show'); // mostrar bootstrap modal
        $('.modal-title').text('Nuevo usuario'); // Setear Title to Bootstrap modal title
        $("#usuario_pass").prop('required',true); // required solo al agregar usuario
        listar_grupo(0)
        $("#form1").parsley().reset();
    }

    function editar(id) {
        save_method = 'update';
        $('#form1')[0].reset(); // reset form on modals
        $("#usuario_pass").val('');
        $("#usuario_pass").removeAttr('required',true); // Sacar requerid del campo
        $("#form1").parsley().reset();
        //$("form").parsley().reset();
        //$('input, select').removeClass('parsley-error');
        //$('.parsley-errors-list').css('display','none');

        $.ajax({
            url: "<?php echo site_url($controller.'/editar/')?>" + id,
            type: 'POST',
            dataType: "JSON",
            success: function(data) {
                $('[name="usuario_id"]').val(data.usuario_id);                
                $('[name="usuario_nombre"]').val(data.usuario_nombre);
                $('[name="usuario_apellido"]').val(data.usuario_apellido);
                $('[name="usuario_user"]').val(data.usuario_user);
                $('[name="usuario_estado"]').val(data.usuario_estado);
                $('#modal_form1').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Editar usuario'); // Set title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
        listar_grupo(id);
    }
    function enviar_datos() {
        //$('.parsley-errors-list').css('display','block');
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
                //$('#datatable').DataTable().ajax.reload();
                $('#datatable').dataTable().fnDraw('page');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error agregando / actualizando datos');
            }
        });
    }

    function eliminar(id) {
        swal({
            title: "¿Estás seguro de eliminar a éste usuario?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-warning',
            confirmButtonText: "Si, estoy seguro!",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        }, function () {
            swal("Eliminado!", "El registro se ha borrado.", "success");
            // ajax delete data from database
            $.ajax({
                url: "<?php echo site_url($controller.'/eliminar/')?>" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    //$('#datatable').DataTable().ajax.reload();
                    $('#datatable').dataTable().fnDraw('page');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error borrando datos');
                }
            });
        });
    }
    /**
    *
    *   Grupo formulario
    */
    function formGrupo() {
        //save_method_1 = 'agregar';
        //$('#form2')[0].reset(); // resetear datos del campo del formulario
        $('#modal_form2').modal('show'); // mostrar bootstrap modal
        $('.modal-title').text('Administración de Grupo'); // Setear Title to Bootstrap modal title
        listar_grupo(0);
        listar_grupo_permisos(1, 2);        
    }

    /***
    *
    *   Grupo usuario
    */

    function listar_grupo(id) {  
        $.ajax({
            url: "<?php echo site_url($controller.'/obtener_grupo_usuario/')?>" + id,
            type:  'POST',
            beforeSend: function () {
                $("#select_grupo").html("Procesando, espere por favor...");
            },
            success:  function (response) {
                $("#select_grupo").html(response);
                $("#select_grupo2").html(response);
                $("#select_grupo").select2();
            }
        });
    }

    /***
    *
    *   Grupo permiso
    */
    $('#menu_id').change(function(){ 
        listar_grupo_permisos($("#select_grupo2").val(), $("#menu_id").val());
    });    

    $('#select_grupo2').change(function(){ 
        listar_grupo_permisos($("#select_grupo2").val(), $("#menu_id").val());
    });

    function listar_grupo_permisos(grupo_id, menu_id) {
        $.ajax({
            url: "<?php echo site_url($controller.'/obtener_grupo_permisos/')?>" + grupo_id + "/" + menu_id,
            type:  'POST',
            beforeSend: function () {
                $("#grupo_acciones_id").html("Listando acciones del perfil seleccionado, espere por favor...");
            },
            success:  function (response) {
                $("#grupo_acciones_id").html(response);
                //alert(response);
            }
        });
    }

    function asignar_permiso_perfil(grupo_id, menu_id, grupo_acciones_id) {
        $.ajax({
            url: "<?php echo site_url($controller.'/guardar_permiso_perfil/')?>" + grupo_id + "/" + menu_id + "/" + grupo_acciones_id,
            type:  'POST',
            beforeSend: function () {
                $("#grupo_acciones_id").html("Procesando, espere por favor...");
            },
            success:  function (response) {
                $("#grupo_acciones_id").html(response);
                listar_grupo_permisos(grupo_id, menu_id);
            }
        });
    }
    /**
    *
    *   Agregar grupo
    */
    function grupo_form() {
        save_method_1 = 'grupo_agregar';
        $('#grupo_form1')[0].reset(); // resetear datos del campo del formulario
        $('#modal_grupo_form').modal('show'); // mostrar bootstrap modal
        $('.modal-title-perfil-form').text('Agregar perfil'); // Setear Title to Bootstrap modal title        
    }

    function grupo_editar(id) {
        save_method_1 = 'grupo_update';
        $('#grupo_form1')[0].reset(); // reset form on modals

        $.ajax({
            url: "<?php echo site_url($controller.'/grupo_editar/')?>" + id,
            type: 'POST',
            dataType: "JSON",
            success: function(data) {
                $('[name="grupo_id"]').val(data.grupo_id);
                $('[name="grupo_nombre"]').val(data.grupo_nombre);
                $('#modal_grupo_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title-perfil-form').text('Editar'); // Set title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
        //listar_grupo(id);
    }

    function grupo_guardar() {
        var url;
        if (save_method_1 == 'grupo_agregar') {
            url = "<?php echo site_url($controller.'/grupo_agregar')?>";
        } else {
            url = "<?php echo site_url($controller.'/grupo_actualizar')?>";
        }
        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#grupo_form1').serialize(),
            dataType: "JSON",
            success: function(data) {
                //if success close modal and reload ajax table
                $('#modal_grupo_form').modal('hide');
                listar_grupo($('[name="grupo_id"]').val());
                listar_grupo_permisos($('[name="grupo_id"]').val(), $('[name="menu_id"]').val());                    
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error agregando / actualizando datos');
            }
        });
    }

    function grupo_eliminar(id) {
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
                url: "<?php echo site_url($controller.'/grupo_eliminar/')?>" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    listar_grupo($('[name="grupo_id"]').val());
                    listar_grupo_permisos($('[name="grupo_id"]').val(), $('[name="menu_id"]').val());
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error eliminando datos');
                }
            });
        });
    }
</script>
