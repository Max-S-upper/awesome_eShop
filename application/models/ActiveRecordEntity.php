<?php


namespace application\models;

use core\Db;

class ActiveRecordEntity
{
    /** @var \PDO */
    protected $db;

    public function __construct()
    {
        $this->db = new Db;
    }

    public function getById($ids)
    {
        $query = "SELECT * FROM " . $this->getTableName() . " WHERE id = ";
        $idsQuantity = count($ids);
        for ($i = 0; $i < $idsQuantity; $i++) {
            if (!$i) $query .= "$ids[$i]";
            else $query .= " OR id = $ids[$i]";
        }

        $itemsData = $this->db->connection->query($query)->fetchAll();
        $items = array();
        foreach ($itemsData as $item) {
            $itemObject = new self();
            foreach ($item as $key => $value) {
                $itemObject->$key = $value;
            }

            if (count($itemsData) === 1) return $itemObject;
            $items[] = $itemObject;
        }

        return $items;
    }

    public function getAll()
    {
        $itemsData = $this->db->connection->query("SELECT * FROM " . $this->getTableName())->fetchAll();
        $items = array();
        foreach ($itemsData as $item) {
            $itemObject = new self();
            foreach ($item as $key => $value) {
                $itemObject->$key = $value;
            }

            $items[] = $itemObject;
        }

        return $items;
    }
}