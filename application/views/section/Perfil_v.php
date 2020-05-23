<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h4 class="header-title m-t-0 m-b-30">
                <?=ucfirst($this->router->class).' / '.$usuario_nombre.' '.$usuario_apellido?> 
            </h4>
            <hr>
<div class="row">
<div class="col-lg-4">
    <div class="panel panel-color panel-inverse">
        <div class="panel-heading">
            <h3 class="panel-title">Foto de perfil</h3>
        </div>
        <div class="panel-body">
            <div class="col-sm-12">
                <!--left col-->
                <div class="text-center">
                    <img src="<?=$usuario_foto?>" class="avatar img-circle img-thumbnail" alt="avatar" style="height:150px !important">
                    <h6>Sube una foto diferente...</h6>
                    <form action="<?=base_url(strtolower($this->router->class).'/subir_foto')?>" method="post" enctype="multipart/form-data" role="form" id="form2">
                        <div class="form-group">
                            <input type="file" name="userfile" value="fichero" id="userfile"/>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info waves-effect waves-light" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Subir foto</button>
                        </div>
                    </form>
                </div>
                </hr>
            </div>
        
        </div>
    </div>
</div>
<!--/col-3-->
<div class="col-lg-4">
    <div class="panel panel-color panel-inverse">
        <div class="panel-heading">
            <h3 class="panel-title">Datos básicos</h3>
        </div>
        <div class="panel-body">
            <form id="form1" data-parsley-validate novalidate role="form" autocomplete="off" method="post" action="<?=base_url(strtolower($this->router->class).'/guardar')?>">
            <input type="hidden" value="" name="usuario_id">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="usuario_nombre" class="control-label">Nombre</label>
                        <input type="text" class="form-control" id="usuario_nombre" name="usuario_nombre" placeholder="Nombre" parsley-trigger="change" required="" value="<?=$usuario_nombre?>">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="usuario_apellido" class="control-label">Apellido</label>
                        <input type="text" class="form-control" id="usuario_apellido" name="usuario_apellido"placeholder="Apellido" required="" value="<?=$usuario_apellido?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="usuario_user" class="control-label">Nombre usuario</label>
                        <input type="text" class="form-control" id="usuario_user" name="usuario_user"
                               placeholder="Nombre de usuario" required="" data-parsley-length="[3, 40]" value="<?=$usuario_user?>">
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-md-6 col-sm-6 col-xs-6">
                    <button class="btn btn-info waves-effect waves-light" type="submit">
                    <i class="glyphicon glyphicon-ok-sign"></i> Guardar
                    </button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <button class="btn btn-default waves-effect waves-light" type="reset">
                        <i class="glyphicon glyphicon-repeat"></i> Recargar
                    </button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

                   
<div class="col-lg-4">
    <div class="panel panel-color panel-inverse">
        <div class="panel-heading">
            <h3 class="panel-title">Contraseña</h3>
        </div>
        <div class="panel-body">
            <form id="form1" data-parsley-validate novalidate role="form" autocomplete="off" method="post" action="<?=base_url(strtolower($this->router->class).'/cambiar_pass')?>">
            <input type="hidden" value="" name="usuario_id">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="usuario_pass_actual" class="control-label">Contraseña actual</label>
                        <input type="password" class="form-control" id="usuario_pass_actual" name="usuario_pass_actual" placeholder="Contraseña actual" required="">                    
                    <?php if ($error): ?><div class="has-error"><p class="control-label"><?php echo $error ?> </p></div><?php endif; ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="usuario_pass" class="control-label">Contraseña nueva</label>
                        <input type="password" class="form-control" id="usuario_pass" name="usuario_pass" placeholder="Contraseña nueva" required="" data-parsley-length="[6, 15]">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="usuario_pass2" class="control-label">Repetir contraseña nueva</label>
                        <input type="password" class="form-control" id="usuario_pass2" name="usuario_pass" placeholder="Repetir contraseña nueva" required="" data-parsley-length="[6, 15]" data-parsley-equalto="#usuario_pass" data-parsley-equalto-message="Las contraseñas no coinciden" >
                    </div>
                </div>
            </div>
            <?php if ($success): ?><div class="has-success"><p class="control-label"><?php echo $success ?> </p></div><?php endif; ?>
            <hr>
            <div class="row">
               <div class="col-md-6 col-sm-6 col-xs-6">
                <button class="btn btn-info waves-effect waves-light" type="submit">
                    <i class="glyphicon glyphicon-ok-sign"></i> Guardar
                </button>
                </div>
               <div class="col-md-6 col-sm-6 col-xs-6">
                <button class="btn btn-default waves-effect waves-light" type="reset">
                    <i class="glyphicon glyphicon-repeat"></i> Limpiar
                </button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
<!--/tab-content-->
</div>
<!--/col-9-->
</div>
<!--/row-->