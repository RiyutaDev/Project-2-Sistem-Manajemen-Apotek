<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model('M_sales');

        // Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    // Tampilkan semua data sales
    public function index() {
        $data['title'] = 'Data Sales';
        $data['sales'] = $this->M_sales->get_all();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('sales/index', $data);
        $this->load->view('template/footer');
    }

    // Form tambah sales
    public function create() {
        // Generate kode otomatis (SALE001, SALE002, dst)
        $query = $this->db->query("SELECT MAX(RIGHT(sales_code, 3)) AS max_code FROM sales");
        $result = $query->row();

        if ($result && $result->max_code) {
            $num = (int) $result->max_code + 1;
            $sales_code = 'SALE' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $sales_code = 'SALE001';
        }

        $data['title'] = 'Tambah Sales';
        $data['sales_code'] = $sales_code;

        if ($this->input->post()) {
            $name = $this->input->post('name', true); // Simpan nama ke variabel untuk audit log
            $data_insert = [
                'sales_code' => $sales_code,
                'name'       => $name,
                'phone'      => $this->input->post('phone', true),
                'email'      => $this->input->post('email', true),
                'note'       => $this->input->post('note', true),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->M_sales->insert($data_insert);

            // Audit Log
            $this->db->insert('audit_log', [
                'user_id' => $this->session->userdata('user_id'),
                'action'  => 'create',
                'detail'  => 'Menambahkan sales: ' . $name, // Diperbaiki dari $data['name'] menjadi $name
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            $this->session->set_flashdata('success', 'Data sales berhasil ditambahkan!');
            redirect('sales');
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('sales/add', $data);
        $this->load->view('template/footer');
    }

    // Edit sales
    public function edit($id) {
        $data['title'] = 'Edit Sales';
        $data['sales'] = $this->M_sales->get_by_id($id);

        if (!$data['sales']) {
            $this->session->set_flashdata('error', 'Data sales tidak ditemukan!');
            redirect('sales');
        }

        if ($this->input->post()) {
            $data_update = [
                'name'  => $this->input->post('name', true),
                'phone' => $this->input->post('phone', true),
                'email' => $this->input->post('email', true),
                'note'  => $this->input->post('note', true)
            ];

            $this->M_sales->update($id, $data_update);

            // Audit Log
            $this->db->insert('audit_log', [
                'user_id' => $this->session->userdata('user_id'),
                'action'  => 'update',
                'detail'  => 'Update data sales ID ' . $id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            $this->session->set_flashdata('success', 'Data sales berhasil diperbarui!');
            redirect('sales');
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('sales/edit', $data);
        $this->load->view('template/footer');
    }

    // Hapus sales (DENGAN PENGECEKAN DATA)
    public function delete($id) {
        // 1. Cek apakah sales sudah digunakan di tabel orders
        // Menggunakan fungsi check_usage yang kita tambahkan di M_sales
        $is_used = $this->M_sales->check_usage($id);

        if ($is_used) {
            // Jika digunakan, kirim pesan error
            $this->session->set_flashdata('error', 'Data Sales tidak bisa dihapus karena sudah memiliki riwayat transaksi!');
        } else {
            // Jika tidak digunakan, jalankan proses hapus
            $this->M_sales->delete($id);

            // Audit Log
            $this->db->insert('audit_log', [
                'user_id' => $this->session->userdata('user_id'),
                'action'  => 'delete',
                'detail'  => 'Menghapus sales ID ' . $id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            $this->session->set_flashdata('success', 'Data sales berhasil dihapus!');
        }
        
        redirect('sales');
    }
}