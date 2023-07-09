<?php
$data = json_decode(json_encode($pageInfo), True);
$me = $data['me'];
$no_rek = $this->db->get('metode_bayar')->result_array();
$kodePesanan = $data['bayar']['kode_pesanan'];
// $checkBayar = $this->db->get_where('pembayaran', ['kode_pesan' => $kodePesanan])->row_array();
$checkBayar = $this->db->select('b.*, mb.nama_bank')
    ->from('pembayaran b')
    ->join('metode_bayar AS mb', 'mb.no_rek = b.no_rek')
    ->where('b.kode_pesan', $kodePesanan)->get()->row_array();
// pre($checkBayar);
// pre($this->db->last_query());
// die();

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class=" d-sm-flex align-items-center justify-content-between mb-4 ml-2">
        <h1 class="h3 mb-0 text-gray-800"><?= $data['title'] ?></h1>
    </div>
    <hr>

    <?php if ($checkBayar) { ?>
        <div class="container">
            <div class="row justify-content-star">
                <table class="table" style="width: 70%; margin: 10px;">
                    <tr class="alert alert-warning">
                        <th style="width: 40%; margin: 10px;">Kode Pesanan </th>
                        <td style="">&nbsp; : &nbsp; <?= $checkBayar['id'] ?></td>
                    </tr>
                    <tr class="alert alert-warning">
                        <th style="width: 40%; margin: 10px;">Kode Pesanan </th>
                        <td style="">&nbsp; : &nbsp; <?= $checkBayar['kode_pesan'] ?></td>
                    </tr>
                    <tr class="alert alert-warning">
                        <th style="width: 40%; margin: 10px;">Jumlah </th>
                        <td style="">&nbsp; : &nbsp; Rp. <?= number_format($data['bayar']['harga_netto'], 2) ?></td>
                    </tr>
                    <tr>
                        <td>Metode Pembayaran </td>
                        <td></td>
                    </tr>
                    <tr class="alert alert-info">
                        <th colspan="2" style="text-align: center; font-size:24px; margin: 10px;"><?= $checkBayar['nama_bank'] ?> &nbsp; <?= $checkBayar['no_rek'] ?> </th>
                    </tr>
                </table><br>
                <small class="shadow p-3 text-center ms-2 text-primary" style="width: 70%; margin: 10px 0;">Lakukan pembayaran sebelum 10 jam kedepan.</small>
                <small class="p-3 text-left ms-1 text-dark" style="width: 70%; margin: 10px 0;">
                    <a href="<?= base_url('kirimBuktiBayar/') . $checkBayar['kode_pesan'] ?>" class="text-decoration-none"><b>Kirim Bukti Pembayaran</b></a> Jika telah melakukan pembayaran
                </small>
            </div>
        </div>
    <?php } else {  ?>
        <!-- Content Row -->
        <div class="container">
            <div class="row">
                <table class="table" style="width: 70%; margin: 10px;">
                    <tr class="alert alert-warning">
                        <th>Kode Pesanan </th>
                        <td>&nbsp; : &nbsp; <?= $kodePesanan ?></td>
                    </tr>
                    <tr class="alert alert-warning">
                        <th>Jumlah </th>
                        <td>&nbsp; : &nbsp; Rp. <?= number_format($data['bayar']['harga_netto'], 2) ?></td>
                    </tr>
                </table><br>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="no_rek" class="form-label">Metode Pembayaran</label>
                        <select name="no_rek" id="no_rek" class="form-select">
                            <option value="">Pilih </option>
                            <?php foreach ($no_rek as $val) { ?>
                                <option value="<?= $val['no_rek'] ?> "><?= $val['nama_bank'] . ' - ' . $val['no_rek'] ?></option>
                            <?php } ?>
                            <option value="lain">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="button"> &nbsp; </label><br>
                        <button type="button" class="btn btn-success" onclick="lanjutkan(`<?= $data['bayar']['kode_pesanan'] ?>`,`<?= $data['bayar']['harga_netto'] ?>`)">Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>
    <?php }  ?>
</div>
</div>
</div>