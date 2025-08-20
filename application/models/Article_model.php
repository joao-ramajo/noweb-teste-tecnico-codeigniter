<?php

use app\helpers\DTOs\ArticleDTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends CI_Model
{
    const TABLE = 'articles';

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

    public function findByTitle(string $title)
    {
        return $this->db->get_where(self::TABLE, ['title' => $title])->row();
    }

    public function create(ArticleDTO $articleDTO)
    {
        $data = $articleDTO->toArray();

        $this->db->insert(self::TABLE, $data);

        $id = $this->db->insert_id(); // pega o ID gerado

        return $this->find($id); // retorna o registro completo
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
