<?php //$controller = strtolower($this->router->class);?>
<!--https://www.webjrcode.com/funciones-jquery-validar-enviar-ajax/-->
<!-- https://es.stackoverflow.com/questions/22770/como-hago-para-validar-la-informaci%C3%B3n-ingresada-en-mi-formulario-a-trav%C3%A9s-de-mi -->
<table id="datatable" class="table table-sm table-bordered">
    <thead class="label-gris-total text-center">
        <tr>
            <th data-priority="1">ID</th>
            <th data-priority="2">Nombre</th>
            <th>Tipo</th>
            <th>C.I.</th>
            <th>Contacto</th>
            <th>Dirección</th>
            <th>Registrado</th>
        </tr>
    </thead>
</table>
</div>
</div>
</div>
<!-- end row -->

<!-- /.modal AGREGAR -->
<div id="modal-form-agregar" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form id="form-agregar" name="form-agregar" data-parsley-validate novalidate role="form" autocomplete="off">
                    <input type="hidden" id="cliente_id" value="" name="cliente_id">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="cliente_nombre" class="control-label">Nombre</label>
                                <input type="text" class="form-control" id="cliente_nombre" name="cliente_nombre" placeholder="Nombre" 
                                parsley-trigger="change" data-parsley-length="[3,35]" required="">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="cliente_apellido" class="control-label">Apellido</label>
                                <input type="text" class="form-control" id="cliente_apellido" name="cliente_apellido" placeholder="Apellido" 
                                parsley-trigger="change" data-parsley-length="[3,35]" required="">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="cliente_fecha_nacimiento" class="control-label">Fecha de nacimiento</label>
                                <input type="date" class="form-control" id="cliente_fecha_nacimiento" name="cliente_fecha_nacimiento">
                            </div>
                        </div>                      
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="form-group">
                                <label for="cliente_sexo" class="control-label">Sexo</label>
                                <select class="form-control" id="cliente_sexo" name="cliente_sexo" required>
                                    <optgroup label="Selecciona">
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </optgroup>
                                </select>   
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="form-group">
                                <label for="cliente_ci" class="control-label">N° de C.I.</label>
                                <input type="text" min="0" class="form-control" id="cliente_ci" name="cliente_ci"
                                placeholder="Solo números" data-parsley-type="number">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="form-group">
                                <label for="cliente_ruc" class="control-label">RUC</label>
                                <input type="text" min="0" class="form-control" id="cliente_ruc" name="cliente_ruc"
                                placeholder="Solo números" data-parsley-type="number">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="form-group">
                                <label for="cliente_ruc_dv" class="control-label">Dígito verificador</label>
                                <input type="text" min="0" class="form-control" id="cliente_ruc_dv" name="cliente_ruc_dv"
                                placeholder="Solo números" data-parsley-type="number">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4">
                           <div class="form-group">
                            <label for="usuario_estado" class="control-label">Tipo de cliente</label>
                                <select class="form-control" id="cliente_tipo_id" name="cliente_tipo_id">
                                    <?php foreach ($tbl_cliente_tipo as $row) {?>
                                    <option value="<?= $row->cliente_tipo_id ?>"><?= $row->cliente_tipo_nombre ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class=" col-md-9 col-sm-8">
                           <div class="form-group">
                                <label for="cliente_id_padre" class="control-label">Selecciona titular</label>
                                <select class="form-control" id="cliente_id_padre" name="cliente_id_padre" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="col-md-3 col-sm-3">
                            <div class="form-group">
                                <label for="cliente_cel" class="control-label">Celular</label>
                                <input type="text" class="form-control" id="cliente_cel" name="cliente_cel"
                                placeholder="Solo números" data-parsley-type="number" required>
                            </div>
                        </div>                      
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="cliente_direccion" class="control-label">Dirección</label>
                                <input type="text" class="form-control" id="cliente_direccion" name="cliente_direccion" placeholder=""
                                parsley-trigger="change" data-parsley-length="[5,25]" required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-sm-8">
                            <div class="form-group">
                                <label for="plan_id" class="control-label">Planes de cobertura</label>
                                <select id="plan_id" class="form-control" name="plan_id">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="planes_clientes_fecha_ingreso" class="control-label">Fecha Plan</label>
                                <input type="date" class="form-control" id="planes_clientes_fecha_ingreso" value="<?=date("Y-m-d")?>" name="planes_clientes_fecha_ingreso" required>
                            </div>
                        </div>
                    </div>
					<div class="row">
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<div class="form-group m-l-10">
									<div class="checkbox checkbox-primary">
										<input id="planes_clientes_modificar_monto" type="checkbox" name="planes_clientes_modificar_monto" 
										value="" onclick="valida(this.checked)">
										<label for="planes_clientes_modificar_monto">Modificar monto</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="planes_clientes_monto" name="planes_clientes_monto" placeholder="Monto" parsley-trigger="change" data-parsley-length="[0,8]">
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

<!-- AJAX -->
<script src="<?=base_url('template/assets/js/jquery.min.js')?>"></script>       
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
                    title: 'Clientes',
                    //messageTop: 'PDF created by PDFMake with Buttons for DataTables.',
                    autoPrint: true,
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6 ]
                    },
                    customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '9pt' )
                            .prepend(
                            '<img src="<?=base_url('template/assets/images/logo-1.png'); ?>" style="position:absolute; top:0; left:0;opacity: 0.01" />'
                        );
                        $(win.document.body).find('table')
                            .addClass('table table-sm table-bordered')
                            .css('font-size', 'inherit');
                    }
                }
            ],
            "language": {
                "decimal": ",",
                "thousands": "."
            },
            lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "Todos"]],
            pageLength: 25,
            pagingType: "full",
            fixedHeader: true,
            stateSave: true,
            responsive: true,
            processing: true,
            searchHighlight: true,
            serverSide: true,
            orderable: false,
            order:[],
            ajax:{
                url:"<?=base_url(strtolower($this->router->class.'/datatable_datos')); ?>",  
                type:"POST"  
            },
            columnDefs: [
                { className : "text-center", targets: [0, 2, 3, 4, 5, 6]},
                { targets:['_all'], "orderable":false, }
                /*{ responsivePriority: 1, targets: 0 },
                { responsivePriority: 3, targets: -4 },
                { responsivePriority: 2, targets: -1 },*/

            ],
            "createdRow": function ( row, data, index ) {
                //alert((data[1]).charAt((data[1]).length-1));
                if(data[2] == 'Titular') {
                    $("td", row).eq(2).html("<span class='label label-primary'>"+data[2]+'</span>');
                    $("td", row).eq(1).html("<b>"+data[1]+'</b>');
                    $("td", row).addClass('label-gris-claro font-weight-bold');
                }else if ( data[2] == 'Adherente'){
                    $("td", row).eq(2).html("<span class='label label-gris-claro'>"+data[2]+'</span>');
                }
            }
        });
        datatable_config_botonesABMR();        
    });
    
    // Accciones de campos de formulario
	$('#cliente_tipo_id').change(function(){ 
		var value = $(this).val();
        if (value == 1){
			$('#cliente_cel').attr('required', true);
            $('#cliente_direccion').attr('required', true); 
		}else{
			$('#cliente_cel').attr('required', false);
            $('#cliente_direccion').attr('required', false);
		}
	});
    // CI = RUC primera vez
    $('#cliente_ci').blur(function(){ 
		let value = $(this).val();
        if (value === "" ) return;
        let ruc = $('[name="cliente_ruc"]').val();
        if (ruc === "" ) $('[name="cliente_ruc"]').val(value);
	});
    /**
    *   
    *   Agregar, editar, actualizar, eliminar
    */
    function agregar() {
        save_method = 'agregar';
        $('#form-agregar')[0].reset(); // resetear datos del campo del formulario
        $('#modal-form-agregar').modal('show'); // mostrar bootstrap modal
        $('.modal-title').text('Nuevo cliente'); // Setear Title to Bootstrap modal title        
        $('#cliente_titular_div label').css('color', '#EEE');
        $('#cliente_id_padre').prop("required", false).prop('disabled', true);
		$("#planes_clientes_modificar_monto").prop('value', 'no');
		$("#planes_clientes_monto").prop('disabled', true);		
        $("form").parsley().reset();
        cliente_titular(0);
		mostrar_planes();
    }

    function editar(id) {
        save_method = 'update';
        $('#form-agregar')[0].reset(); // reset form on modals
        $("form").parsley().reset();
        
        $.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/editar/')); ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="cliente_id"]').val(data.cliente_id);                
                $('[name="cliente_nombre"]').val(data.cliente_nombre);
                $('[name="cliente_apellido"]').val(data.cliente_apellido);
                $('[name="cliente_fecha_nacimiento"]').val(data.cliente_fecha_nacimiento);
                $('[name="cliente_ci"]').val(data.cliente_ci);
                $('[name="cliente_tipo_id"]').val(data.cliente_tipo_id);
                $('[name="cliente_sexo"]').val(data.cliente_sexo);
                $('[name="cliente_cel"]').val(data.cliente_cel);
                $('[name="cliente_direccion"]').val(data.cliente_direccion);
                $('[name="cliente_ruc"]').val(data.cliente_ruc);
                $('[name="cliente_ruc_dv"]').val(data.cliente_ruc_dv);
                
                $('#modal-form-agregar').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Editar cliente'); // Set title to Bootstrap modal title
                if(data.cliente_tipo_id == 1){
                    $('#cliente_titular_div label').css('color', '#EEE');
                    $('#cliente_id_padre').prop("required", false).prop('disabled', true);
                    $('#cliente_cel').attr('required', true);
                    $('#cliente_direccion').attr('required', true);
                }else{
                    $('#cliente_titular_div label').css('color', '#797979');
                    $('#cliente_id_padre').prop("required", true).prop('disabled', false);
                    $('#cliente_cel').attr('required', false);
                    $('#cliente_direccion').attr('required', false);
                }                
                //planes(data.cliente_fecha_nacimiento, data.cliente_id);
                planes_clientes_fecha_ingreso(id, 0, null, null, null);
				mostrar_planes();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
        cliente_titular(id);        
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
            data: $('#form-agregar').serialize(),
            dataType: "JSON",
            success: function(data) {
                //if success close modal and reload ajax table
                $('#modal-form-agregar').modal('hide');
                if (save_method == 'agregar') {
                    $('#datatable').dataTable().fnClearTable();
                }else{
                    $('#datatable').dataTable().fnDraw('page'); // Recargar en la misma página
                }
                notificacion("success", "Correcto!", "toast-top-right");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                notificacion("error", "Error agregando / actualizando datos!", "toast-top-right");
            }
        });
    }

    function enviar_datos() {
        //valor = new Date($('#cliente_fecha_nacimiento').val());
        //if (isNaN(valor)){$("form #plan_id").empty();}

        $("#form-agregar").submit(function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            console.log("enviado correctamente");            
            guardar();
          });
    }

    function eliminar(id) {
        swal({
            title: "¿Estás seguro de eliminar al cliente?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            confirmButtonText: "Si, estoy seguro!",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
        }, function () {
            // ajax delete data from database
            $.ajax({
                url: "<?=base_url(strtolower($this->router->class.'/eliminar/')); ?>" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    $('#datatable').dataTable().fnDraw('page'); // Recargar en la misma página
                    swal.close();
                    notificacion("success", "Registro eliminado", "toast-bottom-right");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error eliminando datos');
                }
            });
        });
    }
    
    // Cambiar el select de Tipo de cliente
    $('#cliente_tipo_id').change(function(){
        if ($('#cliente_tipo_id').val() == 1){
            $('#cliente_id_padre').prop("required", false).prop('disabled', true);
            $('#cliente_titular_div label').css('color', '#EEE');
        }else{
            $('#cliente_id_padre').prop("required", true).prop('disabled', false);
            $('#cliente_titular_div label').css('color', '#797979');
            // si el formulario es de editar capturar id del cliente editado para mostrar su titular en selected
            if (save_method == 'update') {
                cliente_titular($('input[type=hidden]').val());
            }
        }
    });
    
    function cliente_titular(id){
        $("#cliente_id_padre").select2();
        $.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/cliente_titular/')); ?>" + id,
            type:  'GET',
            beforeSend: function () {
                $("#cliente_id_padre").html("Procesando, espere por favor...");
            },
            success:  function (response) {
                $("#cliente_id_padre").html(response);
                $("#cliente_id_padre").select2();
            }
        });
    }
    
    function calcularEdad(fecha) 
    {
        var edad = 0;                             
       //capturamos la fecha de hoy 
       hoy=new Date();                               
      //alert(hoy);                               
       diaActual = hoy.getDate();        // al mes le sumamos 1 ya que los meses javascript los muestra como un array de 0 a 11
       mesActual = hoy.getMonth() + 1;
       yearActual = hoy.getFullYear();        //le concateno un 0 al dia y al mes cuando son menor que diez
       if(diaActual < 10) { diaActual = '0' + diaActual; }
       if(mesActual < 10) { mesActual = '0' + mesActual; }
       //alert('dia '+diaActual +'del mes ' + mesActual + 'del año '+ yearActual)
       //capturo la fecha que recibo
       //La descompongo en un array
       var array_fecha = fecha.split("-");                               
       dia = array_fecha[2];
       mes = array_fecha[1];
       year = array_fecha[0];
       //Valido que la fecha de nacimiento no sea mayor a la fecha actual 
       if(year >= yearActual){
              document.getElementById('txt_fechaNacimiento').setCustomValidity('La fecha de Nacimiento no puede ser mayor o igual a la fecha Actual...');
              document.getElementById('submit').click();
        //return;
       }else if ( (mes >= mesActual) && (dia > diaActual) ){
              edad = (yearActual  - 1 ) - year;
       }else{
              edad = yearActual - year;
       }
       //document.getElementById('txt_edad').value =  edad;                               
       return edad;
    }

    // Cuando pierde el foco
    /*$('#cliente_fecha_nacimiento').blur(function(){
        var cliente_fn = $('#cliente_fecha_nacimiento').val();
		var cliente_id = $('#cliente_id').val();
        valor = new Date(cliente_fn);
        if (isNaN(valor)){
            notificacion("warning", "La fecha de nacimiento no es válida", "toast-top-right");            
            //planes(0, 0);
			planes('-1', 0);
            //$("form #plan_id").empty();
			$('#cliente_fecha_nacimiento').focus();
            console.log('No válido');			
            return false;            
        }else{            
            if (!cliente_id){ var cliente_id = 0;}
            notificacion("warning", calcularEdad(cliente_fn) + " años", "toast-top-right");
            planes(cliente_fn, cliente_id);
            $("form #plan_id").parsley().reset();
            console.log('Válido');
        }
    });*/
	
	
	//$('#plan_id').click(function(){
	/*$('select#plan_id').click(function(){
		var cliente_fn = $('#cliente_fecha_nacimiento').val();
		var cliente_id = $('#cliente_id').val();
		
		if (cliente_fn === ''){
			console.log('No cumpleaños');
			planes('-1', 0);
			}else{
				console.log(cliente_fn);
				if (!cliente_id){ var cliente_id = 0;}
				planes(cliente_fn, cliente_id);
				}
	});
	*/
	function mostrar_planes(){
		var cliente_fn = $('#cliente_fecha_nacimiento').val();
		var cliente_id = $('#cliente_id').val();
		
		if (cliente_fn === ''){
			//console.log('No cumpleaños');
			planes('-1', cliente_id);
			}else{
				//console.log(cliente_fn);
				if (!cliente_id){ var cliente_id = 0;}
				planes(cliente_fn, cliente_id);
				}
	}
	$('#cliente_fecha_nacimiento').blur(function(){
		mostrar_planes();
		var cliente_fn = $('#cliente_fecha_nacimiento').val();
		valor = new Date(cliente_fn);
        if (isNaN(valor)){
            notificacion("warning", "Fecha de nacimiento no definida", "toast-top-right");            
            return false;            
        }else{            
            notificacion("warning", calcularEdad(cliente_fn) + " años", "toast-top-right");
            console.log('Válido');
        }
	});
    
    function planes(fecha_nacimiento, cliente_id){
        //$("#cliente_id_padre").select2();
        $.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/planes/')); ?>" + fecha_nacimiento + "/" + cliente_id,
            type:  'GET',
            beforeSend: function () {
                $("#plan_id").html("Procesando, espere por favor...");
            },
            success:  function (response) {
                $("#plan_id").html(response);
                //$("#plan_id").select2();
            }
        });
    }
    
	function planes_clientes_fecha_ingreso(cliente_id, plan_id){
        //$("#cliente_id_padre").select2();
        $.ajax({
            url: "<?=base_url(strtolower($this->router->class.'/planes_clientes_fecha_ingreso/')); ?>" + cliente_id + "/" + plan_id,
            type:  'GET',
            dataType: "JSON",
            beforeSend: function () {
                $("#planes_clientes_fecha_ingreso").html("Procesando, espere por favor...");
            },
            success:  function (response) {
                $('[name="planes_clientes_fecha_ingreso"]').val(response.planes_clientes_fecha_ingreso);
                $('[name="planes_clientes_monto"]').val(response.planes_clientes_monto);
				
				var v = response.planes_clientes_modificar_monto;
				if (v == 'si'){
					$("#planes_clientes_modificar_monto").prop('checked', true);
					$("#planes_clientes_monto").prop('disabled', false);
					$("#planes_clientes_modificar_monto").prop('value', 'si');
				}else{
					$("#planes_clientes_modificar_monto").prop('checked', false);
					$("#planes_clientes_monto").prop('disabled', true);
					$("#planes_clientes_modificar_monto").prop('value', 'no');
				}
                
            }
        });
    }
	// Al cambiar el input de Modificar monto
	//  onclick="valida(this.checked)"
	function valida(value)
	{
		document.forms['form-agregar'].planes_clientes_monto.disabled=!value;
		//alert(value);
		console.log(value);
		
		if ($('input#planes_clientes_modificar_monto').is(':checked')) {
			console.log('si');
			$("#planes_clientes_modificar_monto").prop('value', 'si');
			$("#planes_clientes_monto").prop('disabled', false);			
		}else{
			console.log('no');
			$("#planes_clientes_modificar_monto").prop('value', 'no');
			$("#planes_clientes_monto").prop('disabled', true);
		}
	}
	// Comprobar cuando cambia un checkbox
	/*
	$('input#planes_clientes_modificar_monto[type=checkbox]').on('change', function() {
		if ($(this).is(':checked') ) {
			console.log("Checkbox " + $(this).prop("id") +  " (" + $(this).val() + ") => Seleccionado");
			$("#planes_clientes_modificar_monto").prop('value', 'no');
			$("#planes_clientes_monto").prop('disabled', false);
		} else {
			console.log("Checkbox " + $(this).prop("id") +  " (" + $(this).val() + ") => Deseleccionado");
			$("#planes_clientes_modificar_monto").prop('value', 'si');
			$("#planes_clientes_monto").prop('disabled', true);
		}
	});
	*/
    /***
    *
    *   insertar_prueba
    */
    /*function insertar_prueba() {
        $.ajax({
            url: "<?php echo site_url('welcome/insertar_prueba')?>",
            type:  'GET',
            beforeSend: function () {
                $("#div-prueba").html("Listando acciones del perfil seleccionado, espere por favor...");
            },
            success:  function (response) {
                $("#div-prueba").html(response);
                //alert(response);
            }
        });
    }*/
</script>

