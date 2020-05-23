<?php
	//setlocale(LC_TIME, 'spanish');
    //echo ucwords(strftime("%B", strtotime("13-12-2018 14:26:05")));
    //var_dump($_SERVER);
    //echo $this->input->ip_address();
?>
<style>
.select2-results .select2-result-label{
    font-size: 11px
}
#form-agregar input,
#form-agregar input[type="date"].form-control, 
#form-agregar input[type="time"].form-control, 
#form-agregar input[type="datetime-local"].form-control, 
#form-agregar input[type="month"].form-control,
#form-agregar select.form-control{
    font-size: 11px
}
</style>
<div id="div-prueba"></div>
<table id="datatable" class="table table-sm table-bordered" style="font-family: 'Arial'">
    <thead class="label-gris-total text-center">
        <tr>
            <th data-priority="1">Ticket</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Cobrador</th>
            <th>Estado</th>
            <th>Total</th>
            <th>Operaciones</th>
        </tr>
    </thead>
</table>
</div>
</div>
</div>
<!-- end row -->

<!-- /.modal AGREGAR -->
<div id="modal-form-agregar" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="myBtn">×</button>
                <h4 class="modal-title col-md-2"></h4><div id="mostrar_ultimo_pago"></div>
            </div>
            <div class="modal-body" style="font-size: 11px">
                <form id="form-agregar" data-parsley-validate novalidate role="form" autocomplete="off">
                    <!--input type="hidden" id="cliente_id" value="" name="cliente_id"-->
                    <div class="row">
                       <div class="col-md-4 col-sm-6 col-xs-12">
                           <div class="form-group">
                                <label for="cliente_id_padre" class="control-label">Cliente</label>
                                <select class="form-control select2" id="cliente_id_padre" name="cliente_id_padre" onChange="mostrar_detalle_cliente_adherente_planes(this), mostrar_ultimo_pago(this)" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="pago_cliente_fecha" class="control-label">Desde</label>
                                <input type="date" class="form-control" id="pago_cliente_fecha" value="<?=date("Y-m-d")?>" name="pago_cliente_fecha" required>
                            </div>
							<div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="pago_cliente_fecha_hasta" class="control-label text-center">Hasta</label>
                                <input type="date" class="form-control" id="pago_cliente_fecha_hasta" value="<?=date("Y-m-d")?>" name="pago_cliente_fecha_hasta" required>								
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                           <div class="form-group">
                                <label for="pago_forma_id" class="control-label">Forma de pago</label>
                                <select class="form-control" id="pago_forma_id" name="pago_forma_id" onChange="mostrar_pago_forma(this)" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 div_pago_monto_efectivo_tarjeta" style="display:none">
                            <div class="form-group div_pago_efectivo">
                                <label for="pago_forma_efectivo_monto" class="control-label div_pago_efectivo"></label>
                                <input type="number" class="form-control div_pago_efectivo text-center" id="pago_forma_efectivo_monto" value="" name="pago_forma_efectivo_monto">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 div_pago_monto_efectivo_tarjeta" style="display:none">
							<div class="form-group div_pago_tarjeta">
                                <label for="pago_forma_tarjeta_monto" class="control-label div_pago_tarjeta">Tarjeta</label>
                                <input type="number" class="form-control div_pago_tarjeta text-center" id="pago_forma_tarjeta_monto" value="" name="pago_forma_tarjeta_monto">
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-1 col-xs-6" style="padding-top: 22px;">
                            <div class="form-group">
                                <button type="submit" id="btn-guardar" onclick="enviar_datos()" class="btn btn-success waves-effect waves-light" disabled=""><i class="fa fa-check-circle"></i></button>
                            </div>
                        </div>                                               
                    </div>
                </form>
				<div class="row" style="margin-bottom: 9px;">					
						<div id="mostrar_ultimo_pago"></div>
				</div>
                    <div class="row">
                       <table id="datatableFacturaDetalle" class="table table-bordered"
                            style="font-size: 12px">
                            <thead class="label-gris-claro text-center">
                                <tr>
                                    <th data-priority="1" class="text-center" style="width:20px">ID</th>
                                    <th class="text-center">Cliente</th>
                                    <th class="text-center">Edad</th>
                                    <th class="text-center">Plan</th>
                                    <th style="width:100px" class="text-center">Monto Plan</th>
                                    <th style="width:120px" class="text-center">Monto adicional</th>
                                </tr>
                            </thead>
                            <tfoot class="label-gris-claro">
                               <tr>
                                    <th colspan="4" class="text-right"></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>                        
                    </div>
                </div>            
        </div>
    </div>
