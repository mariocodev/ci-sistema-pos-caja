<div class="text-center logo-alt-box" style="margin-top: 3%">
    <!--a href="#" class="logo"><span>Template<span>seto</span></span></a-->
    <span><img src="<?=base_url('template/')?>assets/images/logo-1.png" alt="logo" style="height: 150px;"></span>
</div>
<div class="wrapper-page" style="margin-top: -27px;z-index: 1;">
	<div class="m-t-30 card-box">
        <div class="text-center">
            <h4 class="text-uppercase font-bold m-b-0">Iniciar sesión</h4>
        </div>
        <div class="panel-body">
            <form class="form-horizontal m-t-10" method="post" action="<?=base_url('login/iniciar_sesion_post')?>" autocomplete="off">
				<div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" type="text" required="" name="usuario_user" placeholder="Nombre de usuario">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" required="" name="usuario_pass" placeholder="Password">
                    </div>
                </div>
                <div class="form-group text-center m-t-30">
                    <div class="col-xs-12">
                        <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light text-uppercase" type="submit">Loguearse</button>
                    </div>
                </div>
            </form>
            <?php if ($error): ?>
            <p>
                <?php echo $error ?> </p>
            <?php endif; ?>
        </div>
    </div>
    <!-- end card-box -->
</div>