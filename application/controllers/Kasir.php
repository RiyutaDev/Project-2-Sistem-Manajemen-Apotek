<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kasir extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kasir_model');
        $this->load->library('session');

        if(!$this->session->userdata('logged_in')){
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['title'] = 'Kasir';
        $data['produk'] = $this->Kasir_model->getProduk();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('kasir/index', $data);
        $this->load->view('templates/footer');
    }

    public function simpan()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $produk = $data['produk'];
        $total  = $data['total'];

        // insert pesanan
        $this->db->insert('pesanan', [
            'user_id' => $this->session->userdata('id_user'),
            'status' => 'selesai',
            'total_harga' => $total
        ]);

        $id_pesanan = $this->db->insert_id();

        foreach($produk as $p){

            // detail
            $this->db->insert('detail_pesanan', [
                'pesanan_id' => $id_pesanan,
                'produk_id'  => $p['id'],
                'jumlah'     => $p['qty'],
                'harga'      => $p['harga'],
                'subtotal'   => $p['subtotal']
            ]);

            // update stok
            $this->db->set('stok', 'stok-'.$p['qty'], FALSE)
                     ->where('id_produk', $p['id'])
                     ->update('produk');

            // log stok
            $this->db->insert('stok_log', [
                'produk_id' => $p['id'],
                'tipe' => 'keluar',
                'jumlah' => $p['qty'],
                'keterangan' => 'Transaksi kasir'
            ]);
        }

        echo json_encode(['status'=>'success']);
    }
}