<?php


namespace application\models;

class Brand extends ActiveRecordEntity
{
    public $title;

    public function getTitle($id)
    {
        if (!$this->title) {
            $brandTitle = $this->db->connection->query("SELECT title FROM brands WHERE id = $id")->fetchColumn();
            $this->title = $brandTitle;
        }

        return $this->title;
    }

    public function getTableName()
    {
        return 'brands';
    }
}