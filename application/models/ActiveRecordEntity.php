<?php


namespace application\models;

use application\components\Db;

class ActiveRecordEntity
{
    /** @var \PDO */
    protected $db;

    public function __construct()
    {
        $this->db = new Db;
    }

//    public function getById($id)
//    {
//        return $this->db->connection->query("SELECT * FROM " . $this->getTableName() . " WHERE id = $id")->fetchAll();
//    }

    public function getAll()
    {
        $items = array();
        foreach ($this->db->connection->query("SELECT * FROM " . $this->getTableName())->fetchAll() as $item) {
            $itemObject = new self();
            foreach ($item as $key => $value) {
                $itemObject->$key = $value;
            }

            $items[] = $itemObject;
        }

        return $items;
    }
}