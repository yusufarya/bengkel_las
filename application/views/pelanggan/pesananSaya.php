<?php
$data = json_decode(json_encode($pageInfo), True);
$me = $data['me'];

$listPesanan = $data['listPesanan'];

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class=" d-sm-flex align-items-center justify-content-between mb-4 ml-2">
        <h1 class="h3 mb-0 text-gray-800"><?= $data['title'] ?></h1>
    </div>

    <!-- Content Row -->

    <div class="container">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="pesanan-tab" data-bs-toggle="tab" data-bs-target="#pesanan" type="button" role="tab" aria-controls="pesanan" aria-selected="true">Pesanan</button>
                <button class="nav-link" id="dikerjakan-tab" data-bs-toggle="tab" data-bs-target="#dikerjakan" type="button" role="tab" aria-controls="dikerjakan" aria-selected="false">Dikerjakan</button>
                <button class="nav-link" id="dikirim-tab" data-bs-toggle="tab" data-bs-target="#dikirim" type="button" role="tab" aria-controls="dikirim" aria-selected="false">Dikirim</button>
                <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai" type="button" role="tab" aria-controls="selesai" aria-selected="false">Selesai</button>
                <button class="nav-link" id="cancel-tab" data-bs-toggle="tab" data-bs-target="#cancel" type="button" role="tab" aria-controls="cancel" aria-selected="false">Dibatalkan</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="pesanan" role="tabpanel" aria-labelledby="pesanan-tab">
                <table class="table table-sm table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Transaksi</th>
                            <th>Perincian</th>
                            <th style="width: 8%; text-align: right;">Qty</th>
                            <th style="text-align: right;">Harga</th>
                            <th>Status</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($listPesanan as $ps) {
                            if ($ps['aktif'] == 1 && $ps['status'] == '') {
                        ?>
                                <tr>
                                    <td><?= $no += 1 ?></td>
                                    <td><?= $ps['kode'] ?></td>
                                    <td><?= $ps['kategori'] ?></td>
                                    <td style="text-align: right;"><?= $ps['qty'] ?></td>
                                    <td style="text-align: right;"><?= number_format($ps['harga'], 2) ?></td>
                                    <td><span class="badge badge-warning pb-2">Belum Dibayar</span></td>
                                    <td style="text-align: center;">
                                        <a href="#" onclick="infoPesanan(`<?= $ps['kode'] ?>`)" class="btn btn-sm btn-info"><i class="bi bi-info-circle"></i></a>
                                        <a href='#' onclick="batalkanPesanan('<?= $ps['kode'] ?>')" class="btn btn-sm btn-danger"><i class="bi bi-clipboard-x"></i></a>
                                    </td>
                                </tr>
                        <?php }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="dikerjakan" role="tabpanel" aria-labelledby="dikerjakan-tab">
                <table class="table table-sm table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Transaksi</th>
                            <th>Perincian</th>
                            <th style="width: 8%; text-align: right;">Qty</th>
                            <th style="text-align: right;">Harga</th>
                            <th>Status</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($listPesanan as $ps) {
                            if ($ps['status'] == 'P') {
                        ?>
                                <tr>
                                    <td><?= $no += 1 ?></td>
                                    <td><?= $ps['kode'] ?></td>
                                    <td><?= $ps['kategori'] ?></td>
                                    <td style="text-align: right;"><?= $ps['qty'] ?></td>
                                    <td style="text-align: right;"><?= number_format($ps['harga'], 2) ?></td>
                                    <td><span class="badge badge-info pb-2">Di proses</span></td>
                                    <td style="text-align: center;">
                                        <a href="#" onclick="infoPesanan(`<?= $ps['kode'] ?>`)" class="btn btn-sm btn-info"><i class="bi bi-info-circle"></i></a>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="dikirim" role="tabpanel" aria-labelledby="dikirim-tab">
                <table class="table table-sm table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Transaksi</th>
                            <th>Perincian</th>
                            <th style="width: 8%; text-align: right;">Qty</th>
                            <th style="text-align: right;">Harga</th>
                            <th style="text-align: center;">Status</th>
                            <!-- <th style="text-align: center;">Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($listPesanan as $ps) {
                            if ($ps['status'] == 'K') {
                        ?>
                                <tr>
                                    <td><?= $no += 1 ?></td>
                                    <td><?= $ps['kode'] ?></td>
                                    <td><?= $ps['kategori'] ?></td>
                                    <td style="text-align: right;"><?= $ps['qty'] ?></td>
                                    <td style="text-align: right;"><?= number_format($ps['harga'], 2) ?></td>
                                    <td style="text-align: center;"><span class="badge badge-primary pb-2">Dikirim</span></td>
                                    <!-- <td style="text-align: center;"><a href="" class="btn btn-sm btn-info"><i class="bi bi-info-circle"></i></a></td> -->
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                <table class="table table-sm table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Transaksi</th>
                            <th>Perincian</th>
                            <th style="width: 10%; text-align: center;">Tanggal</th>
                            <th style="width: 8%; text-align: right;">Qty</th>
                            <th style="text-align: right;">Harga</th>
                            <th style="text-align: center; width: 160px ">Status</th>
                            <!-- <th style="text-align: center;">Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($listPesanan as $ps) {
                            if ($ps['status'] == 'S' || $ps['status'] == 'A') {
                        ?>
                                <tr>
                                    <td><?= $no += 1 ?></td>
                                    <td><?= $ps['kode'] ?></td>
                                    <td><?= $ps['kategori'] ?></td>
                                    <td style="text-align: center;"><?= date('d/m/Y', strtotime($ps['tanggal'])) ?></td>
                                    <td style="text-align: right;"><?= $ps['qty'] ?></td>
                                    <td style="text-align: right;"><?= number_format($ps['harga'], 2) ?></td>
                                    <td style="text-align: center;">
                                        <?php if ($ps['status'] == 'S') { ?>
                                            <button type="button" class="btn px-2 btn-danger" onclick="accPsn(`<?= $ps['kode'] ?>`)">Terima Pesanan</button>
                                        <?php } else { ?>
                                            <span type="button" class="btn px-2 btn-success">Telah Diterima</span>
                                        <?php } ?>
                                    </td>
                                    <!-- <td style="text-align: center;"><a href="" class="btn btn-sm btn-info"><i class="bi bi-info-circle"></i></a></td> -->
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade show" id="cancel" role="tabpanel" aria-labelledby="cancel-tab">
                <table class="table table-sm table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Transaksi</th>
                            <th>Perincian</th>
                            <th style="width: 8%; text-align: right;">Qty</th>
                            <th style="text-align: right;">Harga</th>
                            <th>Status</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($listPesanan as $ps) {
                            if ($ps['aktif'] == 0) {
                        ?>
                                <tr>
                                    <td><?= $no += 1 ?></td>
                                    <td><?= $ps['kode'] ?></td>
                                    <td><?= $ps['kategori'] ?></td>
                                    <td style="text-align: right;"><?= $ps['qty'] ?></td>
                                    <td style="text-align: right;"><?= number_format($ps['harga'], 2) ?></td>
                                    <td><span class="badge badge-danger pb-2">Dibatalkan</span></td>
                                    <td style="text-align: center;">
                                        <!-- <a href="" class="btn btn-sm btn-info"><i class="bi bi-info-circle"></i></a> -->
                                        <a href='#' onclick="hapusPesanan('<?= $ps['kode'] ?>')" class="btn btn-sm btn-danger"><i class="bi bi-trash3-fill"></i></a>
                                    </td>
                                </tr>
                        <?php }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="cancelModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('Pelanggan/cancelPsn') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="cancelKode" name="cancelKode">
                    Anda yakin ingin membatalkan pesanan ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-primary"> Ya </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hapus data Modal -->
<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="hapusModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('Pelanggan/hapusPsn') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="hapusKode" name="hapusKode">
                    Anda yakin ingin menghapus pesanan ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-primary"> Ya </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailModalLabel">Perincian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table" id="content">
                    <thead>
                        <tr>
                            <th>Bahan Baku</th>
                            <th style="text-align: right;">Qty</th>
                            <th style="text-align: right;">Harga</th>
                            <th style="text-align: right;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: left;">Nama</td>
                            <td style="text-align: right;">2</td>
                            <td style="text-align: right;">2000</td>
                            <td style="text-align: right;">4000</td>
                        </tr>
                        <tr>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;">2</td>
                            <td style="text-align: right;"><strong>Jumlah</strong> &nbsp; :</td>
                            <td style="text-align: right;">4000</td>
                        </tr>
                        <tr>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"><strong>Biaya Jasa</strong> &nbsp; :</td>
                            <td style="text-align: right;">4000</td>
                        </tr>
                        <tr>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"> </td>
                            <td style="text-align: right;"><strong>Total Netto</strong> &nbsp; :</td>
                            <td style="text-align: right;">4000</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <button type="button" class="btn btn-success" id="pembayaran">Pembayaran</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>