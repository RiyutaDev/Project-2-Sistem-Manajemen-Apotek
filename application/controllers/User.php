<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct(); 
        
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('M_user'); 
        // 1. WAJIB LOAD MODEL PRODUK DI SINI
        $this->load->model('M_Product'); 
        
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index(){
        // 2. AMBIL DATA PRODUK DARI DATABASE
        $data['produk'] = $this->M_Product->get_all_produk(); 
        $data['title'] = 'Dashboard - Bayur Farma';

        // 3. KIRIM VARIABEL $data KE VIEW
        $this->load->view('user/template/topbar', $data);
        $this->load->view('user/dashboard', $data);
    }

    public function profile() {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->M_user->get_user_by_id($user_id); 
        
        if (!$data['user']) {
            $this->session->set_flashdata('error', 'Data pengguna tidak ditemukan.');
            redirect('user'); // Sesuai nama controller
        }

        $role_id = $data['user']['role_id'];
        $profile_image = 'default.svg';     
        
        // Logika pemilihan gambar profil berdasarkan role_id
        if ($role_id == 1) {
            $profile_image = 'undraw_profile_1.svg';
        } elseif ($role_id == 2) {
            $profile_image = 'undraw_profile_2.svg';
        } elseif ($role_id == 3) {
            $profile_image = 'undraw_profile_3.svg';
        }

        $data['user']['image'] = $profile_image;
        $data['user_session'] = [
            'role' => $this->session->userdata('role'),
            'role_id' => $role_id
        ];

        $data['title'] = 'Profil Saya';

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data['user_session']); 
        $this->load->view('user/profile', $data); 
        $this->load->view('template/footer', $data);
    }
}