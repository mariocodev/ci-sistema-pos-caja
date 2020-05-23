<div class="row">
	<div class="col-md-5">
		<div class="form-group">
			<div class="input-group m-t-10 ">
				<input id="" name="" class="form-control" placeholder="Directorio backups" type="text">
				<span class="input-group-btn">
					<button onclick="definir_directorio()" type="button" class="btn waves-effect waves-light btn-info">Definir directorio</button>
				</span>
			</div>
		</div>	
	</div>
	<div class="col-md-7">
		<div class="form-group">
			<div class="input-group m-t-10 ">
				<button onclick="ejecutar_backup()" type="button" class="btn waves-effect waves-light btn-info"> <i class="fa fa-refresh m-r-5"></i> <span>Generar backup</span> </button>
			</div>
		</div>
	</div>
	<div class="col-md-12"><code><b>Info: </b></br>El script se dispara cada vez que se ingresa a algún módulo.<br>Guarda por hora.<br>El script solo deja los últimos bkps creados hace 5 horas en el repositorio.<br></code></div>
</div>

<div class="row">
	<div class="col-md-12">
		<div id="response"></div>
	</div>	
</div>
</div>
</div>
<!-- end col -->
</div>
<!-- end row -->
<script type="text/javascript">
	/***
    *
    *   Ejecutar backup automáticamente cada x segundos
    *
    $(document).ready(function(){
    	setInterval( function () {ejecutar_backup();}, 900000 ); // 1000 milisegundos = 1 seg; 900000ms = 15min
    	ejecutar_backup();
    });
    function ejecutar_backup() {
        $.ajax({
            url:"<?=base_url(strtolower($this->router->class.'/databasebackup')); ?>",
            type:  'POST',
            beforeSend: function () {
                $("#response").html("Ejecutando el controlador, espere por favor...");
            },
            success:  function (response) {
                $("#response").html(response);                
                //console.log(response);
            }
        });
    }*/
    /***
    *
    *   Ejecutar backup automáticamente por cada vez que se ingresa a un módulo, cambiar mas adelante
    */
    function ejecutar_backup() {
        $.ajax({
            url:"<?=base_url(strtolower($this->router->class.'/databasebackup')); ?>",
            type:  'POST',
            beforeSend: function () {
                $("#response").html("Ejecutando el controlador, espere por favor...");
            },
            success:  function (response) {
                $("#response").html(response);                
                //console.log(response);
            }
        });
    }

    function definir_directorio(){
    	alert('hola');
    }
</script>