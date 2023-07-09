<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Penjualan extends BaseController
{

    public function customerList()
    {
        cekSession();
        $cekSession = cekSession();

        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;
        $order = $this->input->post('orderby');
        $data['order'] = $order;
        $data['pelanggan'] = $this->Penjualan_model->listPelanggan($searchText, $order);

        $data['me'] = $cekSession;
        $data['title'] = 'Data Pelanggan';
        $data['active'] = 'JL';

        $this->global['page_title'] = 'Data Pelanggan - BENGKEL';
        $this->loadViewsAdmin('pembelian/dataPelanggan', $this->global, $data, NULL, TRUE);
    }

    function addCustomer()
    {
        $getKode = $this->db->query("SELECT kode FROM pelanggan ORDER BY kode DESC LIMIT 0, 1 ")->row_array();
        pre($getKode);
        if ($getKode) {
            $kode = sprintf('%05d', $getKode['kode'] + 1);
        } else {
            $kode = '00001';
        }

        $nama = $this->input->post('nama');
        $no_telp = $this->input->post('no_telp');
        $jns_kel = $this->input->post('jns_kel');
        $alamat = $this->input->post('alamat');
        $email = $this->input->post('email');
        $data = [
            'kode' => $kode,
            'nama' => ucwords($nama),
            'no_telp' => $no_telp,
            'jenis_kel' => ucfirst($jns_kel),
            'alamat' => ucfirst($alamat),
            'email'     => $email,
            'password'  => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'tgl_dibuat' => date('Y-m-d')
        ];
        $result = $this->db->insert('pelanggan', $data);
        if ($result) {
            redirect('custList');
        } else {
            die('Proses Gagal. Hubungi Administrator');
        }
    }

    function updateCustomer()
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
        $result = $this->db->update('pelanggan', $data);
        if ($result) {
            redirect('custList');
        } else {
            die('Proses Gagal. Hubungi Administrator');
        }
    }

    function deletePelanggan()
    {
        $kode = $this->input->post('id_del');
        $this->db->where('kode', $kode);
        $this->db->delete('pelanggan');
        redirect('custList');
    }

    public function listPenjualan()
    {
        cekSession();
        $cekSession = cekSession();
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;
        $order = $this->input->post('orderby');
        $data['order'] = $order;
        $data['dataPenjualan'] = $this->Penjualan_model->listPenjualan($searchText, $order);

        $data['me'] = $cekSession;
        $data['title'] = 'Data Penjualan';
        $data['active'] = 'JL';

        $this->global['page_title'] = 'Data Penjualan - BENGKEL';
        $this->loadViewsAdmin('admin/dataPenjualan', $this->global, $data, NULL, TRUE);
    }

    function addSi()
    {
        cekSession();
        $cekSession = cekSession();

        $data['psnInfo'] = $this->db->select('ps.kode, c.nama AS pelanggan')->distinct()
            ->from('pesanan ps')
            ->join('pelanggan c', 'c.kode = ps.kd_plg', 'left')
            ->where(['ps.flag' => 'B', 'ps.aktif' => 1])
            ->get()->result_array();
        // pre($this->db->last_query());
        $data['barangInfo'] = $this->db->get('bahan_baku')->result_array();
        $data['plgInfo'] = $this->db->get('pelanggan')->result_array();
        $data['me'] = $cekSession;
        $data['title'] = 'Data Penjualan';
        $data['active'] = 'JL';

        $this->global['page_title'] = 'Data Penjualan - BENGKEL';
        $this->loadViewsAdmin('admin/addSi', $this->global, $data, NULL, TRUE);
    }

    function editSi($nomor)
    {
        cekSession();
        $cekSession = cekSession();

        $data['psnInfo'] = $this->db->select('ps.kode, c.nama AS pelanggan')->distinct()
            ->from('pesanan ps')
            ->join('pelanggan c', 'c.kode = ps.kd_plg', 'left')
            ->where(['ps.flag' => 'B', 'ps.aktif' => 1])
            ->get()->result_array();
        // pre($data['psnInfo']);
        $data['hdInfo'] = $this->db->get_where('penjualan', ['nomor' => $nomor])->row_array();
        $data['dtInfo'] = $this->db->get_where('penjualan_detail', ['nomor' => $nomor])->result_array();
        $data['barangInfo'] = $this->db->get('bahan_baku')->result_array();
        $data['plgInfo'] = $this->db->get('pelanggan')->result_array();
        $data['me'] = $cekSession;
        $data['title'] = 'Data Penjualan';
        $data['active'] = 'JL';

        $this->global['page_title'] = 'Data Penjualan - BENGKEL';
        $this->loadViewsAdmin('admin/editSi', $this->global, $data, NULL, TRUE);
    }

    function addDataPenjualanDetail()
    {
        $post = $this->input->post(NULL, TRUE);

        $nomor = $post['nomor'];
        $nomor = preg_replace('/[\W_]+/', '', $nomor);

        $cqry = 'SELECT nourut FROM penjualan_detail WHERE nomor = "' . $nomor . '" order by nourut DESC';
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

        $getPK = $this->Transaksi_model->getIdTr($nomor, 'JL');

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
        $stok = $getStok['stok'] - $qty;
        $this->db->update('bahan_baku', ['stok' => $stok, 'harga_jual' => $harga]);

        $result = $this->db->insert('penjualan_detail', $dataInsert);

        if ($result) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'failed'));
        }
    }
}
