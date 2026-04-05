<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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