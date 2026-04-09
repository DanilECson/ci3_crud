<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function getUserByEmail($email){
        return $this->db->where('email', $email)->get('users')->row_array();
    }

    public function getUserById($id){
        return $this->db->where('id', $id)->get('users')->row_array();
    }

    public function createUser($data){
        return $this->db->insert('users', $data);
    }

    public function verifyPassword($password, $hash){
        if (password_verify($password, $hash)) {
            return true;
        }

        return $password === $hash;
    }

    public function updateUser($id, $data){
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)->update('users', $data);
    }
}
