<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Master extends BaseController
{

    public function kategoriList()
    {
        cekSession();
        $cekSession = cekSession();

        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;
        $order = $this->input->post('orderby');
        $data['order'] = $order;
        $data['kategori'] = $this->Master_model->listKategori($searchText, $order);

        $data['me'] = $cekSession;
        $data['title'] = 'Master Kategori Jasa';
        $data['active'] = 'Master';

        $this->global['page_title'] = 'Kategori - BENGKEL';
        $this->loadViewsAdmin('master/kategori', $this->global, $data, NULL, TRUE);
    }

    function addKategori()
    {
        $nama = $this->input->post('nama');
        $keterangan = $this->input->post('keterangan');
        $biaya = $this->input->post('biaya');
        $data = [
            'nama' => ucwords($nama),
            'keterangan' => ucfirst($keterangan),
            'biaya' => $biaya
        ];
        $result = $this->db->insert('kategori', $data);
        if ($result) {
            redirect('kategoriList');
        } else {
            die('Proses Gagal. Hubungi Administrator');
        }
    }

    function updateKategori()
    {
        $id = $this->input->post('id_edit');
        $nama = $this->input->post('nama_edit');
        $keterangan = $this->input->post('ket_edit');
        $biaya = $this->input->post('biaya_edit');
        $data = [
            'nama' => ucwords($nama),
            'keterangan' => ucfirst($keterangan),
            'biaya' => $biaya
        ];
        $this->db->where("id", $id);
        $result = $this->db->update('kategori', $data);
        if ($result) {
            redirect('kategoriList');
        } else {
            die('Proses Gagal. Hubungi Administrator');
        }
    }

    function deleteKategori()
    {
        $id = $this->input->post('id_del');
        $this->db->where('id', $id);
        $this->db->delete('kategori');
        redirect('kategoriList');
    }

    public function bahanBakuList()
    {
        cekSession();
        $cekSession = cekSession();

        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;
        $order = $this->input->post('orderby');
        $data['order'] = $order;
        $data['bahanbaku'] = $this->Master_model->listBahanbaku($searchText, $order);

        $data['me'] = $cekSession;
        $data['title'] = 'Master Bahan Baku';
        $data['active'] = 'Master';

        $this->global['page_title'] = 'Bahan Baku - BENGKEL';
        $this->loadViewsAdmin('master/bahanbaku', $this->global, $data, NULL, TRUE);
    }

    function addBahanbaku()
    {
        $nama = ucwords($this->input->post('nama'));
        $harga_beli = $this->input->post('harga_beli');
        $harga_jual = $this->input->post('harga_jual');

        $getLasCode = $this->db->query('SELECT MAX(kode) AS KODE FROM bahan_baku')->row();
        $kode = $getLasCode->KODE;
        if ($kode != '') {
            $kode += 1;
            $kode = sprintf('%05d', $kode);
        } else {
            $kode = '000000';
            $kode = sprintf('%05d', $kode) + 1;
        }
        $data = [
            'kode' => $kode,
            'nama' => $nama,
            'harga_beli' => $harga_beli,
            'harga_jual' => $harga_jual
        ];
        $result = $this->db->insert('bahan_baku', $data);

        if ($result) {
            $this->session->set_flashdata('message', '<div class="alert alert-success py-2" role="alert">Barang berhasil di tambahkan.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success py-2" role="alert">Proses Gagal. Hubungi administrator.</div>');
        }
        redirect('bahanBakuList');
    }

    function updateBahanBaku()
    {
        $kode = $this->input->post('kode_edit');
        $nama = $this->input->post('nama_edit');
        $harga_beli = $this->input->post('harga_beli_edit');
        $harga_jual = $this->input->post('harga_jual_edit');
        $data = [
            'nama' => ucwords($nama),
            'harga_beli' => $harga_beli,
            'harga_jual' => $harga_jual
        ];
        $result = $this->db->update('bahan_baku', $data, ['kode' => $kode]);
        // die($this->db->last_query());
        if ($result) {
            redirect('bahanBakuList');
        } else {
            die('Terjadi Kesalahan. Hubungi Administrator.');
        }
    }

    function deleteBahanbaku()
    {
        $kode = $this->input->post('kode_del');
        $this->db->where('kode', $kode);
        $this->db->delete('bahan_baku');
        redirect('bahanBakuList');
    }

    public function metodeBayarList()
    {
        cekSession();
        $cekSession = cekSession();

        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;
        $order = $this->input->post('orderby');
        $data['order'] = $order;
        $data['bahanbaku'] = $this->Master_model->listMetodePembayaran($searchText, $order);

        $data['me'] = $cekSession;
        $data['title'] = 'Metode Pembayaran';
        $data['active'] = 'Master';

        $this->global['page_title'] = 'Metode Pembayaran - BENGKEL';
        $this->loadViewsAdmin('master/medoteBayar', $this->global, $data, NULL, TRUE);
    }

    function addMetodeBayar()
    {
        $nama_bank = strtoupper($this->input->post('nama_bank'));
        $no_rek = $this->input->post('no_rek');

        $data = [
            'nama_bank' => $nama_bank,
            'no_rek' => $no_rek
        ];
        $result = $this->db->insert('metode_bayar', $data);

        if ($result) {
            $this->session->set_flashdata('message', '<div class="alert alert-success py-2" role="alert">Barang berhasil di tambahkan.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success py-2" role="alert">Proses Gagal. Hubungi administrator.</div>');
        }
        redirect('metodeBayarList');
    }

    function updateMetodeBayar()
    {
        $kode = $this->input->post('kode_edit');
        $nama_bank = strtoupper($this->input->post('nama_bank_edit'));
        $no_rek = $this->input->post('norek_edit');

        $data = [
            'nama_bank' => ucwords($nama_bank),
            'no_rek' => $no_rek
        ];
        $result = $this->db->update('metode_bayar', $data, ['id' => $kode]);
        // die($this->db->last_query());
        if ($result) {
            redirect('metodeBayarList');
        } else {
            die('Terjadi Kesalahan. Hubungi Administrator.');
        }
    }

    function deleteMetodeBayar()
    {
        $kode = $this->input->post('kode_del');
        $this->db->where('id', $kode);
        $this->db->delete('metode_bayar');
        redirect('metodeBayarList');
    }

    function getHargaBarang()
    {
        $kode = $this->input->post('kode');

        $data = $this->db->select('nama, harga_jual, harga_beli')->get_where('bahan_baku', ['kode' => $kode])->row_array();
        echo json_encode($data);
    }

    // Menu Driver //
    public function listDriver()
    {
        cekSession();
        $cekSession = cekSession();

        $roleMenu = $cekSession['role_id'] == 2 ? 'D' : '';

        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;
        $order = $this->input->post('orderby');
        $data['order'] = $order;
        $data['kategori'] = $this->Master_model->listDriver($searchText, $order);

        $data['me'] = $cekSession;
        $data['title'] = 'Data Pengirim';
        $data['active'] = 'Driver';

        $this->global['page_title'] = 'Data Pengirim - BENGKEL';
        $this->loadViewsAdmin('master/driver', $this->global, $data, NULL, TRUE, $roleMenu);
    }

    function addDriver()
    {
        $nama = $this->input->post('nama');
        $jenis_kel = $this->input->post('jenis_kel');
        $alamat = $this->input->post('alamat');
        $email = $this->input->post('email');

        $data = [
            'nama' => ucwords($nama),
            'jenis_kel' => $jenis_kel,
            'email' => $email,
            'role_id' => 2,
            'password'  => password_hash('111111', PASSWORD_DEFAULT),
            'alamat' => ucwords($alamat),
            'status' => 1,
            'tgl_dibuat' => date('Y-m-d')
        ];
        $result = $this->db->insert('users', $data);
        if ($result) {
            redirect('listDriver');
        } else {
            die('Proses Gagal. Hubungi Administrator');
        }
    }

    function updateDtiver()
    {
        $id = $this->input->post('id_edit');
        $nama = $this->input->post('nama_edit');
        $alamat = $this->input->post('alamat_edit');

        $data = [
            'nama' => ucwords($nama),
            'alamat' => ucwords($alamat),
            // 'status' => 1,
            // 'tgl_dibuat' => date('Y-m-d')
        ];
        $result = $this->db->update('users', $data, ['id' => $id]);
        if ($result) {
            redirect('listDriver');
        } else {
            die('Proses Gagal. Hubungi Administrator');
        }
    }

    function deleteDriver()
    {
        $id = $this->input->post('id_del');
        $this->db->where('id', $id);
        $this->db->delete('users');
        redirect('listDriver');
    }
}
