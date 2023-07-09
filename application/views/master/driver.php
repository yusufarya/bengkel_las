<?php
$data = json_decode(json_encode($pageInfo), True);
$level_ = $data['me']['role_id'];
$order = $data['order'];
?>
<!-- Begin Page Content -->
<div class="container-fluid" style="height: 100vh;">

    <!-- Page Heading -->
    <form action="<?php echo base_url('listDriver') ?>" method="post">
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
                            <option value="id" <?= $order == 'id' ? 'selected' : '' ?>>Id</option>
                            <option value="nama" <?= $order == 'nama' ? 'selected' : '' ?>>Nama</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" style="float: right;" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addData">
                    <i class="bi bi-plus"></i> Data
                </button>
            </div>
        </div>
    </form>

    <!-- Content Row -->
    <div class="row mt-2 mx-0">

        <table class="table table-sm table-hover table-bordered">
            <thead>
                <tr style="text-transform: uppercase; font-size: 13px; background: #ececec;">
                    <th style="width:3%;">id</th>
                    <th>Nama Driver</th>
                    <th>Jns Kelamin</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th style="width:70px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['kategori'] as $key => $val) { ?>
                    <tr style="font-size: 13px;">
                        <td><?= $val['id'] ?></td>
                        <td><?= $val['nama'] ?></td>
                        <td><?= $val['jenis_kel'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                        <td><?= $val['alamat'] ?></td>
                        <td><?= $val['email'] ?></td>
                        <td style="text-align: center;">
                            <a href="#" onclick="editData('<?= $val['id'] ?>','<?= $val['nama'] ?>','<?= $val['email'] ?>', '<?= $val['alamat'] ?>', <?= $level_ ?>)" class="text-warning bg-white"><i class="bi bi-pencil"></i></a> &nbsp;
                            <a href="#" onclick="deleteData('<?= $val['id'] ?>','<?= $val['nama'] ?>', <?= $level_ ?>)" class="text-danger bg-white"><i class="bi bi-trash"></i></a>
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
                <h1 class="modal-title fs-5" id="addDataLabel">Tambah Data Driver</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('addDriver') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Driver</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Driver">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Driver</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="driver@gmail.com">
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kel" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kel" id="jenis_kel" class="form-select">
                            <option value="">Pilih</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Tambahkan text.."></textarea>
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
                <h1 class="modal-title fs-5" id="editDataLabel">Ubah Data Driver</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('Master/updateDtiver') ?>" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nama" class="form-label">Nama Driver</label>
                            <input type="hidden" class="form-control" id="id_edit" name="id_edit">
                            <input type="text" class="form-control" id="nama_edit" name="nama_edit" required placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="email" class="form-label">Email Driver</label>
                            <input type="text" class="form-control" id="email_edit" name="email_edit" required placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="alamat" class="form-label">alammat</label>
                            <textarea type="text" class="form-control" id="alamat_edit" name="alamat_edit" placeholder=""></textarea>
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
                <h1 class="modal-title fs-5" id="deleteDataLabel">Hapus Data Driver</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('Master/deleteDriver') ?>" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <small>Pilih ya jika anda ingin menghapus</small>
                            <input type="hidden" class="form-control" id="id_del" name="id_del">
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