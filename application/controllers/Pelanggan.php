<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Pelanggan extends BaseController
{

    public function pesan()
    {
        cekSessionUser();
        $cekSessionUser = cekSessionUser();

        $data['me'] = $cekSessionUser;
        $data['title'] = 'Pesan';
        $data['active'] = 'Pesan';

        $data['kategori'] = $this->db->get('kategori')->result_array();

        $this->global['page_title'] = 'Pesan - BENGKEL';
        $this->loadViews('pelanggan/pesan', $this->global, $data, NULL, TRUE);
    }

    public function pesanan()
    {
        cekSessionUser();
        $cekSessionUser = cekSessionUser();

        $data['me'] = $cekSessionUser;
        $data['title'] = 'Pesanan Saya';
        $data['active'] = 'Pesanan';

        $data['listPesanan'] = $this->Transaksi_model->dataPesananSaya($cekSessionUser['kode']);

        $this->global['page_title'] = 'Pesanan - BENGKEL';
        $this->loadViews('pelanggan/pesananSaya', $this->global, $data, NULL, TRUE);
    }

    function cancelPsn()
    {
        $kode = $this->input->post('cancelKode');

        $this->db->update('pesanan', ['aktif' => 0], ['kode' => $kode]);
        redirect('pesanan_saya');
    }
    function hapusPsn()
    {
        $kode = $this->input->post('hapusKode');

        $this->db->delete('pesanan', ['kode' => $kode]);
        redirect('pesanan_saya');
    }

    function getInfoPesanan()
    {
        $kodePesanan = $this->input->post('kode');

        $CSQL = "SELECT ps.*, bb.nama AS bahanbaku, bb.harga_jual, pd.qty AS qtyp, k.biaya
                    FROM pesanan ps 
                    LEFT JOIN pembelian_detail AS pd ON pd.kd_pesan = ps.kode
                    LEFT JOIN bahan_baku AS bb ON bb.kode = pd.kd_bahan_baku
                    LEFT JOIN kategori AS k ON k.id = ps.kategori_id
                    WHERE ps.kode = '" . $kodePesanan . "' AND ps.flag <> ''
                    ";
        $data = $this->db->query($CSQL)->result_array();
        echo json_encode($data);
    }

    function cekPembayaran()
    {
        $kodePesanan = $this->input->post('kodePsn');
        $checkBayar = $this->db->select('b.*, mb.nama_bank')
            ->from('pembayaran b')
            ->join('metode_bayar AS mb', 'mb.no_rek = b.no_rek')
            ->where('b.kode_pesan', $kodePesanan)->get()->row_array();

        echo json_encode($checkBayar);
    }

    function pembayaran($kodePesanan)
    {
        cekSessionUser();
        $cekSessionUser = cekSessionUser();

        $data['me'] = $cekSessionUser;
        $data['title'] = 'Pembayaran';
        $data['active'] = 'Pesanan';

        $CSQL = "SELECT ps.kode AS kode_pesanan, SUM(pd.qty*bb.harga_jual)+k.biaya AS harga_netto
                    FROM pesanan ps 
                    LEFT JOIN pembelian_detail AS pd ON pd.kd_pesan = ps.kode
                    LEFT JOIN bahan_baku AS bb ON bb.kode = pd.kd_bahan_baku
                    LEFT JOIN kategori AS k ON k.id = ps.kategori_id
                    WHERE ps.kode = '" . $kodePesanan . "' AND ps.flag <> ''
                    ";
        $data['bayar'] = $this->db->query($CSQL)->row_array();

        $this->global['page_title'] = 'Transaksi - BENGKEL';
        $this->loadViews('pelanggan/pembayaran', $this->global, $data, NULL, TRUE);
    }

    function insertBayar()
    {
        $kodeps = $this->input->post('kode');
        $no_rek = $this->input->post('no_rek');
        $harga = $this->input->post('harga');

        $data = [
            'id' => "TR" . rand(100000000, 999999999),
            'kode_pesan' => $kodeps,
            'no_rek' => $no_rek,
            'harga' => $harga,
            'tanggal' => date('Y-m-d')
        ];

        $result = $this->db->insert('pembayaran', $data);
        echo json_encode($result);
    }

    function kirimBuktiBayar($kodePesanan)
    {
        cekSessionUser();
        $cekSessionUser = cekSessionUser();

        $data['me'] = $cekSessionUser;
        $data['title'] = 'Kirim Bukti Pembayaran';
        $data['active'] = '';
        $data['kode_pesanan'] = $kodePesanan;

        $this->global['page_title'] = 'Bukti Pembayaran - BENGKEL';
        $this->loadViews('pelanggan/kirimBuktiPembayaran', $this->global, $data, NULL, TRUE);
    }

    function updateBayar()
    {
        $cekSessionUser = cekSessionUser();
        $me = $cekSessionUser;
        $kodePesanan = $this->input->post('kode');

        $config['upload_path']          = './assets/img/pembayaran/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        $config['max_size']             = 1024;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('buktiBayar')) {
            $error = array('error' => $this->upload->display_errors());
            // print_r($error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            // pre($data);
        }
        $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
        $file_name = $upload_data['file_name'];

        $this->db->update('pembayaran', ['gambar' => $file_name], ['kode_pesan' => $kodePesanan]);
        redirect('pesanan_saya');
    }
    public function transaksi()
    {
        cekSessionUser();
        $cekSessionUser = cekSessionUser();

        $data['me'] = $cekSessionUser;
        $data['title'] = 'Transaksi Saya';
        $data['active'] = 'Transaksi';

        $data['transaksi'] = $this->Transaksi_model->listTransaksi($cekSessionUser['kode']);

        $this->global['page_title'] = 'Transaksi - BENGKEL';
        $this->loadViews('pelanggan/transaksi', $this->global, $data, NULL, TRUE);
    }
}
