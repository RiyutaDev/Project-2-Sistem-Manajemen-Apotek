<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // load model
        $this->load->model('Dashboard_model');

        // cek login
        if(!$this->session->userdata('logged_in')){
            redirect('auth/login');
        }

        // cek role (admin saja)
        if($this->session->userdata('role_id') != 1){
            redirect('auth/blocked');
        }
    }

    public function index()
    {
        // ========================
        // DATA DASHBOARD
        // ========================

        $data['title'] = 'Dashboard Admin';

        // statistik utama
        $data['total_produk']      = $this->Dashboard_model->totalProduk();
        $data['total_pelanggan']   = $this->Dashboard_model->totalPelanggan();
        $data['kadaluarsa']        = $this->Dashboard_model->produkKadaluarsa();
        $data['stok_rendah']       = $this->Dashboard_model->stokRendah();

        // penjualan
        $data['penjualan_hari_ini'] = $this->Dashboard_model->penjualanHariIni();

        // grafik
        $data['grafik'] = $this->Dashboard_model->grafikPenjualan();

        // ========================
        // LOAD VIEW
        // ========================

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }

}