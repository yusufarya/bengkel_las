<?php
$data = json_decode(json_encode($pageInfo), True);
$dataMe = $data['me'];
$level_ = $data['me']['role_id'];

$bahan_baku = $data['bahan_baku'];

?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="h4 mb-0 text-gray-800"> <?= $data['title'] ?> Bahan Baku</h3>
    </div>
    <hr>
    <br>

    <div class="container">
        <div class="row">

            <form role="form" action="<?= base_url('laporan/viewLstok') ?>" method="POST" onsubmit="target_popup(this)">
                <div class="col-md-8 card p-4">
                    <div class="row">
                        <div class="col">
                            <label for="brg">Nama Barang</label>
                            <select name="bahan_baku" id="bahan_baku" class="form-select">
                                <option value="">Pilih</option>
                                <?php foreach ($bahan_baku as $row) { ?>
                                    <option value="<?= $row['kode'] ?>"><?= $row['kode'] . ' - ' . $row['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="brg">Stok</label>
                            <select name="stok" id="stok" class="form-select">
                                <option value="1">Lebih dari > 0</option>
                                <option value="0">Kurang dari <= 0</option>
                            </select>
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