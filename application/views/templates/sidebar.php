<?php
$data = json_decode(json_encode($pageInfo), True);
?>
<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background : #0984e3;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('home_sales') ?>">
        <div class="sidebar-brand-icon">
            <i class="bi bi-building"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Bengkel <sup>las</sup> </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php echo $data['active'] == 'Home' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('home') ?>">
            <i class="fas fa-fw fa-home"></i>
            <span>Home Pelanggan</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Heading -->
    <div class="sidebar-heading">
        Transaksi
    </div>
    <!-- Nav Item - Tables -->
    <li class="nav-item <?php echo $data['active'] == 'Pesan' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('pesan') ?>">
            <i class="fas fa-fw fa-cart-plus" aria-hidden="true"></i>
            <span>Pemesanan</span>
        </a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item <?php echo $data['active'] == 'Pesanan' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('pesanan_saya') ?>">
            <i class="fas fa-fw fa-cart-plus" aria-hidden="true"></i>
            <span>Pesanan Saya</span>
        </a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item <?php echo $data['active'] == 'Transaksi' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('transaksi_saya') ?>">
            <i class="fas fa-fw fa-cart-plus" aria-hidden="true"></i>
            <span>Transaksi Saya</span>
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