<?php


namespace application\models;

use config\Db;

class ActiveRecordEntity
{
    protected $db;

    public function __construct()
    {
        $this->db = new Db;
    }

    public function getById($id)
    {
        return $this->db->connection->query("SELECT * FROM " . $this->getTableName() . " WHERE id = $id")->fetchAll();
    }

//    public function getAll()
//    {
//        $products = array();
//        foreach ($this->db->query("SELECT * FROM " . $this->getTableName())->fetchAll() as $product) {
//            $productObject = new self();
//            foreach ($product as $key => $value) {
//                $productObject->$key = $value;
//            }
//
//            $products[] = $productObject;
//        }
//
//        return $products;
//    }
}