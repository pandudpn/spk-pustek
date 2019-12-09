<?php $controller = $this->router->fetch_class(); ?>
<!-- sidebar -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="user-wrapper">
                    <div class="profile-image">
                        <img src="<?php echo base_url('assets/images/faces/avatar5.png'); ?>" alt="Profile Foto">
                    </div>
                    <div class="text-wrapper">
                        <p class="profile-name"><?php echo $login->nama; ?></p>
                        <div>
                            <small class="designation text-muted">
                                <?php
                                if($login->akses == 1){
                                    echo "Administrator";
                                }elseif($login->akses == 2){
                                    echo "Kepala Sekolah";
                                }
                                ?>
                            </small>
                            <span class="status-indicator online"></span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item <?php if($controller == 'home')echo 'active'; ?>">
            <a class="nav-link" href="<?php echo base_url(); ?>">
                <i class="menu-icon mdi mdi-home"></i>
                <span class="menu-title">Home</span>
            </a>
        </li>
        <?php if($this->session->userdata('akses') != 3){ ?>
        <li class="nav-item <?php if($controller == 'guru' || $controller == 'kriteria' || $controller == 'subkriteria')echo 'active'; ?>">
            <a class="nav-link" data-toggle="collapse" href="#master" aria-expanded="false" aria-controls="master">
                <i class="menu-icon mdi mdi-file-table"></i>
                <span class="menu-title">Master</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="master">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item <?php if($controller == 'guru')echo 'active'; ?>">
                        <a class="nav-link" href="<?php echo base_url('guru'); ?>">
                            <i class="menu-icon mdi mdi-account-tie"></i>
                            <span class="menu-title">Guru</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if($controller == 'kriteria')echo'active'; ?>">
                        <a href="<?= base_url('kriteria'); ?>" class="nav-link">
                            <i class="menu-icon mdi mdi-menu"></i>
                            <span class="menu-title">Kriteria</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if($controller == 'subkriteria')echo'active'; ?>">
                        <a class="nav-link" href="<?php echo base_url('subkriteria'); ?>">
                            <i class="menu-icon mdi mdi-menu"></i>
                            <span class="menu-title">Subkriteria</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if($controller == 'periode')echo'active'; ?>">
                        <a class="nav-link" href="<?php echo base_url('periode'); ?>">
                            <i class="menu-icon mdi mdi-menu"></i>
                            <span class="menu-title">Periode</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <?php }
        if($this->session->userdata('akses') != 2){ ?>
        <li class="nav-item <?php if($controller == 'analisa')echo 'active'; ?>">
            <a class="nav-link" data-toggle="collapse" href="#analisa" aria-expanded="false" aria-controls="analisa">
                <i class="menu-icon mdi mdi-google-analytics"></i>
                <span class="menu-title">Analisa</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="analisa">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item <?php if($this->uri->segment(2) == 'perhitungan')echo 'active'; ?>">
                        <a class="nav-link" href="<?php echo base_url('analisa/perhitungan'); ?>">
                            <i class="menu-icon mdi mdi-calculator-variant"></i>
                            <span class="menu-title">Perhitungan</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if($this->uri->segment(2) == 'pilih')echo 'active'; ?>">
                        <a class="nav-link" href="<?php echo base_url('analisa/pilih'); ?>">
                            <i class="menu-icon mdi mdi-account-star"></i>
                            <span class="menu-title">Pemilihan Guru Terbaik</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if($this->uri->segment(2) == 'pilih')echo 'active'; ?>">
                        <a class="nav-link" href="<?php echo base_url('analisa/cetakhasilkeputusan'); ?>">
                            <i class="menu-icon mdi mdi-printer"></i>
                            <span class="menu-title">Cetak Hasil Guru Terbaik</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <?php }
        if($this->session->userdata('akses') != 3){ ?>
        <li class="nav-item <?php if($controller == 'laporan')echo 'active'; ?>">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="menu-icon mdi mdi-file-document-box-multiple"></i>
                <span class="menu-title">Laporan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item <?php if($this->uri->segment(2) == 'ranking')echo 'active'; ?>">
                        <a class="nav-link" href="<?php echo base_url('laporan/ranking'); ?>">
                            <i class="menu-icon mdi mdi-format-list-numbered"></i>
                            <span class="menu-title">Ranking</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if($this->uri->segment(2) == 'evaluasi')echo 'active'; ?>">
                        <a class="nav-link" href="<?php echo base_url('laporan/evaluasi'); ?>">
                            <i class="menu-icon mdi mdi-playlist-edit"></i>
                            <span class="menu-title">Evaluasi</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if($this->uri->segment(2) == 'hasil')echo 'active'; ?>">
                        <a class="nav-link" href="<?php echo base_url('laporan/hasil'); ?>">
                            <i class="menu-icon mdi mdi-account-heart-outline"></i>
                            <span class="menu-title">Guru Terbaik</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <?php } ?>
    </ul>
</nav>
<!-- sidebar ends -->
<div class="main-panel">