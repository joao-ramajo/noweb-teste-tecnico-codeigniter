<?php

use app\helpers\DTOs\UserDTO;
use app\helpers\ValuesObjects\Email;

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function all()
    {
        return $this->db->get('users')->result();
    }

    public function find($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function findByEmail(Email $email): ?stdClass
    {
        $user = $this->db->get_where('users', ['email' => $email])->row();

        if(!$user){
            throw new InvalidArgumentException('User not found');
        }

        return $user;
    }

    public function create($data)
    {
        return $this->db->insert('users', $data);
    }

    public function updateUser($id, $data)
    {
        return $this->db->where('id', $id)->update('users', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('users', ['id' => $id]);
    }
}
