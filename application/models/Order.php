<?php


namespace application\models;


class Order extends ActiveRecordEntity
{
    public $id;
    public $productId;
    public $price;
    public $orderId;
    public $quantity;

    public function save()
    {
        if (!$this->id) {
            $this->db->connection->query("INSERT INTO orders(product_id, order_id, quantity, price) VALUES({$this->productId}, {$this->orderId}, {$this->quantity}, {$this->price})");
            return "INSERT INTO orders(product_id, order_id, quantity, price) VALUES({$this->productId}, {$this->orderId}, {$this->quantity}, {$this->price})";
        }
    }

    public function getTableName()
    {
        return 'orders';
    }
}