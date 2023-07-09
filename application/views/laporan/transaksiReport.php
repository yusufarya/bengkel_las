<?php
$data = json_decode(json_encode($pageInfo), True);
$dataMe = $data['me'];
$level_ = $data['me']['role_id'];

$bahan_baku = $data['bahan_baku'];
$pelanggan = $data['pelanggan'];

?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="h4 mb-0 text-gray-800"> <?= $data['title'] ?> Bahan Baku</h3>
    </div>
    <hr>
    <br>

    <div class="container-fluid">
        <div class="row">

            <form role="form" action="<?= base_url('laporan/viewLtrans') ?>" method="POST" onsubmit="target_popup(this)">
                <div class="col-md-8 card p-4">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="brg">Nama Pelanggan</label>
                            <select name="pelanggan" id="pelanggan" class="form-select">
                                <option value="">Pilih Pelanggan</option>
                                <?php foreach ($pelanggan as $row) { ?>
                                    <option value="<?= $row['kode'] ?>"><?= $row['kode'] . ' - ' . $row['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="tgl">Tanggal</label>
                            <input type="date" name="tgl" id="tgl" class="form-control" value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="tgl">S/D</label>
                            <input type="date" name="tgl1" id="tgl1" class="form-control" value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="kodePs">Kode Pesanan</label>
                            <input type="text" placeholder="PO-XXXXXX" name="kode_ps" id="kode_ps" class="form-control">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="bayar">&nbsp;</label><br>
                            <label class="form-check-label form-control" for="bayar">
                                <input class="form-check-input ms-1" type="checkbox" value="Y" id="bayar" name="bayar">
                                &nbsp; &nbsp; &nbsp; Status Pembayaran
                            </label>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="brg">Status Pesanan</label>
                            <select name="status_ps" id="status_ps" class="form-select">
                                <option value="">Pilih</option>
                                <option value="P">Diproses</option>
                                <option value="K">Pengiriman</option>
                                <option value="S">Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="batal">&nbsp;</label><br>
                            <label class="form-check-label form-control" for="batal">
                                <input class="form-check-input ms-1" type="checkbox" value="Y" id="batal" name="batal">
                                &nbsp; &nbsp; &nbsp; Pesanan Dibatalkan
                            </label>
                        </div>
                        <br>
                        <div class="footer" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-info px-4" style="float: right;"><i class="bi bi-search"></i></button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
</div>
</div>
<br>
<hr>