<?php

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

    public function findByUserEmail($email)
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

    public function create($data)
    {
        return $this->db->insert(self::TABLE, $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update(self::TABLE, $data);
    }

    public function delete($id)
    {
        return $this->db->delete(self::TABLE, ['id' => $id]);
    }
}
