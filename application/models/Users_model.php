<?php
class Users_model extends CI_Model {

    protected $table = 'users';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_users() {
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function get_user_by_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function get_user($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function create_user($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update_user($user_id, $data) {
        $this->db->where('id', $user_id);
        return $this->db->update($this->table, $data);
    }

    public function delete_user($user_id) {
        $this->db->where('id', $user_id);
        return $this->db->delete($this->table);
    }
}