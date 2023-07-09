<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian_model extends CI_Model
{
    function listSupplier($searchText = '', $orderText = '')
    {
        $this->db->distinct();
        $this->db->select('*');
        $this->db->from('supplier');
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

    function listPembelian($searchText = '', $orderText = '')
    {
        $this->db->distinct();
        $this->db->select('p.*, s.nama AS suplier');
        $this->db->from('pembelian p');
        $this->db->join('supplier AS s', 's.kode=p.kd_spl');
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
