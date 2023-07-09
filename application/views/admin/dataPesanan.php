<?php
$data = json_decode(json_encode($pageInfo), True);

$order = $data['order'];
?>
<!-- Begin Page Content -->
<div class="container-fluid" style="height: 100vh;">

    <!-- Page Heading -->
    <form action="<?php echo base_url('listPesanan') ?>" method="post">
        <div class="row">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h3 class="h4 mb-2 text-dark"><?= $data['title'] ?></h3>
            </div>
            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" name="searchText" class="form-control" placeholder="Cari nama..." autocomplete="off" value="<?= $data['searchText'] ?>">
                    <button class="btn btn-outline-primary" type="submit" id="submit">Cari</button>
                    <button class="btn btn-outline-secondary" onclick="resetSearch()"><i class="fa fa-eraser"></i></button>
                </div>
            </div>
            <div class="col-md-2">
                <div class="row">
                    <div class="col-md-10">
                        <select class="form-select" name="orderby" id="orderList">
                            <option value="">Urutkan</option>
                            <option value="kode" <?= $order == 'kode' ? 'selected' : '' ?>>Kode</option>
                            <option value="barang" <?= $order == 'barang' ? 'selected' : '' ?>>Pesanan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-2" hidden>
                <a style="float: right;" href="<?= base_url('Transaksi/addTransaksi') ?>" class="btn btn-sm btn-outline-primary" type="button" id="addData"><i class="bi bi-plus"></i> Data Transaksi</a>
            </div>
        </div>
    </form>

    <!-- Content Row -->
    <div class="row mt-2 mx-0">

        <table class="table table-sm table-hover table-bordered">
            <thead>
                <tr style="text-transform: uppercase; font-size: 13px; background: #ececec;">
                    <th style="width:11%;">Kode</th>
                    <th>Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th style="width:110px; text-align:left;">Tanggal</th>
                    <th style="width:50px; text-align:center;">Qty</th>
                    <th style="text-align:left;">Keterangan</th>
                    <th style="width:110px; text-align:left;">Id Transaksi</th>
                    <th style="width:70px; text-align:center;">Status</th>
                    <th style="width:70px; text-align:center;">Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['dataPesanan'] as $key => $val) { ?>
                    <tr style="font-size: 13px;">
                        <td><?= FormatNo_($val['kode']) ?></td>
                        <td><?= $val['nama_jasa'] ?></td>
                        <td><?= $val['pelanggan'] ?></td>
                        <td><?= date('m-d-Y', strtotime($val['tanggal'])); ?></td>
                        <td style="text-align:center"><?= $val['qty'] ?></td>
                        <td><?= $val['keterangan'] ?></td>
                        <td><a href="#" onclick="detail_tr(`<?= $val['idtr'] ?>`, `<?= $val['bayar'] ?>`)"><?= $val['idtr'] ?></a></td>
                        <td style="text-align: center;">
                            <?php if ($val['status'] == 'P') { ?>
                                <button type="button" class="btn btn-sm btn-success" onclick="kirimPesanan(`<?= $val['kode'] ?>`)">Proses</button>
                            <?php } else if ($val['status'] == 'K') { ?>
                                <button type="button" onclick="pesananSelesai(`<?= $val['kode'] ?>`)" class="btn btn-sm btn-info">Kirim</button>
                            <?php } else if ($val['status'] == 'S' or $val['status'] == 'A') { ?>
                                <button type="button" class=" btn btn-sm btn-primary">Selesai</button>
                            <?php } ?>
                        </td>
                        <td style="text-align: center;">
                            <?php if ($val['bayar'] == 'Y') { ?>
                                <button type="button" class="btn btn-sm btn-success" onclick="prosesPesanan(`<?= $val['kode'] ?>`)"> <i class="bi bi-check-circle"></i> </button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-sm btn-danger px-1"> &nbsp; X &nbsp; </button>
                            <?php } ?>
                        </td>
                        <!-- <td style="text-align:right"><?= number_format($val['harga']) ?></td> -->
                        <!-- <td style="text-align: center;"> -->
                        <!-- <a href="#" onclick="deleteTr('<?= $val['kode'] ?>','<?= $val['nama_jasa'] ?>')" class="text-danger bg-white text-decoration-none"></i></a> -->
                        <!-- </td> -->
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>
<!-- /.container-fluid -->

<div class="modal fade deleteTr" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Sales</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control-plaintext" id="del_kode">
                <p id="hapus"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-primary" id="btnDel">Ya</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade idTR" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="content_tr">
                <div class="row">
                    <div class="col">
                        <table class="table">
                            <tr>
                                <input type="hidden" id="kode_pesanan">
                                <th>Metode Pembayaran</th>
                                <td id="metode_bayar"></td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td id="tgl"></td>
                            </tr>
                            <tr>
                                <th>Jumlah</th>
                                <td id="hrg"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col">
                        <img id="img-tr" width="300" src="" alt="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-acc">ACC</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>