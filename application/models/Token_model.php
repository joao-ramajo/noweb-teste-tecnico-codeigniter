<?php

use app\helpers\ValuesObjects\Email;
use app\helpers\ValuesObjects\Token;

defined('BASEPATH') OR exit('No direct script access allowed');

class Token_model extends CI_Model
{
    const TABLE = 'access_tokens';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function all()
    {
        return $this->db->get(self::TABLE)->result();
    }

    public function find($id)
    {
        return $this->db->get_where(self::TABLE, ['id' => $id])->row();
    }

    public function findByUserEmail(Email $email)
    {
        $this->db->select('access_tokens.user_id, access_tokens.token, access_tokens.expiration');
        $this->db->from('users');
        $this->db->join('access_tokens', 'access_tokens.user_id = users.id');
        $this->db->where('users.email', $email);
        $this->db->where('access_tokens.expiration >=', date('Y-m-d h:i:s'));

        $query = $this->db->get();
        $result = $query->row();

        return $result;
    }

    public function findByToken(Token $token){
        $this->db->select('token');
        $this->db->from('access_tokens');
        $this->db->where('token', $token);
        $this->db->where('expiration >=', date('Y-m-d h:i:s'));

        $query = $this->db->get();
        $result = $query->row();

        return $result;
    }

    public function create(array $data)
    {
        return $this->db->insert(self::TABLE, $data);
    }

    public function update(string $id, array $data)
    {
        return $this->db->where('id', $id)->update(self::TABLE, $data);
    }

    public function delete(string $id)
    {
        return $this->db->delete(self::TABLE, ['id' => $id]);
    }

    public function deleteByToken(Token $token)
    {
        return $this->db->delete(self::TABLE, ['token' => $token]);
    }
}
