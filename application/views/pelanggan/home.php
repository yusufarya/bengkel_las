<?php
$data = json_decode(json_encode($pageInfo), True);
$dataMe = $data['me'];

$this->db->select('ps.*, k.nama AS nama_barang');
$this->db->from('pesanan ps');
$this->db->join('kategori AS k', 'k.id = ps.kategori_id');
$this->db->where('ps.kd_plg', $dataMe['kode']);
$this->db->order_by('ps.kode', 'DESC');
$this->db->limit(3);
$dataAll = $this->db->get()->result_array();

$total_psn = $this->db->get_where('pesanan', ['kd_plg' => $dataMe['kode'], 'aktif' => 1])->num_rows();
$psn_selesai = $this->db->query("SELECT * FROM `pesanan` WHERE `kd_plg` = '" . $dataMe['kode'] . "' AND (`status` = 'S' OR `status` = 'A')")->num_rows();
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body px-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col ms-2">
                            <h3 id="date"></h3>
                            <h1 id="month"></h1>
                            <h1 id="dateTime"></h1>
                        </div>
                        <div class="col-auto mr-2">
                            <table class="table-sm" style="font-size: 14px;">
                                <tr>
                                    <th>Nama</th>
                                    <td> &nbsp; :&nbsp; <?php echo $dataMe['nama'] ?></td>
                                </tr>
                                <tr>
                                    <th>Telp</th>
                                    <td> &nbsp; :&nbsp; <?php echo $dataMe['no_telp'] ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td> &nbsp; :&nbsp; <?php echo $dataMe['alamat'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body px-4">
                    <div class="row no-gutters align-items-center">
                        <div class="col ml-3">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pesanan
                            </div>
                            <div class="mt-3 mb-0 font-weight-bold text-gray-800"> <?= $total_psn ?> Diproses</div>
                            <a href="<?= base_url('pesanan_saya') ?>" class="text-decoration-none text-info" style="font-size:13px;">
                                Selengkapnya..
                            </a>
                        </div>
                        <div class="col-auto me-3">
                            <i class="fas fa-dollar-sign text-warning fa-2x "></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body px-4">
                    <div class="row no-gutters align-items-center">
                        <div class="col ml-3">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Transaksi Selesai
                            </div>
                            <div class="mt-3 mb-0 font-weight-bold text-gray-800"><?= $psn_selesai ?> Selesai</div>
                            <a href="<?= base_url('pesanan_saya') ?>" class="text-decoration-none text-primary" style="font-size:13px;">
                                Selengkapnya..
                            </a>
                        </div>
                        <div class="col-auto me-2 mt-3">
                            <i class="fas fa-shopping-cart fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-8 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">3 Transaksi Terbaru</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="mt-2 text-center small">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: left;">Kode</th>
                                    <th style="text-align: left;">Barang</th>
                                    <th style="text-align: right;">Qty</th>
                                    <th style="text-align: right;">Harga</th>
                                    <th style="text-align: right;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($dataAll as $key => $tr) { ?>
                                    <tr>
                                        <td style="text-align: left;"><?= $tr['kode'] ?></td>
                                        <td style="text-align: left;"><?= $tr['nama_barang'] ?></td>
                                        <td style="text-align: right;"><?= $tr['qty'] ?></td>
                                        <td style="text-align: right;"><?= number_format($tr['harga'], 2) ?></td>
                                        <td style="text-align: right;"><?= number_format($tr['qty'] * $tr['harga'], 2) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->