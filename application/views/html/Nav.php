<header id="topnav">
    <div class="topbar-main">
        <div class="container active">

            <!-- LOGO -->
            <div class="topbar-left">
                <a href="<?=base_url('')?>" class="logo">
                    <!--span>Template<span>seto</span></span-->
                    <span><img src="<?=base_url('template/')?>assets/images/logo-1.png" alt="logo" style="height: 44px;"></span>
                </a>
            </div>
            <!-- End Logo container-->

            <div class="navbar-custom navbar-left">
                <div id="navigation">
                    <ul class="navigation-menu">
                        <?php foreach ($menus as $menu) { ?>
                        <li class="has-submenu">
                            <a href="#"> <span><i class="<?= $menu->menu_icono ?>"></i></span>
                                <span> <?= $menu->menu_nombre ?> </span> 
                            </a>
                            <?php if (isset($menu->children)) { ?>
                            <ul class="submenu">
                                <?php foreach ($menu->children as $child) {?>
                                <li><a href="<?=base_url($child->menu_controlador)?>"><?= $child->menu_nombre ?></a></li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="menu-extras">
                <ul class="nav navbar-nav navbar-right pull-right">
                    <li>
                        <!-- Notification -->
                        <div class="notification-box">
                            <ul class="list-inline m-b-0">
                                <li>
                                    <a href="javascript:void(0);" class="right-bar-toggle">
                                        <i class="zmdi zmdi-notifications-none"></i>
                                    </a>
                                    <div class="noti-dot">
                                        <span class="dot"></span>
                                        <span class="pulse"></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- End Notification bar -->
                    </li>

                    <li class="dropdown user-box">
                        <a href="#" class="dropdown-toggle waves-effect waves-light profile " data-toggle="dropdown" aria-expanded="true">
                            <!--img src="<?=base_url('template/assets/images/').'avatar-2.jpg'?>" alt="user-img" class="img-circle user-img"-->
                            <img src="<?=$this->session->userdata('usuario_foto')?>" alt="user-img" class="img-circle user-img">
                            <div class="user-status away"><i class="zmdi zmdi-dot-circle"></i></div>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="<?=base_url('perfil')?>"><i class="fa fa-user"></i> Perfil <?=$this->session->userdata('usuario_user');?></a></li>
                            <li><a href="<?=base_url('login/cerrar_sesion')?>"><i class="fa fa-sign-out"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>
        </div>
    </div>
</header>
<div class="wrapper">
    <div class="container"><br>