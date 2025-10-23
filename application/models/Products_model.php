<?php

class Products_model extends CI_Model {
    protected $table = 'products';
    public function __construct() {
        parent::__construct();
    }
    public function get_all_products($limit, $offset, $search = '') {
        $this->db->select($this->table . '.id, '.$this->table.'.name , '.$this->table.'.price, '.$this->table.'.sku, categories.name AS category_name');
        if ($search) {
            $this->db->like($this->table .'.name', $search);
            $this->db->or_like($this->table .'.price', $search);
            $this->db->or_like($this->table .'.sku', $search);
            $this->db->or_like('categories.name', $search);
        }
        
        $this->db->join('categories', 'categories.id = '.$this->table.'.category_id', 'left');
        
        return $this->db->get($this->table, $limit, $offset)->result();
        

    }


    public function count_all($search = '') {
        if ($search) {
            $this->db->like($this->table .'.name', $search);
            $this->db->or_like($this->table .'.price', $search);
            $this->db->or_like($this->table .'.sku', $search);
            $this->db->or_like('categories.name', $search);
        }
        $this->db->join('categories', 'categories.id = '.$this->table.'.category_id', 'left');
        return $this->db->count_all_results($this->table);
    }


    public function get_product($product_id) {
        $query = $this->db->get_where($this->table, array('id' => $product_id));
        return $query->row();
    }
    public function create_product($data) {
        return $this->db->insert($this->table, $data);
    }
    public function update_product($product_id, $data) {
        $this->db->where('id', $product_id);
        return $this->db->update($this->table, $data);
    }
    public function delete_product($product_id) {
        $this->db->where('id', $product_id);
        return $this->db->delete($this->table);
    }
}