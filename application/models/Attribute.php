<?php


namespace application\models;

class Attribute extends ActiveRecordEntity
{
    public function getTitle($id)
    {
        $attribute = new Attribute();
        $attribute->title = $this->db->connection->query("SELECT title FROM attributes WHERE id = $id")->fetchColumn();
        return $attribute;
    }

    public function getTableName()
    {
        return 'attributes';
    }
}