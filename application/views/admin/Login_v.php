<div class="text-center logo-alt-box" style="margin-top: 3%">
    <!--a href="#" class="logo"><span>Template<span>seto</span></span></a-->
    <span><img src="<?=base_url('template/')?>assets/images/logo-1.png" alt="logo" style="height: 150px;"></span>
</div>
<div class="wrapper-page" style="margin-top: -27px;z-index: 1;">
	<div class="m-t-30 card-box" style="background-color: transparent;">        
        <div class="panel-body">
            <!--form class="form-horizontal m-t-10" method="post" action="<?=base_url('login/iniciar_sesion_post')?>" autocomplete="off"-->
            <form data-parsley-validate novalidate class="form-horizontal m-t-10" method="post" autocomplete="off" id="formLogin">
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
                        <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light text-uppercase" type="submit" id="login" onclick="enviar_datos()">Loguearse</button>
                    </div>
                </div>
                <style>.d-none{display: none;}</style>
                <div class="col-md-12 text-right" id="forgotPass">
                    <a href="javascript:void(0)" class="text-white">
                        <small><i class="mdi mdi-lock mr-1"></i> ¿Recuperar contraseña?</small>
                    </a>
                </div>
            </form>            
        </div>
    </div>
    <!-- end card-box -->
</div>