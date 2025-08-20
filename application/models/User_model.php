<?php

use app\helpers\DTOs\UserDTO;
use app\helpers\ValuesObjects\Email;
use app\helpers\ValuesObjects\Token;

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

    public function find(string $id)
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

    public function findByToken(Token $token)
    {
        // echo "BUSCANOD USUARIO POR TOKEN: $token";
        $this->db->select('users.id, users.name, users.email');
        $this->db->from('users');
        $this->db->join('access_tokens', 'access_tokens.user_id = users.id');
        $this->db->where('access_tokens.token = ', $token);

        $query = $this->db->get();
        $result = $query->row();

        return $result;
    }

    public function create(array $data)
    {
        return $this->db->insert('users', $data);
    }

    public function updateUser(string $id, array $data)
    {
        return $this->db->where('id', $id)->update('users', $data);
    }

    public function delete(string $id)
    {
        return $this->db->delete('users', ['id' => $id]);
    }
}
