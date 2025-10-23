<?php

class Categories_model extends CI_Model {
    protected $table = 'categories';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_categories() {
        return $this->db->get($this->table)->result();
    }

    public function get_category($category_id) {
        $query = $this->db->get_where($this->table, array('id' => $category_id));
        return $query->row();
    }

    public function validateProductsInCategory($category_id) {
        $this->db->where('category_id', $category_id);
        $query = $this->db->get('products');
        return $query->num_rows() > 0;
    }

    public function create_category($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update_category($category_id, $data) {
        $this->db->where('id', $category_id);
        return $this->db->update($this->table, $data);
    }

    public function delete_category($category_id) {
        $this->db->where('id', $category_id);
        return $this->db->delete($this->table);
    }
}