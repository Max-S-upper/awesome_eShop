<?php


namespace application\models;

class Brand extends ActiveRecordEntity
{
    public function getTitle($id)
    {
        return $this->db->connection->query("SELECT title FROM brands WHERE id = $id")->fetchColumn();
    }

    public function getTableName()
    {
        return 'brands';
    }
}