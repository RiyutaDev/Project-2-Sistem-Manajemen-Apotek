<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_sales extends CI_Model {

    private $table = 'sales';

    public function get_all() {
        // Menambahkan pengurutan agar data terbaru muncul di atas (Opsional)
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
        // Disarankan menggunakan pemisah ->where() agar lebih bersih
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Fitur Tambahan: Cek apakah data sales sudah digunakan dalam transaksi
     * Ini untuk mencegah error 1451 (Foreign Key Constraint)
     */
    public function check_usage($id) {
        // Ganti 'orders' dengan nama tabel transaksi Anda jika berbeda
        // Ganti 'sales_id' dengan nama kolom foreign key di tabel tersebut
        $this->db->where('sales_id', $id);
        $query = $this->db->get('orders');
        
        return ($query->num_rows() > 0);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}