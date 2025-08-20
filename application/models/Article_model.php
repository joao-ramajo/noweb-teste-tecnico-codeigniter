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

    public function all(array $condition)
    {
        // return $this->db->get(self::TABLE)->result();
        $this->db->select('*');
        $this->db->from('articles');
        $this->db->order_by('created_at', 'DESC'); // opcional
        $this->db->limit($condition['perPage'], $condition['offset']);

        $query = $this->db->get();
        $paginate = $query->result();

        $total_pages = $total = $this->db->count_all_results('articles');

        return [
            'total_pages' => $total_pages,
            'data' => $paginate
        ];
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
