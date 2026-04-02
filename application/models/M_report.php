<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_report extends CI_Model {

    // ==========================================
    // AMBIL DATA TABEL (DENGAN NAMA PRODUK & TGL STATUS)
    // ==========================================
    public function get_filtered_report($filter) {
        /**
         * Penambahan kolom sent_at, completed_at, dan canceled_at 
         * agar bisa ditampilkan secara dinamis di tabel laporan.
         */
        $this->db->select("
            orders.id,
            orders.order_code,
            orders.status,
            orders.total_price,
            orders.order_date,
            orders.sent_at,      
            orders.completed_at, 
            orders.canceled_at,
            customers.name AS customer_name,
            sales.name AS sales_name,
            GROUP_CONCAT(DISTINCT products.name SEPARATOR ', ') as product_names
        ");
        $this->db->from("orders");
        $this->db->join("customers", "customers.id = orders.customer_id", "left");
        $this->db->join("sales", "sales.id = orders.sales_id", "left");
        
        // Join ke detail untuk mendapatkan produk
        $this->db->join("order_items", "order_items.order_id = orders.id", "left");
        $this->db->join("products", "products.id = order_items.product_id", "left");

        // Terapkan Filter
        $this->_apply_filters($filter);

        // Group by ID Order agar GROUP_CONCAT bekerja
        $this->db->group_by("orders.id");
        $this->db->order_by("orders.id", "DESC");

        return $this->db->get()->result();
    }

    // ==========================================
    // AMBIL DATA CHART (DINAMIS SESUAI FILTER)
    // ==========================================
    public function get_chart_data($filter) {
        // Menggunakan LOWER() untuk memastikan konsistensi status di JavaScript
        $this->db->select("LOWER(orders.status) as status, COUNT(*) AS total_order");
        $this->db->from("orders");

        // Terapkan Filter yang sama untuk Grafik
        $this->_apply_filters($filter);

        $this->db->group_by("orders.status");
        return $this->db->get()->result_array();
    }

    // ==========================================
    // FUNGSI PRIVATE UNTUK MENGHINDARI REDUNDANSI KODE
    // ==========================================
    private function _apply_filters($filter) {
        // Filter tanggal (format YYYY-MM-DD)
        if (!empty($filter['from'])) {
            $this->db->where("orders.order_date >=", $filter['from'] . " 00:00:00");
        }
        if (!empty($filter['to'])) {
            $this->db->where("orders.order_date <=", $filter['to'] . " 23:59:59");
        }

        // Filter sales
        if (!empty($filter['sales_id'])) {
            $this->db->where("orders.sales_id", $filter['sales_id']);
        }

        // Filter status
        if (!empty($filter['status'])) {
            $this->db->where("orders.status", $filter['status']);
        }
    }
    
    // Alias untuk memanggil fungsi yang sama
    public function get_report_data($filter) {
        return $this->get_filtered_report($filter);
    }
}