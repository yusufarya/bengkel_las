<?php
$data = json_decode(json_encode($pageInfo), True);
?>
<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background : #192a56;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard') ?>">
        <div class="sidebar-brand-icon">
            <i class="bi bi-building"></i>
        </div>
        <div class="sidebar-brand-text mx-3">BENGKEL <sup>Las Nyoto</sup> </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php echo $data['active'] == 'Dashboard' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Master Data
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link <?php echo $data['active'] == 'Master' ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapsePages1" aria-expanded="true" aria-controls="collapsePages1">
            <i class="fas fa-fw fa-users"></i>
            <span>Master Data</span>
        </a>
        <div id="collapsePages1" class="collapse <?php echo $data['active'] == 'Master' ? 'show' : '' ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if ($this->uri->segment(1) == "kategoriList") {
                                            echo "active";
                                        } ?>" href="<?= base_url('kategoriList') ?>">Kategori Jasa</a>
                <a class="collapse-item <?php if ($this->uri->segment(1) == "bahanBakuList") {
                                            echo "active";
                                        } ?>" href="<?= base_url('bahanBakuList') ?>">Bahan Baku</a>
                <a class="collapse-item <?php if ($this->uri->segment(1) == "metodeBayarList") {
                                            echo "active";
                                        } ?>" href="<?= base_url('metodeBayarList') ?>">Metode Pembayaran</a>
                <!-- <div class="collapse-divider"></div> -->
            </div>
        </div>
    </li>
    <li class="nav-item <?php echo $data['active'] == 'Driver' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('listDriver') ?>">
            <i class="fas fa-fw fa-user"></i>
            <span>Data Pengirim</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Transaksi
    </div>
    <!-- Nav Item - Tables -->
    <li class="nav-item <?php echo $data['active'] == 'Pesanan' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('listPesanan') ?>">
            <i class="fas fa-fw fa-file"></i>
            <span>Data Pesanan</span>
        </a>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link <?php echo $data['active'] == 'BL' ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#trbl" aria-expanded="true" aria-controls="trbl">
            <i class="fas fa-fw fa-dollar-sign"></i>
            <span>Pembelian</span>
        </a>
        <div id="trbl" class="collapse <?php echo $data['active'] == 'BL' ? 'show' : '' ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if ($this->uri->segment(1) == "suppList") {
                                            echo "active";
                                        } ?>" href="<?= base_url('suppList') ?>">Suplier</a>
                <a class="collapse-item <?php if ($this->uri->segment(1) == "piList" or $this->uri->segment(1) == "addDataPi" or $this->uri->segment(1) == "editDataPi") {
                                            echo "active";
                                        } ?>" href="<?= base_url('piList') ?>">Pembelian</a>
                <!-- <div class="collapse-divider"></div> -->
            </div>
        </div>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link <?php echo $data['active'] == 'JL' ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#trjl" aria-expanded="true" aria-controls="trjl">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Penjualan</span>
        </a>
        <div id="trjl" class="collapse <?php echo $data['active'] == 'JL' ? 'show' : '' ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if ($this->uri->segment(1) == "custList") {
                                            echo "active";
                                        } ?>" href="<?= base_url('custList') ?>">Pelanggan</a>
                <a class="collapse-item <?php if ($this->uri->segment(1) == "siList" or $this->uri->segment(1) == "addDataSi" or $this->uri->segment(1) == "editDataSi") {
                                            echo "active";
                                        } ?>" href="<?= base_url('siList') ?>">Penjualan</a>
                <!-- <div class="collapse-divider"></div> -->
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Heading -->
    <div class="sidebar-heading">
        Laporan
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link <?php echo $data['active'] == 'Laporan' ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Laporan</span>
        </a>
        <div id="collapsePages" class="collapse <?php echo $data['active'] == 'Laporan' ? 'show' : '' ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?= $data['title'] == 'Laporan Stok' ? 'active' : '' ?>" href="<?= base_url('laporan/lp_stok') ?>">Laporan Stok</a>
                <a class="collapse-item <?= $data['title'] == 'Laporan Transaksi' ? 'active' : '' ?>" href="<?= base_url('laporan/lp_transaksi') ?>">Laporan Transaksi</a>
                <!-- <div class="collapse-divider"></div> -->
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Heading -->
    <div class="sidebar-heading" hidden>
        Pengaturan
    </div>
    <!-- Nav Item - Tables -->
    <li class="nav-item <?php echo $data['active'] == 'Password' ? 'active' : '' ?>" hidden>
        <a class="nav-link" href="<?= base_url('admin/ubahPassword') ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Ubah Kata Sandi</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->