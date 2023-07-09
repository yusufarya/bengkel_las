<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan_model extends CI_Model
{
    function listPelanggan($searchText = '', $orderText = '')
    {
        $this->db->distinct();
        $this->db->select('*');
        $this->db->from('pelanggan');
        if ($searchText) {
            $this->db->like('nama', $searchText);
        }
        if ($orderText == 'kode') {
            $this->db->order_by('kode', 'ASC');
        } else if ($orderText == 'nama') {
            $this->db->order_by('nama', 'ASC');
        } else {
            $this->db->order_by('kode', 'ASC');
        }
        return $this->db->get()->result_array();
    }

    function listPenjualan($searchText = '', $orderText = '')
    {
        $this->db->distinct();
        $this->db->select('p.*, c.nama AS pelanggan');
        $this->db->from('penjualan p');
        $this->db->join('pelanggan AS c', 'c.kode=p.kd_plg');
        if ($searchText) {
            $this->db->like('p.nomor', $searchText);
        }
        if ($orderText == 'tanggal') {
            $this->db->order_by('p.tanggal', 'DESC');
        } else if ($orderText == 'nomor') {
            $this->db->order_by('p.nomor', 'DESC');
        } else {
            $this->db->order_by('p.nomor', 'DESC');
        }
        return $this->db->get()->result_array();
    }
}
