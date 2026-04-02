<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_customer extends CI_Model {

    private $table = 'customers';

    public function get_all() {
        $this->db->order_by('id', 'DESC');
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    // --- TAMBAHKAN FUNGSI INI ---
    /**
     * Mengecek apakah customer sudah digunakan di tabel orders
     */
    public function check_usage($id) {
        // Pastikan nama tabel 'orders' sesuai dengan nama tabel transaksi Anda
        $this->db->where('customer_id', $id);
        $query = $this->db->get('orders');
        
        // Mengembalikan TRUE jika ada data, FALSE jika kosong
        return ($query->num_rows() > 0);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}