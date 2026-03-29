<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_audit_log extends CI_Model {

    // MODIFIKASI: Tambahkan parameter $limit dan $offset di akhir
    public function get_logs($start_date = null, $end_date = null, $user = null, $action = null, $q = null, $limit = null, $offset = null)
    {
        $this->db->select('audit_log.*, users.fullname, users.username');
        $this->db->from('audit_log');
        $this->db->join('users', 'users.id = audit_log.user_id', 'left');

        // Apply Filter
        $this->_apply_filter($start_date, $end_date, $user, $action, $q);

        $this->db->order_by('audit_log.created_at', 'DESC');

        // MODIFIKASI: Tambahkan limit untuk pagination
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }

    // TAMBAHAN: Fungsi untuk menghitung total baris (diperlukan Pagination)
    public function count_logs($start_date = null, $end_date = null, $user = null, $action = null, $q = null)
    {
        $this->db->from('audit_log');
        $this->db->join('users', 'users.id = audit_log.user_id', 'left');
        
        $this->_apply_filter($start_date, $end_date, $user, $action, $q);
        
        return $this->db->count_all_results();
    }

    // HELPER: Agar logika filter tidak ditulis dua kali (DRY Principle)
    private function _apply_filter($start, $end, $user, $action, $q)
    {
        if ($start) $this->db->where('DATE(audit_log.created_at) >=', $start);
        if ($end)   $this->db->where('DATE(audit_log.created_at) <=', $end);
        if ($user)  $this->db->where('audit_log.user_id', $user);
        if ($action) $this->db->where('audit_log.action', $action);

        if ($q) {
            $this->db->group_start()
                ->like('users.fullname', $q)
                ->or_like('users.username', $q)
                ->or_like('audit_log.detail', $q)
            ->group_end();
        }
    }

    public function get_users()
    {
        return $this->db->select('id, fullname, username')
                        ->from('users')
                        ->order_by('fullname')
                        ->get()
                        ->result();
    }

    public function get_summary_days($start = null, $end = null, $days = 30)
    {
        if (!$start) $start = date('Y-m-d', strtotime("-$days days"));
        if (!$end)   $end = date('Y-m-d');

        $sql = "
            SELECT 
                DATE(created_at) AS date,
                SUM(CASE WHEN action = 'login' THEN 1 ELSE 0 END) AS login,
                SUM(CASE WHEN action = 'logout' THEN 1 ELSE 0 END) AS logout,
                SUM(CASE WHEN action = 'create' THEN 1 ELSE 0 END) AS create_count,
                SUM(CASE WHEN action = 'update' THEN 1 ELSE 0 END) AS update_count,
                SUM(CASE WHEN action = 'delete' THEN 1 ELSE 0 END) AS delete_count,
                SUM(CASE WHEN action = 'error' THEN 1 ELSE 0 END) AS error_count
            FROM audit_log
            WHERE DATE(created_at) BETWEEN ? AND ?
            GROUP BY DATE(created_at)
            ORDER BY DATE(created_at) ASC
        ";

        return $this->db->query($sql, [$start, $end])->result();
    }

    public function truncate()
    {
        return $this->db->truncate('audit_log');
    }
}