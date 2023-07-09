<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_model extends CI_Model
{
    function getIdTr($nomor, $tbl)
    {
        if ($tbl == 'BL') {
            $table = 'pembelian';
        } else if ($tbl == 'JL') {
            $table = 'penjualan';
        }
        $query = "SELECT id FROM " . $table . " WHERE nomor = '" . $nomor . "'";
        $result = $this->db->query($query)->row_array();
        return $result['id'];
    }
    function listPesanan($searchText = '', $orderText = '')
    {
        $this->db->distinct();
        $this->db->select('ps.*, k.nama AS nama_jasa, c.nama AS pelanggan, b.id AS idtr');
        $this->db->from('pesanan ps');
        $this->db->join('kategori AS k', 'k.id=ps.kategori_id', 'left');
        $this->db->join('pelanggan AS c', 'c.kode=ps.kd_plg', 'left');
        $this->db->join('pembayaran AS b', 'b.kode_pesan=ps.kode', 'left');
        $this->db->where('aktif', 1);
        if ($searchText) {
            $this->db->like('ps.kode', $searchText)->or_like('k.nama', $searchText);
        }
        if ($orderText == 'kode') {
            $this->db->order_by('ps.kode', 'ASC');
        } else if ($orderText == 'barang') {
            $this->db->order_by('k.nama', 'ASC');
        } else {
            $this->db->order_by('ps.kode', 'DESC');
        }
        return $this->db->get()->result_array();
    }

    function listTransaksi($kode = '', $searchText = '', $orderText = '')
    {
        $this->db->distinct();
        $this->db->select('tr.*, ps.bayar');
        $this->db->from('pembayaran tr');
        $this->db->join('pesanan AS ps', 'ps.kode=tr.kode_pesan', 'left');
        $this->db->join('pelanggan AS plg', 'plg.kode=ps.kd_plg', 'left');
        if ($kode) {
            $this->db->where('ps.kd_plg', $kode);
        }
        if ($searchText) {
            $this->db->like('nama_barang', $searchText)->or_like('plg.nama', $searchText);
        }
        $this->db->order_by('tr.id', 'DESC');
        return $this->db->get()->result_array();
    }

    function getTrInfo($kode)
    {
        $query = "SELECT * FROM `transaksi` WHERE kode = '" . $kode . "' ";
        $data = $this->db->query($query);
        $result = $data->row_array();
        return $result;
    }

    function dataPesananSaya($kode)
    {
        $this->db->select('ps.*, k.nama AS kategori');
        $this->db->from('pesanan ps');
        $this->db->join('pelanggan AS plg', 'plg.kode=ps.kd_plg');
        $this->db->join('kategori AS k', 'k.id=ps.kategori_id');
        $this->db->where('ps.kd_plg', $kode);
        $res = $this->db->get()->result_array();
        return $res;
    }
}
