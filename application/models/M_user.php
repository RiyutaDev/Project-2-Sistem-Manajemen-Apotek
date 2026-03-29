<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Pastikan database dimuat jika belum dimuat secara autoload
    }
    
    // Nama tabel user di database Anda
    private $table = 'users'; 

    // Ambil user berdasarkan username (case insensitive)
    public function get_by_username($username) {
        return $this->db
            ->where('LOWER(username)', strtolower($username))
            ->get($this->table)
            ->row(); // Mengembalikan objek
    }

    /**
     * PERBAIKAN: Mengambil data user berdasarkan ID untuk halaman profile.
     * Mengubah row() menjadi row_array() agar kompatibel dengan $user['kolom'] di View Profile.
     * * @param int $id
     * @return array|null
     */
    public function get_user_by_id($id) {
        // Method ini diganti namanya agar tidak bentrok atau membingungkan dengan get_by_id() jika Anda menggunakannya.
        // Di Controller User.php, panggil $this->M_user->get_user_by_id($id);
        return $this->db->get_where($this->table, ['id' => $id])->row_array(); 
    }
    
    // Asumsi get_by_id lama Anda digunakan untuk keperluan lain (mengembalikan objek)
    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
    
    // Ambil semua user
    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    // Insert user – password disimpan sebagai password_hash
    public function insert($data) {
        // ... (Kode untuk Insert, Validasi Regex sudah bagus) ...

        if (!empty($data['password'])) {

            // Validasi regex password
            if (!$this->valid_password_regex($data['password'])) {
                return false; // tidak memenuhi syarat
            }

            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']);
        }

        $this->db->insert($this->table, $data);
        return $this->db->insert_id(); // return id baru
    }

    // Update user
    public function update($id, $data) {
        // ... (Kode untuk Update, Validasi Regex sudah bagus) ...

        if (isset($data['password']) && !empty($data['password'])) {

            // Validasi password baru
            if (!$this->valid_password_regex($data['password'])) {
                return false;
            }

            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']);
        } else {
            // Hapus index 'password' dari data jika kosong agar tidak mengganggu update
            unset($data['password']);
            // Hapus 'password_hash' jika tidak ada password baru (agar tidak mengupdate hash menjadi kosong)
            if(isset($data['password_hash'])) {
                unset($data['password_hash']);
            }
        }
        
        // PENTING: Update kolom updated_at jika ada
        if ($this->db->field_exists('updated_at', $this->table)) {
             $data['updated_at'] = date('Y-m-d H:i:s');
        }

        return $this->db->where('id', $id)->update($this->table, $data);
    }

    // Hapus user
    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    // Hitung jumlah user
    public function count_all() {
        return $this->db->count_all($this->table);
    }

    // Validasi password dengan regex (huruf besar, kecil, angka, simbol)
    public function valid_password_regex($password) {
        // Minimal 8 karakter, 1 Huruf Besar, 1 Huruf Kecil, 1 Angka, 1 Simbol
        $pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*\W).{8,}$/"; 
        return preg_match($pattern, $password);
    }

    /**
     * Mengupdate kolom last_login saat user berhasil login.
     * Digunakan di Auth.php.
     * @param int $user_id
     * @param string $datetime_now (Contoh: '2025-12-05 12:30:00')
     * @return bool
     */
    public function update_last_login($user_id, $datetime_now) {
        $data = ['last_login' => $datetime_now];
        $this->db->where('id', $user_id);
        return $this->db->update($this->table, $data); 
    }
}