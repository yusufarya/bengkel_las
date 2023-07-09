<?php
$data = json_decode(json_encode($pageInfo), True);
$me = $data['me'];

$transaksi = $data['transaksi'];
// pre($transaksi);
?>


<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class=" d-sm-flex align-items-center justify-content-between mb-4 ml-2">
        <h1 class="h3 mb-0 text-gray-800"><?= $data['title'] ?></h1>
    </div>

    <div class="conteiner px-3">
        <div class="row">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr style="background-color: #acacac;">
                        <th style="width: 14%;">Id Trans</th>
                        <th>Kode Pesanan</th>
                        <th>Tanggal</th>
                        <th style="text-align: right;">Harga</th>
                        <th style="text-align: center; width: 17%;">Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transaksi as $row) { ?>
                        <tr>
                            <td> <?= $row['id'] ?></td>
                            <td> <?= $row['kode_pesan'] ?></td>
                            <td> <?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                            <td style="text-align: right;"> <?= number_format($row['harga'], 2) ?></td>
                            <td style="text-align: center; color: blue;">
                                <strong><?= $row['bayar'] == 'Y' ? 'ACC' : '' ?></strong>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>