<?php
$data = json_decode(json_encode($pageInfo), True);

$order = $data['order'];
?>
<!-- Begin Page Content -->
<div class="container-fluid" style="height: 100vh;">

    <!-- Page Heading -->
    <form action="<?php echo base_url('siList') ?>" method="post">
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
                            <option value="nomor" <?= $order == 'nomor' ? 'selected' : '' ?>>Nomor</option>
                            <option value="tanggal" <?= $order == 'tanggal' ? 'selected' : '' ?>>Tanggal</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <a style="float: right;" href="<?= base_url('addDataSi') ?>" class="btn btn-sm btn-outline-primary" type="button" id="addData"><i class="bi bi-plus"></i> Data </a>
            </div>
        </div>
    </form>

    <!-- Content Row -->
    <div class="row mt-2 mx-0">

        <table class="table table-sm table-hover table-bordered">
            <thead>
                <tr style="text-transform: uppercase; font-size: 13px; background: #ececec;">
                    <th style="width:14%;">Nomor</th>
                    <th style="width:40px; text-align:left;">Tanggal</th>
                    <th style="width:80px; text-align:left;">Pelanggan</th>
                    <th style="width:50px; text-align:right;">Qty</th>
                    <th style="width:110px; text-align:right;">Harga</th>
                    <th style="width: 8%; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['dataPenjualan'] as $key => $val) { ?>
                    <tr style="font-size: 13px;">
                        <td><?= FormatNo_($val['nomor']) ?></td>
                        <td><?= date('m-d-Y', strtotime($val['tanggal'])); ?></td>
                        <td><?= $val['pelanggan'] ?></td>
                        <td style="text-align:right"><?= $val['jumlah'] ?></td>
                        <td style="text-align:right"><?= number_format($val['harga']) ?></td>
                        <td style="text-align: center;">
                            <a href="<?= base_url('editDataSi/') . $val['nomor'] ?>" class="text-warning bg-white"><i class="bi bi-pencil"></i></a> &nbsp;
                            <a href="#" onclick="deleteTr('<?= $val['nomor'] ?>')" class="text-danger bg-white"><i class="bi bi-trash"></i></a>
                        </td>
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