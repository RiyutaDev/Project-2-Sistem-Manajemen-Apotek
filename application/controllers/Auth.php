<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memuat library dan helper yang dibutuhkan
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
        // Memuat Model User
        $this->load->model('M_user');
        $this->load->database();
    }

    /**
     * Menampilkan halaman login.
     */
    public function index() {
        // Jika sudah login, alihkan ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        // Tampilkan halaman login
        $data['title'] = 'Login - PT Maju Jaya Elektronik';
        $this->load->view('template/header', $data);
        $this->load->view('auth/login', $data);
        $this->load->view('template/footer');
    }

    /**
     * Proses verifikasi data login.
     */
    public function process() {

        // --- 1. VALIDASI FORM ---
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]'); // Minimal 4 karakter
    
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth');
        }
    
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
    
        // --- 2. AMBIL DATA USER BERDASARKAN USERNAME ---
        $user = $this->M_user->get_by_username($username);
    
        if (!$user) {
            $this->session->set_flashdata('error', 'Username tidak ditemukan.');
            redirect('auth');
        }
    
        // --- 3. VERIFIKASI PASSWORD HASH ---
        if (!password_verify($password, $user->password_hash)) {
            $this->session->set_flashdata('error', 'Password salah.');
            redirect('auth');
        }
    
        // --- 4. DATA PENDUKUNG & UPDATE LAST LOGIN ---
        
        // Ambil role name (misalnya: Admin, Sales, Manager)
        $role = $this->db->select('name')
                        ->where('id', $user->role_id)
                        ->get('roles')
                        ->row('name');
        
        $now = date('Y-m-d H:i:s');
        
        // Update kolom 'last_login' di database menggunakan M_user
        // Asumsi M_user memiliki method update_last_login()
        $this->M_user->update_last_login($user->id, $now);

        // --- 5. LOGIKA PENENTUAN SALES_ID ---
        $current_sales_id = NULL;

        // Jika Role adalah Sales (ID 2), gunakan user_id sebagai sales_id
        if ($user->role_id == 2) {
            $current_sales_id = $user->id; 
        }
        
        // --- 6. SET SESSION (PENTING untuk Topbar & Dashboard) ---
        $this->session->set_userdata([
            'logged_in'  => true,
            'user_id'    => $user->id,
            'username'   => $user->username,
            'email'      => $user->email, // Asumsi ada kolom 'email'
            'fullname'   => $user->fullname, // Digunakan di sapaan dan topbar
            'role_id'    => $user->role_id,
            'role'       => strtolower($role),
            'sales_id'   => $current_sales_id, 
            
            // Variabel untuk Topbar:
            'last_login' => $now, // Waktu login saat ini
            'image'      => $user->image // Asumsi kolom gambar di tabel user adalah 'image'
        ]);
    
        // --- 7. LOG AUDIT  ---
        $this->db->insert('audit_log', [
            'user_id'   => $user->id,
            'action'    => 'login',
            'detail'    => 'User ' . $user->fullname . ' berhasil login.',
            'created_at'=> $now
        ]);
    
        // --- 8. REDIRECT BERDASARKAN ROLE ---
        switch ($user->role_id) {
            case 1: redirect('dashboard'); break; // Admin
            case 2: redirect('orders'); break;    // Sales
            case 3: redirect('report'); break;    // Manager/Role lain
            default: redirect('dashboard');
        }
    }
    
    /**
     * Proses logout (menghancurkan session).
     */
    public function logout() {

        $user_id = $this->session->userdata('user_id');
        $fullname = $this->session->userdata('fullname');

        if ($user_id) {
            // Log audit sebelum sesi dihancurkan
            $this->db->insert('audit_log', [
                'user_id'   => $user_id,
                'action'    => 'logout',
                'detail'    => 'User ' . $fullname . ' logout.',
                'created_at'=> date('Y-m-d H:i:s')
            ]);
        }

        // Hancurkan semua data sesi
        $this->session->sess_destroy();
        
        // Arahkan kembali ke halaman login
        redirect('auth');
    }
}