<?php


namespace application\models;


class BoughtProductAttribute extends ActiveRecordEntity
{
    public $id;
    public $product_id;
    public $attribute_id;
    public $order_id;
    public function save()
    {
        if ($this->id) {
            if ($this->product_id) $this->db->connection->query("UPDATE users SET product_id = {$this->product_id} WHERE id = {$this->id}");
            if ($this->attribute_id) $this->db->connection->query("UPDATE users SET attribute_id = {$this->attribute_id} WHERE id = {$this->id}");
            if ($this->order_id) $this->db->connection->query("UPDATE users SET order_id = {$this->order_id} WHERE id = {$this->id}");
        }

        else {
            return $this->db->connection->query("INSERT INTO bought_products_attributes(product_id, attribute_id, order_id) VALUES({$this->product_id}, {$this->attribute_id}, {$this->order_id})");
        }
    }

    public function getTableName()
    {
        return 'bought_products_attributes';
    }
}