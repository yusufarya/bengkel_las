<?php
$data = json_decode(json_encode($pageInfo), True);
$me = $data['me'];
$kode_pesanan = $data['kode_pesanan'];
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class=" d-sm-flex align-items-center justify-content-between mb-4 ml-2">
        <h1 class="h3 mb-0 text-gray-800"><?= $data['title'] ?></h1>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-10">
            <form action="<?= base_url('send_trx') ?>" method="POST" enctype="multipart/form-data">
                <strong class="row bg-warning px-2 mx-3 mt-2">Kirimkan Bukti Transaksi</strong>
                <div class=" mb-3 row m-2 mt-4">
                    <label for="bukti_bayar" class="col-sm-3 col-form-label">Kode Pesanan <i style="color: red;">*</i></label>
                    <div class="col-sm-9">
                        <input class="form-control" readonly id="kode" name="kode" type="text" value="<?= $kode_pesanan ?>">
                    </div>
                </div>
                <div class=" mb-3 row m-2 mt-4">
                    <label for="bukti_bayar" class="col-sm-3 col-form-label">Bukti Pembayaran <i style="color: red;">*</i></label>
                    <div class="col-sm-9">
                        <input class="form-control" id="uploadedbayar" name="buktiBayar" type="file">
                    </div>
                </div>
                <div class="mb-3 row mr-2 mt-4" style="float: right !important;">
                    <footer>
                        <button type="submit" id="kirimBukti" class="btn btn-primary">kirim</button>
                    </footer>
                </div>
            </form>

        </div>
    </div>

</div>