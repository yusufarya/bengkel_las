<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Pesanan extends BaseController
{

    function submitPesanan()
    {
        $getLasCode = $this->db->query('SELECT MAX(kode) AS KODE FROM pesanan')->row();
        $kode = $getLasCode->KODE;
        if ($kode != '') {
            $kode = substr($kode, -4) + 1;
            $kode = sprintf('%04d', $kode);
            $kodePO = "PO" . date("Ym") . $kode;
        } else {
            $kode = '00001';
            $kode = sprintf('%04d', $kode);
            $kodePO = "PO" . date("Ym") . $kode;
        }

        $user = $this->db->get_where('pelanggan', ['email' => $this->session->userdata('email')])->row_array();
        $kode_me = $user['kode'];
        $kategori = $this->input->post('kategori');
        $tanggal = $this->input->post('tanggal');
        $keterangan = $this->input->post('keterangan');
        $qty = $this->input->post('qty');
        $data = [
            'kode'  => $kodePO,
            'kd_plg' => $kode_me,
            'kategori_id' => ucwords($kategori),
            'tanggal' => $tanggal,
            'keterangan' => ucfirst($keterangan),
            'qty' => $qty,
            'harga' => 0
        ];
        $result = $this->db->insert('pesanan', $data);
        echo json_encode($result);
    }
}