</div>
<!-- /.modal -->

<!-- /.modal VER DETALLE -->
<div id="modal-form-ver-detalle" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>
            </div>
			<style>
				.pleft{padding-left:0}
			</style>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <strong><span id="cliente"></span> </strong><span class="label label-gris-claro" id="tipo">Titular</span>
                        <br>
                        <span id="cliente_direccion"></span>
                        <br>
                        <span id="cliente_estado"></span>
                        <br>
                        <abbr title="Teléfono">T:</abbr> <span id="cliente_cel"></span>
                    </div>                    
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <strong class="col-md-6 text-left pleft">Fecha de pago: </strong><span id="pago_cliente_fecha"></span>
                        <br>
                        <strong class="col-md-6 text-left pleft">Hora de pago: </strong><span id="pago_cliente_hora"></span>
                        <br>
                        <strong class="col-md-6 text-left pleft">Forma de pago: </strong><span id="pago_forma_descripcion"></span>
                        <br>
                        <strong class="col-md-6 text-left pleft">Estado: </strong><span id="pago_cliente_estado"></span>
                        <br>
                        <strong class="col-md-6 text-left pleft">Registrado por: </strong><span id="cobrador"></span>
                    </div>
                    <div class="col-md-5 col-sm-6 col-xs-12">
                        <strong class="col-md-6 text-left pleft">Total monto plan: </strong>Gs. <span id="pago_cliente_monto_plan"></span>
                        <br>
                        <strong class="col-md-6 text-left pleft">Total monto adicional: </strong>Gs. <span id="pago_cliente_detalle_monto_adicional"></span>
                        <br>
                        <strong class="col-md-6 text-left pleft">Total plan + adicional: </strong>Gs. <span id="total_pago"></span>
						<br>
                        <strong class="col-md-6 text-left pleft">Cuotas: </strong><span id="pago_cliente_cuotas"></span> [ <span id="pago_cliente_desde_hasta"></span> ]
						<br>
                        <strong class="col-md-6 text-left pleft">Total con cuotas: </strong>Gs. <span id="pago_cliente_monto_total"></span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <table id="datatableVerDetalle" class="table table-bordered" style="font-size: 12px">
                        <thead class="label-gris-claro text-center">
                            <tr>
                                <th data-priority="1" class="text-center" style="width:50px">ID</th>
                                <th style="width:350px !important" class="text-center">Cliente</th>
                                <th class="text-center">Edad</th>
                                <th class="text-center">Plan</th>
                                <th class="text-center">Monto Plan</th>
                                <th style="width:120px" class="text-center">Monto adicional</th>
                            </tr>
                        </thead>
                        <tbody id="datatableVerDetalleBody">                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-right">Total</th>
                                <th class="text-center"><span id="pago_cliente_monto_plan"></th>
                                <th class="text-center"><span id="pago_cliente_detalle_monto_adicional"></th>
                            </tr>
                        </tfoot>
                    </table>                        
                </div>                
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
<!-- AJAX -->
<script src="<?=base_url('template/assets/js/jquery.min.js')?>"></script>
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script-->
<script type="text/javascript">
    var save_method; //for save method string
    var table;

    /**
    *
    *   Configuración Datatable
    */

    $(document).ready(function(){  
        // Tabla principal
        var table = $('#datatable').DataTable({
            //dom: '<"btn-datatable dt-buttons btn-group">Blfrtip',
            dom: '<"btn-datatable dt-buttons btn-group">Blfrtip',
            //dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'print',
                    text: 'Imprimir',
                    autoPrint: true,
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5 ]
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
            "language": {
                "decimal": ",",
                "thousands": "."
            },
            lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "Todos"]],
            pageLength: 10,
            pagingType: "full",
            fixedHeader: true,
            "stateSave": true,
            responsive: true,
            "processing":true,
            searchHighlight: true,
            "serverSide":true,
            "orderable":false,
            "order":[],  
            "ajax":{
                url:"<?=base_url(strtolower($this->router->class.'/datatable_datos')); ?>",  
                type:"POST"  
            },
            columnDefs: [
                { className : "text-center", targets: [0, 2, 3, 4, 5, 6]},
                { targets:['_all'], "orderable":false, },
                //{ targets : -1, data: null, defaultContent: "<button>Click!</button>"}
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 3, targets: 1 },
                { responsivePriority: 4, targets: -2 },
                { responsivePriority: 2, targets: -1 },

            ],
            "createdRow": function ( row, data, index ) {
                //alert((data[1]).charAt((data[1]).length-1));
                if(data[4] == 'Pagado') {
                    $("td", row).eq(4).html("<span class='label label-success'>"+data[4]+'</span>');
                    //$("td", row).eq(1).html("<b>"+data[1]+'</b>');
                    //$("td", row).addClass('label-gris-claro font-weight-bold');
                }else if(data[4] == 'Anulado') {
                    $("td", row).eq(4).html("<span class='label label-danger'>"+data[4]+'</span>');
                    //$("td", row).eq(-1).html("<span class='label label-danger'>"+data[4]+'</span>');
                    $('.btn-eliminar').hide();
                }else if(data[4] == 'Pendiente') {
                    $("td", row).eq(4).html("<span class='label label-warning'>"+data[4]+'</span>');
                }
                // Botones de operación
                $("td", row).eq(-1).append('<div class="btn-group"><a class="btn btn-default waves-effect waves-light btn-editar" onclick="imprimir_ticket('+data[0]+')" target="_blank"><i class="fa fa-print"></i></a><a class="btn btn-default waves-effect waves-light btn-ver-detalle" onclick="ver_detalle('+data[0]+')"><i class="fa fa-eye"></i></a><a class="btn btn-default waves-effect waves-light btn-eliminar" onclick="eliminar('+data[0]+')"><i class="fa fa-times"></i></a></div>');
            }
        });
        $('#datatable tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('info') ) {
                $(this).removeClass('info');
            }
            else {
                table.$('tr.info').removeClass('info');
                $(this).addClass('info');
            }
        });
        // Botones cabecera
        $("div.btn-datatable").html('<a id="refresh" class="btn btn-default waves-effect waves-light"><i class="fa fa-refresh"></i></a><a id="agregarRegistro" class="btn-agregar">Crear ticket de pago <i class="fa fa-ticket"></i></a>');
        //  Acciones de los botones
        $('#agregarRegistro').click( function () {agregar();} );
        $('#refresh').click( function (){$('#datatable').dataTable().fnClearTable();});
    });    

    /**
    *   
    *   Agregar, editar, actualizar, eliminar
    */
    function agregar() {
        save_method = 'agregar';
        $('#modal-form-agregar').modal('show'); // mostrar bootstrap modal
        $('.modal-title').text('Nuevo pago');
        //$('#form-agregar')[0].empty();        
        //if ($("#cliente_id_padre" ).val()){$("#btn-guardar").prop("disabled", false);}else{$("#btn-guardar").prop("disabled", true);}
        cliente_titular(0);
        mostrar_forma_pago();
        //
        $("#cliente_id_padre").select2("val", ""); // Resetear select2
        $("#btn-guardar").prop("disabled", true); // Se bloquea botón Generar ticket al abrir form
        mostrar_ultimo_pago(0); // Se setea info último pago
        // Inicializar a 0 datataable
        $('#datatableFacturaDetalle').dataTable().empty(); // Se vacía datatable
        $('#datatableFacturaDetalle_wrapper').hide(); // Se oculta datatable wrap
        console.log('abrir modal agregar');
        //$('#form-agregar').reset();
        $(".div_pago_monto_efectivo_tarjeta").css('display', 'none');
        $('#pago_forma_efectivo_monto, #pago_forma_tarjeta_monto').val('');
    }

    function cliente_titular(id){
        //  Inicializar select2
        //$("#cliente_id_padre").select2();
        $.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/cliente_titular/')); ?>" + id,
            type:  'POST',
            beforeSend: function () {
                $("#cliente_id_padre").html("Procesando, espere por favor...");
            },
            success:  function (response) {
                $("#cliente_id_padre").html(response);
                //alert($("#cliente_id_padre").val());
                //$("#cliente_id_padre").select2();
            }
        });
    }
    function mostrar_forma_pago(){
        $.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/mostrar_forma_pago')); ?>",
            type:  'POST',
            beforeSend: function () {
                $("#pago_forma_id").html("Procesando, espere por favor...");
            },
            success:  function (response) {
                $("#pago_forma_id").html(response);
            }
        });
    }

    function ver_detalle(id) {
        $.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/ver_detalle/')); ?>" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('span#cliente').html(data.cliente);
                $('span#cliente_direccion').html(data.cliente_direccion);
                $('span#cliente_estado').html('Usuario ' + data.cliente_estado);
                $('span#cliente_cel').html(data.cliente_cel);                
                $('span#pago_cliente_fecha').html(data.pago_cliente_fecha);
                $('span#pago_cliente_hora').html(data.pago_cliente_hora);
                $('span#pago_forma_descripcion').html(data.pago_forma_alias);
                $('span#pago_cliente_estado').html(data.pago_cliente_estado);
                $('span#pago_cliente_monto_plan').html(data.pago_cliente_monto_plan);
                $('span#pago_cliente_detalle_monto_adicional').html(data.pago_cliente_detalle_monto_adicional);
                $('span#total_pago').html(data.total_pago);
                $('span#pago_cliente_cuotas').html(data.pago_cliente_cuotas);
                $('span#pago_cliente_monto_total').html(data.pago_cliente_monto_total);
                $('span#pago_cliente_desde_hasta').html(data.pago_cliente_desde_hasta);
                $('span#cobrador').html(data.cobrador);
                
                $('#modal-form-ver-detalle').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Detalles del Ticket n° ' + id); // Set title to Bootstrap modal title
                
                //planes(data.cliente_fecha_nacimiento, data.cliente_id);
                //planes_clientes_fecha_ingreso(id, 0)

                datatableVerDetalle(id);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
        //cliente_titular(id);
    }
    
    function datatableVerDetalle(pago_cliente_id){
        $.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/datatableVerDetalle/')); ?>" + pago_cliente_id,
            //data: {},
            type:  'POST',
            dataType: "JSON",
            beforeSend: function () {
                $("#datatableVerDetalleBody").append("<tr><td class='text-center' colspan='6'>Procesando, espere por favor...</td></tr>");
            },
            success:  function (response) {
                $("#datatableVerDetalleBody").empty(); // vacio la tabla y vuelvo a recargarla
                for (  i = 0 ; i < response.data.length; i++){ //cuenta la cantidad de registros
                    var nuevafila= "<tr><td class='text-center'>" +
                    response.data[i].cliente_id + "</td><td>" +
                    response.data[i].cliente + "</td><td class='text-center'>" +
                    response.data[i].edad + "</td><td>" +
                    response.data[i].plan + "</td><td class='text-center'>" +
                    response.data[i].pago_cliente_detalle_monto_plan + "</td><td class='text-center'>" +
                    response.data[i].pago_cliente_detalle_monto_adicional + "</td class='text-center'></tr>"

                    $("#datatableVerDetalleBody").append(nuevafila).fadeIn();
                }
            }
        });
    }
    
    function guardar() {
        var table = $('#datatableFacturaDetalle').DataTable();
        //  Serializar 2 objetos
        var data = $('#datatableFacturaDetalle input, #form-agregar').serialize();
        //alert("Los siguientes datos se enviarán al servidor: \n\n"+ data);
        //return false;
        // Se vacía la tabla
        //$('#datatableFacturaDetalle').dataTable().empty();
        mostrar_ultimo_pago(0);

        var url;
        url = "<?=base_url(strtolower($this->router->class.'/agregar')); ?>";
        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            //dataType: "JSON",
            success: function(data) {
                //if success close modal and reload ajax table
                $('#modal-form-agregar').modal('hide');
                $('#datatable').dataTable().fnDraw('page'); // Recargar en la misma página
                notificacion("success", "Ticket guardado!", "toast-top-right");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                notificacion("error", "Error agregando / actualizando datos!", "toast-top-right");
            }
        });
    }
    $("#myBtn").click(function(){
        //var table = $('#datatableFacturaDetalle').DataTable();
        // Se vacía la tabla
        //$('#datatableFacturaDetalle').dataTable().empty();
    });

    function enviar_datos() {
        $("#form-agregar").submit(function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            console.log("ingreso al evento");
            $("#btn-guardar").prop("disabled", true); // Se bloquea botón Generar ticket al enviar form
            guardar();
          });
    }

    function eliminar(id) {
        swal({
            title: "¿Anular éste ticket?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            confirmButtonText: "Si, estoy seguro!",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
        }, function () {
            // ajax delete data from database
            $.ajax({
                url: "<?=base_url(strtolower($this->router->class.'/anular_ticket/')); ?>" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    $('#datatable').dataTable().fnDraw('page'); // Recargar en la misma página
                    swal.close();
                    notificacion("success", "Ticket n° " + id + " anulado.", "toast-bottom-right");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error eliminando datos');
                }
            });
        });
    }

    // Cambiar el select de Tipo de cliente
    function mostrar_detalle_cliente_adherente_planes(sel){
        //alert(sel.value);
        $('#datatableFacturaDetalle').DataTable().destroy();
        enviar_cliente_id(sel.value);
        $("#btn-guardar").prop("disabled", false);
    }
	function mostrar_ultimo_pago(sel){
        //alert(sel.value);
		console.log(sel.value);
		$.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/mostrar_ultimo_pago/')); ?>" + sel.value,
            type:  'POST',
            beforeSend: function () {
                $("#mostrar_ultimo_pago").html("Procesando datos del último pago, espere por favor...");
            },
            success:  function (response) {
                $("#mostrar_ultimo_pago").html(response);
            }
        });
    }
    
    function mostrar_pago_forma(sel){
        // Se setea los campos por cada cambio
        $('#pago_forma_efectivo_monto, #pago_forma_tarjeta_monto').val('');
        console.log(sel.value);
        if (sel.value == 4){
            $(".div_pago_monto_efectivo_tarjeta").css('display', 'block');
            $("label.div_pago_efectivo").text('Efectivo');
            $("label.div_pago_tarjeta").text('Tarjeta Débito');
        }else if (sel.value == 5){
            $(".div_pago_monto_efectivo_tarjeta").css('display', 'block');
            $("label.div_pago_efectivo").text('Efectivo');
            $("label.div_pago_tarjeta").text('Tarjeta Crédito');
        }else if (sel.value == 6){
            $(".div_pago_monto_efectivo_tarjeta").css('display', 'block');
            $("label.div_pago_efectivo").text('Tarjeta Débito');
            $("label.div_pago_tarjeta").text('Tarjeta Crédito');
        }else if ((sel.value == 1) || (sel.value == 2) || (sel.value == 7)){
            $(".div_pago_monto_efectivo_tarjeta").css('display', 'none');
        }
    }
    // Datatable DETALLES - dataTables_info
    function enviar_cliente_id(cliente_id){
        $(document).ready(function(){  
            var table = $('#datatableFacturaDetalle').DataTable({
            dom: "<'row'<'col-sm-12't>><'clear'>" +
            "<'row'<'col-sm-4 col-xs-6'i><'col-sm-4 col-xs-6'p><'col-sm-4 col-xs-12'f>>",
            language: {
                "decimal": ",",
                "thousands": ".",
                "info": "Página: _PAGE_ / Adherentes: _MAX_",
            },
            paging: true,
            pagingType: "simple",                
            lengthChange: false,
            info: true,
            pageLength: 20,
            //autoWidth: true,
            responsive: true,
            processing:true,            
            searchHighlight: true,
            serverSide:true,
            ajax:{
                url:"<?=base_url(strtolower($this->router->class.'/datatableFacturaDetalle')); ?>/" + cliente_id,  
                type:"POST"
            },
            columnDefs: [
                { className : "text-center", targets: [0, 2, 3, 4, 5]},
                { targets:['_all'], "orderable":false, },
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 3, targets: 1 },
                { responsivePriority: 4, targets: -2 },
                { responsivePriority: 2, targets: -1 }
            ],
            columns: [
                { width: "10px" },
                { width: "230px" },
                { width: "60px" },
                { width: "60px" },
                { width: "80px" },
                { width: "80px" },
            ],
            select: {
                style:    'info',
                selector: 'td:first-child',
                blurable: true
            },
            "footerCallback": function(row, data, start, end, display) {
                    var api = this.api(),
                        data;
                    // converting to interger to find total
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    // computing column Total of the complete result 
                    var monTotal = api
                        .column(4)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    // Update footer by showing the total with the reference of the column index 
                    $(api.column(3).footer()).html('Subtotal');
                    $(api.column(4).footer()).html(monTotal);
                }
            });
       });
       $('#datatableFacturaDetalle_wrapper div.dataTables_paginate').css('margin-top', '-30px');
       $('#datatableFacturaDetalle_wrapper div.dataTables_paginate').css('text-align', 'center');
       $('#datatableFacturaDetalle_wrapper .dataTables_info').removeClass('dataTables_info col-sm-3');
       $('#datatableFacturaDetalle').removeClass('dataTable');
       
    }

    function imprimir_ticket(ticket_id){
        swal({
            title: "¿Imprimir ticket?",
            type: "info",
            showCancelButton: true,
            confirmButtonClass: 'btn-success',
            confirmButtonText: "Si, estoy seguro!",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
        }, function () {
            // ajax delete data from database
            $.ajax({
                url:"<?=base_url(strtolower($this->router->class.'/ticket')); ?>/" + ticket_id,
                success: function(data) {
                    notificacion("success", "Imprimiendo ticket...", "toast-top-right");
                    swal.close();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    notificacion("error", "Algo anda mal!", "toast-bottom-right");
                }
            });
        });
        
    }        
</script>