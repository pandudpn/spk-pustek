<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="<?php echo base_url(); ?>" style="color:#000; font-size:18px;">
            <img src="<?= base_url('assets/images/logo.png'); ?>" alt="SMK Pustek Serpong" style="width: 60px; height: 60px;">
        </a>
        <a class="navbar-brand brand-logo-mini" href="<?php echo base_url(); ?>" style="color:#000; font-size:14px;">
            <img src="<?= base_url('assets/images/logo.png'); ?>" alt="SMK Pustek Serpong" style="width: 60px; height: 60px;">
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown d-none d-xl-inline-block">
                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <span class="profile-text">Hello, <?php echo $login->nama; ?></span>
                    <img class="img-xs rounded-circle" src="<?php echo base_url('assets/images/faces/avatar5.png'); ?>" alt="avatar5.png">
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <a class="dropdown-item mt-3" href="<?php echo base_url('login/logout'); ?>" style="padding-top: 10px; padding-bottom:10px;">
                        Logout <i class="mdi mdi-logout-variant"></i>
                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
<div class="container-fluid page-body-wrapper">