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
