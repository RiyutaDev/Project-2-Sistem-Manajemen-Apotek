<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_operator extends CI_Model {

    public function get_by_username($username) {
        return $this->db->get_where('operator', ['username' => $username])->row();
    }

    public function update_last_login($operator_id) {
        $this->db->where('operator_id', $operator_id);
        $this->db->update('operator', ['last_login' => date('Y-m-d H:i:s')]);
    }
    public function count_get_all_user() 
    {
        return $this->db->count_all('operator');
    }
}