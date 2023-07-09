<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Laporan extends BaseController
{

    public function lp_stok()
    {
        cekSession();
        $cekSession = cekSession();

        $data['me'] = $cekSession;
        $data['title'] = 'Laporan Stok';
        $data['active'] = 'Laporan';

        $data['bahan_baku'] = $this->db->get('bahan_baku')->result_array();

        $this->global['page_title'] = 'Laporan Stok - BENGKEL LAS';
        $this->loadViewsAdmin('laporan/stokReport', $this->global, $data, NULL, TRUE);
    }

    function viewLstok()
    {
        $kode_bahanbaku = $this->input->post('bahan_baku');
        $stok = $this->input->post('stok');

        $this->db->select('*');
        $this->db->from('bahan_baku');

        if ($stok == '1') {
            $this->db->where('stok >', 0);
        } else {
            $this->db->where('stok <=', 0);
        }

        if ($kode_bahanbaku) {
            $this->db->where('kode', $kode_bahanbaku);
        }
        $dataLap = $this->db->get()->result_array();

        $data['dataLap'] = $dataLap;
        $data['me'] = cekSession();;

        $this->load->view('laporan/lap_stok', $data);
    }

    public function lp_transaksi()
    {
        cekSession();
        $cekSession = cekSession();

        $data['me'] = $cekSession;
        $data['title'] = 'Laporan Transaksi';
        $data['active'] = 'Laporan';

        $data['bahan_baku'] = $this->db->get('bahan_baku')->result_array();
        $data['pelanggan'] = $this->db->get('pelanggan')->result_array();

        $this->global['page_title'] = 'Laporan Transaksi - BENGKEL LAS';
        $this->loadViewsAdmin('laporan/transaksiReport', $this->global, $data, NULL, TRUE);
    }

    function viewLtrans()
    {
        $pelanggan = $this->input->post('pelanggan');
        $tgl = $this->input->post('tgl');
        $tgl1 = $this->input->post('tgl1');
        $kode_ps = $this->input->post('kode_ps');
        $bayar = $this->input->post('bayar');
        $status_ps = $this->input->post('status_ps');
        $batal = $this->input->post('batal');

        $this->db->distinct();
        $this->db->select('ps.*, IFNULL(jbb.nama, "") AS bahan_baku, plg.nama AS pelanggan, jdt.qty AS qtyd , jdt.harga AS hargad');
        $this->db->from('pesanan ps');
        // $this->db->join('pembelian_detail AS bdt', 'bdt.kd_pesan = ps.kode', 'left');
        $this->db->join('penjualan_detail AS jdt', 'jdt.kd_pesan = ps.kode', 'left');
        // $this->db->join('bahan_baku AS bbb', 'bbb.kode = bdt.kd_bahan_baku', 'left');
        $this->db->join('bahan_baku AS jbb', 'jbb.kode = jdt.kd_bahan_baku', 'left');
        $this->db->join('pelanggan AS plg', 'plg.kode = ps.kd_plg', 'left');
        $this->db->where('ps.tanggal BETWEEN   "' . $tgl . '" AND "' . $tgl1 . '" ');

        if ($pelanggan) {
            $this->db->where('plg.kode', $pelanggan);
        }
        if ($bayar == 'Y') {
            $this->db->where('ps.bayar', $bayar);
        }
        if ($kode_ps) {
            $this->db->where('ps.kode', $kode_ps);
        }
        if ($status_ps != 'S' && $status_ps != '') {
            $this->db->where('ps.status', $status_ps);
        }
        if ($status_ps == 'S') {
            $this->db->where('ps.status', 'A');
        }
        if ($batal == 'Y') {
            echo $batal;
            $this->db->where('ps.aktif', '0');
        }
        $dataLap = $this->db->get()->result_array();
        // pre($this->db->last_query());
        $data['dataLap'] = $dataLap;
        $data['me'] = cekSession();

        $data['tanggal'] = $tgl . '/' . $tgl1;

        $this->load->view('laporan/lap_transaksi', $data);
    }
}
