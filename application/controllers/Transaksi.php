<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Transaksi extends BaseController
{

    public function listPesanan()
    {
        cekSession();
        $cekSession = cekSession();

        $roleMenu = $cekSession['role_id'] == 2 ? 'D' : '';

        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;
        $order = $this->input->post('orderby');
        $data['order'] = $order;
        $data['dataPesanan'] = $this->Transaksi_model->listPesanan($searchText, $order);

        $data['me'] = $cekSession;
        $data['title'] = 'Data Pesanan';
        $data['active'] = 'Pesanan';

        $this->global['page_title'] = 'Data Pesanan - BENGKEL';
        $this->loadViewsAdmin('admin/dataPesanan', $this->global, $data, NULL, TRUE, $roleMenu);
    }

    function getNomorHd()
    {
        $post = $this->input->post(NULL, TRUE);

        $table = $post['table'];
        $nomor = $post['nomor'];
        $tanggal = $post['tanggal'];
        $suplier = isset($post['suplier']) == '' ? '' : $post['suplier'];
        $pelanggan = isset($post['pelanggan']) == '' ? '' : $post['pelanggan'];
        // pre($pelanggan);
        $keterangan = $post['keterangan'];

        if ($table == 'BL') {
            $tbl = 'pembelian';
        } else if ($table == 'JL') {
            $tbl = 'penjualan';
        }

        if ($nomor == '') {
            $getLastNo = $this->db->query('SELECT nomor FROM ' . $tbl . ' ORDER BY id DESC')->row_array();
            // pre($getLastNo);
            if ($getLastNo) {
                $kode = substr($getLastNo['nomor'], -4);
                $kode = $kode + 1;
                // pre($kode);
                $result = $table . "-" . date('Y') . "/" . date('m') . "-" . sprintf('%04d', $kode);
            } else {
                $result = $table . "-" . date('Y') . "/" . date('m') . "-0001";
            }
            $nomor = preg_replace('/[\W_]+/', '', $result);
            if ($table == 'BL') {
                $dataHD = ['nomor' => $nomor, 'tanggal' => $tanggal, 'kd_spl' => $suplier, 'keterangan' => $keterangan, 'jumlah' => 0, 'harga' => 0];
            } else if ($table == 'JL') {
                $dataHD = ['nomor' => $nomor, 'tanggal' => $tanggal, 'kd_plg' => $pelanggan, 'keterangan' => $keterangan, 'jumlah' => 0, 'harga' => 0];
            }

            $this->db->insert($tbl, $dataHD);
        } else {
            $result = '';
        }

        echo json_encode($result);
    }

    function checkTransactionDetail()
    {
        $nomor = $this->input->post('nomor');
        $table = $this->input->post('table');

        $result = $this->db->get_where($table, ['nomor' => $nomor])->num_rows();
        // pre($this->db->last_query());
        echo json_encode($result);
    }

    function checkPaymentDetail()
    {
        $nomor = $this->input->post('nomor');
        $table = $this->input->post('table');

        $result = $this->db->get_where($table, ['id' => $nomor])->row_array();
        // pre($this->db->last_query());
        echo json_encode($result);
    }

    function getDataDetail()
    {
        $table = $this->input->post('table');
        $nomor = $this->input->post('nomor');
        $nomor = preg_replace('/[\W_]+/', '', $nomor);
        $kode_psn = $this->input->post('kode_psn');

        $getData = $this->db->select('p.*, b.nama AS bahan_baku')->distinct()
            ->from($table . ' p')
            ->join('bahan_baku AS b', 'b.kode=p.kd_bahan_baku')
            ->where(['nomor' => $nomor])
            ->get()->result_array();
        // pre($this->db->last_query());
        echo json_encode($getData);
    }

    function getDataDetailForSi()
    {
        $kode_psn = $this->input->post('kode_psn');

        $getData = $this->db->select('p.*, b.nama AS bahan_baku, b.kode AS kodebb, b.harga_jual')->distinct()
            ->from('pembelian_detail p')
            ->join('bahan_baku AS b', 'b.kode=p.kd_bahan_baku')
            ->where(['p.kd_pesan' => $kode_psn])
            ->get()->result_array();
        // pre($this->db->last_query());
        echo json_encode($getData);
    }

    function deleteTrList()
    {
        $nomor = $this->input->post('nomor');
        $table = $this->input->post('table');

        $this->db->where('nomor', $nomor);
        $res = $this->db->delete($table);
        echo json_encode($res);
    }

    function updateDetail()
    {
        $nomor = $this->input->post('nomor');
        $nomor = preg_replace('/[\W_]+/', '', $nomor);
        $nourut = $this->input->post('nourut');
        $qty = $this->input->post('qty');
        $qty_old = $this->input->post('qty_old');
        $harga = $this->input->post('harga');
        $table = $this->input->post('table');
        $bahan_baku = $this->input->post('bahan_baku');

        $this->db->where(['nomor' => $nomor, 'nourut' => $nourut]);
        $res = $this->db->update($table, ['qty' => $qty, 'harga' => $harga]);
        if ($table == 'pembelian_detail') {
            $getStok = $this->db->get_where('bahan_baku', ['nama' => $bahan_baku])->row_array();
            $this->db->where('kode', $getStok['kode']);
            $stok = ($getStok['stok'] - $qty_old) + $qty;
            $this->db->update('bahan_baku', ['stok' => $stok, 'harga_beli' => $harga]);
        } else if ($table == 'penjualan_detail') {
            $getStok = $this->db->get_where('bahan_baku', ['nama' => $bahan_baku])->row_array();
            $this->db->where('kode', $getStok['kode']);
            $stok = ($getStok['stok'] + $qty_old) - $qty;
            $this->db->update('bahan_baku', ['stok' => $stok, 'harga_jual' => $harga]);
        }
        echo json_encode($res);
    }

    function deleteDetail()
    {
        $rowCountDT = $this->input->post('rowCountDT');
        $nomor = $this->input->post('nomor');
        $nourut = $this->input->post('nourut');
        $qty = $this->input->post('qty');
        $table = $this->input->post('table');
        $bahan_baku = $this->input->post('bahan_baku');

        $getStok = $this->db->get_where('bahan_baku', ['nama' => $bahan_baku])->row_array();
        $this->db->where('kode', $getStok['kode']);
        $stok = $getStok['stok'] - $qty;
        $this->db->update('bahan_baku', ['stok' => $stok]);

        if ($rowCountDT == 1) {
            $dataDt = $this->db->select('kd_pesan')->get_where($table, ['nomor' => $nomor])->row_array();
            $kd_pesan = $dataDt['kd_pesan'];
            $whereKodePesan = ['kode' => $kd_pesan];
            $psn = ['flag' => ''];
            $this->db->update('pesanan', $psn, $whereKodePesan);
        }

        $this->db->where(['nomor' => $nomor, 'nourut' => $nourut]);
        $res = $this->db->delete($table);

        echo json_encode($res);
    }

    function simpanData()
    {
        $nomor = $this->input->post('nomor');
        $nomor = preg_replace('/[\W_]+/', '', $nomor);
        $keterangan = $this->input->post('keterangan');
        $kode = $this->input->post('kode');

        if ($kode == 'BL') {
            $tableHd = 'pembelian';
            $tableDt = 'pembelian_detail';
            $flag = 'B';
            $status = 'P';
        } else if ($kode == 'JL') {
            $tableHd = 'penjualan';
            $tableDt = 'penjualan_detail';
            $flag = 'J';
            $status = 'K';
        }

        $dataDt = $this->db->select('SUM(qty) AS qty, SUM(qty*harga) AS jumlah, kd_pesan')
                ->group_by('kd_pesan')
                ->get_where($tableDt, ['nomor' => $nomor])
                ->row_array();
        
        $jumlah = $dataDt['qty'];
        $harga = $dataDt['jumlah'];
        $kd_pesan = $dataDt['kd_pesan'];

        $where = ['nomor' => $nomor];
        $infoHD = ['jumlah' => $jumlah, 'harga' => $harga, 'keterangan' => $keterangan];
        $result = $this->db->update($tableHd, $infoHD, $where);

        $whereKodePesan = ['kode' => $kd_pesan];
        $psn = ['flag' => $flag, 'harga' => $harga];
        $this->db->update('pesanan', $psn, $whereKodePesan);
        // pre($this->db->last_query());
        echo json_encode($result);
    }

    function updateStatusBayar()
    {
        $kodePs = $this->input->post('kode');

        $whereKodePesan = ['kode' => $kodePs];
        $psn = ['bayar' => 'Y'];
        $result = $this->db->update('pesanan', $psn, $whereKodePesan);
        echo json_encode($result);
    }

    function updateStatusPesanan()
    {
        $kodePs = $this->input->post('kode');
        $status = $this->input->post('status');

        $whereKodePesan = ['kode' => $kodePs];
        $psn = ['status' => $status];
        $result = $this->db->update('pesanan', $psn, $whereKodePesan);
        echo json_encode($result);
    }

    function updateFlagPesanan()
    {
        $kodePs = $this->input->post('kode');
        $flag = $this->input->post('flag');

        $whereKodePesan = ['kode' => $kodePs];
        $psn = ['flag' => $flag];
        $result = $this->db->update('pesanan', $psn, $whereKodePesan);
        echo json_encode($result);
    }
}
