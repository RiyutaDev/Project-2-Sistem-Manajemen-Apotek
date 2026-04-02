<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memuat Library, Helper, Model, dan Database
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        // Pastikan nama Model Anda sudah benar (M_product, M_user)
        $this->load->model(['M_product', 'M_user']); 
        $this->load->database();

        // Cek login: Pindahkan ke sini untuk memastikan akses dashboard aman
        if (!$this->session->userdata('logged_in')) {
            // Arahkan ke halaman login jika belum login
            redirect('auth'); 
        }
    }

    /**
     * Fungsi utama untuk menampilkan halaman dashboard.
     */
    public function index() {
        
        // 1. Ambil data user dari session (untuk sapaan, topbar, dll.)
        $data['user'] = [
            'nama'       => $this->session->userdata('fullname'),
            'role'       => $this->session->userdata('role'),
            // Variabel last_login dan image harus disimpan di session saat login
            'last_login' => $this->session->userdata('last_login'), 
            'image'      => $this->session->userdata('image') 
        ];

        // 2. Ambil Jumlah Data untuk Kartu Ringkasan (Card)
        
        // Ambil jumlah data produk
        if (method_exists($this->M_product, 'count_all')) {
            $data['jumlah_barang'] = $this->M_product->count_all();
        } else {
            // Fallback jika method count_all tidak ada
            $data['jumlah_barang'] = $this->db->count_all('products');
        }

        // Ambil jumlah data user
        if (method_exists($this->M_user, 'count_all')) {
            $data['jumlah_user'] = $this->M_user->count_all();
        } else {
            // Fallback jika method count_all tidak ada (Asumsi nama tabel user adalah 'users')
            $data['jumlah_user'] = $this->db->count_all('users'); 
        }

        // // 3. Data untuk Diagram (Chart.js)
        // $data['chart_data'] = [
        //     'Produk' => $data['jumlah_barang'],
        //     'User' => $data['jumlah_user']
        // ];
        
        // 4. Judul Halaman
        $data['title'] = 'Dashboard';

        // 5. Load View Template
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data); // Topbar (dengan user info & logout)
        $this->load->view('dashboard/index', $data); // Konten Dashboard
        $this->load->view('template/footer', $data);
    }
}