<?php
$data = json_decode(json_encode($pageInfo), True);
$dataAdm = $data['me'];
$level_ = $data['me']['role_id'];

$barangInfo = $data['barangInfo'];
// pre($barangInfo);
$hdInfo = $data['hdInfo'];
$dtInfo = $data['dtInfo'];

$nomor = '';
$nourut = '';
$kd_pesan = '';
$kd_bahan_baku = '';
$tanggal = '';
$qty = '';
$harga = '';

foreach ($dtInfo as $rowdt) {
    $nomor = $rowdt['nomor'];
    $nourut = $rowdt['nourut'];
    $kd_pesan = $rowdt['kd_pesan'];
    $kd_bahan_baku = $rowdt['kd_bahan_baku'];
    $tanggal = $rowdt['tanggal'];
    $qty = $rowdt['qty'];
    $harga = $rowdt['harga'];
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="h4 mb-0 text-gray-800">Ubah <?= $data['title'] ?></h3>
    </div>
    <hr>
    <br>
    <form action="" method="post">
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="nomor" class="text-dark">Nomor Transaksi</label>
                    <input type="text" id="nomor" name="nomor" class="form-control" placeholder="BL-XXXX/XX-XXXX" readonly value="<?= FormatNo_($hdInfo['nomor']) ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="tanggal" class="text-dark">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" class="form-control" readonly value="<?= date('Y-m-d', strtotime($hdInfo['tanggal'])) ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="pelanggan" class="text-dark">Pelanggan</label>
                    <select name="pelanggan" id="pelanggan" class="form-select" disabled>
                        <option value="">Pilih</option>
                        <?php foreach ($data['plgInfo'] as $plg) { ?>
                            <option value="<?= $plg['kode'] ?>" <?= $hdInfo['kd_plg'] == $plg['kode'] ? 'selected' : '' ?>>
                                <?= $plg['kode'] . ' - ' . $plg['nama'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="form-group">
                    <label for="keterangan" class="text-dark">Keterangan</label>
                    <input type="text" id="keterangan" name="keterangan" class="form-control" autocomplete="off" placeholder="Tambahkan text..." value="<?= $hdInfo['keterangan'] ?>">
                </div>
            </div>
            <div class="col-lg-4" style="width: 10%;">
                <div class="form-group">
                    <label class="text-dark">&nbsp;</label>
                    <button type="button" id="addData" class="btn btn-primary form-control mt-0">
                        <b>+ </b> Detail
                    </button>
                </div>
            </div>

            <div id="rowBarang" class="row">

                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="kode_pesanan" class="text-dark">Kode Pesanan</label>
                        <select name="kode_pesanan" id="kode_pesanan" class="form-select">
                            <option value="">Pilih Kode</option>
                            <?php if (count($dtInfo) > 0) { ?>
                                <option value="<?= $kd_pesan ?>" selected><?= FormatNo_($kd_pesan) ?></option>
                            <?php } else { ?>
                                <?php foreach ($data['psnInfo'] as $pns) { ?>
                                    <option value="<?= $pns['kode'] ?>" <?= $kd_pesan == $pns['kode'] ? 'selected' : '' ?>>
                                        <?= FormatNo_($pns['kode']) . ' - ' . $pns['pelanggan'] ?>
                                    </option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4" style="width: 10%;">
                    <div class="form-group">
                        <label class="text-dark">&nbsp;</label>
                        <button type="button" id="addDetail" class="btn btn-primary form-control mt-0">
                            <b>+ </b> Data
                        </button>
                    </div>
                </div>

            </div>

            <!-- row table  -->
            <div class="col-lg-12 px-2 mx-2" id="rowDetail">

                <table class="table table-sm" id="table-detail">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <!-- <th>Nomor</th> -->
                            <th>Bahan Baku</th>
                            <th style="width: 8%; text-align: right;">Qty</th>
                            <th style="width: 15%; text-align: right;">Harga</th>
                            <th style="width: 15%; text-align: right;">Jumlah</th>
                            <th style="text-align: center; width: 8%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td>Nomor</td>
                            <td>
                                <select name="bahan_baku" id="bahan_baku" class="form-select">
                                    <option value="">Pilih Barang</option>
                                </select>
                            </td>
                            <td style="text-align: right;"><input class="form-control" type="text" id="qty" name="qty" placeholder="0" style="text-align: right; width: 100%;"></td>
                            <td style="text-align: right;"><input class="form-control" type="text" id="harga" name="harga" placeholder="0" style="text-align: right;"></td>
                            <td><input class="form-control" type="text" id="ket" name="ket" placeholder=".... " style="width: 100%;"></td>
                            <td><button type="button" class="btn btn-sm btn-primary"><i class="bi bi-plus-square-fill"></i></button></td>
                        </tr> -->
                    </tbody>
                </table>

            </div>
        </div>
    </form>

    <br><br>
    <section class="row" style="float: right;">
        <a href="<?= base_url('siList') ?> " class="btn btn-warning" style="width: 120px;">Kembali</a>&nbsp;
        <a href="#" onclick="simpan()" class="btn btn-success" style="width: 120px;">Simpan</a>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="modal-editLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-editLabel">Ubah data</h1>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="ebahan_baku" class="form-label">Bahan Baku</label>
                            <input type="text" class="form-control" id="ebahan_baku" name="ebahan_baku" disabled>
                            <input type="hidden" id="enourut" name="enourut">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="eqty" class="form-label">Quantity</label>
                            <input type="text" class="form-control" id="eqty" name="eqty">
                            <input type="hidden" id="eqty_old" name="eqty_old">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="ehrg" class="form-label">Harga</label>
                            <input type="text" class="form-control" id="ehrg" name="ehrg">
                        </div>
                        </row>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="simpanDt">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<hr>