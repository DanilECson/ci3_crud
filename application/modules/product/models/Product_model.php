<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model{

    public function getProductById($id) {
        return $this->db->where('id', $id)->get('products')->row_array();
    }
    
    public function getAllProducts(){
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function createProduct($data){
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('products', $data);
    }

    public function updateProduct($id, $data){
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)->update('products', $data);
    }

    public function deleteProduct($id){
        return $this->db->where('id', $id)->delete('products');
    }
}
