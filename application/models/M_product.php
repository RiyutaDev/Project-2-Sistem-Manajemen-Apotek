<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_product extends CI_Model {

    private $table = 'products';

    public function get_all() {
        return $this->db->order_by('id', 'DESC')->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function count_all() {
        return $this->db->count_all($this->table);
    }
}
class M_Product extends CI_Model {

    public function get_all_produk() {
        $this->db->select('produk.*, kategori.nama_kategori');
        $this->db->from('produk');
        $this->db->join('kategori', 'produk.kategori_id = kategori.id_kategori', 'left');
        $this->db->order_by('produk.id_produk', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_produk_by_id($id) {
        return $this->db->get_where('produk', ['id_produk' => $id])->row_array();
    }
}
