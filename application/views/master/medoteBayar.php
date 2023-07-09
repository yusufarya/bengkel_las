<?php
$data = json_decode(json_encode($pageInfo), True);
$level_ = $data['me']['role_id'];
$order = $data['order'];
?>
<!-- Begin Page Content -->
<div class="container-fluid" style="height: 100vh;">

    <!-- Page Heading -->
    <form action="<?php echo base_url('metodeBayarList') ?>" method="post">
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
                            <option value="no_rek" <?= $order == 'no_rek' ? 'selected' : '' ?>>No. Rek</option>
                            <option value="nama" <?= $order == 'nama' ? 'selected' : '' ?>>Nama Bank</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" style="float: right;" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addData">
                    <i class="bi bi-plus"></i> Bahan Baku
                </button>
            </div>
        </div>
    </form>

    <!-- Content Row -->
    <div class="row mt-2 mx-0">
        <?php
        // echo $this->session->flashdata('message')
        ?>

        <table class="table table-hover table-bordered">
            <thead>
                <tr style="text-transform: uppercase; font-size: 13px; background: #ececec;">
                    <th style="width:5%;">id</th>
                    <th>Nama </th>
                    <th>No. Rek</th>
                    <th style="width:110px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['bahanbaku'] as $key => $val) { ?>
                    <tr style="font-size: 13px;">
                        <td><?= $val['id'] ?></td>
                        <td><?= $val['nama_bank'] ?></td>
                        <td><?= $val['no_rek'] ?></td>
                        <td style="text-align: center;">
                            <a href="#" onclick="editData('<?= $val['id'] ?>','<?= $val['nama_bank'] ?>', '<?= $val['no_rek'] ?>', <?= $level_ ?>)" class="text-warning bg-white"><i class="bi bi-pencil"></i></a> &nbsp;
                            <a href="#" onclick="deleteData('<?= $val['id'] ?>','<?= $val['nama_bank'] ?>', <?= $level_ ?>)" class="text-danger bg-white"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<!-- /.container-fluid -->
<div class="modal fade" id="addData" tabindex="-1" aria-labelledby="addDataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addDataLabel">Tambah Data Barang</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('addMetodeBayar') ?>" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nama" class="form-label">Nama Bank</label>
                            <input type="text" class="form-control" id="nama_bank" name="nama_bank" required placeholder="BCA">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="no_rek" class="form-label">No. Rek</label>
                            <input type="text" class="form-control" id="no_rek" name="no_rek" placeholder="XXXXXXXXXX">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- /.container-fluid -->
<div class="modal fade" id="editData" tabindex="-1" aria-labelledby="editDataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editDataLabel">Ubah Data Metode Pembayaran</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('updateMetodeBayar') ?>" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nama" class="form-label">Nama Bank</label>
                            <input type="hidden" class="form-control" id="kode_edit" name="kode_edit">
                            <input type="text" class="form-control" id="nama_bank_edit" name="nama_bank_edit" required placeholder="Barang">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="norek_edit" class="form-label">No. Rek</label>
                            <input type="text" class="form-control" id="norek_edit" name="norek_edit" placeholder="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- /.container-fluid -->
<div class="modal fade" id="deleteData" tabindex="-1" aria-labelledby="deleteDataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteDataLabel">Hapus Data Kategori</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('deleteMetodeBayar') ?>" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <small>Pilih ya jika anda ingin menghapus</small>
                            <input type="hidden" class="form-control" id="kode_del" name="kode_del">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-primary">&nbsp;Ya&nbsp;</button>
                </div>
            </form>
        </div>
    </div>
</div>