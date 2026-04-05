<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memuat model produk
        $this->load->model('M_Product');
    }

    public function index() {
        $data['title'] = 'Katalog Produk - Bayur Farma';
        
        // Mengambil data produk dari database
        $data['produk'] = $this->M_Product->get_all_produk();

        // Load View (Sesuaikan dengan nama file header/footer Anda)
        $this->load->view('user/template/topbar', $data);
        $this->load->view('user/dashboard', $data);
        $this->load->view('layout/footer');
    }
}