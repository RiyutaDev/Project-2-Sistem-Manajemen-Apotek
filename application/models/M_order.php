<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_order extends CI_Model {

    // 1. Ambil semua order + Daftar Barang (Optimasi untuk Index)
    public function get_all() {
        return $this->db->select('
                        orders.*, 
                        customers.name AS customer_name, 
                        sales.name AS sales_name,
                        GROUP_CONCAT(CONCAT(products.name, " (", order_items.quantity, ")") SEPARATOR "|") AS items_list
                    ')
                    ->from('orders')
                    ->join('customers', 'customers.id = orders.customer_id', 'left')
                    ->join('sales', 'sales.id = orders.sales_id', 'left')
                    ->join('order_items', 'order_items.order_id = orders.id', 'left')
                    ->join('products', 'products.id = order_items.product_id', 'left')
                    ->group_by('orders.id')
                    ->order_by('orders.order_date', 'DESC') // Urutkan berdasarkan tanggal order terbaru
                    ->get()
                    ->result();
    }

    // 2. Ambil order berdasarkan sales + Daftar Barang
    public function get_by_sales($sales_id) {
        return $this->db->select('
                        orders.*, 
                        customers.name AS customer_name, 
                        sales.name AS sales_name,
                        GROUP_CONCAT(CONCAT(products.name, " (", order_items.quantity, ")") SEPARATOR "|") AS items_list
                    ')
                    ->from('orders')
                    ->join('customers', 'customers.id = orders.customer_id', 'left')
                    ->join('sales', 'sales.id = orders.sales_id', 'left')
                    ->join('order_items', 'order_items.order_id = orders.id', 'left')
                    ->join('products', 'products.id = order_items.product_id', 'left')
                    ->where('orders.sales_id', $sales_id)
                    ->group_by('orders.id')
                    ->order_by('orders.order_date', 'DESC')
                    ->get()
                    ->result();
    }

    public function get_by_id($id) {
        // Disarankan menggunakan join jika ingin mengambil nama customer/sales juga
        return $this->db->where('id', $id)->get('orders')->row();
    }

    public function insert_order($data) {
        $this->db->insert('orders', $data);
        return $this->db->insert_id();
    }

    public function insert_item($data) {
        return $this->db->insert('order_items', $data);
    }

    public function update_order($id, $data) {
        return $this->db->where('id', $id)->update('orders', $data);
    }

    public function delete($id) {
        // Database Transaction memastikan kedua tabel terhapus atau tidak sama sekali
        $this->db->trans_start();
        $this->db->where('order_id', $id)->delete('order_items');
        $this->db->where('id', $id)->delete('orders');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_items($order_id) {
        // Menambahkan alias pada quantity agar lebih jelas (quantity vs stock)
        return $this->db->select('order_items.*, products.name, products.stock')
                        ->from('order_items')
                        ->join('products', 'products.id = order_items.product_id', 'left')
                        ->where('order_items.order_id', $order_id)
                        ->get()
                        ->result();
    }

    // 3. Filter Laporan dengan detail barang yang lebih lengkap
    public function filter_report($start_date = null, $end_date = null, $sales_id = null, $status = null)
    {
        $this->db->select('
                    orders.*, 
                    customers.name AS customer_name, 
                    sales.name AS sales_name,
                    GROUP_CONCAT(CONCAT(products.name, " (", order_items.quantity, ")") SEPARATOR "|") AS items_list
                 ')
                 ->from('orders')
                 ->join('customers', 'customers.id = orders.customer_id', 'left')
                 ->join('sales', 'sales.id = orders.sales_id', 'left')
                 ->join('order_items', 'order_items.order_id = orders.id', 'left')
                 ->join('products', 'products.id = order_items.product_id', 'left');

        if (!empty($start_date))
            $this->db->where('orders.order_date >=', $start_date . " 00:00:00");

        if (!empty($end_date))
            $this->db->where('orders.order_date <=', $end_date . " 23:59:59");

        if (!empty($sales_id))
            $this->db->where('orders.sales_id', $sales_id);

        if (!empty($status))
            $this->db->where('orders.status', $status);

        // Jangan lupa group_by saat menggunakan GROUP_CONCAT agar tidak duplikat
        return $this->db->group_by('orders.id')->order_by('orders.order_date', 'DESC')->get()->result();
    }
}