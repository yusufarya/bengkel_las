<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Pembelian extends BaseController
{

    public function supplierList()
    {
        cekSession();
        $cekSession = cekSession();

        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;
        $order = $this->input->post('orderby');
        $data['order'] = $order;
        $data['supplier'] = $this->Pembelian_model->listSupplier($searchText, $order);

        $data['me'] = $cekSession;
        $data['title'] = 'Data Supplier';
        $data['active'] = 'BL';

        $this->global['page_title'] = 'Data Supplier - BENGKEL';
        $this->loadViewsAdmin('pembelian/dataSupplier', $this->global, $data, NULL, TRUE);
    }

    function addSupplier()
    {
        $getKode = $this->db->query("SELECT kode FROM supplier ORDER BY kode DESC LIMIT 0, 1 ")->row_array();
        if ($getKode) {
            $kode = sprintf('%05d', $getKode['kode'] + 1);
        } else {
            $kode = '00001';
        }

        $nama = $this->input->post('nama');
        $no_telp = $this->input->post('no_telp');
        $jns_kel = $this->input->post('jns_kel');
        $alamat = $this->input->post('alamat');
        $data = [
            'kode' => $kode,
            'nama' => ucwords($nama),
            'no_telp' => $no_telp,
            'jenis_kel' => ucfirst($jns_kel),
            'alamat' => ucfirst($alamat),
            'tgl_dibuat' => date('Y-m-d')
        ];
        $result = $this->db->insert('supplier', $data);
        if ($result) {
            redirect('suppList');
        } else {
            die('Proses Gagal. Hubungi Administrator');
        }
    }

    function updateSupplier()
    {
        $kode = $this->input->post('kode_edit');
        $nama = $this->input->post('nama_edit');
        $no_telp = $this->input->post('no_telp_edit');
        $jns_kel = $this->input->post('jns_kel_edit');
        $alamat = $this->input->post('alamat_edit');
        $data = [
            'nama' => ucwords($nama),
            'no_telp' => $no_telp,
            'jenis_kel' => ucfirst($jns_kel),
            'alamat' => ucfirst($alamat),
            'tgl_dibuat' => date('Y-m-d')
        ];
        $this->db->where("kode", $kode);
        $result = $this->db->update('supplier', $data);
        if ($result) {
            redirect('suppList');
        } else {
            die('Proses Gagal. Hubungi Administrator');
        }
    }

    function deleteSupplier()
    {
        $kode = $this->input->post('id_del');
        $this->db->where('kode', $kode);
        $this->db->delete('supplier');
        redirect('suppList');
    }

    public function listPembelian()
    {
        recalculateStock();
        cekSession();
        $cekSession = cekSession();
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;
        $order = $this->input->post('orderby');
        $data['order'] = $order;
        $data['dataPembelian'] = $this->Pembelian_model->listPembelian($searchText, $order);

        $data['me'] = $cekSession;
        $data['title'] = 'Data Pembelian';
        $data['active'] = 'BL';

        $this->global['page_title'] = 'Data Pembelian - BENGKEL';
        $this->loadViewsAdmin('admin/dataPembelian', $this->global, $data, NULL, TRUE);
    }

    function addPi()
    {
        cekSession();
        $cekSession = cekSession();

        // $data['psnInfo'] = $this->db->get_where('pesanan', ['flag' => NULL, 'aktif' => 1])->result_array();
        $data['psnInfo'] = $this->db->query('SELECT * FROM pesanan WHERE  aktif = 1 AND (flag = "" OR flag IS NULL)')->result_array();
        $data['barangInfo'] = $this->db->get('bahan_baku')->result_array();
        $data['splInfo'] = $this->db->get('supplier')->result_array();
        $data['me'] = $cekSession;
        $data['title'] = 'Data Pembelian';
        $data['active'] = 'BL';

        $this->global['page_title'] = 'Data Pembelian - BENGKEL';
        $this->loadViewsAdmin('admin/addPi', $this->global, $data, NULL, TRUE);
    }

    function editPi($nomor)
    {
        cekSession();
        $cekSession = cekSession();

        $data['psnInfo'] = $this->db->where(['flag' => NULL, 'aktif' => 1])->or_where(['flag' => ''])
            ->get('pesanan')->result_array();
        $data['hdInfo'] = $this->db->get_where('pembelian', ['nomor' => $nomor])->row_array();
        $data['dtInfo'] = $this->db->get_where('pembelian_detail', ['nomor' => $nomor])->result_array();
        $data['barangInfo'] = $this->db->get('bahan_baku')->result_array();
        $data['splInfo'] = $this->db->get('supplier')->result_array();
        $data['me'] = $cekSession;
        $data['title'] = 'Data Pembelian';
        $data['active'] = 'BL';

        $this->global['page_title'] = 'Data Pembelian - BENGKEL';
        $this->loadViewsAdmin('admin/editPi', $this->global, $data, NULL, TRUE);
    }

    function addDataPembelianDetail()
    {
        $post = $this->input->post(NULL, TRUE);

        $nomor = $post['nomor'];
        $nomor = preg_replace('/[\W_]+/', '', $nomor);

        $cqry = 'SELECT nourut FROM pembelian_detail WHERE nomor = "' . $nomor . '" order by nourut DESC';
        $getNourut = $this->db->query($cqry)->row_array();
        if ($getNourut) {
            $nourut = $getNourut['nourut'] + 1;
            $nourut = sprintf('%05d', $nourut);
        } else {
            $nourut = sprintf('%05d', 1);
        }
        $tanggal = $post['tanggal'];
        $kode_psn = $post['kode_psn'];
        $bahan_baku = $post['bahan_baku'];
        $qty = $post['qty'];
        $harga = $post['harga'];

        $getPK = $this->Transaksi_model->getIdTr($nomor, 'BL');

        $dataInsert = [
            'id' => $getPK,
            'nomor' => $nomor,
            'nourut' => $nourut,
            'tanggal' => $tanggal,
            'kd_pesan' => $kode_psn,
            'kd_bahan_baku' => $bahan_baku,
            'qty' => $qty,
            'harga' => $harga,
        ];

        $getStok = $this->db->get_where('bahan_baku', ['kode' => $bahan_baku])->row_array();
        $this->db->where('kode', $getStok['kode']);
        $stok = $getStok['stok'] + $qty;
        $this->db->update('bahan_baku', ['stok' => $stok, 'harga_beli' => $harga]);

        $result = $this->db->insert('pembelian_detail', $dataInsert);

        if ($result) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'failed'));
        }
    }
}
